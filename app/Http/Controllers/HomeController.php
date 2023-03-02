<?php

namespace App\Http\Controllers;

use App\Progetto;
use App\Campione;
use App\Societa;
use App\Campagna;
use Carbon\Carbon;
use App\Rilevatore;
use App\ConversioneProgetto;
use App\User;
use Defender;
use Log;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Smisto il traffico degli utenti
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Log::info(auth()->user()->id);
        $userRole = User::join('role_user', 'users.id', '=', 'role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id');

        $userRole = $userRole->where('users.versione',2)->where('role_user.user_id', '=', auth()->user()->id)->first();
        // Log::info($userRole);
        $role = $userRole->name;
        if(\Artesaos\Defender\Facades\Defender::hasRole('admin') || \Artesaos\Defender\Facades\Defender::hasRole('gestore'))
        {
            $campioni = Campione::all();
            $n_campioni = count($campioni);

            $progetti = Progetto::where('versione',2)->get();
            $n_progetti = count($progetti);

            //$n_campagne = count(Campagna::all());
            
            $campioni_progetti = collect([]);
            foreach (Progetto::all() as $p) {
                $nome_progetto = $p->progetto;
                $totale = Progetto::join('campioni','progetti.id','=','campioni.id_progetto')
                                                    ->where('progetti.id',$p->id)
                                                    ->whereNull('progetti.deleted_at')
                                                    ->count(); 
                
                $campioni_progetti->push(['nome_progetto' => $nome_progetto, 'totale' => $totale]);
            }
            
            $societa_progetti = collect([]);
            foreach (Societa::all() as $s) {
                $nome_societa = $s->nome;
                $totale = Societa::join('progetti','societa.id','=','progetti.id_societa')
                                                    ->where('societa.id',$s->id)
                                                    ->whereNull('progetti.deleted_at')
                                                    ->where('progetti.versione',2)
                                                    ->count(); 
                
                $societa_progetti->push(['nome_societa' => $nome_societa, 'tot_progetti' => $totale]);
            }
            
            /**
             * Rapporto campionamenti anni a confronto
             */
            $anno_attuale = Campione::where('dataCampagna', '>', Carbon::now()->startOfYear()->format('Y-m-d'))
                            ->where('dataCampagna', '<=', Carbon::now()->format('Y-m-d'))
                            ->select(DB::raw('count(id) as totale, month(dataCampagna) as mesi'))
                            ->groupBy('mesi')
                            ->orderBy('mesi', 'ASC')
                            ->get(['totale','mesi']);

            $anno_precedente = Campione::where('dataCampagna', '>', Carbon::now()->startOfYear()->subMonths(12)->format('Y-m-d'))
                            ->where('dataCampagna', '<=', Carbon::now()->subMonths(12)->format('Y-m-d'))
                            ->select(DB::raw('count(id) as totale, month(dataCampagna) as mesi'))
                            ->groupBy('mesi')
                            ->orderBy('mesi', 'ASC')
                            ->get(['totale','mesi']);

            $rilevatori_campioni = collect([]);
            foreach (Rilevatore::all() as $r) {
                $nome = $r->rilevatore;
                $interno = $r->interno;
                $tot_rilevatore_normali = Rilevatore::join('campioni_rilevatori','rilevatori.id','=','campioni_rilevatori.id_rilevatore')
                                                ->where('rilevatori.id',$r->id)
                                                ->whereNull('rilevatori.deleted_at')
                                                ->count();
                $tot_rilevatore_molecolari = Rilevatore::join('campioni_rilevatori_analisi_molecolari','rilevatori.id','=','campioni_rilevatori_analisi_molecolari.id_rilevatore')
                                                ->where('rilevatori.id',$r->id)
                                                ->whereNull('rilevatori.deleted_at')
                                                ->count();
                $tot_rilevatore = $tot_rilevatore_normali + $tot_rilevatore_molecolari;

                $rilevatori_campioni->push(['nome' => $nome, 'tot_rilevatore' => $tot_rilevatore, 'interno' => $interno]);
            }
            

            $palette_colori = [
                0 => 'rgba(13, 208, 251, 1)',
                1 => 'rgba(11, 227, 126, 1)',
                2 => 'rgba(224, 227, 11, 1)',
                3 => 'rgba(62, 250, 25, 1)',
                4 => 'rgba(255, 215, 84, 1)',
                5 => 'rgba(227, 119, 57, 1)',
                6 => 'rgba(251, 198, 63, 1)',
                7 => 'rgba(250, 75, 98, 1)',
                8 => 'rgba(178, 57, 227, 1)',
                9 => 'rgba(43, 53, 255, 1)',
                10 => 'rgba(130, 153, 174, 1)',
                11 => 'rgba(50, 153, 250, 1)',
                12 => 'rgba(250, 84, 75, 1)',
                13 => 'rgba(238, 250, 100, 1)',
                14 => 'rgba(173, 42, 35, 1)',
                15 => 'rgba(250, 144, 87, 1)',
                16 => 'rgba(133, 250, 100, 1)',
                17 => 'rgba(250, 84, 75, 1)',
                18 => 'rgba(50, 250, 241, 1)',
                19 => 'rgba(250, 62, 215, 1)',
            ];
            
        }
        if(\Artesaos\Defender\Facades\Defender::hasRole('committente') || \Artesaos\Defender\Facades\Defender::hasRole('utente'))
        {
            $campioni_old = Campione::where('id_progetto',ConversioneProgetto::progettoV1(auth()->user()->progetto))->get();
            $campioni_new = Campione::where('id_progetto',auth()->user()->progetto)->get();
            $campioni = $campioni_old->merge($campioni_new);
            $n_campioni = count($campioni);

            $progetti = Progetto::where('id',ConversioneProgetto::progettoV2(auth()->user()->progetto) ?? auth()->user()->progetto)->where('versione',2)->get();
            $n_progetti = count($progetti);
            
            $id_progetti = Array();
            foreach ($progetti as $p) {
                array_push($id_progetti,$p->id);
            }
            // $campagne = Campione::join('campagna','campagna.id','=','campioni.id_campagna')
            //                     ->join('progetti','progetti.id','=','campioni.id_progetto');

            // foreach ($id_progetti as $p) {
            //     $campagne = $campagne->orWhere('progetti.id',$p);
            // }
            // $campagne = $campagne->select(['campagna.*','campioni.id','campioni.dataCampagna','progetti.id','progetti.progetto'])->groupBy('campioni.dataCampagna')->get();

            // $n_campagne = count($campagne);

            $campioni_progetti = Array();
            /**
             * Campioni dopo la conversione
             */
            for ($i=0; $i < count($id_progetti) ; $i++) { 
                $cp = DB::select(DB::raw("SELECT count(campioni.id) as totale, progetti.progetto as nome_progetto
                                            FROM ENVASSV2.campioni, ENVASSV2.progetti
                                            where campioni.id_progetto = progetti.id
                                            and progetti.id = $id_progetti[$i]
                                            and progetti.deleted_at = null
                                            group by progetti.id;"));
                array_push($campioni_progetti,$cp);
            }

            /**
             * Campioni prima della conversione
             */
            for ($i=0; $i < count($id_progetti) ; $i++) { 
                $id_progetto_v1 = ConversioneProgetto::progettoV1($id_progetti[$i]);
                $cp = DB::select(DB::raw("SELECT count(campioni.id) as totale, progetti.progetto as nome_progetto
                                            FROM ENVASSV2.campioni, ENVASSV2.progetti
                                            where campioni.id_progetto = progetti.id
                                            and progetti.id = $id_progetto_v1
                                            and progetti.deleted_at = null
                                            group by progetti.id;"));
                array_push($campioni_progetti,$cp);
            }
            
            $societa_progetti = Array();
            /**
             * Società dopo la conversione
             */
            for ($i=0; $i < count($id_progetti) ; $i++) { 
                $sp = DB::select(DB::raw("SELECT count(progetti.id) as tot_progetti, societa.nome as nome_societa 
                                            FROM ENVASSV2.societa, ENVASSV2.progetti
                                            where societa.id = progetti.id_societa
                                            and progetti.id = $id_progetti[$i]
                                            group by societa.nome;"));
                array_push($societa_progetti,$sp);
            }

            /**
             * Societa prima della conversione
             */
            for ($i=0; $i < count($id_progetti) ; $i++) { 
                $id_progetto_v1 = ConversioneProgetto::progettoV1($id_progetti[$i]);
                $sp = DB::select(DB::raw("SELECT count(progetti.id) as tot_progetti, societa.nome as nome_societa 
                                            FROM ENVASSV2.societa, ENVASSV2.progetti
                                            where societa.id = progetti.id_societa
                                            and progetti.id = $id_progetto_v1
                                            group by societa.nome;"));
                array_push($societa_progetti,$sp);
            }
        
            /**
             * Rapporto campionamenti anni a confronto
             */
            /**
             * ANNO ATTUALE
             * Versione 2 */
            $anno_attuale = Campione::join('progetti','campioni.id_progetto','=','progetti.id')
                                    ->where('dataCampagna', '>', Carbon::now()->startOfYear()->format('Y-m-d'))
                                    ->where('dataCampagna', '<=', Carbon::now()->format('Y-m-d'))
                                    ->where('progetti.id',$id_progetti[0] ?? '')
                                    ->whereNull('progetti.deleted_at');
            
            for ($i=1; $i < count($id_progetti); $i++) { 
                $anno_attuale = $anno_attuale->orWhere('progetti.id',$id_progetti[$i] ?? '');
            }
            
            $anno_attuale = $anno_attuale->select(DB::raw('count(campioni.id) as totale, month(campioni.dataCampagna) as mesi'))
                                        ->groupBy('mesi')
                                        ->orderBy('mesi', 'ASC')
                                        ->get(['totale','mesi']);
                                        

            /**
             * ANNO ATTUALE
             * Versione 1 */

            $anno_attualeV1 = Campione::join('progetti','campioni.id_progetto','=','progetti.id')
                                    ->where('dataCampagna', '>', Carbon::now()->startOfYear()->format('Y-m-d'))
                                    ->where('dataCampagna', '<=', Carbon::now()->format('Y-m-d'))
                                    ->where('progetti.id',ConversioneProgetto::progettoV1($id_progetti[0]) ?? '')
                                    ->whereNull('progetti.deleted_at');
            
            for ($i=1; $i < count($id_progetti); $i++) { 
                $anno_attualeV1 = $anno_attualeV1->orWhere('progetti.id',ConversioneProgetto::progettoV1($id_progetti[$i]) ?? '');
            }
            
            $anno_attualeV1 = $anno_attualeV1->select(DB::raw('count(campioni.id) as totale, month(campioni.dataCampagna) as mesi'))
                                        ->groupBy('mesi')
                                        ->orderBy('mesi', 'ASC')
                                        ->get(['totale','mesi']);

            /**Unione V1 - V2 */

            $anno_attuale = $anno_attuale->union($anno_attualeV1);
            
            /**
             * ANNO PRECEDENTE
             * Versione 2 */
            $anno_precedente = Campione::join('progetti','campioni.id_progetto','=','progetti.id')
                                        ->where('dataCampagna', '>', Carbon::now()->startOfYear()->subMonths(12)->format('Y-m-d'))
                                        ->where('dataCampagna', '<=', Carbon::now()->subMonths(12)->format('Y-m-d'))
                                        ->where('progetti.id',$id_progetti[0] ?? '')
                                        ->whereNull('deleted_at');
            
            for ($i=1; $i < count($id_progetti); $i++) { 
                $anno_precedente = $anno_precedente->orWhere('progetti.id',$id_progetti[$i] ?? '');
            }
          
            $anno_precedente = $anno_precedente->select(DB::raw('count(campioni.id) as totale, month(campioni.dataCampagna) as mesi'))
                            ->groupBy('mesi')
                            ->orderBy('mesi', 'ASC')
                            ->get(['totale','mesi']);

            /**
             * ANNO PRECEDENTE
             * Versione 1 */
            $anno_precedenteV1 = Campione::join('progetti','campioni.id_progetto','=','progetti.id')
                                        ->where('dataCampagna', '>', Carbon::now()->startOfYear()->subMonths(12)->format('Y-m-d'))
                                        ->where('dataCampagna', '<=', Carbon::now()->subMonths(12)->format('Y-m-d'))
                                        ->where('progetti.id',ConversioneProgetto::progettoV1($id_progetti[0]))
                                        ->whereNull('deleted_at');
            
            // for ($i=1; $i < count($id_progetti); $i++) { 
            //     $anno_precedenteV1 = $anno_precedenteV1->orWhere('progetti.id',ConversioneProgetto::progettoV1($id_progetti[$i]));
            // }
          
            $anno_precedenteV1 = $anno_precedenteV1->select(DB::raw('count(campioni.id) as totale, month(campioni.dataCampagna) as mesi'))
                            ->groupBy('mesi')
                            ->orderBy('mesi', 'ASC')
                            ->get(['totale','mesi']);
            /**UNIONE V1-V2 */
            $anno_precedente = $anno_precedente->merge($anno_precedenteV1);
            
            $rilevatori_campioni = Array();
            for ($i=0; $i < count($id_progetti) ; $i++) { 
                $rc = DB::select(DB::raw("SELECT count(campioni.id) as tot_rilevatore, rilevatori.rilevatore as nome, rilevatori.interno as interno 
                                                            FROM ENVASSV2.rilevatori, ENVASSV2.campioni, ENVASSV2.campioni_rilevatori, ENVASSV2.progetti as p
                                                            where campioni.id = campioni_rilevatori.id_campione and rilevatori.id = campioni_rilevatori.id_rilevatore
                                                            and rilevatori.deleted_at = null
                                                            and p.id = campioni.id_progetto
                                                            and p.id = $id_progetti[$i]
                                                            group by rilevatori.rilevatore;"));
                array_push($rilevatori_campioni,$rc);
            }

            $palette_colori = [
                0 => 'rgba(13, 208, 251, 1)',
                1 => 'rgba(11, 227, 126, 1)',
                2 => 'rgba(224, 227, 11, 1)',
                3 => 'rgba(62, 250, 25, 1)',
                4 => 'rgba(255, 215, 84, 1)',
                5 => 'rgba(227, 119, 57, 1)',
                6 => 'rgba(251, 198, 63, 1)',
                7 => 'rgba(250, 75, 98, 1)',
                8 => 'rgba(178, 57, 227, 1)',
                9 => 'rgba(43, 53, 255, 1)',
                10 => 'rgba(130, 153, 174, 1)',
                11 => 'rgba(50, 153, 250, 1)',
                12 => 'rgba(250, 84, 75, 1)',
                13 => 'rgba(238, 250, 100, 1)',
                14 => 'rgba(173, 42, 35, 1)',
                15 => 'rgba(250, 144, 87, 1)',
                16 => 'rgba(133, 250, 100, 1)',
                17 => 'rgba(250, 84, 75, 1)',
                18 => 'rgba(50, 250, 241, 1)',
                19 => 'rgba(250, 62, 215, 1)',
            ];
        }
        return view('home', compact('n_campioni','n_progetti','campioni_progetti','societa_progetti','anno_attuale','anno_precedente','rilevatori_campioni','palette_colori','role'));

    }
    
    /**
     * Mostra la pagina di saluto.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function bye()
    {
        return view('bye');
    }
}
