<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMicrorganismo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('INSERT INTO `ENVASSV2`.`microrganismi_piastre` (`id`, `microrganismo`, `batGramN`, `batGramP`, `entBac`, `colif`, `id_microrganismo_SANICA`, `gruppo`, `created_at`, `updated_at`) VALUES (\'100\', \'Nessuno\', \'0\', \'0\', \'0\', \'0\', \'-1\', \'-1\', \'2022-01-28\', \'2022-01-28\');');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DELETE FROM `ENVASSV2`.`microrganismi_piastre` WHERE (`id` = \'100\');');
    }
}
