<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ConversioneAbbreviazioneTipiPiastre extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'conversione_abbreviazione_tipi_piastre';

    protected $fillable = [
        'abbreviazioneV1',
        'abbreviazioneV2',
        'created_at',
        'updated_at',
    ];

    public static function abbreviazioneV1($id)
    {
        return ConversioneAbbreviazioneTipiPiastre::where('abbreviazioneV1', $id)->first() != null ? ConversioneAbbreviazioneTipiPiastre::where('abbreviazioneV1', $id)->first()->id : null;
    }

    public static function abbreviazioneV2($id)
    {
        return ConversioneAbbreviazioneTipiPiastre::where('abbreviazioneV2', $id)->first() != null ? ConversioneAbbreviazioneTipiPiastre::where('abbreviazioneV2', $id)->first()->id : null;
    }
}
