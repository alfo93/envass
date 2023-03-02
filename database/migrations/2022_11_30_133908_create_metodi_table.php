<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetodiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metodi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('metodo');
            $table->string('descrizione_prova');
            $table->integer('tempo_incubazione');
            $table->integer('condizione_incubazione');
            $table->unsignedBigInteger('id_tipo_piastra');
            $table->string('tipo_campionamento');
            $table->float('incertezza');
            $table->timestamps();

            $table->foreign('id_tipo_piastra')->references('id')->on('tipi_piastre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metodi');
    }
}
