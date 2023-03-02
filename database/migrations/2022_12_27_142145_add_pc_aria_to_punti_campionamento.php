<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\PuntoCampionamento;

class AddPcAriaToPuntiCampionamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * @var array
         */
        $pCampAria = [
            1 => 'Diffusore/Plafone',
            2 => 'Centro stanza',
            3 => 'Gravitazionale passivo',
            //4 => 'Pass-box'
        ];

        /**
         * @var array
         */
        $codici_pCampAria = [
            'Diffusore/Plafone' => 'SASB',
            'Centro stanza' => 'SASC',
            'Gravitazionale passivo' => 'GRP',
            //'Pass-box' => 'PBX'
        ];

        foreach ($pCampAria as $key => $pcA) {
            $puntoCampionamento = new PuntoCampionamento;
            
            $puntoCampionamento->punto_campionamento = $pcA;
            $puntoCampionamento->codPC = $codici_pCampAria[$pcA];
            $puntoCampionamento->id_categoria = 5;
            $puntoCampionamento->matrice = 'A';
            $puntoCampionamento->versione = 2;
            $puntoCampionamento->save();
        }

       DB::statement("UPDATE `ENVASSV2`.`punti_campionamento` SET `matrice` = 'E' WHERE (`id` = '134')");
       DB::statement("UPDATE `ENVASSV2`.`punti_campionamento` SET `matrice` = 'E' WHERE (`id` = '135')");
       DB::statement("UPDATE `ENVASSV2`.`punti_campionamento` SET `matrice` = 'E' WHERE (`id` = '146')");
       DB::statement("UPDATE `ENVASSV2`.`punti_campionamento` SET `matrice` = 'E' WHERE (`id` = '159')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         /**
         * @var array
         */
        $pCampAria = [
            1 => 'Diffusore/Plafone',
            2 => 'Centro stanza',
            3 => 'Gravitazionale passivo',
            //4 => 'Pass-box'
        ];

        foreach ($pCampAria as $key => $pcA) {
            $puntoCampionamento = PuntoCampionamento::where('punto_campionamento', $pcA)->first();
            $puntoCampionamento->delete();
        }

        DB::statement("UPDATE `ENVASSV2`.`punti_campionamento` SET `matrice` = 'S' WHERE (`id` = '134')");
        DB::statement("UPDATE `ENVASSV2`.`punti_campionamento` SET `matrice` = 'S' WHERE (`id` = '135')");
        DB::statement("UPDATE `ENVASSV2`.`punti_campionamento` SET `matrice` = 'S' WHERE (`id` = '146')");
        DB::statement("UPDATE `ENVASSV2`.`punti_campionamento` SET `matrice` = 'S' WHERE (`id` = '159')");
    }
}
