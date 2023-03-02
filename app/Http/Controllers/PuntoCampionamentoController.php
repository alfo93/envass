<?php

namespace App\Http\Controllers;

use App\PuntoCampionamento;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Event\LoggerEvent;
use Illuminate\Validation\Rule;

class PuntoCampionamentoController extends Controller
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
            'nome' => 'required|unique:punti_campionamento,punto_campionamento,NULL,id,deleted_at,NULL',
            'codPC' => 'unique:punti_campionamento,codPC,NULL,id,deleted_at,NULL',
            'id_categoria' => 'required|integer',
            'matrice' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: punto campionamento gia\' esistente'], 403);
        }

        $pc = new PuntoCampionamento;
        $pc->punto_campionamento = $request->nome;
        $pc->codPC = $request->codPC;
        $pc->id_categoria = $request->id_categoria;
        $pc->matrice = $request->matrice;

        $pc->save();

        $categoria_pc = $pc->categoria()->first();

        LoggerEvent::log(auth()->user()->id,"Inserimento nuovo punto campionamento",$request->all(),false);
        return json_encode(['messaggio'=>'Punto campionamento inserito correttamente',
                            'id'=>$pc->id,
                            'nome'=>$pc->punto_campionamento,
                            'codPC' => $pc->codPC,
                            'id_categoria'=>$pc->id_categoria,
                            'matrice' => $pc->matrice,
                            'nome_categoria'=>$categoria_pc->categoria]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PuntoCampionamento  $puntoCampionamento
     * @return \Illuminate\Http\Response
     */
    public function show(PuntoCampionamento $puntoCampionamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PuntoCampionamento  $puntoCampionamento
     * @return \Illuminate\Http\Response
     */
    public function edit(PuntoCampionamento $puntoCampionamento)
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
        Log::info($request);
        $validator = Validator::make($request->all(), [
            'punto_campionamento' => 'required|unique:punti_campionamento,punto_campionamento,'.$request->id.',id,deleted_at,NULL',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: punto campionamento gia\' esistente'], 403);
        }

        $pc = PuntoCampionamento::find($request->id);
        $pc->motivo = "Sostituito con $request->punto_campionamento. Motivo: $request->motivo";
        $pc->id_utente_cancella = auth()->user()->id;
        $pc->update();
        $pc->delete();

        $new_pc = new PuntoCampionamento;
        $new_pc->punto_campionamento = $request->punto_campionamento;
        $new_pc->codPC = $request->codPC;
        $new_pc->id_categoria = $request->id_categoria;
        $new_pc->matrice = $request->matrice;

        $new_pc->save();

        $categoria_pc = $new_pc->categoria()->first();

        LoggerEvent::log(auth()->user()->id,"Modifcato punto campionamento. Motivo: $request->motivo",$request->all(),false);
        return json_encode(['messaggio'=>'Punto campionamento modificato correttamente',
                            'id'=>$new_pc->id,
                            'nome'=>$new_pc->punto_campionamento,
                            'codPC' => $new_pc->codPC,
                            'id_categoria'=>$new_pc->id_categoria,
                            'matrice' => $new_pc->matrice,
                            'nome_categoria'=>$categoria_pc->categoria]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $pc = PuntoCampionamento::find($request->id);
        if ($pc == null) {
            return response()->error(['errore' => 'punto campionamento non trovato, riprovare'],403); 
        } 
        $pc->motivo = $request->motivo;
        $pc->id_utente_cancella = auth()->user()->id;
        $pc->update();
        $pc->delete();

        LoggerEvent::log(auth()->user()->id, "Cancellazione punto campionamento avvenuta correttamente. Motivo cancellazione: $request->motivo", $request->all(), true);
        return json_encode(['status' => 'ok']);
    }
}
