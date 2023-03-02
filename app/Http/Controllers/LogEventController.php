<?php

namespace App\Http\Controllers;

use App\LogEvent;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\User;
use Log;
use App\RappRelCampioni;
use App\Progetto;
use App\Societa;
use App\Reparto;
use App\Campione;
use App\Materiale;
use App\Struttura;
use App\Campagna;
use App\TipoPiastra;
use App\MicrorganismoPiastra;
use App\SpeciazioneCampione;
use App\MicroAntibiogramma;
use App\Metodo;
use App\Rilevatore;
use App\AreaPartizione;
use Carbon\Carbon;
use App\PuntoCampionamento;
use App\RapportoRelazione;
use App\Antibiotico;
use App\AntibioticoAntibiogramma;
use App\MicroAntibiobiogramma;
use App\Categoria;
use App\Protocollo;
use App\StruttRep;

class LogEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('log_eventi.log_eventi_table');
    }

    /**
     * Ritorna il contenuto della DataTable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function list(Request $request)
    {
        $utenti_azione = LogEvent::join('users', 'log_envass.id_utente', '=', 'users.id');
        
        $utenti_azione = $utenti_azione->select(['log_envass.id','log_envass.created_at','users.nome','users.cognome','log_envass.azione']);

        return DataTables::of($utenti_azione)
        ->addColumn('pulsante', function ($utenti_azione) {
            $button =   '<div class="row">' .
                    '<div class="col-sm-4">' .
                   '<button id="'. $utenti_azione->id .'" evento="'. $utenti_azione->id .'" class="btn btn-small btn-primary datiButton"  data-toggle="modal" data-target="#largeModal">Vedi</button>' .
                   '</div>';

            return $button;
        })
        // ->filterColumn('nome',function(){
        //     return $this->collection->where('nome', 'like', '%' . request()->get('search')['value'] . '%');
        // })
        // ->filterColumn('cognome',function(){
        //     return $this->collection->where('cognome', 'like', '%' . request()->get('search')['value'] . '%');
        // })
        ->filterColumn('nome', function ($query) use ($request) {
            $keyword = str_replace(' ','%',request()->search['value']);
            $query->where('users.nome','like', '%' . $keyword . '%'); 
            
        })
        ->filterColumn('cognome', function ($query) use ($request) {
            $keyword = str_replace(' ','%',request()->search['value']);
            $query->where('users.cognome','like', '%' . $keyword . '%');
        })
        ->filterColumn('created_at', function ($query) use ($request) {
            if(strpos(request()->search['value'],'/') !== false)
            {
                $date = explode('/', request()->search['value']);
                $query->where('log_envass.created_at','like',"%".$date[0]."%");
                for($i=1;$i<count($date);$i++)
                {
                    $query->where('log_envass.created_at','like',"%".$date[$i]."%");
                }
            }
            else
            {
                $query->where('log_envass.created_at','like',"%".request()->search['value']."%");
            }        
        })
        ->rawColumns(['pulsante'])
        ->make(true);
    }

    public function getDati(Request $request)
    {
        $dato = LogEvent::find($request->id);

        $dato['dati'] = json_decode($dato['dati'],true);
        Log::info($dato['dati']);
        $dato = $this->prepareData($dato['dati']);

        return $dato;
    }

    public function filterData(Request $request)
    {
        
        $campioni_rapprel = RappRelCampioni::where('id_rapprel',$request->id_rdp)->get();
        $campioni = [];
        $id_rdp = $request->id_rdp;
        foreach($campioni_rapprel as $c)
        {
            $campioni[] = $c->id_campione;
        }
        
        return view('log_eventi.log_eventi_filter_table',compact('campioni','id_rdp'));
    }


     /**
     * Ritorna il contenuto della DataTable Filtrato per RDP.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function list_filter(Request $request, $id_rdp)
    {
        $utenti_azione = LogEvent::join('users', 'log_envass.id_utente', '=', 'users.id')
                                    ->where('log_envass.rdp',$id_rdp);
                                    
        if($request->campioni_id != null)
        {
            $utenti_azione = $utenti_azione->orWhereIn('log_envass.id_campione',$request->campioni_id);     

        }
        
        $utenti_azione = $utenti_azione->select(['log_envass.id','log_envass.created_at','users.nome','users.cognome','log_envass.azione']);

        return DataTables::of($utenti_azione)
        ->addColumn('pulsante', function ($utenti_azione) {
            $button =   '<div class="row">' .
                    '<div class="col-sm-4">' .
                   '<button id="'. $utenti_azione->id .'" evento="'. $utenti_azione->id .'" class="btn btn-small btn-primary datiButton"  data-toggle="modal" data-target="#largeModal">Vedi</button>' .
                   '</div>';

            return $button;
        })
        // ->filterColumn('nome',function(){
        //     return $this->collection->where('nome', 'like', '%' . request()->get('search')['value'] . '%');
        // })
        // ->filterColumn('cognome',function(){
        //     return $this->collection->where('cognome', 'like', '%' . request()->get('search')['value'] . '%');
        // })
        ->filterColumn('nome', function ($query) use ($request) {
            $keyword = str_replace(' ','%',request()->search['value']);
            $query->where('users.nome','like', '%' . $keyword . '%'); 
            
        })
        ->filterColumn('cognome', function ($query) use ($request) {
            $keyword = str_replace(' ','%',request()->search['value']);
            $query->where('users.cognome','like', '%' . $keyword . '%');
        })
        ->filterColumn('created_at', function ($query) use ($request) {
            if(strpos(request()->search['value'],'/') !== false)
            {
                $date = explode('/', request()->search['value']);
                $query->where('log_envass.created_at','like',"%".$date[0]."%");
                for($i=1;$i<count($date);$i++)
                {
                    $query->where('log_envass.created_at','like',"%".$date[$i]."%");
                }
            }
            else
            {
                $query->where('log_envass.created_at','like',"%".request()->search['value']."%");
            }        
        })
        ->rawColumns(['pulsante'])
        ->make(true);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function prepareData($dati)
    {
        $intestazioni = LogEvent::getIntestazioni();
        $metodi = LogEvent::getMetodoIntestazioni();
        // convert to array
        if($dati == null || $dati == '')
        {
            return null;
        }

        foreach($dati as $key => $value)
        {
            if(array_key_exists($key,$intestazioni))
            {
                $new_key = $intestazioni[$key];
                if(array_key_exists($key,$metodi) && $value != null)
                {
                    $metodo = $metodi[$key];
                    switch ($metodo) {
                        case 'Categoria':
                            switch ($key) {
                                case 'id_categoria':
                                    $new_value = Categoria::find($value)->categoria;
                                    break;
                                
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'Societa':
                            switch ($key) {
                                case 'id_societa':
                                    $new_value = Societa::find($value) != null ? Societa::find($value)->societa : $value;
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'RapportoRelazione':  
                            switch ($key) {
                                case 'id_rdp':
                                    $new_value = $value != null ? RapportoRelazione::find($value)->file : '';
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'Progetto':
                            switch ($key) {
                                case 'id_progetto':
                                    $new_value = Progetto::find($value)->progetto;
                                    break;
                                case 'progetto':
                                    $new_value = Progetto::find($value)->progetto;
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'Campione':
                            switch ($key) {
                                case 'id_campione':
                                    $new_value = Campione::find($value)->id;
                                    break;
                                case 'updated_at':
                                    $new_value = Carbon::parse($value)->format('d/m/Y H:i:s');
                                    break;
                                case 'tipoScheda':
                                    switch ($value) {
                                        case '1':
                                            $new_value = 'Bianco';
                                            break;
                                        case '2':
                                            $new_value = 'Qualità';
                                            break;
                                        default:
                                            $new_value = 'Campionamento';
                                            break;
                                    }
                                    break;
                                case 'gramN':
                                    $new_value = $value == 0 ? 'Nessuno' : 'Rilevati';
                                    break;
                                case 'siGramRil':
                                    $new_value = $value == 0 ? 'No' : 'Si';
                                    break;
                                case 'noGramRil':
                                    if(array_key_exists('siGramRil',$dati))
                                    {
                                        unset($dati['noGramRil']);
                                    }
                                    else
                                    {
                                        $new_value = $value == 0 ? 'Si' : 'No';
                                    }
                                    break;
                                case 'DII':
                                    $new_value = Carbon::parse($value)->format('d/m/Y');
                                    break;
                                case 'tipoScheda':
                                    $new_value =  $value == 'N' ? 'Campionamento' : ($value == 'B' ? 'Bianco' : 'Qualità');
                                    break;
                                case 'scadenza':
                                    $new_value = Carbon::parse($value)->format('d/m/Y');
                                    break;
                                case 'tipoCampione':
                                    $new_value =  ucfirst($value);
                                    break;
                                case 'tipoTest':
                                    $tipo =  $value != null ? ucfirst(Campione::find($value)->tipoTest) : '';
                                    switch ($tipo) {
                                        case '1':
                                            $new_value = 'Ripetibilità Conta';
                                            break;
                                        case '2':
                                            $new_value = 'Ripetibilità Campionamento';
                                            break;
                                        case '3':
                                            $new_value = 'Proficiency Test';
                                            break;
                                        case '4':
                                            $new_value = 'Recupero';
                                            break;
                                        default:
                                            $new_value = $value;
                                            break;
                                    }
                                    break;
                                case 'superficie':
                                    if(array_key_exists('abbreviazione',$dati) && $value != null)
                                    {
                                        $new_value = $value;
                                    }
                                    else
                                    {
                                        $new_value = ucfirst($value == 1 ? 'si' : 'no');
                                    }
                                    break;
                                case 'aria':
                                    $new_value = ucfirst($value == 1 ? 'si' : 'no');
                                    break;
                                case 'vccc':
                                    $new_value = ucfirst($value == 1 ? 'si' : 'no');
                                    break;
                                case 'laminare':
                                    $new_value = ucfirst($value == 1 ? 'si' : 'no');
                                    break;
                                case 'turbolento':
                                    $new_value = ucfirst($value == 1 ? 'si' : 'no');
                                    break;
                                case 'operational':
                                    $new_value = ucfirst($value == 1 ?  'si' : 'no');
                                    break;
                                case 'at_rest':
                                    $new_value = ucfirst($value == 1 ?  'si' : 'no');
                                    break;
                                case 'n_persone':
                                    $new_value = $value;
                                    break;
                                case 'pCampAria':
                                    $new_value =  $value != null ?  PuntoCampionamento::find($value)->punto_campionamento : '';
                                    break;
                                case 'codiceCIAS':
                                    if(array_key_exists('id_campione',$dati))
                                    {
                                        $new_value =  $value != null ?  Campione::find($dati['id_campione'])->codiceCIAS : '';
                                    }
                                    else
                                    {
                                        $new_value = $value;
                                    }
                                    break;
                                case 'lineeGuida1':
                                    $lineeGuida = Campione::get_lineeguida();
                                    $new_value = $value == 1 ? " Applicata" : 'Non applicata' ;
                                    break;
                                case 'lineeGuida2':
                                    $lineeGuida = Campione::get_lineeguida();
                                    $new_value = $value == 1 ? " Applicata" : 'Non applicata' ;
                                    break;
                                case 'lineeGuida3':
                                    $lineeGuida = Campione::get_lineeguida();
                                    $new_value = $value == 1 ? " Applicata" : 'Non applicata' ;
                                    break;
                                case 'lineeGuida4':
                                    $lineeGuida = Campione::get_lineeguida();
                                    $new_value = $value == 1 ? " Applicata" : 'Non applicata' ;
                                    break;
                                case 'classeGMP':
                                    $gmp = Campione::get_gmp();
                                    $new_value = $gmp[$value];
                                    break;
                                case 'classificazioneISO':
                                    $iso = Campione::get_iso();
                                    $new_value = $iso[$value];
                                    break;
                                case 'tipoCamp':
                                    $new_value = $value == 'S' ? 'Superficie' : 'Aria';
                                    break;
                                case preg_match('/^data/', $key) ? true : false:
                                    $new_value = $value != null ? date('d/m/Y', strtotime($value)) : '';
                                    break;
                                case 't_inc':
                                    $new_value = $value ." h";
                                    break;
                                case 'condizione_incbazione':
                                    $new_value = $value . " °C";
                                    break;
                                case 'gramN':
                                    $new_value = $value == 0 ? 'Nessuno' : 'Rilevati';
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'Societa':
                            switch ($key) {
                                case 'id_societa':
                                    if(gettype($value) == 'string')
                                    {
                                        $new_value = $value;
                                    }
                                    elseif(gettype($value) == 'integer')
                                    {
                                        $new_value = Societa::find($value)->nome;
                                    }
                                    else
                                    {
                                        $new_value = $value;
                                    }
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'User':
                            switch ($key) {
                                case 'id_utente':
                                    $new_value = User::find($value)->nome . " " . User::find($value)->cognome;
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'Struttura':
                            switch ($key) {
                                case 'id_struttura':
                                    $new_value = Struttura::find($value)->struttura;
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'AreaPartizione':
                            switch ($key) {
                                case 'areapartizione':
                                    $new_value = Reparto::find(AreaPartizione::find($value)->id_reparto)->partizione . " - " . AreaPartizione::find($value)->area_partizione;
                                    break;
                                case 'area_partizione':
                                    $new_value = ucfirst($value);
                                    break;
                                case 'codice_area_part':
                                    if(array_key_exists('id_campione',$dati))
                                    {
                                        $ap = Campione::find($dati['id_campione'])->id_areareparto;
                                        $new_value = AreaPartizione::find($ap)->codice_area_partizione;
                                    }
                                    else
                                    {
                                        $new_value = strtoupper($value);
                                    }
                                    break;
                                case 'codice_area_partizione':
                                    if(array_key_exists('id_campione',$dati))
                                    {
                                        $ap = Campione::find($dati['id_campione'])->id_areareparto;
                                        $new_value = AreaPartizione::find($ap)->codice_area_partizione;
                                    }
                                    else
                                    {
                                        $new_value = $value;
                                    }
                                    break;
                                case 'id_associazione':
                                    $id_partizione = AreaPartizione::find($value)->id_reparto;
                                    $area_partizione = AreaPartizione::find($value)->area_partizione;
                                    $new_value = Reparto::find($id_partizione)->partizione . " - " . $area_partizione;
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'Reparto':
                            switch ($key) {
                                case 'id_reparto':
                                    $new_value = Reparto::find($value)->partizione;
                                    break;
                                case 'reparto':
                                    $new_value = Reparto::find($value) != null ? Reparto::find($value)->partizione : $value;
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'Materiale':
                            switch ($key) {
                                case 'id_materiale':
                                    $new_value = Materiale::find($value)->materiale;
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'Prodotto':
                            switch ($key) {
                                case 'id_prodotto':
                                    $new_value = Prodotto::find($value)->prodotto;
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'Protocollo':
                            switch ($key) {
                                case 'id_protocollo':
                                    $new_value = Protocollo::find($value)->protocollo;
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'Antibiotico':
                            switch ($key) {
                                case 'id_antibiotico':
                                    $new_value = Antibiotico::find($value)->nome;
                                    break;
                                case 'aa':
                                    $new_value = [];
                                    foreach ($value as $n => $element) {
                                        foreach ($element as $id_key => $id_value) {
                                            switch ($id_key) {
                                                case 'id_antibiotico':
                                                    unset($value[$n][$id_key]);
                                                    $id_key = 'Antibiotico';
                                                    $value[$n][$id_key] = Antibiotico::find($id_value)->nome;
                                                    break;
                                                case 'key_resistenza':
                                                    unset($value[$n][$id_key]);
                                                    $id_key = 'Livello di resistenza:';
                                                    $value[$n][$id_key] = Antibiotico::resistenza()[intval($id_value)];
                                                    break;
                                                default:
                                                    $value[$n][$id_key] = $id_value;
                                                    break;
                                            }
                                            $new_value = $value;
                                        }
                                    }
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'PuntoCampionamento':
                            switch ($key) {
                                case 'id_punto_camp':
                                    $new_value = PuntoCampionamento::find($value)->punto_campionamento;
                                    break;
                                case 'matrice':
                                    $new_value = $value == 'S' ? 'Supercicie' : ($value == 'A' ? 'Aria' : 'Superficie ed Aria');
                                    break;
                                case 'codPC':
                                    $new_value = strtoupper($value);
                                    break;
                                case 'nome':
                                    $new_value = strtoupper($value);
                                    break;
                                case 'punto_campionamento':
                                    $new_value = strtoupper($value);
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'Campagna':
                            switch ($key) {
                                case 'id_campagna':
                                    $campagna = Campagna::find($value);
                                    $new_value = Societa::find($campagna->id_societa)->nome . " - " . Progetto::find($campagna->id_progetto)->progetto . " - " . Struttura::find($campagna->id_struttura)->struttura . " - " . Carbon::parse($campagna->dataCampagna)->format('d/m/Y');
                                    break;
                                case 'dataCampagna':
                                    $new_value = Carbon::parse($value)->format('d/m/Y');
                                    break;
                                case 'data_campagna':
                                    $new_value = Carbon::parse($value)->format('d/m/Y');
                                    break;
                                case 'crea_campagna':
                                    $new_value = $value == 'SALVA'  ? 'Si' : 'No';
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'Rilevatore':
                            $new_value = [];
                            switch ($key) {
                                case 'rilevatori':
                                    $new_value = [];
                                    foreach ($value as $n => $element) {
                                        foreach ($element as $id_key => $id_value) {
                                            $id_key = 'Rilevatore del campionamento';
                                            $value[$id_key] = Rilevatore::find($id_value)->rilevatore;
                                        }
                                    }
                                    $new_value = $value;
                                    break;
                                case 'tecnico':
                                    $new_value = Rilevatore::find($value)->rilevatore;
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'TipoPiastra':
                            switch ($key) {
                                case 'id_tipo_piastra':
                                    $new_value = TipoPiastra::find($value)->piastra;
                                    break;
                                case 'id_tipopiastra':
                                    $new_value = TipoPiastra::find($value)->piastra;
                                    break;
                                case 'abbreviazione':
                                    $new_value = strtoupper($value);
                                    break;
                                case 'id_piastra':
                                    $new_value = TipoPiastra::find($value)->piastra;
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'MicrorganismoPiastra':
                            switch ($key) {
                                case 'id_microrganismo':
                                    $new_value = MicrorganismoPiastra::find($value)->microrganismo;
                                    break;
                                case 'micro':
                                    $new_value = [];
                                    foreach ($value as $n => $element) {
                                        foreach ($element as $id_key => $id_value) {
                                            switch ($id_key) {
                                                case 'id_tipopiastra':
                                                    unset($value[$n][$id_key]);
                                                    $id_key = 'Terreno';
                                                    $value[$n][$id_key] = TipoPiastra::find($id_value)->piastra;
                                                    break;
                                                case 'id_microrganismo':
                                                    unset($value[$n][$id_key]);
                                                    $id_key = 'Microrganismo';
                                                    $value[$n][$id_key] = MicrorganismoPiastra::find($id_value)->microrganismo;
                                                    break;
                                                case 'cfu':
                                                    unset($value[$n][$id_key]);
                                                    $id_key = 'CFU';
                                                    $value[$n][$id_key] = $id_value;
                                                    break;
                                                case 'incertezzaSx':
                                                    unset($value[$n][$id_key]);
                                                    $id_key = 'Incertezza: limite di sinstra';
                                                    $value[$n][$id_key] = gettype($id_value) == 'string' ? 'Non calcolata' : $id_value;
                                                    break;
                                                case 'incertezzaDx':
                                                    unset($value[$n][$id_key]);
                                                    $id_key = 'Incertezza: limite di destra';
                                                    $value[$n][$id_key] = gettype($id_value) == 'string' ? 'Non calcolata' : $id_value;
                                                    break;
                                                default:
                                                    $value[$n][$id_key] = $id_value;
                                                    break;
                                            }
                                            $new_value = $value;
                                        }
                                    }
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'SpeciazioneCampione':
                            $new_value = [];
                            switch ($key) {
                                case 'micro_speciazione':
                                    foreach ($value as $n => $element) {
                                        foreach ($element as $id_key => $id_value) {
                                            switch ($id_key) {
                                                case 'id_tipopiastra':
                                                    $value[$id_key] = TipoPiastra::find($id_value)->piastra;
                                                    break;
                                                case 'id_microrganismo':
                                                    break;
                                                case 'tipoCamp':
                                                    $value[$id_key] = $id_value == 'S' ? 'Superficie' : 'Aria';
                                                    break;
                                                case 'speciazione_risultato':
                                                    $value[$id_key] = $id_value == 'NR' ? 'Non rilevato' : ($id_value == 'NA' ? 'Non Applicato' : 'Rilevato');
                                                    break;
                                                default:
                                                    $new_value = $value;
                                                    break;
                                            }
                                            $new_value = $value;
                                        }
                                    }
                                    break;
                                case 'speciazione':
                                    $new_value = $value == 1 ? 'Speciazione effettuata' : 'Speciazione non effettuata';
                                    break;
                                case 'incertezza':
                                    $new_value = $value == 1 ? 'Incertezza calcolata' : 'Incertezza non calcolata';
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'Metodo':
                            switch ($key) {
                                case 'id_metodo':
                                    $new_value = Metodo::find($value)->metodo;
                                    break;
                                
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'AntibioticoAntibiogramma':
                            switch ($key) {
                                case 'colonia':
                                    $new_value = $value == 0 ? 'No' : 'Si';
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;
                        case 'MicroAntibiogramma':
                            switch ($key) {
                                case 'nab_array':
                                    $new_value = [];
                                    foreach ($value as $n => $element) {
                                        foreach ($element as $id_key => $id_value) {
                                            switch ($id_key) {
                                                case 'NAB':
                                                    $value[$n][$id_key] = $id_value;
                                                    break;
                                                case 'colonia':
                                                    $value[$n][$id_key] = $id_value == 0 ? 'No' : 'Si';
                                                    break;
                                                default:
                                                    $value[$n][$id_key] = $id_value;
                                                    break;
                                            }
                                            $new_value = $value;
                                        }
                                    }
                                    break;
                                case 'id_microrganismo_antibiogramma':
                                    $new_value = MicrorganismoPiastra::find($value)->microrganismo;
                                    break;
                                default:
                                    $new_value = $value;
                                    break;
                            }
                            break;                         
                        default:
                            $new_value = $value;
                            break;
                    }
                    $dati[$new_key] = $new_value;
                }
                else
                {
                    $dati[$new_key] = $value;
                }
                unset($dati[$key]);
                // if($dati[$key] == 'Microrganismo' || $dati[$key] == 'Antibiotico usato in antibiogramma' || $dati[$key] == 'Antibiogramma' || $dati[$key] == 'Rilevatori')
                // {
                //     unset($dati[$key][0]);
                // }
            }
        }

        //delete keys with null value
        foreach ($dati as $key => $value) {
            if ($value == null) {
                unset($dati[$key]);
            }
        }

        return $dati;
    }
}
