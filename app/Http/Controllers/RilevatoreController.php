<?php

namespace App\Http\Controllers;

use App\Rilevatore;
use App\Progetto;
use App\Struttura;
use App\Societa;
use Log;
use App\Event\LoggerEvent;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\StruttRep;

use Illuminate\Http\Request;

class RilevatoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rilevatori = Rilevatore::all();
        $societa = Societa::all();
        $progetti = Progetto::where('versione',2)->get();
        return view('rilevatori.filtro',compact('rilevatori','societa','progetti'));
    }

     /**
     * @param Request $request
     *
     * @return query query per riempimento tabella progetti in index schede_campionamento
     */
    public function list(Request $request, $progetto, $interno)
    {
        $data = Rilevatore::whereNull('deleted_at');
        
        if($progetto != 'tutti')
        {
            $data = $data->where('id_progetto',$progetto);
        }

        if($interno != 'tutti')
        {
            $data = $data->where('interno',$interno == "si" ? 1 : 0);
        }

        $data = $data->select([
            'rilevatori.*'
        ]);

        return DataTables::of($data)
            ->addColumn('azione',function($data) {
                $button = '<div class="row">' . '<div class="col-sm-12">';
                $button .=  '<a href=""  class="btn btn-small btn-action btn-primary modifica-rilevatore" id="' . $data->id . '" data-toggle="modal" data-target="#modificaRilevatoreModal"  value="Modifica" ">Modifica</a>';
                            
                $button.= 
                            '<a class="btn btn-small btn-action button-elimina btn-danger btn-elimina" id="'.$data->id.'"  data-toggle="modal"data-target="#deleteModal">Elimina</a>';
                $button .= '</div>' . '</div>';

                return $button;
            })
            ->editColumn('progetto',function($data){
                $progetto = Progetto::find($data->id_progetto);
                return $progetto->progetto ?? 'Non specificato';
            })
            ->editColumn('interno',function($data){
                $interno = $data->interno == 1 ? 'Interno' : 'Esterno';
                return $interno;
            })
            ->filterColumn('rilevatore', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->whereEncrypted('rilevatore', $keyword);
            }) 
            ->filterColumn('progetto', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $progetto = Progetto::whereEncrypted('progetto','like','%'.$keyword.'%')->first();
                $query->where('id_progetto',$progetto->id ?? '');
            }) 
            ->filterColumn('interno', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                if(levenshtein(strtolower($keyword),'interno') < 1)
                {
                    $query->where('interno',1);
                }
                else if(levenshtein(strtolower($keyword),'esterno') < 1)
                {
                    $query->where('interno',0);
                }
            }) 
            ->rawColumns(['progetto','interno','azione'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $progetti = Progetto::where('versione',2)->get();
        return view('rilevatori.create_rilevatore', compact('progetti'));
    }

     /**
     * Retrieve strutture del progetto associato
     * 
     * @param Request $request
     * 
     */
    public function getStruttureProgetto(Request $request)
    {
        $tot_strutture = Array();
        if($request->id_progetto == "nessuna" || $request->id_progetto == 0 || $request->id_progetto == null)
        {
            return json_encode('nessun progetto selezionato');
        }
        
        $progetti = Progetto::where('id',$request->id_progetto)->first();
        if($progetti == null)
        {
            return response()->json(['message' => 'Nessun progetto trovato'],403);
        }
        $struttRep = StruttRep::where('id_progetto',$progetti->id)->distinct('id_struttura')->select('id_struttura')->get();
        foreach ($struttRep as $s) {
            $strutture = Struttura::find($s->id_struttura);
            array_push($tot_strutture,['id'=>$strutture->id,'struttura'=>$strutture->struttura]);
        }
        return json_encode(['tot_strutture'=>$tot_strutture]);
    }

    /**
     * Recupera dal database le informazioni riguardanti un singolo utente
     * 
     * @param Request $request
     * 
     * @return Rilevatore
     */
    public function getData(Request $request)
    {
        if($request->id == null)
        {
            return redirect('/rilevatori')->withErrors('Dati inviati non validi');
        }

        $rilevatore = Rilevatore::find($request->id);

        if($rilevatore == null)
        {
            return redirect('/rilevatori')->withErrors('Errore nella ricerca del rilevatore');
        }

        $nomeCognome = explode(' ',$rilevatore->rilevatore);

        return ['id' => $rilevatore->id, 'nome' => $nomeCognome[0], 'cognome' => $nomeCognome[1], 'progetto' => $rilevatore->id_progetto, 'struttura' => $rilevatore->id_struttura, 'interno' => $rilevatore->interno];

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
            'rilevatore' => 'unify:rilevatori,nome,cognome',
            'interno' => 'required',
        ]);


        if ($validator->fails()) {
            return redirect('rilevatori/create')->withErrors($validator->messages())->withInput();
        }

        $rilevatore = new Rilevatore;
        $rilevatore->rilevatore = ucfirst($request->nome) . " " . ucfirst($request->cognome);
        $rilevatore->id_progetto = (isset($request->id_progetto) && $request->id_progetto != 'nessuna') ? $request->id_progetto : null;
        $rilevatore->interno = (isset($request->interno) && $request->interno == 'si' && $request->interno != 'tutti') ? 1 : 0;
        $rilevatore->save();

        LoggerEvent::log(auth()->user()->id,"Creazione nuovo rilevatore",$request->all(),false);
        return redirect('/rilevatori');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rilevatore  $rilevatore
     * @return \Illuminate\Http\Response
     */
    public function show(Rilevatore $rilevatore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rilevatore  $rilevatore
     * @return \Illuminate\Http\Response
     */
    public function edit(Rilevatore $rilevatore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'modifica_rilevatore_salva' => 'required',
            'rilevatore' => 'unify:rilevatori,nome,cognome',
            'interno' => 'required',
            'motivo' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/rilevatori')->withErrors($validator->messages())->withInput();
        }
        $rilevatore = Rilevatore::find($request->modifica_rilevatore_salva);
        $rilevatore->rilevatore = ucfirst($request->nome) . " " . ucfirst($request->cognome);
        $rilevatore->id_progetto = (isset($request->id_progetto) && ($request->id_progetto != 'nessuna' && $request->id_progetto != 0 && $request->id_progetto != 'tutti')) ? $request->id_progetto : null;
        $rilevatore->interno = $request->interno;
        $rilevatore->save();

        LoggerEvent::log(auth()->user()->id,"Modificato il rilevatore $rilevatore->rilevatore, motivo: $request->motivo",$request->all(),false);
        return redirect('/rilevatori');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'motivo' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 403);
        }

        $rilevatore = Rilevatore::find($request->id);
        if($rilevatore == null)
        {
            return response()->json(['error' => "Rilevatore non trovato"], 403);
        }

        $rilevatore->id_utente_cancella = auth()->user()->id;
        $rilevatore->motivo = $request->motivo;
        $rilevatore->save();
        $rilevatore->delete();

        LoggerEvent::log(auth()->user()->id,"Eliminato il rilevatore: $rilevatore->rilevatore, motivo: $request->motivo",$request->all(),false);
        return json_encode('Rilevatore eliminato correttamente');
    }
}
