<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConversionePuntiCampionamento extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'conversione_punto_campionamento_punti_campionamento';

    protected $fillable = [
        'punto_campionamentoV1',
        'punto_campionamentoV2',
    ];

    public static function punto_campionamentoV2($punto_campionamentoV1)
    {
        return ConversionePuntiCampionamento::where('punto_campionamentoV1', $punto_campionamentoV1)->first() != null ? ConversionePuntiCampionamento::where('punto_campionamentoV1', $punto_campionamentoV1)->first()->punto_campionamentoV2 : null;
    }

    public static function punto_campionamentoV1($punto_campionamentoV2)
    {
        return ConversionePuntiCampionamento::where('punto_campionamentoV2', $punto_campionamentoV2)->first() != null ? ConversionePuntiCampionamento::where('punto_campionamentoV2', $punto_campionamentoV2)->first()->punto_campionamentoV1 : null;
    }
}
