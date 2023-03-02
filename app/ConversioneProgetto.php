<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConversioneProgetto extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'conversione_progetto';

    protected $fillable = [
        'progettoV1',
        'progettoV2',
    ];

    public static function progettoV2($progettoV1)
    {
        return ConversioneProgetto::where('progettoV1', $progettoV1)->first() != null ? ConversioneProgetto::where('progettoV1', $progettoV1)->first()->progettoV2 : null;
    }
    

    public static function progettoV1($progettoV2)
    {
        return ConversioneProgetto::where('progettoV2', $progettoV2)->first() != null ? ConversioneProgetto::where('progettoV2', $progettoV2)->first()->progettoV1 : null;
    }
}
