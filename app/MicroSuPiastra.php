<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * [MicroSuPiastra]
 */
class MicroSuPiastra extends Model
{
    /**
     * @var string
     */
    protected $table = 'micro_su_piastre';

    protected $fillable = [
        'id_microrganismo',
        'id_campione',
        'id_tipopiastra',
        'CFU',
        'created_at',
        'updated_at'
    ];

    /**
     * @return MicrorganismoPiastra
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

    /**
     * @param mixed $number
     * @param mixed $decimals
     * 
     * @return Float $numbers
     */
    public function toFixed($number, $decimals) {
        return number_format($number, $decimals, '.', "");
    }
}
