<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * [MicrorganismoPiastra]
 */
class MicrorganismoPiastra extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'microrganismi_piastre';

    protected $fillable = [
        'microrganismo',
        'batGramN',
        'batGramP',
        'entBac',
        'colif',
        'id_microrganismo_SANICA',
        'gruppo',
        'created_at',
        'updated_at'
    ];

    /**
     * @param mixed $number
     * @param mixed $decimals
     * 
     * @return Float $number
     */
    public function toFixed($number, $decimals) {
        return number_format($number, $decimals, '.', "");
    }
}
