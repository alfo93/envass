<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * [ImmagineMicroAntibiogrammaSwab]
 */
class ImmagineMicroAntibiogrammaSwab extends Model
{
    use SoftDeletes, EncryptedAttribute;

    /**
     * @var string
     */
    protected $table = 'immagini_microantibiogrammi_analisi_molecolari';

    protected $fillable = [
        'id_campione',
        'nome_file',
        'path_file',
        'tipo',
        'id_utente_cancella',
        'motivo_cancella',
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
}
