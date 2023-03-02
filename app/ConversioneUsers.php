<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConversioneUsers extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'conversione_users';

    protected $fillable = [
        'userV1',
        'userV2',
    ];

    public function userV2($userV1)
    {
        return $this->where('userV1', $userV1)->first()->userV2;
    }

    public function userV1($userV2)
    {
        return $this->where('userV2', $userV2)->first()->userV1;
    }
}
