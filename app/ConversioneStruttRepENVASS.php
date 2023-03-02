<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConversioneStruttRepENVASS extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'conversione_strutture_reparti_envass';

    protected $fillable = [
        'struttureRepartiV1',
        'struttureRepartiV2',
    ];

    public function struttureRepartiV2($struttureRepartiV1)
    {
        return $this->where('struttureRepartiV1', $struttureRepartiV1)->first()->struttureRepartiV2;
    }

    public function struttureRepartiV1($struttureRepartiV2)
    {
        return $this->where('struttureRepartiV2', $struttureRepartiV2)->first()->struttureRepartiV1;
    }
}
