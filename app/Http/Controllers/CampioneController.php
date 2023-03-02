<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Progetto;
use App\Campione;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Reparto;
use App\Stanza;
use App\Procedura;
use App\Protocollo;
use App\Materiale;
use App\Prodotto;
use App\PuntoCampionamento;
use App\Categoria;
use App\Rilevatore;
use App\TipoPiastra;
use App\Societa;
use App\Struttura;
use App\StruttRep;
use App\TemporaryImage;
use App\ImmaginiPiastre;
use App\MicroSuPiastra;
use App\MicroPiastra;
use App\MicroAntibiogramma;
use App\AntibioticoAntibiogramma;
use App\ImmagineMicroAntibiogramma;
use App\Campagna;
use App\CampioneAnalisiMolecolare;
use App\MicroAntibiogrammaSwab;
use App\Event\LoggerEvent;
use App\CampioniRilevatori;
use App\CampioniRilevatoriSWAB;
use App\ConversioneStrutturaStrutture;
use App\ConversionePartizioneReparti;
use App\ConversioneProgetto;
use App\AreaPartizione;
use App\ConversioneAbbreviazioneTipiPiastre;
use App\ConversionePuntiCampionamento;
use App\SpeciazioneCampione;
use App\Metodo;



class CampioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($campagna_id)
    {
        $campagna = Campagna::find($campagna_id);
        
        $societa = $campagna->societa()->first();
        // $reparti = $campagna->reparto()->first();

        $campioni_progetti_piastra = Progetto::join('campioni','progetti.id','=','campioni.id_progetto')
                                                ->join('campagna','campioni.id_campagna','=','campagna.id')
                                                ->where('campioni.id_campagna',$campagna_id)
                                                ->where('tipoScheda','0')
                                                ->where('tipoCampione','piastra')
                                                ->groupBy('progetti.id')
                                                ->count();
        $campioni_progetti_swab = Progetto::join('campioni','progetti.id','=','campioni.id_progetto')
                                                ->join('campagna','campioni.id_campagna','=','campagna.id')
                                                ->where('campioni.id_campagna',$campagna_id)
                                                ->where('tipoScheda','0')
                                                ->where('tipoCampione','tampone')
                                                ->groupBy('progetti.id')
                                                ->count();
        $campioni_progetti_analisi_molecolari = Progetto::join('campioni_analisi_molecolari','progetti.id','=','campioni_analisi_molecolari.id_progetto')
                                                ->join('campagna','campioni_analisi_molecolari.id_campagna','=','campagna.id')
                                                ->where('campioni_analisi_molecolari.id_campagna',$campagna_id)
                                                ->groupBy('progetti.id')
                                                ->count();

        if(\Artesaos\Defender\Facades\Defender::hasRole('admin') || \Artesaos\Defender\Facades\Defender::hasRole('gestore'))
        {
           
            $campioni_progetti_bianco = Progetto::join('campioni','progetti.id','=','campioni.id_progetto')
                                                ->join('campagna','campioni.id_campagna','=','campagna.id')
                                                ->where('campioni.id_campagna',$campagna_id)
                                                ->where('tipoScheda','1')
                                                ->groupBy('progetti.id')
                                                ->count();
            $campioni_progetti_qualita = Progetto::join('campioni','progetti.id','=','campioni.id_progetto')
                                                ->join('campagna','campioni.id_campagna','=','campagna.id')
                                                ->where('campioni.id_campagna',$campagna_id)
                                                ->where('tipoScheda','2')
                                                ->groupBy('progetti.id')
                                                ->count();
        }

        if(\Artesaos\Defender\Facades\Defender::hasRole('admin') || \Artesaos\Defender\Facades\Defender::hasRole('gestore'))
        {
            return view('schede.schede_campionamenti',compact('campioni_progetti_piastra','campioni_progetti_swab','campioni_progetti_bianco','campioni_progetti_qualita','campioni_progetti_analisi_molecolari','societa','campagna'));
        }
        else
        {
            return view('schede.schede_campionamenti',compact('campioni_progetti_piastra','campioni_progetti_swab','campioni_progetti_analisi_molecolari','societa','campagna'));
        }
    }

    /**
     * @param Request $request
     *
     * @return query query per riempimento tabella progetti in index schede_campionamento
     */
    public function list(Request $request, $id, $tipo)
    {
        $campagna = Campagna::find($id);
        if($tipo == 'campioni' || $tipo == 'bianco')
        {
           
            $dataSup =  Campione::join('area_partizione','campioni.id_areareparto','=','area_partizione.id')
                            ->join('reparti','reparti.id','=','area_partizione.id_reparto')
                            ->join('strutture','strutture.id','=','campioni.id_struttura')
                            ->join('tipi_piastre','tipi_piastre.id','=','campioni.id_tipo_piastra');

            if($tipo == 'campioni')
            {
                $dataSup = $dataSup->join('punti_campionamento','punti_campionamento.id','=','campioni.id_punto_camp')
                            ->whereIn('punti_campionamento.matrice',['S','E'])
                            ->where('campioni.id_campagna',$id)
                            ->orderBy('campioni.data','DESC');

                $dataSup = $dataSup->whereIn('tipoCampione',['piastra','tampone','attivo','passivo']);

                $dataSup = $dataSup->where('tipoScheda','=',0);

                $dataSup = $dataSup->select(['campioni.id as id',
                                        'campioni.id_campagna as id_campagna',
                                        'campioni.numStanza as numStanza',
                                        'campioni.data as dataCampionamento',
                                        'campioni.id_struttura as id_struttura',
                                        'campioni.id_progetto as id_progetto',
                                        'campioni.id_areareparto as id_areareparto',
                                        'campioni.dataCampagna as dataCampagna',
                                        'campioni.dataFineProva as dataFineProva',
                                        'campioni.tipoCamp as tipo_campionamento',
                                        'campioni.id_tipo_piastra as id_tipo_piastra',
                                        'campioni.id_punto_camp as id_punto_camp',
                                        'reparti.partizione as partizione',
                                        'strutture.struttura as struttura',
                                        'area_partizione.area_partizione as area',
                                        'campioni.tipoScheda as tipo']);
            }

            $dataAria =  Campione::join('area_partizione','campioni.id_areareparto','=','area_partizione.id')
                            ->join('reparti','reparti.id','=','area_partizione.id_reparto')
                            ->join('strutture','strutture.id','=','campioni.id_struttura')
                            ->join('tipi_piastre','tipi_piastre.id','=','campioni.id_tipo_piastra');
                            
            if($tipo == 'campioni')
            {
                $dataAria = $dataAria->join('punti_campionamento','punti_campionamento.id','=','campioni.pCampAria')
                            ->whereIn('punti_campionamento.matrice',['A','E'])
                            ->where('campioni.id_campagna',$id)
                            ->orderBy('campioni.data','DESC');

                $dataAria = $dataAria->whereIn('tipoCampione',['piastra','tampone','attivo','passivo']);

                $dataAria = $dataAria->where('tipoScheda','=',0);

                $dataAria = $dataAria->select(['campioni.id as id',
                                        'campioni.id_campagna as id_campagna',
                                        'campioni.numStanza as numStanza',
                                        'campioni.data as dataCampionamento',
                                        'campioni.id_struttura as id_struttura',
                                        'campioni.id_progetto as id_progetto',
                                        'campioni.id_areareparto as id_areareparto',
                                        'campioni.dataCampagna as dataCampagna',
                                        'campioni.dataFineProva as dataFineProva',
                                        'campioni.tipoCamp as tipo_campionamento',
                                        'campioni.id_tipo_piastra as id_tipo_piastra',
                                        'campioni.pCampAria as id_punto_camp',
                                        'reparti.partizione as partizione',
                                        'strutture.struttura as struttura',
                                        'area_partizione.area_partizione as area',
                                        'campioni.tipoScheda as tipo']);
            }

            if($tipo == 'bianco')
            {
                $data = $dataSup->where('campioni.id_campagna',$id)
                            ->orderBy('campioni.data','DESC');

                $data = $data->where('tipoScheda','=',1);

                $data = $data->select(['campioni.id as id',
                                        'campioni.id_campagna as id_campagna',
                                        'campioni.numStanza as numStanza',
                                        'campioni.data as dataCampionamento',
                                        'campioni.id_struttura as id_struttura',
                                        'campioni.id_progetto as id_progetto',
                                        'campioni.id_areareparto as id_areareparto',
                                        'campioni.dataCampagna as dataCampagna',
                                        'campioni.dataFineProva as dataFineProva',
                                        'campioni.tipoCamp as tipo_campionamento',
                                        'campioni.id_punto_camp as id_punto_camp',
                                        'campioni.id_tipo_piastra as id_tipo_piastra',
                                        'reparti.partizione as partizione',
                                        'strutture.struttura as struttura',
                                        'area_partizione.area_partizione as area',
                                        'campioni.tipoScheda as tipo']);
            }
            elseif($tipo == 'campioni')
            {
                $data = $dataSup->union($dataAria);
            }
                        
            return DataTables::of($data)
            ->addColumn('azione',function($data) {
                $button =   '<div class="row">';
                $button .=  "<div class=\"col-sm-4 w-a mr-0 pr-0\">";
                $button .=  '<a href="/campioni/' . $data->id . '/'.$data->id_campagna.'/'.$data->tipo.'/edit" class="btn btn-small btn-action btn-primary modifica_scheda" id="' . $data->id . '" data-toggle="tooltip" data-placement="top" title="Apri questa scheda" target="_blank"><i class="material-icons">open_in_new</i></a>';
                $button .=  "</div>";
                
                $button .=  "<div class=\"col-sm-4 w-a mr-0 pr-0\">";
                $button.=   '<span class="button-elimina" data-toggle="modal" data-target="#deleteModal">'.
                            '<a class="btn btn-small btn-action btn-danger btn-elimina" id="'.$data->id.'"  data-toggle="tooltip" data-placement="top" title="Elimina questa scheda"><i class="material-icons">delete</i></a>'.
                            '</span>';
                $button .=  '</div>';
                $button .=  '</div>';

                return $button;
            })
            ->editColumn('dataCampionamento',function($data){
                $data_campionamento = $data->dataCampionamento;
                return $data_campionamento;
            })
            ->editColumn('tipoCamp',function($data){
                return $data->tipo_campionamento == 'S' ? 'Superficie' : 'Aria';
            })
            ->editColumn('tipoPiastra',function($data){
                $piastra = TipoPiastra::find($data->id_tipo_piastra);
                if($piastra != null)
                {
                    return $piastra->abbreviazione;
                }
                else
                {
                    return 'Non specificato';
                }
            })
            ->editColumn('puntoCamp',function($data){
                $punto_camp = PuntoCampionamento::find($data->id_punto_camp);
                if($punto_camp != null)
                {
                    return ucfirst($punto_camp->punto_campionamento);
                }
                else
                {
                    return 'Non specificato'; 
                }
            })
            ->editColumn('struttura',function($data){
                $struttura = Struttura::find($data->id_struttura);
                if($struttura == null)
                {
                    return "Non specificato";
                }
                $struttura_v2 = Struttura::where('id',ConversioneStrutturaStrutture::strutturaV2($struttura->id) ?? $struttura->id)->first();
                
                if($struttura_v2 == null)
                {
                    return "Non specificato";
                }

                return $struttura_v2->struttura;
            })
            ->editColumn('reparto',function($data){
                $areaReparto = AreaPartizione::find($data->id_areareparto);
                $reparto = Reparto::find($areaReparto->id_reparto);
                return $reparto->partizione;
            })
            ->editColumn('area',function($data){
                $areaReparto = AreaPartizione::find($data->id_areareparto);
                return $areaReparto->area_partizione ?? 'Non specificato';
            })
            ->editColumn('stanza',function($data){
                $stanza = $data->numStanza;
                if($stanza == null)
                {
                    return "Non specificato";
                }
                return $stanza;
            })
            ->filterColumn('id', function ($query) use ($request) {
                $query->where('campioni.id', 'like', request()->search['value'] . "%");    
            })
            ->filterColumn('struttura', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('strutture.struttura', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('tipoCamp', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $keyword = substr($keyword,0,1);
                $query->where('campioni.tipoCamp', '=', $keyword);
            })
            ->filterColumn('puntoCamp', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('punti_campionamento.punto_campionamento', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('tipoPiastra', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('tipi_piastre.abbreviazione', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('reparto', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('reparti.partizione', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('area', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('area_partizione.area_partizione', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('dataCampionamento', function ($query) use ($request) {     
                if(strpos(request()->search['value'],'/') !== false)
                {
                    $date = explode('/', request()->search['value']);
                    //$date = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                    if(count($date) == 2 && $date[1] == '')
                    {
                        $query->where('data','like', "%" . $date[0]."%");
                    }
                    else if((count($date) == 2 && $date[1] != '') || (count($date) == 3 && $date[2] == ''))
                    {
                        $query->where('data','like', "%" . $date[1] . "-" . $date[0]."%");
                    }
                    else if(count($date) == 3 && $date[1] != '' && $date[2] != '')
                    {
                        $data = $date[2]."-".$date[1]."-".$date[0];
                        $query->where('data', $data);
                    }
                }
                else
                {
                    $query->where('data','like',"%".request()->search['value']."%");
                }   
            })
            ->filterColumn('dataFineProva', function ($query) use ($request) {     
                if(strpos(request()->search['value'],'/') !== false)
                {
                    $date = explode('/', request()->search['value']);
                    //$date = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                    if(count($date) == 2 && $date[1] == '')
                    {
                        $query->where('dataFineProva','like', "%" . $date[0]."%");
                    }
                    else if((count($date) == 2 && $date[1] != '') || (count($date) == 3 && $date[2] == ''))
                    {
                        $query->where('dataFineProva','like', "%" . $date[1] . "-" . $date[0]."%");
                    }
                    else if(count($date) == 3 && $date[1] != '' && $date[2] != '')
                    {
                        $data = $date[2]."-".$date[1]."-".$date[0];
                        $query->where('dataFineProva', $data);
                    }
                }
                else
                {
                    $query->where('dataFineProva','like',"%".request()->search['value']."%");
                }         
            })
            ->filterColumn('stanza', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('numStanza', 'like', "%" . $keyword . "%");
            })
            ->rawColumns(['dataCampagna','tipoCamp','struttura','reparto','area','stanza','tipoPiastra','puntoCamp','azione','id'])
            ->make(true);
        }
        if($tipo == 'analisimolecolari')
        {
            $dataSup = CampioneAnalisiMolecolare::join('progetti','campioni_analisi_molecolari.id_progetto','=','progetti.id')
                                            ->join('strutture','campioni_analisi_molecolari.id_struttura','=','strutture.id')
                                            ->join('area_partizione','campioni_analisi_molecolari.id_areareparto','=','area_partizione.id')
                                            ->join('punti_campionamento','punti_campionamento.id','=','campioni_analisi_molecolari.id_punto_camp')                
                                            ->join('reparti','area_partizione.id_reparto','=','reparti.id')
                                            ->where('campioni_analisi_molecolari.id_campagna',$id)
                                            ->orderBy('dataCampagna','DESC')
                                            ->select(['campioni_analisi_molecolari.id as id',
                                                        'campioni_analisi_molecolari.id_campagna as id_campagna',
                                                        'campioni_analisi_molecolari.numstanze as numStanza',
                                                        'strutture.struttura as struttura',
                                                        'area_partizione.id_reparto as id_reparto',
                                                        'area_partizione.area_partizione as area',
                                                        'area_partizione.codice_area_partizione as codice_area_partizione',
                                                        'campioni_analisi_molecolari.id_areareparto as id_areareparto',
                                                        'reparti.partizione as reparto',
                                                        'campioni_analisi_molecolari.tipoCamp as tipo_campionamento',
                                                        'campioni_analisi_molecolari.tipoPiastra as id_tipo_piastra',
                                                        'campioni_analisi_molecolari.id_punto_camp as id_punto_camp',
                                                        'campioni_analisi_molecolari.dataCampagna as dataCampagna',
                                                        'campioni_analisi_molecolari.dataAnalisi as dataFineProva'
                                            ]);

            $dataAria = CampioneAnalisiMolecolare::join('progetti','campioni_analisi_molecolari.id_progetto','=','progetti.id')
                                            ->join('strutture','campioni_analisi_molecolari.id_struttura','=','strutture.id')
                                            ->join('area_partizione','campioni_analisi_molecolari.id_areareparto','=','area_partizione.id')
                                            ->join('punti_campionamento','punti_campionamento.id','=','campioni_analisi_molecolari.PCampAria')                
                                            ->join('reparti','area_partizione.id_reparto','=','reparti.id')
                                            ->where('campioni_analisi_molecolari.id_campagna',$id)
                                            ->orderBy('dataCampagna','DESC')
                                            ->select(['campioni_analisi_molecolari.id as id',
                                                        'campioni_analisi_molecolari.id_campagna as id_campagna',
                                                        'campioni_analisi_molecolari.numstanze as numStanza',
                                                        'strutture.struttura as struttura',
                                                        'area_partizione.id_reparto as id_reparto',
                                                        'area_partizione.area_partizione as area',
                                                        'area_partizione.codice_area_partizione as codice_area_partizione',
                                                        'campioni_analisi_molecolari.id_areareparto as id_areareparto',
                                                        'reparti.partizione as reparto',
                                                        'campioni_analisi_molecolari.tipoCamp as tipo_campionamento',
                                                        'campioni_analisi_molecolari.tipoPiastra as id_tipo_piastra',
                                                        'campioni_analisi_molecolari.PCampAria as id_punto_camp',
                                                        'campioni_analisi_molecolari.dataCampagna as dataCampagna',
                                                        'campioni_analisi_molecolari.dataAnalisi as dataFineProva'
                                            ]);

            $data = $dataSup->union($dataAria);
            
            return DataTables::of($data)
            ->addColumn('azione',function($data) {
                $button =   '<div class="row">' . '<div class="col-sm-4 w-a mr-0 pr-0">';
                $button .=  '<a href="/campionianalisimolecolare/' . $data->id . '/'.$data->id_campagna.'/edit"  class="btn btn-small btn-action btn-primary modifica_scheda" id="' . $data->id . '" data-toggle="tooltip" data-placement="top" title="Apri questa scheda" target="_blank">Apri</a>';
                $button .= '</div>' . '<div class="col-sm-4 w-a mr-0 pr-0">';
                $button.= '<span class="button-elimina" data-toggle="modal" data-target="#deleteModal">'.
                            '<a class="btn btn-small btn-action btn-danger btn-elimina" id="'.$data->id.'"  data-toggle="tooltip" data-placement="top" title="Elimina questo referto">Elimina</a>'.
                        '</span>';

                $button .= '</div>' . '</div>';

                return $button;
            })
            ->editColumn('dataCampagna',function($data){
                $data_campagna = $data->dataCampagna;
                return $data_campagna;
            })
            ->editColumn('tipoCamp',function($data){
                return $data->tipo_campionamento == 'S' ? 'Superficie' : 'Aria';
            })
            ->editColumn('tipoPiastra',function($data){
                $piastra = TipoPiastra::find($data->id_tipo_piastra);
                if($piastra != null)
                {
                    return $piastra->abbreviazione;
                }
                else
                {
                    return 'Non specificato';
                }
            })
            ->editColumn('puntoCamp',function($data){
                $punto_camp = PuntoCampionamento::find($data->id_punto_camp);
                if($punto_camp != null)
                {
                    return ucfirst($punto_camp->punto_campionamento);
                }
                else
                {
                    return 'Non specificato'; 
                }
            })
            ->editColumn('struttura',function($data){
                $struttura = $data->struttura;
                return $struttura;
            })
            ->editColumn('reparto',function($data){
                $areaReparto = AreaPartizione::find($data->id_areareparto);
                $reparto = Reparto::find($areaReparto->id_reparto);
                return $reparto->partizione;
            })
            ->editColumn('area',function($data){
                $areaReparto = AreaPartizione::find($data->id_areareparto);
                return $areaReparto->area_partizione ?? 'Non specificato';
            })
            ->editColumn('stanza',function($data){
                $stanza = $data->numStanza;
                if($stanza == null)
                {
                    return "Non specificato";
                }
                return $stanza;
            })
            ->filterColumn('id', function ($query) use ($request) {
                $query->where('campioni.id', 'like', request()->search['value'] . "%");
            })
            ->filterColumn('struttura', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('struttura', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('reparto', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('reparto', 'like', "%" . $keyword . "%");
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
            ->filterColumn('tipoCamp', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $keyword = substr($keyword,0,1);
                $query->where('campioni.tipoCamp', '=', $keyword);
            })
            ->filterColumn('puntoCamp', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('punti_campionamento.punto_campionamento', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('tipoPiastra', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('tipi_piastre.abbreviazione', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('dataFineProva', function ($query) use ($request) {     
                if(strpos(request()->search['value'],'/') !== false)
                {
                    $date = explode('/', request()->search['value']);
                    //$date = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                    if(count($date) == 2 && $date[1] == '')
                    {
                        $query->where('dataFineProva','like', "%" . $date[0]."%");
                    }
                    else if((count($date) == 2 && $date[1] != '') || (count($date) == 3 && $date[2] == ''))
                    {
                        $query->where('dataFineProva','like', "%" . $date[1] . "-" . $date[0]."%");
                    }
                    else if(count($date) == 3 && $date[1] != '' && $date[2] != '')
                    {
                        $data = $date[2]."-".$date[1]."-".$date[0];
                        $query->where('dataFineProva', $data);
                    }
                }
                else
                {
                    $query->where('dataFineProva','like',"%".request()->search['value']."%");
                }         
            })
            ->filterColumn('stanza', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('numStanza', 'like', "%" . $keyword . "%");
            })
            ->rawColumns(['dataCampagna','tipoCamp','tipoPiastra','puntoCamp','struttura','reparto','stanza','azione','id'])
            ->make(true);
        }

        if($tipo == 'qualita')
        {
            $dataAria = Campione::join('tipi_piastre','tipi_piastre.id','=','campioni.id_tipo_piastra')
                                ->where('campioni.id_campagna',$id)
                                ->where('tipoScheda','=',2)
                                ->where('tipoCamp','A')
                                ->orderBy('dataCampagna','DESC')
                                ->select(['campioni.id as id',
                                    'campioni.id_campagna as id_campagna',
                                    'campioni.dataCampagna as dataCampagna',
                                    'campioni.dataFineProva as dataFineProva',
                                    'campioni.tipoCamp as tipo_campionamento',
                                    'campioni.id_tipo_piastra as id_tipo_piastra',
                                    'campioni.tipoScheda as tipo'
                                ]);
            Log::info($dataAria->get());

            $dataSup = Campione::join('tipi_piastre','tipi_piastre.id','=','campioni.id_tipo_piastra')
                                ->where('campioni.id_campagna',$id)
                                ->where('tipoScheda','=',2)
                                ->orderBy('dataCampagna','DESC')
                                ->select(['campioni.id as id',
                                    'campioni.id_campagna as id_campagna',
                                    'campioni.dataCampagna as dataCampagna',
                                    'campioni.dataFineProva as dataFineProva',
                                    'campioni.tipoCamp as tipo_campionamento',
                                    'campioni.id_tipo_piastra as id_tipo_piastra',
                                    'campioni.tipoScheda as tipo'
                                ]);
            Log::info($dataAria->get());


            $data = $dataAria->union($dataSup);

            return DataTables::of($data)
            ->addColumn('azione',function($data) {
                $button = '<div class="row">' . '<div class="col-sm-4 w-a mr-0 pr-0">';
                $button .=  '<a href="/campioni/' . $data->id . '/'.$data->id_campagna.'/'.$data->tipo.'/edit" class="btn btn-small btn-action btn-primary modifica_scheda" id="' . $data->id . '" data-toggle="tooltip" data-placement="top" title="Apri questa scheda" target="_blank">Apri</a>';
                $button .= '</div>' . '<div class="col-sm-4 w-a mr-0 pr-0">';
                $button.= '<span class="button-elimina" data-toggle="modal" data-target="#deleteModal">'.
                            '<a class="btn btn-small btn-action btn-danger btn-elimina" id="'.$data->id.'"  data-toggle="tooltip" data-placement="top" title="Elimina questo referto">Elimina</a>'.
                        '</span>';

                $button .= '</div>' . '</div>';

                return $button;
            })
            ->editColumn('dataCampagna',function($data){
                $data_campagna = $data->dataCampagna;
                return $data_campagna;
            })
            ->editColumn('struttura',function($data){ 
                return 'Non specificato';
            })
            ->editColumn('reparto',function($data){
                return 'Non specificato';
            })
            ->editColumn('tipoCamp',function($data){
                return $data->tipo_campionamento == 'S' ? 'Superficie' : 'Aria';
            })
            ->editColumn('tipoPiastra',function($data){
                $piastra = TipoPiastra::find($data->id_tipo_piastra);
                if($piastra != null)
                {
                    return $piastra->abbreviazione;
                }
                else
                {
                    return 'Non specificato';
                }
            })
            ->editColumn('puntoCamp',function($data){
                return 'Non specificato';
                // $punto_camp = PuntoCampionamento::find($data->id_punto_camp);
                // if($punto_camp != null)
                // {
                //     return ucfirst($punto_camp->punto_campionamento);
                // }
                // else
                // {
                //     return 'Non specificato'; 
                // }
            })
            ->editColumn('area',function($data){
                return 'Non specificato';
            })
            ->editColumn('stanza',function($data){
                return 'Non specificato';
            })
            ->filterColumn('id', function ($query) use ($request) {
                $query->where('campioni.id', 'like', request()->search['value'] . "%");
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
            ->filterColumn('tipoCamp', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $keyword = substr($keyword,0,1);
                $query->where('campioni.tipoCamp', '=', $keyword);
            })
            ->filterColumn('puntoCamp', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('punti_campionamento.punto_campionamento', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('tipoPiastra', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('tipi_piastre.abbreviazione', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('dataFineProva', function ($query) use ($request) {     
                if(strpos(request()->search['value'],'/') !== false)
                {
                    $date = explode('/', request()->search['value']);
                    if(count($date) == 2 && $date[1] == '')
                    {
                        $query->where('dataFineProva','like', "%" . $date[0]."%");
                    }
                    else if((count($date) == 2 && $date[1] != '') || (count($date) == 3 && $date[2] == ''))
                    {
                        $query->where('dataFineProva','like', "%" . $date[1] . "-" . $date[0]."%");
                    }
                    else if(count($date) == 3 && $date[1] != '' && $date[2] != '')
                    {
                        $data = $date[2]."-".$date[1]."-".$date[0];
                        $query->where('dataFineProva', $data);
                    }
                }
                else
                {
                    $query->where('dataFineProva','like',"%".request()->search['value']."%");
                }         
            })
            ->rawColumns(['dataCampagna','azione','tipoCamp','tipoPiastra','puntoCamp','id'])
            ->make(true);
            
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Boolean $direct
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $ids = Array();
        $tipo = $request->tipo;
        $campagna = Campagna::find($request->campagna_id);
        $societa = $campagna->societa()->first();
        $areareparto = StruttRep::join('area_partizione','area_partizione.id','=','strutture_reparti_envass.id_associazione')
                        ->where('id_struttura',$campagna->id_struttura)
                        ->where('id_progetto',$campagna->id_progetto)
                        ->select('area_partizione.*')
                        ->groupby('area_partizione.id_reparto')
                        ->get();

        $strutture = $campagna->struttura()->first();
        $progetti = Progetto::where('id',$campagna->id_progetto)->get();
       
        foreach($progetti as $p)
        {
            array_push($ids,$p->id); 
        }

        $rilevatori = Rilevatore::where('id_progetto',null);
        $procedure = Procedura::where('id_progetto',null);
        for($i = 0; $i < count($ids); $i++)
        {
            $rilevatori = $rilevatori->orWhere('id_progetto',$ids[$i]);
            $procedure = $procedure->orWhere('id_progetto',$ids[$i]);

        }
        $rilevatori = $rilevatori->select('rilevatori.*')->get();
        $procedure = $procedure->select('eprocedure.*')->get();

        //$stanze = Stanza::all();
        $prodotti = Prodotto::all();
        $materiali = Materiale::where('versione',2)->get();
        $protocolli = Protocollo::all();
        $categorie = Categoria::where('versione',2)->get();
        $piastre = TipoPiastra::where('versione',2)->get();
        $metodi = Metodo::all();
        $code = $this->generateUniqueCode();
        $numeroProgressivo = 0;

        return view('schede.edit_scheda',compact('progetti','areareparto','procedure','prodotti','metodi','materiali','protocolli','categorie','rilevatori','piastre','societa','strutture','numeroProgressivo','code','campagna','tipo'));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$campagna,$tipo)
    {
        if($tipo == 0)
        {
            $tipo = 'N';
        }
        if($tipo == 1)
        {
            $tipo = 'B';
        }
        if($tipo == 2)
        {
            $tipo = 'Q';
        }

        $campione = Campione::find($id);
        $campagna = Campagna::find($campione->id_campagna);
        $societa = $campagna->societa()->first();
        $strutture = $campagna->struttura()->first();
        $progetto = $campagna->progetto()->first();
        $areareparto = AreaPartizione::where('id',$campione->id_areareparto)->get();
        $metodi = Metodo::all();
        $metodo_campione = Metodo::where('id',$campione->id_metodo)->first();
        // Log::info($societa);
        // Log::info($campagna);
        // Log::info($areareparto);
        if($tipo != 'Q')
        {
            $progetti = Progetto::join('strutture_reparti_envass','strutture_reparti_envass.id_progetto','=','progetti.id')
                                ->where('strutture_reparti_envass.id_struttura',$strutture->id)
                                ->where('strutture_reparti_envass.id_associazione',$campione->id_areareparto)
                                ->where('progetti.id',ConversioneProgetto::progettoV2($campione->id_progetto) ?? $campione->id_progetto)
                                ->first();

            $rilevatori = Rilevatore::where('id_progetto',null)->orWhere('id_progetto',$progetti->id_progetto ?? null)->select('rilevatori.*')->withTrashed()->get();

            $procedure = Procedura::where('id_progetto',0)->orWhere('id_progetto',$progetti->id_progetto ?? '')->select('eprocedure.*')->get();

            $associazionePartizioneArea = $progetti->id_associazione ?? '';

        }
        else
        {
            $rilevatori = Rilevatore::where('id_progetto',null)->withTrashed()->get();
        }
       
        /**Calcolo campioni rilevatori */
        $campione_rilevatore = CampioniRilevatori::where('id_campione',$campione->id)->get();
        $cp = Array();
        foreach ($rilevatori as $r)
        {
            $cp[$r->id] = 0;
        }
        foreach ($campione_rilevatore as $value) 
        {
            $cp[$value->id_rilevatore] = 1;
        }
        /**--------------------- */

        //$stanze = Stanza::all();
        $prodotti = Prodotto::all();
        $materiali = Materiale::where('versione',2)->get();
        $protocolli = Protocollo::all();
        $categorie = Categoria::where('versione',2)->get();
        $piastre = TipoPiastra::where('versione',2)->get();
        $code = $this->generateUniqueCode();
        $numeroProgressivo = 0;
        $occorrenza = isset($campione->microantibiogramma) ? count($campione->microantibiogramma->where('NAB','!=',0) ?? 0) : 0;
        if($tipo != 'Q')
        {
            return view('schede.edit_scheda',compact('campione','progetto','progetti','areareparto','procedure','materiali','prodotti','protocolli','categorie','rilevatori','piastre','societa','strutture','numeroProgressivo','code','occorrenza','campagna','cp','tipo','associazionePartizioneArea','metodi','metodo_campione'));
        }
        else
        {
            return view('schede.edit_scheda',compact('campione','materiali','prodotti','protocolli','categorie','rilevatori','piastre','societa','numeroProgressivo','code','occorrenza','campagna','cp','tipo'));
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
        //Log::info($request);
        
        if($request->tipoScheda == 'N')
        {
            $validator = Validator::make($request->all(), [
                'tipoScheda' => 'required',
                'id_progetto' => 'required',
                'id_campagna' => 'required|numeric',
                'dataCampagna' => 'required|date|before_or_equal:today',
                'id_struttura' => 'required|numeric',
                'dataPartenza' => 'required|date',
                'oraPartenza' => 'required',
                'dataInizio' => 'required|date',
                'oraInizio' => 'required',
                'dataFine' => 'required|date',
                'oraFine' => 'required',
                'dataArrivo' => 'required|date',
                'oraArrivo' => 'required',
                'tecnico' => 'numeric|required',
                'dataAnalisi' => 'required|date',
                'oraInizioAnalisi' => 'required',
                'oraFineAnalisi' => 'required',
                'dataFineAnalisi' => 'required|date',
                'superficie' => 'boolean',
                'aria' => 'boolean',
                'id_procedura' => 'sometimes|numeric',
                'id_protocollo' => 'sometimes|numeric',
                'id_prodotto' => 'sometimes|numeric',
                'id_punto_camp' => 'sometimes|numeric',
                'id_materiale' => 'sometimes|numeric',
                'procedura' => 'numeric',
                'vccc' => 'sometimes|boolean',
                'laminare' => 'sometimes|boolean',
                'turbolento' => 'sometimes|boolean',
                'operational' => 'sometimes|boolean',
                'at_rest' => 'sometimes|boolean',
                'pCampAria' => 'sometimes|numeric',
                'codDiff' => 'sometimes',
                'id_tipo_piastra' => 'numeric|required',
                'DII' => 'date',
                't_inc' => 'numeric',
                'siGramRil' => 'boolean',
                'noGramRil' => 'boolean',
                'gramN' => 'sometimes|numeric',
                'reparto' => 'numeric|required',
                'lineeGuida1' => 'boolean',
                'lineeGuida2' => 'boolean',
                'lineeGuida3' => 'boolean',
                'lineeGuida4' => 'boolean',
                'scadenza' => 'date',
                'rilevatori' => 'required'
            ]);
        }

        if($request->tipoScheda == 'B')
        {
            $validator = Validator::make($request->all(), [
                'tipoScheda' => 'required',
                'id_progetto' => 'required|numeric',
                'id_campagna' => 'required|numeric',
                'dataCampagna' => 'required|date|before_or_equal:today',
                'id_struttura' => 'required|numeric',
                'dataPartenza' => 'required|date',
                'oraPartenza' => 'required',
                'dataInizio' => 'required|date',
                'oraInizio' => 'required',
                'dataFine' => 'required|date',
                'oraFine' => 'required',
                'dataArrivo' => 'required|date',
                'oraArrivo' => 'required',
                'tecnico' => 'numeric|required',
                'dataAnalisi' => 'required|date',
                'oraInizioAnalisi' => 'required',
                'oraFineAnalisi' => 'required',
                'dataFineAnalisi' => 'required|date',
                'superficie' => 'boolean',
                'aria' => 'boolean',
                'id_procedura' => 'sometimes|numeric',
                'id_tipo_piastra' => 'numeric|required',
                'DII' => 'date',
                't_inc' => 'numeric',
                'siGramRil' => 'boolean',
                'noGramRil' => 'boolean',
                'gramN' => 'sometimes|numeric',
                'reparto' => 'numeric|required',
                'scadenza' => 'date',
                'rilevatori' => 'required'
            ]);
        }

        if($request->tipoScheda == 'Q')
        {
            $validator = Validator::make($request->all(), [
                'tipoScheda' => 'required',
                'id_campagna' => 'required|numeric',
                'dataCampagna' => 'required|date|before_or_equal:today',
                'tecnico' => 'numeric|required',
                'dataAnalisi' => 'required|date',
                'oraInizioAnalisi' => 'required',
                'oraFineAnalisi' => 'required',
                'dataFineAnalisi' => 'required|date',
                'superficie' => 'boolean',
                'aria' => 'boolean',
                'id_procedura' => 'sometimes',
                'id_tipo_piastra' => 'numeric|required',
                't_inc' => 'numeric',
                'siGramRil' => 'boolean',
                'noGramRil' => 'boolean',
                'gramN' => 'sometimes|numeric',
                'scadenza' => 'date',
                'rilevatori' => 'required'
            ]);
        }
       
        if ($validator->fails()) {
            $messages = $validator->messages();
            return response()->json(['error' => $messages], 403);
        }

        if((!isset($request->tipoCampione) || $request->tipoCampione == null || $request->tipoCampione == '') && ($request->tipoScheda == 'N' || $request->tipoScheda == 'Q'))
        {
            $messages = "Specificare il tipo del campione";
            return response()->json(['error' => $messages], 403); 
        }
        
        /**
         * Controllare che ci sia almeno una immagine piastra per il campionamento
         */
        
        $immagine_piastra_inserita = TemporaryImage::where('code',$request->code)->where('tipo',"=",'piastra1')->first();
        if($immagine_piastra_inserita == null)
        {
            $messages = "Immagine piastra mancante, correggere";
            return response()->json(['error' => $messages], 403); 
        }

        /**
         * Controllo su immagine piastra extra
         */
        $immagineTempPiastra2 = TemporaryImage::where('code',$request->code)->where('tipo','piastra2')->first();
        if(isset($request->t_inc_extra))
        {
            if($immagineTempPiastra2 == null)
            {
                $messages = "Immagine piastra extra mancante, inserire immagine o non specificare tempo di incubazione extra";
                return response()->json(['error' => $messages], 403); 
            }
        }

        // if($immagineTempPiastra2 != null)
        // {
        //     if(!isset($request->t_inc_extra))
        //     {
        //         $messages = "tempo di incubazione extra mancante con immagine piastra extra inserita, da correggere";
        //         return response()->json(['error' => $messages], 403); 
        //     }
        // }

        /**
         * Controllo sull'immagine dell'antibiogramma con NAB = 0 (Cioè conta colonie)
         */
        $immagine_temporanea_antibiogramma0 = TemporaryImage::where('code',$request->code)->where('tipo','antibiogramma0')->first();
        if(!isset($request->id_microrganismo_antibiogramma) && $immagine_temporanea_antibiogramma0 != null)
        {
            $messages = "Microrganismo non specificato, correggere";
            return response()->json(['error' => $messages], 403); 
        }
        if(isset($request->id_microrganismo_antibiogramma) && $immagine_temporanea_antibiogramma0 == null)
        {
            $messages = "Immagine antibiogramma per conta colonie mancante, correggere";
            return response()->json(['error' => $messages], 403); 
        }

        if(isset($request->aa))
        {
            foreach ($request->aa as $key => $value) {
                //se sono nel caso in cui ho aggiunto un form per l'antibiogramma ma non ho inserito nulla, procedo. Altrimenti se ho mancato di inserire qualche campo ritorno errore.

                //Il primo if serve a capire se tutti e tre i campi di interesse sono vuoti. Per procedere nego l'ipotesi. 
                if(!((!isset($value['NAB']) || $value['NAB'] == null) && (!isset($value['id_antibiotico']) || $value['id_antibiotico'] == null) && (!isset($value['key_resistenza']) || $value['key_resistenza'] == null)))
                {
                    if((!isset($value['NAB']) || $value['NAB'] == null))
                    {
                        $messages = "Inserire un valore corretto per il campo NAB";
                        return response()->json(['error' => $messages], 403); 
                    }
                    if((!isset($value['id_antibiotico']) || $value['id_antibiotico'] == null))
                    {
                        $messages = "Inserire un valore corretto per il campo antibiotico";
                        return response()->json(['error' => $messages], 403); 
                    }
                    if((!isset($value['key_resistenza']) || $value['key_resistenza'] == null))
                    {
                        $messages = "Inserire un valore corretto per il campo resistenza";
                        return response()->json(['error' => $messages], 403); 
                    }
                } 
            }
        }

        if(!isset($request->rilevatori))
        {
            $message = "Inserire almeno un rilevatore del campionamento";
            return response()->json(['error' => $message],403);
        }

        $progetto = Progetto::where('id',$request->id_progetto)->first();
        
        if($progetto == null && ($request->tipoScheda == 'N' || $request->tipoScheda == 'B'))
        {
            return response()->json(['error' => 'Progetto non trovato, riprovare'], 403);
        }

        // $stanza = stanza::where('stanza',$request->stanza)->first();
        
        // if($stanza == null && $request->tipoScheda == 'N')
        // {
        //     return response()->json(['error' => 'Stanza non trovata, riprovare'], 403);
        // }

        $id_societa = $request->id_societa; //non viene salvato nel campione ma è inviato alla prossima scheda

        $campione = new Campione;

        $crea_areapartizione = false;
         
        /**
         * Anagrafica
         */
        if($request->tipoScheda == 'N' || $request->tipoScheda == 'B')
        {
            $campione->id_progetto = $progetto->id;
            $campione->id_struttura = $request->id_struttura;
            
            $areaReparto = AreaPartizione::where('id_reparto',$request->reparto)->where('area_partizione',$request->area_partizione)->first();
            /**
             * Se non esiste l'area partizione significa che l'utente non è mai stato in quell'area e non l'ha creata nella gestione interna 
             * dunque la creo
             */
            if($areaReparto == null)
            {
                $crea_areapartizione = true;
            }
            else
            {
                $campione->id_areareparto = $areaReparto->id;
            }
        }
        $campione->id_campagna = $request->id_campagna;
        $campione->dataCampagna = $request->dataCampagna;
        $campione->data_accettazione = $request->data_accettazione;
        $campione->data = $request->dataCampionamento;
        $campione->dataPartenza = $request->dataPartenza;
        $campione->oraPartenza = $request->oraPartenza;
        $campione->dataInizio = $request->dataInizio;
        $campione->oraInizio = $request->oraInizio;
        $campione->dataFine = $request->dataFine;
        $campione->oraFine = $request->oraFine;
        $campione->dataArrivo = $request->dataArrivo;
        $campione->oraArrivo = $request->oraArrivo;
        
        /**
         * Sito campionamento
         */
        // $campione->codiceCIAS = $request->codice_area_partizione;
        $campione->numStanza = $request->numStanza;
        $campione->umidAmb = $request->umidAmb;
        $campione->tempAmb = $request->tempAmb;
        $campione->dettaglio = $request->dettaglio;
        $campione->lineeGuida1 = intval($request->lineeGuida1);
        $campione->lineeGuida2 = intval($request->lineeGuida2);
        $campione->lineeGuida3 = intval($request->lineeGuida3);
        $campione->lineeGuida4 = intval($request->lineeGuida4);
        $campione->classeGMP = $request->classeGMP;
        $campione->classificazioneISO = $request->classificazioneISO; 
        $campione->anomalie = $request->anomalie;
        /**
         * Campionamento
         */
        $superficie = isset($request->superficie) ? $request->superficie : 0;
        $aria = isset($request->aria) ? $request->aria : 0;
        $laminare = isset($request->laminare) ? $request->laminare : 0;
        $turbolento = isset($request->turbolento) ? $request->turbolento : 0;
        $operational = isset($request->operational) ? $request->operational : 0;
        $at_rest = isset($request->at_rest) ? $request->at_rest : 0;
        $gramRil = $request->siGramRil == '1' ? 1 : $request->noGramRil;
        //$campione->procedura = $request->id_procedura;
        $campione->id_metodo = $request->id_metodo;
        $campione->tipoCamp = $superficie == 1 ? "S" : "A";
        $campione->id_protocollo = (isset($request->id_protocollo) && $superficie == 1) ? $request->id_protocollo : 0;
        $campione->id_prodotto = (isset($request->id_prodotto) && $superficie == 1) ? $request->id_prodotto : 0;
        $campione->fase_Camp = (isset($request->fase_Camp) && $superficie == 1) ? $request->fase_Camp : 0;
        $campione->tdaSanif = (isset($request->tdaSanif) && $superficie == 1) ? $request->tdaSanif : 0;
        $campione->id_punto_camp = (isset($request->id_punto_camp) && $superficie == 1) ? $request->id_punto_camp : 0;
        $campione->id_superficie = (isset($request->id_materiale) && $superficie == 1) ? $request->id_materiale : 0;
        $campione->flusso = $laminare == 1 ? "L" : "T";
        $campione->operat = $operational == 1 ? "O" : "R";
        $campione->vccc = isset($request->vccc) ? $request->vccc : 0;
        $campione->n_persone = isset($request->n_persone) ? $request->n_persone : 0;
        $campione->pCampAria = isset($request->pCampAria) ? $request->pCampAria : 0;
        $campione->codDiff = isset($request->codDiff) ? $request->codDiff : 0;
        $campione->gramRil = $gramRil;
        $campione->gramN = $gramRil == 1 ? $request->gramN : 0;
        /**
         * Analisi
         */
        $campione->tecnico = $request->tecnico;
        $campione->dataAnalisi = $request->dataAnalisi;
        $campione->oraInizioAnalisi = $request->oraInizioAnalisi;
        $campione->oraFineAnalisi = $request->oraFineAnalisi;
        $campione->dataFineAnalisi = $request->dataFineAnalisi;
        /**
         * Campione
         */
        $campione->id_tipo_piastra = $request->id_tipo_piastra;
        $campione->lotto = $request->lotto;
        $campione->scadenza = $request->scadenza;
        $campione->DII = $request->DII;
        $campione->note = $request->note;
        $campione->t_inc = intval($request->t_inc);
        $campione->condizione_incubazione = $request->condizione_incubazione;
        isset($request->t_inc_extra) ? $campione->t_inc_extra = intval($request->t_inc_extra) : $campione->t_inc_extra = 0;

        $campione->incertezza = $request->incertezza;
        $campione->speciazione = $request->speciazione;

        //Tipo Campionamento
        //0 -> statico
        //1 -> personale
        //Di default settato a statico in quanto per scelta progettuale sembra essere sempre così.
        $campione->tipoCampionamento = 0;

        //tipoScheda           
        //              N        B           Q
        //  0           X
        //
        //  1                    X
        //
        //  2                                X
        // Log::info($request->tipoScheda);
       
        if($request->tipoScheda == 'N')
        {
            $campione->tipoCampione = $request->tipoCampione;
            $campione->tipoScheda = 0;
        }
        if($request->tipoScheda == 'B')
        {
            $campione->tipoCampione = 'piastra';
            $campione->tipoScheda = 1;
        }
        if($request->tipoScheda == 'Q')
        {
            $campione->tipoCampione = $request->tipoCampione;
            $campione->tipoScheda = 2;
        }
        
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $campione->save();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $campione->dataFineProva = $campione->data;

        if($crea_areapartizione == true)
        {
            $areaReparto = new AreaPartizione;
            $areaReparto->id_reparto = $request->reparto;
            $areaReparto->area_partizione = $request->area_partizione;
            $areaReparto->codice_area_partizione = substr($request->area_partizione, 0, 3);
            $areaReparto->save();

            $campione->id_areareparto = $areaReparto->id;

            /**Se ho dovuto creare un area reparto, allora devo salvare anche una nuova tupla PROGETTO-STRUTTURA-PARTIZIONE-AREAREPARTO */
            $progettoStrutturaPartizione = new StruttRep;
            $progettoStrutturaPartizione->id_progetto = $request->id_progetto;
            $progettoStrutturaPartizione->id_struttura = $request->id_struttura;
            $progettoStrutturaPartizione->id_reparto = $request->reparto;
            $progettoStrutturaPartizione->id_associazione = $areaReparto->id;
            $progettoStrutturaPartizione->versione = 2;
            $progettoStrutturaPartizione->save();

        }

        if($campione->tipoCamp == 'A' && $campione->operat == 'O' && $campione->pCampAria == 161)
        {
            $campione->codiceCIAS = $this->createCodiceCias($request->dataCampionamento, $request->reparto, $areaReparto, $reqeust->numStanza, $request->id_tipo_piastra, $campione->pCampAria, True, True, True, False);
        }
        elseif($request->tipoScheda == 'B')
        {
            $campione->codiceCIAS = $this->createCodiceCias($request->dataCampionamento, $request->reparto, $areaReparto, null, $request->id_tipo_piastra, null, False, False, False, True);
        }
        elseif($request->tipoScheda == 'Q')
        {
            $campione->codiceCIAS = $this->createCodiceCias($request->dataCampionamento, $request->reparto, null, null, $request->id_tipo_piastra, null, False, False, False, False, True);
        }
        else
        {
            $campione->codiceCIAS = $this->createCodiceCias($request->dataCampionamento, $request->reparto, $areaReparto, $request->numStanza, $request->id_tipo_piastra, (isset($request->id_punto_camp) && $superficie == 1) ? $request->id_punto_camp : $request->pCampAria);
        }

        if(isset($request->codiceCIAS_appendice) && $request->codiceCIAS_appendice != "")
        {
            $campione->codiceCIAS .= "_".$request->codiceCIAS_appendice;
        }

        $campione->update();
        
        /**
         * Salvataggio rilevatori
         */
        foreach($request->rilevatori as $ril)
        {
            $ril_camp = new CampioniRilevatori;
            $ril_camp->id_campione = $campione->id;
            $ril_camp->id_rilevatore = $ril['id'];
            $ril_camp->save();
        }


        /**
         * Salvataggio dei microrganismi
         */
        if(isset($request->micro))
        {
            foreach ($request->micro as $key => $value) {
                //salvataggio del microrganismo associato al campione con la relativa piastra e grandezza
                $microsupiastra = new MicroSuPiastra;
                $microsupiastra->id_microrganismo = $value['id_microrganismo'];
                $microsupiastra->id_campione = $campione->id;
                $microsupiastra->id_tipopiastra = $value['id_tipopiastra'];
                $microsupiastra->CFU = $value['cfu'];
                $microsupiastra->incertezzaSx = $value['incertezzaSx'] == 'null' ? null : $value['incertezzaSx'];
                $microsupiastra->incertezzaDx = $value['incertezzaDx'] == 'null' ? null : $value['incertezzaDx'];
                $microsupiastra->save();
            }
        }    

        /**
         * Salvataggio dei microrganismi per speciazione
         */
        if(isset($request->micro_speciazione) && $request->speciazione == 1)
        {
            foreach ($request->micro_speciazione as $key => $value) {
                //salvataggio del microrganismo associato al campione con la relativa piastra e grandezza
                $speciazione = new SpeciazioneCampione;
                $speciazione->id_microrganismo = $value['id_microrganismo'];
                $speciazione->id_campione = $campione->id;
                $speciazione->id_tipopiastra = $value['id_tipopiastra'];
                $speciazione->id_punto_camp = $campione->id_punto_camp != 0 ? $campione->id_punto_camp : $campione->pCampAria;
                $speciazione->esito = $value['speciazione_risultato'];
                $speciazione->tipoCamp = $campione->tipoCamp;
                $speciazione->save();
            }
        }

        /**
         * Salvataggio della foto della piastra
         */
        $temporaryFile = TemporaryImage::where('code',$request->code)->get();
        if($temporaryFile != null)
        {
            foreach ($temporaryFile as $image) {
                /**
                 * Generazione nome
                */
                $nuovonome = $image->nome_file;
                if($request->tipoScheda == 'Q')
                {
                    $nuovonome = $campione->id."Q";
                }
                else
                {
                    if($image->tipo == 'piastra1')
                    {
                        $codiceStrRep = "";
                        $id_progetto = ConversioneProgetto::progettoV2($campione->progetto->id) ?? $campione->progetto->id;
                        $id_struttura = ConversioneStrutturaStrutture::strutturaV2($campione->struttura->id) ?? $campione->struttura->id;
                        $id_partizione = ConversionePartizioneReparti::partizioneV2($campione->reparto->id_reparto) ?? $campione->reparto->id_reparto;
                        $codice_area_partizione = $campione->reparto->codice_area_partizione;
                        $progetto = Progetto::find($id_progetto);
                        $struttura = Struttura::find($id_struttura);
                        $partizione = Reparto::find($id_partizione);

                        if($progetto != null)
                        {
                            $codiceStrRep = $progetto->CodPro;
                        }
                        if($struttura != null)
                        {
                            $codiceStrRep .= "_".$struttura->codice_struttura . "_".$struttura->codice_sede."_".$struttura->codice_provincia;
                        }
                        if($partizione != null)
                        {
                            $codiceStrRep .= "_".$partizione->codice_partizione;
                        }
                        if($codice_area_partizione != null)
                        {
                            $codiceStrRep .= "_".$codice_area_partizione;
                        }

                        
                        $nuovonome = $campione->dataCampagna->format('Y');
                        $nuovonome .= "_".$campione->dataCampagna->format('m');
                        $nuovonome .= "_".$campione->dataCampagna->format('d');
                        if($codiceStrRep != '')
                        {
                            $nuovonome .= "_". $codiceStrRep;
                        }
                        else
                        {
                            $nuovonome .= (isset($campione->progetto->codPro) ? "_".$campione->progetto->CodPro : '');
                            $nuovonome .= (isset($campione->struttura->codice_struttura) ? "_".$campione->struttura->codice_struttura : '');
                        }
                        $nuovonome .= isset($campione->numStanza) ? "_".$campione->numStanza : '';
                        $nuovonome .= isset($campione->tipopiastra) ? "_".TipoPiastra::find($campione->tipopiastra->id)->abbreviazione : '';
                        $nuovonome .= $campione->puntocampionamento != '' ? ("_".PuntoCampionamento::find(ConversionePuntiCampionamento::punto_campionamentoV2($campione->puntocampionamento->id) ?? $campione->puntocampionamento->id)->codPC ?? '') : '';
                        $nuovonome .= "_P";
                    }
                    elseif($image->tipo == 'piastra2')
                    {
                        $nuovonome = $campione->id."E";
                        $nuovonome .= isset($campione->t_inc_extra) ? $campione->t_inc_extra : '0';
                    }
                    elseif($image->tipo == 'antibiogramma0')
                    {
                        $nuovonome = "C".$campione->id;
                    }
                }
                

                /**
                 * Verifica esistenza immagine con conseguente cambio nome e salvataggio immagine in cartella
                 */
                if($image->tipo == 'piastra1' || $image->tipo == 'piastra2')
                {
                    $nomecompleto = explode('.',$image->nome_file);
                    $estensione = $nomecompleto[1];
                    $i = 0;
                    $nuovonome .= ".".$estensione;
                    while(1){
                        if(!Storage::disk('public')->exists("$campione->id/$nuovonome")){
                            //Storage::disk('public')->move("temporary/$image->nome_file","$nuovonome.jpg" );
                            Storage::disk('public')->copy("temporary/$image->nome_file","$campione->id/$nuovonome");
                            break;
                        }else{
                            $i++;
                            $nomecompleto = explode('.',$nuovonome);
                            $nome = $nomecompleto[0]."($i)";
                            $estensione = $nomecompleto[1];
                            $nuovonome = $nome.".".$estensione;
                        }
                    }
                    //TO DO: creo segnalazione qui per dire che esiste già un immagine con quel nome
                    
                }
                elseif($image->tipo == 'antibiogramma0')
                {
                    $nomecompleto = explode('.',$image->nome_file);
                    $estensione = $nomecompleto[1];
                    $i = 0;
                    $nuovonome .= ".".$estensione;
                    while(1){
                        if(!Storage::disk('public')->exists("$campione->id/antibiogrammi/$nuovonome")){
                            //Storage::disk('public')->move("temporary/$image->nome_file","$nuovonome.jpg" );
                            Storage::disk('public')->copy("temporary/$image->nome_file","$campione->id/antibiogrammi/$nuovonome");
                            break;
                        }else{
                            $i++;
                            $nomecompleto = explode('.',$nuovonome);
                            $nome = $nomecompleto[0]."($i)";
                            $estensione = $nomecompleto[1];
                            $nuovonome = $nome.".".$estensione;
                        }
                    }
                    //TO DO: creo segnalazione qui per dire che esiste già un immagine con quel nome   
                }

                /**
                 * Salvataggio immagine in database
                 */
                if($image->tipo == 'piastra1' || $image->tipo == 'piastra2')
                {
                    $path = Storage::disk('public')->path("$nuovonome");

                    $immagine = new ImmaginiPiastre;
                    $immagine->id_campione = $campione->id;
                    $immagine->nome_file = $nuovonome;
                    $immagine->path_file = $path;
                    $immagine->tipo = $image->tipo;
                    $immagine->save();

                    //Elimino il riferimento al file temporaneo nella tabella delle immagini temporanee
                    $image->delete();
                }
                elseif($image->tipo == 'antibiogramma0')
                {
                    $path = Storage::disk('public')->path("$campione->id/antibiogrammi/$nuovonome");
                        
                    $immagine = new ImmagineMicroAntibiogramma;
                    $immagine->id_campione = $campione->id;
                    $immagine->nome_file = $nuovonome;
                    $immagine->path_file = $path;
                    $immagine->tipo = $image->tipo;
                    $immagine->save();

                    //Elimino il riferimento al file temporaneo nella tabella delle immagini temporanee
                    $image->delete();
                }            
            }
        }

        if(isset($request->id_microrganismo_antibiogramma) && ImmagineMicroAntibiogramma::where('id_campione',$campione->id)->where('tipo','antibiogramma0')->first() != null && MicroAntibiogramma::where('id_campione',$campione->id)->where('NAB',0)->first() == null)
        {
            $microAntibiogramma = new MicroAntibiogramma;
            $microAntibiogramma->NAB = 0;
            $microAntibiogramma->id_campione = $campione->id;
            $microAntibiogramma->id_microrganismo = $request->id_microrganismo_antibiogramma;
            $microAntibiogramma->colonia = 0;
            $microAntibiogramma->save();
        }
        

        /**
         * Salvataggio del MicroAntibiogramma e AntibioticoAntibiogramma
         */
        $count = 0;
        if(isset($request->nab_array))
        {
            foreach ($request->nab_array as $key => $value) 
            {
                $count++;
                if(isset($value['NAB']) && $value['NAB'] != null)
                {
                    if(MicroAntibiogramma::where('id_campione',$campione->id)->where('id_microrganismo',100)->where('NAB',$value['NAB'])->where('colonia',$request->colonia)->first() == null)
                    {
                        $microAntibiogramma = new MicroAntibiogramma;
                        $microAntibiogramma->NAB = $value['NAB'];
                        $microAntibiogramma->id_campione = $campione->id;
                        $microAntibiogramma->id_microrganismo = 100; //il 100esimo MicrorganismoPiastra è un micro fittizzio per ovviare al -1 del vecchio db. Rappresenta "Nessuno".
                        $microAntibiogramma->colonia = $value['colonia'];
                        $microAntibiogramma->save();
                    }

                    $imageMAB = TemporaryImage::where('code',$request->code)->where('tipo',"antibiogramma$count")->first();
                    if($imageMAB != null)
                    {
                        /**
                         * Genero il nome
                         */
                        $nuovonome = $campione->id."C0".$value['NAB'];

                        /**
                         * Verifica esistenza immagine con conseguente cambio nome e salvataggio in cartella
                         */
                        $nomecompleto = explode('.',$imageMAB->nome_file);
                        $estensione = $nomecompleto[1];
                        $nuovonome .= ".".$estensione;

                        $i = 0;
                        while(1)
                        {
                            if(!Storage::disk('public')->exists("$campione->id/antibiogrammi/$nuovonome")){
                                //Storage::disk('public')->move("temporary/$image->nome_file","$nuovonome.jpg" );
                                Storage::disk('public')->copy("temporary/$imageMAB->nome_file","$campione->id/antibiogrammi/$nuovonome");
                                break;
                            }else{
                                $i++;
                                $nomecompleto = explode('.',$nuovonome);
                                $nome = $nomecompleto[0]."($i)";
                                $estensione = $nomecompleto[1];
                                $nuovonome = $nome.".".$estensione;
                            }
                        }
                        //TO DO: creo segnalazione qui per dire che esiste già un immagine con quel nome
                        
                        $path = Storage::disk('public')->path("$campione->id/antibiogrammi/$nuovonome");
                        
                        $immagine = New ImmagineMicroAntibiogramma;
                        $immagine->id_campione = $campione->id;
                        $immagine->nome_file = $nuovonome;
                        $immagine->path_file = $path;
                        $immagine->tipo = $imageMAB->tipo;
                        $immagine->save();
        
                        //Elimino il riferimento al file temporaneo nella tabella delle immagini temporanee
                        $imageMAB->delete();
                    }

                }
            }
        }

        if(isset($request->aa))
        {
            foreach ($request->aa as $key => $value) {
                if(isset($value['NAB']) && $value['NAB'] != null && isset($value['id_antibiotico']) && $value['id_antibiotico'] != null && isset($value['key_resistenza']) && $value['key_resistenza'] != null)
                {
                    if(AntibioticoAntibiogramma::where('id_campione',$campione->id)->where('NAB',$value['NAB'])->where('id_antibiotico',$value['id_antibiotico'])->where('resistenza',$value['key_resistenza'])->first() == null)
                    {
                        $aa = new AntibioticoAntibiogramma;
                        $aa->id_campione = $campione->id;
                        $aa->NAB = $value['NAB'];
                        $aa->id_antibiotico = $value['id_antibiotico'];
                        $aa->resistenza = $value['key_resistenza'];
                        $aa->save();
                    }
                }
            }
        }

        $id_campionamento = $campione->id;
        LoggerEvent::log(auth()->user()->id,"Salvato nuovo campionamento numero $id_campionamento",$request->all(),false,$campione->id);
        if(isset($request->procedi))
        {
            return $this->saveAndContinue($request->numeroProgressivo,$id_campionamento, $request->tipoScheda);
        }
        else
        {
            return json_encode([
                'switch' => 0,    
                'messaggio' => 'Salvataggio effettuato correttamente'
            ]);
        }
    }

    /**
     * Ritorna alla chiamata ajax la view per la scheda del campionamento 
     *
     * @param Integer $numeroProgressivo
     * @param Integer  $id_campionamento
     * @param String $tipo
     * 
     * @return \Illuminate\Http\Response
     */
    public function saveAndContinue($numeroProgressivo, $id_campionamento, $tipo)
    {
        $numeroProgressivo++;
        return json_encode([
            'switch' => 1,
            'numeroProgressivo' => $numeroProgressivo,
            'dati' => $id_campionamento,
            'tipo' => $tipo,
            'messaggio' => 'Salvataggio effettuato correttamente'
        ]);
    }

    /**
     * Dalla chiamata ajax viene invocata la rotta per chiamata di questa funzione
     * che torna alla view la nuova scheda del campionamento, con i dati della vecchia scheda 
     *
     * @param Integer $numeroProgressivo
     * @param Integer  $id_campionamento
     * @param String $tipo
     * 
     * @return View Scheda
     */
    public function next_scheda($numeroProgressivo, $id_campionamento, $tipo)
    {

        /**
         * Prendo tutti i dati del campione appena salvato per inserirli nel nuovo campione da compilare
         */
        $ids = Array(); 
        $campione = Campione::find($id_campionamento);
        $campagna = Campagna::find($campione->id_campagna);
        $societa = $campagna->societa()->first();
        // $reparti = $campagna->reparto()->first();
        $areareparto = AreaPartizione::where('id',$campione->id_areareparto)->get();
        $strutture = $campagna->struttura()->first();
        $progetto = $campagna->progetto()->first();
        $rilevatori = Rilevatore::where('id_progetto',0)->orWhere('id_progetto',$progetto->id)->orWhere('id_progetto',ConversioneProgetto::progettoV2($progetto->id))->select('rilevatori.*')->get();
        // $procedure = Procedura::where('id_progetto',0)->orWhere('id_progetto',$progetto->id)->select('eprocedure.*')->get();
        $metodi = Metodo::all();
        // if(count($progetti) == 1)
        // {
        //     $progetti = $progetti->first();
        //     $rilevatori = Rilevatore::where('id_progetto',0)->orWhere('id_progetto',$progetti->id)->select('rilevatori.*')->get();
        //     $procedure = Procedura::where('id_progetto',0)->orWhere('id_progetto',$progetti->id)->select('eprocedure.*')->get();
        // }
        // else
        // {
        //     foreach($progetti as $p)
        //     {
        //         array_push($ids,$p->id); 
        //     }

        //     $rilevatori = Rilevatore::where('id_progetto',0);
        //     $procedure = Procedura::where('id_progetto',0);
        //     for($i = 0; $i < count($ids); $i++)
        //     {
        //         $rilevatori = $rilevatori->orWhere('id_progetto',$ids[$i]);
        //         $procedure = $procedure->orWhere('id_progetto',$ids[$i]);

        //     }
        //     $rilevatori = $rilevatori->select('rilevatori.*')->get();
        //     $procedure = $procedure->select('eprocedure.*')->get();
        // }

        /**Calcolo campioni rilevatori */
        $campione_rilevatore = CampioniRilevatori::where('id_campione',$campione->id)->get();
        $cp = Array();
        foreach ($rilevatori as $r)
        {
            $cp[$r->id] = 0;
        }
        foreach ($campione_rilevatore as $value) 
        {
            $cp[$value->id_rilevatore] = 1;
        }
        // $progetto_salvato = $campione->progetto()->first(); //prendo anche il progetto salvato.

        //$stanze = Stanza::all();
        // $stanza_salvata = $campione->stanza()->first();

        $prodotti = Prodotto::all();
        // $prodotto_salvato = $campione->prodotto()->first();

        $materiali = Materiale::where('versione',2)->get();
        // $materiale_salvato = $campione->superficie()->first();

        $protocolli = Protocollo::all();
        // $protocollo_salvato = $campione->protocollo()->first();

        $categorie = Categoria::where('versione',2)->get();        
        $puntiCampionamento = PuntoCampionamento::where('versione',2)->get(); //?? dipendono dalla categoria, quindi forse non serve ma compaiono dinamicamente con js in fase di compilazione
        // $puntoCampionamento_salvato = $campione->puntocampionamento()->first();
        // $categoria_salvata = $campione->puntocampionamento->categoria()->first();

        $piastre = TipoPiastra::where('versione',2)->get();
        // $piastra_salvata = $campione->tipopiastra()->first();


        $code = $this->generateUniqueCode();
        $numeroProgressivo++;
        $occorrenza = 0;
        return view('schede.edit_scheda',compact('campione','progetto','areareparto','metodi','prodotti','materiali','protocolli','puntiCampionamento','categorie','rilevatori','piastre','societa','strutture','numeroProgressivo','code','campagna','occorrenza','tipo','cp'));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Log::info($request);
        if($request->tipoScheda == 'N')
        {
            $validator = Validator::make($request->all(), [
                'tipoScheda' => 'required',
                'id_progetto' => 'required|numeric',
                'id_campagna' => 'required|numeric',
                'dataCampagna' => 'required|date|before_or_equal:today',
                'id_struttura' => 'required|numeric',
                'dataPartenza' => 'required|date',
                'oraPartenza' => 'required',
                'dataInizio' => 'required|date',
                'oraInizio' => 'required',
                'dataFine' => 'required|date',
                'oraFine' => 'required',
                'dataArrivo' => 'required|date',
                'oraArrivo' => 'required',
                'tecnico' => 'numeric|required',
                'dataAnalisi' => 'required|date',
                'oraInizioAnalisi' => 'required',
                'oraFineAnalisi' => 'required',
                'dataFineAnalisi' => 'required|date',
                'superficie' => 'boolean',
                'aria' => 'boolean',
                'id_procedura' => 'sometimes|numeric',
                'id_protocollo' => 'sometimes|numeric',
                'id_prodotto' => 'sometimes|numeric',
                'id_punto_camp' => 'sometimes|numeric',
                'id_materiale' => 'sometimes|numeric',
                'procedura' => 'numeric',
                'id_metodo' => 'sometimes|numeric',
                'vccc' => 'sometimes|boolean',
                'laminare' => 'sometimes|boolean',
                'turbolento' => 'sometimes|boolean',
                'operational' => 'sometimes|boolean',
                'at_rest' => 'sometimes|boolean',
                'pCampAria' => 'sometimes|numeric',
                'codDiff' => 'sometimes',
                'id_tipo_piastra' => 'numeric|required',
                'DII' => 'date',
                't_inc' => 'numeric',
                'siGramRil' => 'boolean',
                'noGramRil' => 'boolean',
                'gramN' => 'sometimes|numeric',
                'reparto' => 'numeric|required',
                'lineeGuida1' => 'boolean',
                'lineeGuida2' => 'boolean',
                'lineeGuida3' => 'boolean',
                'lineeGuida4' => 'boolean',
                'scadenza' => 'date',
                'rilevatori' => 'required'
            ]);
        }

        if($request->tipoScheda == 'B')
        {
            $validator = Validator::make($request->all(), [
                'tipoScheda' => 'required',
                'id_progetto' => 'required|numeric',
                'id_campagna' => 'required|numeric',
                'dataCampagna' => 'required|date|before_or_equal:today',
                'id_struttura' => 'required|numeric',
                'dataPartenza' => 'required|date',
                'oraPartenza' => 'required',
                'dataInizio' => 'required|date',
                'oraInizio' => 'required',
                'dataFine' => 'required|date',
                'oraFine' => 'required',
                'dataArrivo' => 'required|date',
                'oraArrivo' => 'required',
                'tecnico' => 'numeric|required',
                'dataAnalisi' => 'required|date',
                'oraInizioAnalisi' => 'required',
                'oraFineAnalisi' => 'required',
                'dataFineAnalisi' => 'required|date',
                'superficie' => 'boolean',
                'aria' => 'boolean',
                'id_procedura' => 'sometimes|numeric',
                'id_tipo_piastra' => 'numeric|required',
                'DII' => 'date',
                't_inc' => 'numeric',
                'siGramRil' => 'boolean',
                'noGramRil' => 'boolean',
                'gramN' => 'sometimes|numeric',
                'reparto' => 'numeric|required',
                'scadenza' => 'date',
                'rilevatori' => 'required'
            ]);
        }

        if($request->tipoScheda == 'Q')
        {
            $validator = Validator::make($request->all(), [
                'tipoScheda' => 'required',
                'id_campagna' => 'required|numeric',
                'dataCampagna' => 'required|date|before_or_equal:today',
                'tecnico' => 'numeric|required',
                'dataAnalisi' => 'required|date',
                'oraInizioAnalisi' => 'required',
                'oraFineAnalisi' => 'required',
                'dataFineAnalisi' => 'required|date',
                'superficie' => 'boolean',
                'aria' => 'boolean',
                'id_procedura' => 'sometimes',
                'id_tipo_piastra' => 'numeric|required',
                't_inc' => 'numeric',
                'siGramRil' => 'boolean',
                'noGramRil' => 'boolean',
                'gramN' => 'sometimes|numeric',
                'scadenza' => 'date',
                'rilevatori' => 'required'
            ]);
        }

        if ($validator->fails()) {
            $messages = $validator->messages();
            return response()->json(['error' => $messages], 403);
        }

        if((!isset($request->tipoCampione) || $request->tipoCampione == null || $request->tipoCampione == '') && ($request->tipoScheda == 'N' || $request->tipoScheda == 'Q'))
        {
            $messages = "Specificare il tipo del campione";
            return response()->json(['error' => $messages], 403); 
        }

        $crea_areapartizione = false;
        $campione = Campione::find($id);

        if($campione == null)
        {
            $messages = "Campione non trovato, errore";
            return response()->json(['error' => $messages], 403);
        }

        $immagine_antibiogramma0 = ImmagineMicroAntibiogramma::where('id_campione',$campione->id)->where('tipo','antibiogramma0')->first();
        $immagine_temporanea_antibiogramma0 = TemporaryImage::where('code',$request->code)->where('tipo','antibiogramma0')->first();
        if(!isset($request->id_microrganismo_antibiogramma) && $immagine_temporanea_antibiogramma0 != null)
        {
            $messages = "Microrganismo non specificato, da correggere";
            return response()->json(['error' => $messages], 403); 
        }
        if(isset($request->id_microrganismo_antibiogramma) && $immagine_temporanea_antibiogramma0 == null && $immagine_antibiogramma0 == null)
        {
            $messages = "Immagine antibiogramma per conta colonie mancante, da correggere";
            return response()->json(['error' => $messages], 403); 
        }

        //Il numero di immagini da inserire invece corrisponde al numero di immagini inserite a frontend. Se alcuni dropzone sono vuoti allora ci sono immagini da inserire.
        $numero_immagini_da_inserire =  $request->numero_immagini_da_inserire;
        //il numero delle immagini inserite corrisponde al numero di immagini temporanee salvate per quel determinato code.
        $numero_immagini_inserite = count(TemporaryImage::where('code',$request->code)->where('tipo',"!=",'piastra1')->where('tipo',"!=",'piastra2')->where('tipo',"!=",'striscio')->where('tipo','!=','antibiogramma0')->get());
        
        if($numero_immagini_inserite != $numero_immagini_da_inserire)
        {
            $messages = "Immagine per antibiogramma mancante, correggere";
            return response()->json(['error' => $messages], 403); 
        }

        $immagineTempPiastra2 = TemporaryImage::where('code',$request->code)->where('tipo','piastra2')->first();
        $immaginePiastra2 = ImmaginiPiastre::where('id_campione',$campione->id)->where('tipo','piastra2')->first();
        if(isset($request->t_inc_extra))
        {
            if($immagineTempPiastra2 == null && $immaginePiastra2 == null)
            {
                $messages = "Immagine piastra extra mancante, inserire immagine o non specificare tempo di incubazione extra";
                return response()->json(['error' => $messages], 403); 
            }
        }

        // if($immagineTempPiastra2 != null && $immaginePiastra2 == null)
        // {
        //     if(!isset($request->t_inc_extra))
        //     {
        //         $messages = "tempo di incubazione extra mancante con immagine piastra extra inserita, da correggere";
        //         return response()->json(['error' => $messages], 403); 
        //     }
        // }

        if(isset($request->aa))
        {
            foreach ($request->aa as $key => $value) {
                //se sono nel caso in cui ho aggiunto un form per l'antibiogramma ma non ho inserito nulla, procedo. Altrimenti se ho mancato di inserire qualche campo ritorno errore.

                //Il primo if serve a capire se tutti e tre i campi di interesse sono vuoti. Per procedere nego l'ipotesi. 
                if(!((!isset($value['NAB']) || $value['NAB'] == null) && (!isset($value['id_antibiotico']) || $value['id_antibiotico'] == null) && (!isset($value['key_resistenza']) || $value['key_resistenza'] == null)))
                {
                    if((!isset($value['NAB']) || $value['NAB'] == null))
                    {
                        $messages = "Inserire un valore corretto per il campo NAB";
                        return response()->json(['error' => $messages], 403); 
                    }
                    if((!isset($value['id_antibiotico']) || $value['id_antibiotico'] == null))
                    {
                        $messages = "Inserire un valore corretto per il campo antibiotico";
                        return response()->json(['error' => $messages], 403); 
                    }
                    if((!isset($value['key_resistenza']) || $value['key_resistenza'] == null))
                    {
                        $messages = "Inserire un valore corretto per il campo resistenza";
                        return response()->json(['error' => $messages], 403); 
                    }
                } 
            }
        }

       
        if(!isset($request->rilevatori))
        {
            $message = "Inserire almeno un rilevatore del campionamento";
            return response()->json(['error' => $message],403);
        }


        $progetto = Progetto::where('id',$request->id_progetto)->first();
        
        if($progetto == null && ($request->tipoScheda == 'N' || $request->tipoScheda == 'B'))
        {
            return response()->json(['error' => 'Progetto non trovato, riprovare'], 403);
        }

        //$stanza = stanza::where('stanza',$request->stanza)->first();
        
        // if($stanza == null && ($request->tipoScheda == 'N' || $request->tipoScheda == 'B'))
        // {
        //     return response()->json(['error' => 'Stanza non trovata, riprovare'], 403);
        // }

        $id_societa = $request->id_societa; //non viene salvato nel campione ma è inviato alla prossima scheda

        /**
         * Anagrafica
         */
        $campione->id_progetto = $progetto->id ?? null;
        $campione->id_campagna = $request->id_campagna;
        $campione->dataCampagna = $request->dataCampagna;
        $campione->data_accettazione = $request->data_accettazione;
        $campione->data = $request->dataCampionamento;
        $campione->id_struttura = $request->id_struttura ?? null;
        $campione->dataPartenza = $request->dataPartenza;
        $campione->oraPartenza = $request->oraPartenza;
        $campione->dataInizio = $request->dataInizio;
        $campione->oraInizio = $request->oraInizio;
        $campione->dataFine = $request->dataFine;
        $campione->oraFine = $request->oraFine;
        $campione->dataArrivo = $request->dataArrivo;
        $campione->oraArrivo = $request->oraArrivo;

        /**
         * Sito campionamento
         */
        if($request->tipoScheda == 'N' || $request->tipoScheda == 'B')
        {
            $areaReparto = AreaPartizione::where('id_reparto',$request->reparto)->where('area_partizione',$request->area_partizione)->first();
            /**
             * Se non esiste l'area partizione significa che l'utente non è mai stato in quell'area e non l'ha creata nella gestione interna 
             * dunque la creo
             */
            if($areaReparto == null && $request->reparto != null)
            {
               $crea_areapartizione = true;
            }
            elseif($areaReparto == null && $request->reparto == null)
            {
                return response()->json(['error' => 'Inserire una partizione valida, riprovare'], 403);
            }
            else
            {
                $areaRepartoCampione = AreaPartizione::where('id',$campione->id_areareparto)->first();
                if($areaReparto->id != $areaRepartoCampione->id )
                {
                    $campione->id_areareparto = $areaReparto->id;
                }
            }
        }
        
        // $campione->codiceCIAS = $request->codice_area_partizione;
        $campione->numStanza = $request->numStanza;
        $campione->umidAmb = $request->umidAmb;
        $campione->tempAmb = $request->tempAmb;
        $campione->dettaglio = $request->dettaglio;
        $campione->lineeGuida1 = intval($request->lineeGuida1);
        $campione->lineeGuida2 = intval($request->lineeGuida2);
        $campione->lineeGuida3 = intval($request->lineeGuida3);
        $campione->lineeGuida4 = intval($request->lineeGuida4);
        $campione->classeGMP = $request->classeGMP;
        $campione->classificazioneISO = $request->classificazioneISO; 
        $campione->anomalie = $request->anomalie;

        /**
         * Campionamento
         */
        $superficie = isset($request->superficie) ? $request->superficie : 0;
        $aria = isset($request->aria) ? $request->aria : 0;
        $laminare = isset($request->laminare) ? $request->laminare : 0;
        $turbolento = isset($request->turbolento) ? $request->turbolento : 0;
        $operational = isset($request->operational) ? $request->operational : 0;
        $at_rest = isset($request->at_rest) ? $request->at_rest : 0;
        $gramRil = $request->siGramRil == '1' ? 1 : $request->noGramRil;
        //$campione->procedura = $request->id_procedura;
        $campione->id_metodo = $request->id_metodo;
        $campione->tipoCamp = $superficie == 1 ? "S" : "A";
        $campione->id_protocollo = (isset($request->id_protocollo) && $superficie == 1) ? $request->id_protocollo : 0;
        $campione->id_prodotto = (isset($request->id_prodotto) && $superficie == 1) ? $request->id_prodotto : 0;
        $campione->fase_Camp = (isset($request->fase_Camp) && $superficie == 1) ? $request->fase_Camp : 0;
        $campione->tdaSanif = (isset($request->tdaSanif) && $superficie == 1) ? $request->tdaSanif : 0;
        $campione->id_punto_camp = (isset($request->id_punto_camp) && $superficie == 1) ? $request->id_punto_camp : 0;
        $campione->id_superficie = (isset($request->id_materiale) && $superficie == 1) ? $request->id_materiale : 0;
        $campione->flusso = $laminare == 1 ? "L" : "T";
        $campione->operat = $operational == 1 ? "O" : "R";
        $campione->vccc = isset($request->vccc) ? $request->vccc : 0;
        $campione->n_persone = isset($request->n_persone) ? $request->n_persone : 0;
        $campione->pCampAria = isset($request->pCampAria) ? $request->pCampAria : 0;
        $campione->codDiff = isset($request->codDiff) ? $request->codDiff : 0;
        $campione->gramRil = isset($gramRil) ? $gramRil : 0;
        $campione->gramN = isset($gramRil) && $gramRil == 1 ? $request->gramN : 0;

        /**
         * Analisi
         */
        $campione->tecnico = $request->tecnico;
        $campione->dataAnalisi = $request->dataAnalisi;
        $campione->oraInizioAnalisi = $request->oraInizioAnalisi;
        $campione->oraFineAnalisi = $request->oraFineAnalisi;
        $campione->dataFineAnalisi = $request->dataFineAnalisi;

        /**
         * Campione
         */
        $campione->id_tipo_piastra = $request->id_tipo_piastra;
        $campione->lotto = $request->lotto;
        $campione->scadenza = $request->scadenza;
        $campione->DII = $request->DII;
        $campione->note = $request->note;
        $campione->t_inc = intval($request->t_inc);
        $campione->condizione_incubazione = $request->condizione_incubazione;
        isset($request->t_inc_extra) ? $campione->t_inc_extra = intval($request->t_inc_extra) : $campione->t_inc_extra = 0;

        $campione->incertezza = $request->incertezza;
        $campione->speciazione = $request->speciazione;

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $campione->save();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        if($crea_areapartizione == true)
        {
            $areaReparto = new AreaPartizione;
            $areaReparto->id_reparto = $request->reparto;
            $areaReparto->area_partizione = $request->area_partizione;
            $areaReparto->codice_area_partizione = substr($request->area_partizione, 0, 3);
            $areaReparto->save();

            $campione->id_areareparto = $areaReparto->id;
            $campione->save();

            /**Se ho dovuto creare un area reparto, allora devo salvare anche una nuova tupla PROGETTO-STRUTTURA-PARTIZIONE-AREAREPARTO */
            $struttRep = StruttRep::where('id_progetto', $request->id_progetto)
                                    ->where('id_struttura', $request->id_struttura)
                                    ->where('id_reparto', $request->reparto)
                                    ->where('id_associazione', $areaReparto->id)
                                    ->first();

            if($struttRep == null)
            {
                $progettoStrutturaPartizione = new StruttRep;
                $progettoStrutturaPartizione->id_progetto = $request->id_progetto;
                $progettoStrutturaPartizione->id_struttura = $request->id_struttura;
                $progettoStrutturaPartizione->id_reparto = $request->reparto;
                $progettoStrutturaPartizione->id_associazione = $areaReparto->id;
                $progettoStrutturaPartizione->versione = 2;
                $progettoStrutturaPartizione->save();
            }
        }
        else
        {
            Log::info($request->id_progetto);
            /**Se ho dovuto creare un area reparto, allora devo salvare anche una nuova tupla PROGETTO-STRUTTURA-PARTIZIONE-AREAREPARTO */
            $struttRep = StruttRep::where('id_progetto', $request->id_progetto)
                                    ->where('id_struttura', $request->id_struttura)
                                    ->where('id_reparto', $request->reparto)
                                    ->where('id_associazione', $areaReparto->id)
                                    ->first();

            if($struttRep == null)
            {
                $progettoStrutturaPartizione = new StruttRep;
                $progettoStrutturaPartizione->id_progetto = $request->id_progetto;
                $progettoStrutturaPartizione->id_struttura = $request->id_struttura;
                $progettoStrutturaPartizione->id_reparto = $request->reparto;
                $progettoStrutturaPartizione->id_associazione = $areaReparto->id;
                $progettoStrutturaPartizione->versione = 2;
                $progettoStrutturaPartizione->save();
            }
        }

        if($campione->tipoCamp == 'A' && $campione->operat == 'O' && $campione->pCampAria == 161)
        {
            $campione->codiceCIAS = $this->createCodiceCias($request->dataCampionamento, $request->reparto, $areaReparto, $request->numStanza, $request->id_tipo_piastra, $campione->pCampAria, True, True, True, False);
        }
        elseif($request->tipoScheda == 'B')
        {
            $campione->codiceCIAS = $this->createCodiceCias($request->dataCampionamento, $request->reparto, $areaReparto, null, $request->id_tipo_piastra, null, False, False, False, True);
        }
        elseif($request->tipoScheda == 'Q')
        {
            $campione->codiceCIAS = $this->createCodiceCias($request->dataCampionamento, $request->reparto, null, null, $request->id_tipo_piastra, null, False, False, False, False, True);
        }
        else
        {
            $campione->codiceCIAS = $this->createCodiceCias($request->dataCampionamento, $request->reparto,$areaReparto, $request->numStanza, $request->id_tipo_piastra, (isset($request->id_punto_camp) && $superficie == 1) ? $request->id_punto_camp : $request->pCampAria);
        }

        if(isset($request->codiceCIAS_appendice) && $request->codiceCIAS_appendice != "")
        {
            $campione->codiceCIAS .= "_".$request->codiceCIAS_appendice;
        }

        $campione->update();

        /**
         * Salvataggio rilevatori
         */
        $rilevatoriCampione = CampioniRilevatori::where('id_campione',$id)->get();
        $num_rilevatori = count($rilevatoriCampione);

        
        if(count($request->rilevatori) != $num_rilevatori)
        {
            //Verifico se ci sono rilevatori da eliminare
            foreach($rilevatoriCampione as $rilevatore)
            {
                $trovato = 0;
                foreach($request->rilevatori as $ril)
                {
                    if($rilevatore->id == $ril['id'])
                    {
                        $trovato = 1;
                        break;
                    }
                }

                if($trovato == 0)
                {
                    $rilevatore->delete();
                }
                
            }

            //Verifico se ci sono rilevatori da aggiungere
            foreach($request->rilevatori as $ril)
            {
                $trovato = 0;
                foreach($rilevatoriCampione as $rilevatore)
                {
                    if($rilevatore->id == $ril['id'])
                    {
                        $trovato = 1;
                        break;
                    }
                }

                if($trovato == 0)
                {
                    $rilevatore = new CampioniRilevatori;
                    $rilevatore->id_campione = $campione->id;
                    $rilevatore->id_rilevatore = $ril['id'];
                    $rilevatore->save();
                }
                
            }

        }



         /**
         * Salvataggio dei microrganismi
         */
        if(isset($request->micro))
        {
            foreach ($request->micro as $key => $value) {
                //Dato che all'update potrebbero tornare elementi già salvati, verifico prima di effettuare il salvataggio.
                if(MicroSuPiastra::where('id_microrganismo',$value['id_microrganismo'])->where('id_tipopiastra', $value['id_tipopiastra'])->where('cfu', $value['cfu'])->where('id_campione',$campione->id)->first() == null)
                {
                    //salvataggio del microrganismo associato al campione con la relativa piastra e grandezza
                    $microsupiastra = new MicroSuPiastra;
                    $microsupiastra->id_microrganismo = $value['id_microrganismo'];
                    $microsupiastra->id_campione = $campione->id;
                    $microsupiastra->id_tipopiastra = $value['id_tipopiastra'];
                    $microsupiastra->CFU = $value['cfu'];
                    $microsupiastra->incertezzaSx = $value['incertezzaSx'] == 'null' ? null : $value['incertezzaSx'];
                    $microsupiastra->incertezzaDx = $value['incertezzaDx'] == 'null' ? null : $value['incertezzaDx'];
                    $microsupiastra->save();
                }
            }
    
        }

        /**
         * Salvataggio dei microrganismi per speciazione
         */
        
        if(isset($request->micro_speciazione) && $request->speciazione == 1)
        {
            $punto_camp = (isset($request->id_punto_camp) && $superficie == 1) ? $request->id_punto_camp : $request->pCampAria;
            foreach ($request->micro_speciazione as $key => $value) {
                //Dato che all'update potrebbero tornare elementi già salvati, verifico prima di effettuare il salvataggio.
                if(SpeciazioneCampione::where('id_microrganismo',$value['id_microrganismo'])->where('id_tipopiastra', $value['id_tipopiastra'])->where('id_campione',$campione->id)->where('esito',$value['speciazione_risultato'])->where('id_punto_camp',$punto_camp)->where('tipoCamp',$value['tipoCamp'])->first() == null)
                {
                    $speciazione = new SpeciazioneCampione;
                    $speciazione->id_microrganismo = $value['id_microrganismo'];
                    $speciazione->id_campione = $campione->id;
                    $speciazione->id_tipopiastra = $value['id_tipopiastra'];
                    $speciazione->id_punto_camp = $punto_camp;
                    $speciazione->esito = $value['speciazione_risultato'];
                    $speciazione->tipoCamp = $campione->tipoCamp;
                    $speciazione->save();
                }
            }
    
        }

        /**
         * Salvataggio della foto della piastra
         */
        $temporaryFile = TemporaryImage::where('code',$request->code)->get();
        if($temporaryFile != null)
        {
            foreach ($temporaryFile as $image) {
                /**
                 * Generazione nome
                */
                $nuovonome = $image->nome_file;
                if($image->tipo == 'piastra1')
                {
                    $codiceStrRep = "";
                    $id_progetto = ConversioneProgetto::progettoV2($campione->progetto->id) ?? $campione->progetto->id;
                    $id_struttura = ConversioneStrutturaStrutture::strutturaV2($campione->struttura->id) ?? $campione->struttura->id;
                    $id_partizione = ConversionePartizioneReparti::partizioneV2($campione->reparto->id_reparto) ?? $campione->reparto->id_reparto;
                    $codice_area_partizione = $campione->reparto->codice_area_partizione;
                    $progetto = Progetto::find($id_progetto);
                    $struttura = Struttura::find($id_struttura);
                    $partizione = Reparto::find($id_partizione);

                    if($progetto != null)
                    {
                        $codiceStrRep = $progetto->CodPro;
                    }
                    if($struttura != null)
                    {
                        $codiceStrRep .= "_".$struttura->codice_struttura . "_".$struttura->codice_sede."_".$struttura->codice_provincia;
                    }
                    if($partizione != null)
                    {
                        $codiceStrRep .= "_".$partizione->codice_partizione;
                    }
                    if($codice_area_partizione != null)
                    {
                        $codiceStrRep .= "_".$codice_area_partizione;
                    }

                    $nuovonome = $campione->dataCampagna->format('Y');
                    $nuovonome .= "_".$campione->dataCampagna->format('m');
                    $nuovonome .= "_".$campione->dataCampagna->format('d');
                    if($codiceStrRep != '')
                    {
                        $nuovonome .= "_". $codiceStrRep;
                    }
                    else
                    {
                        $nuovonome .= (isset($campione->progetto->CodPro) ? "_".$campione->progetto->CodPro : '');
                        $nuovonome .= (isset($campione->struttura->codice_struttura) ? "_".$campione->struttura->codice_struttura : '');
                    }
                    $nuovonome .= isset($campione->numStanza) ? "_".$campione->numStanza : '';
                    $nuovonome .= isset($campione->tipopiastra) ? "_".$campione->tipopiastra->abbreviazione : '';
                    $nuovonome .= $campione->puntocampionamento != '' ? ("_".$campione->puntocampionamento->codPC ?? '') : '';
                }
                elseif($image->tipo == 'piastra2')
                {
                    $nuovonome = $campione->id."E";
                    $nuovonome .= isset($campione->t_inc_extra) ? $campione->t_inc_extra : '0';
                }
                elseif($image->tipo == 'antibiogramma0')
                {
                    $nuovonome = "C".$campione->id;
                }

                /**
                 * Verifica esistenza immagine con conseguente cambio nome e salvataggio immagine in cartella
                 */
                if($image->tipo == 'piastra1' || $image->tipo == 'piastra2')
                {
                    $nomecompleto = explode('.',$image->nome_file);
                    $estensione = $nomecompleto[1];
                    $i = 0;
                    $nuovonome .= ".".$estensione;
                    while(1){
                        if(!Storage::disk('public')->exists("$campione->id/$nuovonome")){
                            //Storage::disk('public')->move("temporary/$image->nome_file","$nuovonome.jpg" );
                            Storage::disk('public')->copy("temporary/$image->nome_file","$campione->id/$nuovonome");
                            break;
                        }else{
                            $i++;
                            $nomecompleto = explode('.',$nuovonome);
                            $nome = $nomecompleto[0]."($i)";
                            $estensione = $nomecompleto[1];
                            $nuovonome = $nome.".".$estensione;
                        }
                    }
                    //TO DO: creo segnalazione qui per dire che esiste già un immagine con quel nome
                    
                }
                elseif($image->tipo == 'antibiogramma0')
                {
                    $nomecompleto = explode('.',$image->nome_file);
                    $estensione = $nomecompleto[1];
                    $i = 0;
                    $nuovonome .= ".".$estensione;
                    while(1){
                        if(!Storage::disk('public')->exists("$campione->id/antibiogrammi/$nuovonome")){
                            //Storage::disk('public')->move("temporary/$image->nome_file","$nuovonome.jpg" );
                            Storage::disk('public')->copy("temporary/$image->nome_file","$campione->id/antibiogrammi/$nuovonome");
                            break;
                        }else{
                            $i++;
                            $nomecompleto = explode('.',$nuovonome);
                            $nome = $nomecompleto[0]."($i)";
                            $estensione = $nomecompleto[1];
                            $nuovonome = $nome.".".$estensione;
                        }
                    }
                    //TO DO: creo segnalazione qui per dire che esiste già un immagine con quel nome   
                }

                /**
                 * Salvataggio immagine in database
                 */
                if($image->tipo == 'piastra1' || $image->tipo == 'piastra2')
                {
                    $path = Storage::disk('public')->path("$nuovonome");

                    $immagine = new ImmaginiPiastre;
                    $immagine->id_campione = $campione->id;
                    $immagine->nome_file = $nuovonome;
                    $immagine->path_file = $path;
                    $immagine->tipo = $image->tipo;
                    $immagine->save();

                    //Elimino il riferimento al file temporaneo nella tabella delle immagini temporanee
                    $image->delete();
                }
                elseif($image->tipo == 'antibiogramma0')
                {
                    $path = Storage::disk('public')->path("$campione->id/antibiogrammi/$nuovonome");
                        
                    $immagine = new ImmagineMicroAntibiogramma;
                    $immagine->id_campione = $campione->id;
                    $immagine->nome_file = $nuovonome;
                    $immagine->path_file = $path;
                    $immagine->tipo = $image->tipo;
                    $immagine->save();

                    //Elimino il riferimento al file temporaneo nella tabella delle immagini temporanee
                    $image->delete();
                }     
            }
        }

        if(isset($request->id_microrganismo_antibiogramma) && ImmagineMicroAntibiogramma::where('id_campione',$campione->id)->where('tipo','antibiogramma0')->first() != null && MicroAntibiogramma::where('id_campione',$campione->id)->where('NAB',0)->first() == null)
        {
            $microAntibiogramma = new MicroAntibiogramma;
            $microAntibiogramma->NAB = 0;
            $microAntibiogramma->id_campione = $campione->id;
            $microAntibiogramma->id_microrganismo = $request->id_microrganismo_antibiogramma;
            $microAntibiogramma->colonia = 0;
            $microAntibiogramma->save();
        }
        

        /**
         * Salvataggio del MicroAntibiogramma e AntibioticoAntibiogramma
         */
        $mab = MicroAntibiogramma::where('id_campione',$campione->id)->where('id_microrganismo',100)->get();
        $count = 0;
        if($mab != null)
        {
            $n_mab = count(MicroAntibiogramma::where('id_campione',$campione->id)->where('id_microrganismo',100)->get());
            $count = $n_mab;    //se ci sono già microantibiogrammi significa che non posso partire ad analizzare antibiogramma0 
                                // ma devo partire dall'ultimo inserito
        }
        if(isset($request->nab_array))
        {
            foreach ($request->nab_array as $key => $value) {
                $count++;
                if(isset($value['NAB']) && $value['NAB'] != null)
                {
                    if(MicroAntibiogramma::where('id_campione',$campione->id)->where('id_microrganismo',100)->where('NAB',$value['NAB'])->where('colonia',$request->colonia)->first() == null)
                    {

                        $microAntibiogramma = new MicroAntibiogramma;
                        $microAntibiogramma->NAB = $value['NAB'];
                        $microAntibiogramma->id_campione = $campione->id;
                        $microAntibiogramma->id_microrganismo = 100; //il 100esimo MicrorganismoPiastra è un micro fittizzio per ovviare al -1 del vecchio db. Rappresenta "Nessuno".
                        $microAntibiogramma->colonia = $value['colonia'];
                        $microAntibiogramma->save();
                    }

                    $imageMAB = TemporaryImage::where('code',$request->code)->where('tipo',"antibiogramma$count")->first();
                    if($imageMAB != null)
                    {
                        /**
                         * Genero il nome
                         */
                        $nuovonome = $campione->id."C0".$value['NAB'];

                        /**
                         * Verifica esistenza immagine con conseguente cambio nome e salvataggio in cartella
                         */
                        $nomecompleto = explode('.',$imageMAB->nome_file);
                        $estensione = $nomecompleto[1];
                        $nuovonome .= ".".$estensione;

                        $i = 0;
                        while(1){
                            if(!Storage::disk('public')->exists("$campione->id/antibiogrammi/$nuovonome")){
                                //Storage::disk('public')->move("temporary/$image->nome_file","$nuovonome.jpg" );
                                Storage::disk('public')->copy("temporary/$imageMAB->nome_file","$campione->id/antibiogrammi/$nuovonome");
                                break;
                            }else{
                                $i++;
                                $nomecompleto = explode('.',$nuovonome);
                                $nome = $nomecompleto[0]."($i)";
                                $estensione = $nomecompleto[1];
                                $nuovonome = $nome.".".$estensione;
                            }
                        }
                        //TO DO: creo segnalazione qui per dire che esiste già un immagine con quel nome
                        
                        $path = Storage::disk('public')->path("$campione->id/antibiogrammi/$nuovonome");
                        
                        $immagine = New ImmagineMicroAntibiogramma;
                        $immagine->id_campione = $campione->id;
                        $immagine->nome_file = $nuovonome;
                        $immagine->path_file = $path;
                        $immagine->tipo = $imageMAB->tipo;
                        $immagine->save();
        
                        //Elimino il riferimento al file temporaneo nella tabella delle immagini temporanee
                        $imageMAB->delete();
                    }

                }
            }
        }

        if(isset($request->aa))
        {
            foreach ($request->aa as $key => $value) {
                if(isset($value['NAB']) && $value['NAB'] != null && isset($value['id_antibiotico']) && $value['id_antibiotico'] != null && isset($value['key_resistenza']) && $value['key_resistenza'] != null)
                {
                    if(AntibioticoAntibiogramma::where('id_campione',$campione->id)->where('NAB',$value['NAB'])->where('id_antibiotico',$value['id_antibiotico'])->where('resistenza',$value['key_resistenza'])->first() == null)
                    {
                        $aa = new AntibioticoAntibiogramma;
                        $aa->id_campione = $campione->id;
                        $aa->NAB = $value['NAB'];
                        $aa->id_antibiotico = $value['id_antibiotico'];
                        $aa->resistenza = $value['key_resistenza'];
                        $aa->save();
                    }
                }
            }
        }

        LoggerEvent::log(auth()->user()->id,"Modificato campione $campione->id, motivo: $request->motivo",$campione->getChanges(),false,$campione->id);
        return json_encode('Campione modificato correttamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campione = Campione::find($id);

        if($campione == null)
        {
            return json_encode(['error' => "Operazione non riuscita, campionamento con id: $id non trovato"],403);
        }
        $campione->delete();
        
        LoggerEvent::log(auth()->user()->id, "Cancellazione scheda con id $id", ['id_scheda' => $id], true,$campione->id);
        return json_encode('ok');
    }

    /**
     * Funzione usata per generare un codice casuale per la memorizzazione ed identificazione temporanea delle immagini.
     * 
     * @return Integer $code
     */
    public function generateUniqueCode()
    {
        do {
            $code = random_int(100000, 999999);
        } while (TemporaryImage::where("code", "=", $code)->first());
  
        return $code;
    }


    /**
     * Funzione usata per sbloccare il campione in caso di richiesta di modifica
     * 
     * @return Null
     */

    public function unlock(Request $request)
    {
        $campione = Campione::find($request->id);
        if($campione == null)
        {
            return json_encode(['error' => "Operazione non riuscita, campionamento con id: $request->id non trovato"],403);
        }
        $campione->bloccato = 0;
        $campione->save();
        LoggerEvent::log(auth()->user()->id, "Sbloccato campione con id $request->id", ['id_campione' => $request->id, "motivo: $request->motivo"], true, $campione->id);
        return json_encode('ok');
    }


    // /**
    //  * Funzione per visualizzare la schermata di creazione del rapporto di prova
    //  */
    // public function createRapportoProva()
    // {
    //     $societa = Societa::all();
    //     $progetti = Progetto::where('versione',2)->get();
    //     $strutture = Struttura::where('versione',2)->get();
    //     $reparti = Reparto::where('versione',2)->get();
    //     $areaPartizione = AreaPartizione::all();
    //     $view_documento = 0;

    //     return view('relazioni_e_rapporti.genera_rapporto',compact('societa','progetti','strutture','reparti','areaPartizione','view_documento'));
    // }

    //data reparto terreno pc
    public function createCodiceCias($data_campionamento,$id_partizione, $areaReparto, $stanza, $id_tipopiastra, $id_pc, $aria = False, $operat = False, $centro_stanza = False, $bianco = False, $qualita = False)
    {
        $data = explode('-',$data_campionamento);
        $anno = $data[0];
        $mese = $data[1];
        $giorno = $data[2];

        $codice_partizione = Reparto::find($id_partizione) != null ? Reparto::find($id_partizione)->codice_partizione : null;
        if($qualita != True)
        {
            $codice_area_partizione = $areaReparto->codice_area_partizione;
        }
        $stanza_partizione = $stanza != null ? $stanza : null;
        $codice_terreno = TipoPiastra::find($id_tipopiastra) != null ? TipoPiastra::find($id_tipopiastra)->abbreviazione : null;
        
        if($aria == True && $operat == True && $centro_stanza == True)
        {
            $codice_punto_campionamento = 'R';
        }
        else
        {
            $codice_punto_campionamento = PuntoCampionamento::find($id_pc) != null ? PuntoCampionamento::find($id_pc)->codPC : null;
        }

        if($bianco == True)
        {
            if($codice_area_partizione != null)
            {
                return $codice = $anno. "_" . $mese . "_" . $giorno . "_" . $codice_partizione ."-". $codice_area_partizione . "_" . $codice_terreno;
            }
            else
            {
                return $codice = $anno. "_" . $mese . "_" . $giorno . "_" . $codice_partizione . "_" . $codice_terreno;  
            }
        }

        if($qualita == True)
        {   
            return $codice = $anno. "_" . $mese . "_" . $giorno . "_" . $codice_partizione . "_" . $codice_terreno;  
        }

        if($codice_area_partizione != null)
        {
            if($stanza != null)
            {
                $codice = $anno. "_" . $mese . "_" . $giorno . "_" . $codice_partizione ."-". $codice_area_partizione . "_" . $stanza_partizione . "_" . $codice_terreno . "_" . $codice_punto_campionamento;
            }
            else
            {
                $codice = $anno. "_" . $mese . "_" . $giorno . "_" . $codice_partizione ."-". $codice_area_partizione . "_" . $codice_terreno . "_" . $codice_punto_campionamento;
            }
        }
        else
        {
            if($stanza != null)
            {
                $codice = $anno. "_" . $mese . "_" . $giorno . "_" . $codice_partizione . "_" . $stanza_partizione . "_" . $codice_terreno . "_" . $codice_punto_campionamento;
            }
            else
            {
                $codice = $anno. "_" . $mese . "_" . $giorno . "_" . $codice_partizione . "_" . $codice_terreno . "_" . $codice_punto_campionamento;
            }       
        }

        return $codice;
    }
}
