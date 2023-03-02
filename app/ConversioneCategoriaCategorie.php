<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConversioneCategoriaCategorie extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'conversione_categoria_categorie';

    protected $fillable = [
        'categoriaV1',
        'categoriaV2',
    ];

    public static function categoriaV2($categoriaV1)
    {
        return ConversioneCategoriaCategorie::where('categoriaV1', $categoriaV1)->first() != null ? ConversioneCategoriaCategorie::where('categoriaV1', $categoriaV1)->first()->categoriaV2 : null;
    }

    public static function categoriaV1($categoriaV2)
    {
        return ConversioneCategoriaCategorie::where('categoriaV2', $categoriaV2)->first() != null ? ConversioneCategoriaCategorie::where('categoriaV2', $categoriaV2)->first()->categoriaV1 : null;
    }
}
