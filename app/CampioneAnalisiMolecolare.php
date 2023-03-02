<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Log;
class CampioneAnalisiMolecolare extends Model
{
    /**
     * @var string
     */
    protected $table = 'campioni_analisi_molecolari';

    protected $fillable = [
        'anomalie',
        'codDiff',
        'codPiastra',
        'data',
        'dataAnalisi',
        'dataCampagna',
        'dataIncubazione',
        'dataScadenza',
        'dettaglio',
        'fase_Camp',
        'flusso',
        'id_campagna',
        'id_microAntibio',
        'id_prodotto',
        'id_progetto',
        'id_protocollo',
        'id_punto_camp',
        'id_areareparto',
        'id_rilevatore',
        'id_struttura',
        'id_superficie',
        'lotto',
        'microAntibio',
        'notaCampionamento',
        'note',
        'n_persone',
        'numProg',
        'numStanza',
        'operat',
        'ora',
        'PCampAria',
        'PCampTxt',
        'presenzaMicro',
        'stanza',
        'supTxt',
        'tdaSanif',
        'tecnico',
        'tempoIncubazione',
        'tipoCamp',
        'tipoPiastra',
        'tipo_scheda',
        'VCCC'
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'datetime:Y-m-d',
        'dataAnalsi' => 'datetime:Y-m-d',
        'dataCampagna' => 'datetime:Y-m-d',
        'dataIncubazione' => 'datetime:Y-m-d',
        'dataScadenza' => 'datetime:Y-m-d'

    ];

    public static $pCampAria = [
        1 => 'Diffusore/Plafone',
        2 => 'Centro stanza'
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
     * @return Rilevatore
     */
    public function rilevatore()
    {
        return $this->belongsTo('App\Rilevatore', 'id_rilevatore');
    }

    /**
     * @return Stanza
     */
    public function stanza()
    {
        return $this->belongsTo('App\Stanza', 'stanza');
    }

    /**
     * @return Materiale
     */
    public function superficie()
    {
        return $this->belongsTo('App\Materiale', 'id_superficie');
    }

    /**
     * @return ImmaginiPiastre
     */
    public function immaginipiastre()
    {
        return $this->hasMany('App\ImmaginiPiastreSwab','id_campione');
    }

    /**
     * @return ImmagineMicroAntibiogramma
     */
    public function immaginimicroantibiogramma()
    {
        return $this->hasMany('App\ImmagineMicroAntibiogrammaSwab','id_campione');
    }

    /**
     * @return MicroAntibigramma
     */
    public function microantibiogramma()
    {
        return $this->hasMany('App\MicroAntibiogrammaSwab','id_campione');
    }

    /**
     * @return PuntoCampionamento
     */
    public function puntocampionamento()
    {
        return $this->belongsTo('App\PuntoCampionamento', 'id_punto_camp');
    }

    /**
     * @return Piastra
     */
    public function tipopiastra()
    {
        return $this->belongsTo('App\TipoPiastra', 'tipoPiastra');
    }

    /**
     * @return Array
     */
    public static function get_pCampAria()
    {
        return self::$pCampAria;
    }

    /**
     * @param mixed $time
     * 
     * @return String
     */
    public static function floatToTime($time)
    {
        //return sprintf('%02d:%02d', (int) $time, fmod($time, 1) * 60);
        $value1 = explode('.',$time);
        $hours = $value1[0];
        $min_in_float = ($time - $hours) * 60/1;
        $min_val = explode('.',$min_in_float);
        $min_val = $min_val[0];
        $min_in_float = $min_in_float - $min_val;
        if($hours < 10){
            $hours = "0".$hours;
        }
        if($min_val < 10){
            $min_val = "0".$min_val;
        }
        return $hours.":".$min_val;
    }
}
