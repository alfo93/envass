<?php

namespace App\Http\Controllers;

use App\MicroAntibiogramma;
use Illuminate\Http\Request;
use Log;
use Storage;
use App\AntibioticoAntibiogramma;
use App\ImmagineMicroAntibiogramma;

class MicroAntibiogrammaController extends Controller
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MicroAntibiogramma  $microAntibiogramma
     * @return \Illuminate\Http\Response
     */
    public function show(MicroAntibiogramma $microAntibiogramma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MicroAntibiogramma  $microAntibiogramma
     * @return \Illuminate\Http\Response
     */
    public function edit(MicroAntibiogramma $microAntibiogramma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MicroAntibiogramma  $microAntibiogramma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MicroAntibiogramma $microAntibiogramma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MicroAntibiogramma  $microAntibiogramma
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        foreach ($request->aa as $key => $value) {
            if($value['id_aa'] != null)
            {
                $aa = AntibioticoAntibiogramma::find($value['id_aa']);
                if($aa != null)
                {
                    //Log::info($aa);
                    $aa->delete();
                } 
            }         
        }

        $microAntibiogramma = MicroAntibiogramma::where('id_campione',$request->id_campione)->where('id_microrganismo',100)->where('NAB',$request->nab)->where('colonia',$request->colonia)->first();
        if($microAntibiogramma != null)
        {
            $microAntibiogramma->delete();
        }

        $immagineAntibiogramma = ImmagineMicroAntibiogramma::where('id_campione',$request->id_campione)->where('nome_file',$request->nome_file)->where('tipo',$request->tipo)->first();
        if($immagineAntibiogramma != null)
        {
            $exists = Storage::disk('public')->exists("eliminati/$immagineAntibiogramma->nome_file");
            if($exists)
            {
                Storage::disk('public')->delete("eliminati/$immagineAntibiogramma->nome_file");
                Storage::disk('public')->move("$request->id_campione/antibiogrammi/$request->nome_file","eliminati/$immagineAntibiogramma->nome_file");
            }
            else
            {
                Storage::disk('public')->move("$request->id_campione/antibiogrammi/$request->nome_file","eliminati/$immagineAntibiogramma->nome_file");
            }
            $immagineAntibiogramma->delete();
        }

        return json_encode('eliminato correttamente');
    }
}
