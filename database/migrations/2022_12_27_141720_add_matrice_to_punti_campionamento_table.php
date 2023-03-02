<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMatriceToPuntiCampionamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('punti_campionamento', function (Blueprint $table) {
            $table->enum('matrice',['S','A','E'])->default('S')->after('codPC');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('punti_campionamento', function (Blueprint $table) {
            $table->dropColumn('matrice');
        });
    }
}
