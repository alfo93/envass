<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Log;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * [Procedura]
 */
class Procedura extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'eprocedure';

    /**
     * @var array
     */
    protected $fillable = [

        "file",
        "note",
        "livello",
        "id_progetto",
        //"dati",
    ];

    /**
     * @var array
     */
    public static $livello = [
        1 => "Pubblico",
        2 => "Operativo",
        3 => "Riservato"
    ];


    /**
     * @return Progetto
     */
    public function progetto()
    {
        return $this->belongsTo('App\Progetto', 'id_progetto');
    }

    /**
     * @return array
     */
    public static function livello()
    {
        return self::$livello;
    }

    /**
     * @return string
     */
    public static function getLivello($livello)
    {
        switch ($livello) {
            case 1:
                return 'Pubblico';
                break;
            case 2:
                return 'Operativo';
                break;    
            case 3:
                return 'Riservato';
                break;
            default:
                return 'Riservato';
                break;
        }
    }

    /**
     * @return array
     */
    public static function livelloCode($stringa)
    {
        $pubblico = levenshtein($stringa, 'pubblico');
        $operativo = levenshtein($stringa, 'operativo');
        $riservato = levenshtein($stringa, 'riservato');
        $array = [$pubblico => 1, $operativo => 2, $riservato => 3];
        $res = min($pubblico,$operativo,$riservato);
        return $array[$res];
    }

}
