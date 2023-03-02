<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIncertezzaToMicroSuPiastreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('micro_su_piastre', function (Blueprint $table) {
            $table->float('incertezzaSx')->after('CFU')->nullable()->default(null);
            $table->float('incertezzaDx')->after('incertezzaSx')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('micro_su_piastre', function (Blueprint $table) {
            $table->dropColumn('incertezzaSx');
            $table->dropColumn('incertezzaDx');
        });
    }
}
