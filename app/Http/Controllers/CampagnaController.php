<?php

namespace App\Http\Controllers;

use App\Campagna;
use App\Struttura;
use App\Societa;
use App\Reparto;
use App\Campione;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\StruttRep;
use App\Progetto;
use App\Event\LoggerEvent;
use App\AreaPartizione;
use App\ConversioneProgetto;

class CampagnaController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Artesaos\Defender\Facades\Defender::hasRole('admin') || \Artesaos\Defender\Facades\Defender::hasRole('gestore'))
        { 
            $struttura = Struttura::where('versione',2)->get();
            $societa = Societa::all();
            $progetti = Progetto::where('versione',2)->get();

            return view('campagna.campagna',compact('struttura','societa','progetti'));

        }

        if(\Artesaos\Defender\Facades\Defender::hasRole('committente') || \Artesaos\Defender\Facades\Defender::hasRole('utente'))
        {
            $progetto = Progetto::find(auth()->user()->progetto);
            $struttRep = StruttRep::where('id_progetto',$progetto->id)->get();
            
            $struttura = Array();
            $societa = $progetto->societa();
            // $reparti = Array();

            if($struttRep != null)
            {
                foreach($struttRep as $sr)
                {
                    $s = Struttura::find($sr->id_struttura);

                    // $r = Reparto::find($sr->id_reparto);

                    array_push($struttura,$s);
                    // array_push($reparti,$r);
                }
            }

            return view('campagna.campagna',compact('struttura','societa','progetto'));

        }
    }


    /**
     * @param Request $request
     * @param String $progetto
     *
     * @return query query per riempimento tabella progetti in index schede_campionamento
     */
    public function list(Request $request, $societa, $struttura, $progetto, $dataCampagna)
    {
        if(\Artesaos\Defender\Facades\Defender::hasRole('admin') || \Artesaos\Defender\Facades\Defender::hasRole('gestore'))
        {
            $data = Campagna::leftJoin('societa','campagna.id_societa','=','societa.id')
                            ->leftJoin('strutture','campagna.id_struttura','=','strutture.id')
                            ->leftJoin('progetti','progetti.id','=','campagna.id_progetto')
                            ->orderBy('dataCampagna','DESC');

            if($societa != "tutti")
            {
                $data = $data->where('societa.id','=',$societa);
            }

            if($struttura != "tutti")
            {
                $data = $data->where('strutture.id','=',$struttura);
            }

            if($progetto != "tutti")
            {
                $data = $data->where('progetti.id','=',$progetto);
            }

            if($dataCampagna != "tutti")
            {
                $data = $data->where('campagna.dataCampagna',$dataCampagna);
            }

            $data = $data->select(['campagna.id as id',
                                'societa.nome as societa',
                                'societa.id as id_societa',
                                'strutture.struttura as struttura',
                                'progetti.progetto as progetto',
                                'progetti.id as id_progetto',
                                'campagna.dataCampagna as dataCampagna',
            ]);
           
            return DataTables::of($data)
                ->addColumn('azione',function($data) {
                    $button = '<div class="row">' . '<div class="col-sm-12">';
                    $button .=  '<a href="/campagna/'.$data->id.'/edit"  class="btn btn-small btn-action btn-primary" id="' . $data->id . '" data-toggle="tooltip" data-placement="top" title="Apri questa campagna">Apri</a>';

                    $button .= '</div>' . '</div>';

                    return $button;
                })
                ->editColumn('dataCampagna',function($data){
                    $data_campagna = $data->dataCampagna;
                    return $data_campagna;
                })
                ->editColumn('societa',function($data){
                    $societa = Societa::where('nome',$data->societa)->first();
                    return $societa->nome;
                })
                ->editColumn('struttura',function($data){
                    $struttura = $data->struttura;
                    return $struttura;
                })
                ->editColumn('progetto',function($data){
                    $progetto = Progetto::find($data->id_progetto);
                    return $progetto->progetto;
                })
                ->filterColumn('societa', function ($query) use ($request) {
                    $keyword = str_replace(' ','%',request()->search['value']);
                    $societa = Societa::whereEncrypted('nome', 'like', "%" . $keyword . "%")->first();
                    $query->where('id_societa', $societa->id ?? '');
                }) 
                // ->filterColumn('id', function ($query) use ($request) {
                //     $query->where('campagna.id', 'like', request()->search['value'] . "%");
                    
                // })
                ->filterColumn('struttura', function ($query) use ($request) {
                    $keyword = str_replace(' ','%',request()->search['value']);
                    $query->where('struttura', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('progetto', function ($query) use ($request) {
                    $keyword = str_replace(' ','%',request()->search['value']);
                    $query->whereEncrypted('progetti.progetto', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('dataCampagna', function ($query) use ($request) {     
                    if(strpos(request()->search['value'],'/') !== false)
                    {
                        $date = explode('/', request()->search['value']);
                        //$date = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                        if(count($date) == 2 && $date[1] == '')
                        {
                            $query->where('dataCampagna','like', "%" . $date[0]."%");
                        }
                        else if((count($date) == 2 && $date[1] != '') || (count($date) == 3 && $date[2] == ''))
                        {
                            $query->where('dataCampagna','like', "%" . $date[1] . "-" . $date[0]."%");
                        }
                        else if(count($date) == 3 && $date[1] != '' && $date[2] != '')
                        {
                            $data = $date[2]."-".$date[1]."-".$date[0];
                            $query->where('dataCampagna', $data);
                        }
                    }
                    else
                    {
                        $query->where('dataCampagna','like',"%".request()->search['value']."%");
                    }   
                })
                ->rawColumns(['dataCampagna','struttura','reparto','area','societa','azione'])
                ->make(true);
        }

        if(\Artesaos\Defender\Facades\Defender::hasRole('committente') || \Artesaos\Defender\Facades\Defender::hasRole('utente'))
        {
            $prog = Progetto::find(ConversioneProgetto::progettoV1(auth()->user()->progetto) ?? auth()->user()->progetto);
            $soc = $prog->societa()->first();
            $struttRep = StruttRep::whereIn('id_progetto',[ConversioneProgetto::progettoV1(auth()->user()->progetto), auth()->user()->progetto])->get();


            $strutt = Array();

            if($struttRep != null)
            {
                foreach($struttRep as $sr)
                {
                    $s = Struttura::find($sr->id_struttura);
                    array_push($strutt,$s->id);
                }
            }
        
            $data = Campagna::leftJoin('societa','campagna.id_societa','=','societa.id')
                            ->leftJoin('strutture','campagna.id_struttura','=','strutture.id')
                            ->leftJoin('progetti','campagna.id_progetto','=','progetti.id')
                            ->whereIn('campagna.id_progetto',[ConversioneProgetto::progettoV1(auth()->user()->progetto), auth()->user()->progetto]);
            
            $data = $data->where('societa.id','=',$soc->id);
            
            $data = $data->whereIn('strutture.id',$strutt);

            $data = $data->orderBy('dataCampagna','DESC')
                            ->select(['campagna.id as id',
                                'societa.nome as societa',
                                'societa.id as id_societa',
                                'strutture.struttura as struttura',
                                'strutture.id as id_struttura',
                                'progetti.progetto as progetto',
                                'progetti.id as id_progetto',
                                'campagna.dataCampagna as dataCampagna',
            ]);

            return DataTables::of($data)
                ->addColumn('azione',function($data) {
                    $button = '<div class="row">' . '<div class="col-sm-12">';
                    $button .=  '<a href="/campagna/'.$data->id.'/edit"  class="btn btn-small btn-action btn-primary" id="' . $data->id . '" data-toggle="tooltip" data-placement="top" title="Apri questa campagna" target="_blank">Apri</a>';

                    $button .= '</div>' . '</div>';

                    return $button;
                })
                ->editColumn('dataCampagna',function($data){
                    $data_campagna = $data->dataCampagna;
                    return $data_campagna;
                })
                ->editColumn('struttura',function($data){
                    $struttura = $data->struttura;
                    return $struttura;
                })
                ->editColumn('progetto',function($data){
                    $progetto = Progetto::find($data->id_progetto);
                    return $progetto->progetto ?? 'Non specificato';
                })
                ->editColumn('societa',function($data){
                    $societa = Societa::where('nome',$data->societa)->first();
                    return $societa->nome;
                })
                // ->filterColumn('id', function ($query) use ($request) {
                //     $query->where('campagna.id', 'like', request()->search['value'] . "%");
                    
                // })
                ->filterColumn('struttura', function ($query) use ($request) {
                    $keyword = str_replace(' ','%',request()->search['value']);
                    $query->where('struttura', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('progetto', function ($query) use ($request) {
                    $keyword = str_replace(' ','%',request()->search['value']);
                    $query->whereEncrypted('progetti.progetto', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('societa', function ($query) use ($request) {
                    $keyword = str_replace(' ','%',request()->search['value']);
                    $societa = Societa::whereEncrypted('nome', 'like', "%" . $keyword . "%")->first();
                    $query->where('id_societa', $societa->id ?? '');
                }) 
                ->filterColumn('dataCampagna', function ($query) use ($request) {     
                    if(strpos(request()->search['value'],'/') !== false)
                    {
                        $date = explode('/', request()->search['value']);
                        //$date = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                        if(count($date) == 2 && $date[1] == '')
                        {
                            $query->where('dataCampagna','like', "%" . $date[0]."%");
                        }
                        else if((count($date) == 2 && $date[1] != '') || (count($date) == 3 && $date[2] == ''))
                        {
                            $query->where('dataCampagna','like', "%" . $date[1] . "-" . $date[0]."%");
                        }
                        else if(count($date) == 3 && $date[1] != '' && $date[2] != '')
                        {
                            $data = $date[2]."-".$date[1]."-".$date[0];
                            $query->where('dataCampagna', $data);
                        }
                    }
                    else
                    {
                        $query->where('dataCampagna','like',"%".request()->search['value']."%");
                    }   
                })
                ->rawColumns(['dataCampagna','struttura','reparto','societa','azione'])
                ->make(true);
        }
        
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
            'id_societa' => 'uniqueCombo:campagna,id_progetto,id_struttura,dataCampagna',
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect("/campagna")
                            ->withErrors($messages)
                            ->withInput();
        }

        $campagna = new Campagna;
        $campagna->id_societa = $request->id_societa;
        $campagna->id_progetto = $request->id_progetto;
        $campagna->id_struttura = $request->id_struttura;
        $campagna->dataCampagna = $request->dataCampagna;

        $campagna->save();

        LoggerEvent::log(auth()->user()->id, "Creazione di una campagna", $request->all(), true);
        return redirect("/campagna/$campagna->id/edit");
    }

    /**
     * Recupera i progetti associati ad una societa
     * 
     * @param Request $request
     * 
     * @return json Progetti
     */
    public function getProgettiSocieta(Request $request)
    {
        if($request->id_societa == "tutti")
        {
            $progetti = Progetto::where('versione',2)->get();
        }
        else
        {
            $progetti = Progetto::where('id_societa',$request->id_societa)->where('versione',2)->get();
        }

        if($progetti == null)
        {
            return response()->json(['message' => 'Nessun progetto trovato per questa società'],403);
        }

        return json_encode(['progetti' => $progetti]);
    }

    /**
     * Recupara strutture di tutti i progetti associati alla società
     * 
     * @param Request $request
     * 
     * @return json Strutture e reparti
     */
    public function getStruttureProgetto(Request $request)
    {
        $tot_strutture = Array();
        if($request->id_progetto == "nessuna")
        {
            return json_encode('nessun progetto selezionato');
        }
        elseif($request->id_progetto == "tutti")
        {
            $progetti = Progetto::where('id_societa',$request->id_societa)->get();

            if($progetti == null)
            {
                return response()->json(['message' => 'Nessun progetto trovato per questa società'],403);
            }

            foreach ($progetti as $p) {
                $struttRep = StruttRep::where('id_progetto',$p->id)->distinct('id_struttura')->select('id_struttura')->get();
                foreach ($struttRep as $s) {
                    $strutture = Struttura::find($s->id_struttura);
                    array_push($tot_strutture,['id'=>$strutture->id,'struttura'=>$strutture->struttura]);
                }
            }
        }
        else
        {
            $progetti = Progetto::where('id',$request->id_progetto)->first();

            if($progetti == null)
            {
                return response()->json(['message' => 'Nessun progetto trovato per questa società'],403);
            }

            $struttRep = StruttRep::where('id_progetto',$progetti->id)->distinct('id_struttura')->select('id_struttura')->get();
            foreach ($struttRep as $s) {
                $strutture = Struttura::find($s->id_struttura);
                array_push($tot_strutture,['id'=>$strutture->id,'struttura'=>$strutture->struttura]);
            }
        }
        
        return json_encode(['tot_strutture'=>$tot_strutture]);
    }

    /**
     * Retrieve reparti di tutti i progetti associati alla società
     * 
     * @param Request $request
     * 
     * @return json Reparti
     */
    public function getStruttureReparti(Request $request)
    {
        $tot_reparti = Array();
        if($request->id_progetto == "tutti")
        {
            $progetti = Progetto::where('id_societa',$request->id_societa)->get();

            if($progetti == null)
            {
                return response()->json(['message' => 'Nessun progetto trovato per questa società'],403);
            }

            foreach ($progetti as $p) {
                $struttRep = StruttRep::where('id_progetto',$p->id)->where('id_struttura',$request->struttura)->get();
                foreach ($struttRep as $s) {
                    if($s->id_reparto == null)//vuol dire che cerco nella nuova versione
                    {
                        $reparti = Reparto::find(AreaPartizione::find($s->id_associazione)->id_reparto);
                    }
                    else//altrimenti cerco i dati nella vecchia versione
                    {
                        $reparti = Reparto::find($s->id_reparto);
                    }
                    array_push($tot_reparti,['id'=>$reparti->id,'reparto'=>$reparti->partizione]);
                }
            }  
        }
        else
        {
            $struttRep = StruttRep::where('id_progetto',$request->id_progetto)->where('id_struttura',$request->struttura)->get();
            if($struttRep == null)
            {
                return response()->json(['message' => 'Errore, dati non validi'],403);
            }
            foreach ($struttRep as $s) {
                if($s->id_reparto == null)//vuol dire che cerco nella nuova versione
                {
                    $reparti = Reparto::find(AreaPartizione::find($s->id_associazione)->id_reparto);
                }
                else//altrimenti cerco i dati nella vecchia versione
                {
                    $reparti = Reparto::find($s->id_reparto);
                }
                #check if reparti->id is already in
                if(!in_array($reparti->id, array_column($tot_reparti, 'id')))
                {
                    array_push($tot_reparti,['id'=>$reparti->id,'reparto'=>$reparti->partizione]);
                }
            }
        }


        return json_encode(['tot_reparti'=>$tot_reparti]);
    }

    /**
     * Funzione per recuperare le aree riferite ad una particolare partizione
     */
    public function getAreaPartizione(Request $request)
    {
        $tot_areapartizione = Array();
        $partizione = Reparto::find($request->id_partizione);
        if($partizione == null)
        {
            return response()->json(['message' => 'Errore, dati non validi'],403);
        }
        $areapartizione = AreaPartizione::where('id_reparto',$partizione->id)->get();
        foreach($areapartizione as $ap)
        {
            if($ap->area_partizione != null)
            {
                array_push($tot_areapartizione,['id' => $ap->id,'areapartizione' => $ap->area_partizione]);
            }
        }
        return json_encode(['tot_areapartizione'=>$tot_areapartizione]);
    }
    

    /**
     * Recupare i campioni di una campagna
     * @param Request $request
     * @param Integer $id
     * 
     * @return function index campioni
     */
    public function getCampioni(Request $request, $id)
    {
        app('App\Http\Controllers\CampioneController')->index($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campagna  $campagna
     * @return \Illuminate\Http\Response
     */
    public function show(Campagna $campagna)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campagna  $campagna
     * @return \Illuminate\Http\Response
     */
    public function edit(Campagna $campagna)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campagna  $campagna
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campagna $campagna)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campagna  $campagna
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campagna $campagna)
    {
        //
    }
}
