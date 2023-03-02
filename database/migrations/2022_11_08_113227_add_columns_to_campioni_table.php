<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCampioniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campioni', function (Blueprint $table) {
            $table->date('data_accettazione')->after('dataCampagna')->nullable()->default(null);
            $table->integer('condizione_incubazione')->after('t_inc')->nullable()->default(null);
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
            $table->dropColumn('data_accettazione');
            $table->dropColumn('condizione_incubazione');
        });
    }
}
