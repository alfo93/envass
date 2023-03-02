$('#modifica_dati_swab').on('click',function(){
    let micro = [];
    let aa = [];
    let nab_array = [];
    let rilevatori = [];

    $('#rilevatore_campionamento > option:selected').each(function(){
        var rilevatore_i = { 'id' : $(this).val() }
        rilevatori.push(rilevatore_i);
    });

    /**
     * Prima parte
     */
    var id_campione = $('.id_campione').attr('id_campione');
    var id_campagna = $('.id_campagna').attr('id_campagna');
    var code = $('.code_image').attr('code');

    /**
     * Anagrafica
     */
    var id_progetto = $('#progetto option:selected').val(); 
    var dataCampagna = $('#dataCampagna').val(); 
    var dataCampionamento = $('#dataCampionamento').val(); 
    var ora = $('#ora').val(); 
    var id_rilevatore = $('#rilevatore_campionamento option:selected').val(); 
    var id_struttura = $('#nome_struttura option:selected').val(); 
    var id_reparto = $('#reparto option:selected').val(); 
    var area_partizione = $('#area_reparto').val();
    var codice_area_partizione = $('#codice_struttura').val();
    // var stanza = $('#stanza option:selected').val(); 
    var numStanza = $('#numStanza').val();
    var dettaglio = $('#dettaglio').val();
    var anomalie = $('#anomalie').val();

    /**
     * Campionamento
     */
    var tipoCamp = $('#superficie').is(':checked') ? 'S' : 'A';
    if(tipoCamp == '')
    {
        text = "Inserire un tipo di campionamento: Superficie o Aria?"
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    if(tipoCamp == 'S')
    {
        var id_categoria = $('#categoria option:selected').val(); 
        var id_punto_camp = $('#punto_campionamento option:selected').val();
        var id_superficie = $('#materiale option:selected').val();
        var id_prodotto = $('#prodotto option:selected').val();
        var id_protocollo = $('#protocollo option:selected').val();
        var fase_Camp = $('#fase_Camp').val();
        var tdaSanif = $('#tdaSanif').val();

    }
   

    if(tipoCamp == 'A')
    {
        var VCCC = $('#VCCC').is(':checked') ? 1 : 0;
        var laminare = $('#laminare').is(':checked') ? 1 : 0;
        var turbolento = $('#turbolento').is(':checked') ? 1 : 0;
        var flusso = '';
            flusso = turbolento == 1 ? 'T' : 'L';
            flusso = laminare == 1 ? 'L' : 'T';
            if(flusso == '')
            {
                text = 'Inserire un tipo di flusso valido: Laminare o Turbolento?';
                showNotification('alert-danger', text, 'top', 'right', null, null);
                return;
            }
        var operational = $('#operational').is(':checked') ? 1 : 0;
        var at_rest = $('#at_rest').is(':checked') ? 1 : 0;
        var operat = '';
            operat = operational == 1 ? 'O' : 'R';
            operat = at_rest == 1 ? 'R' : 'O';
            if(operat == '')
            {
                text = 'Inserire un tipo di operatività valido: Operational o At rest?';
                showNotification('alert-danger', text, 'top', 'right', null, null);
                return;
            }
        if(operat == 'O')
        {
            var n_persone = $('#n_persone').val(); 
        }
        var pCampAria = $('#pCampAria').val();
    }

    /**
     * Analisi molecolare
     */
    var numProg = $('#codifica_cias').val();
    var codice_envass = $('#codice_envass').val();

    /**
     * Campione
     */
    var dataAnalisi = $('#dataAnalisi').val();
    var tecnico = $('#tecnico').val();
    var lotto = $('#lotto').val();
    var scadenza = $('#scadenza').val();
    var codPiastra = $('#codPiastra').val();
    var tipoPiastra = $('#tipoPiastra option:selected').val();
    var dataincubazione = $('#dataincubazione').val();
    var tempoIncubazione = $('#tempoIncubazione').val();
    var presenzamicro = $('#presenzamicro').is(':checked');

    if(presenzamicro == true)
    {
        micro = [];
        $("#text_area_microrganismi_segnati > option").each(function() {
            var micro_i = {'id_microrganismo':$(this).attr('id_microrganismo'), 'id_tipopiastra':$(this).attr('id_tipopiastra'),'presente':$(this).attr('presente')};
            micro.push(micro_i);
        });

        var note = $('#note').val();
    }

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

    var id_microrganismo_antibiogramma = $('#microrganismi_antibiogramma option:selected').val();
    if ($("#carica_file").prop("files")[0] != null) {
        var file = $("#carica_file").prop("files")[0];
        var nome_file = file['name'];
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(e) {
            rawLog = reader.result;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/campionianalisimolecolare/" + id_campione +"/update",
                type: "post",
                dataType: "json",
                data: {
                    id_campione: id_campione,
                    id_campagna: id_campagna,
                    code: code,
                    id_progetto:id_progetto,
                    dataCampagna: dataCampagna,
                    dataCampionamento: dataCampionamento,
                    ora: ora,
                    id_rilevatore: id_rilevatore,
                    id_struttura: id_struttura,
                    id_reparto: id_reparto,
                    area_partizione: area_partizione,
                    codice_area_partizione: codice_area_partizione,
                    // stanza: stanza,
                    numStanza: numStanza,
                    dettaglio: dettaglio,
                    anomalie: anomalie,
                    tipoCamp: tipoCamp,
                    id_categoria: id_categoria,
                    id_punto_camp: id_punto_camp,
                    id_superficie: id_superficie,
                    id_prodotto: id_prodotto,
                    id_protocollo: id_protocollo,
                    fase_Camp: fase_Camp,
                    tdaSanif: tdaSanif,
                    VCCC: VCCC,
                    laminare: laminare,
                    turbolento: turbolento,
                    flusso: flusso,
                    operational: operational,
                    at_rest: at_rest,
                    operat: operat,
                    n_persone: n_persone,
                    pCampAria: pCampAria,
                    numProg: numProg,
                    codice_envass: codice_envass,
                    dataAnalisi: dataAnalisi,
                    tecnico: tecnico,
                    lotto: lotto,
                    scadenza: scadenza,
                    codPiastra: codPiastra,
                    tipoPiastra: tipoPiastra,
                    dataIncubazione: dataincubazione,
                    tempoIncubazione: tempoIncubazione,
                    presenzamicro: presenzamicro,
                    aa:aa,
                    nab_array:nab_array,
                    micro:micro,
                    occorrenze: occorrenze,
                    occorrenza_iniziale: occorrenza_iniziale,
                    numero_immagini_da_inserire: numero_immagini_da_inserire,
                    file: rawLog,
                    filename: nome_file,
                    note: note,
                    id_microrganismo_antibiogramma: id_microrganismo_antibiogramma,
                    rilevatori: rilevatori,
                },
                success: function(returnValue) {
                    //console.log(returnValue);
                    $( '#errors-container' ).css('display','none');
                    window.location = '/campionianalisimolecolare/'+returnValue['id_campione']+"/"+returnValue['id_campagna']+"/edit";
                }, 
                error: function(data) {
                    var errors = data.responseJSON;

                   
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
                    console.log(errors);
                    console.log(errorsHtml);
                    $( '#errors-container2' ).css('display','block');
                    $( '#errors-container2' ).html( errorsHtml );
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                }
            });
        };
    }
    else
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/campionianalisimolecolare/" + id_campione +"/update",
            type: "post",
            dataType: "json",
            data: {
                id_campione: id_campione,
                id_campagna: id_campagna,
                code: code,
                id_progetto:id_progetto,
                dataCampagna: dataCampagna,
                dataCampionamento: dataCampionamento,
                ora: ora,
                id_rilevatore: id_rilevatore,
                id_struttura: id_struttura,
                id_reparto: id_reparto,
                area_partizione: area_partizione,
                codice_area_partizione: codice_area_partizione,
                // stanza: stanza,
                numStanza: numStanza,
                dettaglio: dettaglio,
                anomalie: anomalie,
                tipoCamp: tipoCamp,
                id_categoria: id_categoria,
                id_punto_camp: id_punto_camp,
                id_superficie: id_superficie,
                id_prodotto: id_prodotto,
                id_protocollo: id_protocollo,
                fase_Camp: fase_Camp,
                tdaSanif: tdaSanif,
                VCCC: VCCC,
                laminare: laminare,
                turbolento: turbolento,
                flusso: flusso,
                operational: operational,
                at_rest: at_rest,
                operat: operat,
                n_persone: n_persone,
                pCampAria: pCampAria,
                numProg: numProg,
                codice_envass: codice_envass,
                dataAnalisi: dataAnalisi,
                tecnico: tecnico,
                lotto: lotto,
                scadenza: scadenza,
                codPiastra: codPiastra,
                tipoPiastra: tipoPiastra,
                dataIncubazione: dataincubazione,
                tempoIncubazione: tempoIncubazione,
                presenzamicro: presenzamicro,
                aa:aa,
                nab_array:nab_array,
                micro:micro,
                occorrenze: occorrenze,
                occorrenza_iniziale: occorrenza_iniziale,
                numero_immagini_da_inserire: numero_immagini_da_inserire,    
                note: note,
                id_microrganismo_antibiogramma: id_microrganismo_antibiogramma,
                rilevatori: rilevatori,
            },
            success: function(returnValue) {
                //console.log(returnValue);
                $( '#errors-container' ).css('display','none');
                window.location = '/campionianalisimolecolare/'+returnValue['id_campione']+"/"+returnValue['id_campagna']+"/edit";
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

                $( '#errors-container2' ).css('display','block');
                $( '#errors-container2' ).html( errorsHtml );
                $('html, body').animate({ scrollTop: 0 }, 'fast');
            }
        });
    }
});