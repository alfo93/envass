<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * [StruttRep]
 */
class StruttRep extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'strutture_reparti_envass';

    /**
     * @var array
     */
    protected $fillable = [
        'id_struttura',
        'id_reparto',
        'id_progetto',
        'id_associazione',
        'versione',
        'created_at',
        'updated_at'
    ];


    /**
     * @return Struttura
     */
    public function struttura()
    {
        return $this->belongsTo('App\Struttura', 'id_struttura');
    }

    /**
     * @return Reparto
     */
    public function reparto()
    {
        return $this->belongsTo('App\Reparto', 'id_reparto');
    }

    /**
     * @return Progetto
     */
    public function progetto()
    {
        return $this->belongsTo('App\Progetto', 'id_progetto');
    }

    /**
     * @return Associazione
     */
    public function associazione()
    {
        return $this->belongsTo('App\AreaPartizione', 'id_associazione');
    }


    
}
