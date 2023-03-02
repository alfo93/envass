<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescrizioneCampionamentoAnteprimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descrizione_campionamento_anteprima', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_rdp');
            $table->bigInteger('id_rdp_anteprima');
            $table->bigInteger('id_campione');
            $table->boolean('aria')->default(0);
            $table->boolean('superficie')->default(0);
            $table->boolean('pca')->default(0);
            $table->boolean('dg18')->default(0);
            $table->boolean('at_rest')->default(0);
            $table->boolean('operat')->default(0);
            $table->boolean('attivo')->default(0);
            $table->boolean('passivo')->default(0);
            $table->string('stanza')->nullable();
            $table->integer('valori_riferimento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('descrizione_campionamento_anteprima');
    }
}
