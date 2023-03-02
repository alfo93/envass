<?php

namespace App\Http\Controllers;

use App\Societa;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Event\LoggerEvent;
use Illuminate\Validation\Rule;
use App\Progetto;

class SocietaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $societa_progetti = collect([]);
        foreach (Societa::all() as $s) {
            $nome_societa = $s->nome;
            $totale = Societa::join('progetti','societa.id','=','progetti.id_societa')
                                ->where('societa.id',$s->id)
                                ->where('progetti.versione',2)
                                ->count(); 
            
            $societa_progetti->push(['nome_societa' => $nome_societa, 'tot_progetti' => $totale]);
        }
                                        
        return view('clienti.index', compact('societa_progetti'));
    }

     /**
     * @param Request $request
     * @param String $progetto
     *
     * @return query query per riempimento tabella progetti in index schede_campionamento
     */
    public function list(Request $request)
    {
        $data = Societa::whereNull('deleted_at')->select([
            'societa.id',
            'societa.nome',
            'societa.indirizzo',
            'societa.email',
            'societa.contratto'
        ]);

        return DataTables::of($data)
            ->addColumn('azione',function($data) {
                $button = '<div class="row">' . '<div class="col-sm-12">';
                $button .=  '<a href=""  class="btn btn-small btn-action btn-primary modifica-cliente" id="' . $data->id . '" data-toggle="modal" data-target="#ModalModificaCliente"  value="Modifica" ">Modifica</a>';
                            
                $button.= 
                            '<a class="btn btn-small btn-action button-elimina btn-danger btn-elimina" id="'.$data->id.'"  data-toggle="modal"data-target="#deleteModal">Elimina</a>';
                $button .= '</div>' . '</div>';

                return $button;
            })
            ->editColumn('file',function($data){
                $button = '<div class="row">' .
                        '<div class="col-sm-4">';

                if($data->contratto != null || $data->contratto != "")
                {
                    $button .= '<a href="committenti/' . $data->contratto . '/view" id="'. $data->id .'_documento" class="" target="_blank" ><i class="material-icons" style="color:#000">archive</i></a>';

                }
                else
                {
                    $button .= '<a href="javascript:void(0)" id="'. $data->id .'_documento" class="" style="cursor: not-allowed;"><i class="material-icons" style="color:#000;">archive</i></a>';

                }
                
                $button .= '</div></div>';

                return $button;
            })
            ->filterColumn('nome', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->whereEncrypted('nome', 'like', "%" . $keyword . "%");
            }) 
            ->filterColumn('email', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('email', 'like', "%" . $keyword . "%");
            }) 
            ->filterColumn('indirizzo', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->whereEncrypted('indirizzo', 'like', "%" . $keyword . "%");
            }) 
            ->rawColumns(['azione','file'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clienti.crea_cliente');
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
            'nome' => 'unique:societa|String|min:2',
            'email' => 'unique:societa|email:rfc,dns',
        ]);

        $cliente = new Societa;
        $cliente->nome = ucfirst($request->nome);
        $cliente->indirizzo = ucfirst($request->indirizzo);
        $cliente->email = $request->mail;


        if (isset($request->contratto)) {
            $fileBASE64 = $request->contratto;
            $filename = $request->nome_contratto;
            $file_parts = pathinfo($filename);
            if ($file_parts['extension'] != "pdf" && $file_parts['extension'] != "txt") 
            {
                return response()->json(['error' => 'Errore: dati non validi'], 402);
            }
            else
            {
                $fileBASE64 = str_replace("data:application/".$file_parts['extension'].";base64,", "", $fileBASE64);
                $fileBASE64 = str_replace(' ', '+', $fileBASE64);
                $new_file = base64_decode($fileBASE64);
                Storage::disk('public')->put("contratti/$filename", $new_file);
                $cliente->contratto = $filename;
            }
        }


        $cliente->save();

        LoggerEvent::log(auth()->user()->id,"Creazione nuovo committente",$request->all(),false);
        return json_encode('Committente creato correttamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Societa  $societa
     * @return \Illuminate\Http\Response
     */
    public function show(Societa $societa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Societa  $societa
     * @return \Illuminate\Http\Response
     */
    public function edit(Societa $societa)
    {
        //
    }

    /**
     * @param Request $request
     * @param mixed $id
     *
     * @return Progetto
     */
    public function getCliente(Request $request, $id)
    {
        $cliente = Societa::find($id);
        $elementi_cliente = [
            'nome' => $cliente->nome,
            'indirizzo' => $cliente->indirizzo,
            'mail' => $cliente->email
        ];
        return json_encode($elementi_cliente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Societa  $societa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Societa $societa)
    {
        $validator = Validator::make($request->all(), [
            'nome' => [
                'required',
                Rule::unique('societa')->ignore($request->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Errore: dati non validi'], 403);
        }

        $cliente = Societa::find($request->id);
        
        if($cliente == null)
        {
            return json_encode('Errore, committente non trovato');
        }
                
        if (request('nome') == null) {
            $risultatoQuery = Societa::find($request->id);
            $nome_cliente = $risultatoQuery["nome"];
        } else {
            $nome_cliente = request('nome');
        }

        if (request('indirizzo') == null) {
            $risultatoQuery = Societa::find($request->id);
            $indirizzo = $risultatoQuery["indirizzo"];
        } else {
            $indirizzo = request('indirizzo');
        }

        if (request('mail') == null) {
            $risultatoQuery = Societa::find($request->id);
            $mail = $risultatoQuery["mail"];
        } else {
            $mail = request('mail');
        }

        if (isset($request->contratto)) {
            $fileBASE64 = $request->contratto;
            $filename = $request->nome_contratto;
            $file_parts = pathinfo($filename);
            if ($file_parts['extension'] != "pdf" && $file_parts['extension'] != "txt") 
            {
                return response()->json(['error' => 'Errore: dati non validi'], 402);
            }
            else
            {
                $fileBASE64 = str_replace("data:application/".$file_parts['extension'].";base64,", "", $fileBASE64);
                $fileBASE64 = str_replace(' ', '+', $fileBASE64);
                $new_file = base64_decode($fileBASE64);
                Storage::disk('public')->put("contratti/$filename", $new_file);
                $cliente->contratto = $filename;
            }
        }

        $cliente->nome = $nome_cliente;
        $cliente->indirizzo = $indirizzo;
        $cliente->email = $mail;

        $cliente->save();

        LoggerEvent::log(auth()->user()->id, "Modifica dei dati del committente: $cliente->nome", $request->all(), true);
        return json_encode("Committente modificato correttamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Societa  $societa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $societa = Societa::find($id);
        if($societa == null)
        {
            return response()->json(["messaggio" => "Errore, committente non trovato"],404);
        }
        $progetti = Progetto::where('id_societa',$societa->id)->get();
        if(count($progetti) != 0)
        {
            return response()->json(["messaggio" => "Impossibile eliminare il committente $societa->nome, esistono progetti per questo committente"],403);
        }  
        $societa->motivo = $request->motivo;
        $societa->id_utente_cancella = auth()->user()->id;

        if($societa->contratto != null)
        {
            Storage::disk('public')->delete("contratti/$societa->contratto");
        }

        $nome = $societa->nome;
        
        $societa->save();
        $societa->delete();
        LoggerEvent::log(auth()->user()->id,"Eliminato committente $nome. Motivo: $request->motivo",$societa,false);
        return response()->json(["messaggio" => "Committente eliminato correttamente"],200);
        
    }
}
