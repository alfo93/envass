<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMotivoToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('antibiotici', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('nome');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        Schema::table('materiali', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('materiale');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        Schema::table('microrganismi_piastre', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('gruppo');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        Schema::table('categorie', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('categoria');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        Schema::table('prodotti', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('prodotto');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        Schema::table('protocolli', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('protocollo');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        Schema::table('punti_campionamento', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('punto_campionamento');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        Schema::table('strutture', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('codice_provincia');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        Schema::table('reparti', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('codice_partizione');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        // Schema::table('stanze', function (Blueprint $table) {
        //     $table->string('motivo', 255)->nullable()->after('stanza');
        //     $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        // });
        Schema::table('tipi_piastre', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('abbreviazione');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        Schema::table('strutture_reparti_envass', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('id_progetto');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        Schema::table('micro_piastre', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('id_piastra');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        Schema::table('rilevatori', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('interno');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        Schema::table('progetti', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('attivo');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        Schema::table('societa', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('email');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        Schema::table('eprocedure', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('id_progetto');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        Schema::table('rapp_rel', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('note');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('motivo', 255)->nullable()->after('rememberToken');
            $table->unsignedBigInteger('id_utente_cancella')->nullable()->after('motivo');
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
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        Schema::table('materiali', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        Schema::table('microrganismi_piastre', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        Schema::table('categorie', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        Schema::table('prodotti', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        Schema::table('protocolli', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        Schema::table('punti_campionamento', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        Schema::table('strutture', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        Schema::table('reparti', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        // Schema::table('stanze', function (Blueprint $table) {
        //     $table->dropColumn('motivo');
        //     $table->dropColumn('id_utente_cancella');
        // });
        Schema::table('tipi_piastre', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        Schema::table('strutture_reparti_envass', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        Schema::table('micro_piastre', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        Schema::table('rilevatori', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        Schema::table('progetti', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        Schema::table('societa', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        Schema::table('eprocedure', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        Schema::table('rapp_rel', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->dropColumn('id_utente_cancella');
        });
    }
}
