<?php

namespace App\Http\Controllers;

use App\MicroSuPiastraSwab;
use Illuminate\Http\Request;
use App\Event\LoggerEvent;

class MicroSuPiastraSwabController extends Controller
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
     * @param  \App\MicroSuPiastraSwab  $microSuPiastraSwab
     * @return \Illuminate\Http\Response
     */
    public function show(MicroSuPiastraSwab $microSuPiastraSwab)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MicroSuPiastraSwab  $microSuPiastraSwab
     * @return \Illuminate\Http\Response
     */
    public function edit(MicroSuPiastraSwab $microSuPiastraSwab)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MicroSuPiastraSwab  $microSuPiastraSwab
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MicroSuPiastraSwab $microSuPiastraSwab)
    {
        //
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
            $microsupiastra = MicroSuPiastraSwab::find($request->id);

            if($microsupiastra == null)
            {
                return response()->json(['error' => 'Dati inviati non validi'],403);
            }

            $microsupiastra->delete();

            LoggerEvent::log(auth()->user()->id,"Eliminazione microrganismo da piastra per campione SWAB",$request->all(),false);
        }
        
        return json_encode('Eliminazione effettuata correttamente');
    }
}
