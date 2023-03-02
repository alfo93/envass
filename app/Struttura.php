<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use StruttRep;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * [Struttura]
 */
class Struttura extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'strutture';

    /**
     * @var array
     */
    protected $fillable = [

        'struttura',
        'sede',
        'provincia',
        'codice_struttura',
        'codice_sede',
        'codice_provincia',
        'versione',
        'id_struttura_SANICA',
        'created_at',
        'updated_at'
        
    ];


    public static function strutturaV2($id)
    {
        return ConversioneStrutturaStrutture::where('strutturaV1', $id)->first() ?  ConversioneStrutturaStrutture::where('strutturaV1', $id)->first()->strutturaV2 : null;
    }

}
