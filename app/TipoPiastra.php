<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * [TipoPiastra]
 */
class TipoPiastra extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'tipi_piastre';

    /**
     * @var array
     */
    protected $fillable = [
        'piastra',
        'superficie',
        'tipo',
        'abbreviazione',
        'versione',
        'created_at',
        'updated_at'
    ];
}
