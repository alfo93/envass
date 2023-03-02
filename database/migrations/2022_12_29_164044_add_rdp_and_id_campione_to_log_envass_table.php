<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRdpAndIdCampioneToLogEnvassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_envass', function (Blueprint $table) {
            $table->unsignedBigInteger('id_campione')->after('id_utente')->nullable();
            $table->unsignedBigInteger('rdp')->after('id_campione')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_envass', function (Blueprint $table) {
            $table->dropColumn('rdp');
            $table->dropColumn('id_campione');
        });
    }
}
