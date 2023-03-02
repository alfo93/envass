<?php

namespace App\Http\Controllers;

use App\MicrorganismoPiastra;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Event\LoggerEvent;
use Illuminate\Validation\Rule;

class MicrorganismoPiastraController extends Controller
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
            'nome' => 'required|unique:microrganismi_piastre,microrganismo,NULL,id,deleted_at,NULL',
            'gruppo' => 'required',
            'gram' => 'required',
            'entbac' => 'required',
            'colif' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: microrganismo gia\' esistente'], 403);
        }

        $microrganismo = new MicrorganismoPiastra;
        $microrganismo->microrganismo = $request->nome;
        $microrganismo->batGramN = $request->gram == "positivo" ? 0 : 1;
        $microrganismo->batGramP = $request->gram == "positivo" ? 1 : 0;
        $microrganismo->entBac = $request->entbac == "si" ? 1 : 0;
        $microrganismo->colif = $request->colif == "si" ? 1 : 0;
        $microrganismo->id_microrganismo_SANICA = -1;
        $microrganismo->gruppo = $request->gruppo;

        $microrganismo->save();

        LoggerEvent::log(auth()->user()->id,"Inserimento nuovo microrganismo",$request->all(),false);
        return json_encode(['messaggio'=>'microrganismo inserito correttamente',
                            'id' => $microrganismo->id,
                            'nome' => $microrganismo->microrganismo, 
                            'batGram' => $microrganismo->batGramP == 1 ? 'positivo' : 'negativo',
                            'entbac' => $microrganismo->entBac, 
                            'colif' => $microrganismo->colif, 
                            'sanica' => $microrganismo->id_microrganismo_SANICA,
                            'gruppo' => $microrganismo->gruppo]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MicrorganismoPiastra  $microrganismoPiastra
     * @return \Illuminate\Http\Response
     */
    public function show(MicrorganismoPiastra $microrganismoPiastra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MicrorganismoPiastra  $microrganismoPiastra
     * @return \Illuminate\Http\Response
     */
    public function edit(MicrorganismoPiastra $microrganismoPiastra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MicrorganismoPiastra  $microrganismoPiastra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MicrorganismoPiastra $microrganismoPiastra)
    {
        $validation = MicrorganismoPiastra::where('id','!=',$request->id)
                        ->where('microrganismo',$request->microrganismo)
                        ->where('deleted_at',NULL)
                        ->where('entbac',$request->entbac == "si" ? 1 : 0)
                        ->where('colif',$request->colif == "si" ? 1 : 0)
                        ->where('gruppo',$request->gruppo)
                        ->where('batGramP',$request->gram == "positivo" ? 1 : 0)
                        ->where('batGramN',$request->gram == "positivo" ? 0 : 1)
                        ->first();
                        
        if($validation != null){
            return response()->json(['error' => 'Errore: microrganismo gia\' esistente'], 403);
        }

        $microrganismo = MicrorganismoPiastra::find($request->id);
        $microrganismo->motivo = "Sostituito con $request->microrganismo";
        $microrganismo->id_utente_cancella = auth()->user()->id;
        $microrganismo->update();
        $microrganismo->delete();

        $new_microrganismo = new MicrorganismoPiastra;
        $new_microrganismo->microrganismo = $request->microrganismo;
        $new_microrganismo->batGramN = $request->gram == "positivo" ? 0 : 1;
        $new_microrganismo->batGramP = $request->gram == "positivo" ? 1 : 0;
        $new_microrganismo->entBac = $request->entbac == "si" ? 1 : 0;
        $new_microrganismo->colif = $request->colif == "si" ? 1 : 0;
        $new_microrganismo->id_microrganismo_SANICA = -1;
        $new_microrganismo->gruppo = $request->gruppo;

        $new_microrganismo->save();

        LoggerEvent::log(auth()->user()->id,"Modificato microrganismo. Motivo: $request->motivo",$request->all(),false);
        return json_encode(['messaggio'=>'microrganismo modificato correttamente',
                            'id' => $new_microrganismo->id,
                            'nome' => $new_microrganismo->microrganismo, 
                            'batGram' => $new_microrganismo->batGramP == 1 ? 'positivo' : 'negativo',
                            'entbac' => $new_microrganismo->entBac, 
                            'colif' => $new_microrganismo->colif, 
                            'sanica' => $new_microrganismo->id_microrganismo_SANICA,
                            'gruppo' => $new_microrganismo->gruppo]);
    }

    /**
     * Crea raggruppamento microrganismi per Gram+ Gram- coli e enterobacteriacae
     * 
     * @param NULL
     * @return \Illumniate\Http\Response
     */
    public function getGroup()
    {
        $BGN = Array();
        $BGP = Array();
        $EB = Array();
        $COL = Array();

        $BGN = MicrorganismoPiastra::where('batGramN',1)->get();
        $BGP = MicrorganismoPiastra::where('batGramP',1)->get();
        $EB = MicrorganismoPiastra::where('entBac',1)->get();
        $COL = MicrorganismoPiastra::where('colif',1)->get();

        return json_encode(['BGN' => $BGN, 'BGP' => $BGP, 'EB' => $EB, 'COL' => $COL]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $microrganismo = MicrorganismoPiastra::find($request->id);
        if ($microrganismo == null) {
            return response()->error(['errore' => 'Microrganismo non trovato, riprovare'],403); 
        } 
        
        $microrganismo->motivo = $request->motivo;
        $microrganismo->id_utente_cancella = auth()->user()->id;
        $microrganismo->update();
        $microrganismo->delete();

        LoggerEvent::log(auth()->user()->id, "Cancellazione microrganismo avvenuta correttamente. Motivo: $request->motivo", $request->all(), true);
        return json_encode(['status' => 'ok']);
    }
}
