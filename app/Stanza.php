<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * [Stanza]
 */
class Stanza extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'stanze';

    /**
     * @var array
     */
    protected $fillable = [
        'stanza',
        'created_at',
        'updated_at'
    ];
}
