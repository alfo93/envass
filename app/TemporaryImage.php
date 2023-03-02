<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * [TemporaryImage]
 */
class TemporaryImage extends Model
{
    /**
     * @var string
     */
    protected $table = 'temporary_image';

    /**
     * @var array
     */
    protected $fillable = [

        'nome_file',
        'path_file',
        'created_at',
        'updated_at'
        
    ];
}
