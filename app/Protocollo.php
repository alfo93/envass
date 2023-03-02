<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * [Protocollo]
 */
class Protocollo extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'protocolli';

    protected $fillable = [
        'protocollo',
        'created_at',
        'updated_at'
    ];
}
