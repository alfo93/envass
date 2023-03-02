<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaCampionamentoRdpAnteprima extends Model
{
    /**
     * @var string
     */
    protected $table = 'note_campionamento_rdp_anteprima';

    protected $fillable = [
        'id',
        'id_rdp_anteprima',
        'id_rdp',
        'tipo_di_ambiente',
        'numero_e_codifica_locali',
        'codice_partizione_stanza',
        'class_iso_di_riferimento',
        'tipo_di_flusso',
        'note_pagina3',
        'stato_di_occupazione_aria_at_rest',
        'data_di_campionamento_ora_inizio_e_fine_aria_at_rest_data',
        'data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraI',
        'data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraF',
        'data_di_campionamento_ora_inizio_e_fine_aria_operat_data',
        'data_di_campionamento_ora_inizio_e_fine_aria_operat_oraI',
        'data_di_campionamento_ora_inizio_e_fine_aria_operat_oraF',
        'data_di_campionamento_ora_inizio_e_fine_superfici_data',
        'data_di_campionamento_ora_inizio_e_fine_superfici_oraI',
        'data_di_campionamento_ora_inizio_e_fine_superfici_oraF',
        'strum_n_aria_at_rest1',
        'strum_n_aria_at_rest2',
        'strum_n_aria_at_rest3',
        'strum_n_aria_operat1',
        'strum_n_aria_operat2',
        'strum_n_aria_operat3',
        'n_persone_presenti_aria_at_rest',
        'stato_porte_aria_at_rest',
        'campionamento_effettuato_da_aria_at_rest',
        'note_pagina3_aria_at_rest',
        'stato_di_occupazione_aria_operat',
        'data_di_campionamento_ora_inizio_e_fine_aria_operat',
        'n_persone_presenti_aria_operat',
        'stato_porte_aria_operat',
        'tipo_di_operazione',
        'campionamento_effettuato_da_aria_operat',
        'note_pagina3_aria_operat',
        'stato_di_occupazione_superfici',
        'data_di_campionamento_ora_inizio_e_fine_superfici',
        'n_persone_presenti_superfici',
        'stato_porte_superfici',
        'campionamento_effettuato_da_superfici',
        'note_pagina3_superfici'
    ];

    
}
