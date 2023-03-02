<?php

namespace App\Http\Controllers;

use App\SpeciazioneCampione;
use App\MicrorganismoPiastra;
use Illuminate\Http\Request;
use App\Event\LoggerEvent;
use Log;

class SpeciazioneCampioneController extends Controller
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
    public function getMicroSpeciazione(Request $request)
    {
        //Log::info($request);
        if($request->id_microrganismo == null || $request->id_tipopiastra == null)
        {
            return response()->json(['error' => 'Inserire correttamente tutti i campi'], 403);
        }

        $microrganismo = MicrorganismoPiastra::find($request->id_microrganismo);

        if($microrganismo == null)
        {
            return response()->json(['error' => 'Microrganismo non trovato'], 403);
        }

        $esito = isset($request->speciazione_risultato) && $request->speciazione_risultato != null ? $request->speciazione_risultato : '/';

        $descrizione = $microrganismo->microrganismo . " - Esito: " . $esito;

        //LoggerEvent::log(auth()->user()->id,"Inserimento nuovo microrganismo su piastra",$request->all(),false);
        return json_encode(['messaggio' => 'Inserimento effettuato correttamente', 'descrizione' => $descrizione, 'id' => $request->id_microrganismo, 'esito' => $esito, 'tipoCamp' => $request->tipoCamp]);
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
     * @param  \App\SpeciazioneCampione  $speciazioneCampione
     * @return \Illuminate\Http\Response
     */
    public function show(SpeciazioneCampione $speciazioneCampione)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SpeciazioneCampione  $speciazioneCampione
     * @return \Illuminate\Http\Response
     */
    public function edit(SpeciazioneCampione $speciazioneCampione)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SpeciazioneCampione  $speciazioneCampione
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SpeciazioneCampione $speciazioneCampione)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if($request->deletable == 1)
        {
            $speciazione_campione = SpeciazioneCampione::find($request->id);

            if($speciazione_campione == null)
            {
                return response()->json(['error' => 'Dati inviati non validi'],403);
            }

            $speciazione_campione->delete();

            LoggerEvent::log(auth()->user()->id,"Eliminazione microrganismo da identificazione specie patogena per il campione $speciazione_campione->id_campione",$request->all(),false);
        }
        
        return json_encode('Eliminazione effettuata correttamente');
    }
}
