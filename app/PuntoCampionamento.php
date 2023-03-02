<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * [PuntoCampionamento]
 */
class PuntoCampionamento extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'punti_campionamento';

    protected $fillable = [
        'punto_campionamento',
        'id_categoria',
        'codPC',
        'matrice',
        'versione',
        'created_at',
        'updated_at'
    ];

    public static $matrice = [
        'S' => 'Superficie',
        'A' => 'Aria',
        'E' => 'Entrambi'
    ];

    /**
     * @var Categoria
     */
    public function categoria()
    {
        return $this->belongsTo('App\Categoria', 'id_categoria');
    }

    public static function getMatrice()
    {
        return self::$matrice;
    }

    
}
