<?php

namespace App\Http\Controllers;

use App\ImmagineMicroAntibiogrammaSwab;
use Illuminate\Http\Request;
use Log;
use Storage;
use App\MicroAntibiogrammaSwab;
use App\TemporaryImage;

class ImmagineMicroAntibiogrammaSwabController extends Controller
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
        //Log::info($request);

        $message = "nok";
        $retval = "nok";
        $path = "";
        
        if($request->hasFile('file'))
        {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();

            Storage::disk('public')->putFileAs("temporary/", $file, $originalName);
            $path = Storage::disk('public')->path("temporary/".$originalName);
            
            $temporaryStore = new TemporaryImage;
            $temporaryStore->code = $request->code;
            $temporaryStore->nome_file = $originalName;
            $temporaryStore->path_file = $path;
            $temporaryStore->tipo = $request->tipo;
            $temporaryStore->save();            

            $retval = "ok";
            $message = "ok";
        }

        return $path;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ImmagineMicroAntibiogrammaSwab  $immagineMicroAntibiogrammaSwab
     * @return \Illuminate\Http\Response
     */
    public function show(ImmagineMicroAntibiogrammaSwab $immagineMicroAntibiogrammaSwab)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ImmagineMicroAntibiogrammaSwab  $immagineMicroAntibiogrammaSwab
     * @return \Illuminate\Http\Response
     */
    public function edit(ImmagineMicroAntibiogrammaSwab $immagineMicroAntibiogrammaSwab)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ImmagineMicroAntibiogrammaSwab  $immagineMicroAntibiogrammaSwab
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImmagineMicroAntibiogrammaSwab $immagineMicroAntibiogrammaSwab)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ImmagineMicroAntibiogrammaSwab  $immagineMicroAntibiogrammaSwab
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImmagineMicroAntibiogrammaSwab $immagineMicroAntibiogrammaSwab)
    {
        //
    }
}
