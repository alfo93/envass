<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFirmeToRdp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rapp_rel', function (Blueprint $table) {
            $table->boolean('firmaDirettore')->nullable()->default(0)->after('committente');
            $table->boolean('firmaResponsabile')->nullable()->default(0)->after('firmaDirettore');
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
            $table->dropColumn('firmaDirettore');
            $table->dropColumn('firmaResponsabile');
        });
    }
}
