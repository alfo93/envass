<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * [CampioniRilevatoriSWAB]
 */
class CampioniRilevatoriSWAB extends Model
{
    /**
     * @var string
     */
    protected $table = 'campioni_rilevatori_analisi_molecolari';

    protected $fillable = [
        'id_campione_swab',
        'id_rilevatore',
        'created_at',
        'updated_at'
    ];

    /**
     * @return Campione
     */
    public function campione()
    {
        return $this->belongsTo('App\CampioneAnalisiMolecolare', 'id_campione');
    }

    /**
     * @return Rilevatore
     */
    public function rilevatore()
    {
        return $this->belongsTo('App\Rilevatore', 'id_rilevatore');
    }
}
