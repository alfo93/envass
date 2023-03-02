<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRevToRappRel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rapp_rel', function (Blueprint $table) {
            $table->integer('rev')->nullable()->default(0)->after('note');
            $table->bigInteger('id_rapporto_rev')->nullable()->default(null)->after('rev');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rapp_rel', function (Blueprint $table) {
            $table->dropColumn('rev');
            $table->dropColumn('id_rapporto_rev');
        });
    }
}
