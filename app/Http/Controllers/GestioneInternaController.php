<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Antibiotico;
use App\Categoria;
//use App\EProcedure;
use App\Materiale;
use App\Prodotto;
use App\Protocollo;
use App\PuntoCampionamento;
use App\Reparto;
// use App\Stanza;
use App\Struttura;
use App\TipoPiastra;
use App\MicrorganismoPiastra;
use App\Progetto;
use App\StruttRep;
use App\MicroPiastra;
use Log;

class GestioneInternaController extends Controller
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
        $progetti = Progetto::orderBy('progetto','ASC')->where('progetti.versione',2)->get();
        $antibiotici = Antibiotico::orderBy('nome','ASC')->get();
        $categorie = Categoria::orderBy('categoria','ASC')->where('categorie.versione',2)->get();
        $microrganismi = MicrorganismoPiastra::orderBy('microrganismo','ASC')->get();
        $materiali = Materiale::orderBy('materiale','ASC')->where('materiali.versione',2)->get();
        $prodotti = Prodotto::orderBy('prodotto','ASC')->get();
        $protocolli = Protocollo::orderBy('protocollo','ASC')->get();
        $punticampionamento = PuntoCampionamento::join('categorie','categorie.id','=','punti_campionamento.id_categoria')->select('punti_campionamento.id','punto_campionamento','id_categoria','codPC','matrice','categorie.categoria')->where('categorie.versione',2)->where('punti_campionamento.versione',2)->orderBy('punto_campionamento','ASC')->get();
        $reparti = Reparto::orderBy('partizione','ASC')->where('versione',2)->get();
        // $stanze = Stanza::orderBy('stanza','ASC')->get();
        $strutture = Struttura::orderBy('struttura','ASC')->where('versione',2)->get();
        $tipopiastra = TipoPiastra::orderBy('piastra','ASC')->where('versione',2)->get();

        $microPiastra = MicroPiastra::join('microrganismi_piastre','micro_piastre.id_microrganismo','=','microrganismi_piastre.id')
                                    ->join('tipi_piastre','tipi_piastre.id','=','micro_piastre.id_piastra')
                                    ->where('micro_piastre.versione',2)
                                    ->where('tipi_piastre.versione',2)
                                    ->select(['micro_piastre.id as id',
                                                'micro_piastre.id_microrganismo as id_microrganismo',
                                                'micro_piastre.id_piastra as id_piastra',
                                                'microrganismi_piastre.microrganismo as nome_microrganismo',
                                                'microrganismi_piastre.id as microrganismo_id',
                                                'tipi_piastre.piastra as nome_piastra',
                                                'tipi_piastre.id as piastra_id'
                                            ])->orderBy('tipi_piastre.piastra','ASC')->get();
                                    
            
        $struttrep = Progetto::join('strutture_reparti_envass','progetti.id','=','strutture_reparti_envass.id_progetto')
                                ->join('strutture','strutture.id','=','strutture_reparti_envass.id_struttura')
                                ->join('area_partizione','area_partizione.id','=','strutture_reparti_envass.id_associazione')
                                ->where('strutture_reparti_envass.versione',2)
                                ->whereNull('strutture_reparti_envass.deleted_at')
                                ->orderBy('progetti.progetto','ASC');
                                
        $struttrep = $struttrep->join('reparti','reparti.id','=','area_partizione.id_reparto')
                                ->select('strutture_reparti_envass.*','area_partizione.id_reparto as id_reparto','reparti.partizione as reparto','strutture.struttura as struttura','progetti.progetto as progetto')
                                ->get();
                                                        

        
        return view('gestione_interna.gestione_interna',compact('antibiotici','categorie','materiali','prodotti','protocolli','punticampionamento','reparti','strutture','tipopiastra','microrganismi','struttrep','progetti','microPiastra'));
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

    /**
     * Retrieve the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getId(Request $request)
    {
        $elemento = $request->div;

        if($elemento == null)
        {
            $message = "Selezionare un elemento corretto";
            return response()->json(['message' => $message]);
        }

        $dati = $elemento == "strutture" ? Struttura::where('struttura',$request->item)->where('versione',2)->first() : Reparto::where('partizione',$request->item)->where('versione',2)->first();
        
        return json_encode(['id'=>$dati->id]);
    }
}
