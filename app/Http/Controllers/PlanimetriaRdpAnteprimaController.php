<?php

namespace App\Http\Controllers;

use App\PlanimetriaRdpAnteprima;
use Illuminate\Http\Request;
use App\Event\LoggerEvent;
use Illuminate\Support\Facades\Log;
use Storage;
class PlanimetriaRdpAnteprimaController extends Controller
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
     * @param  \App\PlanimetriaRdpAnteprima  $planimetriaRdpAnteprima
     * @return \Illuminate\Http\Response
     */
    public function show(PlanimetriaRdpAnteprima $planimetriaRdpAnteprima)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PlanimetriaRdpAnteprima  $planimetriaRdpAnteprima
     * @return \Illuminate\Http\Response
     */
    public function edit(PlanimetriaRdpAnteprima $planimetriaRdpAnteprima)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PlanimetriaRdpAnteprima  $planimetriaRdpAnteprima
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlanimetriaRdpAnteprima $planimetriaRdpAnteprima)
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
        $planimetria = PlanimetriaRdpAnteprima::find($request->id_planimetria);

        if($planimetria == null)
        {
            return response()->json([
                'message' => 'Planimetria non trovata'
            ], 404);
        }
        $planimetria_name = explode('/',$planimetria->planimetria)[count(explode('/',$planimetria->planimetria))-1];
        $rdp_id =  explode('/',$planimetria->planimetria)[count(explode('/',$planimetria->planimetria))-2];
        //delete the image
        if(Storage::disk('public')->exists("planimetrie/$rdp_id/$planimetria_name"))
        {
            Storage::disk('public')->delete("planimetrie/$rdp_id/$planimetria_name");
            //check if the folder id empty
            if(count(Storage::disk('public')->files("planimetrie/$rdp_id")) == 0)
            {
                Storage::disk('public')->deleteDirectory("planimetrie/$rdp_id");
            }
        }
        $planimetria->delete();
        LoggerEvent::log(auth()->user()->id,"Eliminata ",$request->all(),false);
        return response()->json([
            'message' => 'Planimetria eliminata'
        ], 200);
    }
}
