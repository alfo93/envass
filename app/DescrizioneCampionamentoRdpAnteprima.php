<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescrizioneCampionamentoRdpAnteprima extends Model
{
    /**
     * @var string
     */
    protected $table = 'descrizione_campionamento_anteprima';

    protected $fillable = [
        'id',
        'id_rdp',
        'id_rdp_anteprima',
        'id_campione',
        'aria',
        'superficie',
        'pca',
        'dg18',
        'at_rest',
        'operat',
        'attivo',
        'passivo',
        'stanza',
        'valori_riferimento',
        'created_at',
        'updated_at'
    ];
}
