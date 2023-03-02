<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRdpAnteprimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rdp_anteprima', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_rapprel');
            $table->string('n_rdp')->nullable();
            $table->string('nome_cliente')->nullable();
            $table->string('indirizzo_cliente')->nullable();
            $table->string('indirizzo_struttura')->nullable();
            $table->string('struttura_partizione')->nullable();
            $table->string('verbale_campionamento')->nullable();
            $table->string('struttura_indirizzo')->nullable();
            $table->string('dispositivo_di_campionamento_1')->nullable();
            $table->string('dispositivo_di_campionamento_2')->nullable();
            $table->string('tipo_di_campionamento')->nullable();
            $table->string('portata')->nullable();
            $table->string('volume_campionato')->nullable();
            $table->string('tipo_di_substrato_pca_1')->nullable();
            $table->string('tipo_di_substrato_dg18_1')->nullable();
            $table->string('condizioni_durata_pca_1')->nullable();
            $table->string('condizioni_durata_dg18_1')->nullable();
            $table->string('descrizione_punto_pca_1')->nullable();
            $table->string('descrizione_punto_dg18_1')->nullable();
            $table->string('n_prelievi_pca_1')->nullable();
            $table->string('n_prelievi_dg18_1')->nullable();
            $table->string('descrizione_punto_pca_2')->nullable();
            $table->string('descrizione_punto_dg18_2')->nullable();
            $table->string('n_prelievi_pca_2')->nullable();
            $table->string('n_prelievi_dg18_2')->nullable();
            $table->string('note_pagina2_1')->nullable();
            $table->string('note_pagina2_2')->nullable();
            $table->string('area_di_campionamento')->nullable();
            $table->string('tipo_di_substrato_pca_2')->nullable();
            $table->string('tipo_di_substrato_dg18_2')->nullable();
            $table->string('condizioni_durata_pca_2')->nullable();
            $table->string('condizioni_durata_dg18_2')->nullable();
            $table->string('descrizione_punto_pca_3')->nullable();
            $table->string('descrizione_punto_dg18_3')->nullable();
            $table->string('n_prelievi_pca_3')->nullable();
            $table->string('n_prelievi_dg18_3')->nullable();
            $table->string('descrizione_punto_pca_4')->nullable();
            $table->string('descrizione_punto_dg18_4')->nullable();
            $table->string('n_prelievi_pca_4')->nullable();
            $table->string('n_prelievi_dg18_4')->nullable();
            $table->string('note_pagina2_3')->nullable();
            $table->string('note_pagina2_4')->nullable();
            $table->string('incaricati_del_campionamento')->nullable();
            $table->date('data_campionamento')->nullable();
            $table->integer('inizio_campionamento_strum')->nullable();
            $table->integer('inizio_attivita_in_loco_strum')->nullable();
            $table->integer('fine_attivita_in_loco_strum')->nullable();
            $table->integer('fine_campionamento_strum')->nullable();
            $table->date('data_accettazione')->nullable();
            $table->string('dataOraPartenza')->nullable();
            $table->string('dataOraInizio')->nullable();
            $table->string('dataOraFine')->nullable();
            $table->string('dataOraArrivo')->nullable();
            $table->string('superano')->nullable();
            $table->string('lineeguida1')->nullable();
            $table->string('lineeguida2')->nullable();
            $table->string('esito')->nullable();
            $table->string('campione_esito')->nullable();
            $table->string('no_incertezza')->nullable();
            $table->string('opinioni_ed_interpretazioni_lineeguida')->nullable();
            $table->string('opinioni_ed_interpretazioni')->nullable();
            $table->string('note_di_revisione')->nullable();
            $table->boolean('riferimento1')->nullable();
            $table->boolean('riferimento2')->nullable();
            $table->boolean('riferimento3')->nullable();
            $table->boolean('riferimento4')->nullable();
            $table->boolean('riferimento5')->nullable();
            $table->boolean('riferimento6')->nullable();
            $table->boolean('riferimento7')->nullable();
            $table->boolean('riferimento7_table1')->nullable();
            $table->boolean('riferimento7_table2')->nullable();
            $table->boolean('riferimento8')->nullable();
            $table->boolean('riferimento8_indicazione1')->nullable();
            $table->boolean('riferimento8_indicazione2')->nullable();
            $table->boolean('riferimento8_indicazione3')->nullable();
            $table->boolean('riferimento8_indicazione4')->nullable();
            $table->string('riferimento8_portata')->nullable();
            $table->boolean('firmaDirettore')->nullable();
            $table->boolean('firmaResponsabile')->nullable();
            $table->boolean('committente')->nullable();
            $table->string('modulo_accettazione')->nullable();
            $table->date('data_campionamento_inizio_committente')->nullable();
            $table->date('data_campionamento_fine_committente')->nullable();
            $table->date('data_inizio_committente')->nullable();
            $table->date('data_fine_committente')->nullable();
            $table->time('ora_inizio_committente')->nullable();
            $table->time('ora_fine_committente')->nullable();
            $table->string('temperatura')->nullable();
            $table->enum('stato_materiale',['integro','non integro'])->nullable();
            $table->date('data_accettazione_committente')->nullable();
            $table->string('valutazione_committente_note')->nullable();
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
        Schema::dropIfExists('rdp_anteprima');
    }
}