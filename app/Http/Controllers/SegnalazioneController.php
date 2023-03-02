<?php

namespace App\Http\Controllers;

use App\Segnalazione;
use Illuminate\Http\Request;
//use Yajra\DataTables\DataTables;
use Log;
use Storage;
class SegnalazioneController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $segnalazioni = Segnalazione::latest('id')
                                    ->get(['id', 'messaggio', 'data', 'controllato', 'codice']);

        // aggiungi il titolo in base al codice
        $titoli = Segnalazione::get_titoli();
        foreach ($segnalazioni as $segnalazione) {
            $segnalazione['titolo'] = $titoli[$segnalazione['codice']];            
        }

        return view('segnalazioni.segnalazioni_flusso', compact('segnalazioni'));
    }

    /**
     * Ritorna il contenuto della DataTable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    /*public function list(Request $request)
    {
        $data = Segnalazione::get(['id', 'messaggio', 'data', 'controllato']);

        return DataTables::of($data)->toJson();
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JSON
     */
    public function update(Request $request, $id)
    {
        $array = [
            'controllato' => '1',
        ];
        Segnalazione::whereId($id)->update($array);

        return json_encode('aggiornato');
    }
}
