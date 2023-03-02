<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * [MicroSuPiastraSwab]
 */
class MicroSuPiastraSwab extends Model
{
    /**
     * @var string
     */
    protected $table = 'micro_su_piastre_analisi_molecolari';

    /**
     * @var array
     */
    protected $fillable = [
        'id_microrganismo',
        'id_campione',
        'id_tipopiastra',
        'presente',
        'created_at',
        'updated_at'
    ];

    /**
     * @var string
     */
    public function microrganismo()
    {
        return $this->belongsTo('App\MicrorganismoPiastra', 'id_microrganismo');
    }

    /**
     * @return Campione
     */
    public function campione()
    {
        return $this->belongsTo('App\Campione', 'id_campione');
    }

    /**
     * @return TipoPiastra
     */
    public function tipopiastra()
    {
        return $this->belongsTo('App\TipoPiastra', 'id_tipopiastra');
    }
}
