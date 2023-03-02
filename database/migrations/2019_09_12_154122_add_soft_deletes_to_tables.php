<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('antibiotici', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('materiali', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('microrganismi_piastre', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('categorie', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('prodotti', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('protocolli', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('punti_campionamento', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('strutture', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('reparti', function (Blueprint $table) {
            $table->softDeletes();
        });
        // Schema::table('stanze', function (Blueprint $table) {
        //     $table->softDeletes();
        // });
        Schema::table('tipi_piastre', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('strutture_reparti_envass', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('micro_piastre', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('rilevatori', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('progetti', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('societa', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('eprocedure', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('rapp_rel', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('immagini', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('immagini_analisi_molecolari', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('immagini_microantibiogrammi', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('immagini_microantibiogrammi_analisi_molecolari', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        /**Tabelle di conversione */
        Schema::table('conversione_abbreviazione_tipi_piastre', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('conversione_categoria_categorie', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('conversione_materiale', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('conversione_partizione_reparti', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('conversione_progetto', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('conversione_punto_campionamento_punti_campionamento', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('conversione_reparto_partizionearea', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('conversione_struttura_strutture', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('conversione_strutture_reparti_envass', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('conversione_users', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('area_partizione', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('antibiotici', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('materiali', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('microrganismi_piastre', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('categorie', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('prodotti', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('protocolli', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('punti_campionamento', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('strutture', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('reparti', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::table('stanze', function (Blueprint $table) {
        //     $table->dropSoftDeletes();
        // });
        Schema::table('tipi_piastre', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('strutture_reparti_envass', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('micro_piastre', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('rilevatori', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('progetti', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('societa', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('eprocedure', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('rapp_rel', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('immagini', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('immagini_analisi_molecolari', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('immagini_microantibiogrammi', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('immagini_microantibiogrammi_analisi_molecolari', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        /**Tabelle di conversione */
        Schema::table('conversione_abbreviazione_tipi_piastre', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('conversione_categoria_categorie', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('conversione_materiale', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('conversione_partizione_reparti', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('conversione_progetto', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('conversione_punto_campionamento_punti_campionamento', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('conversione_reparto_partizionearea', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('conversione_struttura_strutture', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('conversione_strutture_reparti_envass', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('conversione_users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('area_partizione', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
