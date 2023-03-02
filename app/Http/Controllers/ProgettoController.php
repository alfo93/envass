<?php

namespace App\Http\Controllers;

use App\Progetto;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Societa;
use App\Campione;
use Illuminate\Validation\Rule;
use App\Event\LoggerEvent;
use App\StruttRep;
use App\Procedura;
class ProgettoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $societa = Societa::all();
        /**
         * Rapporto campionamenti anni a confronto
         */
        $progetti_campioni = collect([]);
        
        foreach (Progetto::where('versione',2)->get() as $p) 
        {
            $nome_progetto = $p->progetto;
            $totale_mesi = Campione::join('progetti','progetti.id','=','campioni.id_progetto')
                                    ->join('conversione_progetto','conversione_progetto.progettoV1','=','campioni.id_progetto')
                                    ->where('campioni.data', '>', Carbon::now()->startOfYear()->format('Y-m-d'))
                                    ->where('campioni.data', '<=', Carbon::now()->format('Y-m-d'))
                                    ->where('conversione_progetto.progettoV2',$p->id)
                                    ->select(DB::raw('count(campioni.id) as totale, month(campioni.data) as mesi'))
                                    ->groupBy('mesi')
                                    ->orderBy('mesi', 'ASC')
                                    ->get(['totale','mesi']);  

            $progetti_campioni->push([
                'nome_progetto' => $nome_progetto,
                'totale_mesi' => $totale_mesi
            ]);
        }

        $palette_colori = [
            0 => 'rgba(13, 208, 251, 0.75)',
            1 => 'rgba(11, 227, 126, 0.75)',
            2 => 'rgba(224, 227, 11, 0.75)',
            3 => 'rgba(62, 250, 25, 0.75)',
            4 => 'rgba(255, 215, 84, 0.75)',
            5 => 'rgba(227, 119, 57, 0.75)',
            6 => 'rgba(251, 198, 63, 0.75)',
            7 => 'rgba(250, 75, 98, 0.75)',
            8 => 'rgba(178, 57, 227, 0.75)',
            9 => 'rgba(43, 53, 255, 0.75)',
            10 => 'rgba(130, 153, 174, 0.75)',
            11 => 'rgba(50, 153, 250, 0.75)',
            12 => 'rgba(250, 84, 75, 0.75)',
            13 => 'rgba(238, 250, 100, 0.75)',
            14 => 'rgba(173, 42, 35, 0.75)',
            15 => 'rgba(250, 144, 87, 0.75)',
            16 => 'rgba(133, 250, 100, 0.75)',
            17 => 'rgba(250, 84, 75, 0.75)',
            18 => 'rgba(50, 250, 241, 0.75)',
            19 => 'rgba(250, 62, 215, 0.75)'
        ];

        $palette_colori_bg = [
            0 => 'rgba(13, 208, 251, 0.2)',
            1 => 'rgba(11, 227, 126, 0.2)',
            2 => 'rgba(224, 227, 11, 0.2)',
            3 => 'rgba(62, 250, 25, 0.2)',
            4 => 'rgba(255, 215, 84, 0.2)',
            5 => 'rgba(227, 119, 57, 0.2)',
            6 => 'rgba(251, 198, 63, 0.2)',
            7 => 'rgba(250, 75, 98, 0.2)',
            8 => 'rgba(178, 57, 227, 0.2)',
            9 => 'rgba(43, 53, 255, 0.2)',
            10 => 'rgba(130, 153, 174, 0.2)',
            11 => 'rgba(50, 153, 250, 0.2)',
            12 => 'rgba(250, 84, 75, 0.2)',
            13 => 'rgba(238, 250, 100, 0.2)',
            14 => 'rgba(173, 42, 35, 0.2)',
            15 => 'rgba(250, 144, 87, 0.2)',
            16 => 'rgba(133, 250, 100, 0.2)',
            17 => 'rgba(250, 84, 75, 0.2)',
            18 => 'rgba(50, 250, 241, 0.2)',
            19 => 'rgba(250, 62, 215, 0.2)'
        ];

        $palette_colori_bg_point = [
            0 => 'rgba(13, 208, 251, 0.9)',
            1 => 'rgba(11, 227, 126, 0.9)',
            2 => 'rgba(224, 227, 11, 0.9)',
            3 => 'rgba(62, 250, 25, 0.9)',
            4 => 'rgba(255, 215, 84, 0.9)',
            5 => 'rgba(227, 119, 57, 0.9)',
            6 => 'rgba(251, 198, 63, 0.9)',
            7 => 'rgba(250, 75, 98, 0.9)',
            8 => 'rgba(178, 57, 227, 0.9)',
            9 => 'rgba(43, 53, 255, 0.9)',
            10 => 'rgba(130, 153, 174, 0.9)',
            11 => 'rgba(50, 153, 250, 0.9)',
            12 => 'rgba(250, 84, 75, 0.9)',
            13 => 'rgba(238, 250, 100, 0.9)',
            14 => 'rgba(173, 42, 35, 0.9)',
            15 => 'rgba(250, 144, 87, 0.9)',
            16 => 'rgba(133, 250, 100, 0.9)',
            17 => 'rgba(250, 84, 75, 0.9)',
            18 => 'rgba(50, 250, 241, 0.9)',
            19 => 'rgba(250, 62, 215, 0.9)'
        ];
        


        return view('progetti.index',compact('societa','progetti_campioni','palette_colori','palette_colori_bg','palette_colori_bg_point'));
    }

    /**
     * @param Request $request
     * @param String $progetto
     *
     * @return query query per riempimento tabella progetti in index progetti
     */
    public function list(Request $request)
    {
        $data = Progetto::join('societa','progetti.id_societa','=','societa.id')
                            ->where('progetti.versione',2);
        
        $data = $data->select([
            'progetti.*',
            'societa.nome as societa',
        ]);

        return DataTables::of($data)
            ->addColumn('azione',function($data) {
                $button = '<div class="row">' . '<div class="col-sm-12">';               
                $button .=  '<a href=""  class="btn btn-small btn-action btn-primary modifica_button" id="' . $data->id . '" data-toggle="modal" data-target="#ModalModificaProgetto"  value="Modifica"">Modifica</a>';             
                $button .=  '<a class="btn btn-small btn-action btn-danger button-elimina btn-elimina" id="'.$data->id.'"  data-toggle="modal" data-target="#deleteModal">Elimina</a>';
                $button .= '</div>' . '</div>';

                return $button;
            })
            ->editColumn('societa',function($data){
                $societa = Societa::where('nome',$data->societa)->first();
                return $societa->nome;
            })
            ->editColumn('progetto',function($data){
                $progetto = Progetto::whereEncrypted('progetto',$data->progetto)->first();
                return $progetto->progetto;
            })
            ->editColumn('data_inizio_progetto',function($data){
                return Carbon::parse($data->data_inizio_progetto)->format('d/m/Y');
            })
            ->editColumn('data_fine_progetto',function($data){
                return $data->data_fine_progetto != null ? Carbon::parse($data->data_fine_progetto)->format('d/m/Y') : 'Non specificato';
            })
            ->filterColumn('societa', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->whereEncrypted('nome', 'like', "%" . $keyword . "%");
            }) 
            ->filterColumn('progetto',function($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->whereEncrypted('progetto', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('data_inizio_progetto', function ($query) use ($request) {
                if(strpos(request()->search['value'],'/') !== false)
                {
                    $date = explode('/', request()->search['value']);
                    $query->where('progetti.data_inizio_progetto','like',"%".$date[0]."%");
                    for($i=1;$i<count($date);$i++)
                    {
                        $query->where('progetti.data_inizio_progetto','like',"%".$date[$i]."%");
                    }
                }
                else
                {
                    $query->where('progetti.data_inizio_progetto','like',"%".request()->search['value']."%");
                }        
            })
            ->filterColumn('data_fine_progetto', function ($query) use ($request) {
                if(strpos(request()->search['value'],'/') !== false)
                {
                    $date = explode('/', request()->search['value']);
                    $query->where('progetti.data_fine_progetto','like',"%".$date[0]."%");
                    for($i=1;$i<count($date);$i++)
                    {
                        $query->where('progetti.data_fine_progetto','like',"%".$date[$i]."%");
                    }
                }
                else
                {
                    $query->where('progetti.data_fine_progetto','like',"%".request()->search['value']."%");
                }        
            })
            ->editColumn('attivo',function($data){
                Log::info($data->attivo);
                if($data->attivo == "si")
                {
                    $attivo = "Attivo";
                }
                elseif($data->attivo == "sospeso")
                {
                    $attivo = "Da confermare";
                }
                else
                {
                    $attivo = "Non attivo";
                }
                return $attivo;
            })
            ->rawColumns(['azione','societa','progetto','data_inizio_progetto','data_fine_progetto','attivo'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $societa = Societa::all();
        return view('progetti.crea_progetto',compact('societa'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'progetto' => 'unique:progetti|String|min:2',
            'CodPro' => 'unique:progetti|String|min:2',
        ]);

        $progetto = new Progetto;
        $progetto->progetto = ucfirst($request->nome);
        $progetto->codPro = $request->codice;
        $progetto->id_societa = $request->societa;
        $progetto->data_inizio_progetto = $request->data;
        $progetto->tipo = $request->tipo;
        $progetto->versione = 2;
        $progetto->attivo = $request->stato;
        $progetto->save();

        LoggerEvent::log(auth()->user()->id,"Creazione nuova attività",$request->all(),false);
        return json_encode('attività creata correttamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Progetto  $progetto
     * @return \Illuminate\Http\Response
     */
    public function show(Progetto $progetto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Progetto  $progetto
     * @return \Illuminate\Http\Response
     */
    public function edit(Progetto $progetto)
    {
        //
    }

    /**
     * @param Request $request
     * @param mixed $id
     *
     * @return Progetto
     */
    public function getProgetto(Request $request, $id)
    {
        $progetto = Progetto::find($id);
        //Log::info($progetto);
        $societa_progetto = Societa::where('id',$progetto->id_societa)->first();
        $tipo = $progetto->tipo == 'Monitoraggio routine' ? 1 : 2;
        $elementi_progetto = [
            'nome_progetto' => $progetto->progetto,
            'codProgetto' => $progetto->CodPro,
            'tipo_progetto' => $tipo,
            'societa_progetto' => $societa_progetto->id,
            'data_inizio_progetto' => $progetto->data_inizio_progetto,
            'attivo' => $progetto->attivo
        ];
        return json_encode($elementi_progetto);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Progetto  $progetto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $string)
    {
        $validator = Validator::make($request->all(), [
            'progetto' => [
                'required',
                Rule::unique('progetti')->ignore($request->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: dati non validi'], 403);
        }

        $progetto = Progetto::find($request->id);
        
        if($progetto == null)
        {
            return json_encode('Errore, progetto non trovato');
        }
                
        if (request('progetto') == null) {
            $risultatoQuery = Progetto::find($request->id);
            $nome_progetto = $risultatoQuery["progetto"];
        } else {
            $nome_progetto = request('progetto');
        }

        if (request('CodPro') == null) {
            $risultatoQuery = Progetto::find($request->id);
            $CodPro = $risultatoQuery["CodPro"];
        } else {
            $CodPro = request('CodPro');
        }

        if (request('tipo') == null) {
            $risultatoQuery = Progetto::find($request->id);
            $tipo = $risultatoQuery["tipo"];
        } else {
            $tipo = request('tipo');
        }

        if (request('id_societa') == null) {
            $risultatoQuery = Progetto::find($request->id);
            $id_societa = $risultatoQuery["id_societa"];
        } else {
            $id_societa = request('id_societa');
        }

        if (request('data_inizio_progetto') == null) {
            $risultatoQuery = Progetto::find($request->id);
            $data_inizio_progetto = $risultatoQuery["data_inizio_progetto"];
        } else {
            $data_inizio_progetto = request('data_inizio_progetto');
        }

        Log::info(request('attivo'));
        if (request('attivo') == null) {
            $risultatoQuery = Progetto::find($request->id);
            $attivo = $risultatoQuery["attivo"];
        } else {
            $attivo = request('attivo');
        }


        $progetto->progetto = $nome_progetto;
        $progetto->id_societa = $id_societa;
        $progetto->tipo = $tipo;
        $progetto->CodPro = $CodPro;
        $progetto->data_inizio_progetto = $data_inizio_progetto;
        $progetto->attivo = $attivo;
        $progetto->versione = 2;
        $progetto->save();

        LoggerEvent::log(auth()->user()->id, "Modifica dei dati dell'attività: $progetto->progetto", $request->all(), true);
        return json_encode("Attività modificata correttamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Progetto  $progetto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $progetto = Progetto::find($id);
        if($progetto == null)
        {
            return response()->json(["messaggio"=>'Errore, committente non trovato'],404);
        }
        else
        {
            $campione = Campione::where('id_progetto',$progetto->id)->get();
            
            //Non posso permettere l'eliminazione del progetto se per quel progetto esistono già dei campionamenti
            if(count($campione) > 0)
            {
                return response()->json(["messaggio"=>'Impossibile eliminare l\'attività per presenza di campionamenti riferiti ad esso'],403);
            }

            $progetto->motivo = $request->motivo;
            $progetto->id_utente_cancella = auth()->user()->id;
            $progetto->attivo = "no";
            $progetto->save();
            $progetto->delete();

            LoggerEvent::log(auth()->user()->id,"Eliminato progetto: $progetto->progetto. Motivo: $request->motivo",$progetto,false);
            return json_encode('Attività eliminata correttamente');
        }
    }



    /**
     * Function getDataOfProgetto
     * 
     * @param Request $request
     * @param String $progetto
     * 
     * @return $array
     */
    public function getDataOfProgetto(Request $request, String $progetto) 
    {
        $progetto = Progetto::whereEncrypted('progetto',$request->progetto)->first();
        if($progetto != null)
        {
            $societa = $progetto->societa()->first();
            if($societa != null)
            {
                $struttureProgetto = StruttRep::join('progetti','progetti.id','strutture_reparti_envass.id_progetto')
                                                ->join('strutture','strutture.id','strutture_reparti_envass.id_struttura')
                                                ->where('progetti.id',$progetto->id)
                                                ->select('strutture.*')
                                                ->groupBy('strutture.id')
                                                ->get();

                $repartiProgettoStruttura = StruttRep::join('progetti','progetti.id','strutture_reparti_envass.id_progetto')
                                                ->join('reparti','reparti.id','strutture_reparti_envass.id_reparto')
                                                ->join('strutture','strutture.id','strutture_reparti_envass.id_struttura')
                                                ->where('progetti.id',$progetto->id)
                                                ->where('strutture.id',$struttureProgetto[0]->id)
                                                ->select('reparti.*')
                                                ->groupBy('reparti.id')
                                                ->get();
                
                $procedureProgetto = Procedura::where('id_progetto',$progetto->id)->orWhere('id_progetto',0)->get();

                $array = [
                    'id_societa' => $societa->id,
                    'nome_societa' => $societa->nome,
                    'indirizzo_societa' => $societa->indirizzo,
                    'struttureProgetto' => $struttureProgetto,
                    'repartiProgetto' => $repartiProgettoStruttura,
                    'procedureProgetto' => $procedureProgetto
                ];
                
                return $array;
            }
        }
        else
        {
            $array = [
                'id_societa' => "",
                'nome_societa' => "",
                'indirizzo_societa' => "",
                'srProgetto' => "",
                'struttureProgetto' => "",
                'repartiProgetto' => "",
                'procedureProgetto' => ""
            ];

            return $array;
        }
    }
}
