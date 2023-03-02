<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MicroPiastra;
use App\MicrorganismoPiastra;
use Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Event\LoggerEvent;
use App\TipoPiastra;
use Illuminate\Validation\Rule;

class MicroPiastraController extends Controller
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
            'id_microrganismo' => 'uniqueCombo:micro_piastre,id_piastra',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: assegnamento gia\' esistente'], 403);
        }

        $mp = new MicroPiastra;
        $mp->id_microrganismo = $request->id_microrganismo;
        $mp->id_piastra = $request->id_piastra;
        $mp->versione = 2;
        $mp->save();

        LoggerEvent::log(auth()->user()->id,"Inserito nuovo assegnamento microrganismo-piastra",$request->all(),false);
        return json_encode(['messaggio'=>'Assegnamento inserito correttamente','id'=> $mp->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Retrieve Micro of Piastra
     */
    public function getMicro(Request $request)
    {
        $micropiastra = MicroPiastra::where('id_piastra',$request->id)->get();
        $micro = Array();
        if($micropiastra == null)
        {
            return response()->json(['error' => 'Nessun microrganismo corrispondente alla piastra trovato'],403);
        }

        foreach ($micropiastra as $value) {
            $microrganismo = MicrorganismoPiastra::find($value->id_microrganismo);
            if($microrganismo != null)
            {
                array_push($micro,$microrganismo);
            }
        }

        return json_encode(['microrganismo' => $micro]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $micro_piastra = MicroPiastra::where('id','!=',$request->id)
                        ->where('id_microrganismo',$request->id_microrganismo)
                        ->where('id_piastra',$request->id_piastra);

        if ($micro_piastra->count() > 0) {
            return response()->json(['error' => 'Errore: Assegnamento gia\' esistente'], 403);
        }

        /**
         * Verifico che ci siano dei valori che sono effettivamente cambiati. Se non sono cambiati ritorno senza fare nulla
         */
        $micro_piastra = MicroPiastra::find($request->id);

        if($micro_piastra == null)
        {
            return response()->json(['error' => 'Errore: Microrganismo piastra inesistente'], 403);
        }

        if($micro_piastra->id_microrganismo == $request->id_microrganismo && $micro_piastra->id_piastra == $request->id_piastra)
        {
            return json_encode(['messaggio'=>'Nessun cambiamento'],200);
        }

        $micro = MicrorganismoPiastra::find($request->id_microrganismo);
        $piastra = TipoPiastra::find($request->id_piastra);

        if($micro == null)
        {
            return response()->json(['error' => 'Errore: Microrganismo inesistente'], 403);
        }
        if($piastra == null)
        {
            return response()->json(['error' => 'Errore: Piastra inesistente'], 403);
        }
        
        $micro_piastra->motivo = "Sostituzione con il nuovo assegnamento: $micro->microrganismo - $piastra->piastra. Motivo: $request->motivo";
        $micro_piastra->id_utente_cancella = auth()->user()->id;
        $micro_piastra->update();
        $micro_piastra->delete();

        $new_mp = new MicroPiastra;
        $new_mp->id_microrganismo = $micro->id;
        $new_mp->id_piastra = $piastra->id;
        $new_mp->versione = 2;
        $new_mp->save();

        LoggerEvent::log(auth()->user()->id, "Assegnamento Microrganismo - Piastra modificato correttamente. Motivo: ".$request->motivo, $request->all(), true);
        return json_encode(['messaggio'=>'Assegnamento Microrganismo - Piastra modificato correttamente. Motivo: '.$request->motivo,
        'id'=>$new_mp->id,
        'nome_microrganismo' => $micro->microrganismo,
        'nome_piastra' => $piastra->piastra]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $mp = MicroPiastra::find($request->id);
        if ($mp == null) {
            return response()->error(['errore' => 'Assegnamento Microrganismo - Piastra non trovato, riprovare'],403); 
        } 
        
        $mp->motivo = $request->motivo;
        $mp->id_utente_cancella = auth()->user()->id;
        $mp->update();
        $mp->delete();

        LoggerEvent::log(auth()->user()->id, "Cancellazione assrgnamento Microrganismo - Piastra avvenuta correttamente. Motivo: ".$request->motivo, $request->all(), true);
        return json_encode(['status' => 'ok']);
    }
}
