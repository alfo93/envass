<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIncertezzaAndSpeciazioneToCampioniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campioni', function (Blueprint $table) {
            $table->boolean('incertezza')->after('bloccato')->default(0);
            $table->boolean('speciazione')->after('incertezza')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campioni', function (Blueprint $table) {
            $table->dropColumn('incertezza');
            $table->dropColumn('speciazione');
        });
    }
}
