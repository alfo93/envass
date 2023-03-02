<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoteCampionamentoRdpAnteprimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_campionamento_rdp_anteprima', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_rdp_anteprima');
            $table->bigInteger('id_rdp');
            $table->integer('numero_colonna');
            $table->string('tipo_di_ambiente')->nullable();
            $table->string('numero_e_codifica_locali')->nullable();
            $table->string('codice_partizione_stanza')->nullable();
            $table->string('class_iso_di_riferimento')->nullable();
            $table->string('tipo_di_flusso')->nullable();
            $table->string('note_pagina3')->nullable();
            $table->string('stato_di_occupazione_aria_at_rest')->nullable();
            $table->string('data_di_campionamento_ora_inizio_e_fine_aria_at_rest_data')->nullable();
            $table->string('data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraI')->nullable();
            $table->string('data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraF')->nullable();
            $table->string('data_di_campionamento_ora_inizio_e_fine_aria_operat_data')->nullable();
            $table->string('data_di_campionamento_ora_inizio_e_fine_aria_operat_oraI')->nullable();
            $table->string('data_di_campionamento_ora_inizio_e_fine_aria_operat_oraF')->nullable();
            $table->string('data_di_campionamento_ora_inizio_e_fine_superfici_data')->nullable();
            $table->string('data_di_campionamento_ora_inizio_e_fine_superfici_oraI')->nullable();
            $table->string('data_di_campionamento_ora_inizio_e_fine_superfici_oraF')->nullable();
            $table->string('n_persone_presenti_aria_at_rest')->nullable();
            $table->string('stato_porte_aria_at_rest')->nullable();
            $table->string('strum_n_aria_at_rest1')->nullable();
            $table->string('strum_n_aria_at_rest2')->nullable();
            $table->string('strum_n_aria_at_rest3')->nullable();
            $table->string('campionamento_effettuato_da_aria_at_rest')->nullable();
            $table->string('note_pagina3_aria_at_rest')->nullable();
            $table->string('stato_di_occupazione_aria_operat')->nullable();
            $table->string('data_di_campionamento_ora_inizio_e_fine_aria_operat')->nullable();
            $table->string('strum_n_aria_operat1')->nullable();
            $table->string('strum_n_aria_operat2')->nullable();
            $table->string('strum_n_aria_operat3')->nullable();
            $table->string('n_persone_presenti_aria_operat')->nullable();
            $table->string('stato_porte_aria_operat')->nullable();
            $table->string('tipo_di_operazione')->nullable();
            $table->string('campionamento_effettuato_da_aria_operat')->nullable();
            $table->string('note_pagina3_aria_operat')->nullable();
            $table->string('stato_di_occupazione_superfici')->nullable();
            $table->string('data_di_campionamento_ora_inizio_e_fine_superfici')->nullable();
            $table->string('n_persone_presenti_superfici')->nullable();
            $table->string('stato_porte_superfici')->nullable();
            $table->string('campionamento_effettuato_da_superfici')->nullable();
            $table->string('note_pagina3_superfici')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('note_campionamento_rdp_anteprima');
    }
}
