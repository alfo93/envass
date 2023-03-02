<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStanzeToStanzaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stanze', function (Blueprint $table) {
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Degenza")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Sala operatoria")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Laboratorio")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Magazzini")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Corridoio")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Bagno")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Bagno degenza")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Sala attesa")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Ambulatorio")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Ortopedia")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Ginecologia")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Sala Parto")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Degenza Day Ospital")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Oculistica")');
            // // DB::statement('INSERT INTO stanze (stanza) VALUES ("Deposito")');
            // // DB::statement('INSERT INTO stanze (stanza) VALUES ("Locale Bussola")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Sala Osservazione")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Ristoro")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Ambulatorio sospetti")');
            // // DB::statement('INSERT INTO stanze (stanza) VALUES ("Corridoio")');
            // DB::statement('INSERT INTO stanze (stanza) VALUES ("Vagone")');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stanze', function (Blueprint $table) {
            // DB::statement('DELETE FROM stanze');
        });
    }
}
