<?php

namespace App\Http\Controllers;

use App\Antibiotico;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Event\LoggerEvent;
use Illuminate\Validation\Rule;

class AntibioticoController extends Controller
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
            
            'nome' => 'required|unique:antibiotici,nome,NULL,id,deleted_at,NULL',
            
        ]);

        // Log::info($request);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: antibiotico gia\' esistente'], 403);
        }

        $antibiotico = new Antibiotico;
        $antibiotico->nome = $request->nome;

        $antibiotico->save();

        LoggerEvent::log(auth()->user()->id,"Inserimento nuovo antibiotico",$request->all(),false);
        return json_encode(['messaggio'=>'Antibiotico inserito correttamente','id'=>$antibiotico->id,'nome'=>$antibiotico->nome]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Antibiotico  $antibiotico
     * @return \Illuminate\Http\Response
     */
    public function show(Antibiotico $antibiotico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Antibiotico  $antibiotico
     * @return \Illuminate\Http\Response
     */
    public function edit(Antibiotico $antibiotico)
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
        $validator = Validator::make($request->all(), [
            
            'nome' => 'required|unique:antibiotici,nome,NULL,id,deleted_at,NULL',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: antibiotico gia\' esistente'], 403);
        }

        $antibiotico = Antibiotico::find($request->id);
        $antibiotico->motivo = "Sostituzione con il nuovo antibiotico: $request->nome";
        $antibiotico->id_utente_cancella = auth()->user()->id;
        $antibiotico->update();
        $antibiotico->delete();

        $new_antibiotico = new Antibiotico;
        $new_antibiotico->nome = $request->nome;
        $new_antibiotico->save();

        LoggerEvent::log(auth()->user()->id, "Antibiotico modificato correttamente. Motivo: ".$request->motivo, $request->all(), true);
        return json_encode(['messaggio'=>'Antibiotico modificato correttamente. Motivo: '.$request->motivo,'id'=>$new_antibiotico->id,'nome'=>$new_antibiotico->nome]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $antibiotico = Antibiotico::find($request->id);
        if ($antibiotico == null) {
            return response()->error(['errore' => 'Antibiotico non trovato, riprovare'],403); 
        } 
        
        $antibiotico->motivo = $request->motivo;
        $antibiotico->id_utente_cancella = auth()->user()->id;
        $antibiotico->update();
        $antibiotico->delete();

        LoggerEvent::log(auth()->user()->id, "Cancellazione antibiotico avvenuta correttamente. Motivo: ".$request->motivo, $request->all(), true);
        return json_encode(['status' => 'ok']);
    }
}
