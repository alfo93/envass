<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConversioneMateriale extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'conversione_materiale';

    protected $fillable = [
        'materialeV1',
        'materialeV2',
    ];

    public static function materialeV2($materialeV1)
    {
        return ConversioneMateriale::where('materialeV1', $materialeV1)->first()->materialeV2 ?? $materialeV1;
    }

    public static function materialeV1($materialeV2)
    {
        return ConversioneMateriale::where('materialeV2', $materialeV2)->first()->materialeV1 ?? $materialeV2;
    }
}
