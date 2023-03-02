<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRapprelCampioni extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapprel_campioni', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_rapprel');
            $table->unsignedBigInteger('id_campione');
            $table->foreign('id_rapprel')->references('id')->on('rapp_rel')->onDelete('cascade');
            $table->foreign('id_campione')->references('id')->on('campioni')->onDelete('cascade');
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
        Schema::dropIfExists('rapprel_campioni');
    }
}
