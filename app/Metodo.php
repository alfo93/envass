<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metodo extends Model
{
    /**
     * @var string
     */
    protected $table = 'metodi';

    protected $fillable = [
        'metodo',
        'descrizione_prova',
        'tempo_incubazione',
        'condizione_incubazione',
        'id_tipo_piastra',
        'incertezza',
        'created_at',
        'updated_at'
    ];

     /**
     * @var array
     */
    public static $t_inc = [
        24 => 24,
        48 => 48,
        72 => 72,
        120 => 'da 120 a 168'
    ];

    /**
     * @var array 
     */
    public static $condizione_incubazione = [
        25,
        30,
        37
    ];


     /**
     * @return Array Tempo di incubazione
     */
    public static function get_tInc()
    {
        return self::$t_inc;
    }

    /**
     * @return Array Condizione di incubazione
     */
    public static function get_condizioneIncubazione()
    {
        return self::$condizione_incubazione;
    }
}
