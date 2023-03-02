<?php

namespace App\Http\Controllers;

use App\Stanza;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Event\LoggerEvent;
use Illuminate\Validation\Rule;

class StanzaController extends Controller
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
            'nome' => 'required|unique:stanze,stanza',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: stanza gia\' esistente'], 403);
        }

        $stanza = new Stanza;
        $stanza->stanza = $request->nome;

        $stanza->save();

        LoggerEvent::log(auth()->user()->id,"Inserimento nuova stanza",$request->all(),false);
        return json_encode(['messaggio'=>'Stanza inserita correttamente','id'=>$stanza->id,'stanza'=>$stanza->stanza]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stanza  $stanza
     * @return \Illuminate\Http\Response
     */
    public function show(Stanza $stanza)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stanza  $stanza
     * @return \Illuminate\Http\Response
     */
    public function edit(Stanza $stanza)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stanza' => [
                'required',
                Rule::unique('stanze')->ignore($request->id),
            ],        
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: stanza gia\' esistente'], 403);
        }

        $stanza = Stanza::find($request->id);
        $s_nome = $stanza->stanza;
        $stanza->motivo = "Sostituito con $request->stanza. Motivo: $request->motivo";
        $stanza->id_utente_cancella = auth()->user()->id;
        $stanza->update();
        $stanza->delete();

        $new_stanza = new Stanza;
        $new_stanza->stanza = $request->stanza;
        $new_stanza->save();

        LoggerEvent::log(auth()->user()->id,"Modificata stanza $s_nome. Motivo: $request->motivo",$request->all(),false);
        return json_encode(['messaggio'=>'Stanza modificata correttamente','id'=>$new_stanza->id,'stanza'=>$new_stanza->stanza]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $stanza = Stanza::find($request->id);
        if ($stanza == null) {
            return response()->error(['errore' => 'stanza non trovata, riprovare'],403); 
        } 
        $stanza->motivo = $request->motivo;
        $stanza->id_utente_cancella = auth()->user()->id;
        $stanza->update();
        $stanza->delete();

        LoggerEvent::log(auth()->user()->id, "Cancellazione stanza avvenuta correttamente. Motivo: $request->motivo", $request->all(), true);
        return json_encode(['status' => 'ok']);
    }
}
