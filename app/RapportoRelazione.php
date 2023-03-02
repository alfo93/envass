<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * [RapportoRelazione]
 */
class RapportoRelazione extends Model
{
    /**
     * @var string
     */
    protected $table = 'rapp_rel';

    protected $fillable = [

        'tipo',
        'id_progetto',
        'ospedale',
        'id_reparto',
        'dataCampagna',
        'file',
        'note',
        'versione',
        'created_at',
        'updated_at'
        
    ];

    /**
     * @var Progetto
     */
    public function progetto()
    {
        return $this->belongsTo('App\Progetto', 'id_progetto');
    }

    /**
     * @var Reparto
     */
    public function reparto()
    {
        return $this->belongsTo('App\Reparto', 'id_reparto');
    }

    /**
     * @return Struttura
     */
    public function struttura()
    {
        return $this->belongsTo('App\Struttura','ospedale');
    }
    
}
