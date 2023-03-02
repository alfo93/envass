<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * [sMicroAntibiogramma]
 */
class MicroAntibiogramma extends Model
{
    protected $table = 'microantibiogrammi';

    protected $fillable = [
        'NAB',
        'id_campione',
        'id_microrganismo',
        'colonia',
    ];

    /**
     * @return Campione
     */
    public function campione()
    {
        return $this->belongsTo('App\Campione', 'id_campione');
    }

    /**
     * @return MicrorganismoPiastra
     */
    public function microrganismo()
    {
        return $this->belongsTo('App\MicrorganismoPiastra', 'id_microrganismo');
    }
}
