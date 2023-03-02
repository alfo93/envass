<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * [MicroPiastra]
 */
class MicroPiastra extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'micro_piastre';

    protected $fillable = [
        'id_microrganismo',
        'id_piastra',
        'created_at',
        'updated_at'
    ];

    /**
     * @return MicrorganismoPiastra
     */
    public function microrganismo() {
        return $this->belongsTo('App\MicrorganismoPiastra','id_microrganismo');
    }

    /**
     * @return TipoPiastra
     */
    public function piastra() {
        return $this->belongsTo('App\TipoPiastra','id_piastra');
    }
}
