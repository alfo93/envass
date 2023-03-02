<?php

namespace App\Http\Controllers;

use App\Reparto;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Event\LoggerEvent;
use Illuminate\Validation\Rule;

class RepartoController extends Controller
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
            'nome' => 'required|unique:reparti,partizione,NULL,id,deleted_at,NULL',            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: partizione gia\' esistente'], 403);
        }

        $reparto = new Reparto;
        $reparto->partizione = $request->nome;
        $reparto->codice_partizione = $request->codice;

        $reparto->save();

        LoggerEvent::log(auth()->user()->id,"Inserimento nuova partizione",$request->all(),false);
        return json_encode(['messaggio'=>'Partizione inserita correttamente','id'=>$reparto->id,'partizione'=>$reparto->partizione,'codice' => $reparto->codice_partizione]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reparto  $reparto
     * @return \Illuminate\Http\Response
     */
    public function show(Reparto $reparto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reparto  $reparto
     * @return \Illuminate\Http\Response
     */
    public function edit(Reparto $reparto)
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
            
            'reparto' => 'required|unique:reparti,partizione,'.$request->id.',id,deleted_at,NULL',            
        ]);

        $reparto = Reparto::find($request->id);
        $reparto->motivo = "Sostituito con $request->reparto. Motivo: $request->motivo";
        $reparto->id_utente_cancella = auth()->user()->id;
        $reparto->update();
        $reparto->delete();

        $new_reparto = new Reparto;
        $new_reparto->partizione = $request->reparto;
        $new_reparto->codice_partizione = $request->codice;
        $new_reparto->save();

        LoggerEvent::log(auth()->user()->id,"Modificato correttamente la partizione. Motivo: $request->motivo",$request->all(),false);
        return json_encode(['messaggio'=>'Partizione modificata correttamente','id'=>$new_reparto->id,'reparto'=>$new_reparto->partizione, 'codice' => $new_reparto->codice_partizione]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $reparto = Reparto::find($request->id);
        if ($reparto == null) {
            return response()->error(['errore' => 'partizione non trovata, riprovare'],403); 
        } 
        $reparto->motivo = $request->motivo;
        $reparto->id_utente_cancella = auth()->user()->id;
        $reparto->update();
        $reparto->delete();

        LoggerEvent::log(auth()->user()->id, "Cancellazione partizione avvenuta correttamente. Motivo: $request->motivo", $request->all(), true);
        return json_encode(['status' => 'ok']);
    }

    /**
     * Search the specified resource from storage
     * 
     * @param Request $request
     * @return Reparto $reparto
     */
    public function getReparti(Request $request)
    {
        if ($request->ajax()) {
            $data = Reparto::select('id','partizione')->distinct('partizione')->where('partizione', 'like', $request->partizione.'%')->where('versione',2)->get();
            
            return json_encode($data);
        }
    }

    /**
     * Search the specified resource from storage
     * 
     * @param Request $request
     * @return Reparto $reparto
     */
    public function getReparto(Request $request)
    {
        $reparto = Reparto::find($request->id);
        return json_encode(['reparto' => $reparto]);
    }
}
