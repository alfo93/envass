<?php

namespace App;

//use ESolution\DBEncryption\Traits\EncryptedAttribute;
use Illuminate\Database\Eloquent\Model;

/**
 * [Segnalazione]
 */
class Segnalazione extends Model
{
    //use EncryptedAttribute;

    /**
     * @var string
     */
    protected $table = 'segnalazioni';

    protected $fillable = [
        'codice',
        'messaggio',
        'data',
        'firma',
        'controllato'
    ];

    /** @var array The attributes that should be encrypted/decrypted */
    /*protected $encryptable = [
        'messaggio'
    ];*/
    
    /**
     * @var array
     */
    public static $titoli = [
        '1' => 'Mancata migrazione',
        '2' => 'Mancato aggancio anamnesi temporanea',
        '3' => 'Errore generico',
        '4' => 'Referto inconsistente',
        '5' => 'Possibile errore paziente',
        '6' => 'Possibile segnalazione paziente'
    ];

    /**
     * @return array Titoli
     */
    public static function get_titoli()
    {
        return self::$titoli;
    }

    /**
     * La funzione ha lo scopo di salvare un entità senza scatenare nessun'altro evento al salvataggio
     */
    public function saveWithoutEvents(array $options=[])
    {
        return static::withoutEvents(function () use ($options) {
            return $this->save($options);
        });
    }
}

