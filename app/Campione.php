<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * [Campione]
 */
class Campione extends Model
{
    /**
     * @var string
     */
    protected $table = 'campioni';

    protected $fillable = [
        'id',
        'id_progetto',
        'id_struttura',
        'data',
        'id_areareparto',
        'id_protocollo',
        'id_prodotto',
        'fase_Camp',
        'id_punto_camp',
        'PCampTxt',
        'id_superficie',
        'supTxt',
        'ora',
        'tdaSanif',
        'id_tipo_piastra',
        'lotto',
        'scadenza',
        'DII',
        'id_rilevatore',
        'VCCC',
        'flusso',
        'operat',
        'n_persone',
        'note',
        'dataCampagna',
        'data_accettazione',
        'numStanza',
        'dettaglio',
        'lineeGuida1',
        'lineeGuida2',
        'lineeGuida3',
        'lineeGuida4',
        'classificazioneISO',
        'classeGMP',
        'tipoCamp',
        'pCampAria',
        'codDiff',
        //'dataFineProva' //da aggiungere appena fatta migrazione di correzione
        't_inc',
        'condizione_incubazione',
        'gramRil',
        'gramN',
        't_inc_extra',
        'anomalie',
        'oraPartenza',
        'dataPartenza',
        'dataInizio',
        'dataFine',
        'dataArrivo',
        'oraInizio',
        'oraFine',
        'oraArrivo',
        'umidAmb',
        'tempAmb',
        'procedura',
        'id_metodo',
        'tipoCampionamento',
        'tecnico',
        'dataAnalisi',
        'oraInizioAnalisi',
        'dataFineAnalisi',
        'oraFineAnalisi',
        'codiceCIAS',
        'tipoScheda',
        'tipoTest',
        'bloccato',
        'speciazione',
        'incertezza',
        'created_at',
        'updated_at',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'datetime:Y-m-d',
        'dataPartenza' => 'datetime:Y-m-d',
        'dataFine' => 'datetime:Y-m-d',
        'dataArrivo' => 'datetime:Y-m-d',
        'dataInizio' => 'datetime:Y-m-d',
        'dataAnalsi' => 'datetime:Y-m-d',
        'dataFineAnalisi' => 'datetime:Y-m-d',
        'dataFineProva' => 'datetime:Y-m-d',
        'dataCampagna' => 'datetime:Y-m-d',
        'data_accettazione' => 'datetime:Y-m-d',
        'scadenza' => 'datetime:Y-m-d',
        'DII' => 'datetime:Y-m-d',
        'oraFineAnalisi' => 'time:H:i',
        'oraInizioAnalisi' => 'time:H:i'
    ];
    /** 
     * @var array 
     *
    */
    public static $lineeguida = [
        'lineeGuida1' => 'ISPESL 2003',
        'lineeGuida2' => 'ISPESL 2009',
        'lineeGuida3' => 'GMP 2008',
        'lineeGuida4' => 'Standart IMQ'
    ];

    /**
     * @var array
     */
    public static $tipoCampionamento = [
        '0' => 'Statico',
        '1' => 'Personale',
    ];

    /**
     * @var array
     */
    public static $classificazioneISO = [
        1 => 'ISO 5',
        2 => 'ISO 7',
        3 => 'ISO 8'
    ];

    /**
     * @var array
     */
    public static $classeGMP = [
        1 => 'A',
        2 => 'B',
        3 => 'C',
        4 => 'D'
    ];

    /**
     * @var array
     */
    public static $pCampAria = [
        1 => 'Diffusore/Plafone',
        2 => 'Centro stanza',
        3 => 'Gravitazionale passivo',
        4 => 'Pass-box'
    ];

    /**
     * @var array
     */
    public static $codici_pCampAria = [
        'Diffusore/Plafone' => 'SASB',
        'Centro stanza' => 'SASC',
        'Gravitazionale passivo' => 'GPA',
        'Pass-box' => 'PBX'
    ];

    /**
     * @var array
     */
    public static $t_inc = [
        24 => 24,
        48 => 48,
        72 => 72,
        120 => 'da 120 a 168'
    ];

    /**
     * @var array 
     */
    public static $condizione_incubazione = [
        25,
        30,
        37
    ];


    /**
     * @return Campagna
     */
    public function campagna()
    {
        return $this->belongsTo('App\Campagna', 'id_campagna');
    }

    /**
     * @return Progetto
     */
    public function progetto()
    {
        return $this->belongsTo('App\Progetto', 'id_progetto');
    }

    /**
     * @return Struttura
     */
    public function struttura()
    {
        return $this->belongsTo('App\Struttura', 'id_struttura');
    }

    /**
     * @return Reparto
     */
    public function reparto()
    {
        return $this->belongsTo('App\AreaPartizione', 'id_areareparto');
    }

    /**
     * @return Protocollo
     */
    public function protocollo()
    {
        return $this->belongsTo('App\Protocollo', 'id_protocollo');
    }

    /**
     * @return Prodotto
     */
    public function prodotto()
    {
        return $this->belongsTo('App\Prodotto', 'id_prodotto');
    }

    /**
     * @return PuntoCampionamento
     */
    public function puntocampionamento()
    {
        return $this->belongsTo('App\PuntoCampionamento', 'id_punto_camp');
    }

    /**
     * @return Materiale
     */
    public function superficie()
    {
        return $this->belongsTo('App\Materiale', 'id_superficie');
    }

    /**
     * @return Piastra
     */
    public function tipopiastra()
    {
        return $this->belongsTo('App\TipoPiastra', 'id_tipo_piastra');
    }

    /**
     * @return Rilevatore
     */
    public function rilevatore()
    {
        return $this->belongsTo('App\Rilevatore', 'id_rilevatore');
    }

    /**
     * @return ImmaginiPiastre campionamenti
     */
    public function immaginipiastre()
    {
        return $this->hasMany('App\ImmaginiPiastre','id_campione');
    }

    /**
     * @return ImmaginiPiastre antibiogrammi
     */
    public function immaginimicroantibiogramma()
    {
        return $this->hasMany('App\ImmagineMicroAntibiogramma','id_campione');
    }

    /**
     * @return MicroAntibiogramma
     */
    public function microantibiogramma()
    {
        return $this->hasMany('App\MicroAntibiogramma','id_campione');
    }

    /**
     * @return Metodo
     */
    public function metodo()
    {
        return $this->belongsTo('App\Metodo', 'id_metodo');
    }

    /**
     * @return Array [linee guida]
     */
    public static function get_lineeguida()
    {
        return self::$lineeguida;
    }

    /**
     * @return Array Classificazione iso
     */
    public static function get_iso()
    {
        return self::$classificazioneISO;
    }

    /**
     * @return Array Classificazione iso
     */
    public static function get_iso_of_scheda($key)
    {
        return $key != null ? self::$classificazioneISO[$key] : '/';
    }

    /**
     * @return Array Classe GMP
     */
    public static function get_gmp()
    {
        return self::$classeGMP;
    }

    /**
     * @return Array Punto di campionamento su aria
     */
    public static function get_pCampAria()
    {
        return self::$pCampAria;
    }

    /**
     * @return Array Tempo di incubazione
     */
    public static function get_tInc()
    {
        return self::$t_inc;
    }

    /**
     * @return Array Condizione di incubazione
     */
    public static function get_condizioneIncubazione()
    {
        return self::$condizione_incubazione;
    }

}
