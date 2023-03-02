<?php

namespace App\Http\Controllers;

use App\AreaPartizione;
use Illuminate\Http\Request;

class AreaPartizioneController extends Controller
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
     * @param  \App\AreaPartizione  $areaPartizione
     * @return \Illuminate\Http\Response
     */
    public function show(AreaPartizione $areaPartizione)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AreaPartizione  $areaPartizione
     * @return \Illuminate\Http\Response
     */
    public function edit(AreaPartizione $areaPartizione)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AreaPartizione  $areaPartizione
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AreaPartizione $areaPartizione)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AreaPartizione  $areaPartizione
     * @return \Illuminate\Http\Response
     */
    public function destroy(AreaPartizione $areaPartizione)
    {
        //
    }

    /**
     * Retrieve the specified resource from storage.
     */
    public function getAreaPart(Request $request)
    {
        $areaPart = AreaPartizione::find($request->id);
        if($areaPart == null)
        {
            return response()->json(['error' => 'Area partizione not found'], 404);
        }

        return json_encode(["area_partizione" => $areaPart->area_partizione, "codice_area_partizione" => $areaPart->codice_area_partizione]);
    }

    /**
     * Retrieve the all resources from storage.
     */
    public function getAll(Request $request)
    {
        if ($request->ajax()) {
            $data = AreaPartizione::select('id','id_reparto','area_partizione')->where('area_partizione', 'like', $request->areapartizione.'%')
                ->get();
            
            return json_encode($data);
        }
    }

    /**
     * Retrieve the specified resource from storage.
     */
    public function get(Request $request)
    {
        $areaPart = AreaPartizione::where('id_reparto',$request->id_reparto)->where('area_partizione',$request->area_partizione)->first();

        return json_encode(["area_partizione" => $areaPart]);
    }
}
