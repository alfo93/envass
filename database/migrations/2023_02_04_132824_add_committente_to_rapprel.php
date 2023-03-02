<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommittenteToRapprel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rapp_rel', function (Blueprint $table) {
            $table->boolean('committente')->nullable()->after('file')->default(0);
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
            $table->dropColumn('committente');
        });
    }
}
