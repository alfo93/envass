<?php

namespace App\Http\Controllers;

use App\AntibioticoAntibiogramma;
use Illuminate\Http\Request;

class AntibioticoAntibiogrammaController extends Controller
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
     * @param  \App\AntibioticoAntibiogramma  $antibioticoAntibiogramma
     * @return \Illuminate\Http\Response
     */
    public function show(AntibioticoAntibiogramma $antibioticoAntibiogramma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AntibioticoAntibiogramma  $antibioticoAntibiogramma
     * @return \Illuminate\Http\Response
     */
    public function edit(AntibioticoAntibiogramma $antibioticoAntibiogramma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AntibioticoAntibiogramma  $antibioticoAntibiogramma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AntibioticoAntibiogramma $antibioticoAntibiogramma)
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
        if($request->id == null || $request->deletable == null)
        {
            return response()->json(['Errore' => 'Dati inviati non validi'],403);
        }

        if($request->deletable == 1)
        {
            $aa = AntibioticoAntibiogramma::find($request->id);
            if($aa == null)
            {
                return response()->json(['Errore' => 'Antibiotico resistenza non trovata, riprovare'],403);
            }
            $aa->delete();
        }

        return json_encode('Antibiotico resistenza eliminata correttamente');
    }
}
