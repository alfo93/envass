<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * [AntibioticoAntibiogrammaSwab]
 */
class AntibioticoAntibiogrammaSwab extends Model
{
    /**
     * @var string
     */
    protected $table = 'antibiotici_antibiogrammi_analisi_molecolari';

    protected $fillable = [
        'id_antibiotico',
        'id_campione_analisi_molecolare',
        'NAB',
        'resistenza',
        'created_at',
        'updated_at'
    ];

    const resistenza = [
        '1' => 'Resistente',
        '2' => 'Intermedio',
        '3' => 'Sensibile'
    ];

    /**
     * @return Antibiotico
     */
    public function antibiotico()
    {
        return $this->belongsTo('App\Antibiotico', 'id_antibiotico');
    }

    /**
     * @return Campione
     */
    public function campione()
    {
        return $this->belongsTo('App\Campione', 'id_campione');
    }

    /**
     * @return Array
     */
    public static function resistenza()
    {
        return self::$resistenza;
    }
}
