<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanimetrieRdpAnteprimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planimetrie_rdp_anteprima', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_rdp');
            $table->bigInteger('id_rdp_anteprima');
            $table->string('planimetria');
            $table->string('caption');
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
        Schema::dropIfExists('planimetrie_rdp_anteprima');
    }
}
