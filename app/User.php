<?php

namespace App;

use Artesaos\Defender\Traits\HasDefender;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, HasDefender;
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'nome','cognome','email','email_verified_at', 'password', 'Auth', 'Progetto', 'diritti','versione','remember_token','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * I ruoli dell'utente loggato nel sistema
     * 
     * @var string
     */
    protected static $ruolo = [
        '1' => "Admin",
        '2' => 'Gestore',
        '3' => 'Committente',
        '4' => "Utente",
    ];

    /**
     * I ruoli dell'utente loggato nel sistema
     * 
     * @var string
     */
    protected static $diritti = [
        'interno' => "Interno",
        'cliente' => 'Cliente',
        'amministratore' => 'Amministratore',
        'tecnico cias' => "Tecnico cias",
        'utente di progetto' => "Utente di progetto",
        "demo" => "Demo",
        "tecnico informatico" => "Tecnico informatico",
    ];


    /**
     * Funzione che ritorna il nome completo dell'utente
     * 
     * @return string
     */
    public static function diritti()
    {
        return self::$diritti;
    }

    /**
     * Funziona che ritorna l'array dei ruoli
     * 
     * @return array
     */
    public static function ruoli()
    {
        return self::$ruolo;
    }
}
