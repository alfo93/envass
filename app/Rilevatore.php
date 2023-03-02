<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ESolution\DBEncryption\Traits\EncryptedAttribute;

/**
 * [Rilevatore]
 */
class Rilevatore extends Model
{
    use SoftDeletes, EncryptedAttribute;
    
    /**
     * @var string
     */
    protected $table = 'rilevatori';

    protected $fillable = [
        'id',
        'rilevatore',
        'id_progetto',
        'interno',
        //'id_struttura',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be encrypted on save.
     *
     * @var array
     */
    protected $encryptable = [
        'rilevatore'
    ];

    /**
     * @var array
     */
    public static $descrizione = [
        'Matteo Bisi' => 'Tecnico Interno, società CIAS/UNIFE - Via Saragat 13 - 44122 Ferrara (FE)',
        "Maria D'Accolti" => "Tecnico Interno, società CIAS/UNIFE - Via Saragat 13 - 44122 Ferrara (FE)",
        'Luca Lanzoni' => 'Tecnico Interno, società CIAS/UNIFE - Via Saragat 13 - 44122 Ferrara (FE)',
        'Antonella Volta' => 'Tecnico Interno, società CIAS/UNIFE - Via Saragat 13 - 44122 Ferrara (FE)',
        'Michele Calderoni' => 'Tecnico Esterno, società ETABETA S.R.L. - Via Sacco Nicola 19 - 47122 Forlì (FC)',
        'Alberto Casadei' => 'Tecnico Esterno, società ETABETA S.R.L. - Via Sacco Nicola 19 - 47122 Forlì (FC)',
        'Stefano Cremonini' => 'Tecnico Esterno, società ETABETA S.R.L. - Via Sacco Nicola 19 - 47122 Forlì (FC)',
        'Maria Angela Palamara' => 'Rilevatore del campionamento',
        'Cristina Genovese' => 'Rilevatore del campionamento',
        'Vincenza La Fauci' => 'Rilevatore del campionamento',
        'Irene Soffritti' => 'Tecnico Interno, società CIAS/UNIFE - Via Saragat 13 - 44122 Ferrara (FE)',
        'Elisabetta Caselli' => 'Tecnico Interno, società CIAS/UNIFE - Via Saragat 13 - 44122 Ferrara (FE)',
    ];

    /**
     * @var string Descrizione del rilevatore
     */
    public static function getDescrizione()
    {
        return self::$descrizione;
    }
}
