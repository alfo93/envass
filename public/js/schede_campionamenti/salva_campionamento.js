$('#salva_procedi_dati').on('click',function(e){
    e.preventDefault();
    var tipoScheda = $(this).attr('tipo');
    var tipoTest = "";
    
    let micro = [];
    let micro_speciazione = [];
    let aa = [];
    let nab_array = [];
    let rilevatori = [];

    $("#text_area_microrganismi_segnati > option").each(function() {
        var micro_i = {'id_microrganismo':$(this).attr('id_microrganismo'), 'id_tipopiastra':$(this).attr('id_tipopiastra'),'cfu':$(this).attr('cfu'),'incertezzaSx':$(this).attr('incertezzaSx'),'incertezzaDx':$(this).attr('incertezzaDx')};
        micro.push(micro_i);
    });

    $("#text_area_microrganismi_ricercati > option").each(function() {
        var speciazione_micro_i = {'id_microrganismo':$(this).attr('id_microrganismo'), 'id_tipopiastra':$(this).attr('id_tipopiastra'), 'tipoCamp':$(this).attr('tipoCamp'), 'speciazione_risultato':$(this).attr('speciazione_risultato')};
        micro_speciazione.push(speciazione_micro_i);
    });
    $('#rilevatore_campionamento > option:selected').each(function(){
        var rilevatore_i = { 'id' : $(this).val() }
        rilevatori.push(rilevatore_i);
    });

    if(tipoScheda == 'Q')
    {
        tipoTest = $('#tipotest option:selected').val();
    }
    var id_campagna = $('.id_campagna').attr('id_campagna');
    var code = $('.code_image').attr('code');
    var numeroProgressivo = $('.nprogressivo').val();
    var id_progetto = $('#progetto option:selected').val();
    var dataCampagna = $('#dataCampagna').val();
    var data_accettazione = $('#data_accettazione').val();
    var dataCampionamento = $('#dataCampionamento').val();
    var id_societa = $('#nome_societa').attr('id_societa');
    var id_struttura = $('#nome_struttura option:selected').val();
    var dataPartenza = $('#dataPartenza').val();
    var oraPartenza = $('#oraPartenza').val();
    var dataInizio = $('#dataInizio').val();
    var oraInizio = $('#oraInizio').val();
    var dataFine = $('#dataFine').val();
    var oraFine = $('#oraFine').val();
    var dataArrivo = $('#dataArrivo').val();
    var oraArrivo = $('#oraArrivo').val();
    var tecnico = $('#tecnico option:selected').val();
    var dataAnalisi = $('#dataAnalisi').val();
    var oraInizioAnalisi = $('#oraInizioAnalisi').val();
    var oraFineAnalisi = $('#oraFineAnalisi').val();
    var dataFineAnalisi = $('#dataFineAnalisi').val();
    var superficie = $('#superficie').is(':checked') ? 1 : 0;
    var aria = $('#aria').is(':checked') ? 1 : 0;
    if(superficie == true)
    {
        var metodo = $('#metodo_sup option:selected').val();
        var id_procedura = $('#procedura_aria_sup option:selected').val();
        var fase_Camp = $('#fase_Camp').val();
        var id_protocollo = $('#protocollo option:selected').val();
        var id_prodotto = $('#prodotto option:selected').val();
        var tdaSanif = $('#tdaSanif').val();
        let [hour, minute] = tdaSanif.split(":");
        tdaSanif = parseInt(hour) * 60 + parseInt(minute); //in minuti

        var id_punto_camp = $('#punto_campionamento option:selected').val();
        var id_materiale = $('#materiale option:selected').val();
    }
    if(aria == true)
    {
        var metodo = $('#metodo_aria option:selected').val();
        var id_procedura = $('#procedura_aria_sup option:selected').val();
        var vccc = $('#vccc').is(':checked') ? 1 : 0;
        var laminare = $('#laminare').is(':checked') ? 1 : 0;
        var turbolento = $('#turbolento').is(':checked') ? 1 : 0;
        var operational = $('#operational').is(':checked') ? 1 : 0;
        var at_rest = $('#at_rest').is(':checked') ? 1 : 0;
        var n_persone = $('#n_persone').val();
        var pCampAria = $('#pCampAria option:selected').val();
        var codDiff = $('#codDiff').val();
    }
    var tipoCampione = aria == true ? $('#tipocampione_aria option:selected').val() : $('#tipocampione_superficie option:selected').val();


    var codiceCIAS = $('#codiceCIAS').val();
    var id_tipo_piastra = $('#id_tipo_piastra option:selected').val();
    var lotto = $('#lotto').val();
    var scadenza = $('#scadenza').val();
    var DII = dataAnalisi;//$('#DII').val();
    var t_inc = $('#t_inc option:selected').val();
    var condizione_incubazione = $('#condizione_incubazione option:selected').val();
    var t_inc_extra = $('#t_inc_extra').val();
    var siGramRil = $('#siGramRil').is(':checked') ? 1 : 0;
    var noGramRil = $('#noGramRil').is(':checked') ? 1 : 0;
    var gramN = $('input#gramN').val();
    var note = $('#note').val();
    var reparto = $('#reparto option:selected').val();
    var area_partizione = $('#area_reparto').val();
    var codice_area_partizione = $('#codice_struttura').val();
    // var stanza = $('#stanza option:selected').val();
    var numStanza = $('#numStanza').val();
    var umidAmb = $('#umidAmb').val();
    var tempAmb = $('#tempAmb').val();
    var dettaglio = $('#dettaglio').val();
    var classificazioneISO = $('#classificazioneISO option:selected').val();
    var lineeGuida1 = $('#lineeGuida1').is(':checked') ? 1 : 0;
    var lineeGuida2 = $('#lineeGuida2').is(':checked') ? 1 : 0;
    var lineeGuida3 = $('#lineeGuida3').is(':checked') ? 1 : 0;
    var lineeGuida4 = $('#lineeGuida4').is(':checked') ? 1 : 0;
    var classeGMP = $('#classeGMP option:selected').val();
    var anomalie = $('#anomalie').val();
    var id_microrganismo_antibiogramma = $('#microrganismi_antibiogramma option:selected').val();
    var incertezza = $('#incertezza').prop('checked') == true ? 1 : 0;
    var speciazione = $('#flag_speciazione').prop('checked') == true ? 1 : 0;
    var codiceCIAS_appendice = $('#codiceCIAS_appendice').val();
    /**
    * Sezione antibiogramma
    */
    var occorrenze = $('#aggiungi_antibiogramma').attr('occorrenze');
    var occorrenza_iniziale = $('#aggiungi_antibiogramma').attr('occorrenza_iniziale');
    for (let index = occorrenza_iniziale * 1 + 1; index <= occorrenze; index++) {
        $("#text_area_antibiotico_resistenza_"+index+" > option").each(function() {
            var antibiogramma_i = {'id_antibiotico':$(this).attr('id_antibiotico'), 'key_resistenza':$(this).attr('key_resistenza'),'NAB':$("#NAB_"+index).val()};
            aa.push(antibiogramma_i);
        });
        $('#text_area_antibiotico_resistenza_'+index).each(function(){
            var colonia = $('#colonia_'+index).is(':checked') ? 1 : 0;
            var nab_i = { 'NAB':  $("#NAB_"+index).val(),'colonia':colonia};
            nab_array.push(nab_i);
        }); 
    }

    var numero_immagini_da_inserire = (occorrenze*1) - (occorrenza_iniziale*1);
    var tipocampione = $('#tipocampione option:selected').val();
    if( tipocampione == "")
    {
        text = "Inserire un tipo di campionamento valido";
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    swal({
        title: "Sei sicuro?",
        text: "Al salvataggio verrai indirizzato in una nuova scheda",
        type: "info",
        showCancelButton: true,
        confirmButtonText: "Salva e procedi",
        confirmButtonColor: "#8CD4F5",
        cancelButtonText: "Chiudi",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/campioni",
                type: "POST",
                dataType: "json",
                data: {
                    tipoScheda: tipoScheda,
                    tipoCampione: tipoCampione,
                    tipoTest: tipoTest,
                    id_progetto: id_progetto,
                    id_campagna: id_campagna,
                    dataCampagna: dataCampagna,
                    data_accettazione: data_accettazione,
                    dataCampionamento: dataCampionamento,
                    id_societa: id_societa,
                    id_struttura: id_struttura,
                    dataPartenza: dataPartenza,
                    oraPartenza: oraPartenza,
                    dataInizio: dataInizio,
                    oraInizio: oraInizio,
                    dataFine: dataFine,
                    oraFine: oraFine,
                    dataArrivo: dataArrivo,
                    oraArrivo: oraArrivo,
                    tecnico: tecnico,
                    dataAnalisi: dataAnalisi,
                    oraInizioAnalisi: oraInizioAnalisi,
                    oraFineAnalisi: oraFineAnalisi,
                    dataFineAnalisi: dataFineAnalisi,
                    superficie: superficie,
                    aria: aria,
                    id_procedura: id_procedura,
                    fase_Camp: fase_Camp,
                    id_protocollo: id_protocollo,
                    id_prodotto: id_prodotto,
                    tdaSanif: tdaSanif,
                    id_punto_camp: id_punto_camp,
                    id_materiale: id_materiale,
                    id_procedura: id_procedura,
                    vccc: vccc,
                    laminare: laminare,
                    turbolento: turbolento,
                    operational: operational,
                    at_rest: at_rest,
                    n_persone: n_persone,
                    pCampAria: pCampAria,
                    codDiff: codDiff,
                    codiceCIAS: codiceCIAS,
                    id_tipo_piastra: id_tipo_piastra,
                    lotto: lotto,
                    scadenza: scadenza,
                    DII: DII,
                    t_inc: t_inc,
                    condizione_incubazione: condizione_incubazione,
                    t_inc_extra: t_inc_extra,
                    siGramRil: siGramRil,
                    noGramRil: noGramRil,
                    gramN: gramN,
                    note: note,
                    reparto: reparto,
                    area_partizione: area_partizione,
                    codice_area_partizione: codice_area_partizione,
                    // stanza: stanza,
                    numStanza: numStanza,
                    umidAmb: umidAmb,
                    tempAmb: tempAmb,
                    dettaglio: dettaglio,
                    lineeGuida1: lineeGuida1,
                    lineeGuida2: lineeGuida2,
                    lineeGuida3: lineeGuida3,
                    lineeGuida4: lineeGuida4,
                    classeGMP: classeGMP,
                    anomalie: anomalie,
                    classificazioneISO: classificazioneISO,
                    numeroProgressivo: numeroProgressivo,
                    code: code,
                    micro: micro,
                    micro_speciazione: micro_speciazione,
                    id_microrganismo_antibiogramma: id_microrganismo_antibiogramma,
                    aa: aa,
                    nab_array: nab_array,
                    rilevatori: rilevatori,
                    occorrenze:occorrenze*1,
                    occorrenza_iniziale:occorrenza_iniziale*1,
                    numero_immagini_da_inserire:numero_immagini_da_inserire,
                    tipocampione: tipocampione,
                    id_metodo: metodo,
                    codiceCIAS_appendice: codiceCIAS_appendice,
                    speciazione:speciazione,
                    incertezza:incertezza,
                    procedi:1
                },
                success: function(returnValue) {
                   //console.log(returnValue);
                   $( '#errors-container' ).css('display','none');
                   if(returnValue['switch'] == 0)
                   {
                        window.location.assign("/campioni");
                   }
                   if(returnValue['switch'] == 1)
                   {
                       console.log(returnValue['dati']);
                       window.location.assign("/campioni/nuovascheda/"+returnValue['numeroProgressivo']+"/"+returnValue['dati']+"/"+returnValue['tipo']);
                   }
                }, 
                error: function(data) {
                    var errors = data.responseJSON;
                    console.log(errors);

                   
                    errorsHtml = '<div class="alert alert-danger"><ul>';

                    if(typeof errors['error'] === 'object')
                    {
                        Object.values(errors['error']).forEach(element => {
                            errorsHtml += '<li>'+ element[0] + '</li>';
                        });
                    }
                    else
                    {
                        errorsHtml += '<li>'+ errors['error'] + '</li>';
                    }
                    errorsHtml += '</ul></div>';

                    $( '#errors-container' ).css('display','block');
                    $( '#errors-container' ).html( errorsHtml );
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                }
            });
        }
    });
});


$('#salva_chiudi_dati').on('click',function(e){
    e.preventDefault();
    var tipoScheda = $(this).attr('tipo');
    var tipoTest = "";

    if(tipoScheda == 'Q')
    {
        tipoTest = $('#tipotest option:selected').val();
    }

    let micro = [];
    let micro_speciazione = [];
    let aa = [];
    let nab_array = [];
    let rilevatori = [];
    $("#text_area_microrganismi_segnati > option").each(function() {
        var micro_i = {'id_microrganismo':$(this).attr('id_microrganismo'), 'id_tipopiastra':$(this).attr('id_tipopiastra'),'cfu':$(this).attr('cfu'),'incertezzaSx':$(this).attr('incertezzaSx'),'incertezzaDx':$(this).attr('incertezzaDx')};
        micro.push(micro_i);
    });
    $("#text_area_microrganismi_ricercati > option").each(function() {
        var speciazione_micro_i = {'id_microrganismo':$(this).attr('id_microrganismo'), 'id_tipopiastra':$(this).attr('id_tipopiastra'), 'tipoCamp':$(this).attr('tipoCamp'), 'speciazione_risultato':$(this).attr('speciazione_risultato')};
        micro_speciazione.push(speciazione_micro_i);
    });
    $('#rilevatore_campionamento > option:selected').each(function(){
        var rilevatore_i = { 'id' : $(this).val() }
        rilevatori.push(rilevatore_i);
    });
    var id_campagna = $('.id_campagna').attr('id_campagna');
    var code = $('.code_image').attr('code');
    var numeroProgressivo = $('.nprogressivo').val();
    var id_progetto = $('#progetto option:selected').val();
    var dataCampagna = $('#dataCampagna').val();
    var data_accettazione = $('#data_accettazione').val();
    var dataCampionamento = $('#dataCampionamento').val();
    var id_societa = $('#nome_societa').attr('id_societa');
    var id_struttura = $('#nome_struttura option:selected').val();
    var dataPartenza = $('#dataPartenza').val();
    var oraPartenza = $('#oraPartenza').val();
    var dataInizio = $('#dataInizio').val();
    var oraInizio = $('#oraInizio').val();
    var dataFine = $('#dataFine').val();
    var oraFine = $('#oraFine').val();
    var dataArrivo = $('#dataArrivo').val();
    var oraArrivo = $('#oraArrivo').val();
    var tecnico = $('#tecnico option:selected').val();
    var dataAnalisi = $('#dataAnalisi').val();
    var oraInizioAnalisi = $('#oraInizioAnalisi').val();
    var oraFineAnalisi = $('#oraFineAnalisi').val();
    var dataFineAnalisi = $('#dataFineAnalisi').val();
    var superficie = $('#superficie').is(':checked') ? 1 : 0;
    var aria = $('#aria').is(':checked') ? 1 : 0;
    if(superficie == true)
    {
        var metodo = $('#metodo_sup option:selected').val();
        var id_procedura = $('#procedura_aria_sup option:selected').val();
        var fase_Camp = $('#fase_Camp').val();
        var id_protocollo = $('#protocollo option:selected').val();
        var id_prodotto = $('#prodotto option:selected').val();
        var tdaSanif = $('#tdaSanif').val();
        let [hour, minute] = tdaSanif.split(":");
        tdaSanif = parseInt(hour) * 60 + parseInt(minute); //in minuti

        var id_punto_camp = $('#punto_campionamento option:selected').val();
        var id_materiale = $('#materiale option:selected').val();
    }
    if(aria == true)
    {
        var metodo = $('#metodo_aria option:selected').val();
        var id_procedura = $('#procedura_aria_sup option:selected').val();
        var vccc = $('#vccc').is(':checked') ? 1 : 0;
        var laminare = $('#laminare').is(':checked') ? 1 : 0;
        var turbolento = $('#turbolento').is(':checked') ? 1 : 0;
        var operational = $('#operational').is(':checked') ? 1 : 0;
        var at_rest = $('#at_rest').is(':checked') ? 1 : 0;
        var n_persone = $('#n_persone').val();
        var pCampAria = $('#pCampAria option:selected').val();
        var codDiff = $('#codDiff').val();
    }
    var tipoCampione = aria == true ? $('#tipocampione_aria option:selected').val() : $('#tipocampione_superficie option:selected').val();

    var codiceCIAS = $('#codiceCIAS').val();
    var id_tipo_piastra = $('#id_tipo_piastra option:selected').val();
    var lotto = $('#lotto').val();
    var scadenza = $('#scadenza').val();
    var DII = dataAnalisi;//$('#DII').val();
    var t_inc = $('#t_inc option:selected').val();
    var condizione_incubazione = $('#condizione_incubazione option:selected').val();
    var t_inc_extra = $('#t_inc_extra').val();
    var siGramRil = $('#siGramRil').is(':checked') ? 1 : 0;
    var noGramRil = $('#noGramRil').is(':checked') ? 1 : 0;
    var gramN = $('input#gramN').val();
    var note = $('#note').val();
    var reparto = $('#reparto option:selected').val();
    var area_partizione = $('#area_reparto').val();
    var codice_area_partizione = $('#codice_struttura').val();
    // var stanza = $('#stanza option:selected').val();
    var numStanza = $('#numStanza').val();
    var umidAmb = $('#umidAmb').val();
    var tempAmb = $('#tempAmb').val();
    var dettaglio = $('#dettaglio').val();
    var classificazioneISO = $('#classificazioneISO option:selected').val();
    var lineeGuida1 = $('#lineeGuida1').is(':checked') ? 1 : 0;
    var lineeGuida2 = $('#lineeGuida2').is(':checked') ? 1 : 0;
    var lineeGuida3 = $('#lineeGuida3').is(':checked') ? 1 : 0;
    var lineeGuida4 = $('#lineeGuida4').is(':checked') ? 1 : 0;
    var classeGMP = $('#classeGMP option:selected').val();
    var anomalie = $('#anomalie').val();
    var id_microrganismo_antibiogramma = $('#microrganismi_antibiogramma option:selected').val();
    
    var incertezza = $('#incertezza').prop('checked') == true ? 1 : 0;
    var speciazione = $('#flag_speciazione').prop('checked') == true ? 1 : 0;
    var codiceCIAS_appendice = $('#codiceCIAS_appendice').val();
    /**
    * Sezione antibiogramma
    */
    var occorrenze = $('#aggiungi_antibiogramma').attr('occorrenze');
    var occorrenza_iniziale = $('#aggiungi_antibiogramma').attr('occorrenza_iniziale');
    console.log(occorrenze);
    console.log(occorrenza_iniziale);
    for (let index = occorrenza_iniziale * 1 + 1; index <= occorrenze; index++) {
        $("#text_area_antibiotico_resistenza_"+index+" > option").each(function() {
            var antibiogramma_i = {'id_antibiotico':$(this).attr('id_antibiotico'), 'key_resistenza':$(this).attr('key_resistenza'),'NAB':$("#NAB_"+index).val()};
            aa.push(antibiogramma_i);
        });
        $('#text_area_antibiotico_resistenza_'+index).each(function(){
            var colonia = $('#colonia_'+index).is(':checked') ? 1 : 0;
            var nab_i = { 'NAB':  $("#NAB_"+index).val(),'colonia':colonia};
            nab_array.push(nab_i);
        }); 
    }
    var numero_immagini_da_inserire = (occorrenze*1) - (occorrenza_iniziale*1);
    var tipocampione = $('#tipocampione option:selected').val();
    if(tipocampione == "")
    {
        text = "Inserire un tipo di campionamento valido";
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    swal({
        title: "Sei sicuro?",
        text: "Questo salvataggio è l'ultimo del campionamento",
        type: "info",
        showCancelButton: true,
        confirmButtonText: "Salva e chiudi",
        confirmButtonColor: "#8CD4F5",
        cancelButtonText: "Chiudi",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/campioni",
                type: "POST",
                dataType: "json",
                data: {
                    tipoScheda: tipoScheda,
                    tipoCampione: tipoCampione,
                    tipoTest: tipoTest,
                    id_progetto: id_progetto,
                    id_campagna: id_campagna,
                    dataCampagna: dataCampagna,
                    data_accettazione: data_accettazione,
                    dataCampionamento: dataCampionamento,
                    id_societa: id_societa,
                    id_struttura: id_struttura,
                    dataPartenza: dataPartenza,
                    oraPartenza: oraPartenza,
                    dataInizio: dataInizio,
                    oraInizio: oraInizio,
                    dataFine: dataFine,
                    oraFine: oraFine,
                    dataArrivo: dataArrivo,
                    oraArrivo: oraArrivo,
                    tecnico: tecnico,
                    dataAnalisi: dataAnalisi,
                    oraInizioAnalisi: oraInizioAnalisi,
                    oraFineAnalisi: oraFineAnalisi,
                    dataFineAnalisi: dataFineAnalisi,
                    superficie: superficie,
                    aria: aria,
                    id_procedura: id_procedura,
                    fase_Camp: fase_Camp,
                    id_protocollo: id_protocollo,
                    id_prodotto: id_prodotto,
                    tdaSanif: tdaSanif,
                    id_punto_camp: id_punto_camp,
                    id_materiale: id_materiale,
                    id_procedura: id_procedura,
                    vccc: vccc,
                    laminare: laminare,
                    turbolento: turbolento,
                    operational: operational,
                    at_rest: at_rest,
                    n_persone: n_persone,
                    pCampAria: pCampAria,
                    codDiff: codDiff,
                    codiceCIAS: codiceCIAS,
                    id_tipo_piastra: id_tipo_piastra,
                    lotto: lotto,
                    scadenza: scadenza,
                    DII: DII,
                    t_inc: t_inc,
                    condizione_incubazione: condizione_incubazione,
                    t_inc_extra: t_inc_extra,
                    siGramRil: siGramRil,
                    noGramRil: noGramRil,
                    gramN: gramN,
                    note: note,
                    reparto: reparto,
                    area_partizione: area_partizione,
                    codice_area_partizione: codice_area_partizione,
                    // stanza: stanza,
                    numStanza: numStanza,
                    umidAmb: umidAmb,
                    tempAmb: tempAmb,
                    dettaglio: dettaglio,
                    lineeGuida1: lineeGuida1,
                    lineeGuida2: lineeGuida2,
                    lineeGuida3: lineeGuida3,
                    lineeGuida4: lineeGuida4,
                    classeGMP: classeGMP,
                    anomalie: anomalie,
                    classificazioneISO: classificazioneISO,
                    numeroProgressivo: numeroProgressivo,
                    code: code,
                    micro: micro,
                    micro_speciazione: micro_speciazione,
                    id_microrganismo_antibiogramma:id_microrganismo_antibiogramma,
                    aa: aa,
                    nab_array: nab_array,
                    rilevatori: rilevatori,
                    occorrenze:occorrenze*1,
                    occorrenza_iniziale:occorrenza_iniziale*1,
                    numero_immagini_da_inserire:numero_immagini_da_inserire,
                    tipocampione: tipocampione,
                    id_metodo: metodo,
                    codiceCIAS_appendice: codiceCIAS_appendice,
                    speciazione: speciazione,
                    incertezza: incertezza,
                    chiudi:1
                },
                success: function(returnValue) {
                    $( '#errors-container' ).css('display','none');
                    if(returnValue['switch'] == 0)
                    {
                        window.location.assign("/campagna/"+id_campagna+"/edit");
                    }
                    if(returnValue['switch'] == 1)
                    {
                        window.location.assign("/campioni/nuovascheda/"+returnValue['numeroProgressivo']+"/"+returnValue['dati'])
                    }
                }, 
                error: function(data) {
                    var errors = data.responseJSON;
                    console.log(errors);

                   
                    errorsHtml = '<div class="alert alert-danger"><ul>';

                    if(typeof errors['error'] === 'object')
                    {
                        Object.values(errors['error']).forEach(element => {
                            errorsHtml += '<li>'+ element[0] + '</li>';
                        });
                    }
                    else
                    {
                        errorsHtml += '<li>'+ errors['error'] + '</li>';
                    }
                    errorsHtml += '</ul></div>';

                    $( '#errors-container' ).css('display','block');
                    $( '#errors-container' ).html( errorsHtml );
                    $('html, body').animate({ scrollTop: 0 }, 'fast');              
                }
            });
        }
    });
});


$('#modifica_dati_salva').on('click',function(e){
    e.preventDefault();
    var tipoScheda = $(this).attr('tipo');
    var tipoTest = "";

    if(tipoScheda == 'Q')
    {
        tipoTest = $('#tipotest option:selected').val();
    }
    
    var code = $('.code_image').attr('code');
    var id = $(this).attr('id_campione');
    var motivo = $('#modifica_motivo').val();
    let rilevatori = [];
    let micro = [];
    let micro_speciazione = [];
    let aa = [];
    let nab_array = [];

    $("#text_area_microrganismi_segnati > option").each(function() {
        var micro_i = {'id_microrganismo':$(this).attr('id_microrganismo'), 'id_tipopiastra':$(this).attr('id_tipopiastra'),'cfu':$(this).attr('cfu'),'incertezzaSx':$(this).attr('incertezzaSx'),'incertezzaDx':$(this).attr('incertezzaDx')};
        micro.push(micro_i);
    });
    $("#text_area_microrganismi_ricercati > option").each(function() {
        var speciazione_micro_i = {'id_microrganismo':$(this).attr('id_microrganismo'), 'id_tipopiastra':$(this).attr('id_tipopiastra'), 'tipoCamp':$(this).attr('tipoCamp'), 'speciazione_risultato':$(this).attr('speciazione_risultato')};
        micro_speciazione.push(speciazione_micro_i);
    });
    $('#rilevatore_campionamento > option:selected').each(function(){
        var rilevatore_i = { 'id' : $(this).val() }
        rilevatori.push(rilevatore_i);
    });

    var id_campagna = $('.id_campagna').attr('id_campagna');
    var numeroProgressivo = $('.nprogressivo').val();
    var id_progetto = $('#progetto option:selected').val();
    var dataCampagna = $('#dataCampagna').val();
    var data_accettazione = $('#data_accettazione').val();
    var dataCampionamento = $('#dataCampionamento').val();
    var id_societa = $('#nome_societa').attr('id_societa');
    var id_struttura = $('#nome_struttura option:selected').val();
    var dataPartenza = $('#dataPartenza').val();
    var oraPartenza = $('#oraPartenza').val();
    var dataInizio = $('#dataInizio').val();
    var oraInizio = $('#oraInizio').val();
    var dataFine = $('#dataFine').val();
    var oraFine = $('#oraFine').val();
    var dataArrivo = $('#dataArrivo').val();
    var oraArrivo = $('#oraArrivo').val();
    var tecnico = $('#tecnico option:selected').val();
    var dataAnalisi = $('#dataAnalisi').val();
    var oraInizioAnalisi = $('#oraInizioAnalisi').val();
    var oraFineAnalisi = $('#oraFineAnalisi').val();
    var dataFineAnalisi = $('#dataFineAnalisi').val();
    var superficie = $('#superficie').is(':checked') ? 1 : 0;
    var aria = $('#aria').is(':checked') ? 1 : 0;
    if(superficie == true)
    {
        var metodo = $('#metodo_sup option:selected').val();
        var id_procedura = $('#procedura_aria_sup option:selected').val();
        var fase_Camp = $('#fase_Camp').val();
        var id_protocollo = $('#protocollo option:selected').val();
        var id_prodotto = $('#prodotto option:selected').val();
        var tdaSanif = $('#tdaSanif').val();
        let [hour, minute] = tdaSanif.split(":");
        tdaSanif = parseInt(hour) * 60 + parseInt(minute); //in minuti

        var id_punto_camp = $('#punto_campionamento option:selected').val();
        var id_materiale = $('#materiale option:selected').val();
    }
    if(aria == true)
    {
        var metodo = $('#metodo_aria option:selected').val();
        var id_procedura = $('#procedura_aria_sup option:selected').val();
        var vccc = $('#vccc').is(':checked') ? 1 : 0;
        var laminare = $('#laminare').is(':checked') ? 1 : 0;
        var turbolento = $('#turbolento').is(':checked') ? 1 : 0;
        var operational = $('#operational').is(':checked') ? 1 : 0;
        var at_rest = $('#at_rest').is(':checked') ? 1 : 0;
        var n_persone = $('#n_persone').val();
        var pCampAria = $('#pCampAria option:selected').val();
        var codDiff = $('#codDiff').val();
    }
    var tipoCampione = aria == true ? $('#tipocampione_aria option:selected').val() : $('#tipocampione_superficie option:selected').val();

    var codiceCIAS = $('#codiceCIAS').val();
    var id_tipo_piastra = $('#id_tipo_piastra option:selected').val();
    var lotto = $('#lotto').val();
    var scadenza = $('#scadenza').val();
    var DII = dataAnalisi;//$('#DII').val();
    var t_inc = $('#t_inc option:selected').val();
    var condizione_incubazione = $('#condizione_incubazione option:selected').val();
    var t_inc_extra = $('#t_inc_extra').val();
    var siGramRil = $('#siGramRil').is(':checked') ? 1 : 0;
    var noGramRil = $('#noGramRil').is(':checked') ? 1 : 0;
    var gramN = $('input#gramN').val();
    var note = $('#note').val();
    var reparto = $('#reparto option:selected').val();
    var area_partizione = $('#area_reparto').val();
    var codice_area_partizione = $('#codice_struttura').val();
    // var stanza = $('#stanza option:selected').val();
    var numStanza = $('#numStanza').val();
    var umidAmb = $('#umidAmb').val();
    var tempAmb = $('#tempAmb').val();
    var dettaglio = $('#dettaglio').val();
    var classificazioneISO = $('#classificazioneISO option:selected').val();
    var lineeGuida1 = $('#lineeGuida1').is(':checked') ? 1 : 0;
    var lineeGuida2 = $('#lineeGuida2').is(':checked') ? 1 : 0;
    var lineeGuida3 = $('#lineeGuida3').is(':checked') ? 1 : 0;
    var lineeGuida4 = $('#lineeGuida4').is(':checked') ? 1 : 0;
    var classeGMP = $('#classeGMP option:selected').val();
    var anomalie = $('#anomalie').val();
    var id_microrganismo_antibiogramma = $('#microrganismi_antibiogramma option:selected').val();
    var incertezza = $('#incertezza').prop('checked') == true ? 1 : 0;
    var speciazione = $('#flag_speciazione').prop('checked') == true ? 1 : 0;
    var codiceCIAS_appendice = $('#codiceCIAS_appendice').val();
    /**
     * Sezione antibiogramma
     */
    var occorrenze = $('#aggiungi_antibiogramma').attr('occorrenze');
    var occorrenza_iniziale = $('#aggiungi_antibiogramma').attr('occorrenza_iniziale');

    for (let index = occorrenza_iniziale * 1 + 1; index <= occorrenze; index++) {
        $("#text_area_antibiotico_resistenza_"+index+" > option").each(function() {
            var antibiogramma_i = {'id_antibiotico':$(this).attr('id_antibiotico'), 'key_resistenza':$(this).attr('key_resistenza'),'NAB':$("#NAB_"+index).val()};
            aa.push(antibiogramma_i);
        });
        $('#text_area_antibiotico_resistenza_'+index).each(function(){
            var colonia = $('#colonia_'+index).is(':checked') ? 1 : 0;
            var nab_i = { 'NAB':  $("#NAB_"+index).val(),'colonia':colonia};
            nab_array.push(nab_i);
        }); 
    }
    var numero_immagini_da_inserire = (occorrenze*1) - (occorrenza_iniziale*1);
    var tipocampione = $('#tipocampione option:selected').val();
    if( tipocampione == "")
    {
        text = "Inserire un tipo di campionamento valido";
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    swal({
        title: "Sei sicuro?",
        text: "Stai modificando un campionamento già compilato",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Salva",
        confirmButtonColor: "#8CD4F5",
        cancelButtonText: "Chiudi",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/campioni/"+id+"/update",
                type: "POST",
                dataType: "json",
                data: {
                    id:id,
                    tipoScheda: tipoScheda,
                    tipoCampione: tipoCampione,
                    tipoTest: tipoTest,
                    id_progetto: id_progetto,
                    id_campagna: id_campagna,
                    dataCampagna: dataCampagna,
                    data_accettazione: data_accettazione,
                    dataCampionamento: dataCampionamento,
                    id_societa: id_societa,
                    id_struttura: id_struttura,
                    dataPartenza: dataPartenza,
                    oraPartenza: oraPartenza,
                    dataInizio: dataInizio,
                    oraInizio: oraInizio,
                    dataFine: dataFine,
                    oraFine: oraFine,
                    dataArrivo: dataArrivo,
                    oraArrivo: oraArrivo,
                    tecnico: tecnico,
                    dataAnalisi: dataAnalisi,
                    oraInizioAnalisi: oraInizioAnalisi,
                    oraFineAnalisi: oraFineAnalisi,
                    dataFineAnalisi: dataFineAnalisi,
                    superficie: superficie,
                    aria: aria,
                    id_procedura: id_procedura,
                    fase_Camp: fase_Camp,
                    id_protocollo: id_protocollo,
                    id_prodotto: id_prodotto,
                    tdaSanif: tdaSanif,
                    id_punto_camp: id_punto_camp,
                    id_materiale: id_materiale,
                    id_procedura: id_procedura,
                    vccc: vccc,
                    laminare: laminare,
                    turbolento: turbolento,
                    operational: operational,
                    at_rest: at_rest,
                    n_persone: n_persone,
                    pCampAria: pCampAria,
                    codDiff: codDiff,
                    codiceCIAS: codiceCIAS,
                    id_tipo_piastra: id_tipo_piastra,
                    lotto: lotto,
                    scadenza: scadenza,
                    DII: DII,
                    t_inc: t_inc,
                    condizione_incubazione: condizione_incubazione,
                    t_inc_extra: t_inc_extra,
                    siGramRil: siGramRil,
                    noGramRil: noGramRil,
                    gramN: gramN,
                    note: note,
                    reparto: reparto,
                    area_partizione: area_partizione,
                    codice_area_partizione: codice_area_partizione,
                    // stanza: stanza,
                    numStanza: numStanza,
                    umidAmb: umidAmb,
                    tempAmb: tempAmb,
                    dettaglio: dettaglio,
                    lineeGuida1: lineeGuida1,
                    lineeGuida2: lineeGuida2,
                    lineeGuida3: lineeGuida3,
                    lineeGuida4: lineeGuida4,
                    classeGMP: classeGMP,
                    anomalie: anomalie,
                    classificazioneISO: classificazioneISO,
                    numeroProgressivo: numeroProgressivo,
                    micro: micro,
                    micro_speciazione: micro_speciazione,
                    code: code,
                    id_microrganismo_antibiogramma:id_microrganismo_antibiogramma,
                    aa: aa,
                    nab_array: nab_array,
                    rilevatori: rilevatori,
                    occorrenze:occorrenze*1,
                    occorrenza_iniziale:occorrenza_iniziale*1,
                    numero_immagini_da_inserire:numero_immagini_da_inserire,
                    tipocampione: tipocampione,
                    motivo: motivo,
                    id_metodo: metodo,
                    codiceCIAS_appendice: codiceCIAS_appendice,
                    speciazione: speciazione,
                    incertezza: incertezza,
                    chiudi:1
                },
                success: function(returnValue) {
                    //console.log(returnValue);
                    $( '#errors-container' ).css('display','none');
                    location.reload(true);
                }, 
                error: function(data) {
                    $('#modifica_modal').modal('hide');
                    var errors = data.responseJSON;
                    console.log(errors);

                   
                    errorsHtml = '<div class="alert alert-danger"><ul>';

                    if(typeof errors['error'] === 'object')
                    {
                        Object.values(errors['error']).forEach(element => {
                            errorsHtml += '<li>'+ element[0] + '</li>';
                        });
                    }
                    else
                    {
                        errorsHtml += '<li>'+ errors['error'] + '</li>';
                    }
                    errorsHtml += '</ul></div>';

                    $( '#errors-container' ).css('display','block');
                    $( '#errors-container' ).html( errorsHtml );
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                }
            });
        }
    });
});



$('#sblocca_campione').on('click',function(){
    var id_campione = $(this).attr('id_campione');
    var motivo = $('#sblocca_motivo').val();
    swal({
        title: "Sei sicuro?",
        text: "Stai sbloccando un campione attualmente bloccato. In seguito a questa operazione sarà possibile la modifica dei dati del campione.",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Salva",
        confirmButtonColor: "#8CD4F5",
        cancelButtonText: "Chiudi",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/campioni/unlock",
                type: "POST",
                dataType: "json",
                data: {
                    id: id_campione,
                    motivo: motivo
                },
                success: function(returnValue) {
                    //console.log(returnValue);
                    location.reload(true);
                }, 
                error: function(data) {
                    $('#sbloccaModal').modal('hide');
                    var errors = data.responseJSON;
                    console.log(errors);

                   
                    errorsHtml = '<div class="alert alert-danger"><ul>';

                    if(typeof errors['error'] === 'object')
                    {
                        Object.values(errors['error']).forEach(element => {
                            errorsHtml += '<li>'+ element[0] + '</li>';
                        });
                    }
                    else
                    {
                        errorsHtml += '<li>'+ errors['error'] + '</li>';
                    }
                    errorsHtml += '</ul></div>';

                    $( '#errors-container' ).css('display','block');
                    $( '#errors-container' ).html( errorsHtml );
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                }
            });
        }
    });
});

$('#riprendi').on('click',function(){
    var id_campione = $(this).attr('id_campione');
    var tipoScheda = $(this).attr('tipo');
    swal({
        title: "Sei sicuro?",
        text: "Stai riprendendo un campionamento a partire da questa scheda. Vuoi continuare?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Procedi",
        confirmButtonColor: "#8CD4F5",
        cancelButtonText: "Chiudi",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            window.location.assign("/campioni/nuovascheda/1/"+id_campione+"/"+tipoScheda);
        }
    });

})