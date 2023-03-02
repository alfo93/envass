<?php

namespace App\Http\Controllers;

use App\Struttura;
use Illuminate\Http\Request;
use Log;
use App\Progetto;
use App\StruttRep;
use App\Reparto;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Event\LoggerEvent;
use Illuminate\Validation\Rule;


class StrutturaController extends Controller
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
    public function create()
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
            
            'nome' => 'required|unique:strutture,struttura',
            'sede' => 'required',
            'provincia' => 'required|string|max:2',
            'codice_struttura' => 'required|unique:strutture,codice_struttura',
            'codice_sede' => 'required|max:3',
            'codice_provincia' => 'required|max:2',
            'codice_struttura' => 'uniqueCombo:strutture,codice_sede,codice_provincia',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: struttura gia\' esistente'], 403);
        }

        $struttura = new Struttura;
        $struttura->struttura = $request->nome;
        $struttura->sede = ucfirst(strtolower($request->sede));
        $struttura->provincia = strtoupper($request->provincia);
        $struttura->codice_struttura = strtoupper($request->codice_struttura);
        $struttura->codice_sede = ucfirst(strtolower($request->sede));
        $struttura->codice_provincia = strtoupper($request->codice_provincia);
        $struttura->id_struttura_SANICA = -1;
        $struttura->versione = 2;
        $struttura->save();

        LoggerEvent::log(auth()->user()->id,"Inserimento nuova struttura",$request->all(),false);
        return json_encode(['messaggio'=>'Struttura inserita correttamente',
                            'id'=>$struttura->id,
                            'codice_struttura'=>$struttura->codice_struttura,
                            'codice_sede'=>$struttura->codice_sede,
                            'codice_provincia'=>$struttura->codice_provincia,
                            'struttura'=>$struttura->struttura,
                            'sede'=>$struttura->sede,
                            'provincia'=>$struttura->provincia,
                            'sanica' => $struttura->id_struttura_SANICA]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Struttura  $struttura
     * @return \Illuminate\Http\Response
     */
    public function show(Struttura $struttura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Struttura  $struttura
     * @return \Illuminate\Http\Response
     */
    public function edit(Struttura $struttura)
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
        $struttura = Struttura::find($request->id);
        foreach (Struttura::all() as $s) {
            if($s->id != $struttura->id && $s->struttura == $request->nome && $s->sede == $request->sede && $s->provincia == $request->provincia){
                return response()->json(['error' => 'Errore: struttura gia\' esistente'], 403);
            }
        }


        $s_nome = $struttura->struttura;
        $struttura->motivo = "Sostituito con $request->struttura. Motivo: $request->motivo";
        $struttura->id_utente_cancella = auth()->user()->id;
        $struttura->update();
        $struttura->delete();

        $new_struttura = new Struttura;
        $new_struttura->struttura = $request->struttura;
        $new_struttura->sede = ucfirst(strtolower($request->sede));
        $new_struttura->provincia = strtoupper($request->provincia);
        $new_struttura->codice_struttura = strtoupper($request->codice_struttura);
        $new_struttura->codice_sede = ucfirst(strtolower($request->codice_sede));
        $new_struttura->codice_provincia = strtoupper($request->codice_provincia);
        $new_struttura->id_struttura_SANICA = -1;
        $new_struttura->versione = 2;
        $new_struttura->save();

        LoggerEvent::log(auth()->user()->id,"Modificata struttura $s_nome. Motivo: $request->motivo",$request->all(),false);
        return json_encode(['messaggio'=>'Struttura inserita correttamente',
                            'id'=>$new_struttura->id,
                            'struttura'=>$new_struttura->struttura,
                            'sede'=>$new_struttura->sede,
                            'provincia'=>$new_struttura->provincia,
                            'codice_struttura' => $new_struttura->codice_struttura,
                            'codice_sede' => $new_struttura->codice_sede,
                            'codice_provincia' => $new_struttura->codice_provincia,
                            'sanica' => $new_struttura->id_struttura_SANICA]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $struttura = Struttura::find($request->id);
        if ($struttura == null) {
            return response()->error(['errore' => 'struttura non trovata, riprovare'],403); 
        } 
        $struttura->motivo = $request->motivo;
        $struttura->id_utente_cancella = auth()->user()->id;
        $struttura->update();
        $struttura->delete();

        LoggerEvent::log(auth()->user()->id, "Cancellazione struttura avvenuta correttamente. Motivo: $request->motivo", $request->all(), true);
        return json_encode(['status' => 'ok']);
    }

     /**
     * Function getDataOfStruttura
     * 
     * @param Request $request
     * @param String $struttura
     * 
     * @return $array
     */
    public function getDataOfStruttura(Request $request) 
    {
        $struttura = Struttura::find($request->id_struttura);
        $progetto = Progetto::whereEncrypted('progetto',$request->progetto)->first();
        if($struttura != null && $progetto != null)
        {
            
            $repartiStruttura = StruttRep::join('progetti','progetti.id','strutture_reparti_envass.id_progetto')
                                            ->join('strutture','strutture.id','strutture_reparti_envass.id_struttura')
                                            ->join('reparti','reparti.id','strutture_reparti_envass.id_reparto')
                                            ->join('area_partizione','area_partizione.id','strutture_reparti_envass.id_associazione')
                                            ->where('progetti.id',$progetto->id)
                                            ->where('strutture.id',$struttura->id)
                                            ->select('reparti.*')
                                            ->groupBy('reparti.id')
                                            ->get();        
        }
        else
        {
            $repartiStruttura = Reparto::all();
        }

        return $repartiStruttura;
    }

    /**
     * Function getStrutture
     * 
     * @param Request $request
     * 
     * @return $array
     */
    public function getStrutture(Request $request) 
    {
        if ($request->ajax()) {
            $data = Struttura::select('id','struttura')->distinct('struttura')->where('struttura', 'like', $request->struttura.'%')->where('versione',2)
                ->get();
            
            return json_encode($data);
        }
    }
}
