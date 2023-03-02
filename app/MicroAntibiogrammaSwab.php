<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * [MicroAntibiogrammaSwab]
 */
class MicroAntibiogrammaSwab extends Model
{
    /**
     * @var string
     */
    protected $table = 'microantibiogrammi_analisi_molecolari';

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
        return $this->belongsTo('App\CampioneAnalisiMolecolare', 'id_campione');
    }

    /**
     * @return MicrorganismoPiastra
     */
    public function microrganismo()
    {
        return $this->belongsTo('App\MicrorganismoPiastra', 'id_microrganismo');
    }
}
