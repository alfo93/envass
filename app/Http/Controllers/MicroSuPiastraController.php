<?php

namespace App\Http\Controllers;

use App\MicroSuPiastra;
use App\MicrorganismoPiastra;
use Illuminate\Http\Request;
use App\Event\LoggerEvent;
use Log;

class MicroSuPiastraController extends Controller
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
       //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MicroSuPiastra  $microSuPiastra
     * @return \Illuminate\Http\Response
     */
    public function show(MicroSuPiastra $microSuPiastra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MicroSuPiastra  $microSuPiastra
     * @return \Illuminate\Http\Response
     */
    public function edit(MicroSuPiastra $microSuPiastra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MicroSuPiastra  $microSuPiastra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MicroSuPiastra $microSuPiastra)
    {
        //
    }

    /**
     * Recupera le informazioni di un microrganismo su piastra
     *
     * @param  Request $request
     * 
     * @return \Illuminate\Http\Response
     * @return String $descrizione
     * @return Integer $id
     * @return String messaggio
     * @return Float cfu per aria
     * @return Float cfu per superficie
     */
    public function getMicro(Request $request)
    {
        if($request->id_microrganismo == null || $request->id_tipopiastra == null || $request->cfu == null)
        {
            return response()->json(['error' => 'Inserire correttamente tutti i campi'], 403);
        }

        $microrganismo = MicrorganismoPiastra::find($request->id_microrganismo);
 
        
        $cfu_m_s = ($request->cfu/23.75*10000);
        $cfu_m_s = $microrganismo->toFixed($cfu_m_s,2);
        
        $cfu_m_a = ($request->cfu);

        $cfu_h = ($request->cfu);

        $rangeSx = null;
        $rangeDx = null;
        if($request->incertezza == 'true' && ($request->u != null || $request->u != ""))
        {
            #formula incertezza è 10^(log10(cfu)-u) per il range sinistro, 10^(log10(cfu)+u) per il range destro
            $rangeSx = $microrganismo->toFixed(pow(10,$microrganismo->toFixed(log10($request->cfu)-$request->u,2)),0);
            $rangeDx = $microrganismo->toFixed(pow(10,$microrganismo->toFixed(log10($request->cfu)+$request->u,2)),0);
            
        }
        
        //LoggerEvent::log(auth()->user()->id,"Inserimento nuovo microrganismo su piastra",$request->all(),false);
        return json_encode(['messaggio' => 'Inserimento effettuato correttamente', 'id' => $request->id_microrganismo, 'nome_microrganismo' => $microrganismo->microrganismo,'cfu_s' => $cfu_m_s." CFU/m²", 'cfu_a' => $cfu_m_a . " CFU/m³",'cfu_h' => $cfu_h . " CFU/4h",'incertezzaSx' => $rangeSx,'incertezzaDx' => $rangeDx, 'cfu' => $request->cfu]);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if($request->deletable == 1)
        {
            $microsupiastra = MicroSuPiastra::find($request->id);

            if($microsupiastra == null)
            {
                return response()->json(['error' => 'Dati inviati non validi'],403);
            }

            $microsupiastra->delete();

            LoggerEvent::log(auth()->user()->id,"Eliminazione microrganismo da piastra",$request->all(),false);
        }
        
        return json_encode('Eliminazione effettuata correttamente');
    }
}
