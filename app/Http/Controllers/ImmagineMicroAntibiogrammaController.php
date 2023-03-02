<?php

namespace App\Http\Controllers;

use App\ImmagineMicroAntibiogramma;
use Illuminate\Http\Request;
use Log;
use Storage;
use App\MicroAntibiogramma;
use App\TemporaryImage;

class ImmagineMicroAntibiogrammaController extends Controller
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
     * @param  \App\ImmagineMicroAntibiogramma  $immagineMicroAntibiogramma
     * @return \Illuminate\Http\Response
     */
    public function show(ImmagineMicroAntibiogramma $immagineMicroAntibiogramma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ImmagineMicroAntibiogramma  $immagineMicroAntibiogramma
     * @return \Illuminate\Http\Response
     */
    public function edit(ImmagineMicroAntibiogramma $immagineMicroAntibiogramma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ImmagineMicroAntibiogramma  $immagineMicroAntibiogramma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImmagineMicroAntibiogramma $immagineMicroAntibiogramma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $tabella = $request->tipoTabella;
        $tipo = $request->tipoFoto;
        $motivo = $request->motivo;

        if($id == null)
        {
            return response()->json(['error'=>"Errore nell'eliminazione dell'immagine"],403);
        }

        if($tabella == 'campioni')
        {
            $image = ImmaginiMicroAntibiogrammiController::where('id_campione',$id)->where('tipo',$tipo)->first();

            if($image == null)
            {
                return response()->json(['error'=>"Errore: immagine non trovata"],403);
            }
            $i = 0;
            $nome = $image->nome_file;
            while(1){
                if(!Storage::disk('public')->exists("eliminati/$nome")){
                    //Storage::disk('public')->delete($id/$nome);
                    Storage::disk('public')->move("$id/$image->nome_file","eliminati/$nome" );
                    break;
                }else{
                    $i++;
                    $nomemodificato = explode('.',$nome);
                    $nome_file = $nomemodificato[0]."($i)";
                    $estensione = $nomemodificato[1];
                    $nome = $nome_file.".".$estensione;
                }
            }

            $image->motivo = $motivo;
            $image->id_utente_cancella = auth()->user()->id;
            $image->update();
            $image->delete();

            LoggerEvent::log(auth()->user()->id,"Eliminazione immagine $tipo, Motivo: $Motivo",$request->all(),false);
        }
        else //temporary
        {
            $image = TemporaryImage::where('code',$id)->where('tipo',$tipo)->first();
            if($image == null)
            {
                return response()->json(['error'=>"Errore: immagine non trovata"],403);
            }

            $i = 0;
            $nome = $image->nome_file;
            while(1){
                if(!Storage::disk('public')->exists("eliminati/$nome")){
                    //Storage::disk('public')->delete(temporary/$nome);
                    Storage::disk('public')->move("temporary/$image->nome_file","eliminati/$nome" );
                    break;
                }else{
                    $i++;
                    $nomemodificato = explode('.',$nome);
                    $nome_file = $nomemodificato[0]."($i)";
                    $estensione = $nomemodificato[1];
                    $nome = $nome_file.".".$estensione;
                }
            }

            $image->delete();            
        }

        return json_encode('eliminazione effettuata correttamente');
    }
}
