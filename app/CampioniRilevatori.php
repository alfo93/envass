<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * [CampioniRilevatori]
 */
class CampioniRilevatori extends Model
{
    /**
     * @var string
     */
    protected $table = 'campioni_rilevatori';

    protected $fillable = [
        'id_campione',
        'id_rilevatore',
        'created_at',
        'updated_at'
    ];

    /**
     * @return Campione
     */
    public function campione()
    {
        return $this->belongsTo('App\Campione', 'id_campione');
    }

    /**
     * @return Rilevatore
     */
    public function rilevatore()
    {
        return $this->belongsTo('App\Rilevatore', 'id_rilevatore');
    }

}
