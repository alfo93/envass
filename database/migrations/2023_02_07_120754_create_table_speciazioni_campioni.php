<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSpeciazioniCampioni extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('speciazioni_campioni', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_campione');
            $table->unsignedBigInteger('id_microrganismo');
            $table->unsignedBigInteger('id_tipopiastra');
            $table->unsignedBigInteger('id_punto_camp');
            $table->string('tipoCamp');
            $table->enum('esito',['NA','NR','R'])->default('NA');

            $table->foreign('id_campione')->references('id')->on('campioni')->onDelete('cascade');
            $table->foreign('id_microrganismo')->references('id')->on('microrganismi_piastre')->onDelete('cascade');
            $table->foreign('id_tipopiastra')->references('id')->on('tipi_piastre')->onDelete('cascade');
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
        Schema::dropIfExists('speciazioni_campioni');
    }
}
