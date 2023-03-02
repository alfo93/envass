<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpeciazioneCampione extends Model
{
     /**
     * @var string
     */
    protected $table = 'speciazioni_campioni';

    protected $fillable = [
        'id_campione',
        'id_microrganismo',
        'id_tipopiastra',
        'esito',
        'tipoCamp',
        'created_at',
        'updated_at'
    ];

    /**
     * @return MicrorganismoPiastra
     */
    public function microrganismo()
    {
        return $this->belongsTo('App\MicrorganismoPiastra', 'id_microrganismo');
    }

    /**
     * @return Campione
     */
    public function campione()
    {
        return $this->belongsTo('App\Campione', 'id_campione');
    }

    /**
     * @return TipoPiastra
     */
    public function tipopiastra()
    {
        return $this->belongsTo('App\TipoPiastra', 'id_tipopiastra');
    }
}
