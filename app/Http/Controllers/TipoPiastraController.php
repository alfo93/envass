<?php

namespace App\Http\Controllers;

use App\TipoPiastra;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Event\LoggerEvent;
use Illuminate\Validation\Rule;
class TipoPiastraController extends Controller
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
            
            'nome' => 'required|unique:tipi_piastre,piastra',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: piastra gia\' esistente'], 403);
        }

        $piastra = new TipoPiastra;
        $piastra->piastra = $request->nome;
        $piastra->superficie = $request->superficie;
        $piastra->tipo = $request->tipo;
        $piastra->abbreviazione = $request->abbreviazione;
        $piastra->versione = 2;

        $piastra->save();

        LoggerEvent::log(auth()->user()->id,"Inserimento nuova piastra",$request->all(),false);
        return json_encode(['messaggio'=>'Piastra inserita correttamente',
                            'id' => $piastra->id,
                            'piastra' => $piastra->piastra,
                            'tipo' => $piastra->tipo,
                            'abbreviazione' => $piastra->abbreviazione,
                            'superficie' => $piastra->superficie]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(TipoPiastra $tipoPiastra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoPiastra  $tipoPiastra
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoPiastra $tipoPiastra)
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
            
            'piastra' => 'required|unique:tipi_piastre,piastra,'.$request->id,
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: piastra gia\' esistente'], 403);
        }

        $piastra = TipoPiastra::find($request->id);
        $p_nome = $piastra->piastra;
        $piastra->motivo = "Sostituito con $request->piastra. Motivo: $request->motivo";
        $piastra->id_utente_cancella = auth()->user()->id;
        $piastra->update();
        $piastra->delete();

        $new_piastra = new TipoPiastra;
        $new_piastra->piastra = $request->piastra;
        $new_piastra->superficie = $request->superficie;
        $new_piastra->tipo = $request->tipo;
        $new_piastra->abbreviazione = $request->abbreviazione;

        $new_piastra->save();

        LoggerEvent::log(auth()->user()->id,"Modificata piastra $p_nome. Motivo: $request->motivo",$request->all(),false);
        return json_encode(['messaggio'=>'Piastra modificata correttamente',
                            'id' => $new_piastra->id,
                            'piastra' => $new_piastra->piastra,
                            'tipo' => $new_piastra->tipo,
                            'abbreviazione' => $new_piastra->abbreviazione,
                            'superficie' => $new_piastra->superficie]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $piastra = TipoPiastra::find($request->id);
        if ($piastra == null) {
            return response()->json(['errore' => 'piastra non trovata, riprovare'],403); 
        } 
        $piastra->motivo = $request->motivo;
        $piastra->id_utente_cancella = auth()->user()->id;
        $piastra->update();
        $piastra->delete();

        LoggerEvent::log(auth()->user()->id, "Cancellazione piastra avvenuta correttamente. Motivo: $request->motivo", $request->all(), true);
        return json_encode(['status' => 'ok']);
    }
}
