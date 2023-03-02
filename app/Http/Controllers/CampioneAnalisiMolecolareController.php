<?php

namespace App\Http\Controllers;

use App\CampioneAnalisiMolecolare;
use Illuminate\Http\Request;
use App\Progetto;
use App\Campione;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Reparto;
use App\Stanza;
use App\Procedura;
use App\Protocollo;
use App\Materiale;
use App\Prodotto;
use App\PuntoCampionamento;
use App\Categoria;
use App\Rilevatore;
use App\TipoPiastra;
use App\Societa;
use App\Struttura;
use App\StruttRep;
use App\TemporaryImage;
use App\ImmaginiPiastreSwab;
use App\MicroSuPiastra;
use App\MicroPiastra;
use App\MicroAntibiogramma;
use App\AntibioticoAntibiogramma;
use App\ImmagineMicroAntibiogrammaSwab;
use App\Campagna;
use App\MicroAntibiogrammaSwab;
use App\MicroSuPiastraSwab;
use App\AntibioticoAntibiogrammaSwab;
use App\Event\LoggerEvent;
use App\CampioniRilevatori;
use App\CampioniRilevatoriSWAB;
use App\ConversioneStrutturaStrutture;
use App\ConversioneProgetto;
use App\AreaPartizione;

class CampioneAnalisiMolecolareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $ids = Array();
        $campagna = Campagna::find($id);
        $societa = $campagna->societa()->first();
        
        $strutture = $campagna->struttura()->first();
        $areareparto = StruttRep::join('area_partizione','area_partizione.id','=','strutture_reparti_envass.id_associazione')
                        ->where('id_struttura',$campagna->id_struttura)
                        ->where('id_progetto',$campagna->id_progetto)
                        ->select('area_partizione.*')
                        ->groupby('area_partizione.id_reparto')
                        ->get();
        $progetti = Progetto::where('id',$campagna->id_progetto)->get();

        foreach($progetti as $p)
        {
            array_push($ids,$p->id); 
        }

        $rilevatori = Rilevatore::where('id_progetto',null);
        for($i = 0; $i < count($ids); $i++)
        {
            $rilevatori = $rilevatori->orWhere('id_progetto',$ids[$i]);
        }
        $rilevatori = $rilevatori->select('rilevatori.*')->get();

        

        // $stanze = Stanza::all();
        $prodotti = Prodotto::all();
        $materiali = Materiale::where('versione',2)->get();
        $protocolli = Protocollo::all();
        $categorie = Categoria::where('versione',2)->get();
        $puntiCampionamento = PuntoCampionamento::where('versione',2)->get(); //?? dipendono dalla categoria, quindi forse non serve ma compaiono dinamicamente con js in fase di compilazione
        $piastre = TipoPiastra::where('versione',2)->get();
        $code = $this->generateUniqueCode();
        $numeroProgressivo = 0;

        return view('schede.edit_scheda_molecolare',compact('progetti','areareparto','prodotti','materiali','protocolli','puntiCampionamento','categorie','rilevatori','piastre','societa','strutture','numeroProgressivo','code','campagna'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $campione = CampioneAnalisiMolecolare::find($id);

        $ids = Array();
        $cp = Array();
        
        $campagna = Campagna::find($campione->id_campagna);
        $societa = $campagna->societa()->first();
        $areareparto = AreaPartizione::where('id',$campione->id_areareparto)->get();
        $strutture = $campagna->struttura()->first();

        $rilevatori = "";
        $progetti = $campagna->progetto()->first();

        if($progetti != null)
        {
            $rilevatori = Rilevatore::where('id_progetto',null)->orWhere('id_progetto',$progetti->id)->select('rilevatori.*')->get();
            /**Calcolo campioni rilevatori */
            $campione_rilevatore = CampioniRilevatoriSWAB::where('id_campione_analisi_molecolari',$campione->id)->get();
            foreach ($rilevatori as $r)
            {
                $cp[$r->id] = 0;
            }
            foreach ($campione_rilevatore as $value) 
            {
                $cp[$value->id_rilevatore] = 1;
            }
            /**--------------------- */
        }

        // $stanze = Stanza::all();
        $prodotti = Prodotto::all();
        $materiali = Materiale::where('versione',2)->get();
        $protocolli = Protocollo::all();
        $categorie = Categoria::where('versione',2)->get();
        $puntiCampionamento = PuntoCampionamento::where('versione',2)->get(); //?? dipendono dalla categoria, quindi forse non serve ma compaiono dinamicamente con js in fase di compilazione
        $piastre = TipoPiastra::where('versione',2)->get();
        $code = $this->generateUniqueCode();
        $numeroProgressivo = 0;
        
        $occorrenza = count($campione->microantibiogramma->where('NAB','!=',0) ?? 0);
        return view('schede.edit_scheda_molecolare',compact('campione','progetti','areareparto','materiali','prodotti','protocolli','puntiCampionamento','categorie','rilevatori','piastre','societa','strutture','numeroProgressivo','code','occorrenza','campagna','cp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Log::info($request);
        $validator = Validator::make($request->all(), [
            'id_progetto' => 'required',
            'dataCampagna' => 'required',
            'data' => 'required',
            'ora' => 'required',
            'id_struttura' => 'required',
            'id_reparto' => 'required',
            'numStanza' => 'required',
            'tipoCamp' => 'required',
            'id_categoria' => 'sometimes',
            'id_punto_camp' => 'sometimes',
            'id_superficie' => 'sometimes',
            'id_prodotto' => 'sometimes',
            'id_protocollo' => 'sometimes',
            'tdaSanif' => 'sometimes',
            'fase_Camp' => 'sometimes',
            'VCCC' => 'sometimes',
            'flusso' => 'sometimes',
            'operat' => 'sometimes',
            'n_persone' => 'sometimes',
            'PCampAria' => 'sometimes',
            'codDiff' => 'sometimes',
            'numProg' => 'required',
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect("/campionianalisimolecolare/$request->id_campagna/nuovomolecolari")
                            ->withErrors($validator->messages())
                            ->withInput();
        }

        if(!isset($request->id_rilevatore))
        {
            $message = "Inserire almeno un rilevatore del campionamento";
            return response()->json(['error' => $message],403);
        }
        
        $crea_areapartizione = false;
        $campione = new CampioneAnalisiMolecolare;

        $campione->id_campagna = $request->id_campagna;
        $campione->id_progetto = $request->id_progetto;
        $campione->id_struttura = $request->id_struttura;
        $campione->data = $request->data;
        $campione->dataCampagna = $request->dataCampagna;
        $campione->ora = $request->ora;
        /**
         * Ricerca dell'area reparto da assegnare al campione
         */
        $areaReparto = AreaPartizione::where('id_reparto',$request->id_reparto)->where('area_partizione',$request->area_reparto)->first();
        /**
         * Se non esiste l'area partizione significa che l'utente non è mai stato in quell'area e non l'ha creata nella gestione interna 
         * dunque la creo
         */
        if($areaReparto == null)
        {
            $crea_areapartizione = true;
        }
        else
        {
            $campione->id_areareparto = $areaReparto->id;
        }
        
        $campione->numstanze = $request->numStanza;
        $campione->tipoCamp = $request->tipoCamp;
        $campione->id_protocollo = isset($request->id_protocollo) ? $request->id_protocollo : 0;
        $campione->id_prodotto = isset($request->id_prodotto) ? $request->id_prodotto : 0;
        $campione->id_punto_camp = isset($request->id_punto_camp) ? $request->id_punto_camp : 0;
        $campione->id_superficie = isset($request->id_superficie) ? $request->id_superficie : 0;
        $campione->tdaSanif = isset($request->tdaSanif) ? $request->tdaSanif : 0;
        $campione->fase_Camp = isset($request->fase_Camp) ? $request->fase_Camp : 0;
        $campione->VCCC = isset($request->VCCC) ? ($request->VCCC == "on" ? 1 : 0) : 0;
        $campione->flusso = isset($request->flusso) ? $request->flusso : null;
        $campione->operat = isset($request->operat) ? $request->operat : null;
        $campione->n_persone = isset($request->n_persone) ? $request->n_persone : 0;
        $campione->PCampAria = isset($request->PCampAria) ? $request->PCampAria : 0;
        $campione->codDiff = isset($request->codDiff) ? $request->codDiff : 0;
        $campione->numProg = $request->numProg;
        $campione->dettaglio = isset($request->dettaglio) ? $request->dettaglio : null;
        $campione->anomalie = isset($request->anomalie) ? $request->anomalie : null;

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $campione->save();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        if($crea_areapartizione == true)
        {
            $areaReparto = new AreaPartizione;
            $areaReparto->id_reparto = $request->id_reparto;
            $areaReparto->area_partizione = $request->area_reparto;
            $areaReparto->codice_area_partizione = substr($request->area_reparto, 0, 3);
            $areaReparto->save();

            $campione->id_areareparto = $areaReparto->id;
            $campione->update();
        }

         /**
         * Salvataggio rilevatori
         */
        foreach($request->id_rilevatore as $ril)
        {
            $ril_camp = new CampioniRilevatoriSWAB;
            $ril_camp->id_campione_analisi_molecolari = $campione->id;
            $ril_camp->id_rilevatore = $ril;
            $ril_camp->save();
        }

        if($request->file('file'))
        {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $file_parts = pathinfo($filename);
            
            if($file_parts['extension'] != 'xlsx' && $file_parts['extension'] != 'xls')
            {
                Log::info($file_parts['extension']);
                $message = "Errore, formato file non valido. Inserire un file xlsx o xls";
                
                return redirect("/campionianalisimolecolare/$request->id_campagna/nuovomolecolari")
                        ->withErrors($message)
                        ->withInput();
                
        
            }
            
            if(Storage::disk('public')->exists("campionianalisimolecolare/$campione->id/$file"))
            {
                $message = "Errore, file inserito già presente in archivio. Ricontrollare";
                return redirect("/campionianalisimolecolare/$request->id_campagna/nuovomolecolari")
                    ->withErrors($message)
                    ->withInput();            }

            Storage::disk('public')->putFileAs("campionianalisimolecolare/$campione->id/", $file, $filename);
        }

        $id = $campione->id_campagna;

        //LoggerEvent::log(auth()->user()->id,"Creata nuova scheda con id $campione->id per la campagna $campione->id_campagna",$request->all(),false);

        if($request->submit == "Salva e procedi")
        {
            return $this->create($id);
        }
        else
        {
            return redirect()->action(
                [CampioneController::class, 'index'], [$id]
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CampioneAnalisiMolecolare  $CampioneAnalisiMolecolare
     * @return \Illuminate\Http\Response
     */
    public function show(CampioneAnalisiMolecolare $CampioneAnalisiMolecolare)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CampioneAnalisiMolecolare  $CampioneAnalisiMolecolare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Log::info($request);
        $validator = Validator::make($request->all(), [
            'id_progetto' => 'required',
            'dataCampagna' => 'required',
            'dataCampionamento' => 'required',
            'ora' => 'required',
            'id_struttura' => 'required',
            'id_reparto' => 'required',
            'numStanza' => 'required',
            'tipoCamp' => 'required',
            'id_categoria' => 'sometimes',
            'id_punto_camp' => 'sometimes',
            'id_superficie' => 'sometimes',
            'id_prodotto' => 'sometimes',
            'id_protocollo' => 'sometimes',
            'tdaSanif' => 'sometimes',
            'fase_Camp' => 'sometimes',
            'VCCC' => 'sometimes',
            'flusso' => 'sometimes',
            'operat' => 'sometimes',
            'n_persone' => 'sometimes',
            'PCampAria' => 'sometimes',
            'codDiff' => 'sometimes',
            'numProg' => 'required',
            'file' => 'sometimes',
            'dataAnalisi' => 'date',
            'tecnico' => 'string',
            'lotto' => 'string',
            'scadenza' => 'date',
            'tipoPiastra' => 'required',
            'occorrenze' => 'numeric',
            'occorrenza_iniziale' => 'numeric',
            'numero_immagini_da_inserire' => 'numeric'
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return response()->json(['error' => $messages], 403);
        }
        
        $code = $request->code; //codice di sessione per recupero dati
        $crea_areapartizione = false;
        $campione = CampioneAnalisiMolecolare::find($request->id_campione);
        if($campione == null)
        {
            $message = "Errore, campione non trovato";
            return response()->json(['error' => $message],403);
        }

        /**
         * Controllo sull'immagine dell'antibiogramma con NAB = 0 (Cioè conta colonie)
         */
        $immagine_temporanea_antibiogramma0 = TemporaryImage::where('code',$code)->where('tipo','antibiogramma0')->first();
        $imageMAB0 = ImmagineMicroAntibiogrammaSwab::where('id_campione',$campione->id)->where('tipo','antibiogramma0')->first();
        if(!isset($request->id_microrganismo_antibiogramma) && $immagine_temporanea_antibiogramma0 != null)
        {
            $messages = "Microrganismo non specificato, correggere";
            return response()->json(['error' => $messages], 403); 
        }
        if(isset($request->id_microrganismo_antibiogramma) && $immagine_temporanea_antibiogramma0 == null && $imageMAB0 == null)
        {
            $messages = "Immagine antibiogramma per conta colonie mancante, correggere";
            return response()->json(['error' => $messages], 403); 
        }

        /** 
         * Controllo sull'immagine dello striscio e microrganismi rilevatgi 
        */
        $immagine_temporanea_striscio = TemporaryImage::where('code',$code)->where('tipo','striscio')->first();
        $imageStriscio = ImmaginiPiastreSwab::where('id_campione',$campione->id)->where('tipo','striscio')->first();
        if(!isset($request->micro) && $immagine_temporanea_striscio != null)
        {
            $messages = "Microrganismo non specificato, correggere";
            return response()->json(['error' => $messages], 403); 
        }
        if(isset($request->micro) && $immagine_temporanea_striscio == null && $imageStriscio == null)
        {
            $messages = "Immagine striscio mancante, correggere";
            return response()->json(['error' => $messages], 403); 
        }

        if(isset($request->aa))
        {
            foreach ($request->aa as $key => $value) {
                //se sono nel caso in cui ho aggiunto un form per l'antibiogramma ma non ho inserito nulla, procedo. Altrimenti se ho mancato di inserire qualche campo ritorno errore.

                //Il primo if serve a capire se tutti e tre i campi di interesse sono vuoti. Per procedere nego l'ipotesi. 
                if(!((!isset($value['NAB']) || $value['NAB'] == null) && (!isset($value['id_antibiotico']) || $value['id_antibiotico'] == null) && (!isset($value['key_resistenza']) || $value['key_resistenza'] == null)))
                {
                    if((!isset($value['NAB']) || $value['NAB'] == null))
                    {
                        $messages = "Inserire un valore corretto per il campo NAB";
                        return response()->json(['error' => $messages], 403); 
                    }
                    if((!isset($value['id_antibiotico']) || $value['id_antibiotico'] == null))
                    {
                        $messages = "Inserire un valore corretto per il campo antibiotico";
                        return response()->json(['error' => $messages], 403); 
                    }
                    if((!isset($value['key_resistenza']) || $value['key_resistenza'] == null))
                    {
                        $messages = "Inserire un valore corretto per il campo resistenza";
                        return response()->json(['error' => $messages], 403); 
                    }
                } 
            }
        }

        if(!isset($request->rilevatori))
        {
            $message = "Inserire almeno un rilevatore del campionamento";
            return response()->json(['error' => $message],403);
        }

        $campagna = Campagna::find($request->id_campagna);
        if($campagna == null)
        {
            $message = "Errore, campagna non trovata";
            return response()->json(['error' => $message],403); 
        }

        $occorrenze = $request->occorrenze;
        $occorrenza_iniziale = $request->occorrenza_iniziale;
        $numero_immagini_da_inserire = $request->numero_immagini_da_inserire;


        $campione->id_campagna = $campagna->id;
        $campione->id_progetto = $request->id_progetto;
        $campione->id_struttura = $request->id_struttura;
        $campione->data = $request->dataCampionamento;
        $campione->dataCampagna = $campagna->dataCampagna;
        $campione->ora = $request->ora;

        $areaReparto = AreaPartizione::where('id_reparto',$request->id_reparto)->where('area_partizione',$request->area_partizione)->first();
        /**
         * Se non esiste l'area partizione significa che l'utente non è mai stato in quell'area e non l'ha creata nella gestione interna 
         * dunque la creo
         */
        if($areaReparto == null && $request->reparto != null)
        {
            $crea_areapartizione = true;
        }
        elseif($areaReparto == null && $request->reparto == null)
        {
            return response()->json(['error' => 'Inserire una partizione valida, riprovare'], 403);
        }
        else
        {
            $areaRepartoCampione = AreaPartizione::where('id',$campione->id_areareparto)->first();
            if($areaReparto->id != $areaRepartoCampione->id )
            {
                $campione->id_areareparto = $areaReparto->id;
            }
        }

        $campione->numstanze = $request->numStanza;
        $campione->tipoCamp = $request->tipoCamp;
        $campione->id_protocollo = isset($request->id_protocollo) ? $request->id_protocollo : 0;
        $campione->id_prodotto = isset($request->id_prodotto) ? $request->id_prodotto : 0;
        $campione->id_punto_camp = isset($request->id_punto_camp) ? $request->id_punto_camp : 0;
        $campione->id_superficie = isset($request->id_superficie) ? $request->id_superficie : 0;
        $campione->tdaSanif = isset($request->tdaSanif) ? $request->tdaSanif : 0;
        $campione->fase_Camp = isset($request->fase_Camp) ? $request->fase_Camp : 0;
        $campione->VCCC = (isset($request->VCCC) && $request->VCCC == "on") ? 1 : 0;
        $campione->flusso = isset($request->flusso) ? $request->flusso : null;
        $campione->operat = isset($request->operat) ? $request->operat : null;
        $campione->n_persone = isset($request->n_persone) ? $request->n_persone : 0;
        $campione->PCampAria = isset($request->PCampAria) ? $request->PCampAria : 0;
        $campione->codDiff = isset($request->codDiff) ? $request->codDiff : 0;
        $campione->numProg = $request->numProg;
        $campione->dettaglio = isset($request->dettaglio) ? $request->dettaglio : null;
        $campione->anomalie = isset($request->anomalie) ? $request->anomalie : null;
        $campione->dataAnalisi = $request->dataAnalisi;
        $campione->tecnico = $request->tecnico;
        $campione->lotto = $request->lotto;
        $campione->dataScadenza = $request->scadenza;
        $campione->codPiastra = $request->codPiastra;
        $campione->tipoPiastra = $request->tipoPiastra;
        $campione->dataIncubazione = isset($request->dataIncubazione) ? $request->dataIncubazione : null;
        $parts = isset($request->tempoIncubazione) ? explode(':', $request->tempoIncubazione) : 0;
        $tempoIncubazione = ($parts != 0) ? $parts[0] + floor(($parts[1]/60)*100) / 100 : null;
        // Log::info($tempoIncubazione);
        $campione->tempoIncubazione = $tempoIncubazione;
        $campione->note = $request->note;

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $campione->save();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        if($crea_areapartizione == true)
        {
            $areaReparto = new AreaPartizione;
            $areaReparto->id_reparto = $request->reparto;
            $areaReparto->area_partizione = $request->area_partizione;
            $areaReparto->codice_area_partizione = substr($request->area_partizione, 0, 3);
            $areaReparto->save();

            $campione->id_areareparto = $areaReparto->id;
            $campione->save();
        }

        /**
         * Salvataggio rilevatori
         */
        $rilevatoriCampione = CampioniRilevatoriSWAB::where('id_campione_analisi_molecolari',$campione->id)->get();
        $num_rilevatori = count($rilevatoriCampione);

        
        if(count($request->rilevatori) != $num_rilevatori)
        {
            //Verifico se ci sono rilevatori da eliminare
            foreach($rilevatoriCampione as $rilevatore)
            {
                $trovato = 0;
                foreach($request->rilevatori as $ril['id'])
                {
                    if($rilevatore->id == $ril['id'])
                    {
                        $trovato = 1;
                        break;
                    }
                }

                if($trovato == 0)
                {
                    $rilevatore->delete();
                }
                
            }

            //Verifico se ci sono rilevatori da aggiungere
            foreach($request->rilevatori as $ril['id'])
            {
                $trovato = 0;
                foreach($rilevatoriCampione as $rilevatore)
                {
                    if($rilevatore->id == $ril['id'])
                    {
                        $trovato = 1;
                        break;
                    }
                }

                if($trovato == 0)
                {
                    $rilevatore = new CampioniRilevatoriSWAB;
                    $rilevatore->id_campione_swab = $campione->id;
                    $rilevatore->id_rilevatore = $ril;
                    $rilevatore->save();
                }
                
            }

        }


        //Salvo eventualmente un nuovo file uploadato
        if(isset($request->file))
        {
            $file = $request->file;
            $file_parts = pathinfo($request->filename);

            if($file_parts['extension'] != 'xlsx')
            {
                $message = "Errore, formato file non valido. Inserire un file xlsx";
                return response()->json(['message',$message],403);
            }

            $file = str_replace("data:image/".$file_parts['extension'].";base64,", "", $file);
            $file = str_replace(' ', '+', $file);
            
            if(Storage::disk('public')->exists("campionianalisimolecolare/$campione->id/$file"))
            {
                $message = "Errore, file inserito già presente in archivio. Ricontrollare";
                return response()->json(['message',$message],403);        
            }

            $filename = $request->filename;

            Storage::disk('public')->putFileAs("campionianalisimolecolare/$campione->id/", $file, $filename);

        }

        //se presenza micro è on allora valutare microrganismi e foto striscio
        if($request->presenzamicro == true)
        {
            /**
             * Salvataggio dei microrganismi
             */
            if(isset($request->micro))
            {
                foreach ($request->micro as $key => $value) {
                    //salvataggio del microrganismo associato al campione con la relativa piastra e grandezza
                    if(MicroSuPiastraSwab::where('id_microrganismo',$value['id_microrganismo'])->where('id_campione',$campione->id)->where('id_tipopiastra',$value['id_tipopiastra'])->where('presente',$value['presente'])->first() == null)
                    {   
                        $microsupiastra = new MicroSuPiastraSwab;
                        $microsupiastra->id_microrganismo = $value['id_microrganismo'];
                        $microsupiastra->id_campione = $campione->id;
                        $microsupiastra->id_tipopiastra = $value['id_tipopiastra'];
                        $microsupiastra->presente = $value['presente'];
                        $microsupiastra->save();
                    }
                }
            }  
            
             /**
             * Salvataggio della foto della piastra (striscio)
             */
            $temporaryFile = TemporaryImage::where('code',$request->code)->get();
            if($temporaryFile != null)
            {
                foreach ($temporaryFile as $image) {
                    /**
                     * Generazione nome
                    */
                    $nuovonome = $image->nome_file;
                    if($image->tipo == 'striscio')
                    {
                        $nuovonome = $campione->id."S";
                    }      
                    elseif($image->tipo == 'antibiogramma0')
                    {
                        $nuovonome = "C".$campione->id;
                    }

                    /**
                     * Verifica esistenza immagine con conseguente cambio nome e salvataggio immagine in cartella
                     */
                    if($image->tipo == 'striscio')
                    {
                        $nomecompleto = explode('.',$image->nome_file);
                        $estensione = $nomecompleto[1];
                        $i = 0;
                        $nuovonome .= ".".$estensione;
                        while(1){
                            if(!Storage::disk('public')->exists("campionianalisimolecolare/$campione->id/$nuovonome")){
                                //Storage::disk('public')->move("temporary/$image->nome_file","$nuovonome.jpg" );
                                Storage::disk('public')->copy("temporary/$image->nome_file","campionianalisimolecolare/$campione->id/$nuovonome");
                                break;
                            }else{
                                $i++;
                                $nomecompleto = explode('.',$nuovonome);
                                $nome = $nomecompleto[0]."($i)";
                                $estensione = $nomecompleto[1];
                                $nuovonome = $nome.".".$estensione;
                            }
                        }
                        //TO DO: creo segnalazione qui per dire che esiste già un immagine con quel nome
                        
                    }
                    elseif($image->tipo == 'antibiogramma0')
                    {
                        $nomecompleto = explode('.',$image->nome_file);
                        $estensione = $nomecompleto[1];
                        $i = 0;
                        $nuovonome .= ".".$estensione;
                        while(1){
                            if(!Storage::disk('public')->exists("campionianalisimolecolare/$campione->id/antibiogrammi/$nuovonome")){
                                //Storage::disk('public')->move("temporary/$image->nome_file","$nuovonome.jpg" );
                                Storage::disk('public')->copy("temporary/$image->nome_file","campionianalisimolecolare/$campione->id/antibiogrammi/$nuovonome");
                                break;
                            }else{
                                $i++;
                                $nomecompleto = explode('.',$nuovonome);
                                $nome = $nomecompleto[0]."($i)";
                                $estensione = $nomecompleto[1];
                                $nuovonome = $nome.".".$estensione;
                            }
                        }
                        //TO DO: creo segnalazione qui per dire che esiste già un immagine con quel nome   
                    }

                    /**
                     * Salvataggio immagine in database
                     */
                    if($image->tipo == 'striscio')
                    {
                        $path = Storage::disk('public')->path("campionianalisimolecolare/$campione->id/$nuovonome");

                        $immagine = new ImmaginiPiastreSwab;
                        $immagine->id_campione = $campione->id;
                        $immagine->nome_file = $nuovonome;
                        $immagine->path_file = $path;
                        $immagine->tipo = $image->tipo;
                        $immagine->save();

                        //Elimino il riferimento al file temporaneo nella tabella delle immagini temporanee
                        $image->delete();
                    }
                    elseif($image->tipo == 'antibiogramma0')
                    {
                        $path = Storage::disk('public')->path("campionianalisimolecolare/$campione->id/antibiogrammi/$nuovonome");
                            
                        $immagine = new ImmagineMicroAntibiogrammaSwab;
                        $immagine->id_campione = $campione->id;
                        $immagine->nome_file = $nuovonome;
                        $immagine->path_file = $path;
                        $immagine->tipo = $image->tipo;
                        $immagine->save();

                        //Elimino il riferimento al file temporaneo nella tabella delle immagini temporanee
                        $image->delete();
                    }            
                }
            }
        }

        if(isset($request->id_microrganismo_antibiogramma) && ImmagineMicroAntibiogrammaSwab::where('id_campione',$campione->id)->where('tipo','antibiogramma0')->first() != null && MicroAntibiogrammaSwab::where('id_campione',$campione->id)->where('NAB',0)->first() == null)
        {
            $microAntibiogramma = new MicroAntibiogrammaSwab;
            $microAntibiogramma->NAB = 0;
            $microAntibiogramma->id_campione = $campione->id;
            $microAntibiogramma->id_microrganismo = $request->id_microrganismo_antibiogramma;
            $microAntibiogramma->colonia = 0;
            $microAntibiogramma->save();
        }

         /**
         * Salvataggio del MicroAntibiogramma e AntibioticoAntibiogramma
         */
        $count = 0;
        if(isset($request->nab_array))
        {
            foreach ($request->nab_array as $key => $value) 
            {
                $count++;
                if(isset($value['NAB']) && $value['NAB'] != null)
                {
                    if(MicroAntibiogrammaSwab::where('id_campione',$campione->id)->where('id_microrganismo',100)->where('NAB',$value['NAB'])->where('colonia',$request->colonia)->first() == null)
                    {
                        $microAntibiogramma = new MicroAntibiogrammaSwab;
                        $microAntibiogramma->NAB = $value['NAB'];
                        $microAntibiogramma->id_campione = $campione->id;
                        $microAntibiogramma->id_microrganismo = 100; //il 100esimo MicrorganismoPiastra è un micro fittizzio per ovviare al -1 del vecchio db. Rappresenta "Nessuno".
                        $microAntibiogramma->colonia = $value['colonia'];
                        $microAntibiogramma->save();
                    }

                    $imageMAB = TemporaryImage::where('code',$request->code)->where('tipo',"antibiogramma$count")->first();
                    if($imageMAB != null)
                    {
                        /**
                         * Genero il nome
                         */
                        $nuovonome = $campione->id."C0".$value['NAB'];

                        /**
                         * Verifica esistenza immagine con conseguente cambio nome e salvataggio in cartella
                         */
                        $nomecompleto = explode('.',$imageMAB->nome_file);
                        $estensione = $nomecompleto[1];
                        $nuovonome .= ".".$estensione;

                        $i = 0;
                        while(1)
                        {
                            if(!Storage::disk('public')->exists("/campionianalisimolecolare/$campione->id/antibiogrammi/$nuovonome")){
                                //Storage::disk('public')->move("temporary/$image->nome_file","$nuovonome.jpg" );
                                Storage::disk('public')->copy("temporary/$imageMAB->nome_file","/campionianalisimolecolare/$campione->id/antibiogrammi/$nuovonome");
                                break;
                            }else{
                                $i++;
                                $nomecompleto = explode('.',$nuovonome);
                                $nome = $nomecompleto[0]."($i)";
                                $estensione = $nomecompleto[1];
                                $nuovonome = $nome.".".$estensione;
                            }
                        }
                        //TO DO: creo segnalazione qui per dire che esiste già un immagine con quel nome
                        
                        $path = Storage::disk('public')->path("/campionianalisimolecolare/$campione->id/antibiogrammi/$nuovonome");
                        
                        $immagine = New ImmagineMicroAntibiogrammaSwab;
                        $immagine->id_campione = $campione->id;
                        $immagine->nome_file = $nuovonome;
                        $immagine->path_file = $path;
                        $immagine->tipo = $imageMAB->tipo;
                        $immagine->save();
        
                        //Elimino il riferimento al file temporaneo nella tabella delle immagini temporanee
                        $imageMAB->delete();
                    }

                }
            }
        }

        if(isset($request->aa))
        {
            foreach ($request->aa as $key => $value) {
                if(isset($value['NAB']) && $value['NAB'] != null && isset($value['id_antibiotico']) && $value['id_antibiotico'] != null && isset($value['key_resistenza']) && $value['key_resistenza'] != null)
                {
                    if(AntibioticoAntibiogrammaSwab::where('id_campione_analisi_molecolare',$campione->id)->where('NAB',$value['NAB'])->where('id_antibiotico',$value['id_antibiotico'])->where('resistenza',$value['key_resistenza'])->first() == null)
                    {
                        $aa = new AntibioticoAntibiogrammaSwab;
                        $aa->id_campione_analisi_molecolare = $campione->id;
                        $aa->NAB = $value['NAB'];
                        $aa->id_antibiotico = $value['id_antibiotico'];
                        $aa->resistenza = $value['key_resistenza'];
                        $aa->save();
                    }
                }
            }
        }

        LoggerEvent::log(auth()->user()->id,"Modificato campione analisi molecoalre con id $campione->id della campagna $campione->id_campagna",$request->all(),false, $campione->id);
        return json_encode(['id_campione' => $campione->id, 'id_campagna' => $campione->id_campagna]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Log::info("CampioneAnalisiMolecolare ".$id);
        $campione = CampioneAnalisiMolecolare::find($id);

        if($campione != null)
        {
            $campione->delete();
        }

        LoggerEvent::log(auth()->user()->id, "Cancellazione scheda con id $id", ['id_scheda' => $id], true, $campione->id);
        return json_encode('ok');
    }

    /**
     * Funzione usata per generare un codice casuale per la memorizzazione ed identificazione temporanea delle immagini.
     */
    public function generateUniqueCode()
    {
        do {
            $code = random_int(100000, 999999);
        } while (TemporaryImage::where("code", "=", $code)->first());
  
        return $code;
    }
}
