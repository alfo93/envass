<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * [Description Materiale]
 */
class Materiale extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'materiali';

    protected $fillable = [
        'materiale',
        'sigla',
        'versione',
        'created_at',
        'updated_at'
    ];
}
