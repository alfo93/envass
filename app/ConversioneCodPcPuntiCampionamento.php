<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConversioneCodPcPuntiCampionamento extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'conversione_codpc_punti_campionamento';

    protected $fillable = [
        'codPCV1',
        'codPCV2',
    ];

    public function codPCV2($codPCV1)
    {
        return $this->where('codPCV1', $codPCV1)->first()->codPCV2;
    }

    public function codPCV1($codPCV2)
    {
        return $this->where('codPCV2', $codPCV2)->first()->codPCV1;
    }
}
