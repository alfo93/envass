<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertTipipiastreCampioniToVersion2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $conv_tipi_piastre = App\ConversioneAbbreviazioneTipiPiastre::all();
        foreach ($conv_tipi_piastre as $ctp) {
            DB::statement('UPDATE campioni SET id_tipo_piastra = ' . $ctp->abbreviazioneV2 . ' WHERE id_tipo_piastra = ' . $ctp->abbreviazioneV1);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $conv_tipi_piastre = App\ConversioneAbbreviazioneTipiPiastre::all();
        foreach ($conv_tipi_piastre as $ctp) {
            DB::statement('UPDATE campioni SET id_tipo_piastra = ' . $ctp->abbreviazioneV1 . ' WHERE id_tipo_piastra = ' . $ctp->abbreviazioneV2);
        }
    }
}
