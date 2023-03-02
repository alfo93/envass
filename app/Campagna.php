<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * [Campagna]
 */
class Campagna extends Model
{
    /**
     * @var string
     */
    protected $table = 'campagna';

    protected $fillable = [
        'id_societa',
        'id_progetto',
        'id_areareparto',
        'id_struttura',
        'dataCampagna',
        'versione'
    ];

    /**
     * @return Struttura
     */
    public function struttura()
    {
        return $this->belongsTo('App\Struttura', 'id_struttura');
    }

    /**
     * @return Societa
     */
    public function societa()
    {
        return $this->belongsTo('App\Societa', 'id_societa');
    }

     /**
     * @return Progetto
     */
    public function progetto()
    {
        return $this->belongsTo('App\Progetto', 'id_progetto');
    }
}


