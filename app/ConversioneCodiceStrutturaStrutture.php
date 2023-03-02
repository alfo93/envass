<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConversioneCodiceStrutturaStrutture extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'conversione_codice_struttura_strutture';

    protected $fillable = [
        'codiceV1',
        'codiceV2',
    ];

    public function codiceV2($codiceV1)
    {
        return $this->where('codiceV1', $codiceV1)->first()->codiceV2;
    }

    public function codiceV1($codiceV2)
    {
        return $this->where('codiceV2', $codiceV2)->first()->codiceV1;
    }
}
