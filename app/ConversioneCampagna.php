<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConversioneCampagna extends Model
{
    /**
     * @var string
     */
    protected $table = 'conversione_campagna';

    protected $fillable = [
        'campagnaV1',
        'campagnaV2',
    ];

    public function campagnaV2($campagnaV1)
    {
        return $this->where('campagnaV1', $campagnaV1)->first()->campagnaV2;
    }

    public function campagnaV1($campagnaV2)
    {
        return $this->where('campagnaV2', $campagnaV2)->first()->campagnaV1;
    }
}
