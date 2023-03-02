<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanimetriaRdpAnteprima extends Model
{
     /**
     * @var string
     */
    protected $table = 'planimetrie_rdp_anteprima';

    protected $fillable = [
        'id_rdp_anteprima',
        'id_rdp',
        'planimetria',
        'caption'
    ];
}
