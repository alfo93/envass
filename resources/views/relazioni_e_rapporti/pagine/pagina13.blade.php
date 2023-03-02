<!-- riferimenti -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group mb-0">
            <ul role="listbox" tabindex="0" aria-label="list" style="list-style: none;">
                <li tabindex="-1" role="option" aria-checked="false" >
                    <div class="form-check mb-0">
                        <input tabindex="-1" id="check1" name="riferimento1" class="form-check-input" type="checkbox" {{ is_checked($anteprima == 1 && isset($rdp_anteprima->riferimento1) ? $rdp_anteprima->riferimento1 : 0)}}><label for="check1" class="form-check-label"><p><b>Riferimento 1</b></p>.</label>
                        <div><p>GMP Annex 1 del 2008, limiti raccomandati per il monitoraggio microbiologico di aree pulite durante il funzionamento.</p></div> <br><br>
                        <table style="border: 1px solid">
                            <thead style="border: 1px solid">
                                <tr style="border: 1px solid">
                                    <th colspan="5" style="border: 1px solid">
                                        Limiti raccomandati per la contaminazione microbica
                                    </th>
                                </tr>
                                <tr style="border: 1px solid">
                                    <th style="border: 1px solid; text-align: center;">
                                        Grado
                                    </th>
                                    <th style="border: 1px solid; text-align: center;">
                                        Campione d’aria CFU/m&#179;
                                    </th>
                                    <th style="border: 1px solid; text-align: center;">
                                        Microrganismi per deposizione su piastra (diam. 90mm) CFU/4 ore(*)
                                    </th>
                                    <th style="border: 1px solid; text-align: center;">
                                        Piastre per contatto (diam. 55 mm) CFU/piastra
                                    </th>
                                    <th style="border: 1px solid; text-align: center;">
                                        Impronta delle 5 dita del guanto CFU/guanto
                                    </th>
                                </tr>
                            </thead>
                            <tbody style="border: 1px solid; text-align: center;">
                                <tr style="border: 1px solid; text-align: center;">
                                    <td style="border: 1px solid; text-align: center;">
                                        A
                                    </td>
                                    <td style="border: 1px solid; text-align: center;">
                                        < 1
                                    </td>
                                    <td style="border: 1px solid; text-align: center;">
                                        < 1
                                    </td>
                                    <td style="border: 1px solid; text-align: center;">
                                        < 1
                                    </td>
                                    <td style="border: 1px solid; text-align: center;">
                                        < 1
                                    </td>
                                </tr>
                                <tr style="border: 1px solid; text-align: center;">
                                    <td style="border: 1px solid; text-align: center;">
                                        B
                                    </td>
                                    <td style="border: 1px solid; text-align: center;">
                                        10
                                    </td>
                                    <td style="border: 1px solid; text-align: center;">
                                        5
                                    </td>
                                    <td style="border: 1px solid; text-align: center;">
                                        5
                                    </td>
                                    <td style="border: 1px solid; text-align: center;">
                                        5
                                    </td>
                                </tr>
                                <tr style="border: 1px solid; text-align: center;">
                                    <td style="border: 1px solid; text-align: center;">
                                        C
                                    </td>
                                    <td style="border: 1px solid; text-align: center;">
                                        100
                                    </td>
                                    <td style="border: 1px solid; text-align: center;">
                                        50
                                    </td>
                                    <td style="border: 1px solid; text-align: center;">
                                        25
                                    </td>
                                    <td style="border: 1px solid; text-align: center;">
                                        -
                                    </td>
                                </tr>
                                <tr style="border: 1px solid; text-align: center;">
                                    <td style="border: 1px solid; text-align: center;">
                                        D
                                    </td>
                                    <td style="border: 1px solid; text-align: center;">
                                        200
                                    </td>
                                    <td style="border: 1px solid; text-align: center;">
                                        100
                                    </td>
                                    <td style="border: 1px solid; text-align: center;">
                                        50
                                    </td>
                                    <td style="border: 1px solid; text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot style="border: 1px solid">
                                <tr style="border: 1px solid">
                                    <td colspan="5" style="border: 1px solid">
                                        Note: (*) Le singole piastre di sedimentazione possono essere esposte per meno di 4 ore.
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </li>
                <br><br><hr>
                <li tabindex="-1" role="option" aria-checked="false" >
                    <div class="form-check mb-0">
                        <input tabindex="-1" id="check2" name="riferimento2" class="form-check-input" type="checkbox" {{ is_checked($anteprima == 1 && isset($rdp_anteprima->riferimento2) ? $rdp_anteprima->riferimento2 : 0)}}><label for="check2" class="form-check-label"><p><b>Riferimento 2</b></p>.</label><br>
                        <div>Contaminazione microbiologica dell’aria in condizioni At-Rest (capitolo 3.3.1 – ISPESL 2009):
                        la contaminazione biologica nell’aria ambiente, in prossimità del tavolo operatorio, per sala operatoria convenzionale in condizioni di riposo, con impianto VCCC a flusso turbolento, non deve superare o essere uguale al valore di 35 UFC/m&#179;.</div>
                    </div>
                </li>
                <br><br><hr>
                <li tabindex="-1" role="option" aria-checked="false" >
                    <div class="form-check mb-0">
                        <input tabindex="-1" id="check3" name="riferimento3" class="form-check-input" type="checkbox" {{ is_checked($anteprima == 1 && isset($rdp_anteprima->riferimento3) ? $rdp_anteprima->riferimento3 : 0)}}><label for="check3" class="form-check-label"><p><b>Riferimento 3</b></p>.</label>
                        <div>Contaminazione microbiologica dell’aria in condizioni At-Rest (capitolo 3.3.1 – ISPESL 2009):
                        la contaminazione microbiologica dell’aria in condizioni At-Rest è accettabile solo in assenza di germi patogeni (S. Aureus, A. Niger, A. fumigatus e bacilli gram-)</div>
                    </div>
                </li>
                <br><br><hr>
                <li tabindex="-1" role="option" aria-checked="false" >
                    <div class="form-check mb-0">
                        <input tabindex="-1" id="check4" name="riferimento4" class="form-check-input" type="checkbox" {{ is_checked($anteprima == 1 && isset($rdp_anteprima->riferimento4) ? $rdp_anteprima->riferimento4 : 0)}}><label for="check4" class="form-check-label"><p><b>Riferimento 4</b></p>.</label>
                        <div>Contaminazione microbiologica dell’aria in condizioni Operational (capitolo 3.3.2 – ISPESL 2009)
                        la contaminazione biologica nell’aria ambiente, in prossimità del tavolo operatorio, per sala operatoria convenzionale in attività non deve superare o essere uguale al valore di 180 UFC/m&#179; con impianto VCCC a flusso turbolento.</div>
                    </div>
                </li>
                <br><br><hr>
                <li tabindex="-1" role="option" aria-checked="false" >
                    <div class="form-check mb-0">
                        <input tabindex="-1" id="check5" name="riferimento5" class="form-check-input" type="checkbox" {{ is_checked($anteprima == 1 && isset($rdp_anteprima->riferimento5) ? $rdp_anteprima->riferimento5 : 0)}}><label for="check5" class="form-check-label"><p><b>Riferimento 5</b></p>.</label>
                        <div>Contaminazione microbiologica dell’aria in condizioni Operational (capitolo 3.3.2 – ISPESL 2009):
                        la contaminazione biologica nell’aria ambiente, in prossimità del tavolo operatorio, per sala operatoria convenzionale in attività, non deve superare o essere uguale al valore di 20 UFC/m&#179; con impianto VCCC a flusso unidirezionale.</div>
                    </div>
                </li>
                <br><br><hr>
                <li tabindex="-1" role="option" aria-checked="false" >
                    <div class="form-check mb-0">
                        <input tabindex="-1" id="check6" name="riferimento6" class="form-check-input" type="checkbox" {{ is_checked($anteprima == 1 && isset($rdp_anteprima->riferimento6) ? $rdp_anteprima->riferimento6 : 0)}}><label for="check6" class="form-check-label"><p><b>Riferimento 6</b></p>.</label>
                        <div>Contaminazione microbiologica dell’aria immessa dall’impianto di VCCC in condizioni at rest in prossimità della bocchetta di mandata (ISPESL 2003): la contaminazione biologica nell’aria ambiente per sala operatoria deve risultare < 1 UFC/m&#179;.
                        Per ciò che attiene alla contaminazione delle superfici, di seguito è riportata per la tabella di riferimento ricavata dalle Linee Guida ISPESL 2009.</div>
                    </div>
                </li>
                <br><br><hr>
                <li tabindex="-1" role="option" aria-checked="false" >
                    <div class="form-check mb-0">
                        <input tabindex="-1" id="check7" name="riferimento7" class="form-check-input" type="checkbox" {{ is_checked($anteprima == 1 && isset($rdp_anteprima->riferimento7) ? $rdp_anteprima->riferimento7 : 0)}}><label for="check7" class="form-check-label"><p><b>Riferimento 7</b></p>.</label>
                        <div>Contaminazione microbiologica sulle superfici in condizioni At Rest (Tabella 4 – ISPESL 2009)</div> 
                        <br><br>
                        <ul role="listbox" tabindex="0" aria-label="list" style="list-style: none;">
                            <li tabindex="-1" role="option" aria-checked="false" >
                                <div class="form-check mb-0">
                                    <input tabindex="-1" id="check7_table1" name="riferimento7_table1" class="form-check-input" type="checkbox" {{ is_checked($anteprima == 1 && isset($rdp_anteprima->riferimento7_table1) ? $rdp_anteprima->riferimento7_table1 : 0)}}>
                                    <label for="check7_table1" class="form-check-label">
                                        Tabella 1
                                    </label>
                                </div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="border: 1px solid; text-align: center;">
                                                Locali
                                            </th>
                                            <th style="border: 1px solid; text-align: center;">
                                                Obiettivi
                                            </th>
                                            <th style="border: 1px solid; text-align: center;">
                                                Tecniche
                                            </th>
                                            <th style="border: 1px solid; text-align: center;">
                                                Risultati attesi (UFC/piastra)
                                            </th>
                                            <th style="border: 1px solid; text-align: center;">
                                                Provvedimenti se risultati non conformi (X=risultato ottenuto)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="border: 1px solid; text-align: center;">
                                                Sale operatorie
                                            </td>
                                            <td style="border: 1px solid; text-align: center;">
                                                Conformità della disinfezione e del trattamento dell’aria
                                            </td>
                                            <td style="border: 1px solid; text-align: center;">
                                                Contatto
                                            </td>
                                            <td style="border: 1px solid; text-align: center;">
                                                ≤ 5
                                            </td>
                                            <td style="border: 1px solid;">
                                                <ul class="dashed">
                                                    <li>
                                                        Se 5 < X ≤ 15 accettabile
                                                    </li>
                                                    <li>
                                                        Se X ≥ 15 in:
                                                        <ul class="dashed">
                                                            <li>
                                                                1 punto accettabile
                                                            </li>
                                                            <li>
                                                                2-4 punti segnalazione - rivedere il protocollo di pulizia e la sua attuazione
                                                            </li>
                                                            <li>
                                                                5 inaccettabile
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        Se presenti S. aureus, Enterobatteri, Aspergillus spp., Pseudomonas spp., rivedere interamente il protocollo di pulizia e programmare nuovi controlli
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> 
                            </li>
                            <br><br>
                            <li tabindex="-1" role="option" aria-checked="false" >
                                <div class="form-check mb-0">
                                    <input tabindex="-1" id="check7_table2" name="riferimento7_table2" class="form-check-input" type="checkbox" {{ is_checked($anteprima == 1 && isset($rdp_anteprima->riferimento7_table2) ? $rdp_anteprima->riferimento7_table2 : 0)}}>
                                    <label for="check7_table2" class="form-check-label"> Tabella 2 </label>
                                </div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="border: 1px solid; text-align: center;">
                                                Locali
                                            </th>
                                            <th style="border: 1px solid; text-align: center;">
                                                Obiettivi
                                            </th>
                                            <th style="border: 1px solid; text-align: center;">
                                                Tecniche
                                            </th>
                                            <th style="border: 1px solid; text-align: center;">
                                                Risultati attesi (UFC/piastra)
                                            </th>
                                            <th style="border: 1px solid; text-align: center;">
                                                Provvedimenti se risultati non conformi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="border: 1px solid; text-align: center;">
                                                Degenza prepost intervento Rianimazioni Neonatologia
                                            </td>
                                            <td style="border: 1px solid; text-align: center;">
                                                Controllo del protocollo di disinfezione e conformità della pulizia
                                            </td>
                                            <td style="border: 1px solid; text-align: center;">
                                                Contatto
                                            </td>
                                            <td style="border: 1px solid; text-align: center;">
                                                ≤ 50UFC/piastra <br>Senza agenti patogeni: S. aureus, enterobatteri, Aspergillus spp, Pseudomonas spp
                                            </td>
                                            <td style="border: 1px solid; text-align: center;">
                                                - Se > 50: rivedere il protocollo.
                                            </td>
                                        </tr>   
                                    </tbody>
                                </table>
                            </li>
                        </ul>
                        <br><br>
                        <p>
                            <b>Esecuzione della prova</b><br>
                            La quantificazione della CMT è stata effettuata nelle modalità e siti d’indagine descritti dal piano di campionamento.
                            {{-- <ul>
                                <li>
                                    aria ambiente in prossimità del campo operatorio (centro stanza)  a sala operatoria “at-rest”, ad un’altezza di circa 1,5 m dal pavimento.
                                </li>
                                <li>
                                    Sulle superfici ambientali dopo la sanificazione e in condizioni "at-rest".
                                </li>
                                <li>
                                    aria ambiente in prossimità del campo operatorio in condizioni di operational, ad un’altezza di 1,5 m dal pavimento e nel raggio di circa 1 m dal taglio chirurgico.
                                </li>
                            </ul> --}}
                        </p>
                        <br>
                        <p>
                            <ul role="listbox" tabindex="0" aria-label="list" style="list-style: none;">
                                <li  tabindex="-1" role="option" aria-checked="false" >
                                    <div class="form-check mb-0">
                                        <input tabindex="-1" id="check8_indicazione1" name="riferimento8_indicazione1" class="form-check-input" type="checkbox" {{ is_checked($anteprima == 1 && isset($rdp_anteprima->riferimento8_indicazione1) ? $rdp_anteprima->riferimento8_indicazione1 : 0)}}>
                                        <label for="check8_indicazione1" class="form-check-label">
                                            <p>
                                            La determinazione dei microrganismi aerodispersi è stata eseguita secondo le indicazioni della norma ISO 14698-1.
                                            Per la valutazione microbica dell’aria, il campionamento passivo è uno fra i metodi più tradizionali: <br>
                                            piastre con terreno generico o selettivo vengono esposte nell’ambiente in esame, <br>
                                            ad intervalli di tempo adeguati, per permettere la crescita di <br>
                                            microrganismi sospesi nell’aria che si depositano in piastra per sedimentazione.
                                            </p>
                                        </label>
                                    </div>
                                </li>
                                <br><br><br>
                                <li  tabindex="-1" role="option" aria-checked="false">
                                    <div class="form-check mb-0">
                                        <input tabindex="-1" id="check8_indicazione2" name="riferimento8_indicazione2" class="form-check-input" type="checkbox" {{ is_checked($anteprima == 1 && isset($rdp_anteprima->riferimento8_indicazione2) ? $rdp_anteprima->riferimento8_indicazione2 : 0)}}>
                                        <label for="check8_indicazione2" class="form-check-label">
                                            <p>
                                            La determinazione dei microrganismi aerodispersi è stata eseguita secondo le indicazioni della norma ISO 14698-1.
                                            Per il campionamento del bioaerosol, il metodo attivo risulta essere maggiormente affidabile <br> 
                                            in termini di efficienza di campionamento e di percentuale di rilevazione di microrganismi.<br>
                                            Per la prova si è utilizzato il campionatore SAS (Surface Air System), che prevede l’impiego di piastre Rodac di 55 mm di diametro,<br>
                                            contenenti terreno di coltura idoneo a favorire la crescita dei microrganismi. <br>
                                            Il SAS è stato impostato per un volume d’aspirazione di 
                                            <input style="width: 70px; height: 20px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143; " tabindex="-1" id="riferimento8_portata" name="riferimento8_portata" value="{{ $anteprima == 1 && isset($rdp_anteprima->riferimento8_portata) ? $rdp_anteprima->riferimento8_portata : '' }}" class="form-check-input" type="text">
                                            /piastra.
                                            </p>
                                        </label>
                                    </div>
                                </li>
                            </ul>
                            <br><br>
                        </p>
                        <br><br><br>
                        <ul role="listbox" tabindex="0" aria-label="list" style="list-style: none;">
                            <li  tabindex="-1" role="option" aria-checked="false" >
                                <div class="form-check mb-0">
                                    <input tabindex="-1" id="check8_indicazione3" name="riferimento8_indicazione3" class="form-check-input" type="checkbox" {{ is_checked($anteprima == 1 && isset($rdp_anteprima->riferimento8_indicazione3) ? $rdp_anteprima->riferimento8_indicazione3 : 0)}}>
                                    <label for="check8_indicazione3" class="form-check-label">
                                        <p>
                                        Per promuovere la crescita mesofila, vengono utilizzate piastre PCA (Plate Count Agar) per essere incubate a 30°C per 72±3 ore; 
                                        </p>
                                    </label>
                                </div>
                            </li>
                            <li  tabindex="-1" role="option" aria-checked="false">
                                <div class="form-check mb-0">
                                    <input tabindex="-1" id="check8_indicazione4" name="riferimento8_indicazione4" class="form-check-input" type="checkbox" {{ is_checked($anteprima == 1 && isset($rdp_anteprima->riferimento8_indicazione4) ? $rdp_anteprima->riferimento8_indicazione4 : 0)}}>
                                    <label for="check8_indicazione4" class="form-check-label">
                                        <p>
                                        per promuovere la crescita micotica, vengono utilizzate  DG18 (Dichloran Glycerol Agar) per essere incubate a 25°C per 120-172 ore.
                                        </p>
                                    </label>
                                </div>
                            </li>
                        </ul>
                        <p>
                            Per ogni data di campionamento è stata eseguita la prova di sterilità, incubando in parallelo, alle temperature e per i tempi previsti, una piastra vergine per ogni lotto di piastra utilizzata.
                        </p>
                    </div>
                </li>
            </ul>
        </div>      
    </div>
</div>
