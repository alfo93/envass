<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaPartizione extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'area_partizione';

    protected $fillable = [
        'id_reparto',
        'area_partizione',
        'codice_area_partizione',
        'versione',
        'created_at',
        'updated_at'
    ];
}
