<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBloccatoToCampioni extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campioni', function (Blueprint $table) {
            $table->boolean('bloccato')->after('tipoTest')->default(0);
        });

        Schema::table('campioni_analisi_molecolari', function (Blueprint $table) {
            $table->boolean('bloccato')->after('tipo_scheda')->default(0);
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
            $table->dropColumn('bloccato');
        });

        Schema::table('campioni_analisi_molecolari', function (Blueprint $table) {
            $table->dropColumn('bloccato');
        });
    }
}
