<?php

namespace App\Http\Controllers;

use App\RapportoRelazione;
use Illuminate\Http\Request;
use App\Reparto;
use Yajra\DataTables\DataTables;
use App\Progetto;
use Log;
use DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Event\LoggerEvent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\StruttRep;
use App\Societa;
use App\Struttura;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notifiable;
use App\Notifications\SendEmail;
use App\Notifications\SendEmailDir;
use App\Notifications\SendEmailApprovazione;
use App\User;
use App\ConversionePartizioneReparti;
use App\ConversioneProgetto;
use App\ConversioneStrutturaStrutture;
use App\Campagna;
use App\AreaPartizione;
use App\Campione;
use Carbon\Carbon;
use App\MicroSuPiastra;
use App\ConversioneAbbreviazioneTipiPiastre;
use App\RappRelCampioni;
use App\SpeciazioneCampione;
use PDF;
use URL;
use setasign\Fpdi\Fpdi;
use Symfony\Component\Process\Exception\InvalidArgumentException;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\RdpAnteprima;
use App\NotaCampionamentoRdpAnteprima;
use App\PlanimetriaRdpAnteprima;
use App\DescrizioneCampionamentoRdpAnteprima;


class RapportoRelazioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $societa = Societa::orderBy('nome','ASC')->get();
        return view('relazioni_e_rapporti.filtro',compact('societa'));
    }

      /**
     * Ritorna il contenuto della DataTable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function list(Request $request, $progetto, $struttura, $reparto)
    {
        if(\Artesaos\Defender\Facades\Defender::hasRole('admin') || \Artesaos\Defender\Facades\Defender::hasRole('gestore'))
        {
            $rapprel = RapportoRelazione::leftJoin('progetti', 'progetti.id', '=', 'rapp_rel.id_progetto')
                                        ->leftJoin('reparti','reparti.id','=','rapp_rel.id_reparto')
                                        ->leftJoin('strutture','strutture.id','=','rapp_rel.ospedale')
                                        ->leftJoin('societa','societa.id','=','progetti.id_societa')
                                        ->where('rapp_rel.versione',2);


            if($progetto != "tutti")
            {
                $rapprel = $rapprel->where('rapp_rel.id_progetto','=',$progetto);
            }

            if($struttura != "tutti")
            {
                $rapprel = $rapprel->where('rapp_rel.ospedale','=',$struttura);
            }

            if($reparto != "tutti")
            {
                $rapprel = $rapprel->where('rapp_rel.id_reparto','=',$reparto);
            }
 

            $rapprel = $rapprel->select(['rapp_rel.*','progetti.progetto as progetto','progetti.id as id_progetto','strutture.struttura as struttura','reparti.partizione as reparto','societa.id as id_societa']);


            return DataTables::of($rapprel)
            ->addColumn('azione', function ($rapprel) {
                if($rapprel->committente == 1)
                {
                    $modifica_href = action('RapportoRelazioneController@createDocumento_committente', ['id_rdp' => $rapprel->id,'id_progetto' => $rapprel->id_progetto,'id_struttura' => $rapprel->ospedale,'id_reparto' => $rapprel->id_reparto, 'areapartizione' => $rapprel->id_areapartizione,'id_societa' => $rapprel->id_societa, 'data_campagna' => $rapprel->dataCampagna,'create' => 0]);
                }
                else
                {
                    $modifica_href = action('RapportoRelazioneController@createDocumento', ['id_rdp' => $rapprel->id,'id_progetto' => $rapprel->id_progetto,'id_struttura' => $rapprel->ospedale,'id_reparto' => $rapprel->id_reparto,'areapartizione' => $rapprel->id_areapartizione, 'id_societa' => $rapprel->id_societa, 'data_campagna' => $rapprel->dataCampagna,'create' => False]);
                }
                $eventi_href = action('LogEventController@filterData', ['id_rdp' => $rapprel->id,'id_progetto' => $rapprel->id_progetto,'id_struttura' => $rapprel->ospedale,'id_reparto' => $rapprel->id_reparto, 'id_societa' => $rapprel->id_societa, 'data_campagna' => $rapprel->dataCampagna,'create' => 0]);
                $rev_href = action('RapportoRelazioneController@creaRev', ['id_rdp' => $rapprel->id,'id_progetto' => $rapprel->id_progetto,'id_struttura' => $rapprel->ospedale,'id_reparto' => $rapprel->id_reparto,'areapartizione' => $rapprel->id_areapartizione, 'id_societa' => $rapprel->id_societa, 'data_campagna' => $rapprel->dataCampagna]);
                if($rapprel->bloccato == 1)
                {
                    $button = "<div class=\"row\">" .
                            "<div class=\"col-sm-4 w-a mr-0 pr-0\">" .
                                "<a href=\"javascript:void(0);\" id_progetto=\"$rapprel->id_progetto\" bloccato=\"$rapprel->bloccato\" class=\"btn btn-action btn-primary btn-modifica\"  style=\"cursor: not-allowed;\" disabled><i class=\"material-icons\">build</i></a>" .
                            "</div>";
                }
                else
                {
                    $button = "<div class=\"row\">" .
                            "<div class=\"col-sm-4 w-a mr-0 pr-0\">" .
                                "<a href=\" $modifica_href \" id_rapprel=\"$rapprel->id\" id_progetto=\"$rapprel->id_progetto\" bloccato=\"$rapprel->bloccato\" class=\"btn btn-action btn-primary btn-modifica\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Modifica\"><i class=\"material-icons\">build</i></a>" .
                            "</div>";
                }

                if(auth()->user()->diritti == 'tecnico informatico' || auth()->user()->diritti == 'amministratore' || auth()->user()->diritti == 'tecnico cias')
                {

                    if($rapprel->approvato == 1 && (auth()->user()->diritti == 'tecnico informatico' || auth()->user()->diritti == 'amministratore') && $rapprel->file != null)
                    {
                        $button .= 
                                '<div class="col-sm-4 w-a mr-0 pr-0">' .
                                    '<a href="javascript:void(0);" id_rapprel="'. $rapprel->id .'" id_progetto="'.$rapprel->id_progetto.'" bloccato="'.$rapprel->bloccato.'" class="btn btn-action btn-warning btn-spediscimail" data-toggle="tooltip" data-placement="top" data-original-title="Invia mail al committente"><i class="material-icons">email</i></a>' .
                                '</div>';
                    }
                    

                    if((auth()->user()->diritti == 'tecnico informatico' || auth()->user()->diritti == 'tecnico cias') && $rapprel->file != null)
                    {
                        if($rapprel->bloccato == 1 || $rapprel->approvato == 1)
                        {
                            $button .= 
                            '<div class="col-sm-4 w-a mr-0 pr-0">' .
                                '<a href="javascript:void(0);" style="cursor: not-allowed;" id_rapprel="'. $rapprel->id .'" id_progetto="'.$rapprel->id_progetto.'" bloccato="'.$rapprel->bloccato.'" class="btn btn-action bg-blue-grey"  disabled><i class="material-icons">email</i></a>' .
                            '</div>';
                        }
                        else
                        {
                            
                            $button .= 
                            '<div class="col-sm-4 w-a mr-0 pr-0">' .
                                '<a href="javascript:void(0);" id_rapprel="'. $rapprel->id .'" id_progetto="'.$rapprel->id_progetto.'" bloccato="'.$rapprel->bloccato.'" class="btn btn-action bg-blue-grey btn-spediscimaildir" data-toggle="tooltip" data-placement="top" data-original-title="Invia mail alla dir"><i class="material-icons">email</i></a>' .
                            '</div>';
                            
                        }
                    }
                }

                $button .=
                        '<div class="col-sm-4 w-a mr-0 pr-0">' .
                            '<span data-toggle="modal" data-target="#deleteModal">' .
                                '<a href="javascript:void(0);" id="'. $rapprel->id .'" bloccato="'.$rapprel->bloccato.'" class="btn btn-action btn-danger btn-elimina" data-toggle="tooltip" data-placement="top" data-original-title="Elimina" ><i class="material-icons">delete</i></a>' .
                            '</span>' .
                        '</div>';

                $button .=
                        '<div class="col-sm-4 w-a mr-0 pr-0">' .
                            '<a href="'.$eventi_href.'" id="'. $rapprel->id .'" bloccato="'.$rapprel->bloccato.'" class="btn btn-action btn-success btn-eventi" data-toggle="tooltip" data-placement="top" data-original-title="Vai alle info"><i class="material-icons">info_outline</i></a>' .
                        '</div>';
                

                if($rapprel->approvato == 0 && (auth()->user()->diritti == 'amministratore' || auth()->user()->diritti == 'tecnico informatico') && $rapprel->file != null)
                {
                    $button .= 
                    '<div class="col-sm-4 w-a mr-0 pr-0">' .
                        '<span data-toggle="modal" data-target="#approvaModal">' .
                            '<a href="javascript:void(0);" id_rapprel="'. $rapprel->id .'" id_progetto="'.$rapprel->id_progetto.'" bloccato="'.$rapprel->bloccato.'" class="btn btn-action bg-indigo btn-approva"data-toggle="tooltip" data-placement="top" data-original-title="Approva" ><i class="material-icons">check_circle</i></a>' .
                    '</div>';
                }

                if($rapprel->approvato == 1 && (auth()->user()->diritti == 'amministratore' || auth()->user()->diritti == 'tecnico informatico') && $rapprel->file != null)
                {
                    if($rapprel->firmaDirettore == 0)
                    {
                        $button .= 
                        '<div class="col-sm-4 w-a mr-0 pr-0">' .
                                '<a href="javascript:void(0);" id_rapprel="'. $rapprel->id .'" id_progetto="'.$rapprel->id_progetto.'" bloccato="'.$rapprel->bloccato.'" class="btn btn-action bg-light-green btn-firma-direttore"data-toggle="tooltip" data-placement="top" data-original-title="Firma del Direttore" ><i class="material-icons">edit</i></a>' .
                        '</div>';
                    }
                    else
                    {
                        $button .= 
                        '<div class="col-sm-4 w-a mr-0 pr-0">' .
                                '<a href="javascript:void(0);" id_rapprel="'. $rapprel->id .'" id_progetto="'.$rapprel->id_progetto.'" bloccato="'.$rapprel->bloccato.'" class="btn btn-action bg-red btn-annulla-firma-direttore"data-toggle="tooltip" data-placement="top" data-original-title="Annulla firma del Direttore" ><i class="material-icons">edit</i></a>' .
                        '</div>';
                    }
                    if($rapprel->firmaResponsabile == 0)
                    {
                        $button .= 
                        '<div class="col-sm-4 w-a mr-0 pr-0">' .
                                '<a href="javascript:void(0);" id_rapprel="'. $rapprel->id .'" id_progetto="'.$rapprel->id_progetto.'" bloccato="'.$rapprel->bloccato.'" class="btn btn-action bg-lime btn-firma-responsabile"data-toggle="tooltip" data-placement="top" data-original-title="Firma del Responsabile" ><i class="material-icons">edit</i></a>' .
                        '</div>';
                    }
                    else
                    {
                        $button .= 
                        '<div class="col-sm-4 w-a mr-0 pr-0">' .
                                '<a href="javascript:void(0);" id_rapprel="'. $rapprel->id .'" id_progetto="'.$rapprel->id_progetto.'" bloccato="'.$rapprel->bloccato.'" class="btn btn-action bg-red btn-annulla-firma-responsabile"data-toggle="tooltip" data-placement="top" data-original-title="Annulla firma del Responsabile" ><i class="material-icons">edit</i></a>' .
                        '</div>';
                    }
                }

                $button .=
                        '<div class="col-sm-4 w-a mr-0 pr-0">' .
                            '<a href="'.$rev_href.'" id="'. $rapprel->id .'" bloccato="'.$rapprel->bloccato.'" class="btn btn-action bg-deep-orange btn-rev" data-toggle="tooltip" data-placement="top" data-original-title="Crea una rev"><i class="material-icons">assignment_late</i></a>' .
                        '</div>';

                $button .= '</div>';
                                
                return $button;
            })
            ->editColumn('id',function($rapprel){
                return $rapprel->id;
            })
            ->editColumn('dataCampagna',function($rapprel){
                return $rapprel->dataCampagna;
            })
            ->editColumn('progetto',function($rapprel){
                $progetto = Progetto::where('id','=',$rapprel->id_progetto)->first();
                return $progetto ? $progetto->progetto : 'Non specificato';
            })
            ->editColumn('struttura',function($rapprel){
                $struttura = Struttura::where('id','=',$rapprel->ospedale)->first();
                return $struttura ? $struttura->struttura : 'Non specificato';
            })
            ->editColumn('reparto',function($rapprel){
                $partizione = $rapprel->id_reparto > 0 ? (Reparto::where('id',$rapprel->id_reparto)->first() ? Reparto::where('id',$rapprel->id_reparto)->first()->partizione : 'Non specificato') : 'Non specificato';

                if($partizione == 'Non specificato')
                {
                    return $partizione;
                }
                else
                {
                    $area_partizione = AreaPartizione::find($rapprel->id_areapartizione);
                    if($area_partizione == null || ($area_partizione != null && $area_partizione->area_partizione == null))
                    {
                        return $partizione;
                    }
                    elseif($area_partizione->area_partizione != null)
                    {
                        return $partizione . ' ' . $area_partizione->area_partizione;
                    }
                }
            })
            ->editColumn('tipo',function($rapprel){
                return $rapprel->tipo == 'A' ? 'Rapporto di prova' : 'Relazione';
            }) 
            ->editColumn('file',function($rapprel){
                    $button = '<div class="row">' .
                            '<div class="col-sm-4">' .
                            '<a href="rapprel/' . $rapprel->file . '/view" id="'. $rapprel->id .'_documento" class="" target="_blank" >'.$rapprel->file.'</a>' .
                            '</div></div>';
                    return $button;
            })
            ->editColumn('note',function($rapprel){
                return $rapprel->note;
            }) 
            ->filterColumn('progetto', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $progetto = Progetto::whereEncrypted('progetto', 'like', "%" . $keyword . "%")->first()->progetto ?? '';
                $query->where('progetto', 'like', "%" . $progetto . "%");
            })
            ->filterColumn('reparto', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('reparti.partizione', 'like', "%" . $keyword . "%"); 
            })
            ->filterColumn('struttura', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('strutture.struttura', 'like', "%" . $keyword . "%"); 
            })
            ->filterColumn('tipo', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $rapporto = levenshtein(strtolower($keyword), 'rapporto di prova');
                $relazione = levenshtein(strtolower($keyword), 'relazione');
                if($rapporto < $relazione)
                {
                    $query->where('rapp_rel.tipo', '=','A'); 
                }
                else
                {
                    $query->where('rapp_rel.tipo','=','E');
                }
            })
            ->filterColumn('dataCampagna', function ($query) use ($request) {
                if(strpos(request()->search['value'],'/') !== false)
                {
                    $date = explode('/', request()->search['value']);
                    $query->where('rapp_rel.dataCampagna','like',"%".$date[0]."%");
                    for($i=1;$i<count($date);$i++)
                    {
                        $query->where('rapp_rel.dataCampagna','like',"%".$date[$i]."%");
                    }
                }
                else
                {
                    $query->where('rapp_rel.dataCampagna','like',"%".request()->search['value']."%");
                }        
            })
            ->rawColumns(['id','dataCampagna','struttura','reparto','tipo','file','note','azione'])
            ->make(true);
        }
        if(\Artesaos\Defender\Facades\Defender::hasRole('committente') || \Artesaos\Defender\Facades\Defender::hasRole('utente'))
        {
            $prog = Progetto::find(ConversioneProgetto::progettoV1(auth()->user()->progetto) ?? auth()->user()->progetto);
            
            $rapprel = RapportoRelazione::leftJoin('progetti', 'progetti.id', '=', 'rapp_rel.id_progetto')
                                        ->leftJoin('reparti','reparti.id','=','rapp_rel.id_reparto')
                                        ->leftJoin('strutture','strutture.id','=','rapp_rel.ospedale');

            if($prog != null)
            {
                $rapprel = $rapprel->where('rapp_rel.id_progetto','=',$prog->id);

            }

            $rapprel = $rapprel->select(['rapp_rel.*','progetti.progetto as progetto','strutture.struttura as struttura','reparti.partizione as reparto']);

            return DataTables::of($rapprel)
            ->editColumn('id',function($rapprel){
                return $rapprel->id;
            })
            ->editColumn('dataCampagna',function($rapprel){
                return $rapprel->dataCampagna;
            })
            ->editColumn('progetto',function($rapprel){
                $progetto = Progetto::where('id',$rapprel->id_progetto)->first();
                return $progetto->progetto;
            })
            ->editColumn('struttura',function($rapprel){
                return $rapprel->struttura;
            })
            ->editColumn('reparto',function($rapprel){
                return $rapprel->id_reparto > 0 ? $rapprel->reparto : 'Non specificato';
            })
            ->editColumn('tipo',function($rapprel){
                return $rapprel->tipo == 'A' ? 'Rapporto di prova' : 'Relazione';
            }) 
            ->editColumn('file',function($rapprel){
                    $button = '<div class="row">' .
                            '<div class="col-sm-4">' .
                            '<a href="rapprel/' . $rapprel->file . '/view" id="'. $rapprel->id .'_documento" class="" target="_blank" >'.$rapprel->file.'</a>' .
                            '</div></div>';
                    return $button;
            })
            ->editColumn('note',function($rapprel){
                return $rapprel->note;
            }) 
            ->filterColumn('progetto', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->whereEncrypted('progetti.progetto', 'like', "%" . $keyword . "%"); 
            })
            ->filterColumn('reparto', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('reparti.partizione', 'like', "%" . $keyword . "%"); 
            })
            ->filterColumn('struttura', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $query->where('strutture.struttura', 'like', "%" . $keyword . "%"); 
            })
            ->filterColumn('tipo', function ($query) use ($request) {
                $keyword = str_replace(' ','%',request()->search['value']);
                $rapporto = levenshtein(strtolower($keyword), 'rapporto di prova');
                $relazione = levenshtein(strtolower($keyword), 'relazione');
                if($rapporto < $relazione)
                {
                    $query->where('rapp_rel.tipo', '=','A'); 
                }
                else
                {
                    $query->where('rapp_rel.tipo','=','E');
                }
            })
            ->filterColumn('dataCampagna', function ($query) use ($request) {
                if(strpos(request()->search['value'],'/') !== false)
                {
                    $date = explode('/', request()->search['value']);
                    $query->where('rapp_rel.dataCampagna','like',"%".$date[0]."%");
                    for($i=1;$i<count($date);$i++)
                    {
                        $query->where('rapp_rel.dataCampagna','like',"%".$date[$i]."%");
                    }
                }
                else
                {
                    $query->where('rapp_rel.dataCampagna','like',"%".request()->search['value']."%");
                }        
            })
            ->rawColumns(['id','dataCampagna','struttura','reparto','tipo','file','note'])
            ->make(true);          
        }
        
    } 

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $societa = Societa::all();
        $progetti = Progetto::where('versione',2)->get();
        $strutture = Struttura::where('versione',2)->get();
        $reparti = Reparto::where('versione',2)->get();
        $areaPartizione = AreaPartizione::all();
        $view_documento = 0;
        $view_documento_committente = 0;
        return view('relazioni_e_rapporti.create_rapprel',compact('societa','progetti','strutture','reparti','areaPartizione','view_documento','view_documento_committente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Log::info($request);
        $validator = Validator::make($request->all(), [
            
            'file' => 'required|file',
            'ospedale' => 'required|integer',
            'id_progetto' => 'required|integer',
            'id_reparto' => 'required|integer',
            'dataCampagna' => 'required|date',
            'areapartizione' => 'required',
            'rev' => 'required|integer',

            'file' => 'uniqueCombo:rapp_rel,id_progetto,id_reparto,ospedale',
            
        ]);

        if ($validator->fails()) {
            return redirect("/rapprel/uploadRapporto")
                            ->withErrors($validator->messages())
                            ->withInput();
        }
        
        //find areaPartizione
        $area_partizione = $request->areapartizione;
        $areapartizione = "";
        if($area_partizione == 'tutti' || $area_partizione == null || $area_partizione == '')
        {
            $areapartizione = AreaPartizione::where('id_reparto',$request->id_reparto)->where('area_partizione',null)->first();
            if($areapartizione == null)
            {
                $text = 'Errore, non esiste una partizione per i dati selezionati';
                return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
            }
        }
        else
        {
            $areapartizione = AreaPartizione::find($area_partizione);
            if($areapartizione == null)
            {
                $text = 'Errore, non esiste una partizione per i dati selezionati';
                return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
            }
        }

        //search if rapprel exists
        $rapprel = RapportoRelazione::where('id_progetto',$request->id_progetto)
                                    ->where('id_reparto',$request->id_reparto)
                                    ->where('ospedale',$request->ospedale)
                                    ->where('rev',$request->rev ?? 0)
                                    ->where('dataCampagna',$request->dataCampagna)
                                    ->first();
        
        

        if($rapprel)
        {
            if($request->file('file'))
            {
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();

                $file_parts = pathinfo($filename);

                //if file is not pdf or docx or doc 
                if($file_parts['extension'] == 'pdf' || $file_parts['extension'] == 'docx' || $file_parts['extension'] == 'doc')
                {
                    Storage::disk('public')->putFileAs("rapporti_relazioni/", $file, $filename);
                }
                else
                {
                    $message = "Errore, formato file non valido. Inserire un file pdf";
                    return redirect("/rapprel/uploadRapporto")
                            ->withErrors($message)
                            ->withInput();
                }

                
            }
            $rapprel->file = $filename;
            $rapprel->id_utente_genera_rapporto = auth()->user()->id;
            $rapprel->note = $request->note;
            $rapprel->save();

            LoggerEvent::log(auth()->user()->id,"Sostituito il documento al file $request->tipo: nuovo documento $rapprel->file: ",$request->all(),false,null,$rapprel->id);

        }
        else
        {
            $rapprel = new RapportoRelazione;
            $rapprel->note = $request->note;
            $rapprel->id_reparto = $request->id_reparto;
            $rapprel->id_progetto = $request->id_progetto;
            $rapprel->ospedale = $request->ospedale;
            $rapprel->tipo = $request->tipo == 'Rapporto di prova' ? 'A' : 'E';
            $rapprel->id_areapartizione =
            $rapprel->dataCampagna = $request->dataCampagna;
            $rapprel->rev = $request->rev ?? 0;
            $rapprel->id_utente_genera_rapporto = auth()->user()->id;
            $filename = null;
            if($request->file('file'))
            {
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();

                $file_parts = pathinfo($filename);
    
                if($file_parts['extension'] == 'pdf' || $file_parts['extension'] == 'docx' || $file_parts['extension'] == 'doc')
                {
                    Storage::disk('public')->putFileAs("rapporti_relazioni/", $file, $filename);
                }
                else
                {
                    $message = "Errore, formato file non valido. Inserire un file pdf";
                    return redirect("/rapprel/uploadRapporto")
                            ->withErrors($message)
                            ->withInput();
                }    
            }
            
            $rapprel->file = $filename;      

            
            $rapprel->save();
            LoggerEvent::log(auth()->user()->id,"Creazione nuovo file: $request->tipo, con documento: $rapprel->file",$request->all(),false,null,$rapprel->id);
        }
        
        

        return redirect()->route('rapportirelazioni');
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
        if($request->id_progetto == "nessuna")
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
     * Retrieve strutture e reparti di tutti i progetti associati alla società
     * 
     * @param Request $request
     * 
     */
    public function getStruttureReparti(Request $request)
    {
        $tot_reparti = Array();
        if($request->id_progetto == "nessuna")
        {
            return json_encode('nessun progetto selezionato');
        }

        $struttRep = StruttRep::where('id_progetto',$request->id_progetto)->where('id_struttura',$request->struttura)->get();
        if($struttRep == null)
        {
            return response()->json(['message' => 'Errore, dati non validi'],403);
        }

        foreach ($struttRep as $s) {
            $reparti = Reparto::find($s->id_reparto);
            array_push($tot_reparti,['id'=>$reparti->id,'reparto'=>$reparti->partizione]);
        }
        
        return json_encode(['tot_reparti'=>$tot_reparti]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RapportoRelazione  $rapportoRelazione
     * @return \Illuminate\Http\Response
     */
    public function show(RapportoRelazione $rapportoRelazione)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RapportoRelazione  $rapportoRelazione
     * @return \Illuminate\Http\Response
     */
    public function edit(RapportoRelazione $rapportoRelazione)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RapportoRelazione  $rapportoRelazione
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RapportoRelazione $rapportoRelazione)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RapportoRelazione  $rapprel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $rapprel = RapportoRelazione::find($request->id);
        $rapprel_eliminato = null;

        if($rapprel == null)
        {
            $message = "Impossibile eliminare il rapporto di prova, non trovato";
            return response()->json(['message' => $message],403);
        }

        $filename = $rapprel->file;

        // if($filename == null)
        // {
        //     $message = "Attenzione, errore di incosistenza dati, nome file non presente in archivio";
        //     return response()->json(['message' => $message],403);
        // }

        if($filename != null)
        {
            if(Storage::disk('public')->exists("rapporti_relazioni/$filename"))
            {
                Storage::disk('public')->delete("rapporti_relazioni/$filename");
            }

            $rapprel_eliminato = $rapprel->file;
        }
        
        $rapprel->motivo = $request->motivo;
        $rapprel->id_utente_cancella = auth()->user()->id;
        
        $rapprel->update();
        $id_rapprel = $rapprel->id;
        $rapprel->delete();

        //delete all anteprime associated to rdp
        $anteprime = RdpAnteprima::where('id_rapprel',$id_rapprel)->get();
        foreach ($anteprime as $a) {
            $a->delete();
        }
        $notaCampionamentoAnteprima = NotaCampionamentoRdpAnteprima::where('id_rdp',$id_rapprel)->get();
        foreach ($notaCampionamentoAnteprima as $n) {
            $n->delete();
        }
        
        if($rapprel->bloccato == 1)
        {
            LoggerEvent::log(auth()->user()->id,"Eliminazione Documento già inviato al committente: $rapprel_eliminato",$request->all(),false,null, $id_rapprel);
        }
        else
        {
            if($rapprel_eliminato == null)
            {
                LoggerEvent::log(auth()->user()->id,"Eliminazione rapporto. Documento non ancora generato",$request->all(),false,null, $id_rapprel);
            }
            else
            {
                LoggerEvent::log(auth()->user()->id,"Eliminazione Documento in fase di costruzione: $rapprel_eliminato",$request->all(),false,null, $id_rapprel); 
            }
        }

        return json_encode(['ok' => 'documento eliminato correttamente']);
    }

    /**
     * Invia la mail alla dir per l'approvazione del rapporto di prova o della relazione
     */
    public function sendEmailDir(Request $request)
    {
        $input = $request->all();

        $rapprel = RapportoRelazione::find($input['id']);
        if($rapprel == null)
        {
            $message = "Impossibile inviare la mail, documento non trovato";
            return response()->json(['message' => $message],403);
        }

        #ricerca delle mail appartenenti alla dir: mazzacane, caselli e coccagna
        #$users_dir = User::where('diritti','amministratore')->get();
        $users_dir = User::where('diritti','tecnico informatico')->where('versione',2)->get();
        foreach($users_dir as $utente)
        {
            Notification::send($utente, new SendEmailDir($utente,$rapprel));
        }

        LoggerEvent::log(auth()->user()->id,"L'utente $utente->nome $utente->cognome ha inviato la mail alla dir per la conferma del rapporto.",$request->all(),false,null, $rapprel->id); 

        return json_encode('ok');
    }

    /**
     * Invia la mail al tecnico cias per la visualizzazione dell'esito di approvazione dell'rdp generato
     */
    public function sendEmailApprovazione(Request $request)
    {
        $input = $request->all();
        $motivo = $request->motivo != null ? $request->motivo : '';

        $rapprel = RapportoRelazione::find($input['id']);

        if($rapprel == null)
        {
            $message = "Impossibile inviare la mail, documento non trovato";
            return response()->json(['message' => $message],403);
        }

        $progetto = Progetto::find($rapprel->id_progetto);

        if($progetto == null)
        {
            $message = "Errore inconsistenza dati, progetto non trovato";
            return response()->json(['message' => $message],403);
        }

        $campagna = Campagna::where('id_societa',$progetto->id_societa)
                            ->where('id_progetto',$progetto->id)
                            ->where('id_struttura',$rapprel->ospedale)
                            ->where('dataCampagna',$rapprel->dataCampagna)
                            ->first();

        if($campagna == null)
        {
            $message = "Errore inconsistenza dati, campagna non trovata";
            return response()->json(['message' => $message],403);
        }
        
        Log::info("id utente che genera il rapporto: ".$rapprel->id_utente_genera_rapporto);
        $user = User::find($rapprel->id_utente_genera_rapporto);
        if($user == null)
        {
            $message = "Impossibile inviare la mail, utente non trovato";
            return response()->json(['message' => $message],403);
        }
        
        $approvazione = $request->approvazione == 'si' ? 'Approvato' : 'Non approvato';

        Notification::send($user, new SendEmailApprovazione($user,$rapprel,$motivo));

        if($approvazione == 'Approvato')
        {
            $rapprel->data_approvazione = date('Y-m-d H:i:s');
            $rapprel->approvato = 1;
            $rapprel->update();

            $campioni = Campione::where('id_campagna',$campagna->id)->where('id_progetto',$progetto->id)->where('id_struttura',$rapprel->ospedale)->where('id_areareparto',$rapprel->id_areapartizione)->where('tipoScheda',0)->get();
            foreach($campioni as $c)
            {
                $c->bloccato = 1;
                $c->update();

                LoggerEvent::log(auth()->user()->id,"Campione $c->id bloccato in seguito ad approvazione del rapporto di prova $rapprel->file con id $rapprel->id",$request->all(),false,$c->id,$rapprel->id); 
            }
        }

        $utente_loggato = auth()->user()->nome . " " . auth()->user()->cognome;
        LoggerEvent::log(auth()->user()->id,"L'utente $utente_loggato ha inviato al tecnico cias $user->nome $user->cognome la mail relativa all'approvazione del rapporto. Esito: $approvazione",$request->all(),false,null, $rapprel->id); 

        return json_encode('ok');
    }

    /**
     * Invia la mail al cliente per la visualizzazione del rapporto di prova o della relazione
     */
    public function sendEmailCommittente(Request $request)
    {
        $input = $request->all();

        $rapprel = RapportoRelazione::find($input['id']);
        if($rapprel == null)
        {
            $message = "Impossibile inviare la mail, documento non trovato";
            return response()->json(['message' => $message],403);
        }

        $progetto = Progetto::find($rapprel->id_progetto);

        if($progetto == null)
        {
            $message = "Errore inconsistenza dati, progetto non trovato";
            return response()->json(['message' => $message],403);
        }
        $committente = Progetto::where('id',$input['id_progetto'])->first()->societa;

        if($committente == null)
        {
            $message = "Impossibile inviare la mail, committente non trovato";
            return response()->json(['message' => $message],403);
        }

        # per test usare account tecnico informatico
        Notification::send($committente, new SendEmail($committente, $rapprel, $progetto->progetto));
        
        $rapprel->bloccato = 1;
        $rapprel->data_comunicazione = date('Y-m-d H:i:s');
        $rapprel->update();

        $utente = auth()->user()->nome . " " . auth()->user()->cognome;
        LoggerEvent::log(auth()->user()->id,"L'utente $utente ha inviato la mail al committente per la notifica della generazione del rapporto di prova.",$request->all(),false,null, $rapprel->id); 

        return json_encode('ok');
    }

    /**
     * Cerca tutti gli elementi per la creazione del documento rapporto di prova
     */

    public function createDocumento(Request $request)
    {
        $id_rapprel = null;

        if(isset($request->id_rdp))
        {
            $id_rapprel = $request->id_rdp;
        }

        if($request->id_societa == 'tutti')
        {
            $text = "Inserire un cliente valido.";
            return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
        }

        if($request->id_progetto == 'tutti')
        {
            $text = "Inserire un progetto valido.";
            return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
        }

        if($request->id_struttura == 'tutti')
        {
            $text = "Inserire una struttura valida.";
            return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
        }

        if($request->id_reparto == 'tutti')
        {
            $text = "Inserire una partizione valida.";
            return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
        }

        if($request->data_campagna == '')
        {
            $text = "Inserire una data valida.";
            return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
        }

        //verifico inizialmente se esiste una campagna per i dati selezionati
        $campagna = Campagna::where('id_societa',$request->id_societa)
                            ->where('id_progetto',$request->id_progetto)
                            ->where('id_struttura',$request->id_struttura)
                            ->where('dataCampagna',$request->data_campagna)
                            ->first();

        //Log::info($campagna);
        if($campagna == null)
        {
            $text = 'Errore, non esiste una campagna per i dati selezionati';
            return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
        }
        
        $area_partizione = $request->areapartizione;
        $areapartizione = "";
        if($area_partizione == 'tutti' || $area_partizione == null)
        {
            $areapartizione = AreaPartizione::where('id_reparto',$request->id_reparto)->where('area_partizione',null)->first();
            if($areapartizione == null)
            {
                $text = 'Errore, non esiste una partizione per i dati selezionati';
                return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
            }
        }
        else
        {
            $areapartizione = AreaPartizione::find($area_partizione);
            if($areapartizione == null)
            {
                $text = 'Errore, non esiste una partizione per i dati selezionati';
                return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
            }
        }

        $StruttRep = StruttRep::where('id_progetto',$request->id_progetto)
                                ->where('id_struttura',$request->id_struttura)
                                ->where('id_reparto',$request->id_reparto)
                                ->where('id_associazione',$areapartizione->id)
                                ->first();

        

        if($StruttRep == null)
        {
            $text = 'Errore, risulta che presso la partizione selezionata non vi sono campionamenti';
            return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
        }

        /************************************************************************************************
         * CALCOLO DATI PER ANTEPRIMA RAPPORTO
         */
        $campioni_aria_pca_at_rest_attivo = Campione::where('id_campagna',$campagna->id)
                                                        ->where('id_areareparto',$areapartizione->id)
                                                        ->where('tipoScheda',0)
                                                        ->where('tipoCamp','A')
                                                        ->where('id_tipo_piastra',26)
                                                        ->where('operat','R')
                                                        ->whereIn('tipoCampione',['attivo','piastra'])
                                                        ->select(['campioni.*'])
                                                        ->get();

        $campioni_aria_pca_at_rest_passivo = Campione::where('id_campagna',$campagna->id)
                                                        ->where('id_areareparto',$areapartizione->id)
                                                        ->where('tipoScheda',0)
                                                        ->where('tipoCamp','A')
                                                        ->where('id_tipo_piastra',26)
                                                        ->where('operat','R')
                                                        ->whereIn('tipoCampione',['passivo','piastra'])
                                                        ->select(['campioni.*'])
                                                        ->get();  

        $campioni_aria_dg18_at_rest_attivo = Campione::where('id_campagna',$campagna->id)
                                                        ->where('id_areareparto',$areapartizione->id)
                                                        ->where('tipoScheda',0)
                                                        ->where('tipoCamp','A')
                                                        ->where('id_tipo_piastra',27)
                                                        ->where('operat','R')
                                                        ->whereIn('tipoCampione',['attivo','piastra'])
                                                        ->select(['campioni.*'])
                                                        ->get();
        
        $campioni_aria_dg18_at_rest_passivo = Campione::where('id_campagna',$campagna->id)
                                                        ->where('id_areareparto',$areapartizione->id)
                                                        ->where('tipoScheda',0)
                                                        ->where('tipoCamp','A')
                                                        ->where('id_tipo_piastra',27)
                                                        ->where('operat','R')
                                                        ->whereIn('tipoCampione',['passivo','piastra'])
                                                        ->select(['campioni.*'])
                                                        ->get();                                     

        /**QUESTI DEVONO POI ESSERE RAGGRUPPATI PER STANZE */
        $campioni_aria_pca_operat_attivo = Campione::where('id_campagna',$campagna->id)
                                                        ->where('id_areareparto',$areapartizione->id)
                                                        ->where('tipoScheda',0)
                                                        ->where('id_tipo_piastra',26)
                                                        ->where('tipoCamp','A')
                                                        ->where('operat','O')
                                                        ->whereIn('tipoCampione',['attivo','piastra'])
                                                        ->select(['campioni.*'])
                                                        ->get();
        
        $campioni_aria_pca_operat_passivo = Campione::where('id_campagna',$campagna->id)
                                                        ->where('id_areareparto',$areapartizione->id)
                                                        ->where('tipoScheda',0)
                                                        ->where('tipoCamp','A')
                                                        ->where('id_tipo_piastra',26)
                                                        ->where('operat','O')
                                                        ->whereIn('tipoCampione',['passivo','piastra'])
                                                        ->select(['campioni.*'])
                                                        ->get();
        
        /**PCA OPERAT ATTIVO RAGGRUPPAMENTO PER STANZE*/
        $stanze = [];
        // per ogni campione, vedo quali sono le stanze e le salvo nell'array stanze.
        foreach($campioni_aria_pca_operat_attivo as $c)
        {
            array_push($stanze, $c->numStanza);
        }
        //elimino i duplicati
        $stanze = array_unique($stanze);

        $pca_attivo_stanze = []; // trovate le stanze creo un array associativo in modo da associare ad ogni stanza un array vuoto.
        foreach($stanze  as $key => $s)
        {
            $pca_attivo_stanze[$s] = [];
        }
        
        // rieffettuo uno scorrimento di tutti i campioni di quella piastra con metodo O in modo da assegnare ad ogni stanza il suo campione
        // nell'array associativo, che prima era vuoto, e ora lo vado a riempire man mano.
        //alla fine ottengo un array formate da chiavi (stanze) e valori (array di campioni)
        // per ogni campione, vedo quali sono le stanze e le salvo nell'array stanze.
        foreach($campioni_aria_pca_operat_attivo as $c)
        {
            foreach ($pca_attivo_stanze as $key => $value) 
            {
                if($c->numStanza == $key)
                {
                    array_push($pca_attivo_stanze[$key], $c->toArray());
                }
            }
        }

        /**PCA OPERAT PASSIVO RAGGRUPPAMENTO PER STANZE*/
        $stanze = [];
        // per ogni campione, vedo quali sono le stanze e le salvo nell'array stanze.
        foreach($campioni_aria_pca_operat_passivo as $c)
        {
            array_push($stanze, $c->numStanza);
        }
        //elimino i duplicati
        $stanze = array_unique($stanze);

        $pca_passivo_stanze = []; // trovate le stanze creo un array associativo in modo da associare ad ogni stanza un array vuoto.
        foreach($stanze  as $key => $s)
        {
            $pca_passivo_stanze[$s] = [];
        }
        
        // rieffettuo uno scorrimento di tutti i campioni di quella piastra con metodo O in modo da assegnare ad ogni stanza il suo campione
        // nell'array associativo, che prima era vuoto, e ora lo vado a riempire man mano.
        //alla fine ottengo un array formate da chiavi (stanze) e valori (array di campioni)
        // per ogni campione, vedo quali sono le stanze e le salvo nell'array stanze.
        foreach($campioni_aria_pca_operat_passivo as $c)
        {
            foreach ($pca_passivo_stanze as $key => $value) 
            {
                if($c->numStanza == $key)
                {
                    array_push($pca_passivo_stanze[$key], $c->toArray());
                }
            }
        }

        /*************************************************************************************************************** */

        /** PREPARAZIONE CAMPIONI CON SPECIAZIONE */

        $campioni_speciazione_pca_aria = SpeciazioneCampione::join('campioni','speciazioni_campioni.id_campione','=','campioni.id')
                                                        ->join('microrganismi_piastre','speciazioni_campioni.id_microrganismo','=','microrganismi_piastre.id')
                                                        ->join('tipi_piastre','speciazioni_campioni.id_tipopiastra','=','tipi_piastre.id')
                                                        ->join('punti_campionamento', 'punti_campionamento.id','=','speciazioni_campioni.id_punto_camp')
                                                        ->where('campioni.id_campagna',$campagna->id)
                                                        ->where('campioni.tipoCamp','A')
                                                        ->where('campioni.id_tipo_piastra',26)
                                                        ->select('campioni.id as id_campione',
                                                                'campioni.codiceCIAS as codice_campione',
                                                                'punti_campionamento.punto_campionamento as punto_campionamento',
                                                                'speciazioni_campioni.esito as risultato',
                                                                'microrganismi_piastre.microrganismo as microrganismo_ricercato',
                                                                'campioni.dataAnalisi as dataInizioProva',
                                                                'campioni.dataFineAnalisi as dataFineProva',
                                                                'campioni.tecnico as tecnico',
                                                                'tipi_piastre.abbreviazione as tipo_terreno')->get();
                                                        

        $campioni_speciazione_pca_superficie = SpeciazioneCampione::join('campioni','speciazioni_campioni.id_campione','=','campioni.id')
                                                        ->join('microrganismi_piastre','speciazioni_campioni.id_microrganismo','=','microrganismi_piastre.id')
                                                        ->join('tipi_piastre','speciazioni_campioni.id_tipopiastra','=','tipi_piastre.id')
                                                        ->join('punti_campionamento', 'punti_campionamento.id','=','speciazioni_campioni.id_punto_camp')
                                                        ->where('campioni.id_campagna',$campagna->id)
                                                        ->where('campioni.tipoCamp','S')
                                                        ->where('campioni.id_tipo_piastra',26)
                                                        ->select('campioni.id as id_campione',
                                                                'campioni.codiceCIAS as codice_campione',
                                                                'punti_campionamento.punto_campionamento as punto_campionamento',
                                                                'speciazioni_campioni.esito as risultato',
                                                                'microrganismi_piastre.microrganismo as microrganismo_ricercato',
                                                                'campioni.dataAnalisi as dataInizioProva',
                                                                'campioni.dataFineAnalisi as dataFineProva',
                                                                'campioni.tecnico as tecnico',
                                                                'tipi_piastre.abbreviazione as tipo_terreno')->get();

        $campioni_speciazione_dg18_aria = SpeciazioneCampione::join('campioni','speciazioni_campioni.id_campione','=','campioni.id')
                                                        ->join('microrganismi_piastre','speciazioni_campioni.id_microrganismo','=','microrganismi_piastre.id')
                                                        ->join('tipi_piastre','speciazioni_campioni.id_tipopiastra','=','tipi_piastre.id')
                                                        ->join('punti_campionamento', 'punti_campionamento.id','=','speciazioni_campioni.id_punto_camp')
                                                        ->where('campioni.id_campagna',$campagna->id)
                                                        ->where('campioni.tipoCamp','A')
                                                        ->where('campioni.id_tipo_piastra',27)
                                                        ->select('campioni.id as id_campione',
                                                                'campioni.codiceCIAS as codice_campione',
                                                                'punti_campionamento.punto_campionamento as punto_campionamento',
                                                                'speciazioni_campioni.esito as risultato',
                                                                'microrganismi_piastre.microrganismo as microrganismo_ricercato',
                                                                'campioni.dataAnalisi as dataInizioProva',
                                                                'campioni.dataFineAnalisi as dataFineProva',
                                                                'campioni.tecnico as tecnico',
                                                                'tipi_piastre.abbreviazione as tipo_terreno')->get();

        $campioni_speciazione_dg18_superficie = SpeciazioneCampione::join('campioni','speciazioni_campioni.id_campione','=','campioni.id')
                                                        ->join('microrganismi_piastre','speciazioni_campioni.id_microrganismo','=','microrganismi_piastre.id')
                                                        ->join('tipi_piastre','speciazioni_campioni.id_tipopiastra','=','tipi_piastre.id')
                                                        ->join('punti_campionamento', 'punti_campionamento.id','=','speciazioni_campioni.id_punto_camp')
                                                        ->where('campioni.id_campagna',$campagna->id)
                                                        ->where('campioni.tipoCamp','S')
                                                        ->where('campioni.id_tipo_piastra',27)
                                                        ->select('campioni.id as id_campione',
                                                                'campioni.codiceCIAS as codice_campione',
                                                                'punti_campionamento.punto_campionamento as punto_campionamento',
                                                                'speciazioni_campioni.esito as risultato',
                                                                'microrganismi_piastre.microrganismo as microrganismo_ricercato',
                                                                'campioni.dataAnalisi as dataInizioProva',
                                                                'campioni.dataFineAnalisi as dataFineProva',
                                                                'campioni.tecnico as tecnico',
                                                                'tipi_piastre.abbreviazione as tipo_terreno')->get();

        $societa = Societa::all();
        $societa_documento = Societa::find($request->id_societa);
        $progetto = Progetto::find($request->id_progetto);
        $struttura = Struttura::find($request->id_struttura);
        $partizione = Reparto::find($request->id_reparto);

        $campioni = Campione::where('id_campagna',$campagna->id)->where('tipoScheda',0)->get();

        $lg = [];
        $lineeguida = [
            '1' => 'ISPESL 2003',
            '2' => 'ISPESL 2009',
            '3' => 'GMP 2008',
            '4' => 'Standart IMQ'
        ];
        foreach ($campioni as $campione) {
            for($i=1; $i<=4; $i++)
            {
                if($campione["lineeGuida$i"] != 0)
                {
                    array_push($lg,$lineeguida[$i]);
                }
            }
        }


        $lg = array_unique($lg);

        $lineeguida_testo = "";
        foreach ($lg as $key => $value) {
            $lineeguida_testo .= $value.", ";
        }
        $lineeguida_testo = substr($lineeguida_testo, 0, -2);

        $progetti = Progetto::where('versione',2)->get(); // serve solo per le due sezioni di upload.
        $view_documento_committente = 0;
        $view_documento = 1;

        $rapprel_esistente = RapportoRelazione::find($request->id_rdp);
        if($rapprel_esistente == null)
        {
            $rapprel = new RapportoRelazione;
            $rapprel->tipo = 'A';
            $rapprel->id_progetto = $request->id_progetto;
            $rapprel->ospedale = $request->id_struttura;
            $rapprel->id_reparto = $request->id_reparto;
            $rapprel->id_areapartizione = $areapartizione->id;
            $rapprel->dataCampagna = $request->data_campagna;
            $rapprel->file = "";
            $rapprel->committente = 0;
            $rapprel->rev = 0;
            $rapprel->id_utente_genera_rapporto = auth()->user()->id;
            $rapprel->versione = 2;
            $rapprel->save();

            foreach($campioni as $c)
            {
                $rapprel_campioni = new RappRelCampioni;
                $rapprel_campioni->id_rapprel = $rapprel->id;
                $rapprel_campioni->id_campione = $c->id;
                $rapprel_campioni->save();
            }

            $id_rapprel = $rapprel->id;
            LoggerEvent::log(auth()->user()->id,"Creato nuovo Rapporto di prova",$request->all(),false,null, $id_rapprel); 
        }
        else
        {
            $id_rapprel = $rapprel_esistente->id;
        }

        $rdp_anteprima = RdpAnteprima::where('id_rapprel',$id_rapprel)->first();
        if($rdp_anteprima != null)
        {
            $anteprima = 1;
            $rdp_anteprima_descrizione = DescrizioneCampionamentoRdpAnteprima::where('id_rdp_anteprima',$rdp_anteprima->id)->get(); 
            if(count($rdp_anteprima_descrizione) > 0)
            {
                return view('relazioni_e_rapporti.gestisci_anteprima_rdp',compact('id_rapprel','campioni','progetti','societa','campagna','societa_documento','progetto','struttura','partizione','areapartizione','view_documento','view_documento_committente','lineeguida_testo','campioni_aria_pca_at_rest_attivo','campioni_aria_pca_at_rest_passivo','campioni_aria_dg18_at_rest_attivo','campioni_aria_dg18_at_rest_passivo','campioni_aria_pca_operat_attivo','campioni_aria_pca_operat_passivo','pca_attivo_stanze','pca_passivo_stanze','campioni_speciazione_pca_aria','campioni_speciazione_pca_superficie','campioni_speciazione_dg18_aria','campioni_speciazione_dg18_superficie','anteprima','rdp_anteprima','rdp_anteprima_descrizione'));
            }
            else
            {
                return view('relazioni_e_rapporti.gestisci_anteprima_rdp',compact('id_rapprel','campioni','progetti','societa','campagna','societa_documento','progetto','struttura','partizione','areapartizione','view_documento','view_documento_committente','lineeguida_testo','campioni_aria_pca_at_rest_attivo','campioni_aria_pca_at_rest_passivo','campioni_aria_dg18_at_rest_attivo','campioni_aria_dg18_at_rest_passivo','campioni_aria_pca_operat_attivo','campioni_aria_pca_operat_passivo','pca_attivo_stanze','pca_passivo_stanze','campioni_speciazione_pca_aria','campioni_speciazione_pca_superficie','campioni_speciazione_dg18_aria','campioni_speciazione_dg18_superficie','anteprima','rdp_anteprima'));
            }
        }
        else
        {
            $anteprima = 1;
            return view('relazioni_e_rapporti.gestisci_anteprima_rdp',compact('id_rapprel','campioni','progetti','societa','campagna','societa_documento','progetto','struttura','partizione','areapartizione','view_documento','view_documento_committente','lineeguida_testo','campioni_aria_pca_at_rest_attivo','campioni_aria_pca_at_rest_passivo','campioni_aria_dg18_at_rest_attivo','campioni_aria_dg18_at_rest_passivo','campioni_aria_pca_operat_attivo','campioni_aria_pca_operat_passivo','pca_attivo_stanze','pca_passivo_stanze','campioni_speciazione_pca_aria','campioni_speciazione_pca_superficie','campioni_speciazione_dg18_aria','campioni_speciazione_dg18_superficie','anteprima'));
        }
    }

    /**
     * Genera il pdf relativo al rapporto di prova
     */
    public function generaPDF(Request $request)
    {
        // Log::info($request);
        $rapprel = RapportoRelazione::find($request->id_rdp);
        if($rapprel == null)
        {
            $text = 'Errore, non esiste un rapporto per i dati selezionati';
            return redirect('/genera_rapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
        }

        $campioni = json_decode($request->campioni);

        /**Pagina 1 */
        $nome_cliente = $request->cliente_nome;
        $indirizzo_cliente = $request->cliente_indirizzo;
        $struttura_partizione = $request->struttura_partizione;
        $indirizzo_struttura = $request->indirizzo_struttura;
        $verbale_campionamento = $request->verbale_campionamento;
        $num_rdp = $request->num_rdp;

        /**Pagina 2 */
        $struttura_indirizzo = $request->struttura_sede;
        $campagna = Campagna::find($request->campagna);
        $dispositivo_di_campionamento_1 = $request->dispositivo_di_campionamento_1;
        $dispositivo_di_campionamento_2 = $request->dispositivo_di_campionamento_2;
        $tipo_di_campionamento = $request->tipo_di_campionamento;
        $portata = $request->portata;
        $volume_campionato = $request->volume_campionato;
        $tipo_di_substrato_pca_1 = $request->tipo_di_substrato_pca_1;
        $tipo_di_substrato_dg18_1 = $request->tipo_di_substrato_dg18_1;
        $condizioni_durata_pca_1 = $request->condizioni_durata_pca_1;
        $condizioni_durata_dg18_1 = $request->condizioni_durata_dg18_1;
        $descrizione_punto_pca_1 = $request->descrizione_punto_pca_1;
        $descrizione_punto_dg18_1 = $request->descrizione_punto_dg18_1;
        $n_prelievi_pca_1 = $request->n_prelievi_pca_1;
        $n_prelievi_dg18_1 = $request->n_prelievi_dg18_1;
        $descrizione_punto_pca_2 = $request->descrizione_punto_pca_2;
        $descrizione_punto_dg18_2 = $request->descrizione_punto_dg18_2;
        $n_prelievi_pca_2 = $request->n_prelievi_pca_2;
        $n_prelievi_dg18_2 = $request->n_prelievi_dg18_2;
        $note_pagina2_1 = $request->note_pagina2_1;
        $note_pagina2_2 = $request->note_pagina2_2;
        $area_di_campionamento = $request->area_di_campionamento;
        $tipo_di_substrato_pca_2 = $request->tipo_di_substrato_pca_2;
        $tipo_di_substrato_dg18_2 = $request->tipo_di_substrato_dg18_2;
        $condizioni_durata_pca_2 = $request->condizioni_durata_pca_2;
        $condizioni_durata_dg18_2 = $request->condizioni_durata_dg18_2;
        $descrizione_punto_pca_3 = $request->descrizione_punto_pca_3;
        $descrizione_punto_dg18_3 = $request->descrizione_punto_dg18_3;
        $n_prelievi_pca_3 = $request->n_prelievi_pca_3;
        $n_prelievi_dg18_3 = $request->n_prelievi_dg18_3;
        $descrizione_punto_pca_4 = $request->descrizione_punto_pca_4;
        $descrizione_punto_dg18_4 = $request->descrizione_punto_dg18_4;
        $n_prelievi_pca_4 = $request->n_prelievi_pca_4;
        $n_prelievi_dg18_4 = $request->n_prelievi_dg18_4;
        $note_pagina2_3 = $request->note_pagina2_3;
        $note_pagina2_4 = $request->note_pagina2_4;

        /**Pagina 3-4 */
        $tipo_di_ambiente = [];
        $numero_e_codifica_locali = [];
        $codice_partizione_stanza = [];
        $class_iso_di_riferimento = [];
        $tipo_di_flusso = [];
        $note_pagina3 = [];
        $stato_di_occupazione_aria_at_rest = [];
        $data_di_campionamento_ora_inizio_e_fine_aria_at_rest = [];
        $strum_n_aria_at_rest = [];
        $n_persone_presenti_aria_at_rest = [];
        $stato_porte_aria_at_rest = [];
        $campionamento_effettuato_da_aria_at_rest = [];
        $note_pagina3_aria_at_rest = [];
        $stato_di_occupazione_aria_operat = [];
        $data_di_campionamento_ora_inizio_e_fine_aria_operat = [];
        $strum_n_aria_operat = [];
        $n_persone_presenti_aria_operat = [];
        $stato_porte_aria_operat= [];
        $campionamento_effettuato_da_aria_operat = [];
        $note_pagina3_aria_operat = [];
        $stato_di_occupazione_superfici = [];
        $data_di_campionamento_ora_inizio_e_fine_superfici = [];
        $n_persone_presenti_superfici = [];
        $stato_porte_superfici = [];
        $campionamento_effettuato_da_superfici = [];
        $note_pagina3_superfici = [];
        $tipo_di_operazione = [];
        for($i = 1; $i<=$request->numero_colonne; $i++)
        {
            $strum_n_aria_operat_string = "";
            $strum_n_aria_at_rest_string = "";
            $tipo_di_ambiente[$i] = $request["tipo_di_ambiente_$i"];
            $numero_e_codifica_locali[$i] = $request["numero_e_codifica_locali_$i"];
            $codice_partizione_stanza[$numero_e_codifica_locali[$i]] = $request["codice_partizione_stanza_$i"];;
            $class_iso_di_riferimento[$i] = $request["class_iso_di_riferimento_$i"];
            $tipo_di_flusso[$i] = $request["tipo_di_flusso_$i"];
            $note_pagina3[$i] = $request["note_pagina3_$i"];
            $stato_di_occupazione_aria_at_rest[$i] = $request["stato_di_occupazione_aria_at_rest_$i"];
            if($request["strum_n_aria_at_rest_$i"] != '/' && gettype($request["strum_n_aria_at_rest_$i"]) == 'array')
            {
                foreach ($request["strum_n_aria_at_rest_$i"] as $key => $value)
                {
                    $strum_n_aria_at_rest_string .= $value.", ";
                }
                $strum_n_aria_at_rest[$i] = substr($strum_n_aria_at_rest_string, 0, -1);
            }
            else
            {
                $strum_n_aria_at_rest[$i] = $request["strum_n_aria_at_rest_$i"];
            }
            $n_persone_presenti_aria_at_rest[$i] = $request["n_persone_presenti_aria_at_rest_$i"];
            $stato_porte_aria_at_rest[$i] = $request["stato_porte_aria_at_rest_$i"];
            $campionamento_effettuato_da_aria_at_rest[$i] = $request["campionamento_effettuato_da_aria_at_rest_$i"];
            $note_pagina3_aria_at_rest[$i] = $request["note_pagina3_aria_at_rest_$i"];
            $stato_di_occupazione_aria_operat[$i] = $request["stato_di_occupazione_aria_operat_$i"];
            if($request["strum_n_aria_operat_$i"] != '/' && gettype($request["strum_n_aria_operat_$i"]) == 'array')
            {
                foreach ($request["strum_n_aria_operat_$i"] as $key => $value)
                {
                    $strum_n_aria_operat_string .= $value.", ";
                }
                $strum_n_aria_operat[$i] = substr($strum_n_aria_operat_string, 0, -1);
            }  
            else
            {
                $strum_n_aria_operat[$i] = $request["strum_n_aria_operat_$i"];
            }
            $n_persone_presenti_aria_operat[$i] = $request["n_persone_presenti_aria_operat_$i"];
            $stato_porte_aria_operat[$i] = $request["stato_porte_aria_operat_$i"];
            $campionamento_effettuato_da_aria_operat[$i] = $request["campionamento_effettuato_da_aria_operat_$i"];
            $note_pagina3_aria_operat[$i] = $request["note_pagina3_aria_operat_$i"];
            $stato_di_occupazione_superfici[$i] = $request["stato_di_occupazione_superfici_$i"];
            $n_persone_presenti_superfici[$i] = $request["n_persone_presenti_superfici_$i"];
            $stato_porte_superfici[$i] = $request["stato_porte_superfici_$i"];
            $campionamento_effettuato_da_superfici[$i] = $request["campionamento_effettuato_da_superfici_$i"];
            $note_pagina3_superfici[$i] = $request["note_pagina3_superfici_$i"];
            $tipo_di_operazione[$i] = $request["tipo_di_operazione_$i"]; 

           
            // $data_di_campionamento_ora_inizio_e_fine_aria_at_rest[$i] = $request["data_di_campionamento_ora_inizio_e_fine_aria_at_rest_data_$i"] . " " . $request["data_di_campionamento_ora_inizio_e_fine_superfici_oraI_$i"] . " " .  $request["data_di_campionamento_ora_inizio_e_fine_superfici_oraF_$i"];
            // $data_di_campionamento_ora_inizio_e_fine_aria_operat[$i] = $request["data_di_campionamento_ora_inizio_e_fine_aria_operat_data_$i"] . " ". $request["data_di_campionamento_ora_inizio_e_fine_aria_operat_oraI_$i"] ." ". $request["data_di_campionamento_ora_inizio_e_fine_aria_operat__oraF_$i"] ;
            // $data_di_campionamento_ora_inizio_e_fine_superfici[$i] = $request["data_di_campionamento_ora_inizio_e_fine_superfici_data_$i"] . " " . $request["data_di_campionamento_ora_inizio_e_fine_superfici_oraI_$i"] . " " . $request["data_di_campionamento_ora_inizio_e_fine_superfici_oraF_$i"];

            $data_di_campionamento_ora_inizio_e_fine_aria_at_rest[$i] = $this->convert_data($request["data_di_campionamento_ora_inizio_e_fine_aria_at_rest_data_$i"],$request["data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraI_$i"],$request["data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraF_$i"]);
            $data_di_campionamento_ora_inizio_e_fine_aria_operat[$i] = $this->convert_data($request["data_di_campionamento_ora_inizio_e_fine_aria_operat_data_$i"],$request["data_di_campionamento_ora_inizio_e_fine_aria_operat_oraI_$i"],$request["data_di_campionamento_ora_inizio_e_fine_aria_operat_oraF_$i"]);
            $data_di_campionamento_ora_inizio_e_fine_superfici[$i] = $this->convert_data($request["data_di_campionamento_ora_inizio_e_fine_superfici_data_$i"],$request["data_di_campionamento_ora_inizio_e_fine_superfici_oraI_$i"],$request["data_di_campionamento_ora_inizio_e_fine_superfici_oraF_$i"]);
        }
        
        #PAGINA 5 - upload planimetrie
        $planimetria = [];
        $caption = [];
        $image = $request->file('planimetria');
        $caption_modificate = [];
        if($image != null)
        {
            $counter = 1;
            $counter_anteprima = 0;
            $numero = 0;
            $trovato = False; // per gestire il caso in cui ho una sola immagine con nome planimetria_0.jpg
            if(count(PlanimetriaRdpAnteprima::where('id_rdp',$rapprel->id)->get()) > 0)
            {
                $trovato = True;
                $numero = count(PlanimetriaRdpAnteprima::where('id_rdp',$rapprel->id)->get()) - 1;
            }
            foreach($image as $key => $value){
                if($numero == 0 && $trovato == False)
                {
                    $imageName = "planimetria_$key.jpg";
                }
                else
                {
                    $numero = $numero + 1;
                    $imageName = "planimetria_$numero.jpg";
                }
                $value->move(Storage::disk('public')->path("planimetrie/$rapprel->id"), $imageName);
                $planimetria[$key] = storage_path() . "/app/public/planimetrie/$rapprel->id/" . $imageName;
                $caption[$counter] = $request["caption_$counter"];
                $counter++;
                $counter_anteprima = $key + 1; // il $key parte da 0 dunque $key + 1 sarà l'elemento successivo
            }
            foreach (PlanimetriaRdpAnteprima::where('id_rdp',$rapprel->id)->get() as $key => $value) {
                $planimetria[$counter_anteprima] = $value->planimetria;
                $caption[$counter] = $value->caption;
                $counter++;
                $counter_anteprima++;
            }
        }
        else //caso in cui non aggiungo altre foto (considero la modifica della caption)
        {
            $counter = 1;
            $counter_anteprima = 0;
            foreach (PlanimetriaRdpAnteprima::where('id_rdp',$rapprel->id)->get() as $key => $value) {
                $planimetria[$counter_anteprima] = $value->planimetria;
                $caption[$counter] = isset($request['caption_planimetria_salvata_'.$value->id]) ? $request['caption_planimetria_salvata_'.$value->id] : $value->caption;
                $caption_modificate[$value->id] = isset($request['caption_planimetria_salvata_'.$value->id]) ? $request['caption_planimetria_salvata_'.$value->id] : $value->caption;
                $counter++;
                $counter_anteprima++;
            }
            
        }

        #pagina 6
        $incaricati_del_campionamento = $request->incaricati_del_campionamento;
        $data_campionamento = $request->data_campionamento;
        $inizio_campionamento_strum = $request->inizio_campionamento_strum;
        $inizio_attivita_in_loco_strum = $request->inizio_attivita_in_loco_strum;
        $fine_attivita_in_loco_strum = $request->fine_attivita_in_loco_strum;
        $fine_campionamento_strum = $request->fine_campionamento_strum;
        $dataOraPartenza = $request->dataOraPartenza;
        $dataOraInizio = $request->dataOraInizio;
        $dataOraFine = $request->dataOraFine;
        $dataOraArrivo = $request->dataOraArrivo;
        $data_accettazione = Carbon::parse($request->data_accettazione)->format('Y-m-d');

        #pagina 7

        /**I vari campioni da distribuire nelle tabelle */
        $campioni_aria_pca_at_rest_attivo = unserialize($request->campioni_aria_pca_at_rest_attivo);
        $campioni_aria_pca_at_rest_passivo = unserialize($request->campioni_aria_pca_at_rest_passivo);
        $pca_attivo_stanze = unserialize($request->pca_attivo_stanze);
        $pca_passivo_stanze = unserialize($request->pca_passivo_stanze);
        $campioni_aria_dg18_at_rest_attivo = unserialize($request->campioni_aria_dg18_at_rest_attivo);
        $campioni_aria_dg18_at_rest_passivo = unserialize($request->campioni_aria_dg18_at_rest_passivo);
        $campioni_stanze_pca_attivo = [];
        $campioni_stanze_pca_passivo = [];

        if($pca_attivo_stanze != null)
        {
            foreach($pca_attivo_stanze as $stanza => $lista_campioni)
            {
                $campioni_stanze_pca_attivo[$stanza] = [];
            }    
        }
        
        if($pca_passivo_stanze != null)
        {
            foreach($pca_passivo_stanze as $stanza => $lista_campioni)
            {
                $campioni_stanze_pca_passivo[$stanza] = [];
            }
        }
        
        $campioni_per_tipo = [
            '_pca_at_rest_attivo' => $campioni_aria_pca_at_rest_attivo,
            '_pca_at_rest_passivo' => $campioni_aria_pca_at_rest_passivo,
            '_pca_operat_attivo' => $pca_attivo_stanze,
            '_pca_operat_passivo' => $pca_passivo_stanze,
            '_dg18_at_rest_attivo' => $campioni_aria_dg18_at_rest_attivo,
            '_dg18_at_rest_passivo' => $campioni_aria_dg18_at_rest_passivo
        ];

        $campioni_analizzati_con_piastra_aria = [
            '_pca_at_rest_attivo' => [],
            '_pca_at_rest_passivo' => [],
            '_pca_operat_attivo' => [],
            '_pca_operat_passivo' => [],
            '_dg18_at_rest_attivo' => [],
            '_dg18_at_rest_passivo' => []
        ];

        $tipi_di_campioni = unserialize($request->tipi_di_campioni);
    
        /**Elementi in comune a tutte le tabelle */
        $dataOraInizioIncubazioneAria = [];
        $dataOraFineIncubazioneAria = [];
        $metodoAria = [];
        $descrizioneMetodoAria = [];
        $tecnicoAria = [];
        $lineeguida = [];       
        
        foreach($tipi_di_campioni as $tipo => $inserito)
        {
            if($inserito == 1)
            {
                $dataOraInizioIncubazioneAria["dataOraInizioIncubazione$tipo"] = $request["dataOraInizioIncubazioneAria$tipo"];
                $dataOraFineIncubazioneAria["dataOraFineIncubazione$tipo"] = $request["dataOraFineIncubazioneAria$tipo"];
                $metodoAria["metodo$tipo"] = $request["metodo_aria$tipo"];
                $descrizioneMetodoAria["descrizione_metodo$tipo"] = $request["descrizione_metodo_aria$tipo"];
                $tecnicoAria["tecnico$tipo"] = $request["tecnico_aria$tipo"];
    
                foreach($campioni_per_tipo[$tipo] as $key => $c)
                {
                   
                    if($tipo == '_pca_operat_attivo')
                    {
                        foreach($c as $camp)
                        {
                            if($camp != null)
                            {

                                array_push($campioni_stanze_pca_attivo[$key],
                                        [
                                            "id_campione" => $request["id_campione_aria_".$camp['id']],
                                            "codice_cias" => $request["codice_cias_aria_".$camp['id']],
                                            "punto_camp" => $request["punto_camp_aria_".$camp['id']],
                                            "CFU" => $request["CFU_aria_".$camp['id']] ?? 'NA',
                                            "U" => $request["U_aria_".$camp['id']] ?? 'NA',
                                            "valori_riferimento" => $request["valori_riferimento_aria_".$camp['id']],
                                        ]                             
                                );
                            }
                        }    
                    }
                    elseif($tipo == '_pca_operat_passivo')
                    {
                        foreach($c as $camp)
                        {
                            if($camp != null)
                            {
                                array_push($campioni_stanze_pca_passivo[$key],
                                        [
                                            "id_campione" => $request["id_campione_aria_".$camp['id']],
                                            "codice_cias" => $request["codice_cias_aria_".$camp['id']],
                                            "punto_camp" => $request["punto_camp_aria_".$camp['id']],
                                            "CFU" => $request["CFU_aria_".$camp['id']] ?? 'NA',
                                            "U" => $request["U_aria_".$camp['id']] ?? 'NA',
                                            "valori_riferimento" => $request["valori_riferimento_aria_".$camp['id']],
                                        ]                            
                                );
                            }
                        }   
                    }
                    else
                    {
                        if($c != null)
                        {
                            array_push($campioni_analizzati_con_piastra_aria[$tipo], 
                                [
                                    "id_campione" => $request["id_campione_aria_".$c['id']],
                                    "codice_cias" => $request["codice_cias_aria_".$c['id']],
                                    "punto_camp" => $request["punto_camp_aria_".$c['id']],
                                    "CFU" => $request["CFU_aria_".$c['id']] ?? 'NA',
                                    "U" => $request["U_aria_".$c['id']] ?? 'NA',
                                    "valori_riferimento" => $request["valori_riferimento_aria_".$c['id']],
                                ]
                            );
                        }
                        
                    }  
                }  
            }
            
        }

        #pagina 8 - 9
        $tipi_piastre_superficie = unserialize($request->tipi_piastre_superficie);
        $tipo_di_campione = unserialize($request->tipo_di_campione);
    
        $dataOraInizioIncubazioneSuperficie = [];
        $dataOraFineIncubazioneSuperficie = [];
        $metodoSuperficie = [];
        $descrizioneMetodoSuperficie = [];
        $tecnicoSuperficie = [];
        $lineeguida = [];

        $campioni_analizzati_con_piastra_superficie = ['pca' => [], 'dg18' => []];
        $campioni_pca = RapportoRelazioneController::get_all_campioni_for_piastra($campioni,26);
        $campioni_dg18 = RapportoRelazioneController::get_all_campioni_for_piastra($campioni,27);
        $campioni = $campioni_pca->merge($campioni_dg18);

        if($tipi_piastre_superficie != null || $tipi_piastre_superficie != [] || $tipi_piastre_superficie != "")
        {
            foreach($tipi_piastre_superficie as $key => $piastra)
            {
                $dataOraInizioIncubazioneSuperficie["dataOraInizioIncubazione_$piastra"] = $request["dataOraInizioIncubazioneSuperficie_$piastra"];
                $dataOraFineIncubazioneSuperficie["dataOraFineIncubazione_$piastra"] = $request["dataOraFineIncubazioneSuperficie_$piastra"];
                $metodoSuperficie["metodo_$piastra"] = $request["metodo_superficie_$piastra"];
                $descrizioneMetodoSuperficie["descrizione_metodo_$piastra"] = $request["descrizione_metodo_superficie_$piastra"];
                $tecnicoSuperficie["tecnico_$piastra"] = $request["tecnico_superficie_$piastra"];
    
                foreach($campioni as $c)
                {
                    
                    if($c->id_tipo_piastra == $key)
                    {
                        
                        array_push($campioni_analizzati_con_piastra_superficie[$piastra],
                            [
                                "id_campione" => $request["id_campione_superficie_$c->id"],
                                "codice_cias" => $request["codice_cias_superficie_$c->id"],
                                "punto_camp" => $request["punto_camp_superficie_$c->id"],
                                "CFU" => $request["CFU_superficie_$c->id"] ?? '/',
                                "U" => $request["U_superficie_$c->id"] ?? 'NA',
                                "valori_riferimento" => $request["valori_riferimento_superficie_$c->id"],
                            ]
                        );
                    }   
                }  
            } 
        }
       
        #delete all element where id_campione => NULL
        if($campioni_analizzati_con_piastra_superficie != null || $campioni_analizzati_con_piastra_superficie != [] || $campioni_analizzati_con_piastra_superficie != "")
        {
            foreach($campioni_analizzati_con_piastra_superficie as $key => $piastra)
            {
                foreach($piastra as $key2 => $campione)
                {
                    if($campione['id_campione'] == NULL)
                    {
                        unset($campioni_analizzati_con_piastra_superficie[$key][$key2]);
                    }
                }
            }
        }
        

        #pagina 10
        $campioni_speciazione_pca_aria = SpeciazioneCampione::join('campioni','speciazioni_campioni.id_campione','=','campioni.id')
                                                        ->join('microrganismi_piastre','speciazioni_campioni.id_microrganismo','=','microrganismi_piastre.id')
                                                        ->join('tipi_piastre','speciazioni_campioni.id_tipopiastra','=','tipi_piastre.id')
                                                        ->join('punti_campionamento', 'punti_campionamento.id','=','speciazioni_campioni.id_punto_camp')
                                                        ->where('campioni.id_campagna',$campagna->id)
                                                        ->where('campioni.tipoCamp','A')
                                                        ->where('campioni.id_tipo_piastra',26)
                                                        ->select('campioni.id as id_campione',
                                                                'campioni.codiceCIAS as codice_campione',
                                                                'punti_campionamento.punto_campionamento as punto_campionamento',
                                                                'speciazioni_campioni.esito as risultato',
                                                                'microrganismi_piastre.microrganismo as microrganismo_ricercato',
                                                                'campioni.dataAnalisi as dataInizioProva',
                                                                'campioni.dataFineAnalisi as dataFineProva',
                                                                'campioni.tecnico as tecnico',
                                                                'tipi_piastre.abbreviazione as tipo_terreno')->get();
                                                        

        $campioni_speciazione_pca_superficie = SpeciazioneCampione::join('campioni','speciazioni_campioni.id_campione','=','campioni.id')
                                                        ->join('microrganismi_piastre','speciazioni_campioni.id_microrganismo','=','microrganismi_piastre.id')
                                                        ->join('tipi_piastre','speciazioni_campioni.id_tipopiastra','=','tipi_piastre.id')
                                                        ->join('punti_campionamento', 'punti_campionamento.id','=','speciazioni_campioni.id_punto_camp')
                                                        ->where('campioni.id_campagna',$campagna->id)
                                                        ->where('campioni.tipoCamp','S')
                                                        ->where('campioni.id_tipo_piastra',26)
                                                        ->select('campioni.id as id_campione',
                                                                'campioni.codiceCIAS as codice_campione',
                                                                'punti_campionamento.punto_campionamento as punto_campionamento',
                                                                'speciazioni_campioni.esito as risultato',
                                                                'microrganismi_piastre.microrganismo as microrganismo_ricercato',
                                                                'campioni.dataAnalisi as dataInizioProva',
                                                                'campioni.dataFineAnalisi as dataFineProva',
                                                                'campioni.tecnico as tecnico',
                                                                'tipi_piastre.abbreviazione as tipo_terreno')->get();

        $campioni_speciazione_dg18_aria = SpeciazioneCampione::join('campioni','speciazioni_campioni.id_campione','=','campioni.id')
                                                        ->join('microrganismi_piastre','speciazioni_campioni.id_microrganismo','=','microrganismi_piastre.id')
                                                        ->join('tipi_piastre','speciazioni_campioni.id_tipopiastra','=','tipi_piastre.id')
                                                        ->join('punti_campionamento', 'punti_campionamento.id','=','speciazioni_campioni.id_punto_camp')
                                                        ->where('campioni.id_campagna',$campagna->id)
                                                        ->where('campioni.tipoCamp','A')
                                                        ->where('campioni.id_tipo_piastra',27)
                                                        ->select('campioni.id as id_campione',
                                                                'campioni.codiceCIAS as codice_campione',
                                                                'punti_campionamento.punto_campionamento as punto_campionamento',
                                                                'speciazioni_campioni.esito as risultato',
                                                                'microrganismi_piastre.microrganismo as microrganismo_ricercato',
                                                                'campioni.dataAnalisi as dataInizioProva',
                                                                'campioni.dataFineAnalisi as dataFineProva',
                                                                'campioni.tecnico as tecnico',
                                                                'tipi_piastre.abbreviazione as tipo_terreno')->get();

        $campioni_speciazione_dg18_superficie = SpeciazioneCampione::join('campioni','speciazioni_campioni.id_campione','=','campioni.id')
                                                        ->join('microrganismi_piastre','speciazioni_campioni.id_microrganismo','=','microrganismi_piastre.id')
                                                        ->join('tipi_piastre','speciazioni_campioni.id_tipopiastra','=','tipi_piastre.id')
                                                        ->join('punti_campionamento', 'punti_campionamento.id','=','speciazioni_campioni.id_punto_camp')
                                                        ->where('campioni.id_campagna',$campagna->id)
                                                        ->where('campioni.tipoCamp','S')
                                                        ->where('campioni.id_tipo_piastra',27)
                                                        ->select('campioni.id as id_campione',
                                                                'campioni.codiceCIAS as codice_campione',
                                                                'punti_campionamento.punto_campionamento as punto_campionamento',
                                                                'speciazioni_campioni.esito as risultato',
                                                                'microrganismi_piastre.microrganismo as microrganismo_ricercato',
                                                                'campioni.dataAnalisi as dataInizioProva',
                                                                'campioni.dataFineAnalisi as dataFineProva',
                                                                'campioni.tecnico as tecnico',
                                                                'tipi_piastre.abbreviazione as tipo_terreno')->get();

        $dataFineProva_pca_aria = $request->dataFineProva_pca_aria;
        $dataFineProva_pca_superficie = $request->dataFineProva_pca_superficie;
        $dataFineProva_dg18_aria = $request->dataFineProva_dg18_aria;
        $dataFineProva_dg18_superficie = $request->dataFineProva_dg18_superficie;
    
        #pagina 11
        $superano = $request->superano;
        $lineeguida1 = $request->lineeguida1_page11;        
        $lineeguida2 = $request->lineeguida2_page11;
        $esito = $request->esito;
        $campione_esito = $request->campione_esito;
        $no_incertezza = $request->no_incertezza;



        #appendice
        $riferimenti = [];
        $riferimenti7_accessori = [];
        $riferimenti8_accessori = [];
        $count_riferimenti = 0;
        for($i = 1; $i <= 8; $i++)
        {
            if($request["riferimento$i"] != null)
            {
                array_push($riferimenti, ["$i" => 1]);
                $count_riferimenti++;
            }
            else
            {
                array_push($riferimenti, ["$i" => 0]);
            }

            if($i == 7 && isset($request->riferimento7))
            {
                if(isset($request->riferimento7_table1))
                {
                    array_push($riferimenti7_accessori,[$i.'_table1' =>  1]);
                    $count_riferimenti++;
                }
                else
                {
                    array_push($riferimenti7_accessori,[$i.'_table1' =>  0]);
                }

                if(isset($request->riferimento7_table2))
                {
                    array_push($riferimenti7_accessori,[$i.'_table2' =>  1]);
                    $count_riferimenti++;

                }
                else
                {
                    array_push($riferimenti7_accessori,[$i.'_table2' =>  0]);
                    
                }
            }

            if($i == 8)
            {
                if(isset($request->riferimento8_indicazione1) || isset($request->riferimento8_indicazione2))
                {
                    array_push($riferimenti, ["8" => 1]);
                    $count_riferimenti++;
                }

                if(isset($request->riferimento8_indicazione1))
                {
                    array_push($riferimenti8_accessori,['8_indicazione1' =>  1]);
                    $count_riferimenti++;
                }
                else
                {
                    array_push($riferimenti8_accessori,['8_indicazione1' =>  0]);
                }
                if(isset($request->riferimento8_indicazione2))
                {
                    array_push($riferimenti8_accessori,['8_indicazione2' =>  1]);
                    $count_riferimenti++;
                }
                else
                {
                    array_push($riferimenti8_accessori,['8_indicazione2' =>  0]);
                }
                if(isset($request->riferimento8_indicazione3))
                {
                    array_push($riferimenti8_accessori,['8_indicazione3' =>  1]);
                    $count_riferimenti++;
                }
                else
                {
                    array_push($riferimenti8_accessori,['8_indicazione3' =>  0]);
                }
                if(isset($request->riferimento8_indicazione4))
                {
                    array_push($riferimenti8_accessori,['8_indicazione4' =>  1]);
                    $count_riferimenti++;
                }
                else
                {
                    array_push($riferimenti8_accessori,['8_indicazione4' =>  0]);
                }
            }
        }

        $riferimento8_portata = $request->riferimento8_portata;
        #last page
        $opinioni = "In relazione ai risultati ottenuti, in base a quanto indicato dalle Linee Guida di riferimento " . $request->opinioni_ed_interpretazioni_lineeguida ." si suggerisce di ". $request->opinioni_ed_interpretazioni;
        $note_di_revisione = $request->note_di_revisione;

        $rev_precedente = 0;
        $rapprel_da_correggere = "";
        if($rapprel->rev != 0 && $rapprel->id_rapporto_rev != null)
        {
            $rapprel_da_correggere = RapportoRelazione::find($rapprel->id_rapporto_rev);
            $rev_precedente = 1;
        }

        $pdf = PDF::loadView(
            'relazioni_e_rapporti.rapporto_pdf',
            [
                'rev_precedente' => $rev_precedente,
                'rapprel_da_correggere' => $rapprel_da_correggere,
                'rapprel' => $rapprel,
                'campioni' => $campioni,
                'campagna' => $campagna,
                'numero_colonne' => $request->numero_colonne,
                'nome_cliente' => $nome_cliente,
                'indirizzo_cliente' => $indirizzo_cliente,
                'indirizzo_struttura' => $indirizzo_struttura,
                'struttura_partizione' => $struttura_partizione,
                'verbale_campionamento' => $verbale_campionamento, 
                'struttura_indirizzo' => $struttura_indirizzo,
                'dispositivo_di_campionamento_1' => $dispositivo_di_campionamento_1,
                'dispositivo_di_campionamento_2' => $dispositivo_di_campionamento_2,
                'tipo_di_campionamento' => $tipo_di_campionamento,
                'portata' => $portata,
                'volume_campionato' => $volume_campionato,
                'tipo_di_substrato_pca_1' => $tipo_di_substrato_pca_1,
                'tipo_di_substrato_dg18_1' => $tipo_di_substrato_dg18_1,
                'condizioni_durata_pca_1' => $condizioni_durata_pca_1,
                'condizioni_durata_dg18_1' => $condizioni_durata_dg18_1,
                'descrizione_punto_pca_1' => $descrizione_punto_pca_1,
                'descrizione_punto_dg18_1' => $descrizione_punto_dg18_1,
                'n_prelievi_pca_1' => $n_prelievi_pca_1,
                'n_prelievi_dg18_1' => $n_prelievi_dg18_1,
                'descrizione_punto_pca_2' => $descrizione_punto_pca_2,
                'descrizione_punto_dg18_2' => $descrizione_punto_dg18_2,
                'n_prelievi_pca_2' => $n_prelievi_pca_2,
                'n_prelievi_dg18_2' => $n_prelievi_dg18_2,
                'note_pagina2_1' => $note_pagina2_1,
                'note_pagina2_2' => $note_pagina2_2,
                'area_di_campionamento' => $area_di_campionamento,
                'tipo_di_substrato_pca_2' => $tipo_di_substrato_pca_2,
                'tipo_di_substrato_dg18_2' => $tipo_di_substrato_dg18_2,
                'condizioni_durata_pca_2' => $condizioni_durata_pca_2,
                'condizioni_durata_dg18_2' => $condizioni_durata_dg18_2,
                'descrizione_punto_pca_3' => $descrizione_punto_pca_3,
                'descrizione_punto_dg18_3' => $descrizione_punto_dg18_3,
                'n_prelievi_pca_3' => $n_prelievi_pca_3,
                'n_prelievi_dg18_3' => $n_prelievi_dg18_3,
                'descrizione_punto_pca_4' => $descrizione_punto_pca_4,
                'descrizione_punto_dg18_4' => $descrizione_punto_dg18_4,
                'n_prelievi_pca_4' => $n_prelievi_pca_4,
                'n_prelievi_dg18_4' => $n_prelievi_dg18_4,
                'note_pagina2_3' => $note_pagina2_3,
                'note_pagina2_4' => $note_pagina2_4,
                'tipo_di_ambiente' => $tipo_di_ambiente,
                'numero_e_codifica_locali' => $numero_e_codifica_locali,
                'codice_partizione_stanza' => $codice_partizione_stanza,
                'class_iso_di_riferimento' => $class_iso_di_riferimento,
                'tipo_di_flusso' => $tipo_di_flusso,
                'note_pagina3' => $note_pagina3,
                'stato_di_occupazione_aria_at_rest' => $stato_di_occupazione_aria_at_rest,
                'data_di_campionamento_ora_inizio_e_fine_aria_at_rest' => $data_di_campionamento_ora_inizio_e_fine_aria_at_rest,
                'strum_n_aria_at_rest' => $strum_n_aria_at_rest,
                'n_persone_presenti_aria_at_rest' => $n_persone_presenti_aria_at_rest,
                'stato_porte_aria_at_rest' => $stato_porte_aria_at_rest,
                'campionamento_effettuato_da_aria_at_rest' => $campionamento_effettuato_da_aria_at_rest,
                'note_pagina3_aria_at_rest' => $note_pagina3_aria_at_rest,
                'stato_di_occupazione_aria_operat' => $stato_di_occupazione_aria_operat,
                'data_di_campionamento_ora_inizio_e_fine_aria_operat' => $data_di_campionamento_ora_inizio_e_fine_aria_operat,
                'strum_n_aria_operat' => $strum_n_aria_operat,
                'n_persone_presenti_aria_operat' => $n_persone_presenti_aria_operat,
                'stato_porte_aria_operat' => $stato_porte_aria_operat,
                'tipo_di_operazione' => $tipo_di_operazione,
                'campionamento_effettuato_da_aria_operat' => $campionamento_effettuato_da_aria_operat,
                'note_pagina3_aria_operat' => $note_pagina3_aria_operat,
                'stato_di_occupazione_superfici' => $stato_di_occupazione_superfici,
                'data_di_campionamento_ora_inizio_e_fine_superfici' => $data_di_campionamento_ora_inizio_e_fine_superfici,
                'n_persone_presenti_superfici' => $n_persone_presenti_superfici,
                'stato_porte_superfici' => $stato_porte_superfici,
                'campionamento_effettuato_da_superfici' => $campionamento_effettuato_da_superfici,
                'note_pagina3_superfici' => $note_pagina3_superfici,
                'planimetria' =>  $planimetria,
                'incaricati_del_campionamento' => $incaricati_del_campionamento,
                'data_campionamento' => $data_campionamento,
                'inizio_campionamento_strum' => $inizio_campionamento_strum,
                'inizio_attivita_in_loco_strum' => $inizio_attivita_in_loco_strum,
                'fine_attivita_in_loco_strum' => $fine_attivita_in_loco_strum,
                'fine_campionamento_strum' => $fine_campionamento_strum,
                'data_accettazione' => $data_accettazione,
                'dataOraPartenza' => $dataOraPartenza, 
                'dataOraInizio' => $dataOraInizio, 
                'dataOraFine' => $dataOraFine, 
                'dataOraArrivo' => $dataOraArrivo, 
                'tipi_di_campioni' => $tipi_di_campioni,
                'campioni_stanze_pca_attivo' => $campioni_stanze_pca_attivo,
                'campioni_stanze_pca_passivo' => $campioni_stanze_pca_passivo,
                'campioni_analizzati_con_piastra_aria' => $campioni_analizzati_con_piastra_aria,
                'tipi_piastre_superficie' => $tipi_piastre_superficie,
                'dataOraInizioIncubazioneAria' => $dataOraInizioIncubazioneAria,
                'dataOraFineIncubazioneAria' => $dataOraFineIncubazioneAria,
                'metodoAria' => $metodoAria,
                'descrizioneMetodoAria' => $descrizioneMetodoAria,
                'descrizioneMetodoSuperficie' => $descrizioneMetodoSuperficie,
                'tecnicoAria' => $tecnicoAria,
                'lineeGuidaAria' => unserialize($request->lineeGuida_aria),
                'dataOraInizioIncubazioneSuperficie' => $dataOraInizioIncubazioneSuperficie,
                'dataOraFineIncubazioneSuperficie' => $dataOraFineIncubazioneSuperficie,
                'metodoSuperficie' => $metodoSuperficie,
                'tecnicoSuperficie' => $tecnicoSuperficie,
                'campioni_analizzati_con_piastra_superficie' => $campioni_analizzati_con_piastra_superficie,
                'lineeGuidaSuperficie' => unserialize($request->lineeGuida_superficie),
                'campioni_speciazione_pca_aria' => $campioni_speciazione_pca_aria,
                'campioni_speciazione_pca_superficie' => $campioni_speciazione_pca_superficie,                
                'campioni_speciazione_dg18_aria' => $campioni_speciazione_dg18_aria,
                'campioni_speciazione_dg18_superficie' => $campioni_speciazione_dg18_superficie,
                'dataFineProva_pca_aria' => $request->dataFineProva_pca_aria,
                'dataFineProva_pca_superficie' => $request->dataFineProva_pca_superficie,
                'dataFineProva_dg18_aria' => $request->dataFineProva_dg18_aria,
                'dataFineProva_dg18_superficie' => $request->dataFineProva_dg18_superficie,
                'superano' => $superano,
                'lineeguida1' => $lineeguida1,
                'lineeguida2' => $lineeguida2,
                'esito' => $esito,
                'campione_esito' => $campione_esito,
                'no_incertezza' => $no_incertezza,
                'opinioni' => $opinioni,
                'note_di_revisione' => $note_di_revisione,
                'num_rdp' => $num_rdp,
                'riferimenti' => $riferimenti,
                'count_riferimenti' => $count_riferimenti,
                'riferimenti7_accessori' => $riferimenti7_accessori,
                'riferimenti8_accessori' => $riferimenti8_accessori,
                'riferimento8_portata' => $riferimento8_portata,
                'firmaDirettore' => null,
                'firmaResponsabile' => null,
                'caption' => $caption,
                'anteprima' => RdpAnteprima::where('id_rapprel', $rapprel->id)->first() != null ? 1 : 0
            ]
        );        
        $content = $pdf->download()->getOriginalContent();
        $path_folder = "rapporti_relazioni";
        if($rapprel->rev == 0)
        {
            $fileName = "MOD_01_RDP_".$num_rdp."_".Carbon::now()->format('Y-m-d').".pdf";
        }
        else
        {
            $fileName = "MOD_01_RDP_".$num_rdp."_".Carbon::now()->format('Y-m-d')."_0".$rapprel->rev.".pdf";
        }

        Storage::put("public/$path_folder/$fileName", $content);

        $rapprel->file = $fileName;
        $rapprel->data_generazione = Carbon::now()->format('Y-m-d');
        $rapprel->save();

        //creazione tupla in rdp_anteprima
        $anteprima = RdpAnteprima::where('id_rapprel', $rapprel->id)->first();
        if($anteprima == null)
        {
            $anteprima = new RdpAnteprima;
            $anteprima->id_rapprel = $rapprel->id;
        }
        //pagina 1
        $anteprima->n_rdp = $num_rdp;
        $anteprima->nome_cliente = $nome_cliente;
        $anteprima->indirizzo_cliente = $indirizzo_cliente;
        $anteprima->indirizzo_struttura = $indirizzo_struttura;
        $anteprima->struttura_partizione = $struttura_partizione;
        $anteprima->verbale_campionamento = $verbale_campionamento;
        $anteprima->struttura_indirizzo = $struttura_indirizzo;
        //pagina 2
        $anteprima->dispositivo_di_campionamento_1 = $dispositivo_di_campionamento_1;
        $anteprima->dispositivo_di_campionamento_2 = $dispositivo_di_campionamento_2;
        $anteprima->tipo_di_campionamento = $tipo_di_campionamento;
        $anteprima->portata = $portata;
        $anteprima->volume_campionato = $volume_campionato;
        $anteprima->tipo_di_substrato_pca_1 = $tipo_di_substrato_pca_1;
        $anteprima->tipo_di_substrato_dg18_1 = $tipo_di_substrato_dg18_1;
        $anteprima->condizioni_durata_pca_1 = $condizioni_durata_pca_1;
        $anteprima->condizioni_durata_dg18_1 = $condizioni_durata_dg18_1;
        $anteprima->descrizione_punto_pca_1 = $descrizione_punto_pca_1;
        $anteprima->descrizione_punto_dg18_1 = $descrizione_punto_dg18_1;
        $anteprima->n_prelievi_pca_1 = $n_prelievi_pca_1;
        $anteprima->n_prelievi_dg18_1 = $n_prelievi_dg18_1;
        $anteprima->descrizione_punto_pca_2 = $descrizione_punto_pca_2;
        $anteprima->descrizione_punto_dg18_2 = $descrizione_punto_dg18_2;
        $anteprima->n_prelievi_pca_2 = $n_prelievi_pca_2;
        $anteprima->n_prelievi_dg18_2 = $n_prelievi_dg18_2;
        $anteprima->note_pagina2_1 = $note_pagina2_1;
        $anteprima->note_pagina2_2 = $note_pagina2_2;
        $anteprima->area_di_campionamento = $area_di_campionamento;
        $anteprima->tipo_di_substrato_pca_2 = $tipo_di_substrato_pca_2;
        $anteprima->tipo_di_substrato_dg18_2 = $tipo_di_substrato_dg18_2;
        $anteprima->condizioni_durata_pca_2 = $condizioni_durata_pca_2;
        $anteprima->condizioni_durata_dg18_2 = $condizioni_durata_dg18_2;
        $anteprima->descrizione_punto_pca_3 = $descrizione_punto_pca_3;
        $anteprima->descrizione_punto_dg18_3 = $descrizione_punto_dg18_3;
        $anteprima->n_prelievi_pca_3 = $n_prelievi_pca_3;
        $anteprima->n_prelievi_dg18_3 = $n_prelievi_dg18_3;
        $anteprima->descrizione_punto_pca_4 = $descrizione_punto_pca_4;
        $anteprima->descrizione_punto_dg18_4 = $descrizione_punto_dg18_4;
        $anteprima->n_prelievi_pca_4 = $n_prelievi_pca_4;
        $anteprima->n_prelievi_dg18_4 = $n_prelievi_dg18_4;
        $anteprima->note_pagina2_3 = $note_pagina2_3;
        $anteprima->note_pagina2_4 = $note_pagina2_4;
        //pagina 6
        $anteprima->incaricati_del_campionamento = $incaricati_del_campionamento;
        $anteprima->data_campionamento = $data_campionamento;
        $anteprima->inizio_campionamento_strum = $inizio_campionamento_strum;
        $anteprima->inizio_attivita_in_loco_strum = $inizio_attivita_in_loco_strum;
        $anteprima->fine_attivita_in_loco_strum = $fine_attivita_in_loco_strum;
        $anteprima->fine_campionamento_strum = $fine_campionamento_strum;
        $anteprima->data_accettazione = $data_accettazione;
        $anteprima->dataOraPartenza = $dataOraPartenza;
        $anteprima->dataOraInizio = $dataOraInizio;
        $anteprima->dataOraFine = $dataOraFine;
        $anteprima->dataOraArrivo = $dataOraArrivo;
        $anteprima->superano = $superano;
        $anteprima->lineeguida1 = $lineeguida1;
        $anteprima->lineeguida2 = $lineeguida2;
        $anteprima->esito = $esito;
        $anteprima->campione_esito = $campione_esito;
        $anteprima->no_incertezza = $no_incertezza;
        $anteprima->opinioni_ed_interpretazioni = $request->opinioni_ed_interpretazioni;
        $anteprima->opinioni_ed_interpretazioni_lineeguida = $request->opinioni_ed_interpretazioni_lineeguida;
        $anteprima->note_di_revisione = $note_di_revisione;
        $anteprima->riferimento1 = $request["riferimento1"] != null ? 1 : 0;
        $anteprima->riferimento2 = $request["riferimento2"] != null ? 1 : 0;
        $anteprima->riferimento3 = $request["riferimento3"] != null ? 1 : 0;
        $anteprima->riferimento4 = $request["riferimento4"] != null ? 1 : 0;
        $anteprima->riferimento5 = $request["riferimento5"] != null ? 1 : 0;
        $anteprima->riferimento6 = $request["riferimento6"] != null ? 1 : 0;
        $anteprima->riferimento7 = isset($request->riferimento7) ? 1 : 0;
        $anteprima->riferimento7_table1 = isset($request->riferimento7_table1) ? 1 : 0;
        $anteprima->riferimento7_table2 = isset($request->riferimento7_table2) ? 1 : 0;
        $anteprima->riferimento8 = (isset($request->riferimento8_indicazione1) || isset($request->riferimento8_indicazione2)) ? 1 : 0;
        $anteprima->riferimento8_indicazione1 = isset($request->riferimento8_indicazione1) ? 1 : 0;
        $anteprima->riferimento8_indicazione2 = isset($request->riferimento8_indicazione2) ? 1 : 0;
        $anteprima->riferimento8_indicazione3 = isset($request->riferimento8_indicazione3) ? 1 : 0;
        $anteprima->riferimento8_indicazione4 = isset($request->riferimento8_indicazione4) ? 1 : 0;
        $anteprima->riferimento8_portata = $riferimento8_portata;
        $anteprima->firmaDirettore = 0;
        $anteprima->firmaResponsabile = 0;
        $anteprima->committente = 0;

        $anteprima->save();

        //save note_campionamento associate ad anteprima
        for($i = 1; $i<=$request->numero_colonne; $i++)
        {
            $notaCampionamentoAnteprima = NotaCampionamentoRdpAnteprima::where('id_rdp_anteprima', $anteprima->id)->where('numero_colonna',$i)->first();
            if($notaCampionamentoAnteprima == null)
            {
                $notaCampionamentoAnteprima = new NotaCampionamentoRdpAnteprima;
                $notaCampionamentoAnteprima->id_rdp_anteprima = $anteprima->id;
                $notaCampionamentoAnteprima->id_rdp = $rapprel->id;
                $notaCampionamentoAnteprima->numero_colonna = $i;
            }
            //pagina 3 - 4
            $notaCampionamentoAnteprima->tipo_di_ambiente = $request["tipo_di_ambiente_$i"];
            $notaCampionamentoAnteprima->numero_e_codifica_locali = $request["numero_e_codifica_locali_$i"];
            $notaCampionamentoAnteprima->codice_partizione_stanza = $request["codice_partizione_stanza_$i"];
            $notaCampionamentoAnteprima->class_iso_di_riferimento = $request["class_iso_di_riferimento_$i"];
            $notaCampionamentoAnteprima->tipo_di_flusso = $request["tipo_di_flusso_$i"];
            $notaCampionamentoAnteprima->note_pagina3 = $request["note_pagina3_$i"];
            $notaCampionamentoAnteprima->stato_di_occupazione_aria_at_rest = $request["stato_di_occupazione_aria_at_rest_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_aria_at_rest_data = $request["data_di_campionamento_ora_inizio_e_fine_aria_at_rest_data_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraI = $request["data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraI_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraF = $request["data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraF_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_aria_operat_data = $request["data_di_campionamento_ora_inizio_e_fine_aria_operat_data_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_aria_operat_oraI = $request["data_di_campionamento_ora_inizio_e_fine_aria_operat_oraI_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_aria_operat_oraF = $request["data_di_campionamento_ora_inizio_e_fine_aria_operat_oraF_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_superfici_data = $request["data_di_campionamento_ora_inizio_e_fine_superfici_data_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_superfici_oraI = $request["data_di_campionamento_ora_inizio_e_fine_superfici_oraI_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_superfici_oraF = $request["data_di_campionamento_ora_inizio_e_fine_superfici_oraF_$i"];
            $notaCampionamentoAnteprima->n_persone_presenti_aria_at_rest = $request["n_persone_presenti_aria_at_rest_$i"];
            $notaCampionamentoAnteprima->stato_porte_aria_at_rest = $request["stato_porte_aria_at_rest_$i"];
            $notaCampionamentoAnteprima->campionamento_effettuato_da_aria_at_rest = $request["campionamento_effettuato_da_aria_at_rest_$i"];
            $notaCampionamentoAnteprima->note_pagina3_aria_at_rest = $request["note_pagina3_aria_at_rest_$i"];
            $notaCampionamentoAnteprima->stato_di_occupazione_aria_operat = $request["stato_di_occupazione_aria_operat_$i"];
            $notaCampionamentoAnteprima->strum_n_aria_at_rest1 = isset($request["strum_n_aria_at_rest_$i"][0]) ? $request["strum_n_aria_at_rest_$i"][0] : '';
            $notaCampionamentoAnteprima->strum_n_aria_at_rest2 = isset($request["strum_n_aria_at_rest_$i"][1]) ? $request["strum_n_aria_at_rest_$i"][1] : '';
            $notaCampionamentoAnteprima->strum_n_aria_at_rest3 = isset($request["strum_n_aria_at_rest_$i"][2]) ? $request["strum_n_aria_at_rest_$i"][2] : '';
            $notaCampionamentoAnteprima->strum_n_aria_operat1 = isset($request["strum_n_aria_operat_$i"][0]) ? $request["strum_n_aria_operat_$i"][0] : '';
            $notaCampionamentoAnteprima->strum_n_aria_operat2 = isset($request["strum_n_aria_operat_$i"][1]) ? $request["strum_n_aria_operat_$i"][1] : '';
            $notaCampionamentoAnteprima->strum_n_aria_operat3 = isset($request["strum_n_aria_operat_$i"][2]) ? $request["strum_n_aria_operat_$i"][2] : '';
            $notaCampionamentoAnteprima->n_persone_presenti_aria_operat = $request["n_persone_presenti_aria_operat_$i"];
            $notaCampionamentoAnteprima->stato_porte_aria_operat = $request["stato_porte_aria_operat_$i"];
            $notaCampionamentoAnteprima->tipo_di_operazione = $request["tipo_di_operazione_$i"];
            $notaCampionamentoAnteprima->campionamento_effettuato_da_aria_operat = $request["campionamento_effettuato_da_aria_operat_$i"];
            $notaCampionamentoAnteprima->note_pagina3_aria_operat = $request["note_pagina3_aria_operat_$i"];
            $notaCampionamentoAnteprima->stato_di_occupazione_superfici = $request["stato_di_occupazione_superfici_$i"];
            $notaCampionamentoAnteprima->n_persone_presenti_superfici = $request["n_persone_presenti_superfici_$i"];
            $notaCampionamentoAnteprima->stato_porte_superfici = $request["stato_porte_superfici_$i"];
            $notaCampionamentoAnteprima->campionamento_effettuato_da_superfici = $request["campionamento_effettuato_da_superfici_$i"];
            $notaCampionamentoAnteprima->note_pagina3_superfici = $request["note_pagina3_superfici_$i"];

            // Log::info($request["tipo_di_ambiente_$i"]);
            // Log::info($request["numero_e_codifica_locali_$i"]);
            // Log::info($request["codice_partizione_stanza_$i"]);
            // Log::info($request["class_iso_di_riferimento_$i"]);
            // Log::info($request["tipo_di_flusso_$i"]);
            // Log::info($request["note_pagina3_$i"]);
            // Log::info($request["stato_di_occupazione_aria_at_rest_$i"]);
            // Log::info($request["data_di_campionamento_ora_inizio_e_fine_aria_at_rest_data_$i"]);
            // Log::info($request["data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraI_$i"]);
            // Log::info($request["data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraF_$i"]);
            // Log::info($request["data_di_campionamento_ora_inizio_e_fine_aria_operat_data_$i"]);
            // Log::info($request["data_di_campionamento_ora_inizio_e_fine_aria_operat_oraI_$i"]);
            // Log::info($request["data_di_campionamento_ora_inizio_e_fine_aria_operat_oraF_$i"]);
            // Log::info($request["data_di_campionamento_ora_inizio_e_fine_superfici_data_$i"]);
            // Log::info($request["data_di_campionamento_ora_inizio_e_fine_superfici_oraI_$i"]);
            // Log::info($request["data_di_campionamento_ora_inizio_e_fine_superfici_oraF_$i"]);
            // Log::info($request["n_persone_presenti_aria_at_rest_$i"]);
            // Log::info($request["stato_porte_aria_at_rest_$i"]);
            // Log::info($request["campionamento_effettuato_da_aria_at_rest_$i"]);
            // Log::info($request["note_pagina3_aria_at_rest_$i"]);
            // Log::info($request["stato_di_occupazione_aria_operat_$i"]);
            // Log::info($request["n_persone_presenti_aria_operat_$i"]);
            // Log::info($request["stato_porte_aria_operat_$i"]);
            // Log::info($request["tipo_di_operazione_$i"]);
            // Log::info($request["campionamento_effettuato_da_aria_operat_$i"]);
            // Log::info($request["note_pagina3_aria_operat_$i"]);
            // Log::info($request["stato_di_occupazione_superfici_$i"]);
            // Log::info($request["n_persone_presenti_superfici_$i"]);
            // Log::info($request["stato_porte_superfici_$i"]);
            // Log::info($request["campionamento_effettuato_da_superfici_$i"]);
            // Log::info($request["note_pagina3_superfici_$i"]);
            

            $notaCampionamentoAnteprima->save();
        }

        //save planimetrie e caption all'anteprima
        $image = $request->file('planimetria');
        if($image != null)
        {
            $counter = 1;
            $trovato = False; // per gestire il caso in cui ho una sola immagine con nome planimetria_0.jpg
            if(count(PlanimetriaRdpAnteprima::where('id_rdp',$rapprel->id)->get()) > 0)
            {
                $trovato = True;
                $numero = count(PlanimetriaRdpAnteprima::where('id_rdp',$rapprel->id)->get()) - 1;
            }
            foreach($image as $key => $value){
                if($numero == 0 && $trovato == False)
                {
                    $imageName = "planimetria_$key.jpg";
                }
                else
                {
                    $numero = $numero + 1;
                    $imageName = "planimetria_$numero.jpg";
                }
                $imageName = "planimetria_$numero.jpg";
                if(PlanimetriaRdpAnteprima::where('id_rdp',$rapprel->id)->where('id_rdp_anteprima',$anteprima->id)->where('planimetria',storage_path() . "/app/public/planimetrie/$rapprel->id/" . $imageName)->where('caption',$request["caption_$counter"])->first() == null)
                {   
                    $planimetrieAnteprima = new PlanimetriaRdpAnteprima();
                    $planimetrieAnteprima->id_rdp = $rapprel->id;
                    $planimetrieAnteprima->id_rdp_anteprima = $anteprima->id;
                    $planimetrieAnteprima->planimetria = storage_path() . "/app/public/planimetrie/$rapprel->id/" . $imageName;
                    $planimetrieAnteprima->caption = $request["caption_".$counter];
                    $planimetrieAnteprima->save();
                }
                else
                {
                    $planimetrieAnteprima = PlanimetriaRdpAnteprima::where('id_rdp',$rapprel->id)->where('id_rdp_anteprima',$anteprima->id)->where('planimetria',storage_path() . "/app/public/planimetrie/$rapprel->id/" . $imageName)->where('caption',$request["caption_$counter"])->first();
                    $planimetrieAnteprima->id_rdp = $rapprel->id;
                    $planimetrieAnteprima->id_rdp_anteprima = $anteprima->id;
                    $planimetrieAnteprima->planimetria = storage_path() . "/app/public/planimetrie/$rapprel->id/" . $imageName;
                    $planimetrieAnteprima->caption = isset($request['caption_planimetria_salvata_'.$anteprima->id]) ? $request['caption_planimetria_salvata_'.$anteprima->id] : $anteprima->caption;
                    $planimetrieAnteprima->save();
                }
                $counter++;
            }
        }
        else //caso in cui non aggiungo altre foto (considero la modifica della caption)
        {
            foreach ($caption_modificate as $id => $value) {
                $planimetria = PlanimetriaRdpAnteprima::find($id);
                $planimetria->caption = $value;
                $planimetria->save();
            }
            
        }

        //save descrizione anteprima
        if($tipi_di_campioni['_pca_at_rest_attivo'] != 0)
        {
            foreach($campioni_analizzati_con_piastra_aria as $tipo_campione => $value)
            {
                if($tipo_campione == '_pca_at_rest_attivo')
                {
                    foreach ($value as $item) 
                    {
                        $descrizioneAnteprima = new DescrizioneCampionamentoRdpAnteprima();
                        $descrizioneAnteprima->id_rdp = $rapprel->id;
                        $descrizioneAnteprima->id_rdp_anteprima = $anteprima->id;
                        $descrizioneAnteprima->aria = 1;
                        $descrizioneAnteprima->pca = 1;
                        $descrizioneAnteprima->at_rest = 1;
                        $descrizioneAnteprima->attivo = 1;
                        $descrizioneAnteprima->valori_riferimento = $item['valori_riferimento'];
                        $descrizioneAnteprima->id_campione = $item['id_campione'];
                        $descrizioneAnteprima->save();
                    }
                }
            }       
        }

        if($tipi_di_campioni['_pca_at_rest_passivo'] != 0)
        {
            foreach($campioni_analizzati_con_piastra_aria as $tipo_campione => $value)
            {
                if($tipo_campione == '_pca_at_rest_passivo')
                {
                    foreach ($value as $item) 
                    {
                        $descrizioneAnteprima = new DescrizioneCampionamentoRdpAnteprima();
                        $descrizioneAnteprima->id_rdp = $rapprel->id;
                        $descrizioneAnteprima->id_rdp_anteprima = $anteprima->id;
                        $descrizioneAnteprima->aria = 1;
                        $descrizioneAnteprima->pca = 1;
                        $descrizioneAnteprima->at_rest = 1;
                        $descrizioneAnteprima->passivo = 1;
                        $descrizioneAnteprima->id_campione = $item['id_campione'];
                        $descrizioneAnteprima->save();
                    }
                }
            }  
        }

        if($tipi_di_campioni['_pca_operat_attivo'] != 0)
        {
            foreach ($campioni_stanze_pca_attivo as $stanza => $lista_campioni_stanza) {
                foreach($lista_campioni_stanza as $value)
                {
                    $descrizioneAnteprima = new DescrizioneCampionamentoRdpAnteprima();
                    $descrizioneAnteprima->id_rdp = $rapprel->id;
                    $descrizioneAnteprima->id_rdp_anteprima = $anteprima->id;
                    $descrizioneAnteprima->aria = 1;
                    $descrizioneAnteprima->pca = 1;
                    $descrizioneAnteprima->operat = 1;
                    $descrizioneAnteprima->attivo = 1;
                    $descrizioneAnteprima->stanza = $stanza;
                    $descrizioneAnteprima->valori_riferimento = $value['valori_riferimento'];
                    $descrizioneAnteprima->id_campione = $value['id_campione'];
                    $descrizioneAnteprima->save();
                }
            }
        }

        if($tipi_di_campioni['_pca_operat_passivo'] != 0)
        {
            foreach ($campioni_stanze_pca_passivo as $stanza => $lista_campioni_stanza) {
                foreach($lista_campioni_stanza as $value)
                {
                    $descrizioneAnteprima = new DescrizioneCampionamentoRdpAnteprima();
                    $descrizioneAnteprima->id_rdp = $rapprel->id;
                    $descrizioneAnteprima->id_rdp_anteprima = $anteprima->id;
                    $descrizioneAnteprima->aria = 1;
                    $descrizioneAnteprima->pca = 1;
                    $descrizioneAnteprima->operat = 1;
                    $descrizioneAnteprima->passivo = 1;
                    $descrizioneAnteprima->stanza = $stanza;
                    $descrizioneAnteprima->valori_riferimento = $value['valori_riferimento'];
                    $descrizioneAnteprima->id_campione = $value['id_campione'];
                    $descrizioneAnteprima->save();
                }
            }
        }

        if($tipi_di_campioni['_dg18_at_rest_attivo'] != 0)
        {
            foreach($campioni_analizzati_con_piastra_aria as $tipo_campione => $value)
            {
                if($tipo_campione == '_dg18_at_rest_attivo')
                {
                    foreach ($value as $item) 
                    {
                        $descrizioneAnteprima = new DescrizioneCampionamentoRdpAnteprima();
                        $descrizioneAnteprima->id_rdp = $rapprel->id;
                        $descrizioneAnteprima->id_rdp_anteprima = $anteprima->id;
                        $descrizioneAnteprima->aria = 1;
                        $descrizioneAnteprima->dg18 = 1;
                        $descrizioneAnteprima->at_rest = 1;
                        $descrizioneAnteprima->attivo = 1;
                        $descrizioneAnteprima->id_campione = $item['id_campione'];
                        $descrizioneAnteprima->save();
                    }
                }
            }   
        }

        if($tipi_di_campioni['_dg18_at_rest_passivo'] != 0)
        {
            foreach($campioni_analizzati_con_piastra_aria as $tipo_campione => $value)
            {
                if($tipo_campione == '_dg18_at_rest_passivo')
                {
                    foreach ($value as $item) 
                    {
                        $descrizioneAnteprima = new DescrizioneCampionamentoRdpAnteprima();
                        $descrizioneAnteprima->id_rdp = $rapprel->id;
                        $descrizioneAnteprima->id_rdp_anteprima = $anteprima->id;
                        $descrizioneAnteprima->aria = 1;
                        $descrizioneAnteprima->dg18 = 1;
                        $descrizioneAnteprima->at_rest = 1;
                        $descrizioneAnteprima->passivo = 1;
                        $descrizioneAnteprima->id_campione = $item['id_campione'];
                        $descrizioneAnteprima->save();
                    }
                }
            }   
        }

        if(count($tipi_piastre_superficie) > 0)
        {
            foreach ($tipi_piastre_superficie as $id_piastra => $piastra) 
            {
                foreach($campioni_analizzati_con_piastra_superficie as $nome_piastra => $campioni)
                {
                    if($piastra == $nome_piastra)
                    {
                        foreach ($campioni as $c)
                        {
                            if(DescrizioneCampionamentoRdpAnteprima::where('id_rdp',$rapprel->id)->where('id_rdp_anteprima',$anteprima->id)->where('id_campione',$c['id_campione'])->first() == null)
                            {
                                $descrizioneAnteprima = new DescrizioneCampionamentoRdpAnteprima();
                                $descrizioneAnteprima->id_rdp = $rapprel->id;
                                $descrizioneAnteprima->id_rdp_anteprima = $anteprima->id;
                                $descrizioneAnteprima->id_campione = $c['id_campione'];
                                $descrizioneAnteprima->superficie = 1;
                                $descrizioneAnteprima->pca = $id_piastra == 26 ? 1 : 0;
                                $descrizioneAnteprima->dg18 = $id_piastra == 27 ? 1 : 0;
                                $descrizioneAnteprima->at_rest = 1;
                            }
                            else
                            {
                                $descrizioneAnteprima = DescrizioneCampionamentoRdpAnteprima::where('id_rdp',$rapprel->id)->where('id_rdp_anteprima',$anteprima->id)->where('id_campione',$c['id_campione'])->first();
                            }
                            $descrizioneAnteprima->valori_riferimento = $c['valori_riferimento'];
                            $descrizioneAnteprima->save();
                        }
                    }
                }
            }
        }


        // Log::info(auth()->user()->id);
        LoggerEvent::log(auth()->user()->id,"Rapporto di prova generato", ['id_utente' => auth()->user()->id], true, null, $rapprel->id);
        
        //return $pdf->download($fileName);
        return $pdf->stream();

    }

    /**
    * Cerca tutti gli elementi per la creazione del documento rapporto di prova (committente)
    */
    public function createDocumento_committente(Request $request)
    {
        $id_rapprel = null;

        if(isset($request->id_rdp))
        {
            $id_rapprel = $request->id_rdp;
        }

        if($request->id_societa == 'tutti')
        {
            $text = "Inserire un cliente valido.";
            return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
        }

        if($request->id_progetto == 'tutti')
        {
            $text = "Inserire un progetto valido.";
            return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
        }

        if($request->id_struttura == 'tutti')
        {
            $text = "Inserire una struttura valida.";
            return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
        }

        if($request->id_reparto == 'tutti')
        {
            $text = "Inserire una partizione valida.";
            return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
        }

        if($request->data_campagna == '')
        {
            $text = "Inserire una data valida.";
            return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
        }


        //verifico inizialmente se esiste una campagna per i dati selezionati
        $campagna = Campagna::where('id_societa',$request->id_societa)
                            ->where('id_progetto',$request->id_progetto)
                            ->where('id_struttura',$request->id_struttura)
                            ->where('dataCampagna',$request->data_campagna)
                            ->first();

        //Log::info($campagna);
        
        if($campagna == null)
        {
            $text = 'Errore, non esiste una campagna per i dati selezionati';
            return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
        }

        //verifico se esiste una tupla struttura-progetto-partizione-areapartizione nella tabella strutture_reparti
        //Questo perchè senza questa tupla nella tabella non è stato possibile inserire delle schede e dunque non c'è materiale per generare un rapporto
        $area_partizione = $request->areapartizione;
        $areapartizione = "";
        if($area_partizione == 'tutti' || $area_partizione == null)
        {
            $areapartizione = AreaPartizione::where('id_reparto',$request->id_reparto)->where('area_partizione',null)->first();
            if($areapartizione == null)
            {
                $text = 'Errore, non esiste una partizione per i dati selezionati';
                return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
            }
        }
        else
        {
            $areapartizione = AreaPartizione::find($area_partizione);
            if($areapartizione == null)
            {
                $text = 'Errore, non esiste una partizione per i dati selezionati';
                return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
            }
        }
        $StruttRep = StruttRep::where('id_progetto',$request->id_progetto)
                                ->where('id_struttura',$request->id_struttura)
                                ->where('id_reparto',$request->id_reparto)
                                ->where('id_associazione',$areapartizione->id)
                                ->first();

        if($StruttRep == null)
        {
            $text = 'Errore, risulta che presso la partizione selezionata non vi sono campionamenti';
            return redirect('/rapprel/uploadRapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
        }

        /************************************************************************************************
         * CALCOLO DATI PER ANTEPRIMA RAPPORTO
         */
        $campioni_aria_pca_at_rest_attivo = Campione::where('id_campagna',$campagna->id)
                                                        ->where('id_progetto',$request->id_progetto)
                                                        ->where('id_struttura',$request->id_struttura)
                                                        ->where('id_areareparto',$areapartizione->id)
                                                        ->where('tipoScheda',0)
                                                        ->where('tipoCamp','A')
                                                        ->where('id_tipo_piastra',26)
                                                        ->where('operat','R')
                                                        ->where('tipoCampione','attivo')
                                                        ->get();
    


        $campioni_aria_pca_at_rest_passivo = Campione::where('id_campagna',$campagna->id)
                                                        ->where('id_progetto',$request->id_progetto)
                                                        ->where('id_struttura',$request->id_struttura)
                                                        ->where('id_areareparto',$areapartizione->id)
                                                        ->where('tipoScheda',0)
                                                        ->where('tipoCamp','A')
                                                        ->where('id_tipo_piastra',26)
                                                        ->where('operat','R')
                                                        ->where('tipoCampione','passivo')
                                                        ->get();
        #########################

        $campioni_aria_dg18_at_rest_attivo = Campione::where('id_campagna',$campagna->id)
                                                        ->where('id_progetto',$request->id_progetto)
                                                        ->where('id_struttura',$request->id_struttura)
                                                        ->where('id_areareparto',$areapartizione->id)
                                                        ->where('tipoScheda',0)
                                                        ->where('tipoCamp','A')
                                                        ->where('id_tipo_piastra',27)
                                                        ->where('operat','R')
                                                        ->where('tipoCampione','attivo')
                                                        ->get();

        $campioni_aria_dg18_at_rest_passivo = Campione::where('id_campagna',$campagna->id)
                                                        ->where('id_progetto',$request->id_progetto)
                                                        ->where('id_struttura',$request->id_struttura)
                                                        ->where('id_areareparto',$areapartizione->id)
                                                        ->where('tipoScheda',0)
                                                        ->where('tipoCamp','A')
                                                        ->where('id_tipo_piastra',27)
                                                        ->where('operat','R')
                                                        ->where('tipoCampione','passivo')
                                                        ->get();

        ######################

        /**QUESTI DEVONO POI ESSERE RAGGRUPPATI PER STANZE */
        $campioni_aria_pca_operat_attivo = Campione::where('id_campagna',$campagna->id)
                                                        ->where('id_progetto',$request->id_progetto)
                                                        ->where('id_struttura',$request->id_struttura)
                                                        ->where('id_areareparto',$areapartizione->id)
                                                        ->where('tipoScheda',0)
                                                        ->where('id_tipo_piastra',26)
                                                        ->where('tipoCamp','A')
                                                        ->where('operat','O')
                                                        ->where('tipoCampione','attivo')
                                                        ->get();

        $campioni_aria_pca_operat_passivo = Campione::where('id_campagna',$campagna->id)
                                                        ->where('id_progetto',$request->id_progetto)
                                                        ->where('id_struttura',$request->id_struttura)
                                                        ->where('id_areareparto',$areapartizione->id)
                                                        ->where('tipoScheda',0)
                                                        ->where('tipoCamp','A')
                                                        ->where('id_tipo_piastra',26)
                                                        ->where('operat','O')
                                                        ->where('tipoCampione','passivo')
                                                        ->get();

        /**PCA OPERAT ATTIVO RAGGRUPPAMENTO PER STANZE*/
        $stanze = [];
        // per ogni campione, vedo quali sono le stanze e le salvo nell'array stanze.
        foreach($campioni_aria_pca_operat_attivo as $c)
        {
            array_push($stanze, $c->numStanza);
        }
        //elimino i duplicati
        $stanze = array_unique($stanze);

        $pca_attivo_stanze = []; // trovate le stanze creo un array associativo in modo da associare ad ogni stanza un array vuoto.
        foreach($stanze  as $key => $s)
        {
            $pca_attivo_stanze[$s] = [];
        }
        
        // rieffettuo uno scorrimento di tutti i campioni di quella piastra con metodo O in modo da assegnare ad ogni stanza il suo campione
        // nell'array associativo, che prima era vuoto, e ora lo vado a riempire man mano.
        //alla fine ottengo un array formate da chiavi (stanze) e valori (array di campioni)
        // per ogni campione, vedo quali sono le stanze e le salvo nell'array stanze.
        foreach($campioni_aria_pca_operat_attivo as $c)
        {
            foreach ($pca_attivo_stanze as $key => $value) 
            {
                if($c->numStanza == $key)
                {
                    array_push($pca_attivo_stanze[$key], $c->toArray());
                }
            }
        }

        /**PCA OPERAT PASSIVO RAGGRUPPAMENTO PER STANZE*/
        $stanze = [];
        // per ogni campione, vedo quali sono le stanze e le salvo nell'array stanze.
        foreach($campioni_aria_pca_operat_passivo as $c)
        {
            array_push($stanze, $c->numStanza);
        }
        //elimino i duplicati
        $stanze = array_unique($stanze);

        $pca_passivo_stanze = []; // trovate le stanze creo un array associativo in modo da associare ad ogni stanza un array vuoto.
        foreach($stanze  as $key => $s)
        {
            $pca_passivo_stanze[$s] = [];
        }
        
        // rieffettuo uno scorrimento di tutti i campioni di quella piastra con metodo O in modo da assegnare ad ogni stanza il suo campione
        // nell'array associativo, che prima era vuoto, e ora lo vado a riempire man mano.
        //alla fine ottengo un array formate da chiavi (stanze) e valori (array di campioni)
        // per ogni campione, vedo quali sono le stanze e le salvo nell'array stanze.
        foreach($campioni_aria_pca_operat_passivo as $c)
        {
            foreach ($pca_passivo_stanze as $key => $value) 
            {
                if($c->numStanza == $key)
                {
                    array_push($pca_passivo_stanze[$key], $c->toArray());
                }
            }
        }

        /************************************************************************************************************+++ */

         /** PREPARAZIONE CAMPIONI CON SPECIAZIONE */

         $campioni_speciazione_pca_aria = SpeciazioneCampione::join('campioni','speciazioni_campioni.id_campione','=','campioni.id')
                ->join('microrganismi_piastre','speciazioni_campioni.id_microrganismo','=','microrganismi_piastre.id')
                ->join('tipi_piastre','speciazioni_campioni.id_tipopiastra','=','tipi_piastre.id')
                ->join('punti_campionamento', 'punti_campionamento.id','=','speciazioni_campioni.id_punto_camp')
                ->where('campioni.id_campagna',$campagna->id)
                ->where('campioni.tipoCamp','A')
                ->where('campioni.id_tipo_piastra',26)
                ->select('campioni.id as id_campione',
                        'campioni.codiceCIAS as codice_campione',
                        'punti_campionamento.punto_campionamento as punto_campionamento',
                        'speciazioni_campioni.esito as risultato',
                        'microrganismi_piastre.microrganismo as microrganismo_ricercato',
                        'campioni.dataAnalisi as dataInizioProva',
                        'campioni.dataFineAnalisi as dataFineProva',
                        'campioni.tecnico as tecnico',
                        'tipi_piastre.abbreviazione as tipo_terreno')->get();
         

        $campioni_speciazione_pca_superficie = SpeciazioneCampione::join('campioni','speciazioni_campioni.id_campione','=','campioni.id')
                ->join('microrganismi_piastre','speciazioni_campioni.id_microrganismo','=','microrganismi_piastre.id')
                ->join('tipi_piastre','speciazioni_campioni.id_tipopiastra','=','tipi_piastre.id')
                ->join('punti_campionamento', 'punti_campionamento.id','=','speciazioni_campioni.id_punto_camp')
                ->where('campioni.id_campagna',$campagna->id)
                ->where('campioni.tipoCamp','S')
                ->where('campioni.id_tipo_piastra',26)
                ->select('campioni.id as id_campione',
                        'campioni.codiceCIAS as codice_campione',
                        'punti_campionamento.punto_campionamento as punto_campionamento',
                        'speciazioni_campioni.esito as risultato',
                        'microrganismi_piastre.microrganismo as microrganismo_ricercato',
                        'campioni.dataAnalisi as dataInizioProva',
                        'campioni.dataFineAnalisi as dataFineProva',
                        'campioni.tecnico as tecnico',
                        'tipi_piastre.abbreviazione as tipo_terreno')->get();

        $campioni_speciazione_dg18_aria = SpeciazioneCampione::join('campioni','speciazioni_campioni.id_campione','=','campioni.id')
                ->join('microrganismi_piastre','speciazioni_campioni.id_microrganismo','=','microrganismi_piastre.id')
                ->join('tipi_piastre','speciazioni_campioni.id_tipopiastra','=','tipi_piastre.id')
                ->join('punti_campionamento', 'punti_campionamento.id','=','speciazioni_campioni.id_punto_camp')
                ->where('campioni.id_campagna',$campagna->id)
                ->where('campioni.tipoCamp','A')
                ->where('campioni.id_tipo_piastra',27)
                ->select('campioni.id as id_campione',
                        'campioni.codiceCIAS as codice_campione',
                        'punti_campionamento.punto_campionamento as punto_campionamento',
                        'speciazioni_campioni.esito as risultato',
                        'microrganismi_piastre.microrganismo as microrganismo_ricercato',
                        'campioni.dataAnalisi as dataInizioProva',
                        'campioni.dataFineAnalisi as dataFineProva',
                        'campioni.tecnico as tecnico',
                        'tipi_piastre.abbreviazione as tipo_terreno')->get();

        $campioni_speciazione_dg18_superficie = SpeciazioneCampione::join('campioni','speciazioni_campioni.id_campione','=','campioni.id')
                ->join('microrganismi_piastre','speciazioni_campioni.id_microrganismo','=','microrganismi_piastre.id')
                ->join('tipi_piastre','speciazioni_campioni.id_tipopiastra','=','tipi_piastre.id')
                ->join('punti_campionamento', 'punti_campionamento.id','=','speciazioni_campioni.id_punto_camp')
                ->where('campioni.id_campagna',$campagna->id)
                ->where('campioni.tipoCamp','S')
                ->where('campioni.id_tipo_piastra',27)
                ->select('campioni.id as id_campione',
                        'campioni.codiceCIAS as codice_campione',
                        'punti_campionamento.punto_campionamento as punto_campionamento',
                        'speciazioni_campioni.esito as risultato',
                        'microrganismi_piastre.microrganismo as microrganismo_ricercato',
                        'campioni.dataAnalisi as dataInizioProva',
                        'campioni.dataFineAnalisi as dataFineProva',
                        'campioni.tecnico as tecnico',
                        'tipi_piastre.abbreviazione as tipo_terreno')->get();
        
        $societa = Societa::all();
        $societa_documento = Societa::find($request->id_societa);
        $progetto = Progetto::find($request->id_progetto);
        $struttura = Struttura::find($request->id_struttura);
        $partizione = Reparto::find($request->id_reparto);
        $view_documento_committente = 1;

        $campioni = Campione::where('id_campagna',$campagna->id)->where('id_progetto',$request->id_progetto)->where('id_struttura',$request->id_struttura)->where('id_areareparto',$areapartizione->id)->where('tipoScheda',0)->get();

        $rapprel_esistente = RapportoRelazione::where('id_progetto',$request->id_progetto)->where('ospedale',$request->id_struttura)->where('id_reparto',$request->id_reparto)->where('id_areapartizione',$areapartizione->id)->where('dataCampagna',$request->data_campagna)->where('committente',1)->where('versione',2)->first();

        if($rapprel_esistente == null)
        {
            $rapprel = new RapportoRelazione;
            $rapprel->tipo = 'A';
            $rapprel->id_progetto = $request->id_progetto;
            $rapprel->ospedale = $request->id_struttura;
            $rapprel->id_reparto = $request->id_reparto;
            $rapprel->id_areapartizione = $areapartizione->id;
            $rapprel->dataCampagna = $request->data_campagna;
            $rapprel->file = "";
            $rapprel->committente = 1;
            $rapprel->rev = 0;
            $rapprel->id_utente_genera_rapporto = auth()->user()->id;
            $rapprel->versione = 2;
            $rapprel->save();

            foreach($campioni as $c)
            {
                $rapprel_campioni = new RappRelCampioni;
                $rapprel_campioni->id_rapprel = $rapprel->id;
                $rapprel_campioni->id_campione = $c->id;
                $rapprel_campioni->save();
            }

            $id_rapprel = $rapprel->id;
            LoggerEvent::log(auth()->user()->id,"Creato nuovo rapporto di prova",$request->all(),false,null, $id_rapprel); 
        }
        else
        {
            $id_rapprel = $rapprel_esistente->id;
        }

        $lg = [];
        $lineeguida = [
            '1' => 'ISPESL 2003',
            '2' => 'ISPESL 2009',
            '3' => 'GMP 2008',
            '4' => 'Standart IMQ'
        ];
        foreach ($campioni as $campione) {
            for($i=1; $i<=4; $i++)
            {
                if($campione["lineeGuida$i"] != 0)
                {
                    array_push($lg,$lineeguida[$i]);
                }
            }
        }

        $lg = array_unique($lg);

        $lineeguida_testo = "";
        foreach ($lg as $key => $value) {
            $lineeguida_testo .= $value.", ";
        }
        $lineeguida_testo = substr($lineeguida_testo, 0, -2);

        $progetti = Progetto::where('versione',2)->get(); // serve solo per le due sezioni di upload.
        $view_documento = 0;
        
        $rdp_anteprima = RdpAnteprima::where('id_rapprel',$id_rapprel)->where('committente',1)->first();
        if($rdp_anteprima != null)
        {
            $anteprima = 1;
            $rdp_anteprima_descrizione = DescrizioneCampionamentoRdpAnteprima::where('id_rdp_anteprima',$rdp_anteprima->id)->get(); 
            if(count($rdp_anteprima_descrizione) > 0)
            {
                return view('relazioni_e_rapporti.gestisci_anteprima_rdp',compact('id_rapprel','campioni','progetti','societa','campagna','societa_documento','progetto','struttura','partizione','areapartizione','view_documento','view_documento_committente','lineeguida_testo','campioni_aria_pca_at_rest_attivo','campioni_aria_pca_at_rest_passivo','campioni_aria_dg18_at_rest_attivo','campioni_aria_dg18_at_rest_passivo','campioni_aria_pca_operat_attivo','campioni_aria_pca_operat_passivo','pca_attivo_stanze','pca_passivo_stanze','campioni_speciazione_pca_superficie','campioni_speciazione_dg18_superficie','campioni_speciazione_dg18_aria','campioni_speciazione_pca_aria','anteprima','rdp_anteprima','rdp_anteprima_descrizione'));
            }
            else
            {
                return view('relazioni_e_rapporti.gestisci_anteprima_rdp',compact('id_rapprel','campioni','progetti','societa','campagna','societa_documento','progetto','struttura','partizione','areapartizione','view_documento','view_documento_committente','lineeguida_testo','campioni_aria_pca_at_rest_attivo','campioni_aria_pca_at_rest_passivo','campioni_aria_dg18_at_rest_attivo','campioni_aria_dg18_at_rest_passivo','campioni_aria_pca_operat_attivo','campioni_aria_pca_operat_passivo','pca_attivo_stanze','pca_passivo_stanze','campioni_speciazione_pca_superficie','campioni_speciazione_dg18_superficie','campioni_speciazione_dg18_aria','campioni_speciazione_pca_aria','anteprima','rdp_anteprima'));
            }
        }
        else
        {
            $anteprima = 1;
            return view('relazioni_e_rapporti.gestisci_anteprima_rdp',compact('id_rapprel','campioni','progetti','societa','campagna','societa_documento','progetto','struttura','partizione','areapartizione','view_documento','view_documento_committente','lineeguida_testo','campioni_aria_pca_at_rest_attivo','campioni_aria_pca_at_rest_passivo','campioni_aria_dg18_at_rest_attivo','campioni_aria_dg18_at_rest_passivo','campioni_aria_pca_operat_attivo','campioni_aria_pca_operat_passivo','pca_attivo_stanze','pca_passivo_stanze','campioni_speciazione_pca_superficie','campioni_speciazione_dg18_superficie','campioni_speciazione_dg18_aria','campioni_speciazione_pca_aria','anteprima'));
        }
    }

    /**
     * Genera il pdf relativo al rapporto di prova (committente)
     */
    public function generaPDF_committente(Request $request)
    {
        // Log::info($request);

        $rapprel = RapportoRelazione::find($request->id_rdp);
        if($rapprel == null)
        {
            $text = 'Errore, non esiste un rapporto per i dati selezionati';
            return redirect('/genera_rapporto')
                        ->withErrors($text)
                        ->withInput($request->toArray());
        }

        $campioni = json_decode($request->campioni);
        $campagna = Campagna::find($request->campagna);

        /**Pagina 1 */
        $nome_cliente = $request->cliente_nome;
        $indirizzo_cliente = $request->cliente_indirizzo;
        $struttura_partizione = $request->struttura_partizione;
        $indirizzo_struttura = $request->indirizzo_struttura;
        $struttura_sede = $request->struttura_sede;
        $modulo_di_accettazione = $request->modulo_di_accettazione;
        $num_rdp = $request->num_rdp;

        /**Pagina 2 */
        $incaricati_del_campionamento = $request->incaricati_campionamento;
        $data_campionamento_inizio = Carbon::parse($request->data_campionamento_inizio)->format('d/m/Y');
        $data_campionamento_fine = Carbon::parse($request->data_campionamento_fine)->format('d/m/Y');
        $ora_inizio = Carbon::parse($request->ora_inizio)->format('H:i');
        $ora_fine = Carbon::parse($request->ora_fine)->format('H:i');
        $data_inizio = Carbon::parse($request->data_inizio)->format('d/m/Y');
        $data_fine = Carbon::parse($request->data_fine)->format('d/m/Y');
        $elenco_campioni = [];

        $note = $request->note;

        for($i=1;$i<=$request->num_campioni_elenco;$i++)
        {
            array_push($elenco_campioni,["codiceCIAS" => $request->input("codiceCIAS_$i"), "terreno_fornitore" => $request->input("terreno_fornitore_$i"), "lotto" => $request->input("lotto_$i"), "scadenza" => $request->input("scadenza_$i")]);
        }
       

        $tipo_di_ambiente = [];
        $numero_e_codifica_locali = [];
        $codice_partizione_stanza = [];
        $class_iso_di_riferimento = [];
        $tipo_di_flusso = [];
        $note_pagina3 = [];
        $stato_di_occupazione_aria_at_rest = [];
        $n_persone_presenti_aria_at_rest = [];
        $stato_porte_aria_at_rest = [];
        $campionamento_effettuato_da_aria_at_rest = [];
        $note_pagina3_aria_at_rest = [];
        $stato_di_occupazione_aria_operat = [];
        $n_persone_presenti_aria_operat = [];
        $stato_porte_aria_operat= [];
        $campionamento_effettuato_da_aria_operat = [];
        $note_pagina3_aria_operat = [];
        $stato_di_occupazione_superfici = [];
        $n_persone_presenti_superfici = [];
        $stato_porte_superfici = [];
        $campionamento_effettuato_da_superfici = [];
        $note_pagina3_superfici = [];
        $tipo_di_operazione = [];

        for($i = 1; $i<=$request->numero_colonne; $i++)
        {
            $tipo_di_ambiente[$i] = $request["tipo_di_ambiente_$i"];
            $numero_e_codifica_locali[$i] = $request["numero_e_codifica_locali_$i"];
            $codice_partizione_stanza[$numero_e_codifica_locali[$i]] = $request["codice_partizione_stanza_$i"];
            $class_iso_di_riferimento[$i] = $request["class_iso_di_riferimento_$i"];
            $tipo_di_flusso[$i] = $request["tipo_di_flusso_$i"];
            $note_pagina3[$i] = $request["note_pagina3_$i"];
            $stato_di_occupazione_aria_at_rest[$i] = $request["stato_di_occupazione_aria_at_rest_$i"];
            $n_persone_presenti_aria_at_rest[$i] = $request["n_persone_presenti_aria_at_rest_$i"];
            $stato_porte_aria_at_rest[$i] = $request["stato_porte_aria_at_rest_$i"];
            $campionamento_effettuato_da_aria_at_rest[$i] = $request["campionamento_effettuato_da_aria_at_rest_$i"];
            $note_pagina3_aria_at_rest[$i] = $request["note_pagina3_aria_at_rest_$i"];
            $stato_di_occupazione_aria_operat[$i] = $request["stato_di_occupazione_aria_operat_$i"];
            $n_persone_presenti_aria_operat[$i] = $request["n_persone_presenti_aria_operat_$i"];
            $stato_porte_aria_operat[$i] = $request["stato_porte_aria_operat_$i"];
            $campionamento_effettuato_da_aria_operat[$i] = $request["campionamento_effettuato_da_aria_operat_$i"];
            $note_pagina3_aria_operat[$i] = $request["note_pagina3_aria_operat_$i"];
            $stato_di_occupazione_superfici[$i] = $request["stato_di_occupazione_superfici_$i"];
            $n_persone_presenti_superfici[$i] = $request["n_persone_presenti_superfici_$i"];
            $stato_porte_superfici[$i] = $request["stato_porte_superfici_$i"];
            $campionamento_effettuato_da_superfici[$i] = $request["campionamento_effettuato_da_superfici_$i"];
            $note_pagina3_superfici[$i] = $request["note_pagina3_superfici_$i"];
            $tipo_di_operazione[$i] = $request["tipo_di_operazione_$i"]; 
        }
        
        #PAGINA 5 - upload planimetrie
        $planimetria = [];
        $caption = [];
        $image = $request->file('planimetria');
        $caption_modificate = [];
        if($image != null)
        {
            $counter = 1;
            $counter_anteprima = 0;
            $numero = 0;
            $trovato = False; // per gestire il caso in cui ho una sola immagine con nome planimetria_0.jpg
            if(count(PlanimetriaRdpAnteprima::where('id_rdp',$rapprel->id)->get()) > 0)
            {
                $trovato = True;
                $numero = count(PlanimetriaRdpAnteprima::where('id_rdp',$rapprel->id)->get()) - 1;
            }
            foreach($image as $key => $value){
                if($numero == 0 && $trovato == False)
                {
                    $imageName = "planimetria_$key.jpg";
                }
                else
                {
                    $numero = $numero + 1;
                    $imageName = "planimetria_$numero.jpg";
                }
                $value->move(Storage::disk('public')->path("planimetrie/$rapprel->id"), $imageName);
                $planimetria[$key] = storage_path() . "/app/public/planimetrie/$rapprel->id/" . $imageName;
                $caption[$counter] = $request["caption_$counter"];
                $counter++;
                $counter_anteprima = $key + 1; // il $key parte da 0 dunque $key + 1 sarà l'elemento successivo
            }
            foreach (PlanimetriaRdpAnteprima::where('id_rdp',$rapprel->id)->get() as $key => $value) {
                $planimetria[$counter_anteprima] = $value->planimetria;
                $caption[$counter] = $value->caption;
                $counter++;
                $counter_anteprima++;
            }
        }
        else //caso in cui non aggiungo altre foto (considero la modifica della caption)
        {
            $counter = 1;
            $counter_anteprima = 0;
            foreach (PlanimetriaRdpAnteprima::where('id_rdp',$rapprel->id)->get() as $key => $value) {
                $planimetria[$counter_anteprima] = $value->planimetria;
                $caption[$counter] = isset($request['caption_planimetria_salvata_'.$value->id]) ? $request['caption_planimetria_salvata_'.$value->id] : $value->caption;
                $caption_modificate[$value->id] = isset($request['caption_planimetria_salvata_'.$value->id]) ? $request['caption_planimetria_salvata_'.$value->id] : $value->caption;
                $counter++;
                $counter_anteprima++;
            }
            
        }
        

        $temperatura = $request->temperatura;
        $stato_materiale = $request->stato_materiale;
        $data_accettazione = $request->data_accettazione;
        $note_pagina5 = $request->note_pagina5;

        #pagina 7

        /**I vari campioni da distribuire nelle tabelle */
        $campioni_aria_pca_at_rest_attivo = unserialize($request->campioni_aria_pca_at_rest_attivo);
        $campioni_aria_pca_at_rest_passivo = unserialize($request->campioni_aria_pca_at_rest_passivo);
        $pca_attivo_stanze = unserialize($request->pca_attivo_stanze);
        $pca_passivo_stanze = unserialize($request->pca_passivo_stanze);
        $campioni_aria_dg18_at_rest_attivo = unserialize($request->campioni_aria_dg18_at_rest_attivo);
        $campioni_aria_dg18_at_rest_passivo = unserialize($request->campioni_aria_dg18_at_rest_passivo);
        $campioni_stanze_pca_attivo = [];
        $campioni_stanze_pca_passivo = [];

        if($pca_attivo_stanze != null)
        {
            foreach($pca_attivo_stanze as $stanza => $lista_campioni)
            {
                $campioni_stanze_pca_attivo[$stanza] = [];
            }    
        }
        
        if($pca_passivo_stanze != null)
        {
            foreach($pca_passivo_stanze as $stanza => $lista_campioni)
            {
                $campioni_stanze_pca_passivo[$stanza] = [];
            }
        }
        
        $campioni_per_tipo = [
            '_pca_at_rest_attivo' => $campioni_aria_pca_at_rest_attivo,
            '_pca_at_rest_passivo' => $campioni_aria_pca_at_rest_passivo,
            '_pca_operat_attivo' => $pca_attivo_stanze,
            '_pca_operat_passivo' => $pca_passivo_stanze,
            '_dg18_at_rest_attivo' => $campioni_aria_dg18_at_rest_attivo,
            '_dg18_at_rest_passivo' => $campioni_aria_dg18_at_rest_passivo
        ];

        $campioni_analizzati_con_piastra_aria = [
            '_pca_at_rest_attivo' => [],
            '_pca_at_rest_passivo' => [],
            '_pca_operat_attivo' => [],
            '_pca_operat_passivo' => [],
            '_dg18_at_rest_attivo' => [],
            '_dg18_at_rest_passivo' => []
        ];

        $tipi_di_campioni = unserialize($request->tipi_di_campioni);
    
        /**Elementi in comune a tutte le tabelle */
        $dataOraInizioIncubazioneAria = [];
        $dataOraFineIncubazioneAria = [];
        $descrizioneMetodoAria = [];
        $metodoAria = [];
        $tecnicoAria = [];
        $lineeguida = [];       
        
        foreach($tipi_di_campioni as $tipo => $inserito)
        {
            if($inserito == 1)
            {
                $dataOraInizioIncubazioneAria["dataOraInizioIncubazione$tipo"] = $request["dataOraInizioIncubazioneAria$tipo"];
                $dataOraFineIncubazioneAria["dataOraFineIncubazione$tipo"] = $request["dataOraFineIncubazioneAria$tipo"];
                $descrizioneMetodoAria["descrizione_metodo$tipo"] = $request["descrizione_metodo_aria$tipo"];
                
                $metodoAria["metodo$tipo"] = $request["metodo_aria$tipo"];
                $tecnicoAria["tecnico$tipo"] = $request["tecnico_aria$tipo"];
    
                foreach($campioni_per_tipo[$tipo] as $key => $c)
                {
                   
                    if($tipo == '_pca_operat_attivo')
                    {
                        foreach($c as $camp)
                        {
                            if($camp != null)
                            {

                                array_push($campioni_stanze_pca_attivo[$key],
                                        [
                                            "id_campione" => $request["id_campione_aria_".$camp['id']],
                                            "codice_cias" => $request["codice_cias_aria_".$camp['id']],
                                            "punto_camp" => $request["punto_camp_aria_".$camp['id']],
                                            "CFU" => $request["CFU_aria_".$camp['id']] ?? 'NA',
                                            "U" => $request["U_aria_".$camp['id']] ?? 'NA',
                                            "valori_riferimento" => $request["valori_riferimento_aria_".$camp['id']],
                                        ]                             
                                );
                            }
                        }    
                    }
                    elseif($tipo == '_pca_operat_passivo')
                    {
                        foreach($c as $camp)
                        {
                            if($camp != null)
                            {
                                array_push($campioni_stanze_pca_passivo[$key],
                                        [
                                            "id_campione" => $request["id_campione_aria_".$camp['id']],
                                            "codice_cias" => $request["codice_cias_aria_".$camp['id']],
                                            "punto_camp" => $request["punto_camp_aria_".$camp['id']],
                                            "CFU" => $request["CFU_aria_".$camp['id']] ?? 'NA',
                                            "U" => $request["U_aria_".$camp['id']] ?? 'NA',
                                            "valori_riferimento" => $request["valori_riferimento_aria_".$camp['id']],
                                        ]                            
                                );
                            }
                        }   
                    }
                    else
                    {
                        if($c != null)
                        {
                            array_push($campioni_analizzati_con_piastra_aria[$tipo], 
                                [
                                    "id_campione" => $request["id_campione_aria_".$c['id']],
                                    "codice_cias" => $request["codice_cias_aria_".$c['id']],
                                    "punto_camp" => $request["punto_camp_aria_".$c['id']],
                                    "CFU" => $request["CFU_aria_".$c['id']] ?? 'NA',
                                    "U" => $request["U_aria_".$c['id']] ?? 'NA',
                                    "valori_riferimento" => $request["valori_riferimento_aria_".$c['id']],
                                ]
                            );
                        }
                        
                    }  
                }  
            }
            
        }

        #pagina 8 - 9
        $tipi_piastre_superficie = unserialize($request->tipi_piastre_superficie);
        $tipo_di_campione = unserialize($request->tipo_di_campione);
    
        $dataOraInizioIncubazioneSuperficie = [];
        $dataOraFineIncubazioneSuperficie = [];
        $metodoSuperficie = [];
        $descrizioneMetodoSuperficie = [];
        $tecnicoSuperficie = [];
        $lineeguida = [];

        $campioni_analizzati_con_piastra_superficie = ['pca' => [], 'dg18' => []];
        $campioni_pca = RapportoRelazioneController::get_all_campioni_for_piastra($campioni,26);
        $campioni_dg18 = RapportoRelazioneController::get_all_campioni_for_piastra($campioni,27);
        $campioni = $campioni_pca->merge($campioni_dg18);
        
        if($tipi_piastre_superficie != null || $tipi_piastre_superficie != [] || $tipi_piastre_superficie != "")
        {
            foreach($tipi_piastre_superficie as $key => $piastra)
            {
                $dataOraInizioIncubazioneSuperficie["dataOraInizioIncubazione_$piastra"] = $request["dataOraInizioIncubazioneSuperficie_$piastra"];
                $dataOraFineIncubazioneSuperficie["dataOraFineIncubazione_$piastra"] = $request["dataOraFineIncubazioneSuperficie_$piastra"];
                $metodoSuperficie["metodo_$piastra"] = $request["metodo_superficie_$piastra"];
                $descrizioneMetodoSuperficie["descrizione_metodo_$piastra"] = $request["descrizione_metodo_superficie_$piastra"];
                $tecnicoSuperficie["tecnico_$piastra"] = $request["tecnico_superficie_$piastra"];
    
                foreach($campioni as $c)
                {
                    
                    if($c->id_tipo_piastra == $key)
                    {
                        
                        array_push($campioni_analizzati_con_piastra_superficie[$piastra],
                            [
                                "id_campione" => $request["id_campione_superficie_$c->id"],
                                "codice_cias" => $request["codice_cias_superficie_$c->id"],
                                "punto_camp" => $request["punto_camp_superficie_$c->id"],
                                "CFU" => $request["CFU_superficie_$c->id"] ?? '/',
                                "U" => $request["U_superficie_$c->id"] ?? 'NA',
                                "valori_riferimento" => $request["valori_riferimento_superficie_$c->id"],
                            ]
                        );
                    }   
                }  
            }
        }
        

        #delete all element where id_campione => NULL
        if($campioni_analizzati_con_piastra_superficie != null || $campioni_analizzati_con_piastra_superficie != [] || $campioni_analizzati_con_piastra_superficie != "")
        {
            foreach($campioni_analizzati_con_piastra_superficie as $key => $piastra)
            {
                foreach($piastra as $key2 => $campione)
                {
                    if($campione['id_campione'] == NULL)
                    {
                        unset($campioni_analizzati_con_piastra_superficie[$key][$key2]);
                    }
                }
            }
        }
        

        #pagina 10
        $campioni_speciazione_pca_aria = SpeciazioneCampione::join('campioni','speciazioni_campioni.id_campione','=','campioni.id')
                                                        ->join('microrganismi_piastre','speciazioni_campioni.id_microrganismo','=','microrganismi_piastre.id')
                                                        ->join('tipi_piastre','speciazioni_campioni.id_tipopiastra','=','tipi_piastre.id')
                                                        ->join('punti_campionamento', 'punti_campionamento.id','=','speciazioni_campioni.id_punto_camp')
                                                        ->where('campioni.id_campagna',$campagna->id)
                                                        ->where('campioni.tipoCamp','A')
                                                        ->where('campioni.id_tipo_piastra',26)
                                                        ->select('campioni.id as id_campione',
                                                                'campioni.codiceCIAS as codice_campione',
                                                                'punti_campionamento.punto_campionamento as punto_campionamento',
                                                                'speciazioni_campioni.esito as risultato',
                                                                'microrganismi_piastre.microrganismo as microrganismo_ricercato',
                                                                'campioni.dataAnalisi as dataInizioProva',
                                                                'campioni.dataFineAnalisi as dataFineProva',
                                                                'campioni.tecnico as tecnico',
                                                                'tipi_piastre.abbreviazione as tipo_terreno')->get();
                                                        

        $campioni_speciazione_pca_superficie = SpeciazioneCampione::join('campioni','speciazioni_campioni.id_campione','=','campioni.id')
                                                        ->join('microrganismi_piastre','speciazioni_campioni.id_microrganismo','=','microrganismi_piastre.id')
                                                        ->join('tipi_piastre','speciazioni_campioni.id_tipopiastra','=','tipi_piastre.id')
                                                        ->join('punti_campionamento', 'punti_campionamento.id','=','speciazioni_campioni.id_punto_camp')
                                                        ->where('campioni.id_campagna',$campagna->id)
                                                        ->where('campioni.tipoCamp','S')
                                                        ->where('campioni.id_tipo_piastra',26)
                                                        ->select('campioni.id as id_campione',
                                                                'campioni.codiceCIAS as codice_campione',
                                                                'punti_campionamento.punto_campionamento as punto_campionamento',
                                                                'speciazioni_campioni.esito as risultato',
                                                                'microrganismi_piastre.microrganismo as microrganismo_ricercato',
                                                                'campioni.dataAnalisi as dataInizioProva',
                                                                'campioni.dataFineAnalisi as dataFineProva',
                                                                'campioni.tecnico as tecnico',
                                                                'tipi_piastre.abbreviazione as tipo_terreno')->get();

        $campioni_speciazione_dg18_aria = SpeciazioneCampione::join('campioni','speciazioni_campioni.id_campione','=','campioni.id')
                                                        ->join('microrganismi_piastre','speciazioni_campioni.id_microrganismo','=','microrganismi_piastre.id')
                                                        ->join('tipi_piastre','speciazioni_campioni.id_tipopiastra','=','tipi_piastre.id')
                                                        ->join('punti_campionamento', 'punti_campionamento.id','=','speciazioni_campioni.id_punto_camp')
                                                        ->where('campioni.id_campagna',$campagna->id)
                                                        ->where('campioni.tipoCamp','A')
                                                        ->where('campioni.id_tipo_piastra',27)
                                                        ->select('campioni.id as id_campione',
                                                                'campioni.codiceCIAS as codice_campione',
                                                                'punti_campionamento.punto_campionamento as punto_campionamento',
                                                                'speciazioni_campioni.esito as risultato',
                                                                'microrganismi_piastre.microrganismo as microrganismo_ricercato',
                                                                'campioni.dataAnalisi as dataInizioProva',
                                                                'campioni.dataFineAnalisi as dataFineProva',
                                                                'campioni.tecnico as tecnico',
                                                                'tipi_piastre.abbreviazione as tipo_terreno')->get();

        $campioni_speciazione_dg18_superficie = SpeciazioneCampione::join('campioni','speciazioni_campioni.id_campione','=','campioni.id')
                                                        ->join('microrganismi_piastre','speciazioni_campioni.id_microrganismo','=','microrganismi_piastre.id')
                                                        ->join('tipi_piastre','speciazioni_campioni.id_tipopiastra','=','tipi_piastre.id')
                                                        ->join('punti_campionamento', 'punti_campionamento.id','=','speciazioni_campioni.id_punto_camp')
                                                        ->where('campioni.id_campagna',$campagna->id)
                                                        ->where('campioni.tipoCamp','S')
                                                        ->where('campioni.id_tipo_piastra',27)
                                                        ->select('campioni.id as id_campione',
                                                                'campioni.codiceCIAS as codice_campione',
                                                                'punti_campionamento.punto_campionamento as punto_campionamento',
                                                                'speciazioni_campioni.esito as risultato',
                                                                'microrganismi_piastre.microrganismo as microrganismo_ricercato',
                                                                'campioni.dataAnalisi as dataInizioProva',
                                                                'campioni.dataFineAnalisi as dataFineProva',
                                                                'campioni.tecnico as tecnico',
                                                                'tipi_piastre.abbreviazione as tipo_terreno')->get();

        $dataFineProva_pca_aria = $request->dataFineProva_pca_aria;
        $dataFineProva_pca_superficie = $request->dataFineProva_pca_superficie;
        $dataFineProva_dg18_aria = $request->dataFineProva_dg18_aria;
        $dataFineProva_dg18_superficie = $request->dataFineProva_dg18_superficie;

        //Log::info($righe_campioni_speciazione_automatica);

        #pagina 11
        $superano = $request->superano;
        $lineeguida1 = $request->lineeguida1_page11;        
        $lineeguida2 = $request->lineeguida2_page11;
        $esito = $request->esito;
        $campione_esito = $request->campione_esito;
        $no_incertezza = $request->no_incertezza;



        #appendice
        $riferimenti = [];
        $riferimenti7_accessori = [];
        $riferimenti8_accessori = [];
        $count_riferimenti = 0;
        for($i = 1; $i <= 8; $i++)
        {
            if($request["riferimento$i"] != null)
            {
                array_push($riferimenti, ["$i" => 1]);
                $count_riferimenti++;
            }
            else
            {
                array_push($riferimenti, ["$i" => 0]);
            }

            if($i == 7 && isset($request->riferimento7))
            {
                if(isset($request->riferimento7_table1))
                {
                    array_push($riferimenti7_accessori,[$i.'_table1' =>  1]);
                    $count_riferimenti++;
                }
                else
                {
                    array_push($riferimenti7_accessori,[$i.'_table1' =>  0]);
                }

                if(isset($request->riferimento7_table2))
                {
                    array_push($riferimenti7_accessori,[$i.'_table2' =>  1]);
                    $count_riferimenti++;

                }
                else
                {
                    array_push($riferimenti7_accessori,[$i.'_table2' =>  0]);
                    
                }
            }

            if($i == 8)
            {
                if(isset($request->riferimento8_indicazione1) || isset($request->riferimento8_indicazione2))
                {
                    array_push($riferimenti, ["8" => 1]);
                    $count_riferimenti++;
                }

                if(isset($request->riferimento8_indicazione1))
                {
                    array_push($riferimenti8_accessori,['8_indicazione1' =>  1]);
                    $count_riferimenti++;
                }
                else
                {
                    array_push($riferimenti8_accessori,['8_indicazione1' =>  0]);
                }
                if(isset($request->riferimento8_indicazione2))
                {
                    array_push($riferimenti8_accessori,['8_indicazione2' =>  1]);
                    $count_riferimenti++;
                }
                else
                {
                    array_push($riferimenti8_accessori,['8_indicazione2' =>  0]);
                }
                if(isset($request->riferimento8_indicazione3))
                {
                    array_push($riferimenti8_accessori,['8_indicazione3' =>  1]);
                    $count_riferimenti++;
                }
                else
                {
                    array_push($riferimenti8_accessori,['8_indicazione3' =>  0]);
                }
                if(isset($request->riferimento8_indicazione4))
                {
                    array_push($riferimenti8_accessori,['8_indicazione4' =>  1]);
                    $count_riferimenti++;
                }
                else
                {
                    array_push($riferimenti8_accessori,['8_indicazione4' =>  0]);
                }
            }
        }

        $riferimento8_portata = $request->riferimento8_portata;
        #last page
        $opinioni = "In relazione ai risultati ottenuti, in base a quanto indicato dalle Linee Guida di riferimento " . $request->opinioni_ed_interpretazioni_lineeguida ." si suggerisce di procedere con il controllo microbiologico ". $request->opinioni_ed_interpretazioni;
        $note_di_revisione = null;
        
        $rev_precedente = 0;
        $rapprel_da_correggere = "";
        if($rapprel->rev != 0 && $rapprel->id_rapporto_rev != null)
        {
            $rapprel_da_correggere = RapportoRelazione::find($rapprel->id_rapporto_rev);
            $rev_precedente = 1;
        }

        //pdf generation
        $pdf = PDF::loadView(
            'relazioni_e_rapporti.rapporto_pdf_committente',
            [
                'rev_precedente' => $rev_precedente,
                'rapprel_da_correggere' => $rapprel_da_correggere,
                'rapprel' => $rapprel,
                'campioni' => $campioni,
                'campagna' => $campagna,
                'numero_colonne' => $request->numero_colonne,
                'nome_cliente' => $nome_cliente,
                'indirizzo_cliente' => $indirizzo_cliente,
                'indirizzo_struttura' => $indirizzo_struttura,
                'struttura_partizione' => $struttura_partizione,
                'modulo_di_accettazione' => $modulo_di_accettazione, 
                'struttura_indirizzo' => $struttura_sede,
                'incaricati_del_campionamento' => $incaricati_del_campionamento,
                'data_campionamento_inizio' => $data_campionamento_inizio,
                'data_campionamento_fine' => $data_campionamento_fine,
                'ora_inizio' => $ora_inizio,
                'ora_fine' => $ora_fine,
                'data_inizio' => $data_inizio,
                'data_fine' => $data_fine,
                'elenco_campioni' => $elenco_campioni,
                'tipo_di_ambiente' => $tipo_di_ambiente,
                'numero_e_codifica_locali' => $numero_e_codifica_locali,
                'codice_partizione_stanza' => $codice_partizione_stanza,
                'class_iso_di_riferimento' => $class_iso_di_riferimento,
                'tipo_di_flusso' => $tipo_di_flusso,
                'note_pagina3' => $note_pagina3,
                'stato_di_occupazione_aria_at_rest' => $stato_di_occupazione_aria_at_rest,
                'n_persone_presenti_aria_at_rest' => $n_persone_presenti_aria_at_rest,
                'stato_porte_aria_at_rest' => $stato_porte_aria_at_rest,
                'campionamento_effettuato_da_aria_at_rest' => $campionamento_effettuato_da_aria_at_rest,
                'note_pagina3_aria_at_rest' => $note_pagina3_aria_at_rest,
                'stato_di_occupazione_aria_operat' => $stato_di_occupazione_aria_operat,
                'n_persone_presenti_aria_operat' => $n_persone_presenti_aria_operat,
                'stato_porte_aria_operat' => $stato_porte_aria_operat,
                'tipo_di_operazione' => $tipo_di_operazione,
                'campionamento_effettuato_da_aria_operat' => $campionamento_effettuato_da_aria_operat,
                'note_pagina3_aria_operat' => $note_pagina3_aria_operat,
                'stato_di_occupazione_superfici' => $stato_di_occupazione_superfici,
                'n_persone_presenti_superfici' => $n_persone_presenti_superfici,
                'stato_porte_superfici' => $stato_porte_superfici,
                'campionamento_effettuato_da_superfici' => $campionamento_effettuato_da_superfici,
                'note_pagina3_superfici' => $note_pagina3_superfici,
                'note' => $note,
                'planimetria' =>  $planimetria,
                'descrizioneMetodoAria' => $descrizioneMetodoAria,
                'descrizioneMetodoSuperficie' => $descrizioneMetodoSuperficie,
                'temperatura' => $temperatura,
                'stato_materiale' => $stato_materiale,
                'data_accettazione' => $data_accettazione,
                'note_pagina5' => $note_pagina5,
                'tipi_di_campioni' => $tipi_di_campioni,
                'campioni_stanze_pca_attivo' => $campioni_stanze_pca_attivo,
                'campioni_stanze_pca_passivo' => $campioni_stanze_pca_passivo,
                'campioni_analizzati_con_piastra_aria' => $campioni_analizzati_con_piastra_aria,
                'tipi_piastre_superficie' => $tipi_piastre_superficie,
                'dataOraInizioIncubazioneAria' => $dataOraInizioIncubazioneAria,
                'dataOraFineIncubazioneAria' => $dataOraFineIncubazioneAria,
                'metodoAria' => $metodoAria,
                'tecnicoAria' => $tecnicoAria,
                'lineeGuidaAria' => unserialize($request->lineeGuida_aria),
                'dataOraInizioIncubazioneSuperficie' => $dataOraInizioIncubazioneSuperficie,
                'dataOraFineIncubazioneSuperficie' => $dataOraFineIncubazioneSuperficie,
                'metodoSuperficie' => $metodoSuperficie,
                'tecnicoSuperficie' => $tecnicoSuperficie,
                'campioni_analizzati_con_piastra_superficie' => $campioni_analizzati_con_piastra_superficie,
                'lineeGuidaSuperficie' => unserialize($request->lineeGuida_superficie),
                'superano' => $superano,
                'lineeguida1' => $lineeguida1,
                'lineeguida2' => $lineeguida2,
                'esito' => $esito,
                'campione_esito' => $campione_esito,
                'no_incertezza' => $no_incertezza,
                'opinioni' => $opinioni,
                'note_di_revisione' => $note_di_revisione,
                'num_rdp' => $num_rdp,
                'riferimenti' => $riferimenti,
                'count_riferimenti' => $count_riferimenti,
                'riferimenti7_accessori' => $riferimenti7_accessori,
                'riferimenti8_accessori' => $riferimenti8_accessori,
                'riferimento8_portata' => $riferimento8_portata,
                'firmaDirettore' => null,
                'firmaResponsabile' => null,
                'campioni_speciazione_pca_superficie' => $campioni_speciazione_pca_superficie,
                'campioni_speciazione_dg18_superficie' => $campioni_speciazione_dg18_superficie,
                'campioni_speciazione_dg18_aria' => $campioni_speciazione_dg18_aria,
                'campioni_speciazione_pca_aria' => $campioni_speciazione_pca_aria,
                'dataFineProva_pca_aria' => $request->dataFineProva_pca_aria,
                'dataFineProva_pca_superficie' => $request->dataFineProva_pca_superficie,
                'dataFineProva_dg18_aria' => $request->dataFineProva_dg18_aria,
                'dataFineProva_dg18_superficie' => $request->dataFineProva_dg18_superficie,
                'caption' => $caption,
            ]
        );        
        $content = $pdf->download()->getOriginalContent();
        $path_folder = "rapporti_relazioni";
        $actual_year = substr(Carbon::now()->year, -2);
        if($rapprel->rev == 0)
        {
            $fileName = "MOD_02_RDP_".$num_rdp."_".Carbon::now()->format('Y-m-d').".pdf";
        }
        else
        {
            $fileName = "MOD_02_RDP_".$num_rdp."_".Carbon::now()->format('Y-m-d')."_0".$rapprel->rev.".pdf";
        }

        Storage::put("public/$path_folder/$fileName", $content);

        $rapprel->file = $fileName;
        $rapprel->data_generazione = Carbon::now()->format('d-m-Y');
        $rapprel->save();

        //creazione tupla in rdp_anteprima
        $anteprima = RdpAnteprima::where('id_rapprel', $rapprel->id)->where('committente',1)->first();
        if($anteprima == null)
        {
            $anteprima = new RdpAnteprima;
            $anteprima->id_rapprel = $rapprel->id;
            $anteprima->committente = 1;
        }
        //pagina 1
        $anteprima->n_rdp = $num_rdp;
        $anteprima->nome_cliente = $nome_cliente;
        $anteprima->indirizzo_cliente = $indirizzo_cliente;
        $anteprima->indirizzo_struttura = $indirizzo_struttura;
        $anteprima->struttura_partizione = $struttura_partizione;
        $anteprima->modulo_accettazione = $modulo_di_accettazione;

        //pagina 2
        $anteprima->incaricati_del_campionamento = $incaricati_del_campionamento;
        $anteprima->data_campionamento_inizio_committente = $data_campionamento_inizio;
        $anteprima->data_campionamento_fine_committente = $data_campionamento_fine;
        $anteprima->ora_inizio_committente = $ora_inizio;
        $anteprima->data_inizio_committente = $data_inizio;
        $anteprima->ora_fine_committente = $ora_fine;
        $anteprima->data_fine_committente = $data_fine;

        //pagina 3
        $anteprima->temperatura = $temperatura;
        $anteprima->stato_materiale = $stato_materiale;
        $anteprima->data_accettazione = $data_accettazione;
        $anteprima->valutazione_committente_note = $note;
        $anteprima->superano = $superano;
        $anteprima->lineeguida1 = $lineeguida1;
        $anteprima->lineeguida2 = $lineeguida2;
        $anteprima->esito = $esito;
        $anteprima->campione_esito = $campione_esito;
        $anteprima->no_incertezza = $no_incertezza;
        $anteprima->opinioni_ed_interpretazioni = $request->opinioni_ed_interpretazioni;
        $anteprima->opinioni_ed_interpretazioni_lineeguida = $request->opinioni_ed_interpretazioni_lineeguida;
        $anteprima->note_di_revisione = $note_di_revisione;
        $anteprima->riferimento1 = $request["riferimento1"] != null ? 1 : 0;
        $anteprima->riferimento2 = $request["riferimento2"] != null ? 1 : 0;
        $anteprima->riferimento3 = $request["riferimento3"] != null ? 1 : 0;
        $anteprima->riferimento4 = $request["riferimento4"] != null ? 1 : 0;
        $anteprima->riferimento5 = $request["riferimento5"] != null ? 1 : 0;
        $anteprima->riferimento6 = $request["riferimento6"] != null ? 1 : 0;
        $anteprima->riferimento7 = isset($request->riferimento7) ? 1 : 0;
        $anteprima->riferimento7_table1 = isset($request->riferimento7_table1) ? 1 : 0;
        $anteprima->riferimento7_table2 = isset($request->riferimento7_table2) ? 1 : 0;
        $anteprima->riferimento8 = (isset($request->riferimento8_indicazione1) || isset($request->riferimento8_indicazione2)) ? 1 : 0;
        $anteprima->riferimento8_indicazione1 = isset($request->riferimento8_indicazione1) ? 1 : 0;
        $anteprima->riferimento8_indicazione2 = isset($request->riferimento8_indicazione2) ? 1 : 0;
        $anteprima->riferimento8_indicazione3 = isset($request->riferimento8_indicazione3) ? 1 : 0;
        $anteprima->riferimento8_indicazione4 = isset($request->riferimento8_indicazione4) ? 1 : 0;
        $anteprima->riferimento8_portata = $riferimento8_portata;
        $anteprima->firmaDirettore = 0;
        $anteprima->firmaResponsabile = 0;

        $anteprima->save();

        //save note_campionamento associate ad anteprima
        for($i = 1; $i<=$request->numero_colonne; $i++)
        {
            $notaCampionamentoAnteprima = NotaCampionamentoRdpAnteprima::where('id_rdp_anteprima', $anteprima->id)->where('numero_colonna',$i)->first();
            if($notaCampionamentoAnteprima == null)
            {
                $notaCampionamentoAnteprima = new NotaCampionamentoRdpAnteprima;
                $notaCampionamentoAnteprima->id_rdp_anteprima = $anteprima->id;
                $notaCampionamentoAnteprima->id_rdp = $rapprel->id;
                $notaCampionamentoAnteprima->numero_colonna = $i;
            }
            //pagina 3 - 4
            $notaCampionamentoAnteprima->tipo_di_ambiente = $request["tipo_di_ambiente_$i"];
            $notaCampionamentoAnteprima->numero_e_codifica_locali = $request["numero_e_codifica_locali_$i"];
            $notaCampionamentoAnteprima->codice_partizione_stanza = $request["codice_partizione_stanza_$i"];
            $notaCampionamentoAnteprima->class_iso_di_riferimento = $request["class_iso_di_riferimento_$i"];
            $notaCampionamentoAnteprima->tipo_di_flusso = $request["tipo_di_flusso_$i"];
            $notaCampionamentoAnteprima->note_pagina3 = $request["note_pagina3_$i"];
            $notaCampionamentoAnteprima->stato_di_occupazione_aria_at_rest = $request["stato_di_occupazione_aria_at_rest_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_aria_at_rest_data = $request["data_di_campionamento_ora_inizio_e_fine_aria_at_rest_data_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraI = $request["data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraI_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraF = $request["data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraF_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_aria_operat_data = $request["data_di_campionamento_ora_inizio_e_fine_aria_operat_data_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_aria_operat_oraI = $request["data_di_campionamento_ora_inizio_e_fine_aria_operat_oraI_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_aria_operat_oraF = $request["data_di_campionamento_ora_inizio_e_fine_aria_operat_oraF_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_superfici_data = $request["data_di_campionamento_ora_inizio_e_fine_superfici_data_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_superfici_oraI = $request["data_di_campionamento_ora_inizio_e_fine_superfici_oraI_$i"];
            $notaCampionamentoAnteprima->data_di_campionamento_ora_inizio_e_fine_superfici_oraF = $request["data_di_campionamento_ora_inizio_e_fine_superfici_oraF_$i"];
            $notaCampionamentoAnteprima->n_persone_presenti_aria_at_rest = $request["n_persone_presenti_aria_at_rest_$i"];
            $notaCampionamentoAnteprima->stato_porte_aria_at_rest = $request["stato_porte_aria_at_rest_$i"];
            $notaCampionamentoAnteprima->campionamento_effettuato_da_aria_at_rest = $request["campionamento_effettuato_da_aria_at_rest_$i"];
            $notaCampionamentoAnteprima->note_pagina3_aria_at_rest = $request["note_pagina3_aria_at_rest_$i"];
            $notaCampionamentoAnteprima->stato_di_occupazione_aria_operat = $request["stato_di_occupazione_aria_operat_$i"];
            $notaCampionamentoAnteprima->strum_n_aria_at_rest1 = isset($request["strum_n_aria_at_rest_$i"][0]) ? $request["strum_n_aria_at_rest_$i"][0] : '';
            $notaCampionamentoAnteprima->strum_n_aria_at_rest2 = isset($request["strum_n_aria_at_rest_$i"][1]) ? $request["strum_n_aria_at_rest_$i"][1] : '';
            $notaCampionamentoAnteprima->strum_n_aria_at_rest3 = isset($request["strum_n_aria_at_rest_$i"][2]) ? $request["strum_n_aria_at_rest_$i"][2] : '';
            $notaCampionamentoAnteprima->strum_n_aria_operat1 = isset($request["strum_n_aria_operat_$i"][0]) ? $request["strum_n_aria_operat_$i"][0] : '';
            $notaCampionamentoAnteprima->strum_n_aria_operat2 = isset($request["strum_n_aria_operat_$i"][1]) ? $request["strum_n_aria_operat_$i"][1] : '';
            $notaCampionamentoAnteprima->strum_n_aria_operat3 = isset($request["strum_n_aria_operat_$i"][2]) ? $request["strum_n_aria_operat_$i"][2] : '';
            $notaCampionamentoAnteprima->n_persone_presenti_aria_operat = $request["n_persone_presenti_aria_operat_$i"];
            $notaCampionamentoAnteprima->stato_porte_aria_operat = $request["stato_porte_aria_operat_$i"];
            $notaCampionamentoAnteprima->tipo_di_operazione = $request["tipo_di_operazione_$i"];
            $notaCampionamentoAnteprima->campionamento_effettuato_da_aria_operat = $request["campionamento_effettuato_da_aria_operat_$i"];
            $notaCampionamentoAnteprima->note_pagina3_aria_operat = $request["note_pagina3_aria_operat_$i"];
            $notaCampionamentoAnteprima->stato_di_occupazione_superfici = $request["stato_di_occupazione_superfici_$i"];
            $notaCampionamentoAnteprima->n_persone_presenti_superfici = $request["n_persone_presenti_superfici_$i"];
            $notaCampionamentoAnteprima->stato_porte_superfici = $request["stato_porte_superfici_$i"];
            $notaCampionamentoAnteprima->campionamento_effettuato_da_superfici = $request["campionamento_effettuato_da_superfici_$i"];
            $notaCampionamentoAnteprima->note_pagina3_superfici = $request["note_pagina3_superfici_$i"];

            $notaCampionamentoAnteprima->save();
        }

        $image = $request->file('planimetria');
        if($image != null)
        {
            $counter = 1;
            $trovato = False; // per gestire il caso in cui ho una sola immagine con nome planimetria_0.jpg
            if(count(PlanimetriaRdpAnteprima::where('id_rdp',$rapprel->id)->get()) > 0)
            {
                $trovato = True;
                $numero = count(PlanimetriaRdpAnteprima::where('id_rdp',$rapprel->id)->get()) - 1;
            }
            foreach($image as $key => $value){
                if($numero == 0 && $trovato == False)
                {
                    $imageName = "planimetria_$key.jpg";
                }
                else
                {
                    $numero = $numero + 1;
                    $imageName = "planimetria_$numero.jpg";
                }
                if(PlanimetriaRdpAnteprima::where('id_rdp',$rapprel->id)->where('id_rdp_anteprima',$anteprima->id)->where('planimetria',storage_path() . "/app/public/planimetrie/$rapprel->id/" . $imageName)->where('caption',$request["caption_$counter"])->first() == null)
                {   
                    $planimetrieAnteprima = new PlanimetriaRdpAnteprima();
                    $planimetrieAnteprima->id_rdp = $rapprel->id;
                    $planimetrieAnteprima->id_rdp_anteprima = $anteprima->id;
                    $planimetrieAnteprima->planimetria = storage_path() . "/app/public/planimetrie/$rapprel->id/" . $imageName;
                    $planimetrieAnteprima->caption = $request["caption_".$counter];
                    $planimetrieAnteprima->save();
                }
                else
                {
                    $planimetrieAnteprima = PlanimetriaRdpAnteprima::where('id_rdp',$rapprel->id)->where('id_rdp_anteprima',$anteprima->id)->where('planimetria',storage_path() . "/app/public/planimetrie/$rapprel->id/" . $imageName)->where('caption',$request["caption_$counter"])->first();
                    $planimetrieAnteprima->id_rdp = $rapprel->id;
                    $planimetrieAnteprima->id_rdp_anteprima = $anteprima->id;
                    $planimetrieAnteprima->planimetria = storage_path() . "/app/public/planimetrie/$rapprel->id/" . $imageName;
                    $planimetrieAnteprima->caption = isset($request['caption_planimetria_salvata_'.$anteprima->id]) ? $request['caption_planimetria_salvata_'.$anteprima->id] : $anteprima->caption;
                    $planimetrieAnteprima->save();
                }
                $counter++;
            }
        }
        else //caso in cui non aggiungo altre foto (considero la modifica della caption)
        {
            foreach ($caption_modificate as $id => $value) {
                $planimetria = PlanimetriaRdpAnteprima::find($id);
                $planimetria->caption = $value;
                $planimetria->save();
            }
            
        }

        //save descrizione anteprima
        if($tipi_di_campioni['_pca_at_rest_attivo'] != 0)
        {
            foreach($campioni_analizzati_con_piastra_aria as $tipo_campione => $value)
            {
                if($tipo_campione == '_pca_at_rest_attivo')
                {
                    foreach ($value as $item) 
                    {
                        $descrizioneAnteprima = new DescrizioneCampionamentoRdpAnteprima();
                        $descrizioneAnteprima->id_rdp = $rapprel->id;
                        $descrizioneAnteprima->id_rdp_anteprima = $anteprima->id;
                        $descrizioneAnteprima->aria = 1;
                        $descrizioneAnteprima->pca = 1;
                        $descrizioneAnteprima->at_rest = 1;
                        $descrizioneAnteprima->attivo = 1;
                        $descrizioneAnteprima->valori_riferimento = $item['valori_riferimento'];
                        $descrizioneAnteprima->id_campione = $item['id_campione'];
                        $descrizioneAnteprima->save();
                    }
                }
            }       
        }

        if($tipi_di_campioni['_pca_at_rest_passivo'] != 0)
        {
            foreach($campioni_analizzati_con_piastra_aria as $tipo_campione => $value)
            {
                if($tipo_campione == '_pca_at_rest_passivo')
                {
                    foreach ($value as $item) 
                    {
                        $descrizioneAnteprima = new DescrizioneCampionamentoRdpAnteprima();
                        $descrizioneAnteprima->id_rdp = $rapprel->id;
                        $descrizioneAnteprima->id_rdp_anteprima = $anteprima->id;
                        $descrizioneAnteprima->aria = 1;
                        $descrizioneAnteprima->pca = 1;
                        $descrizioneAnteprima->at_rest = 1;
                        $descrizioneAnteprima->passivo = 1;
                        $descrizioneAnteprima->id_campione = $item['id_campione'];
                        $descrizioneAnteprima->save();
                    }
                }
            }  
        }

        if($tipi_di_campioni['_pca_operat_attivo'] != 0)
        {
            foreach ($campioni_stanze_pca_attivo as $stanza => $lista_campioni_stanza) {
                foreach($lista_campioni_stanza as $value)
                {
                    $descrizioneAnteprima = new DescrizioneCampionamentoRdpAnteprima();
                    $descrizioneAnteprima->id_rdp = $rapprel->id;
                    $descrizioneAnteprima->id_rdp_anteprima = $anteprima->id;
                    $descrizioneAnteprima->aria = 1;
                    $descrizioneAnteprima->pca = 1;
                    $descrizioneAnteprima->operat = 1;
                    $descrizioneAnteprima->attivo = 1;
                    $descrizioneAnteprima->stanza = $stanza;
                    $descrizioneAnteprima->$value['valori_riferimento'];
                    $descrizioneAnteprima->id_campione = $value['id_campione'];
                    $descrizioneAnteprima->save();
                }
            }
        }

        if($tipi_di_campioni['_pca_operat_passivo'] != 0)
        {
            foreach ($campioni_stanze_pca_passivo as $stanza => $lista_campioni_stanza) {
                foreach($lista_campioni_stanza as $value)
                {
                    $descrizioneAnteprima = new DescrizioneCampionamentoRdpAnteprima();
                    $descrizioneAnteprima->id_rdp = $rapprel->id;
                    $descrizioneAnteprima->id_rdp_anteprima = $anteprima->id;
                    $descrizioneAnteprima->aria = 1;
                    $descrizioneAnteprima->pca = 1;
                    $descrizioneAnteprima->operat = 1;
                    $descrizioneAnteprima->passivo = 1;
                    $descrizioneAnteprima->stanza = $stanza;
                    $descrizioneAnteprima->$value['valori_riferimento'];
                    $descrizioneAnteprima->id_campione = $value['id_campione'];
                    $descrizioneAnteprima->save();
                }
            }
        }

        if($tipi_di_campioni['_dg18_at_rest_attivo'] != 0)
        {
            foreach($campioni_analizzati_con_piastra_aria as $tipo_campione => $value)
            {
                if($tipo_campione == '_dg18_at_rest_attivo')
                {
                    foreach ($value as $item) 
                    {
                        $descrizioneAnteprima = new DescrizioneCampionamentoRdpAnteprima();
                        $descrizioneAnteprima->id_rdp = $rapprel->id;
                        $descrizioneAnteprima->id_rdp_anteprima = $anteprima->id;
                        $descrizioneAnteprima->aria = 1;
                        $descrizioneAnteprima->dg18 = 1;
                        $descrizioneAnteprima->at_rest = 1;
                        $descrizioneAnteprima->attivo = 1;
                        $descrizioneAnteprima->id_campione = $item['id_campione'];
                        $descrizioneAnteprima->save();
                    }
                }
            }   
        }

        if($tipi_di_campioni['_dg18_at_rest_passivo'] != 0)
        {
            foreach($campioni_analizzati_con_piastra_aria as $tipo_campione => $value)
            {
                if($tipo_campione == '_dg18_at_rest_passivo')
                {
                    foreach ($value as $item) 
                    {
                        $descrizioneAnteprima = new DescrizioneCampionamentoRdpAnteprima();
                        $descrizioneAnteprima->id_rdp = $rapprel->id;
                        $descrizioneAnteprima->id_rdp_anteprima = $anteprima->id;
                        $descrizioneAnteprima->aria = 1;
                        $descrizioneAnteprima->dg18 = 1;
                        $descrizioneAnteprima->at_rest = 1;
                        $descrizioneAnteprima->passivo = 1;
                        $descrizioneAnteprima->id_campione = $item['id_campione'];
                        $descrizioneAnteprima->save();
                    }
                }
            }   
        }

        if(count($tipi_piastre_superficie) > 0)
        {
            foreach ($tipi_piastre_superficie as $id_piastra => $piastra) 
            {
                foreach($campioni_analizzati_con_piastra_superficie as $nome_piastra => $campioni)
                {
                    if($piastra == $nome_piastra)
                    {
                        foreach ($campioni as $c)
                        {
                            if(DescrizioneCampionamentoRdpAnteprima::where('id_rdp',$rapprel->id)->where('id_rdp_anteprima',$anteprima->id)->where('id_campione',$c['id_campione'])->first() == null)
                            {
                                $descrizioneAnteprima = new DescrizioneCampionamentoRdpAnteprima();
                                $descrizioneAnteprima->id_rdp = $rapprel->id;
                                $descrizioneAnteprima->id_rdp_anteprima = $anteprima->id;
                                $descrizioneAnteprima->id_campione = $c['id_campione'];
                                $descrizioneAnteprima->superficie = 1;
                                $descrizioneAnteprima->pca = $id_piastra == 26 ? 1 : 0;
                                $descrizioneAnteprima->dg18 = $id_piastra == 27 ? 1 : 0;
                                $descrizioneAnteprima->at_rest = 1;
                            }
                            else
                            {
                                $descrizioneAnteprima = DescrizioneCampionamentoRdpAnteprima::where('id_rdp',$rapprel->id)->where('id_rdp_anteprima',$anteprima->id)->where('id_campione',$c['id_campione'])->first();
                            }
                            $descrizioneAnteprima->valori_riferimento = $c['valori_riferimento'];
                            $descrizioneAnteprima->save();
                        }
                    }
                }
            }
        }

        LoggerEvent::log(auth()->user()->id,"Generato Rapporto di prova di campionamenti eseguiti dal committente", ['id_utente' => auth()->user()->id], true, null, $rapprel->id);
        
        //return $pdf->download($fileName);
        return $pdf->stream();
    }

    public function convert_data($data,$oraI,$oraF)
    {
        
        if($data == null || $oraI == null || $oraF == null || $data == '/' || $oraI == '/' || $oraF == '/' )
        {
            return '/';
        }
        
        $date = Carbon::createFromFormat('Y-m-d', $data);
       
        $new_date = $date->format('d/m/Y')." h. ".$oraI." - ".$oraF;
        
        return $new_date;
    }

    public static function get_all_campioni_for_piastra($campioni,$id_piastra)
    {
        if($campioni == null || count($campioni) == 0)
        {
            return [];
        }

        $campioni = Campione::hydrate($campioni);

        $campioni_piastra = $campioni->where('id_tipo_piastra',$id_piastra);
        
        return $campioni_piastra;
    }

    /**
     * Inserisce la firma del direttore o del responsabile sul rapporto di prova 
     *
     * @param  \App\RapportoRelazione  $rappRel
     * @return \Illuminate\Http\Response
     */
    public static function gestisciFirma(Request $request)
    {
        $rapprel = RapportoRelazione::find($request->id_rapprel);
        if($rapprel == null)
        {
            return response()->json(['error' => 'Rapporto di prova non trovato'], 404);
        }
        
        if($request->azione == 'aggiungi')
        {
            if($request->amministratore == 'responsabile')
            {
                $rapprel->firmaResponsabile = 1;
                //add the sign to the pdf file
                $file = Storage::disk("public")->path("rapporti_relazioni/".$rapprel->file);
                $outputFilePath = Storage::disk("public")->path("rapporti_relazioni/".$rapprel->file);
                
                $fpdi = new FPDI;
                $count = $fpdi->setSourceFile($file);
        
                for ($i=1; $i<=$count; $i++) {
        
                    $template = $fpdi->importPage($i);
                    $size = $fpdi->getTemplateSize($template);
                    $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
                    $fpdi->useTemplate($template);

                    if($i == $count)
                    {
                        $fpdi->Image(Storage::disk('public')->path("/firme/firma_caselli.png"), 110, 190, 70);
                    }
                }
        
                $fpdi->Output($outputFilePath, 'F');
            }
            else
            {
                $rapprel->firmaDirettore = 1;
                $file = Storage::disk("public")->path("rapporti_relazioni/".$rapprel->file);
                $outputFilePath = Storage::disk("public")->path("rapporti_relazioni/".$rapprel->file);
                
                $fpdi = new FPDI;
                $count = $fpdi->setSourceFile($file);
        
                for ($i=1; $i<=$count; $i++) {
        
                    $template = $fpdi->importPage($i);
                    $size = $fpdi->getTemplateSize($template);
                    $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
                    $fpdi->useTemplate($template);

                    if($i == $count)
                    {
                        $fpdi->Image(Storage::disk('public')->path("/firme/firma_mazzacane.png"), 40, 190, 50);
                    }
                }
        
                $fpdi->Output($outputFilePath, 'F');
            }

            


            $rapprel->save();
            return response()->json(['success' => "Firma del $request->amministratore inserita con successo"], 200);

        }
        else
        {
            if($request->amministratore == 'responsabile')
            {
                $rapprel->firmaResponsabile = 0;

                $file = Storage::disk("public")->path("rapporti_relazioni/".$rapprel->file);
                $outputFilePath = Storage::disk("public")->path("rapporti_relazioni/".$rapprel->file);

                $fpdi = new FPDI;
                $count = $fpdi->setSourceFile($file);
        
                for ($i=1; $i<=$count; $i++) {
        
                    $template = $fpdi->importPage($i);
                    $size = $fpdi->getTemplateSize($template);
                    $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
                    $fpdi->useTemplate($template);

                    if($i == $count)
                    {
                        $fpdi->Image(Storage::disk('public')->path("/firme/annulla_firma.png"), 110, 190, 70);
                    }
                }
        
                $fpdi->Output($outputFilePath, 'F');
            }
            else
            {
                $rapprel->firmaDirettore = 0;

                $file = Storage::disk("public")->path("rapporti_relazioni/".$rapprel->file);
                $outputFilePath = Storage::disk("public")->path("rapporti_relazioni/".$rapprel->file);

                $fpdi = new FPDI;
                $count = $fpdi->setSourceFile($file);
        
                for ($i=1; $i<=$count; $i++) {
        
                    $template = $fpdi->importPage($i);
                    $size = $fpdi->getTemplateSize($template);
                    $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
                    $fpdi->useTemplate($template);

                    if($i == $count)
                    {
                        $fpdi->Image(Storage::disk('public')->path("/firme/annulla_firma.png"), 40, 190, 50);
                    }
                }
        
                $fpdi->Output($outputFilePath, 'F');
            }

            $rapprel->save();
            return response()->json(['success' => "Firma del $request->amministratore eliminata con successo"], 200);
        }
    }

    /**
     * Crea una nuova revisione del rapporto di prova
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    public static function creaRev(Request $request)
    {
        //prendo il rapporto di prova
        $rapprel = RapportoRelazione::find($request->id_rdp);
        if($rapprel == null)
        {
            return response()->json(['error' => 'Rapporto di prova non trovato'], 404);
        }

        //creo la nuova correzione
        $rapprel_new = new RapportoRelazione;
        if($rapprel->id_rapporto_rev == null)
        {
            $rapprel_new->id_rapporto_rev = $rapprel->id;
        }
        else
        {
            $rapprel_new->id_rapporto_rev = $rapprel->id_rapporto_rev;
        }

        //verifico quanti record hanno come id_rapporto_rev l'id del rapporto di prova
        if($rapprel->id_rapporto_rev == null)
        {
            $count = RapportoRelazione::where('id_rapporto_rev', $rapprel->id)->count();
        }
        else
        {
            $count = RapportoRelazione::where('id_rapporto_rev', $rapprel->id_rapporto_rev)->count();
        }
        $numero_di_correzione = $count + 1;
        $rapprel_new->rev = $numero_di_correzione;
        
        //assegno tutte le info del vecchio rapporto di prova al nuovo
        $rapprel_new->tipo = $rapprel->tipo;
        $rapprel_new->id_progetto = $rapprel->id_progetto;
        $rapprel_new->ospedale = $rapprel->ospedale;
        $rapprel_new->id_reparto = $rapprel->id_reparto;
        $rapprel_new->id_areapartizione = $rapprel->id_areapartizione;
        $rapprel_new->dataCampagna = $rapprel->dataCampagna;
        $rapprel_new->data_approvazione = null;
        $rapprel_new->data_comunicazione = null;
        $rapprel_new->committente = $rapprel->committente;
        $rapprel_new->firmaDirettore = null;
        $rapprel_new->firmaResponsabile = null;
        $rapprel_new->note = null;
        $rapprel_new->id_utente_genera_rapporto = auth()->user()->id;
        $rapprel_new->data_generazione = Carbon::now()->format('Y-m-d');
        $rapprel_new->bloccato = 0;
        $rapprel_new->approvato = 0;
        $rapprel_new->versione = 2;

        //prendo il file del vecchio rapporto di prova
        $file = Storage::disk("public")->path("rapporti_relazioni/".$rapprel->file);

        $array_file = explode('_', $rapprel->file);
        if($numero_di_correzione == 1)
        {
            $array_file[3] = $array_file[3].'-0'.$rapprel_new->rev;
        }
        else
        {
            $numero_da_correggere = explode('-', $array_file[3]);
            $numero_da_correggere[1] = '0'.$numero_di_correzione;
            $array_file[3] = implode('-', $numero_da_correggere);
        }
        $new_file = implode('_', $array_file);

        //save the new file
        Storage::disk("public")->put("rapporti_relazioni/".$new_file, file_get_contents($file));
        $rapprel_new->file = $new_file;
        //salvo il nuovo rapporto di prova
        $rapprel_new->save();

        $rdp_anteprime = RdpAnteprima::where('id_rapprel', $rapprel->id)->first();
        if($rdp_anteprime != null)
        {
            $rdp_anteprime_new = new RdpAnteprima;
            $rdp_anteprime_new = $rdp_anteprime->replicate();
            $rdp_anteprime_new->id_rapprel = $rapprel_new->id;
            $rdp_anteprime_new->save();
        }
        $nota_anteprima = NotaCampionamentoRdpAnteprima::where('id_rdp', $rapprel->id)->get();
        if($nota_anteprima != null || count($nota_anteprima) > 0)
        {
            foreach($nota_anteprima as $nota)
            {
                $nota_new = new NotaCampionamentoRdpAnteprima;
                $nota_new = $nota->replicate();
                $nota_new->id_rdp = $rapprel_new->id;
                $nota_new->save();
            }
        }

        //sblocco tutti i campioni associati al vecchio rapporto di prova
        $campioni_rdp = RappRelCampioni::join('campioni','campioni.id','=','rapprel_campioni.id_campione')
                                    ->where('id_rapprel', $rapprel->id)->get();

        $ids = [];
        if(count($campioni_rdp) > 0)
        {
            foreach($campioni_rdp as $campione)
            {
                $ids[] = ['id' => $campione->id_campione]; 
            }
        }

        if(count($ids) > 0)
        {
            Campione::whereIn('id', $ids)->update(['bloccato' => 0]);
        }

        $filename = explode('/', $rapprel->file)[count(explode('/', $rapprel->file)) - 1];
        LoggerEvent::log(auth()->user()->id,"Sbloccati tutti i campioni relativi al rapporto di prova $filename in seguito alla richiesta di correzione del documento",$ids,false,null,$rapprel->id);
        LoggerEvent::log(auth()->user()->id,"generata correzione numero $rapprel_new->rev del rapporto di prova $filename",$request->all(),false,null,$rapprel->id);

        //return route index
        return redirect()->route('rapportirelazioni');
    }
   
}
