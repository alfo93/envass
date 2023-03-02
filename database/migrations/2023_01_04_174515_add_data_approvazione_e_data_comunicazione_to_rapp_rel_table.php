<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataApprovazioneEDataComunicazioneToRappRelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rapp_rel', function (Blueprint $table) {
            $table->date('data_approvazione')->after('dataCampagna')->nullable();
            $table->date('data_comunicazione')->after('data_approvazione')->nullable();
            $table->boolean('approvato')->after('bloccato')->default(0);
            $table->unsignedBigInteger('id_utente_genera_rapporto')->after('note')->nullable();
            $table->foreign('id_utente_genera_rapporto')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rapp_rel', function (Blueprint $table) {
            $table->dropColumn('data_approvazione');
            $table->dropColumn('data_comunicazione');
            $table->dropColumn('approvato');
            $table->dropForeign('rapp_rel_id_utente_genera_rapporto_foreign');
            $table->dropColumn('id_utente_genera_rapporto');
        });
    }
}
