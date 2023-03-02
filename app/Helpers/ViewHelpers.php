<?php

    /**
     * Ritorna un valore valido fra v1, v2 o v3 che è il valore di default
     *
     * @param Any $value
     * @param Any $fallback
     * @param Any $default
     * @return Any | null
     */

    use Carbon\Carbon;
    use App\StruttRep;

    function get_value_or_default($value, $fallback, $default = null)
    {
        try {
            if (isset($value) && $value != null) {
                return $value;
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }

        try {
            if (isset($fallback) && $fallback != null) {
                return $fallback;
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }

        try {
            if (isset($default) && $default != null) {
                return $default;
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }

        return null;
    }

    /**
     * Ritorna se la sezione attiva è fra quelle passate
     *
     * @param Array
     * @return Bool
     */
    function is_section_active($list)
    {
        return in_array(app_section_name(), $list);
    }

    /**
     * Ritorna il nome della sezione attiva.
     *
     * @return String
     */
    function app_section_name()
    {
        $request_segments = request()->segments();
        $current_section = count($request_segments) > 0 ? $request_segments[0] : '';
        
        return $current_section;
    }

    /**
     * Ritorna la data formattata.
     *
     * @param String
     * @return String
     */
    function format_date($date)
    {
        if (is_object($date) && get_class($date) == 'Illuminate\Support\Carbon') {
            return $date->format('d/m/Y');
        }

        return Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
    }

    /**
     * Ritorna nome e cognome formattati.
     *
     * @param String
     * @param String
     * @return String
     */
    function format_name($fname, $lname)
    {
        return ucfirst(strtolower($fname)) ." ". ucfirst(strtolower($lname));
    }

    /**
     * Ritorna se l'opzione è selezionata.
     *
     * @param String
     * @param String
     * @return Bool
     */
    function is_selected_option($val, $check)
    {
        return strtolower($val) == strtolower($check) ? 'selected' : '';
    }

    /**
     * Ritorna se il checkbox è selezionata.
     *
     * @param String
     * @param String
     * @return Bool
     */
    function is_checked($check, $val = null)
    {
        $val = $val != null ? $val : 1;
        return ($check === 'on' || $check === 'si' || $check === 1 || $check === true) ? 'checked' : '';
    }

    /**
     * Ritorna se il checkbox è selezionata.
     *
     * @param String
     * @param String
     * @return Bool
     */
    function is_disabled($check, $val = null)
    {
        $val = $val != null ? $val : 1;

        return ($check === 'on' || $check === 'si' || $check === 1 || $check === true) ? 'disabled' : '';
    }

    /**
     * Disabilita l'elemento se $val è settato.
     *
     * @param String
     * @return String
     */
    function disable_if_set($val)
    {
        return isset($val) ? 'disabled' : '';
    }

    /**
     * Disabilita l'elemento se $val NON è settato.
     *
     * @param String
     * @return String
     */
    function disable_if_empty_or_unset($val)
    {
        return isset($val) && strlen($val) > 0 ? '' : 'disabled';
    }

    /**
     * Ritorna l'indice dell'opzione nell'array.
     *
     * @param String
     * @param array
     * @return Int
     */
    function selected_option_index($option, $array)
    {
        return array_search($option, $array);
    }

    /**
     * Ritorna la classe 'errored' se sono presenti errori per il campo
     *
     * @param errors Array
     * @param label String
     * @return String
     */
    function add_error_class($errors, $label): String
    {
        return $errors->has($label) ? 'errored' : '';
    }

    /**
     * Ritorna 'disabled' se la scansione non esiste.
     *
     * @param int $stato
     * @return String
     */
    function disable_if_missing_scan($stato): String
    {
        if ($stato <= 0) {
            return 'disabled';
        }

        return '';
    }
    
    /**
     * Data una string in snake_case
     * torna la stringa con gli spazi
     *
     * @param stringa String
     * @return String
     */
    function snake_to_space($stringa): String
    {
        return str_replace('_', ' ', $stringa);
    }

    /**
     * Data una string in snake_case
     * torna la stringa con gli spazi
     *
     * @param stringa String
     * @return String
     */
    function upper_first_snake_to_space($stringa): String
    {
        return str_replace('_', ' ', ucfirst($stringa));
    }

     /**
     * Data una string in snake_case
     * torna la stringa con gli spazi
     *
     * @param stringa String
     * @return String
     */
    function down_first_snake_to_space($stringa): String
    {
        return str_replace('_', ' ', lcfirst($stringa));
    }

    /**
     * Data una string con spazi
     * sostituisce tutti gli spazi con _
     *
     * @param stringa String
     * @return String
     */
    function string_to_snake_case($stringa): String
    {
        return strtolower(str_replace(' ', '_', $stringa));
    }


    /**
     * Dati i 3 parametri struttura progetto reparto, restituisce il codice personale associato
     * @param Integer id_struttura
     * @param Integer id_reparto
     * @param Integer id_progetto
     */
    function codiceStrRep($id_struttura,$id_reparto,$id_progetto, $id_area_partizione)
    {
        $codice = '';

        $progetto = App\Progetto::find($id_progetto);
        $struttura = App\Struttura::find($id_struttura);
        $reparto = App\Reparto::find($id_reparto);
        $area_partizione = App\AreaPartizione::find($id_area_partizione);
        if($progetto != null)
        {
            $codice = $progetto->CodPro;
        }
        if($struttura != null)
        {
            $codice .= "_".$struttura->codice_struttura . "_".$struttura->codice_sede."_".$struttura->codice_provincia;
        }
        if($reparto != null)
        {
            $codice .= "_".$reparto->codice_partizione;
        }
        if($area_partizione != null)
        {
            $codice .= "_".$area_partizione->codice_area_partizione;
        }
        return $codice;
    }

    /**
     * Dati i 2 parametri reparto e area_partizione, restituisce il codice personale associato
     * @param Integer id_reparto
     * @param Integer id_areapartizione
     */
    function codiceRepArea($id_reparto,$id_area_partizione)
    {
        $codice = '';

        $reparto = App\Reparto::find($id_reparto);
        $area_partizione = App\AreaPartizione::find($id_area_partizione);
        
        if($reparto != null)
        {
            $codice .= $reparto->codice_partizione;
        }
        if($area_partizione != null)
        {
            if($area_partizione->codice_area_partizione != null)
            {
                $codice .= "_".$area_partizione->codice_area_partizione;
            }
        }
        return $codice;
    }

    /**
     * Dati i 2 parametri data campionamento e codice, restituisce il codice finale associato al campionamento
     * @param Date dataCampagna
     * @param String Codice
     */
    function generaCodice($dataCampagna, $codiceRepArea,$codiceNumStanza,$codiceTipoPiastra,$id_punto_camp,$tipoCamp)
    {
        $codice_finale = "";
        if($codiceRepArea != null)
        {
            $dataCampagna = str_replace('-','_',$dataCampagna);
            $codice_finale = $dataCampagna."_".$codiceRepArea;    
        }
        if($codiceNumStanza != null)
        {
            $codice_finale .= "_".$codiceNumStanza;
        }
        if($codiceTipoPiastra != null)
        {
            $codice_finale .= "_".$codiceTipoPiastra;
        }

        if($id_punto_camp != null && $tipoCamp != null)
        {
            $punto_camp = App\PuntoCampionamento::find($id_punto_camp);
            if($punto_camp != null)
            {
                $codice_finale .= "_".$punto_camp->codPC;
            } 
        }     

        if($codiceRepArea == null && $codiceNumStanza == null && $codiceTipoPiastra == null && $id_punto_camp == null && $tipoCamp == null)
        {
            $codiceRepArea = "";
            $dataCampagna = str_replace('-','_',$dataCampagna);
            $codice_finale = $dataCampagna; 
        }

        
        
        return $codice_finale;
    }

    /**
     * La funzione prende la categoria in ingresso e restituisce i punti di campionamento associati a quella categoria
     * 
     * @param mixed $id_categoria
     * 
     * @return punto_campionamento
     */
    function getPuntoCampPerCategoria($id_categoria,$matrice)
    {
        if($id_categoria == "tutti")
        {
            $pc = App\PuntoCampionamento::where('versione',2)->whereIn('matrice',[$matrice, 'E'])->get();
        }
        else
        {
            $pc = App\PuntoCampionamento::where('id_categoria',$id_categoria)->whereIn('matrice',[$matrice,'E'])->where('versione',2)->get();
        }
        
        return $pc;
    }

    function getPuntoCampAria()
    {
        return App\PuntoCampionamento::where('versione',2)->whereIn('matrice',['A','E'])->orderBy('punto_campionamento','ASC')->get();
    }

    function getPuntoCampSuperficie($campioni)
    {
        if($campioni == null || count($campioni) == 0)
        {
            return '';
        }
        else
        {
            $punto_camp = '';
            $campione = $campioni->where('tipoCamp','S')->first();
            $punto_camp = App\PuntoCampionamento::find($campione->id_punto_camp);

            if($punto_camp != null)
            {
                return ucfirst($punto_camp->punto_campionamento);
            }
            else
            {
                return '';
            }
        }
    }

    function get_punti_campionamento_superficie($campioni,$tipoPiastra,$occorrenze)
    {
        if($campioni == null || count($campioni) == 0)
        {
            return '';
        }

        if($tipoPiastra == '' || $tipoPiastra == null)
        {
            return '';
        }
        $punto_camp = '';
        $punti_camp = [];
         
        if($tipoPiastra == 'PCA')
        {
           
            $campioni_sup = $campioni->where('tipoCamp','S')->where('id_tipo_piastra',26);
            foreach ($campioni_sup as $c) {
                $pc = App\PuntoCampionamento::find($c->id_punto_camp);
                if($pc != null)
                {
                    $punti_camp[] = $pc->punto_campionamento;
                }
            }
            #count occurrences of each element in array
            $occurrences_array = array_count_values($punti_camp);
            $punti_camp = [];
            foreach ($occurrences_array as $key => $value) 
            {
                if($value == $occorrenze)
                {
                    $punti_camp[] = $key;
                }
            }

            foreach ($punti_camp as $p) {
                $punto_camp .= ucfirst($p).', ';
            }

        }

        if($tipoPiastra == 'DG18')
        {
            $campioni_sup = $campioni->where('tipoCamp','S')->where('id_tipo_piastra',27);
            foreach ($campioni_sup as $c) {
                $pc = App\PuntoCampionamento::find($c->id_punto_camp);
                if($pc != null)
                {
                    $punti_camp[] = $pc->punto_campionamento;
                }
            }
            #count occurrences of each element in array
            $occurrences_array = array_count_values($punti_camp);
            $punti_camp = [];
            foreach ($occurrences_array as $key => $value) {
                if($value == $occorrenze)
                {
                    $punti_camp[] = $key;
                }
            }

            foreach ($punti_camp as $p) {
                $punto_camp .= ucfirst($p).', ';
            }
        }

        return rtrim($punto_camp,', ');

        
    }

    /**
     * La funzione restituisce la descrizione associata all'utente rilevatore
     * 
     * @param mixed $array
     * @param mixed $index
     * 
     * @return String descrizione
     */
    function getDescrizioneRilevatore($array,$index)
    {
        $descrizione = "Rilevatore del campionamento";
        $index = trim($index);
        if((count($array) > 0))
        {
            if(isset($array[$index]))
            {
                $descrizione = $array[$index];
            }
        }

        return $descrizione;
    }

    function toFixed($number, $decimals) 
    {
        return number_format($number, $decimals, '.', "");
    }
      

    function get_micro_su_piastra($id_campione)
    {
        $microrganismisupiastra = App\MicroSuPiastra::where('id_campione',$id_campione)->get();
        $array = Array();

        if($microrganismisupiastra != null)
        {
            foreach ($microrganismisupiastra as $value) {
                $microrganismo = App\MicrorganismoPiastra::find($value->id_microrganismo);
                if($microrganismo != null)
                {
                    $id_tupla = $value->id;
                    $cfu = $value->CFU;
                    $microrganismo_nome = $microrganismo->microrganismo;
                    $cfu_m = ($value->CFU/23.75*10000);
                    $cfu_m = toFixed($cfu_m,2);
                    $cfu_m_s = $cfu_m . " CFU/m²";
                    $cfu_m_a = $cfu . " CFU/m³";
                    $cfu_h = $cfu . " CFU/4h";
                    $incertezzaSx = $value->incertezzaSx;
                    $incertezzaDx = $value->incertezzaDx;
                    $array_object = ['id' => $id_tupla,'id_microrganismo'=> $microrganismo->id, 'id_tipopiastra' => $value->id_tipopiastra,'nome' => $microrganismo_nome,'cfu' => $cfu,'cfu_m' => $cfu_m,'cfu_m_s' => $cfu_m_s, 'cfu_m_a' => $cfu_m_a, 'cfu_h' => $cfu_h,'incertezzasx' => $incertezzaSx,'incertezzadx' => $incertezzaDx, 'deletable' => 1];
                    array_push($array,$array_object);
                }
            }
        }
        return $array;  
    }

    function get_micro_su_piastraSWAB($id)
    {
        $microrganismisupiastra = App\MicroSuPiastraSwab::where('id_campione',$id)->get();
        $array = Array();

        if($microrganismisupiastra != null)
        {
            foreach ($microrganismisupiastra as $value) {
                $microrganismo = App\MicrorganismoPiastra::find($value->id_microrganismo);
                if($microrganismo != null)
                {
                    $id_tupla = $value->id;
                    $presente = $value->presente;
                    $microrganismo_nome = $microrganismo->microrganismo;
                    $id_tipopiaastra = $value->id_tipopiastra;
                    $array_object = ['id' => $id_tupla,'id_microrganismo'=> $microrganismo->id, 'id_tipopiastra' => $value->id_tipopiastra,'nome' => $microrganismo_nome,'presente' => $presente, 'deletable' => 1];
                    array_push($array,$array_object);
                }
            }
        }

        return $array;  
    }

    function get_speciazioni($id)
    {   
        if($id == null || $id == '')
        {
            return null;
        }

        $speciazioni = App\SpeciazioneCampione::where('id_campione',$id)->get();

        if($speciazioni == null)
        {
            return null;
        }

        $array = Array();
        foreach ($speciazioni as $value) {
            $microrganismo = App\MicrorganismoPiastra::find($value->id_microrganismo);
            if($microrganismo != null)
            {
                $id_tupla = $value->id;
                $microrganismo_nome = $microrganismo->microrganismo;

                $array_object = ['id' => $id_tupla,'id_microrganismo'=> $microrganismo->id, 'id_tipopiastra' => $value->id_tipopiastra,'nome' => $microrganismo_nome,'speciazione_risultato' => $value->esito, 'tipoCamp' => $value->tipoCamp, 'deletable' => 1];
                array_push($array,$array_object);
            }
            else return null;
        }

        return $array;

    }

    function get_antibio_res($id,$nab, $analisimolecolari = false)
    {
        $array = Array();

        if($analisimolecolari == false)
        {
            $ar = App\AntibioticoAntibiogramma::where('id_campione',$id)->where('NAB',$nab)->get();
    
            if($ar != null)
            {
                $res = App\Antibiotico::resistenza();
                foreach ($ar as $value) {
                    $antibiotico = App\Antibiotico::find($value->id_antibiotico);
                    foreach ($res as $key => $v) {
                        if($value->resistenza == $key)
                        {
                            $resistenza = $v;
                            $k_res = $key;
                        }
                    }
                    $array_object = ['id_ar' => $value->id,'id_antibiotico' => $antibiotico->id, 'nome_antibiotico' => $antibiotico->nome, 'key_resistenza' => $k_res, 'resistenza' => $resistenza, 'deletable' => 1];
                    array_push($array,$array_object);
                }
            }
        }
        else
        {
            $ar = App\AntibioticoAntibiogrammaSwab::where('id_campione_analisi_molecolare',$id)->where('NAB',$nab)->get();
    
            if($ar != null)
            {
                $res = App\Antibiotico::resistenza();
                foreach ($ar as $value) {
                    $antibiotico = App\Antibiotico::find($value->id_antibiotico);
                    foreach ($res as $key => $v) {
                        if($value->resistenza == $key)
                        {
                            $resistenza = $v;
                            $k_res = $key;
                        }
                    }
                    $array_object = ['id_ar' => $value->id,'id_antibiotico' => $antibiotico->id, 'nome_antibiotico' => $antibiotico->nome, 'key_resistenza' => $k_res, 'resistenza' => $resistenza, 'deletable' => 1];
                    array_push($array,$array_object);
                }
            }
        }
        
        return $array;
    }

    function checkImmagine($id,$tipo,$code,$analisimolecolari = false)
    {
        /**
         *  0 -> non c'è immagine, ne definitiva ne temporanea
         *  1 -> c'è l'immagine, nella tabella definitiva
         */

        $check = 0; 
        if($analisimolecolari == true)
        {
            $campione = App\CampioneAnalisiMolecolare::find($id);
        }
        else
        {
            $campione = App\Campione::find($id);
        }
        if($campione != null)
        {
            switch ($tipo) {
                case 'piastra1':
                    $piastra1 = $campione->immaginipiastre->where('tipo',$tipo)->first();
                    if($piastra1 != null)
                    {
                        $check = 1;
                    }
                    break;
                case 'piastra2':
                    $piastra2 = $campione->immaginipiastre->where('tipo',$tipo)->first();
                    if($piastra2 != null)
                    {
                        $check = 1;
                    }
                    break;
                case 'tampone':
                    $tampone = $campione->immaginipiastre->where('tipo',$tipo)->first();
                    if($tampone != null)
                    {
                        $check = 1;
                    }
                    break;
                case 'striscio':
                    $striscio = $campione->immaginipiastre->where('tipo',$tipo)->first();
                    if($striscio != null)
                    {
                        $check = 1;
                    }
                    break;
                case 'antibiogramma0':
                    $mab = $campione->microantibiogramma->where('NAB',0)->first();
                    $immagine = $campione->immaginimicroantibiogramma->where('tipo',$tipo)->first();
                    if($mab != null && $immagine != null)
                    {
                        $check = 1;
                    }
                    break;
                case 'antibiogramma':
                    # code...
                    break;
                
                default:
                    # code...
                    break;
            }
           
        }
        return $check;
    }

    function generateUniqueCode()
    {
        do {
            $code = random_int(100000, 999999);
        } while (App\TemporaryImage::where("code", "=", $code)->first());
  
        return $code;
    }

    function getImageTemporary($code,$tipo)
    {
        $temporaryImage = App\TemporaryImage::where('code',$code)->where('tipo',$tipo)->first();
        if($temporaryImage != null)
        {
            return $temporaryImage->nome_file;
        }
        
        return '';
    }

    function getImageName($id,$tipo)
    {
        $image = App\ImmaginiPiastre::where('id_campione',$id)->where('tipo',$tipo)->first();
        //Log::info($image);
        if($image != null)
        {
            return $image->nome_file;
        }
        
        return '';
    }

    function getImageNameSwab($id,$tipo)
    {
        $image = App\ImmaginiPiastreSwab::where('id_campione',$id)->where('tipo',$tipo)->first();
        //Log::info($image);
        if($image != null)
        {
            return $image->nome_file;
        }
        
        return '';
    }

    function getImageMicroAntibio($id,$tipo)
    {
        $image = App\ImmagineMicroAntibiogramma::where('id_campione',$id)->where('tipo',$tipo)->first();
        //Log::info($image);
        if($image != null)
        {
            return $image->nome_file;
        }
        
        return '';
    }

    function getImageMicroAntibioSwab($id,$tipo)
    {
        $image = App\ImmagineMicroAntibiogrammaSwab::where('id_campione',$id)->where('tipo',$tipo)->first();
        //Log::info($image);
        if($image != null)
        {
            return $image->nome_file;
        }
        
        return '';
    }

    function getAreaOfPartizione($associazione)
    {
        return App\AreaPartizione::where('id',$associazione)->first() ?  App\AreaPartizione::where('id',$associazione)->first()->area_partizione : '';
    }

    // ai fini della generazione del rapporto di prova
    // si cerca di capire che tipo di substrato è stato usato: PCA - DG18 - entrambi
    // 0 per nessuno (Errore probabilmente)
    // 1 per PCA
    // 2 per DG18
    // 3 per entrambi
    function tipo_di_substrato($campioni)
    {
        $substrato_pca = 0;
        $substrato_dg18 = 0;

        if($campioni == null)
        {
            return 0;
        }
        
        foreach($campioni as $campione)
        {
            if($campione->id_tipo_piastra == 26)
            {
                $substrato_pca = 1;
            }
            elseif($campione->id_tipo_piastra == 27)
            {
                $substrato_dg18 = 1;
            }
        }

        if($substrato_pca == 1 && $substrato_dg18 == 1)
        {
            return 3; //PCA e DG18
        }
        elseif($substrato_pca == 1 && $substrato_dg18 == 0)
        {
            return 1; //PCA
        }
        elseif($substrato_pca == 0 && $substrato_dg18 == 1)
        {
            return 2; //DG18
        }
        else
        {
            return 0; //Nessuno dei due
        }
    }

    function format_condizioni_durata_incubazione($tipo_di_substrato,$campioni)
    {
        $tempo_di_incubazione = ['pca' => '','dg18' => ''];
        $condizioni_di_incubazione = ['pca' => '','dg18' => ''];
        $condizioni_e_durata = ['pca' => '/','dg18' => '/'];

        if($tipo_di_substrato == 1 || $tipo_di_substrato == 3)
        {
            $tempo_di_incubazione['pca'] = $campioni->where('id_tipo_piastra',26)->first()->t_inc;
            $condizioni_di_incubazione['pca'] = $campioni->where('id_tipo_piastra',26)->first()->condizione_incubazione;

        }

        if($tipo_di_substrato == 2 || $tipo_di_substrato == 3)
        {
            $tempo_di_incubazione['dg18'] = $campioni->where('id_tipo_piastra',27)->first()->t_inc;
            $condizioni_di_incubazione['dg18'] = $campioni->where('id_tipo_piastra',27)->first()->condizione_incubazione;
        }

        if($tempo_di_incubazione['pca'] == 120)
        {
            $condizioni_e_durata['pca'] = " da " . $tempo_di_incubazione['pca']." h a 168 h a (". $condizioni_di_incubazione['pca'] . " ± 1) °C";
        }
        else
        {
            $condizioni_e_durata['pca'] =  " (".$tempo_di_incubazione['pca']." ± 3) h a (".$condizioni_di_incubazione['pca']." ± 1) °C";
        }

        if($tempo_di_incubazione['dg18'] == 120)
        {
            $condizioni_e_durata['dg18'] = " da " . $tempo_di_incubazione['dg18']." h a 168 h a (". $condizioni_di_incubazione['dg18'] . " ± 1) °C";
        }
        else
        {
            $condizioni_e_durata['dg18'] = " (".$tempo_di_incubazione['dg18']." ± 3) h a (".$condizioni_di_incubazione['dg18']." ± 1) °C";
        }

        return $condizioni_e_durata;
       
        
    }

    function get_number_of_column($campioni)
    {
        if($campioni == null || count($campioni) == 0)
        {
            return 0;
        }

        $stanze = $campioni->groupBy('numStanza')->count();
        
        
        if($stanze <= 5)
        {
            return 5;
        }
        else
        {
            return 10;
        }
        
    }

    function note_di_campionamento($campioni, $column)
    {
        if($campioni == null || count($campioni) == 0)
        {
            return [];
        }

        $schede = Array();
        $i = 0; //counter -> mi serivrà per ottenere attributo html name dinamico e diverso (in base al numero della colonna)

        $stanze_trovate = Array(); //devo visualizzare in questa sezione solo le informazioni generale relative ai campionamenti fatti in questa stanza, senza visualizzare ogni singolo campionamento.
                                    //quindi uso un booleano per stoppare la ricerca se per la stanza in questione ho già riempito le informazioni necessarie.

        
        foreach ($campioni as $c) {
            if(!(isset($stanze_trovate[$c->numStanza])))
            {
                $stanze_trovate[$c->numStanza] = False;
            }
        }

        

        foreach($campioni as $c)
        {
            //tipo di ambiente
            $areaPartizione = App\AreaPartizione::find($c->id_areareparto);
            $reparto = App\Reparto::find($areaPartizione->id_reparto)->partizione;
            $codice_reparto = App\Reparto::find($areaPartizione->id_reparto)->codice_partizione;
            $area_partizione = $areaPartizione->area_partizione;
            $tipo_di_ambiente = $reparto ." ". $area_partizione;

            if(!($stanze_trovate[$c->numStanza]))
            {
                array_push($schede, [
                    'i' => ++$i,
                    'scheda' => 'si',
                    'codice_partizione_stanza' => $codice_reparto ."_".$c->numStanza,
                    'tipoCamp' => $c->tipoCamp,
                    'tipo_di_ambiente' => $tipo_di_ambiente,
                    'numero_e_codifica_locali' => $c->numStanza,
                    'classe_iso_di_riferimento' => App\Campione::get_iso_of_scheda($c->classificazioneISO),
                    'tipo_di_flusso' => $c->flusso,
                    'stato_di_occupazione' => $c->operat,
                    'n_persone_presenti' => $c->n_persone,
                ]);

                $stanze_trovate[$c->numStanza] = True;
            }
            
        }

        for($counter = $i+1; $counter <= $column; $counter++)
        {
            array_push($schede, [
                'i' => $counter,
                'scheda' => 'no',
                'codice_partizione_stanza' => '',
                'tipoCamp' => '/',
                'tipo_di_ambiente' => '/',
                'numero_e_codifica_locali' => '/',
                'classe_iso_di_riferimento' => '/',
                'tipo_di_flusso' => '/',
                'stato_di_occupazione' => '/',
                'n_persone_presenti' => '/',
            ]);
        }
        
        return $schede;
    }

    function campionamento_sez_3($campioni,$tipoCamp,$operat, $column)
    {
        if($campioni == null || count($campioni) == 0)
        {
            return [];
        }

        $schede = Array();
        $i = 0; //counter -> mi serivrà per ottenere attributo html name dinamico e diverso (in base al numero della colonna)

        $operativita = Array(); //devo visualizzare in questa sezione solo le informazioni generale relative ai campionamenti fatti in questa stanza, senza visualizzare ogni singolo campionamento.
                                    //quindi uso un booleano per stoppare la ricerca se per la stanza in questione ho già riempito le informazioni necessarie.
                                    //una colonna per campione raggruppati per operatività (At rest, operational)

        
        foreach ($campioni as $c) {
            if(!(isset($operativita[$c->numStanza])))
            {
                $operativita[$c->numStanza] = False;
            }
        }

        $campioni = $campioni->where('operat',$operat)->where('tipoCamp',$tipoCamp);

        foreach($campioni as $c)
        {
            //tipo di ambiente
            $areaPartizione = App\AreaPartizione::find($c->id_areareparto);
            $reparto = App\Reparto::find($areaPartizione->id_reparto)->partizione;
            $area_partizione = $areaPartizione->area_partizione;
            $tipo_di_ambiente = $reparto ." ". $area_partizione;

            if(!($operativita[$c->numStanza]))
            {
                array_push($schede, [
                    'i' => ++$i,
                    'scheda' => 'si',
                    'tipoCamp' => $c->tipoCamp,
                    'tipo_di_ambiente' => $tipo_di_ambiente,
                    'numero_e_codifica_locali' => $c->numStanza,
                    'dataInizio' => Carbon::parse($c->dataInizio)->format('Y-m-d'),
                    'oraInizio' => Carbon::parse($c->oraInizio)->format('H:i'),
                    'dataFine' => Carbon::parse($c->dataFine)->format('Y-m-d'),
                    'oraFine' => Carbon::parse($c->oraFine)->format('H:i'),
                    'classe_iso_di_riferimento' => App\Campione::get_iso_of_scheda($c->classificazioneISO),
                    'tipo_di_flusso' => $c->flusso,
                    'stato_di_occupazione' => $c->operat,
                    'n_persone_presenti' => $c->n_persone == 0 ? '0' : $c->n_persone,
                    'tecnico' => get_tecnico_rilevatore_campionamento($c->id)
                ]);

                $operativita[$c->numStanza] = True;
            }
            
        }

        for($counter = $i+1; $counter <= $column; $counter++)
        {
            array_push($schede, [
                'i' => $counter,
                'scheda' => 'no',
                'tipoCamp' => '/',
                'tipo_di_ambiente' => '/',
                'numero_e_codifica_locali' => '/',
                'classe_iso_di_riferimento' => '/',
                'tipo_di_flusso' => '/',
                'stato_di_occupazione' => '/',
                'n_persone_presenti' => '/',
            ]);
        }
        
        return $schede;
    }
    
    function get_tecnico_analisi_campione($campioni)
    {
        if($campioni == null || count($campioni) == 0)
        {
            return '';
        }
        if(gettype($campioni) == 'object')
        {
            $tecnico = App\Rilevatore::find($campioni->first()->tecnico);
        }
        else
        {
            $tecnico = App\Rilevatore::find($campioni[0]['tecnico']);
        }
        if($tecnico == null)
            return '';
        else
            return $tecnico->rilevatore;
    }

    function get_tecnico_rilevatore_campionamento($id)
    {
        $rilevatori_campioni = App\CampioniRilevatori::where('id_campione',$id)->get();
        $tecnici = "";

        foreach ($rilevatori_campioni as $rc) {
            $rilevatore = App\Rilevatore::find($rc->id_rilevatore);
            
            $tecnico = $rilevatore->rilevatore;

            $tecnici .= " " . ucfirst($tecnico) . ",";
        }
        #delete last char of string
        
        return rtrim($tecnici,",");
    }

    /**
     * PER CAMPIONAMENTO AD ARIA O SUPERFICI
     * 
     * Verifica che tipi di piastre sono stati usati per i campionamenti, andando a raggruppare i vari campioni per tipo di piastra, operatività e stanza.
     * 
     * I campioni PCA devono essere suddivisi in At rest -> R e Operat -> O.
     * I campioni PCA O devono essere poi divisi per stanza.
     * 
     */
    function get_campioni($campioni, $tipoCamp, $tipoCampione)
    {        
        if($campioni == null || count($campioni) == 0)
        {
            return [];
        }

        if(($tipoCamp != 'A' && $tipoCamp != 'S') || $tipoCamp == '' || $tipoCamp == null || ($tipoCampione != 'piastra' && $tipoCampione != 'tampone') || $tipoCampione == '' || $tipoCampione == null)
        {
            return [];
        }

        $piastre = [];
        $piastre['pca'] = [];
        $piastre['dg18'] = [];

        if($tipoCamp == 'S')
        {
            if(count($campioni->where('id_tipo_piastra',26)->where('tipoCamp',$tipoCamp)->where('tipoCampione',$tipoCampione)) > 0 || count($campioni->where('id_tipo_piastra',26)->where('tipoCamp',$tipoCamp)->where('tipoCampione',$tipoCampione)) > 0)
            {
                //tutti i campioni per la piastra pca
                $campioni_pca = [];
                foreach ($campioni as $c) 
                {
                    if(($c->id_tipo_piastra == 26 && $c->tipoCamp == $tipoCamp && $c->operat == 'R' && $c->tipoCampione == $tipoCampione) || ($c->id_tipo_piastra == 26 && $c->tipoCamp == $tipoCamp && $c->operat == 'R' && $c->tipoCampione == $tipoCampione))
                    {
                        array_push($campioni_pca, $c);
                    }
                }
                $piastre['pca'] = $campioni_pca;
            }

            if(count($campioni->where('id_tipo_piastra',27)->where('tipoCamp',$tipoCamp)->where('tipoCampione',$tipoCampione)) > 0 || count($campioni->where('id_tipo_piastra',27)->where('tipoCamp',$tipoCamp)) > 0)
            {
                //tutti i campioni per la piastra dg18
                $campioni_dg18 = [];
                foreach ($campioni as $c) 
                {
                    if(($c->id_tipo_piastra == 27 && $c->tipoCamp == $tipoCamp && $c->operat == 'R' && $c->tipoCampione == $tipoCampione) || ($c->id_tipo_piastra == 27 && $c->tipoCamp == $tipoCamp && $c->operat == 'R' && $c->tipoCampione == $tipoCampione))
                    {
                        array_push($campioni_dg18, $c);
                    }
                }
                $piastre['dg18'] = $campioni_dg18;            }
        }

        
        return $piastre;
    }

    function get_campioni_given_tipoCampionamento_tipoCampione($campioni, $tipoCamp)
    {
        $piastre = get_campioni($campioni,$tipoCamp,'piastra');
        $tamponi = get_campioni($campioni,$tipoCamp,'tampone');

        return ['piastra' => $piastre, 'tampone' => $tamponi];
    }

    function get_linea_guida_piastra($campione)
    {       
        $lineeguida = [
            'lineeGuida1' => 'ISPESL 2003',
            'lineeGuida2' => 'ISPESL 2009',
            'lineeGuida3' => 'GMP 2008',
            'lineeGuida4' => 'Standart IMQ'
        ];

        $lineaGuidaScelta = ''; 
        for($i = 1; $i <= 4; $i++)
        {
            if(gettype($campione) == 'object')
            {
                if($campione->{"lineeGuida".$i} != 0)
                {
                    $lineaGuidaScelta .= $lineeguida['lineeGuida'.$i] . " ";
                    break;
                }
            }
            else
            {
                if($campione["lineeGuida".$i] != 0)
                {
                    $lineaGuidaScelta .= $lineeguida['lineeGuida'.$i] . " ";
                    break;
                }
            }
            
        }

        return $lineaGuidaScelta;
    }

    function get_all_campioni_for_piastra($campioni,$id_piastra, $tipoCamp)
    {
        if($campioni == null || count($campioni) == 0)
        {
            return [];
        }

        $campioni_piastra_old = $campioni->where('id_tipo_piastra',$id_piastra)->where('tipoCamp',$tipoCamp);
        $campioni_piastra_new = $campioni->where('id_tipo_piastra',$id_piastra)->where('tipoCamp','A');
        $campioni_piastra = $campioni_piastra_old->merge($campioni_piastra_new);
        
        return $campioni_piastra;
    }

    function get_metodo($campioni)
    {
        if($campioni == null || count($campioni) == 0)
        {
            return [];
        }

        $metodi = [];
        
        $metodi['piastra'] = [];
        $metodi['tampone'] = [];
        
        $attivo_pca = [];
        $attivo_dg18 = [];
        $passivo_pca = [];
        $passivo_dg18 = [];

        foreach ($campioni as $tipo => $lista_campioni) {
            foreach ($lista_campioni as $tipo_campionamento => $campioni) {
                foreach($campioni as $c)
                {
                    if($c->pCampAria == 1 || $c->pCampAria == 2 || $c->pCampAria == 4)
                    {
                        
                    }
                    elseif($c->pCampAria == 3)
                    {
                        array_push($passivo, $c);
                    }
                }
            }
            
        }

        $attivo = $campioni->where('pCampAria',1)->where('tipoCamp','A')->first() ?? $campioni->where('pCampAria',2)->where('tipoCamp','A')->first() ?? $campioni->where('pCampAria',4)->where('tipoCamp','A')->first();
        $passivo = $campioni->where('pCampAria',3)->where('tipoCamp','A')->first();

        if($attivo != null && $passivo != null)
        {
            return ['attivo', 'passivo'];
        }
        elseif($attivo == null && $passivo != null)
        {
            return ['passivo'];
        }
        elseif($attivo != null && $passivo == null)
        {
            return ['attivo'];
        }
        else
        {
            return [];
        }   
    }

    function get_punto_camp($campione)
    {
        if($campione == null)
        {
            return '';
        }

        $punto_camp = '';

        

        if(gettype($campione) == 'object')
        {
            $tipo_camp = $campione->tipoCamp;
        }
        else
        {
            $tipo_camp = $campione['tipoCamp'];
        }

        if($tipo_camp == 'A')
        {
            if(gettype($campione) == 'object')
            {
                $punto_camp = App\PuntoCampionamento::where('id',$campione->pCampAria)->first()->punto_campionamento;
            }
            else
            {
                $punto_camp = App\PuntoCampionamento::where('id',$campione['pCampAria'])->first()->punto_campionamento;
            }
        }
        else
        {
            if(gettype($campione) == 'object')
            {
                $punto_camp = App\PuntoCampionamento::where('id',$campione->id_punto_camp)->first()->punto_campionamento;
            }
            else
            {
                $punto_camp = App\PuntoCampionamento::where('id',$campione['id_punto_camp'])->first()->punto_campionamento;
            }
        }

        return $punto_camp;
    }

    /**************************** */

    function get_micro_for_campione($campione)
    {
        if($campione == null)
        {
            return [];
        }

        $micro = ['SA' => 'NR', 'P' => 'NR', 'ANF' => 'NR', 'E' => 'NR'];
        $micro_su_piastra = App\MicroSuPiastra::where('id_campione',$campione->id)->get();

        if($micro_su_piastra == null || count($micro_su_piastra) == 0)
        {
            return ['SA' => 'NA', 'P' => 'NA', 'ANF' => 'NA', 'E' => 'NA'];
        }

        foreach($micro_su_piastra as $m)
        {
            $microrganismo = App\MicrorganismoPiastra::where('id',$m->id_microrganismo)->first();
            
            switch ($microrganismo->id) {
                case 63:
                    $micro['SA'] = 'R';
                    break;
                
                case 57:
                    $micro['P'] = 'R';
                    break;
                    
                case 13:
                    $micro['ANF'] = 'R';
                    break;

                case 12:
                    $micro['ANF'] = 'R';
                    break;
                
                case 11:
                    $micro['ANF'] = 'R';
                    break;
                    
                default:
                    if($microrganismo->entBac == 1 && $microrganismo->batGramN == 1)
                    {
                        $micro['E'] = 'R';
                    }
                    break;
            }
        }

        //Log::info($micro);

        return $micro;
    }
    

    function get_cfu_micro_piastra($campione)
    {
        if($campione == null)
        {
            return '';
        }

        $id_campione = "";
        $id_tipo_piastra = "";
        
        if(gettype($campione) == 'object')
        {
            $id_campione = $campione->id;
            $id_tipo_piastra = $campione->id_tipo_piastra;
        }
        else
        {
            $id_campione = $campione['id'];
            $id_tipo_piastra = $campione['id_tipo_piastra'];
        }

        $micropiastra = App\MicroSuPiastra::where('id_campione',$id_campione)
                                    ->where('id_tipopiastra',$id_tipo_piastra)
                                    ->first();

        if($micropiastra == null)
        {
            return '';
        }

        $cfu = $micropiastra->CFU;
        return $cfu;
    }

    function get_microrganismi_ricercati_campione($campioni)
    {
        if($campioni == null)
        {
            return [];
        }

        $microrganismi = [];

        foreach($campioni as $campione)
        {
            $microrganismi[] = $campione->microrganismo_ricercato;
        }

        # remove duplicate 
        $microrganismi = array_unique($microrganismi);
        
        $microrganismi_ricercati = "";
        foreach($microrganismi as $m)
        {
            $microrganismi_ricercati .= $m . ', ';
        }

        return rtrim($microrganismi_ricercati, ', ');
    }

    function getMetodo($campioni)
    {
        if($campioni == null)
        {
            return '';
        }

        $metodo = '';

        if(gettype($campioni) == 'object')
        {
            $metodo = App\Metodo::where('id',$campioni->first()->id_metodo)->first();
            if($metodo != null)
            {
                $metodo = $metodo->metodo;
            }
        }
        else
        {
            $metodo = App\Metodo::where('id',$campioni[0]['id_metodo'])->first();
            if($metodo != null)
            {
                $metodo = $metodo->metodo;
            }
        }

        return $metodo;
    }

    function getDescrizioneMetodo($campioni)
    {
        if($campioni == null)
        {
            return '';
        }

        $metodo = '';

        if(gettype($campioni) == 'object')
        {
            $metodo = App\Metodo::where('id',$campioni->first()->id_metodo)->first();
            if($metodo != null)
            {
                $metodo = $metodo->descrizione_prova;
            }
        }
        else
        {
            $metodo = App\Metodo::where('id',$campioni[0]['id_metodo'])->first();
            if($metodo != null)
            {
                $metodo = $metodo->descrizione_prova;
            }
        }

        return $metodo;

    }

    function getStrumenti($strumenti)
    {
        $strum = '';
        
        if($strumenti == '/' || $strumenti == null)
        {
            return '/';
        }

        foreach ($strumenti as $s) {
            $strum .= $s . ', ';
        }

        return rtrim($strum, ', ');
    }

    function getIncertezza($campione)
    {
        if($campione == null)
        {
            return '';
        }

        $incertezza = 'NA';

        if(gettype($campione) == 'object')
        {
            $micro_su_piastra = App\MicroSuPiastra::where('id_campione',$campione->id)->first();
            if($micro_su_piastra != null && $micro_su_piastra->incertezzaSx != null && $micro_su_piastra->incertezzaDx != null)
            {
                $incertezza = $micro_su_piastra->incertezzaSx . " - " . $micro_su_piastra->incertezzaDx;
            }
        }
        else
        {
            $micro_su_piastra = App\MicroSuPiastra::where('id_campione',$campione['id'])->first();
            if($micro_su_piastra != null && $micro_su_piastra->incertezzaSx != null && $micro_su_piastra->incertezzaDx != null)
            {
                $incertezza = $micro_su_piastra->incertezzaSx . " - " . $micro_su_piastra->incertezzaDx;
            }
        }

        return $incertezza;
    }

    function getAllResults($campioni){
        
        $results = ['NR' => [], 'R' => []];
        $campioni_NR = [];
        $campioni_R = [];
        if($campioni == null || count($campioni) == 0)
        {
            return [];
        }

        if(count($campioni) == 1)
        {
            if($campioni->first()->risultato == 'NR')
            {
                $results['NR'] = $campioni;
                $results['R'] = [];
            }
            else
            {
                $results['NR'] = [];
                $results['R'] = $campioni;
            }
            return $results;
        }
        
        foreach ($campioni as $c) {
            if($c->risultato == 'NR')
            {
                $campioni_NR[] = $c;
            }
            else
            {
                $campioni_R[] = $c;
            }
        }

        $campioni_id = [];
        foreach ($campioni as $c) {
            $campioni_id[$c->id_campione] = 0;
        }

        # check if each element of $campioni_NR is in $campioni_R
        # insert before the NR and then all the R
        $array = [];
        foreach ($campioni_NR as $c_NR) {
            $found = false;
            foreach ($campioni_R as $c_R) {
                if($c_NR->id_campione == $c_R->id_campione)
                {
                    $found = true;
                    break;
                }
            }

            if(!$found && $campioni_id[$c_NR->id_campione] == 0)
            {
                $campioni_id[$c_NR->id_campione] = 1;
                $array[] = $c_NR;
            }
        }

        $results['NR'] = $array;

        $array = [];
        foreach ($campioni_NR as $c_NR) {
            foreach ($campioni_R as $c_R) {
                if($c_NR->id == $c_R->id)
                {
                    $array[] = $c_R;
                    break;
                }
            }
        }
        /**delete duplicate */
        $array = array_unique($array, SORT_REGULAR);
        
        $results['R'] = $array;
        

        return $results;
        

    }

    function getPlanimetriaName($file)
    {
        $namefile = explode('/',$file);
        $namefile = $namefile[count($namefile)-1];
        return $namefile;
    }