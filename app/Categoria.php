<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * [Categoria]
 */
class Categoria extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'categorie';

    protected $fillable = [
        'categoria',
        'versione',
        'created_at',
        'updated_at'
    ];
}
