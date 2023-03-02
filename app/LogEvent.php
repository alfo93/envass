<?php

namespace App;

//use ESolution\DBEncryption\Traits\EncryptedAttribute;
use Illuminate\Database\Eloquent\Model;

/**
 * [LogEvent]
 */
class LogEvent extends Model
{
    //use EncryptedAttribute;

    /**
     * @var string
     */
    protected $table = 'log_envass';

    protected $fillable = [

        "id_utente",
        "azione",
        "dati",
    ];

    /**@var array The attributes that should be encrypted/decrypted */
    protected $encryptable = [
       'dati'
    ];


    public static $intestazione_dati = [
        'id_rdp' => 'Rapporto di prova',
        'id_progetto' => 'Progetto',
        'id_societa' => 'Committente',
        'id_reparto' => 'Partizione',
        'id_campione' => 'Campione',
        'id_materiale' => 'Materiale',
        'areapartizione' => 'Area partizione',
        'id_utente' => 'Utente',
        'codice_area_part' => 'Codice area partizione',
        'id_struttura' => 'Struttura',
        'tipoScheda' => 'Tipo scheda',
        'DII' => 'Data inizio incubazione',
        "tipoCampione" => "Tipo campione",
        "tipoTest"  => "Tipo test",
        "id_campagna" => "Campagna",
        "dataCampagna" => "Data campagna",
        "data_accettazione" => "Data accettazione",
        "dataCampionamento" => "Data campionamento",
        "dataPartenza" => "Data partenza",
        "oraPartenza" => "Ora partenza",
        "dataInizio" => "Data inizio",
        "oraInizio" => "Ora inizio",
        "dataFine" => "Data fine",
        "oraFine" => "Ora fine",
        "dataArrivo" => "Data arrivo",
        "oraArrivo" => "Ora arrivo",
        "tecnico" => "Tecnico",
        "dataAnalisi" => "Data analisi",
        "oraInizioAnalisi" => "Ora inizio analisi",
        "oraFineAnalisi" => "Ora fine analisi",
        "dataFineAnalisi" => "Data fine analisi",
        "superficie" => "Superficie",
        "aria" => "Aria",
        "vccc" => "VCCC",
        "laminare" => "Laminare",
        "turbolento" => "Turbolento",
        "operational" => "Operational",
        "at_rest" => "At rest",
        "n_persone" => "Numero di persone",
        "pCampAria" => "Punto di campionamento aria",
        "codDiff" => "Codice diffusore",
        "codiceCIAS" => "Codice CIAS",
        "id_tipo_piastra" => "Tipo piastra",
        "lotto" => "Lotto",
        "scadenza" => "Scadenza",
        "t_inc" => "Tempo di incubazione",
        "condizione_incubazione" => "Condizione di incubazione",
        "siGramRil" => "Rilevati Gram positivi",
        "noGramRil" => "Non sono stati  rilevati Gram positivi",
        "gramN" => "Gram negativo",
        "note" => "Note",
        "reparto" => "Partizione",
        "area_partizione"  => "Area partizione",
        "codice_area_partizione" => "Codice area partizione",
        "numStanza" => "Numero stanza",
        "umidAmb" => "Umidità ambiente",
        "tempAmb" => "Temperatura ambiente",
        "dettaglio" => "Dettaglio",
        "lineeGuida1" => "Linee guida ISPESL 2003",
        "lineeGuida2" => "Linee guida ISPESL 2009",
        "lineeGuida3" => "Linee guida GMP 2008",
        "lineeGuida4" => "Linee guida Standart IMQ",
        "classeGMP" => "Classe GMP",
        "anomalie" => "Anomalie",
        "classificazioneISO" => "Classificazione ISO",
        "numeroProgressivo" => "Numero progressivo",
        "code" => "Codice",
        "micro" => "Microrganismo",
        "id_microrganismo" => "Microrganismo",
        "id_tipopiastra" => "Tipo piastra",
        "cfu" => "CFU",
        "incertezzaSx" => "Incertezza: intorno di sinistra",
        "incertezzaDx" => "Incertezza: intorno di destra",
        "micro_speciazione" => "Speciazione",
        "tipoCamp" => "Tipo di campionamento",
        "speciazione_risultato" => "Speciazione risultato",
        "id_microrganismo_antibiogramma" => "Microrganismo antibiogramma",
        "rilevatori" => "Rilevatori",
        "id_metodo" => "Metodo",
        "codiceCIAS_appendice" => "Codice CIAS (appendice)",
        "speciazione" => "Speciazione",
        "incertezza" => "Incertezza",
        "tipoTabella" => "Tipo tabella",
        "tipoFoto" => "Tipo foto",
        'data_campagna' => 'Data campagna',
        'updated_at' => 'Data ultima modifica',
        'crea_campagna' => 'Campagna creata con successo',
        'aa' => 'Antibiotico usato in antibiogramma',
        'id_antibiotico' => 'Antibiotico',
        'key_resistenza' => 'Antibiotico resistenza',
        'NAB' => 'Numero di antibiogramma',
        'nab_array' => 'Antibiogramma',
        'condizione_incubazione' => 'Condizione di incubazione',
        'colonia' => 'Colonia trovata',
        'id_categoria' => 'Categoria',
        'codPC' => 'Codice punto di campionamento',
        'matrice' => 'Matrice',
        'nome' => 'Nome',
        'punto_campionamento' => 'Punto di campionamento',
        'abbreviazione' => 'Abbreviazione',
        'id_associazione' => 'Partizione - Area partizione',
        'id_piastra' => 'Terreno',

    ];

    public static $metodoIntestazione = [
        'crea_campagna' => 'Campagna',
        'id_rdp' => 'RapportoRelazione',
        'id_progetto' => 'Progetto',
        'id_societa' => 'Societa',
        'id_reparto' => 'Reparto',
        'id_campione' => 'Campione',
        'id_materiale' => 'Materiale',
        'areapartizione' => 'AreaPartizione',
        'id_utente' => 'User',
        'codice_area_part' => 'AreaPartizione',
        'id_struttura' => 'Struttura',
        'tipoScheda' => 'Campione',
        'tipoCampione' => 'Campione',
        'tipoTest' => 'Campione',
        'id_campagna' => 'Campagna',
        'tecnico' => 'Rilevatore',
        'superficie' => 'Campione',
        'aria' => 'Campione',
        'vccc' => 'Campione',
        'laminare' => 'Campione',
        'turbolento' => 'Campione',
        'operational' => 'Campione',
        'at_rest' => 'Campione',
        'n_persone' => 'Campione',
        'pCampAria' => 'Campione',
        'codDiff' => 'Campione',
        'codiceCIAS' => 'Campione',
        'id_tipo_piastra' => 'TipoPiastra',
        'reparto' => 'Reparto',
        'area_partizione' => 'AreaPartizione',
        'codice_area_partizione' => 'AreaPartizione',
        'lineeGuida1' => 'Campione',
        'lineeGuida2' => 'Campione',
        'lineeGuida3' => 'Campione',
        'lineeGuida4' => 'Campione',
        'classeGMP' => 'Campione',
        'classificazioneISO' => 'Campione',
        'numeroProgressivo' => 'Campione',
        'micro' => 'MicrorganismoPiastra',
        'id_microrganismo' => 'MicrorganismoPiastra',
        'id_tipopiastra' => 'TipoPiastra',
        'micro_speciazione' => 'SpeciazioneCampione',
        'tipoCamp' => 'Campione',
        'speciazione_risultato' => 'SpeciazioneCampione',
        'id_microrganismo_antibiogramma' => 'MicroAntibiogramma',
        'rilevatori' => 'Rilevatore',
        'id_metodo' => 'Metodo',
        'speciazione' => 'SpeciazioneCampione',
        'dataCampagna' => 'Campagna',
        'data_campagna' => 'Campagna',
        'dataInizio' => 'Campione',
        'data_accettazione' => 'Campione',
        'dataPartenza' => 'Campione',
        'dataFine' => 'Campione',
        'dataArrivo' => 'Campione',
        'dataAnalisi' => 'Campione',
        'dataFineAnalisi' => 'Campione',
        'dataCampionamento' => 'Campione',
        'updated_at' => 'Campione',
        'aa' => 'Antibiotico',
        'id_antibiotico' => 'Antibiotico',
        'key_resistenza' => 'Microrganismo',
        'colonia' => 'AntibioticoAntibiogramma',
        'nab_array' => 'MicroAntibiogramma',
        'DII' => 'Campione',
        'scadenza' => 'Campione',
        't_inc' => 'Campione',
        'condizione_incubazione' => 'Campione',
        'noGramRil' => 'Campione',
        'siGramRil' => 'Campione',
        'gramN' => 'Campione',
        "id_tipopiastra" => "Tipopiastra",
        "cfu" => "SpeciazioneCampione",
        "incertezzaSx" => "SpeciazioneCampione",
        "incertezzaDx" => "SpeciazioneCampione",
        "incertezza" => "SpeciazioneCampione",
        'id_categoria' => 'Categoria',
        'codPC' => 'PuntoCampionamento',
        'matrice' => 'PuntoCampionamento',
        'nome' => 'PuntoCampionamento',
        'punto_campionamento' => 'PuntoCampionamento',
        'abbreviazione' => 'TipoPiastra',
        'id_associazione' => 'AreaPartizione',
        'id_piastra' => 'TipoPiastra',

    ];

     /**
     * @return Array Intestazioni
     */
    public static function getIntestazioni()
    {
        return self::$intestazione_dati;
    }

    /**
     * @return Array Metodo associato alle intestazioni
     */
    public static function getMetodoIntestazioni()
    {
        return self::$metodoIntestazione;
    }

}
