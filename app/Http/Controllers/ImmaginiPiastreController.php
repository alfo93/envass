<?php

namespace App\Http\Controllers;

use App\ImmaginiPiastre;
use Illuminate\Http\Request;
use Log;
use App\Campione;
use App\TemporaryImage;
use Storage;
use App\Event\LoggerEvent;

class ImmaginiPiastreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        if($request->hasFile('file')){
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $tipo = $request->tipo;

            $newname = "";

            if($tipo == 'piastra2')
            {
                $nomecompleto = explode('.',$originalName);
                $nome = $nomecompleto[0]."_C";
                $estensione = $nomecompleto[1];
                $newname = $nome.".".$estensione;
                $exists = Storage::disk('public')->exists("temporary/$newname");
                if($exists)
                {
                    $nomecompleto = explode('.',$newname);
                    $nome = $nomecompleto[0]."_2";
                    $estensione = $nomecompleto[1];
                    $newname = $nome.".".$estensione;
                    Storage::disk('public')->putFileAs("temporary/", $file, $newname);
                    $path = Storage::disk('public')->path("temporary/".$newname);    
                    
                }
                else
                {
                    Storage::disk('public')->putFileAs("temporary/", $file, $newname);
                    $path = Storage::disk('public')->path("temporary/".$newname);
                }
            }
            else
            {
                $nomecompleto = explode('.',$originalName);
                $nome = $nomecompleto[0]."_P";
                $estensione = $nomecompleto[1];
                $newname = $nome.".".$estensione;
                $exists = Storage::disk('public')->exists("temporary/$newname");
                if($exists)
                {
                    $nomecompleto = explode('.',$newname);
                    $nome = $nomecompleto[0]."_2";
                    $estensione = $nomecompleto[1];
                    $newname = $nome.".".$estensione;
                    Storage::disk('public')->putFileAs("temporary/", $file, $newname);
                    $path = Storage::disk('public')->path("temporary/".$newname);    
                    
                }
                else
                {
                    Storage::disk('public')->putFileAs("temporary/", $file, $newname);
                    $path = Storage::disk('public')->path("temporary/".$newname);
                }
            }
            
          
            $temporaryStore = new TemporaryImage;
            $temporaryStore->code = $request->code;
            $temporaryStore->nome_file = $newname;
            $temporaryStore->path_file = $path;
            $temporaryStore->tipo = $request->tipo;
            $temporaryStore->save();            
            
        }

        return ['path'=>$path,'nome'=> $newname];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ImmaginiPiastra  $immaginiPiastra
     * @return \Illuminate\Http\Response
     */
    public function show(ImmaginiPiastra $immaginiPiastra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ImmaginiPiastra  $immaginiPiastra
     * @return \Illuminate\Http\Response
     */
    public function edit(ImmaginiPiastra $immaginiPiastra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ImmaginiPiastra  $immaginiPiastra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImmaginiPiastra $immaginiPiastra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ImmaginiPiastra  $immaginiPiastra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // Log::info($request);
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
            $image = ImmaginiPiastre::where('id_campione',$id)->where('tipo',$tipo)->first();

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

            $image->motivo_cancella = $motivo;
            $image->id_utente_cancella = auth()->user()->id;
            $image->update();
            $image->delete();

            LoggerEvent::log(auth()->user()->id,"Eliminazione immagine $tipo, Motivo: $motivo",$request->all(),false);
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
