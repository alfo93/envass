<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RdpAnteprima extends Model
{
     /**
     * @var string
     */
    protected $table = 'rdp_anteprima';

    protected $fillable = [
        'id',
        'id_rapprel',
        'id_campagna',
        'n_rdp',
        'nome_cliente',
        'indirizzo_cliente',
        'indirizzo_struttura',
        'struttura_partizione',
        'verbale_campionamento',
        'struttura_indirizzo',
        'dispositivo_di_campionamento_1',
        'dispositivo_di_campionamento_2',
        'tipo_di_campionamento',
        'portata',
        'volume_campionato',
        'tipo_di_substrato_pca_1',
        'tipo_di_substrato_dg18_1',
        'condizioni_durata_pca_1',
        'condizioni_durata_dg18_1',
        'descrizione_punto_pca_1',
        'descrizione_punto_dg18_1',
        'n_prelievi_pca_1',
        'n_prelievi_dg18_1',
        'descrizione_punto_pca_2',
        'descrizione_punto_dg18_2',
        'n_prelievi_pca_2',
        'n_prelievi_dg18_2',
        'note_pagina2_1',
        'note_pagina2_2',
        'area_di_campionamento',
        'tipo_di_substrato_pca_2',
        'tipo_di_substrato_dg18_2',
        'condizioni_durata_pca_2',
        'condizioni_durata_dg18_2',
        'descrizione_punto_pca_3',
        'descrizione_punto_dg18_3',
        'n_prelievi_pca_3',
        'n_prelievi_dg18_3',
        'descrizione_punto_pca_4',
        'descrizione_punto_dg18_4',
        'n_prelievi_pca_4',
        'n_prelievi_dg18_4',
        'note_pagina2_3',
        'note_pagina2_4',
        'incaricati_del_campionamento',
        'data_campionamento',
        'inizio_campionamento_strum',
        'inizio_attivita_in_loco_strum',
        'fine_attivita_in_loco_strum',
        'fine_campionamento_strum',
        'data_accettazione',
        'dataOraPartenza',
        'dataOraInizio',
        'dataOraFine',
        'dataOraArrivo',
        'superano',
        'lineeguida1',
        'lineeguida2',
        'esito',
        'campione_esito',
        'no_incertezza',
        'opinioni_ed_interpretazioni',
        'opinioni_ed_interpretazioni_lineeguida',
        'note_di_revisione',
        'riferimento1',
        'riferimento2',
        'riferimento3',
        'riferimento4',
        'riferimento5',
        'riferimento6',
        'riferimento7',
        'riferimento7_table1',
        'riferimento7_table2',
        'riferimento8',
        'riferimento8_indicazione1',
        'riferimento8_indicazione2',
        'riferimento8_indicazione3',
        'riferimento8_indicazione4',
        'riferimento8_portata',
        'firmaDirettore',
        'firmaResponsabile',
        'committente'
    ];
}