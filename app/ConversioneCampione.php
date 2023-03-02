<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConversioneCampione extends Model
{
    /**
     * @var string
     */
    protected $table = 'conversione_campioni';

    protected $fillable = [
        'campioneV1',
        'campioneV2',
    ];

    public static function campioneV2($campioneV1)
    {
        return ConversioneCampione::where('campioneV1',$campioneV1)->first()->campioneV2 ?? null;
    }

    public static function campioneV1($campioneV2)
    {
        return ConversioneCampione::where('campioneV2',$campioneV2)->first()->campioneV1 ?? null;
    }
}
