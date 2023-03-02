<?php

namespace App\Http\Controllers;

use App\Protocollo;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Event\LoggerEvent;
use Illuminate\Validation\Rule;

class ProtocolloController extends Controller
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
            
            'nome' => 'required|unique:protocolli,protocollo,NULL,id,deleted_at,NULL',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: protocollo gia\' esistente'], 403);
        }

        $protocollo = new Protocollo;
        $protocollo->protocollo = $request->nome;

        $protocollo->save();

        LoggerEvent::log(auth()->user()->id,"Inserimento nuovo protocollo",$request->all(),false);
        return json_encode(['messaggio'=>'protocollo inserito correttamente','id'=>$protocollo->id,'nome'=>$protocollo->protocollo]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Protocollo  $protocollo
     * @return \Illuminate\Http\Response
     */
    public function show(Protocollo $protocollo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Protocollo  $protocollo
     * @return \Illuminate\Http\Response
     */
    public function edit(Protocollo $protocollo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Protocollo  $protocollo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Protocollo $protocollo)
    {
        $validator = Validator::make($request->all(), [
            
            'protocollo' => 'required|unique:protocolli,protocollo,NULL,id,deleted_at,NULL'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: protocollo gia\' esistente'], 403);
        }

        $protocollo = Protocollo::find($request->id);
        $p_nome = $protocollo->protocollo;
        if ($protocollo == null) {
            return response()->error(['errore' => 'protocollo non trovato, riprovare'],403); 
        } 
        $protocollo->motivo = "Sostituito con $request->protocollo. Motivo: $request->motivo";
        $protocollo->id_utente_cancella = auth()->user()->id;
        $protocollo->update();
        $protocollo->delete();

        $new_protocollo = new Protocollo;
        $new_protocollo->protocollo = $request->protocollo;

        $new_protocollo->save();

        LoggerEvent::log(auth()->user()->id,"Modificato il protocollo $p_nome. Motivo: $request->motivo",$request->all(),false);
        return json_encode(['messaggio'=>'protocollo modificato correttamente','id' => $new_protocollo->id,'nome' => $new_protocollo->protocollo]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $protocollo = Protocollo::find($request->id);
        if ($protocollo == null) {
            return response()->error(['errore' => 'protocollo non trovato, riprovare'],403); 
        } 
        $protocollo->motivo = $request->motivo;
        $protocollo->id_utente_cancella = auth()->user()->id;
        $protocollo->update();
        $protocollo->delete();

        LoggerEvent::log(auth()->user()->id, "Cancellazione protocollo avvenuta correttamente. Motivo cancellazione: $request->motivo", $request->all(), true);
        return json_encode(['status' => 'ok']);
    }
}
