<?php

namespace App\Http\Controllers;

use App\Procedura;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Progetto;
use Log;
use DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Event\LoggerEvent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProceduraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('procedure.procedure');
    }


    /**
     * Ritorna il contenuto della DataTable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function list(Request $request)
    {
        $procedure = Procedura::leftjoin('progetti', 'progetti.id', '=', 'eprocedure.id_progetto');
        
        $procedure = $procedure->select(['eprocedure.*','progetti.progetto as progetto','progetti.id as id_progetto']);

        return DataTables::of($procedure)
        ->addColumn('pulsante', function ($procedure) {
            $button = '<div class="row">' .
                        '<div class="col-sm-4">' .
                        '<a href="#" id="'. $procedure->id .'" class="btn btn-action btn-primary btn-modifica" data-toggle="modal" data-target="#largeModal">Modifica</a>' .
                        '</div>';
            $button .=   '<div class="row">' .
                        '<div class="col-sm-4">' .
                        '<button id="'. $procedure->id .'" class="btn btn-action btn-danger btn-elimina">Elimina</button>' .
                        '</div>';

            return $button;
        })
        ->editColumn('data_inserimento',function($procedure){
            $data_inserimento = $procedure->created_at->format('d-m-Y');
            return $data_inserimento;
        })
        ->editColumn('progetto',function($procedure){
            $progetto = Progetto::where('id',$procedure->id_progetto)->first();
            if($progetto){
                return $progetto->progetto;
            }else{
                return 'generale';
            }
        })
        ->editColumn('livello',function($procedure){
            return $procedure->getLivello($procedure->livello);
        }) 
        ->editColumn('documento',function($procedure){
            $button = '<div class="row">' .
                        '<div class="col-sm-4">' .
                        '<a href="procedure/' . $procedure->file . '/view" id="'. $procedure->id .'_documento" class="" target="_blank" ><i class="material-icons" style="color:#000">archive</i></a>' .
                        '</div></div>';
            return $button;
        })
        ->filterColumn('progetto', function ($query) use ($request) {
            $keyword = str_replace(' ','%',request()->search['value']);
            $generale = levenshtein(strtolower($keyword), 'generale');
            if($generale < 3)
            {
                $query->where('eprocedure.id_progetto', '=', '0'); 
            }
            else
            {
                $progetto = Progetto::whereEncrypted('progetto', 'like', '%' . $keyword . '%')->first();
                $query->where('progetti.id',$progetto->id ?? ''); 
            }
        })
        ->filterColumn('data_inserimento', function ($query) use ($request) {
            if(strpos(request()->search['value'],'/') !== false)
            {
                $date = explode('/', request()->search['value']);
                $query->where('eprocedure.created_at','like',"%".$date[0]."%");
                for($i=1;$i<count($date);$i++)
                {
                    $query->where('eprocedure.created_at','like',"%".$date[$i]."%");
                }
            }
            else
            {
                $query->where('eprocedure.created_at','like',"%".request()->search['value']."%");
            }        
        })
        ->filterColumn('livello', function ($query) use ($request) {
            $keyword = str_replace(' ','%',request()->search['value']);
            $do = 1;
            foreach (Progetto::all() as $value) {
                $string = levenshtein(strtolower($keyword), strtolower($value->progetto));
                if($string < 15)
                {
                    $do = 0;
                }
            }
            $operativo = levenshtein(strtolower($keyword),'operativo');
            $riservato = levenshtein(strtolower($keyword),'riservato');
            $pubblico= levenshtein(strtolower($keyword),'pubblico');
            if($operativo < 3 || $pubblico < 3 || $riservato < 3)
            {
                $do = 1;
            }
            
            if($do == 1)
            {
                $int = Procedura::livelloCode(strtolower($keyword));
                $query->where('eprocedure.livello', '=', $int);    
            }   
        })
        ->rawColumns(['livello','pulsante','data_inserimento','documento','progetto'])
        ->make(true);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('procedure.create_procedura');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            
            'file' => 'required|file',
            'note' => 'required|string',
            'livello' => 'required|integer',
            'id_progetto' => 'required|integer',
            'file' => 'uniqueCombo:eprocedure,note,livello,id_progetto',
            
        ]);

        if ($validator->fails()) {
            return redirect("/procedure/create")
                            ->withErrors($validator->messages())
                            ->withInput();
        }

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        
        $procedura = new Procedura;
        $procedura->note = $request->note;
        $procedura->livello = $request->livello;
        $procedura->id_progetto = $request->id_progetto;
        $procedura->file = $filename;      
        
        if($request->file('file'))
        {
            Storage::disk('public')->putFileAs("procedure/", $file, $filename);
        }

        if($procedura->id_progetto == 0)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }
        $procedura->save();
        if($procedura->id_progetto == 0)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        return redirect()->route('procedure');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Procedura  $procedura
     * @return \Illuminate\Http\Response
     */
    public function show(Procedura $procedura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if($request->id == null)
        {
            return response()->json(['error'=> 'Dati non validi'],403);
        }
        $procedura = Procedura::find($request->id);   
        if($procedura == null)
        {
            return response()->json('Procedura non trovata, riporvare',403);
        }

        return json_encode(['note' => $procedura->note,'livello' => $procedura->livello,'id_progetto'=>$procedura->id_progetto]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Log::info($request);
        $validator = Validator::make($request->all(), [  
            'note' => 'required|string',
            'livello' => 'required|integer',
            'id_progetto' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect("/procedure")
                            ->withErrors($validator->messages())
                            ->withInput();
        }

        $procedura = Procedura::find($request->id);

        $procedura->note = $request->note ?? $procedura->note;
        $procedura->livello = $request->livello ?? $procedura->livello;
        $procedura->id_progetto = $request->id_progetto ?? $procedura->id_progetto;
        $returnFile = isset($request->filename) ? $request->filename : '';
        if(isset($request->file))
        {
            $file = $request->file;
            $file_parts = pathinfo($request->filename);

            if($file_parts['extension'] != 'pdf')
            {
                $message = "Errore, formato file non valido. Inserire un file pdf";
                return response()->json(['message',$message],403);
            }

            $file = str_replace("data:image/".$file_parts['extension'].";base64,", "", $file);
            $file = str_replace(' ', '+', $file);
            
            if(Storage::disk('public')->exists("procedure/$file"))
            {
                $message = "Errore, file inserito già presente in archivio. Ricontrollare";
                return response()->json(['message',$message],403);        
            }

            Storage::disk('public')->delete("/procedure/$procedura->file");

            $procedura->file = $request->filename;

            Storage::disk('public')->putFileAs("procedure/", $file, $request->filename);

        }

        if($request->id_progetto == 0)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }
        $procedura->save();
        if($request->id_progetto == 0)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        return json_encode(['success' => 'Procedura modificata correttamente','file' => $returnFile]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Procedura  $procedura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $procedura = Procedura::find($request->id);

        if($procedura == null)
        {
            $message = "Impossibile eliminare il messaggio, procedura non trovata";
            return response()->json(['message' => $message],403);
        }

        $filename = $procedura->file;

        if($filename == null)
        {
            $message = "Attenzione, errore di incosistenza dati, nome file non presente in archivio";
            return response()->json(['message' => $message],403);
        }

        if(!Storage::disk('public')->exists("procedure/$filename"))
        {
            $message = "Impossibile eliminare il documento, file non trovato";
            return response()->json(['message' => $message],403);
        }

        Storage::disk('public')->delete("procedure/$filename");

        $procedura->delete();

        return json_encode(['ok' => 'procedura eliminata correttamente']);
    }
}
