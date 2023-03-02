<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConversioneRepartoPartizioneArea extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'conversione_reparto_partizionearea';

    protected $fillable = [
        'partizioneV1',
        'partizioneV2',
        'area_partizione'
    ];

    public function partizioneV2($partizioneV1)
    {
        return $this->where('partizioneV1', $partizioneV1)->first()->partizioneV2;
    }

    public function partizioneV1($partizioneV2)
    {
        return $this->where('partizioneV2', $partizioneV2)->first()->partizioneV1;
    }
}
