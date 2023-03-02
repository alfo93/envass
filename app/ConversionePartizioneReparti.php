<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConversionePartizioneReparti extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'conversione_partizione_reparti';

    protected $fillable = [
        'partizioneV1',
        'partizioneV2',
    ];

    public static function partizioneV2($partizioneV1)
    {
        return ConversionePartizioneReparti::where('partizioneV1', $partizioneV1)->first()->partizioneV2 ?? null;
    }

    public static function partizioneV1($partizioneV2)
    {
        return ConversionePartizioneReparti::where('partizioneV2', $partizioneV2)->first()->partizioneV1 ?? null;
    }
}
