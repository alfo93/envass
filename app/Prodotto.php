<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * [Prodotto]
 */
class Prodotto extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'prodotti';

    protected $fillable = [
        'prodotto',
        'created_at',
        'updated_at'
    ];
}
