<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdMetodoToCampioneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campioni', function (Blueprint $table) {
            $table->unsignedBigInteger('id_metodo')->after('procedura')->nullable();
        });

        Schema::table('campioni_analisi_molecolari', function (Blueprint $table) {
            $table->unsignedBigInteger('id_metodo')->after('id_protocollo')->nullable();
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
            $table->dropColumn('id_metodo');
        });

        Schema::table('campioni_analisi_molecolari', function (Blueprint $table) {
            $table->dropColumn('id_metodo');
        });
    }
}
