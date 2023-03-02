<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ESolution\DBEncryption\Traits\EncryptedAttribute;
use App\ConversioneProgetto;

/**
 * [Progetto]
 */
class Progetto extends Model
{
    use SoftDeletes, EncryptedAttribute;
    
    /**
     * @var string
     */
    protected $table = 'progetti';

    protected $fillable = [
        'id',
        'progetto',
        'id_societa',
        'CodPro',
        'tipo',
        'data_inizio_progetto',
        'data_fine_progetto',
        'versione',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be encrypted on save.
     *
     * @var array
     */
    protected $encryptable = [
        'progetto'
    ];

    /**
     * @var array
     */
    public static $tipo = [
        1 => 'Monitoraggio routine',
        2 => 'Progetto di ricerca',
    ];

    /**
     * @return string
     */
    public static $stato = [
        "si" => 'Attivo',
        "no" => 'Non attivo',
        "sospeso" => 'Da confermare'
    ];

    /**
     * @return array
     */
    public static function tipo()
    {
        return self::$tipo;
    }

    /**
     * @return array
     */
    public static function stato()
    {
        return self::$stato;
    }

    /**
     * @return Societa
     */
    public function societa()
    {
        return $this->belongsTo('App\Societa', 'id_societa');
    }

    /**
     * @return Progetto
     */
    public static function progettoV2($id)
    {
        return ConversioneProgetto::where('progettoV1', $id)->first() ? ConversioneProgetto::where('progettoV1', $id)->first()->progettoV2 : null;
    }

    /**
     * @return Progetto
     */
    public static function progettoV1($id)
    {
        return ConversioneProgetto::where('progettoV2', $id)->first() ? ConversioneProgetto::where('progettoV1', $id)->first()->progettoV1 : null;
    }
}
