<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * [ImmaginiPiastreSwab]
 */
class ImmaginiPiastreSwab extends Model
{
    use SoftDeletes, EncryptedAttribute;

    /**
     * @var string
     */
    protected $table = 'immagini_analisi_molecolari';

    protected $fillable = [
        'id_campione',
        'id_utente_cancella',
        'motivo_cancella',
        'nome_file',
        'path_file',
        'tipo',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be encrypted on save.
     *
     * @var array
     */
    protected $encryptable = [
        'nome_file','path_file'
    ];

    /**
     * @return Campione
     */
    public function campione()
    {
        return $this->belongsTo('App\Campione', 'id_campione');
    }

    /**
     * @return User
     */
    public function utente()
    {
        return $this->belongsTo('App\User', 'id_utente_cancella');
    }
}
