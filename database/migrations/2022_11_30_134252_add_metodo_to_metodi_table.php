<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Metodo;

class AddMetodoToMetodiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $metodo = new Metodo;
        $metodo->metodo = 'ISO 14698-1:2003 App. A + UNI EN ISO 4833-2:2022';
        $metodo->descrizione_prova = 'conta di microrganismi a 30 °C in aria di camera bianche ed ambienti controllati e associati';
        $metodo->tempo_incubazione = 72; #72H
        $metodo->condizione_incubazione = 30; #30 °C
        $metodo->id_tipo_piastra = 26; #PCA
        $metodo->tipo_campionamento = 'A'; #Aria
        $metodo->incertezza = 0.27;
        $metodo->save();

        $metodo = new Metodo;
        $metodo->metodo = 'ISO 14698-1:2003 App. A + ISO 21527-2:2008';
        $metodo->descrizione_prova = 'conta di lieviti e muffe in aria di camera bianche ed ambienti controllati e associati';
        $metodo->tempo_incubazione = 120; #120H
        $metodo->condizione_incubazione = 25; #25 °C
        $metodo->id_tipo_piastra = 27; #DG18
        $metodo->tipo_campionamento = 'A'; #Aria
        $metodo->incertezza = 0.87;
        $metodo->save();

        $metodo = new Metodo;
        $metodo->metodo = 'UNI EN 13098:2019 + UNI EN ISO 4833-2:2022';
        $metodo->descrizione_prova = 'conta dei microrganismi a 30 °C in aria di ambienti di lavoro e ambienti di vita';
        $metodo->tempo_incubazione = 72; #72H
        $metodo->condizione_incubazione = 30; #30 °C
        $metodo->id_tipo_piastra = 26; #PCA
        $metodo->tipo_campionamento = 'A'; #Aria
        $metodo->incertezza = 0.41;
        $metodo->save();

        $metodo = new Metodo;
        $metodo->metodo = 'UNI EN 13098:2019 + ISO 21527-2:2008';
        $metodo->descrizione_prova = 'conta dei lieviti e muffe in aria di ambienti di lavoro e ambienti di vita';
        $metodo->tempo_incubazione = 120; #120H
        $metodo->condizione_incubazione = 25; #25 °C
        $metodo->id_tipo_piastra = 27; #DG18
        $metodo->tipo_campionamento = 'A'; #Aria
        $metodo->incertezza = 0.46;
        $metodo->save();

        $metodo = new Metodo;
        $metodo->metodo = 'ISO 14698-1:2003 App. C + UNI EN ISO 4833-2:2022';
        $metodo->descrizione_prova = 'conta di microrganismi a 30 °C in superfici di camera bianche ed ambienti controllati e associati';
        $metodo->tempo_incubazione = 72; #72H
        $metodo->condizione_incubazione = 30; #30 °C
        $metodo->id_tipo_piastra = 26; #PCA
        $metodo->tipo_campionamento = 'S'; #Superficie
        $metodo->incertezza = 0.25;
        $metodo->save();

        $metodo = new Metodo;
        $metodo->metodo = 'ISO 14698-1:2003 App. C + ISO 21527-2:2008';
        $metodo->descrizione_prova = 'conta di lieviti e muffe in superfici di camera bianche ed ambienti controllati e associati';
        $metodo->tempo_incubazione = 120; #120H
        $metodo->condizione_incubazione = 25; #25 °C
        $metodo->id_tipo_piastra = 27; #DG18
        $metodo->tipo_campionamento = 'S'; #Superficie
        $metodo->incertezza = 0.17;
        $metodo->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("TRUNCATE metodi");
    }
}
