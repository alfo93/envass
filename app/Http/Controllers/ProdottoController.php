<?php

namespace App\Http\Controllers;

use App\Prodotto;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Event\LoggerEvent;
use Illuminate\Validation\Rule;

class ProdottoController extends Controller
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
            
            'nome' => 'required|unique:prodotti,prodotto,NULL,id,deleted_at,NULL',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: prodotto gia\' esistente'], 403);
        }

        $prodotto = new Prodotto;
        $prodotto->prodotto = $request->nome;

        $prodotto->save();

        LoggerEvent::log(auth()->user()->id,"Inserimento nuovo prodotto",$request->all(),false);
        return json_encode(['messaggio'=>'Prodotto inserito correttamente','id'=>$prodotto->id,'nome'=>$prodotto->prodotto]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Prodotti  $prodotti
     * @return \Illuminate\Http\Response
     */
    public function show(Prodotti $prodotti)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Prodotti  $prodotti
     * @return \Illuminate\Http\Response
     */
    public function edit(Prodotti $prodotti)
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
            'prodotto' => 'required|unique:prodotti,prodotto,NULL,id,deleted_at,NULL',
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: prodotto gia\' esistente'], 403);
        }

        $prodotto = Prodotto::find($request->id);
        $prodotto->motivo = "Sostituito con $request->prodotto. Motivo: $request->motivo";
        $prodotto->id_utente_cancella = auth()->user()->id;
        $prodotto->update();
        $prodotto->delete();

        $new_prodotto = new Prodotto;
        $new_prodotto->prodotto = $request->prodotto;

        $new_prodotto->save();

        LoggerEvent::log(auth()->user()->id,"Prodotto modificato. Motivo: $request->motivo",$request->all(),false);
        return json_encode(['messaggio'=>'Prodotto modificato correttamente','id'=>$new_prodotto->id,'nome'=>$new_prodotto->prodotto]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $prodotto = Prodotto::find($request->id);
        if ($prodotto == null) {
            return response()->error(['errore' => 'prodotto non trovato, riprovare'],403); 
        } 
        $prodotto->motivo = $request->motivo;
        $prodotto->id_utente_cancella = auth()->user()->id;
        $prodotto->update();
        $prodotto->delete();

        LoggerEvent::log(auth()->user()->id, "Cancellazione prodotto avvenuta correttamente. Motivo: $request->motivo", $request->all(), true);
        return json_encode(['status' => 'ok']);
    }
}
