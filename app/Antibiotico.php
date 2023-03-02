<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * [Antibiotico]
 */

class Antibiotico extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'antibiotici';

    protected $fillable = [
        'nome',
        'created_at',
        'updated_at'
    ];

    const resistenza = [
        '1' => 'Resistente',
        '2' => 'Intermedio',
        '3' => 'Sensibile'
    ];

    /**
     * @return Array
     */
    public static function resistenza()
    {
        return self::resistenza;
    }
}
