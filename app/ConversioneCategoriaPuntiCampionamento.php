<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConversioneCategoriaPuntiCampionamento extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'conversione_categoria_punti_campionamento';

    protected $fillable = [
        'categoriaV1',
        'categoriaV2',
    ];

    public function categoriaV2($categoriaV1)
    {
        return $this->where('categoriaV1', $categoriaV1)->first()->categoriaV2;
    }

    public function categoriaV1($categoriaV2)
    {
        return $this->where('categoriaV2', $categoriaV2)->first()->categoriaV1;
    }
}
