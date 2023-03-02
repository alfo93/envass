<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use ESolution\DBEncryption\Traits\EncryptedAttribute;
/**
 * [Societa]
 */
class Societa extends Model
{
    use Notifiable, SoftDeletes, EncryptedAttribute;
    
    /**
     * @var string
     */
    protected $table = 'societa';

    protected $fillable = [
        'id',
        'nome',
        'indirizzo',
        'email',
        'contratto',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be encrypted on save.
     *
     * @var array
     */
    protected $encryptable = [
        'nome', 'indirizzo','contratto'
    ];

    /**
     * @var Progetto
     */
    public function progetto()
    {
        return $this->hasMany('App\Progetto', 'id_societa');
    }
}
