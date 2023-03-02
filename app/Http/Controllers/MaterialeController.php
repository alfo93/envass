<?php

namespace App\Http\Controllers;

use App\Materiale;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Event\LoggerEvent;
use Illuminate\Validation\Rule;

class MaterialeController extends Controller
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
            
            'nome' => 'required|unique:materiali,materiale,NULL,id,deleted_at,NULL',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: materiale gia\' esistente'], 403);
        }

        $materiale = new Materiale;
        $materiale->materiale = $request->nome;

        $materiale->save();

        LoggerEvent::log(auth()->user()->id,"Inserimento nuovo materiale",$request->all(),false);
        return json_encode(['messaggio'=>'Materiale inserito correttamente','id'=>$materiale->id,'nome'=>$materiale->materiale]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Materiale  $materiale
     * @return \Illuminate\Http\Response
     */
    public function show(Materiale $materiale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Materiale  $materiale
     * @return \Illuminate\Http\Response
     */
    public function edit(Materiale $materiale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materiale  $materiale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Materiale $materiale)
    {
        $validator = Validator::make($request->all(), [
            
            'materiale' => 'required|unique:materiali,materiale,NULL,id,deleted_at,NULL',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: materiale gia\' esistente'], 403);
        }

        $materiale = Materiale::find($request->id);
        $materiale->motivo = "Sostituzione con $request->materiale";
        $materiale->id_utente_cancella = auth()->user()->id;
        $materiale->update();
        $materiale->delete();

        $new_materiale = new Materiale;
        $new_materiale->materiale = $request->materiale;
        $new_materiale->save();
        //Log::info($materiale);

        LoggerEvent::log(auth()->user()->id,"Modifica del materiale $request->materiale. Motivo: $request->motivo",$request->all(),false);
        return json_encode(['messaggio'=>'Materiale modificato correttamente','id'=>$new_materiale->id,'nome'=>$new_materiale->materiale]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $materiale = Materiale::find($request->id);
        if ($materiale == null) {
            return response()->error(['errore' => 'materiale non trovato, riprovare'],403); 
        } 
        $materiale->motivo = $request->motivo;
        $materiale->id_utente_cancella = auth()->user()->id;
        $materiale->update();
        $materiale->delete();

        LoggerEvent::log(auth()->user()->id, "Cancellazione materiale avvenuta correttamente. Motivo: ".$request->motivo, $request->all(), true);
        return json_encode(['status' => 'ok']);
    }
}
