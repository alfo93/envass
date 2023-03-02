<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Event\LoggerEvent;
use Illuminate\Validation\Rule;
use App\PuntoCampionamento;

class CategoriaController extends Controller
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
            'categoria' => 'required|unique:categorie,categoria,NULL,id,deleted_at,NULL'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: categoria gia\' esistente'], 403);
        }

        $categoria = new Categoria;
        $categoria->categoria = $request->categoria;

        $categoria->save();

        LoggerEvent::log(auth()->user()->id,"Inserimento nuova categoria",$request->all(),false);
        return json_encode(['messaggio'=>'Categoria inserita correttamente','id'=>$categoria->id,'nome'=>$categoria->categoria]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categoria)
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
            'categoria' => 'required|unique:categorie,categoria,NULL,id,deleted_at,NULL'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: categoria gia\' esistente'], 403);
        }

        $categoria = Categoria::find($request->id);
        $categoria->motivo = "Sostituito con $request->categoria";
        $categoria->id_utente_cancella = auth()->user()->id;
        $categoria->update();
        $categoria->delete();

        $new_categoria = new Categoria;
        $new_categoria->categoria = $request->categoria;

        $new_categoria->save();

        LoggerEvent::log(auth()->user()->id,"Categoria modificata correttamente. Motivo della modifica: $request->motivo",$request->all(),false);
        return json_encode(['messaggio'=>'Categoria modificata correttamente','id'=>$new_categoria->id,'nome'=>$new_categoria->categoria]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $categoria = Categoria::find($request->id);
        if ($categoria == null) {
            return response()->error(['errore' => 'materiale non trovato, riprovare'],403); 
        } 
        $categoria->motivo = $request->motivo;
        $categoria->id_utente_cancella = auth()->user()->id;
        $categoria->update();
        $categoria->delete();

        LoggerEvent::log(auth()->user()->id, "Cancellazione categoria avvenuta correttamente. Motivo: $request->motivo", $request->all(), true);
        return json_encode(['status' => 'ok']);
    }

    /**
     * La funzione recupera tutti i punti di campionamento che sono legati ad una specifica categoria
     * 
     * @param Request $request
     * 
     * @return App\PuntoCampionamento $pc
     */
    public function getPC(Request $request)
    {
        $array = Array();
        $categoria = Categoria::find($request->id);

        if($categoria == null)
        {
            return response()->json(['message'=>'Errore dati incosistenti'],403);
        }

        $pc_1 = PuntoCampionamento::where('id_categoria',$categoria->id)->where('matrice','S')->where('versione',2)->select('id','punto_campionamento','codPC')->get();
        $pc_2 = PuntoCampionamento::where('id_categoria',$categoria->id)->where('matrice','E')->where('versione',2)->select('id','punto_campionamento','codPC')->get();
        
        $pc = $pc_1->merge($pc_2);
        
        return $pc;
    }
}
