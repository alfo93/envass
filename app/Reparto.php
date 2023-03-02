<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * [Reparto]
 */
class Reparto extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'reparti';

    protected $fillable = [

        'partizione',
        'codice_partizione',
        'versione',
        'created_at',
        'updated_at'
        
    ];

    public static function partizioneV2($id)
    {
        return ConversionePartizioneReparti::where('partizioneV1', $id)->first() ? ConversionePartizioneReparti::where('partizioneV1', $id)->first()->partizioneV2 : null;
    }
}
