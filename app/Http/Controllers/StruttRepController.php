<?php

namespace App\Http\Controllers;

use App\StruttRep;
use Illuminate\Http\Request;
use App\Progetto;
use App\Struttura;
use App\Reparto;
use Log;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Event\LoggerEvent;
use Illuminate\Validation\Rule;
use App\AreaPartizione;
class StruttRepController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            
            'id_progetto' => 'uniqueCombo:strutture_reparti_envass,id_struttura,id_reparto,id_associazione',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: Assegnamento gia\' esistente'], 403);
        }

        $StruttRep = new StruttRep;
        $StruttRep->id_progetto = $request->id_progetto;
        $StruttRep->id_reparto = $request->id_reparto;
        $StruttRep->id_struttura = $request->id_struttura;

        $associazione = AreaPartizione::where('id_reparto',$request->id_reparto)->where('area_partizione',$request->area_partizione)->first();
        if($associazione == null)
        {
            $new_associazione = new AreaPartizione;
            $new_associazione->id_reparto = $request->id_reparto;
            $new_associazione->area_partizione = $request->area_partizione;
            $new_associazione->codice_area_partizione = $request->codice_area_part;
            $new_associazione->versione = 2;
            $new_associazione->save();

        }
        else
        {
            $new_associazione = $associazione;
        }

        $StruttRep->id_associazione = $new_associazione->id;
        $StruttRep->versione = 2;
        $StruttRep->save();

        LoggerEvent::log(auth()->user()->id,"Nuovo assegnamento reparto struttura",$request->all(),false);
        return json_encode(['messaggio'=>'Assegnamento inserito correttamente',
                            'id'=>$StruttRep->id,
                            'id_progetto'=>$StruttRep->id_progetto,
                            'id_struttura'=>$StruttRep->id_struttura,
                            'id_reparto'=>$StruttRep->id_reparto,
                            'id_associazione' => $StruttRep->id_associazione,
                            'area_partizione' => $new_associazione->area_partizione,
                            'codice_area_part' => $new_associazione->codice_area_partizione]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SruttRep  $sruttRep
     * @return \Illuminate\Http\Response
     */
    public function show(SruttRep $sruttRep)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SruttRep  $sruttRep
     * @return \Illuminate\Http\Response
     */
    public function edit(SruttRep $sruttRep)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'id_progetto' => 'uniqueComboIgnore:strutture_reparti_envass,id_struttura,id_reparto,id_associazione,'.$request->id
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['error' => 'Errore: Assegnamento gia\' esistente'], 403);
        // }

        $strutt_rep = StruttRep::where('id','!=',$request->id)
                                ->where('id_progetto',$request->id_progetto)
                                ->where('id_struttura',$request->id_struttura)
                                ->where('id_reparto',$request->id_reparto)
                                ->where('id_associazione',$request->id_associazione);

        if ($strutt_rep->count() > 0) {
            return response()->json(['error' => 'Errore: Assegnamento gia\' esistente'], 403);
        }

        /**
         * Verifico che ci siano dei valori che sono effettivamente cambiati. Se non sono cambiati ritorno senza fare nulla
         */
        $strutt_rep = StruttRep::find($request->id);
        if($strutt_rep->id_progetto == $request->id_progetto && $strutt_rep->id_struttura == $request->id_struttura && $strutt_rep->id_reparto == $request->id_reparto && $strutt_rep->id_associazione == $request->id_associazione)
        {
            $areaPartizione = AreaPartizione::find($request->id_associazione);
            if($areaPartizione->id_reparto == $request->id_reparto && $areaPartizione->area_partizione == $request->area_partizione && $areaPartizione->codice_area_partizione == $request->codice_area)
            {
                return json_encode(['messaggio'=>'Nessun cambiamento'],200);
            }
        }

        
        $messaggio = "";
        $StruttRep = StruttRep::find($request->id);
        if($request->id_progetto != $StruttRep->id_progetto)
        {
           $messaggio .= "Sostituito progetto. ";

        }
        if($request->id_reparto != $StruttRep->id_reparto)
        {
           $messaggio .= "Sostituito reparto. ";

        }
        if($request->id_associazione != $StruttRep->id_associazione)
        {
           $messaggio .= "Sostituita associazione area reparto. ";

        }
        if($request->id_struttura != $StruttRep->id_struttura)
        {
           $messaggio .= "Sostituita struttura. ";

        }
        
        $StruttRep->motivo = "$messaggio. Motivo: $request->motivo";
        $StruttRep->id_utente_cancella = auth()->user()->id;
        $StruttRep->update();
        $StruttRep->delete();

        /**
         * Identifico il tipo di modifica da effettuare
         * Ho essenzialmente 2 casi:
         * Modifico solo le informazioni relativo alla tripla Progetto - Struttura - Reparto
         * Modifico anche le informazioni relativa alla coppia Area Partizione - Codice Area Partizione
         * Per prima cosa quindi devo identificare cosa ho modificato. 
         * 
         * If ho modificato Area Partizione o Codice Area Partizione
         * Then 
         *      If le informazioni che ho modificato esistono già nella tabella
         *      Then 
         *           Sostituisco l'id dell'associazione con la nuova nella tabella struttura reparti
         *      Else
         *          Modifico le informazioni nell'associazione attuale nella tabella area_partizione 
         *          Infine assegno il risultato della modifica all'id dell'associazione nella tabella struttura reparti
         * If ho modificato Progetto, Struttura o Reparto
         * Then 
         *      Controllo che non esista già questa tripla.
         *      If esiste
         *          Then Errore all'utente
         *      Else
         *          devo modificare quelle informazioni nella tabella strutture_reparti_envass
         */

        
        $struttura_reparti = StruttRep::where('id_progetto',$request->id_progetto)
                                        ->where('id_reparto',$request->id_reparto)
                                        ->where('id_struttura',$request->id_struttura)
                                        ->where('id','!=',$request->id)
                                        ->first();
        if($struttura_reparti != null)
        {
            return response()->json(['error' => 'Errore: Assegnamento gia\' esistente'], 403);
        }
        
        $new_StruttRep = new StruttRep;
        $new_StruttRep->id_progetto = $request->id_progetto;
        $new_StruttRep->id_reparto = $request->id_reparto;
        $new_StruttRep->id_struttura = $request->id_struttura;


        /**
         * Sto cercando un'associazione che abbia lo stesso id_reparto e che abbia lo stesso area_partizione e codice_area_partizione
         * Se la trovo e sto sostituendo l'assegnamento del progetto a questa tripla reparto-area-codice_area allora uso quella esistente
         * senza crearne una nuova. Infine controllo se l'associazione sostiuita è stata utilizzata in altri assegnamenti. 
         * Se non è stata utilizzata vuol dire che non serve più e la elimino.
         */
        $area_partizione = AreaPartizione::where('id_reparto',$request->id_reparto)
                                        ->where('area_partizione',$request->area_partizione)
                                        ->where('codice_area_partizione',$request->codice_area)
                                        ->where('id','!=',$request->id_associazione)->first();
        
        if($area_partizione == null)
        {
            $associazione = AreaPartizione::find($request->id_associazione);
            $associazione->area_partizione = $request->area_partizione;
            $associazione->codice_area_partizione = $request->codice_area;
            $associazione->update();
            $new_StruttRep->id_associazione = $request->id_associazione;
            $new_StruttRep->save();
        }
        else
        {
            $new_StruttRep->id_associazione = $area_partizione->id;
            $new_StruttRep->save();
            /**
             * cerco se l'associazione che ho modificato è assegnata a qualche tripla progetto struttura reparto
             * If non è assegnata
             *    Then la elimino
             */
            $struttura_reparti = StruttRep::where('id_associazione',$request->id_associazione)->first();
            if($struttura_reparti == null)
            {
                $associazione = AreaPartizione::find($request->id_associazione);
                $associazione->delete();
            }
        }        

        LoggerEvent::log(auth()->user()->id,"Assegnamento reparto struttura modificato. Motivo: $request->motivo",$request->all(),false);
        return json_encode(['messaggio'=>'Assegnamento modificato correttamente',
                            'id'=>$new_StruttRep->id,
                            'id_progetto'=>$new_StruttRep->id_progetto,
                            'id_struttura'=>$new_StruttRep->id_struttura,
                            'id_reparto'=>$new_StruttRep->id_associazione,
                            'id_associazione' => $new_StruttRep->id_associazione,
                            'area_partizione' => $request->area_partizione,
                            'codice_area' => $request->codice_area
                        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SruttRep  $sruttRep
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $StruttRep = StruttRep::find($request->id);
        if ($StruttRep == null) {
            return response()->error(['errore' => 'assegnamento non trovato, riprovare'],403); 
        } 
        $StruttRep->motivo = $request->motivo;
        $StruttRep->id_utente_cancella = auth()->user()->id;
        $StruttRep->update();
        $StruttRep->delete();

        LoggerEvent::log(auth()->user()->id, "Cancellazione struttura - reparto avvenuta correttamente. Motivo: $request->motivo", $request->all(), true);
        return json_encode(['status' => 'ok']);
    }

    /**
     * Search the specified resource
     */
    public function getStruttura(Request $request)
    {
        $progetto = Progetto::where('id',$request->id_progetto)->first();

        if($progetto == null)
        {
            $message = "Inserire un progetto valido";
            return response()->json(['message' => $message]);
        }

        
        $struttura = StruttRep::join('strutture','strutture.id','=','strutture_reparti_envass.id_struttura')
                                ->join('progetti','progetti.id','=','strutture_reparti_envass.id_progetto')
                                ->where('strutture_reparti_envass.id_progetto','=',$progetto->id)
                                ->distinct('strutture_reparti_envass.id_struttura')
                                ->select('strutture_reparti_envass.id_struttura as id','strutture.struttura as struttura')
                                ->get(); 
        //Log::info($StruttRep);      
        

        //Log::info($codiceStruttura);
        return json_encode(['strutture' => $struttura]);
        
    }

    /**
     * Search the specified resource
     */
    public function getReparto(Request $request)
    {
        $progetto = Progetto::find($request->id_progetto);
        $struttura = Struttura::find($request->id_struttura);

        $reparto = Reparto::all();

        if($progetto != null && $struttura != null)
        {   
            $reparto = StruttRep::join('strutture','strutture.id','=','strutture_reparti_envass.id_struttura')
                                    ->join('progetti','progetti.id','=','strutture_reparti_envass.id_progetto')
                                    ->join('reparti','reparti.id','=','strutture_reparti_envass.id_reparto')
                                    ->where('strutture_reparti_envass.id_progetto','=',$progetto->id)
                                    ->where('strutture_reparti_envass.id_struttura','=',$struttura->id)
                                    ->distinct('strutture_reparti_envass.id_reparto')
                                    ->select('strutture_reparti_envass.id_reparto as id','reparti.partizione as reparto')
                                    ->get(); 

        }

        //Log::info($codiceStruttura);
        return json_encode(['reparti' => $reparto]);
    }
}
