<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConversioneRappRel extends Model
{
    /**
     * @var string
     */
    protected $table = 'conversione_rapp_rel';

    protected $fillable = [
        'rapprelV1',
        'rapprelV2',
    ];

    public function rapprelV2($rapprelV1)
    {
        return $this->where('rapprelV1', $rapprelV1)->first()->rapprelV2;
    }

    public function rapprelV1($rapprelV2)
    {
        return $this->where('rapprelV2', $rapprelV2)->first()->rapprelV1;
    }
}
