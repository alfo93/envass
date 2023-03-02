<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConversioneStrutturaStrutture extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'conversione_struttura_strutture';

    protected $fillable = [
        'strutturaV1',
        'strutturaV2',
    ];

    public static function strutturaV2($strutturaV1)
    {
        return ConversioneStrutturaStrutture::where('strutturaV1', $strutturaV1)->first() != null ? ConversioneStrutturaStrutture::where('strutturaV1', $strutturaV1)->first()->strutturaV2 : null;
    }
    

    public static function strutturaV1($strutturaV2)
    {
        return ConversioneStrutturaStrutture::where('strutturaV2', $strutturaV2)->first() != null ? ConversioneStrutturaStrutture::where('strutturaV2', $strutturaV2)->first()->strutturaV1 : null;
    }
}
