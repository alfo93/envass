<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RappRelCampioni extends Model
{
    
    /**
     * @var string
     */
    protected $table = 'rapprel_campioni';

    protected $fillable = [

        'id',
        'id_rapprel',
        'id_campione',
        'created_at',
        'updated_at'
        
    ];

    public function campione()
    {
        return $this->belongsTo('App\Campione', 'id_campione');
    }

    public function rapprel()
    {
        return $this->belongsTo('App\RappRel', 'id_rapprel');
    }

}
