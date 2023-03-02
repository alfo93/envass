<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConversioneCodProProgetto extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'conversione_codpro_progetto';

    protected $fillable = [
        'CodProV1',
        'CodProV2',
    ];

    public function CodProV2($CodProV1)
    {
        return $this->where('CodProV1', $CodProV1)->first()->CodProV2;
    }

    public function CodProV1($CodProV2)
    {
        return $this->where('CodProV2', $CodProV2)->first()->CodProV1;
    }
}
