$(document).ready(function(){
    $("#text_area_antibiotici").on('change',function(e) {
        e.preventDefault();
        var $optionSelected = $("option:selected", this);
        var selectedValue = $optionSelected.val();   

        if (selectedValue != "" ) {
            $('#modifica_antibiotico').prop("disabled", false);
        } 
        else {
            $('#modifica_antibiotico').prop("disabled", true)
        }

        if (selectedValue != "" ) {
            $('#cancella_antibiotico_button').prop("disabled", false);
        } 
        else {
            $('#cancella_antibiotico_button').prop("disabled", true)
        }
    });

    $("#text_area_materiali").on('change',function(e) {
        e.preventDefault();
        var $optionSelected = $("option:selected", this);
        var selectedValue = $optionSelected.val();   

        if (selectedValue != "" ) {
            $('#modifica_materiale').prop("disabled", false);
        } 
        else {
            $('#modifica_materiale').prop("disabled", true)
        }

        if (selectedValue != "" ) {
            $('#cancella_materiale_button').prop("disabled", false);
        } 
        else {
            $('#cancella_materiale_button').prop("disabled", true)
        }
    });

    $("#text_area_microrganismi").on('change',function(e) {
        e.preventDefault();
        var $optionSelected = $("option:selected", this);
        var selectedValue = $optionSelected.val();   

        if (selectedValue != "" ) {
            $('#modifica_microrganismo').prop("disabled", false);
        } 
        else {
            $('#modifica_microrganismo').prop("disabled", true)
        }

        if (selectedValue != "" ) {
            $('#cancella_microrganismo_button').prop("disabled", false);
        } 
        else {
            $('#cancella_microrganismo_button').prop("disabled", true)
        }
    });

    $("#text_area_categorie").on('change',function(e) {
        e.preventDefault();
        var $optionSelected = $("option:selected", this);
        var selectedValue = $optionSelected.val();   

        if (selectedValue != "" ) {
            $('#modifica_categoria').prop("disabled", false);
        } 
        else {
            $('#modifica_categoria').prop("disabled", true)
        }

        if (selectedValue != "" ) {
            $('#cancella_categoria_button').prop("disabled", false);
        } 
        else {
            $('#cancella_categoria_button').prop("disabled", true)
        }
    });

    $("#text_area_prodotti").on('change',function(e) {
        e.preventDefault();
        var $optionSelected = $("option:selected", this);
        var selectedValue = $optionSelected.val();   

        if (selectedValue != "" ) {
            $('#modifica_prodotto').prop("disabled", false);
        } 
        else {
            $('#modifica_prodotto').prop("disabled", true)
        }

        if (selectedValue != "" ) {
            $('#cancella_prodotto_button').prop("disabled", false);
        } 
        else {
            $('#cancella_prodotto_button').prop("disabled", true)
        }
    });

    $("#text_area_protocolli").on('change',function(e) {
        e.preventDefault();
        var $optionSelected = $("option:selected", this);
        var selectedValue = $optionSelected.val();   

        if (selectedValue != "" ) {
            $('#modifica_protocollo').prop("disabled", false);
        } 
        else {
            $('#modifica_protocollo').prop("disabled", true)
        }

        if (selectedValue != "" ) {
            $('#cancella_protocollo_button').prop("disabled", false);
        } 
        else {
            $('#cancella_protocollo_button').prop("disabled", true)
        }
    });

    $("#text_area_punticampionamento").on('change',function(e) {
        e.preventDefault();
        var $optionSelected = $("option:selected", this);
        var selectedValue = $optionSelected.val();  

        if (selectedValue != "" ) {
            $('#modifica_puntocampionamento').prop("disabled", false);
        } 
        else {
            $('#modifica_puntocampionamento').prop("disabled", true)
        }

        if (selectedValue != "" ) {
            $('#cancella_puntocampionamento_button').prop("disabled", false);
        } 
        else {
            $('#cancella_puntocampionamento_button').prop("disabled", true)
        }
    });

    $("#text_area_strutture").on('change',function(e) {
        e.preventDefault();
        var $optionSelected = $("option:selected", this);
        var selectedValue = $optionSelected.val();  

        if (selectedValue != "" ) {
            $('#modifica_struttura').prop("disabled", false);
        } 
        else {
            $('#modifica_struttura').prop("disabled", true)
        }

        if (selectedValue != "" ) {
            $('#cancella_struttura_button').prop("disabled", false);
        } 
        else {
            $('#cancella_struttura_button').prop("disabled", true)
        }

    });

    $("#text_area_reparti").on('change',function(e) {
        e.preventDefault();
        var $optionSelected = $("option:selected", this);
        var selectedValue = $optionSelected.val();  

        if (selectedValue != "" ) {
            $('#modifica_reparto').prop("disabled", false);
        } 
        else {
            $('#modifica_reparto').prop("disabled", true)
        }

        if (selectedValue != "" ) {
            $('#cancella_reparto_button').prop("disabled", false);
        } 
        else {
            $('#cancella_reparto_button').prop("disabled", true)
        }

    });

    $("#text_area_stanze").on('change',function(e) {
        e.preventDefault();
        var $optionSelected = $("option:selected", this);
        var selectedValue = $optionSelected.val();  

        if (selectedValue != "" ) {
            $('#modifica_stanza').prop("disabled", false);
        } 
        else {
            $('#modifica_stanza').prop("disabled", true)
        }

        if (selectedValue != "" ) {
            $('#cancella_stanza_button').prop("disabled", false);
        } 
        else {
            $('#cancella_stanza_button').prop("disabled", true)
        }

    });

    $("#text_area_piastre").on('change',function(e) {
        e.preventDefault();
        var $optionSelected = $("option:selected", this);
        var selectedValue = $optionSelected.val();  

        if (selectedValue != "" ) {
            $('#modifica_piastra').prop("disabled", false);
        } 
        else {
            $('#modifica_piastra').prop("disabled", true)
        }

        if (selectedValue != "" ) {
            $('#cancella_piastra_button').prop("disabled", false);
        } 
        else {
            $('#cancella_piastra_button').prop("disabled", true)
        }
    });

    $("#text_area_struttrep").on('change',function(e) {
        e.preventDefault();
        var $optionSelected = $("option:selected", this);
        var selectedValue = $optionSelected.val();  

        if (selectedValue != "" ) {
            $('#modifica_struttrep').prop("disabled", false);
        } 
        else {
            $('#modifica_struttrep').prop("disabled", true)
        }

        if (selectedValue != "" ) {
            $('#cancella_struttrep_button').prop("disabled", false);
        } 
        else {
            $('#cancella_struttrep_button').prop("disabled", true)
        }
    });

    $("#text_area_micropiastra").on('change',function(e) {
        e.preventDefault();
        var $optionSelected = $("option:selected", this);
        var selectedValue = $optionSelected.val();  
        if (selectedValue != "" ) {
            $('#modifica_micropiastra').prop("disabled", false);
        } 
        else {
            $('#modifica_micropiastra').prop("disabled", true)
        }

        if (selectedValue != "" ) {
            $('#cancella_micropiastra_button').prop("disabled", false);
        } 
        else {
            $('#cancella_micropiastra_button').prop("disabled", true)
        }
    });

    $('#struttrep_strutture').typeahead({
        source: function(query, result) {
            $.ajax({
                url: "/strutture/getStrutture",
                type: "GET",
                dataType: "json",
                data: 'query=' + query,
                success: function(data) {
                    result($.map(data, function(item) {
                        return item.struttura;
                    }));
                    
                }
            });
        },
        afterSelect: function(item){
            retrieve_id(item,false,'strutture');
        }
    });

    $('#struttrep_reparti').typeahead({
        source: function(query, result) {
            $.ajax({
                url: "/reparto/getReparti",
                type: "GET",
                dataType: "json",
                data: 'query=' + query,
                success: function(data) {
                    result($.map(data, function(item) {
                        return item.partizione;
                    }));
                }
            });
        },
        afterSelect: function(item){
            retrieve_id(item,false,'reparti');
        }
    });

    $('#struttrep_strutture_modal').typeahead({
        source: function(query, result) {
            $.ajax({
                url: "/strutture/getStrutture",
                type: "GET",
                dataType: "json",
                data: 'query=' + query,
                success: function(data) {
                    result($.map(data, function(item) {
                        $('#struttrep_strutture_modal').attr('id_value',item.id);
                        return item.struttura;
                    }));
                }
            });
        },
        afterSelect: function(item){
            retrieve_id(item,true,'strutture');
        }
    });

    $('#struttrep_reparti_modal').typeahead({
        source: function(query, result) {
            $.ajax({
                url: "/reparto/getReparti",
                type: "GET",
                dataType: "json",
                data: 'query=' + query,
                success: function(data) {
                    result($.map(data, function(item) {
                        $('#struttrep_reparti_modal').attr('id_value',item.id);
                        return item.partizione;
                    }));
                }
            });
        },
        afterSelect: function(item){
            retrieve_id(item,true,'reparti');
        }
    });

    

});

//---------------------------- SEZIONE ANTIBIOTICO -------------------------------------\\
$('#aggiungi_antibiotico').on('click',function(){
    //stringa per immagazinare la stringa totale
    var nome = $('#antibiotico_nome').val();

    if (nome == ""){
        text = "Il nome dell'antibiotico non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:"/antibiotico",
        type:"POST",
        dataType: "json",
        data: {
            nome: nome
        },
        success: function(returnValue){
            $("#antibiotico_nome").val("");
            var newOption = new Option(nome ,returnValue['id']);
            newOption.setAttribute('nome',returnValue['nome']);
            $("#text_area_antibiotici").append(newOption);
            $.AdminBSB.select.refresh();
            text = "<strong>"+nome+"</strong> aggiunto correttamente agli antibiotici."
            showNotification('alert-success', text, 'top', 'right', null, null);
        },
        error: function(response, stato) {
            console.log(stato);
            if (stato = "403"){
                text = "<strong>"+nome+"</strong> già presente tra gli antibiotici.";
                showNotification('alert-danger', text, 'top', 'right', null, null);
            }
        }
    });
});

$('#cancella_antibiotico_button').on('click',function(){
    $('#deleteModalLabel').text('Inserisci il motivo della cancellazione dell\'antibiotico');
    $('.elimina_modal').attr('id','cancella_antibiotico');

    $('#cancella_antibiotico').on('click',function(){
        var idOption = $("#text_area_antibiotici option:selected").val();
        var optionSelected = $("#text_area_antibiotici option:selected").text();
        var motivo = $('#cancel_motivo_annullamento').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro?",
            text: "Sei sicuro di voler eliminare il seguente antibiotico: "+optionSelected,
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, procedi",
            confirmButtonColor: "#DD6B55",
            cancelButtonText: "No, annulla",
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url:"/antibiotico/"+idOption,
                    type:"POST",
                    dataType: "json",
                    data: {
                        id: idOption,
                        motivo:motivo
                        },
                    success: function(returnValue){
                        $("#text_area_antibiotici option:selected").remove();
                        $('#cancella_antibiotico').prop('disabled',true);
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        $.AdminBSB.select.refresh();
                        text = "<strong>"+optionSelected+"</strong> rimosso dagli antibiotici."
                        showNotification('alert-success', text, 'top', 'right', null, null);
                    },
                    error: function(response, stato) {
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        text = "Impossibile rimuovere <strong>"+optionSelected+"</strong> dagli antibiotici perché assegnato."
                        showNotification('alert-danger', text, 'top', 'right', null, null);
                    }
                });
            }
        });
    });
});

$('#modifica_antibiotico_salva').on('click',function(){
    var id = $('#text_area_antibiotici option:selected').val();
    var nome_vecchio = $('#text_area_antibiotici option:selected').text();
    var nome = $('#aNome').val();
    var motivo = $('#aMotivo').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
        title: "Sei sicuro?",
        text: "Sei sicuro di voler modificare il seguente antibiotico: "+nome_vecchio+". Ti ricordo che la modifica comporta la sostituzione dell'elemento con un nuovo elemento. Il vecchio elemento NON sarà più disponibile",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, procedi",
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "No, annulla",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url:"/antibiotico/update/"+id,
                type:"POST",
                dataType: "json",
                data: {
                    id: id,
                    nome:nome,
                    motivo:motivo
                    },
                success: function(returnValue){
                    $('#ModalAntibiotico').modal('hide');
                    var new_nome = returnValue['nome']
                    var newOption = new Option(new_nome ,returnValue['id']);
                    newOption.setAttribute('nome',returnValue['nome']);
                    $("#text_area_antibiotici option:selected").remove();
                    $("#text_area_antibiotici").append(newOption);
                    $.AdminBSB.select.refresh();
                    text = "<strong>"+nome+"</strong><br> L'antibiotico è stato modificato correttamente."
                    showNotification('alert-success', text, 'top', 'right', null, null);
                },
                error: function(response, stato) {
                    $('#ModalAntibiotico').modal('hide');
                    text = "Impossibile modificare <strong>"+nome_vecchio+"</strong> dagli antibiotici."
                    showNotification('alert-danger', text, 'top', 'right', null, null);
                }
            });
        }
    });
});



$('#text_area_antibiotici').on('click',function(){
    var antibiotico = $('#text_area_antibiotici option:selected').text()
    $('#aNome').val(antibiotico);
})

//---------------------------- FINE SEZIONE ANTIBIOTICO -------------------------------------\\

//---------------------------- SEZIONE MATERIALE -------------------------------------\\
$('#aggiungi_materiale').on('click',function(){
    //stringa per immagazinare la stringa totale
    var nome = $('#materiale_nome').val();

    if (nome == ""){
        text = "Il nome del materiale non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:"/materiale",
        type:"POST",
        dataType: "json",
        data: {
            nome: nome
        },
        success: function(returnValue){
            $("#materiale_nome").val("");
            var newOption = new Option(nome ,returnValue['id']);
            newOption.setAttribute('nome',returnValue['nome']);
            $("#text_area_materiali").append(newOption);
            $.AdminBSB.select.refresh();
            text = "<strong>"+nome+"</strong> aggiunto correttamente ai materiali."
            showNotification('alert-success', text, 'top', 'right', null, null);
        },
        error: function(response, stato) {
            console.log(stato);
            if (stato = "403"){
                text = "<strong>"+nome+"</strong> già presente tra i materiali.";
                showNotification('alert-danger', text, 'top', 'right', null, null);
            }
        }
    });
});

$('#cancella_materiale_button').on('click',function(){
    $('#deleteModalLabel').text('Inserisci il motivo della cancellazione del materiale');
    $('.elimina_modal').attr('id','cancella_materiale');

    $('#cancella_materiale').on('click',function(){
        var idOption = $("#text_area_materiali option:selected").val();
        var optionSelected = $("#text_area_materiali option:selected").text();
        var motivo = $('#cancel_motivo_annullamento').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro?",
            text: "Sei sicuro di voler eliminare il seguente materiale: "+optionSelected,
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, procedi",
            confirmButtonColor: "#DD6B55",
            cancelButtonText: "No, annulla",
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url:"/materiale/"+idOption,
                    type:"POST",
                    dataType: "json",
                    data: {
                        id: idOption,
                        motivo: motivo
                        },
                    success: function(returnValue){
                        $("#text_area_materiali option:selected").remove();
                        $('#cancella_materiale').prop('disabled',true);
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        $.AdminBSB.select.refresh();
                        text = "<strong>"+optionSelected+"</strong> rimosso dai materiali."
                        showNotification('alert-success', text, 'top', 'right', null, null);
                    },
                    error: function(response, stato) {
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        text = "Impossibile rimuovere <strong>"+optionSelected+"</strong> dai materiali perché assegnato."
                        showNotification('alert-danger', text, 'top', 'right', null, null);
                    }
                });
            }
        });
    });
});

$('#modifica_materiale_salva').on('click',function(){
    var id = $('#text_area_materiali option:selected').val();
    var nome_vecchio = $('#text_area_materiali option:selected').text();
    var materiale = $('#mNome').val();
    var motivo = $('mMotivo').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
        title: "Sei sicuro?",
        text: "Sei sicuro di voler modificare il seguente materiale: "+nome_vecchio+". Ti ricordo che la modifica comporta la sostituzione dell'elemento con un nuovo elemento. Il vecchio elemento NON sarà più disponibile",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, procedi",
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "No, annulla",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url:"/materiale/update/"+id,
                type:"POST",
                dataType: "json",
                data: {
                    id: id,
                    materiale:materiale,
                    motivo:motivo
                    },
                success: function(returnValue){
                    $('#ModalMateriale').modal('hide');
                    $('mMotivo').val("");
                    var new_nome = returnValue['nome']
                    var newOption = new Option(new_nome ,returnValue['id']);
                    newOption.setAttribute('nome',returnValue['nome']);
                    $("#text_area_materiali option:selected").remove();
                    $("#text_area_materiali").append(newOption);
                    $.AdminBSB.select.refresh();
                    text = "<strong>"+materiale+"</strong><br> Il materiale è stato modificato correttamente."
                    showNotification('alert-success', text, 'top', 'right', null, null);
                },
                error: function(response, stato) {
                    $('#ModalMateriale').modal('hide');
                    text = "Impossibile modificare <strong>"+nome_vecchio+"</strong> dai materiali."
                    showNotification('alert-danger', text, 'top', 'right', null, null);
                }
            });
        }
    });

});

$('#text_area_materiali').on('click',function(){
    var materiale = $('#text_area_materiali option:selected').text()
    $('#mNome').val(materiale);
})

//---------------------------- FINE SEZIONE MATERIALE -------------------------------------\\

//---------------------------- SEZIONE MICRORGANISMOPIASTRA -------------------------------------\\
$('#aggiungi_microrganismo').on('click',function(){
    //stringa per immagazzinare la stringa totale
    var nome = $('#microrganismo_nome').val();
    var gram = $('#gram option:selected').val();
    var entbac = $('#entbac option:selected').val();
    var colif = $('#colif option:selected').val();
    var gruppo = $('#gruppo').val();
    console.log(entbac);
    if (nome == "")
    {
        text = "Il nome del microrganismo non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    if(gram == "")
    {
        text = "Specificare se il microrganismo è gram positivo o negativo."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    if(entbac == "")
    {
        text = "Indicare se il microrganismo appartiene alla famiglia delle Enterobacteriaceae."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    if(colif == "")
    {
        text = "Indicare se il microrganismo è coliforme."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    if(gruppo == "")
    {
        text = "Indicare il gruppo di appartenenza."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:"/microrganismopiastra",
        type:"POST",
        dataType: "json",
        data: {
            nome: nome,
            gram: gram,
            entbac: entbac,
            colif: colif,
            gruppo: gruppo
        },
        success: function(returnValue){
            $('#microrganismo_nome').val("");
            $('#gram').val("").trigger('change');
            $('#entbac').val("").trigger('change');
            $('#colif').val("").trigger('change');
            $('#gruppo').val("");
            var newOption = new Option(nome ,returnValue['id']);
            newOption.setAttribute('nome',returnValue['nome']);
            newOption.setAttribute('batgram',returnValue['gram']);
            newOption.setAttribute('entbac',returnValue['entbac']);
            newOption.setAttribute('colif',returnValue['colif']);
            newOption.setAttribute('gruppo',returnValue['gruppo']);
            $("#text_area_microrganismi").append(newOption);
            $.AdminBSB.select.refresh();
            text = "<strong>"+nome+"</strong> aggiunto correttamente ai microrganismi."
            showNotification('alert-success', text, 'top', 'right', null, null);
        },
        error: function(response, stato) {
            console.log(stato);
            if (stato = "403"){
                text = "<strong>"+nome+"</strong> già presente tra i microrganismi.";
                showNotification('alert-danger', text, 'top', 'right', null, null);
            }
            console.log(response.responseText);
        }
    });
});

$('#cancella_microrganismo_button').on('click',function(){
    $('#deleteModalLabel').text('Inserisci il motivo della cancellazione del microrganismo');
    $('.elimina_modal').attr('id','cancella_microrganismo');

    $('#cancella_microrganismo').on('click',function(){
        var idOption = $("#text_area_microrganismi option:selected").val();
        var optionSelected = $("#text_area_microrganismi option:selected").text();
        var motivo = $('#cancel_motivo_annullamento').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro?",
            text: "Sei sicuro di voler eliminare il seguente microrganismo: "+optionSelected,
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, procedi",
            confirmButtonColor: "#DD6B55",
            cancelButtonText: "No, annulla",
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url:"/microrganismopiastra/"+idOption,
                    type:"POST",
                    dataType: "json",
                    data: {
                        id: idOption,
                        motivo:motivo
                        },
                    success: function(returnValue){
                        $("#text_area_microrganismi option:selected").remove();
                        $('#cancella_microrganismo').prop('disabled',true);
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        $.AdminBSB.select.refresh();
                        text = "<strong>"+optionSelected+"</strong> rimosso dai microrganismi."
                        showNotification('alert-success', text, 'top', 'right', null, null);
                    },
                    error: function(response, stato) {
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        text = "Impossibile rimuovere <strong>"+optionSelected+"</strong> dai microrganismi perché assegnato."
                        showNotification('alert-danger', text, 'top', 'right', null, null);
                    }
                });
            }
        });
    });
})

$('#modifica_microrganismo_salva').on('click',function(){
    var id = $('#text_area_microrganismi option:selected').val();
    var nome_vecchio = $('#text_area_microrganismi option:selected').text();
    var microrganismo = $('#microrganismo_nome_modal').val();
    var gram = $('#gram_modal otpion:selected').val();
    var entbac = $('#entbac_modal option:selected').val();
    var colif = $('#colif_modal option:selected').val();
    var gruppo = $('#gruppo_modal').val();
    var motivo = $('motivo_microrganismo_modal').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
        title: "Sei sicuro?",
        text: "Sei sicuro di voler modificare il seguente microrganismo: "+nome_vecchio+". Ti ricordo che la modifica comporta la sostituzione dell'elemento con un nuovo elemento. Il vecchio elemento NON sarà più disponibile",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, procedi",
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "No, annulla",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url:"/microrganismopiastra/update/"+id,
                type:"POST",
                dataType: "json",
                data: {
                    id: id,
                    microrganismo: microrganismo,
                    gram: gram,
                    entbac: entbac,
                    colif: colif,
                    gruppo: gruppo,
                    motivo:motivo
                },
                success: function(returnValue){
                    $('#ModalMicrorganismo').modal('hide');
                    var new_nome = returnValue['nome']
                    var newOption = new Option(new_nome ,returnValue['id']);
                    newOption.setAttribute('nome',returnValue['nome']);
                    newOption.setAttribute('batgram',returnValue['gram']);
                    newOption.setAttribute('entbac',returnValue['entbac']);
                    newOption.setAttribute('colif',returnValue['colif']);
                    newOption.setAttribute('gruppo',returnValue['gruppo']);
                    $("#text_area_microrganismi option:selected").remove();
                    $("#text_area_microrganismi").append(newOption);
                    $.AdminBSB.select.refresh();
                    text = "<strong>"+microrganismo+"</strong><br> Il micrroganismo è stato modificato correttamente."
                    showNotification('alert-success', text, 'top', 'right', null, null);
                },
                error: function(response, stato) {
                    $('#ModalMicrorganismo').modal('hide');
                    text = "Impossibile modificare <strong>"+nome_vecchio+"</strong>."
                    showNotification('alert-danger', text, 'top', 'right', null, null);
                }
            });
        }
    });

});

$('#text_area_microrganismi').on('click',function(){
    var nome_microrganismo = $('#text_area_microrganismi option:selected').attr('nome')
    var gram = $('#text_area_microrganismi option:selected').attr('batgram');
    var entbac = $('#text_area_microrganismi option:selected').attr('entbac') == 1 ? 'si' : 'no';
    var colif = $('#text_area_microrganismi option:selected').attr('colif') == 1 ? 'si' : 'no';
    var gruppo = $('#text_area_microrganismi option:selected').attr('gruppo');

    $('#microrganismo_nome_modal').val(nome_microrganismo);
    $('#gram_modal').val(gram);
    $('#gram_modal').trigger('change');
    $('#entbac_modal').val(entbac);
    $('#entbac_modal').trigger('change');
    $('#colif_modal').val(colif);
    $('#colif_modal').trigger('change');
    $('#gruppo_modal').val(gruppo);
});

//---------------------------- FINE SEZIONE MICRORGANISMOPIASTRA -------------------------------------\\

//---------------------------- SEZIONE CATEGORIA -------------------------------------\\
$('#aggiungi_categoria').on('click',function(){
    //stringa per immagazinare la stringa totale
    var categoria = $('#categoria_nome').val();

    if (categoria == ""){
        text = "Il nome della categoria non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:"/categoria",
        type:"POST",
        dataType: "json",
        data: {
            categoria: categoria
        },
        success: function(returnValue){
            $("#categoria_nome").val("");
            var newOption = new Option(categoria ,returnValue['id']);
            newOption.setAttribute('nome',returnValue['nome']);
            $("#text_area_categorie").append(newOption);
            $.AdminBSB.select.refresh();
            text = "<strong>"+categoria+"</strong> aggiunto correttamente alle categorie."
            showNotification('alert-success', text, 'top', 'right', null, null);
        },
        error: function(response, stato) {
            console.log(stato);
            if (stato = "403"){
                text = "<strong>"+nome+"</strong> già presente tra le categorie.";
                showNotification('alert-danger', text, 'top', 'right', null, null);
            }
        }
    });
});

$('#cancella_categoria_button').on('click',function(){
    $('#deleteModalLabel').text('Inserisci il motivo della cancellazione della categoria');
    $('.elimina_modal').attr('id','cancella_categoria');

    $('#cancella_categoria').on('click',function(){
        var idOption = $("#text_area_categorie option:selected").val();
        var optionSelected = $("#text_area_categorie option:selected").text();
        var motivo = $('#cancel_motivo_annullamento').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro?",
            text: "Sei sicuro di voler eliminare la seguente categoria: "+optionSelected,
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, procedi",
            confirmButtonColor: "#DD6B55",
            cancelButtonText: "No, annulla",
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url:"/categoria/"+idOption,
                    type:"POST",
                    dataType: "json",
                    data: {
                        id: idOption,
                        motivo:motivo
                    },
                    success: function(returnValue){
                        $("#text_area_categorie option:selected").remove();
                        $('#cancella_categoria').prop('disabled',true);
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        $.AdminBSB.select.refresh();
                        text = "<strong>"+optionSelected+"</strong> rimosso dalle categorie."
                        showNotification('alert-success', text, 'top', 'right', null, null);
                    },
                    error: function(response, stato) {
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        text = "Impossibile rimuovere <strong>"+optionSelected+"</strong> dalle categorie perché assegnata."
                        showNotification('alert-danger', text, 'top', 'right', null, null);
                    }
                });
            }
        });
    });
})


$('#modifica_categoria_salva').on('click',function(){
    var id = $('#text_area_categorie option:selected').val();
    var nome_vecchio = $('#text_area_categorie option:selected').text();
    var categoria = $('#cNome').val();
    var motivo = $('#cMotivo').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
        title: "Sei sicuro?",
        text: "Sei sicuro di voler modificare la seguente categoria: "+nome_vecchio+". Ti ricordo che la modifica comporta la sostituzione dell'elemento con un nuovo elemento. Il vecchio elemento NON sarà più disponibile",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, procedi",
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "No, annulla",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url:"/categoria/update/"+id,
                type:"POST",
                dataType: "json",
                data: {
                    id: id,
                    categoria:categoria,
                    motivo:motivo
                    },
                success: function(returnValue){
                    $('#ModalCategoria').modal('hide');
                    var new_nome = returnValue['nome']
                    var newOption = new Option(new_nome ,returnValue['id']);
                    newOption.setAttribute('nome',returnValue['nome']);
                    $("#text_area_categorie option:selected").remove();
                    $("#text_area_categorie").append(newOption);
                    $.AdminBSB.select.refresh();
                    text = "<strong>"+categoria+"</strong><br> La categoria è stata modificata correttamente."
                    showNotification('alert-success', text, 'top', 'right', null, null);
                },
                error: function(response, stato) {
                    $('#ModalCategoria').modal('hide');
                    text = "Impossibile modificare <strong>"+nome_vecchio+"</strong> dalle categorie."
                    showNotification('alert-danger', text, 'top', 'right', null, null);
                }
            });
        }
    });

});

$('#text_area_categorie').on('click',function(){
    var categoria = $('#text_area_categorie option:selected').text()
    $('#cNome').val(categoria);
})

//---------------------------- FINE SEZIONE CATEGORIA -------------------------------------\\

//---------------------------- SEZIONE PRODOTTO -------------------------------------\\
$('#aggiungi_prodotto').on('click',function(){
    //stringa per immagazinare la stringa totale
    var nome = $('#prodotto_nome').val();

    if (nome == ""){
        text = "Il nome del prodotto non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:"/prodotto",
        type:"POST",
        dataType: "json",
        data: {
            nome: nome
        },
        success: function(returnValue){
            $("#prodotto_nome").val("");
            var newOption = new Option(nome ,returnValue['id']);
            newOption.setAttribute('nome',returnValue['nome']);
            $("#text_area_prodotti").append(newOption);
            $.AdminBSB.select.refresh();
            text = "<strong>"+nome+"</strong> aggiunto correttamente ai prodotti."
            showNotification('alert-success', text, 'top', 'right', null, null);
        },
        error: function(response, stato) {
            console.log(stato);
            if (stato = "403"){
                text = "<strong>"+nome+"</strong> già presente tra i prodotti.";
                showNotification('alert-danger', text, 'top', 'right', null, null);
            }
        }
    });
});

$('#cancella_prodotto_button').on('click',function(){
    $('#deleteModalLabel').text('Inserisci il motivo della cancellazione del prodotto');
    $('.elimina_modal').attr('id','cancella_prodotto');
    $('#cancella_prodotto').on('click',function(){
        var idOption = $("#text_area_prodotti option:selected").val();
        var optionSelected = $("#text_area_prodotti option:selected").text();
        var motivo = $('#cancel_motivo_annullamento').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro?",
            text: "Sei sicuro di voler eliminare il seguente prodotto: "+optionSelected,
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, procedi",
            confirmButtonColor: "#DD6B55",
            cancelButtonText: "No, annulla",
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url:"/prodotto/"+idOption,
                    type:"POST",
                    dataType: "json",
                    data: {
                        id: idOption,
                        motivo:motivo
                    },
                    success: function(returnValue){
                        $("#text_area_prodotti option:selected").remove();
                        $('#cancella_prodotto').prop('disabled',true);
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        $.AdminBSB.select.refresh();
                        text = "<strong>"+optionSelected+"</strong> rimosso dai prodotti."
                        showNotification('alert-success', text, 'top', 'right', null, null);
                    },
                    error: function(response, stato) {
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        text = "Impossibile rimuovere <strong>"+optionSelected+"</strong> dai prodotti perché assegnato."
                        showNotification('alert-danger', text, 'top', 'right', null, null);
                    }
                });
            }
        });
    });
});

$('#modifica_prodotto_salva').on('click',function(){
    var id = $('#text_area_prodotti option:selected').val();
    var nome_vecchio = $('#text_area_prodotti option:selected').text();
    var prodotto = $('#pNome').val();
    var motivo = $('#pMotivo').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
        title: "Sei sicuro?",
        text: "Sei sicuro di voler modificare il seguente prodotto: "+nome_vecchio+". Ti ricordo che la modifica comporta la sostituzione dell'elemento con un nuovo elemento. Il vecchio elemento NON sarà più disponibile",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, procedi",
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "No, annulla",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url:"/prodotto/update/"+id,
                type:"POST",
                dataType: "json",
                data: {
                    id: id,
                    prodotto:prodotto,
                    motivo:motivo
                },
                success: function(returnValue){
                    $('#ModalProdotto').modal('hide');
                    var new_nome = returnValue['nome']
                    var newOption = new Option(new_nome ,returnValue['id']);
                    newOption.setAttribute('nome',returnValue['nome']);
                    $("#text_area_prodotti option:selected").remove();
                    $("#text_area_prodotti").append(newOption);
                    $.AdminBSB.select.refresh();
                    text = "<strong>"+prodotto+"</strong><br> Il prodotto è stato modificato correttamente."
                    showNotification('alert-success', text, 'top', 'right', null, null);
                },
                error: function(response, stato) {
                    $('#ModalProdotto').modal('hide');
                    text = "Impossibile modificare <strong>"+nome_vecchio+"</strong> dai prodotti."
                    showNotification('alert-danger', text, 'top', 'right', null, null);
                }
            });
        }
    });

});

$('#text_area_prodotti').on('click',function(){
    var prodotto = $('#text_area_prodotti option:selected').text()
    $('#pNome').val(prodotto);
})

//---------------------------- FINE SEZIONE PRODOTTO -------------------------------------\\

//---------------------------- SEZIONE PROTOCOLLO -------------------------------------\\
$('#aggiungi_protocollo').on('click',function(){
    //stringa per immagazinare la stringa totale
    var nome = $('#protocollo_nome').val();

    if (nome == ""){
        text = "Il nome del protocollo non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:"/protocollo",
        type:"POST",
        dataType: "json",
        data: {
            nome: nome
        },
        success: function(returnValue){
            $("#protocollo_nome").val("");
            var newOption = new Option(nome ,returnValue['id']);
            newOption.setAttribute('nome',returnValue['nome']);
            $("#text_area_protocolli").append(newOption);
            $.AdminBSB.select.refresh();
            text = "<strong>"+nome+"</strong> aggiunto correttamente ai protocolli."
            showNotification('alert-success', text, 'top', 'right', null, null);
        },
        error: function(response, stato) {
            console.log(stato);
            if (stato = "403"){
                text = "<strong>"+nome+"</strong> già presente tra i protocolli.";
                showNotification('alert-danger', text, 'top', 'right', null, null);
            }
        }
    });
});

$('#cancella_protocollo_button').on('click',function(){
    $('#deleteModalLabel').text('Inserisci il motivo della cancellazione del protocollo');
    $('.elimina_modal').attr('id','cancella_protocollo');

    $('#cancella_protocollo').on('click',function(){
        var idOption = $("#text_area_protocolli option:selected").val();
        var optionSelected = $("#text_area_protocolli option:selected").text();
        var motivo = $('#cancel_motivo_annullamento').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro?",
            text: "Sei sicuro di voler eliminare il seguente protocollo: "+optionSelected,
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, procedi",
            confirmButtonColor: "#DD6B55",
            cancelButtonText: "No, annulla",
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url:"/protocollo/"+idOption,
                    type:"POST",
                    dataType: "json",
                    data: {
                        id: idOption,
                        motivo:motivo
                    },
                    success: function(returnValue){
                        $("#text_area_protocolli option:selected").remove();
                        $('#cancella_protocollo').prop('disabled',true);
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        $.AdminBSB.select.refresh();
                        text = "<strong>"+optionSelected+"</strong> rimosso dai protocolli."
                        showNotification('alert-success', text, 'top', 'right', null, null);
                    },
                    error: function(response, stato) {
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        text = "Impossibile rimuovere <strong>"+optionSelected+"</strong> dai protocolli perché assegnato."
                        showNotification('alert-danger', text, 'top', 'right', null, null);
                    }
                });
            }
        });
    });
})


$('#modifica_protocollo_salva').on('click',function(){
    var id = $('#text_area_protocolli option:selected').val();
    var nome_vecchio = $('#text_area_protocolli option:selected').text();
    var protocollo = $('#protocolloNome').val();
    var motivo = $('#protocolloMotivo').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
        title: "Sei sicuro?",
        text: "Sei sicuro di voler modificare il seguente protocollo: "+nome_vecchio+". Ti ricordo che la modifica comporta la sostituzione dell'elemento con un nuovo elemento. Il vecchio elemento NON sarà più disponibile",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, procedi",
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "No, annulla",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url:"/protocollo/update/"+id,
                type:"POST",
                dataType: "json",
                data: {
                    id: id,
                    protocollo:protocollo,
                    motivo:motivo
                },
                success: function(returnValue){
                    $('#ModalProtocollo').modal('hide');
                    var new_nome = returnValue['nome']
                    var newOption = new Option(new_nome ,returnValue['id']);
                    newOption.setAttribute('nome',returnValue['nome']);
                    $("#text_area_protocolli option:selected").remove();
                    $("#text_area_protocolli").append(newOption);
                    $.AdminBSB.select.refresh();
                    text = "<strong>"+protocollo+"</strong><br> Il protocollo è stato modificato correttamente."
                    showNotification('alert-success', text, 'top', 'right', null, null);
                },
                error: function(response, stato) {
                    $('#ModalProtocollo').modal('hide');
                    text = "Impossibile modificare <strong>"+nome_vecchio+"</strong> dai protocolli."
                    showNotification('alert-danger', text, 'top', 'right', null, null);
                }
            });
        }
    });

});

$('#text_area_protocolli').on('click',function(){
    var protocollo = $('#text_area_protocolli option:selected').text()
    $('#protocolloNome').val(protocollo);
})

//---------------------------- FINE SEZIONE PROTOCOLLO -------------------------------------\\

//---------------------------- SEZIONE PUNTOCAMPIONAMENTO -------------------------------------\\
$('#aggiungi_puntocampionamento').on('click',function(){
    var nome = $('#puntocampionamento_nome').val();
    var id_categoria = $('#categoriaPC option:selected').val();
    var codPC = $('#codPC').val();
    var matrice = $('#matricePC option:selected').val()

    if (nome == ""){
        text = "Il nome del punto campionamento non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    if (id_categoria == ""){
        text = "Inserire la categoria di appartenenza."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    if(matrice == "")
    {
        text = "Inserire la matrice di appartenenza."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:"/puntocampionamento",
        type:"POST",
        dataType: "json",
        data: {
            nome: nome,
            id_categoria: id_categoria,
            codPC: codPC,
            matrice: matrice
        },
        success: function(returnValue){
            $("#puntocampionamento_nome").val("");
            $("#categoriaPC").val("");
            $('#categoriaPC').trigger('change');
            $("#codPC").val("");
            $("#matricePC").val("");
            $('#matricePC').trigger('change')
            var newOption = new Option(nome ,returnValue['id']);
            newOption.setAttribute('nome_categoria',returnValue['nome_categoria']);
            newOption.setAttribute('id_categoria',returnValue['id_categoria']);
            newOption.setAttribute('codPC',returnValue['codPC']);
            newOption.setAttribute('nome',returnValue['nome']);
            newOption.setAttribute('matrice',returnValue['matrice']);
            $("#text_area_punticampionamento").append(newOption);
            $.AdminBSB.select.refresh();

            text = "<strong>"+nome+"</strong> aggiunto correttamente ai punti campionamento."
            showNotification('alert-success', text, 'top', 'right', null, null);
        },
        error: function(response, stato) {
            console.log(stato);
            if (stato = "403"){
                text = "<strong>"+nome+"</strong> già presente tra i punti campionamento.";
                showNotification('alert-danger', text, 'top', 'right', null, null);
            }
        }
    });
});

$('#cancella_puntocampionamento_button').on('click',function(){
    $('#deleteModalLabel').text('Inserisci il motivo della cancellazione del punto di campionamento');
    $('.elimina_modal').attr('id','cancella_puntocampionamento');

    $('#cancella_puntocampionamento').on('click',function(){
        var idOption = $("#text_area_punticampionamento option:selected").val();
        var optionSelected = $("#text_area_punticampionamento option:selected").text();
        var motivo = $('#cancel_motivo_annullamento').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro?",
            text: "Sei sicuro di voler eliminare il seguente punto campionamento: "+optionSelected,
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, procedi",
            confirmButtonColor: "#DD6B55",
            cancelButtonText: "No, annulla",
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url:"/puntocampionamento/"+idOption,
                    type:"POST",
                    dataType: "json",
                    data: {
                        id: idOption,
                        motivo:motivo
                    },
                    success: function(returnValue){
                        $("#text_area_punticampionamento option:selected").remove();
                        $('#cancella_puntocampionamento').prop('disabled',true);
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        $.AdminBSB.select.refresh();
                        text = "<strong>"+optionSelected+"</strong> rimosso dai punti campionamento."
                        showNotification('alert-success', text, 'top', 'right', null, null);
                    },
                    error: function(response, stato) {
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        text = "Impossibile rimuovere <strong>"+optionSelected+"</strong> dai punti campionamento perché assegnato."
                        showNotification('alert-danger', text, 'top', 'right', null, null);
                    }
                });
            }
        });
    });
});

$('#modifica_puntocampionamento_salva').on('click',function(){
    var optionSelected = $('#text_area_punticampionamento option:selected').text();
    var id = $('#text_area_punticampionamento option:selected').val();
    var nome_vecchio = $('#text_area_punticampionamento option:selected').text();
    var punto_campionamento = $('#puntocampionamento_nome_modal').val();
    var id_categoria = $('#categoriaPC_modal option:selected').val();
    var codPC = $('#codPC_modal').val();
    var motivo = $('#motivo_puntocampionamento_modal').val();
    var matrice = $('#matricePC_modal option:selected').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
        title: "Sei sicuro?",
        text: "Sei sicuro di voler modificare il seguente punto campionamento: "+nome_vecchio+". Ti ricordo che la modifica comporta la sostituzione dell'elemento con un nuovo elemento. Il vecchio elemento NON sarà più disponibile",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, procedi",
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "No, annulla",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url:"/puntocampionamento/update/"+id,
                type:"POST",
                dataType: "json",
                data: {
                    id: id,
                    punto_campionamento:punto_campionamento,
                    id_categoria:id_categoria,
                    codPC:codPC,
                    motivo:motivo,
                    matrice: matrice
                },
                success: function(returnValue){
                    $('#ModalPuntoCampionamento').modal('hide');
                    $("#text_area_punticampionamento option:selected").remove();
                    var new_nome = returnValue['nome']
                    var newOption = new Option(new_nome ,returnValue['id']);
                    newOption.setAttribute('nome_categoria',returnValue['nome_categoria']);
                    newOption.setAttribute('id_categoria',returnValue['id_categoria']);
                    newOption.setAttribute('codPC',returnValue['codPC']);
                    newOption.setAttribute('nome',returnValue['nome']);
                    newOption.setAttribute('matrice',returnValue['matrice']);
                    $("#text_area_punticampionamento").append(newOption);
                    $.AdminBSB.select.refresh();
                    text = "<strong>"+punto_campionamento+"</strong><br> Il punto campionamento è stato modificato correttamente."
                    showNotification('alert-success', text, 'top', 'right', null, null);
                },
                error: function(response, stato) {
                    $('#ModalPuntoCampionamento').modal('hide');
                    text = "Impossibile modificare <strong>"+optionSelected+"</strong> dai punti campionamento."
                    showNotification('alert-danger', text, 'top', 'right', null, null);
                }
            });
        }
    });

});

$('#text_area_punticampionamento').on('click',function(){
    var nome = $('#text_area_punticampionamento option:selected').attr('nome');
    var id_categoria = $('#text_area_punticampionamento option:selected').attr('id_categoria');
    var codPC = $('#text_area_punticampionamento option:selected').attr('codPC');
    var matrice = $('#text_area_punticampionamento option:selected').attr('matrice');
    $('#puntocampionamento_nome_modal').val(nome);
    $('#categoriaPC_modal').val(id_categoria).trigger('change');
    $('#codPC_modal').val(codPC);
    $('#matricePC_modal').val(matrice).trigger('change');
})

//---------------------------- FINE SEZIONE PUNTOCAMPIONAMENTO -------------------------------------\\

//---------------------------- SEZIONE STRUTTURA -------------------------------------\\
$('#aggiungi_struttura').on('click',function(){
    var nome = $('#struttura_nome').val();
    var sede = $('#struttura_sede').val();
    var provincia = $('#struttura_provincia').val();
    var codice_struttura = $('#codice_struttura').val();
    var codice_sede = $('#codice_sede').val();
    var codice_provincia = $('#codice_provincia').val();

    if (nome == ""){
        text = "Il campo nome della struttura non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    if (sede == ""){
        text = "Il campo sede della struttura non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    if (provincia == ""){
        text = "Il campo provincia della struttura non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    if (codice_struttura == ""){
        text = "Il campo codice struttura della struttura non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    if (codice_sede == ""){
        text = "Il campo codice sede della struttura non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    if (codice_provincia == ""){
        text = "Il campo codice provincia della struttura non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:"/strutture",
        type:"POST",
        dataType: "json",
        data: {
            nome: nome,
            sede:sede,
            provincia:provincia,
            codice_struttura:codice_struttura,
            codice_sede:codice_sede,
            codice_provincia:codice_provincia,
        },
        success: function(returnValue){
            $("#struttura_nome").val("");
            $("#struttura_sede").val("");
            $("#struttura_provincia").val("");
            $("#codice_struttura").val("");
            $("#codice_sede").val("");
            $("#codice_provincia").val("");
           
            var newOption = new Option(nome ,returnValue['id']);
            newOption.setAttribute('nome',returnValue['struttura']);
            newOption.setAttribute('sede',returnValue['sede']);
            newOption.setAttribute('provincia',returnValue['provincia']);
            newOption.setAttribute('codice_struttura',returnValue['codice_struttura']);
            newOption.setAttribute('codice_sede',returnValue['codice_sede']);
            newOption.setAttribute('codice_provincia',returnValue['codice_provincia']);
            $("#text_area_strutture").append(newOption);
            $.AdminBSB.select.refresh();

            text = "<strong>"+nome+"</strong> aggiunto correttamente alle strutture."
            showNotification('alert-success', text, 'top', 'right', null, null);
        },
        error: function(response, stato) {
            console.log(stato);
            if (stato = "403"){
                text = "<strong>"+nome+"</strong> già presente tra le strutture.";
                showNotification('alert-danger', text, 'top', 'right', null, null);
            }
        }
    });
});


$('#cancella_struttura_button').on('click',function(){
    $('#deleteModalLabel').text('Inserisci il motivo della cancellazione della struttura');
    $('.elimina_modal').attr('id','cancella_struttura');

    $('#cancella_struttura').on('click',function(){
        var idOption = $("#text_area_strutture option:selected").val();
        var optionSelected = $("#text_area_strutture option:selected").text();
        var motivo = $('#cancel_motivo_annullamento').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro?",
            text: "Sei sicuro di voler eliminare la seguente struttura: "+optionSelected,
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, procedi",
            confirmButtonColor: "#DD6B55",
            cancelButtonText: "No, annulla",
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url:"/strutture/"+idOption,
                    type:"POST",
                    dataType: "json",
                    data: {
                        id: idOption,
                        motivo:motivo
                    },
                    success: function(returnValue){
                        $("#text_area_strutture option:selected").remove();
                        $('#cancella_struttura').prop('disabled',true);
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        $.AdminBSB.select.refresh();
                        text = "<strong>"+optionSelected+"</strong> rimosso dalle strutture."
                        showNotification('alert-success', text, 'top', 'right', null, null);
                    },
                    error: function(response, stato) {
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        text = "Impossibile rimuovere <strong>"+optionSelected+"</strong> dalle strutture perché assegnato."
                        showNotification('alert-danger', text, 'top', 'right', null, null);
                    }
                });
            }
        });
    });
});

$('#modifica_struttura_salva').on('click',function(){
    var optionSelected = $('#text_area_strutture option:selected').text();
    var id = $('#text_area_strutture option:selected').val();
    var nome_vecchio = $('#text_area_strutture option:selected').text();
    var struttura = $('#struttura_nome_modal').val();
    var sede = $('#struttura_sede_modal').val();
    var provincia = $('#struttura_provincia_modal').val();
    var codice_struttura = $('#codiceStruttura_modal').val();
    var codice_sede = $('#codiceStrutturaSede_modal').val();
    var codice_provincia = $('#codiceStrutturaProvincia_modal').val();
   
    var motivo = $('#motivo_struttura_modal').val();

    if(motivo = "")
    {
        text = "Il campo motivo non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
        title: "Sei sicuro?",
        text: "Sei sicuro di voler modificare la seguente struttura: "+nome_vecchio+". Ti ricordo che la modifica comporta la sostituzione dell'elemento con un nuovo elemento. Il vecchio elemento NON sarà più disponibile",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, procedi",
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "No, annulla",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url:"/strutture/update/"+id,
                type:"POST",
                dataType: "json",
                data: {
                    id: id,
                    struttura: struttura,
                    sede: sede,
                    provincia: provincia,
                    codice_struttura: codice_struttura,
                    codice_sede: codice_sede,
                    codice_provincia: codice_provincia,
                    motivo:motivo
                },
                success: function(returnValue){
                    $('#ModalStruttura').modal('hide');
                    $("#text_area_strutture option:selected").remove();
                    var new_nome = returnValue['struttura']
                    var newOption = new Option(new_nome ,returnValue['id']);
                    newOption.setAttribute('nome',returnValue['struttura']);
                    newOption.setAttribute('sede',returnValue['sede']);
                    newOption.setAttribute('provincia',returnValue['provincia']);
                    newOption.setAttribute('codice_struttura',returnValue['codice_struttura']);
                    newOption.setAttribute('codice_sede',returnValue['codice_sede']);
                    newOption.setAttribute('codice_provincia',returnValue['codice_provincia']);
                    $("#text_area_strutture").append(newOption);
                    $.AdminBSB.select.refresh();
                    text = "<strong>"+struttura+"</strong><br> La struttura è stata modificata correttamente."
                    showNotification('alert-success', text, 'top', 'right', null, null);
                },
                error: function(response, stato) {
                    $('#ModalStruttura').modal('hide');
                    text = "Impossibile modificare <strong>"+optionSelected+"</strong> dalle strutture."
                    showNotification('alert-danger', text, 'top', 'right', null, null);
                }
            });
        }
    });

});

$('#text_area_strutture').on('click',function(){
    var nome = $('#text_area_strutture option:selected').attr('nome');
    var sede = $('#text_area_strutture option:selected').attr('sede');
    var provincia = $('#text_area_strutture option:selected').attr('provincia');
    var codice_struttura = $('#text_area_strutture option:selected').attr('codice_struttura');
    var codice_sede = $('#text_area_strutture option:selected').attr('codice_sede');
    var codice_provincia = $('#text_area_strutture option:selected').attr('codice_provincia');
  
    $('#struttura_nome_modal').val(nome);
    $('#struttura_sede_modal').val(sede);
    $('#struttura_provincia_modal').val(provincia);
    $('#codiceStruttura_modal').val(codice_struttura);
    $('#codiceStrutturaSede_modal').val(codice_sede);
    $('#codiceStrutturaProvincia_modal').val(codice_provincia);
})

//---------------------------- FINE SEZIONE STRUTTURA -------------------------------------\\

//---------------------------- SEZIONE REPARTI -------------------------------------\\
$('#aggiungi_reparto').on('click',function(){
    var nome = $('#reparto_nome').val();
    var codice = $('#reparto_codice').val();

    if (nome == ""){
        text = "Il nome della partizione non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }
    if (codice == ""){
        text = "Il codice della partizione non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:"/reparto",
        type:"POST",
        dataType: "json",
        data: {
            nome: nome,
            codice: codice,
        },
        success: function(returnValue){
            $("#reparto_nome").val("");
            var newOption = new Option(nome ,returnValue['id']);
            newOption.setAttribute('nome',returnValue['partizione']);
            newOption.setAttribute('codice',returnValue['codice']);
            $("#text_area_reparti").append(newOption);
            $.AdminBSB.select.refresh();

            text = "<strong>"+nome+"</strong> aggiunto correttamente alle partizioni."
            showNotification('alert-success', text, 'top', 'right', null, null);
        },
        error: function(response, stato) {
            if (stato = "403")
            {
                text = "<strong>"+nome+"</strong> già presente tra le partizioni.";
                showNotification('alert-danger', text, 'top', 'right', null, null);
            }
        }
    });
});

$('#cancella_reparto_button').on('click',function(){
    $('#deleteModalLabel').text('Inserisci il motivo della cancellazione della partizione');
    $('.elimina_modal').attr('id','cancella_reparto');

    $('#cancella_reparto').on('click',function(){
        var idOption = $("#text_area_reparti option:selected").val();
        var optionSelected = $("#text_area_reparti option:selected").text();
        var motivo = $('#cancel_motivo_annullamento').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro?",
            text: "Sei sicuro di voler eliminare la seguente partizione: "+optionSelected,
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, procedi",
            confirmButtonColor: "#DD6B55",
            cancelButtonText: "No, annulla",
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url:"/reparto/"+idOption,
                    type:"POST",
                    dataType: "json",
                    data: {
                        id: idOption,
                        motivo:motivo,
                    },
                    success: function(returnValue){
                        $("#text_area_reparti option:selected").remove();
                        $('#cancella_reparto').prop('disabled',true);
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        $.AdminBSB.select.refresh();
                        text = "<strong>"+optionSelected+"</strong> rimosso dai reparti."
                        showNotification('alert-success', text, 'top', 'right', null, null);
                    },
                    error: function(response, stato) {
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        text = "Impossibile rimuovere <strong>"+optionSelected+"</strong> dalle partizioni perché assegnato."
                        showNotification('alert-danger', text, 'top', 'right', null, null);
                    }
                });
            }
        });
    });
});

$('#modifica_reparto_salva').on('click',function(){
    var optionSelected = $('#text_area_reparti option:selected').text();
    var id = $('#text_area_reparti option:selected').val();
    var nome_vecchio = $('#text_area_reparti option:selected').text();
    var reparto = $('#reparto_nome_modal').val();
    var codice = $('#reparto_codice_modal').val();
    var motivo = $('#motivo_reparto_modal').val();

    if(motivo = "")
    {
        text = "Il motivo della modifica della partizione non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
        title: "Sei sicuro?",
        text: "Sei sicuro di voler modificare la seguente partizione: "+nome_vecchio+". Ti ricordo che la modifica comporta la sostituzione dell'elemento con un nuovo elemento. Il vecchio elemento NON sarà più disponibile",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, procedi",
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "No, annulla",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url:"/reparto/update/"+id,
                type:"POST",
                dataType: "json",
                data: {
                    id: id,
                    reparto: reparto,
                    codice: codice,
                    motivo:motivo
                },
                success: function(returnValue){
                    $('#ModalReparto').modal('hide');
                    $("#text_area_reparti option:selected").remove();
                    var new_nome = returnValue['reparto']
                    var newOption = new Option(new_nome ,returnValue['id']);
                    newOption.setAttribute('nome',returnValue['reparto']);
                    newOption.setAttribute('codice',returnValue['codice']);
                    $("#text_area_reparti").append(newOption);
                    $.AdminBSB.select.refresh();
                    text = "<strong>"+reparto+"</strong><br> La partizione è stata modificata correttamente."
                    showNotification('alert-success', text, 'top', 'right', null, null);
                },
                error: function(response, stato) {
                    $('#ModalReparto').modal('hide');
                    text = "Impossibile modificare <strong>"+optionSelected+"</strong> dalle partizioni."
                    showNotification('alert-danger', text, 'top', 'right', null, null);
                }
            });
        }
    });

});

$('#text_area_reparti').on('click',function(){
    var nome = $('#text_area_reparti option:selected').attr('nome');
    var codice = $('#text_area_reparti option:selected').attr('codice');
    $('#reparto_nome_modal').val(nome);
    $('#reparto_codice_modal').val(codice);
})

//---------------------------- FINE SEZIONE REPARTO -------------------------------------\\

//---------------------------- SEZIONE STANZA -------------------------------------\\
// $('#aggiungi_stanza').on('click',function(){
//     var nome = $('#stanza_nome').val();

//     if (nome == ""){
//         text = "Il nome della stanza non può essere vuoto."
//         showNotification('alert-danger', text, 'top', 'right', null, null);
//         return;
//     }

//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//     $.ajax({
//         url:"/stanza",
//         type:"POST",
//         dataType: "json",
//         data: {
//             nome: nome,
//         },
//         success: function(returnValue){
//             $("#stanza_nome").val("");
//             var newOption = new Option(nome ,returnValue['id']);
//             newOption.setAttribute('nome',returnValue['stanza']);
//             $("#text_area_stanze").append(newOption);
//             $.AdminBSB.select.refresh();

//             text = "<strong>"+nome+"</strong> aggiunto correttamente alle stanze."
//             showNotification('alert-success', text, 'top', 'right', null, null);
//         },
//         error: function(response, stato) {
//             if (stato = "403")
//             {
//                 text = "<strong>"+nome+"</strong> già presente tra le stanze.";
//                 showNotification('alert-danger', text, 'top', 'right', null, null);
//             }
//         }
//     });
// });

// $('#cancella_stanza_button').on('click',function(){
//     $('#deleteModalLabel').text('Inserisci il motivo della cancellazione della stanza');
//     $('.elimina_modal').attr('id','cancella_stanza');

//     $('#cancella_stanza').on('click',function(){
//         var idOption = $("#text_area_stanze option:selected").val();
//         var optionSelected = $("#text_area_stanze option:selected").text();
//         var motivo = $('#cancel_motivo_annullamento').val();
//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//         });
//         swal({
//             title: "Sei sicuro?",
//             text: "Sei sicuro di voler eliminare la seguente stanza: "+optionSelected,
//             type: "warning",
//             showCancelButton: true,
//             confirmButtonText: "Si, procedi",
//             confirmButtonColor: "#DD6B55",
//             cancelButtonText: "No, annulla",
//             closeOnConfirm: true,
//             closeOnCancel: true,
//         }, function (isConfirm) {
//             if (isConfirm) {
//                 $.ajax({
//                     url:"/stanza/"+idOption,
//                     type:"POST",
//                     dataType: "json",
//                     data: {
//                         id: idOption,
//                         motivo: motivo
//                     },
//                     success: function(returnValue){
//                         $("#text_area_stanze option:selected").remove();
//                         $('#cancella_stanza').prop('disabled',true);
//                         $('#deleteModal').modal('hide');
//                         $('#deleteModal').hide();
//                         $('body').removeClass('modal-open');
//                         $('.modal-backdrop').remove();
//                         $.AdminBSB.select.refresh();
//                         text = "<strong>"+optionSelected+"</strong> rimosso dalle stanze."
//                         showNotification('alert-success', text, 'top', 'right', null, null);
//                     },
//                     error: function(response, stato) {
//                         $('#deleteModal').modal('hide');
//                         $('#deleteModal').hide();
//                         $('body').removeClass('modal-open');
//                         $('.modal-backdrop').remove();
//                         text = "Impossibile rimuovere <strong>"+optionSelected+"</strong> dalle stanze perché assegnata."
//                         showNotification('alert-danger', text, 'top', 'right', null, null);
//                     }
//                 });
//             }
//         });
//     });
// });

// $('#modifica_stanza_salva').on('click',function(){
//     var optionSelected = $('#text_area_stanze option:selected').text();
//     var id = $('#text_area_stanze option:selected').val();
//     var nome_vecchio = $('#text_area_stanze option:selected').text();
//     var stanza = $('#stanza_nome_modal').val();
//     var motivo = $('#motivo_stanza_modal').val();
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//     swal({
//         title: "Sei sicuro?",
//         text: "Sei sicuro di voler modificare la seguente stanza: "+nome_vecchio+". Ti ricordo che la modifica comporta la sostituzione dell'elemento con un nuovo elemento. Il vecchio elemento NON sarà più disponibile",
//         type: "warning",
//         showCancelButton: true,
//         confirmButtonText: "Si, procedi",
//         confirmButtonColor: "#DD6B55",
//         cancelButtonText: "No, annulla",
//         closeOnConfirm: true,
//         closeOnCancel: true,
//     }, function (isConfirm) {
//         if (isConfirm) {
//             $.ajax({
//                 url:"/stanza/update/"+id,
//                 type:"POST",
//                 dataType: "json",
//                 data: {
//                     id: id,
//                     stanza: stanza,
//                     motivo:motivo
//                 },
//                 success: function(returnValue){
//                     $('#ModalStanza').modal('hide');
//                     $("#text_area_stanze option:selected").remove();
//                     var new_nome = returnValue['stanza']
//                     var newOption = new Option(new_nome ,returnValue['id']);
//                     newOption.setAttribute('nome',returnValue['stanza']);
//                     $("#text_area_stanze").append(newOption);
//                     $.AdminBSB.select.refresh();
//                     text = "<strong>"+stanza+"</strong><br> La stanza è stata modificata correttamente."
//                     showNotification('alert-success', text, 'top', 'right', null, null);
//                 },
//                 error: function(response, stato) {
//                     $('#ModalStanza').modal('hide');
//                     text = "Impossibile modificare <strong>"+optionSelected+"</strong> dalle stanze."
//                     showNotification('alert-danger', text, 'top', 'right', null, null);
//                 }
//             });
//         }
//     });

// });

// $('#text_area_stanze').on('click',function(){
//     var nome = $('#text_area_stanze option:selected').attr('nome');
//     $('#stanza_nome_modal').val(nome);
// })

//---------------------------- FINE SEZIONE STANZA -------------------------------------\\

//---------------------------- SEZIONE TIPOPIASTRA -------------------------------------\\
$('#aggiungi_piastra').on('click',function(){
    var nome = $('#piastra_nome').val();
    var superficie = $('#superficie_piastra').val();
    var tipo = $('#tipo_piastra').val();
    var abbreviazione = $('#abbreviazione_piastra').val();

    if (nome == ""){
        text = "Il nome della piastra non può essere vuoto."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    if (superficie == ""){
        text = "La superficie della piastra non può essere vuota."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:"/tipopiastra",
        type:"POST",
        dataType: "json",
        data: {
            nome: nome,
            superficie: superficie,
            tipo: tipo,
            abbreviazione: abbreviazione
        },
        success: function(returnValue){
            $('#piastra_nome').val();
            $('#superficie_piastra').val();
            $('#tipo_piastra').val();
            $('#abbreviazione_piastra').val();            
            var newOption = new Option(nome ,returnValue['id']);
            newOption.setAttribute('nome',returnValue['piastra']);
            newOption.setAttribute('superficie',returnValue['superficie']);
            newOption.setAttribute('tipo',returnValue['tipo']);
            newOption.setAttribute('abbreviazione',returnValue['abbreviazione']);
            $("#text_area_piastre").append(newOption);
            $.AdminBSB.select.refresh();

            text = "<strong>"+nome+"</strong> aggiunto correttamente alle piastre."
            showNotification('alert-success', text, 'top', 'right', null, null);
        },
        error: function(response, stato) {
            if (stato = "403")
            {
                text = "<strong>"+nome+"</strong> già presente tra le piastre.";
                showNotification('alert-danger', text, 'top', 'right', null, null);
            }
        }
    });
});
$('#cancella_piastra_button').on('click',function(){
    $('#deleteModalLabel').text('Inserisci il motivo della cancellazione della piastra');
    $('.elimina_modal').attr('id','cancella_piastra');

    $('#cancella_piastra').on('click',function(){
        var id = $("#text_area_piastre option:selected").val();
        var optionSelected = $("#text_area_piastre option:selected").text();
        var motivo = $('#cancel_motivo_annullamento').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro?",
            text: "Sei sicuro di voler eliminare la seguente piastra: "+$("#text_area_piastre option:selected").text(),
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, procedi",
            confirmButtonColor: "#DD6B55",
            cancelButtonText: "No, annulla",
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url:"/tipopiastra/"+id,
                    type:"POST",
                    dataType: "json",
                    data: {
                        id: id,
                        motivo:motivo
                    },
                    success: function(returnValue){
                        $("#text_area_piastre option:selected").remove();
                        $('#cancella_piastra').prop('disabled',true);
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        $.AdminBSB.select.refresh();
                        text = "<strong>"+optionSelected+"</strong> rimosso dalle piastre."
                        showNotification('alert-success', text, 'top', 'right', null, null);
                    },
                    error: function(response, stato) {
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        text = "Impossibile rimuovere <strong>"+optionSelected+"</strong> dalle piastre perché assegnata."
                        showNotification('alert-danger', text, 'top', 'right', null, null);
                    }
                });
            }
        });
    });
});

$('#modifica_piastra_salva').on('click',function(){
    var optionSelected = $('#text_area_piastre option:selected').text();
    var id = $('#text_area_piastre option:selected').val();
    var nome_vecchio = $('#text_area_piastre option:selected').text();
    var piastra = $('#piastra_nome_modal').val();
    var superficie = $('#superficie_piastra_modal').val();
    var tipo = $('#tipo_piastra_modal').val();
    var abbreviazione = $('#abbreviazione_piastra_modal').val();
    var motivo = $('#motivo_piastra_modal').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
        title: "Sei sicuro?",
        text: "Sei sicuro di voler modificare la seguente piastra: "+nome_vecchio+". Ti ricordo che la modifica comporta la sostituzione dell'elemento con un nuovo elemento. Il vecchio elemento NON sarà più disponibile",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, procedi",
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "No, annulla",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url:"/tipopiastra/update/"+id,
                type:"POST",
                dataType: "json",
                data: {
                    id: id,
                    piastra: piastra,
                    superficie: superficie,
                    tipo: tipo,
                    abbreviazione: abbreviazione,
                    motivo:motivo
                },
                success: function(returnValue){
                    $('#ModalPiastra').modal('hide');
                    $("#text_area_piastre option:selected").remove();
                    var new_nome = returnValue['piastra']
                    var newOption = new Option(new_nome ,returnValue['id']);
                    newOption.setAttribute('nome',returnValue['piastra']);
                    newOption.setAttribute('superficie',returnValue['superficie']);
                    newOption.setAttribute('tipo',returnValue['tipo']);
                    newOption.setAttribute('abbreviazione',returnValue['abbreviazione']);
                    $("#text_area_piastre").append(newOption);
                    $.AdminBSB.select.refresh();
                    text = "<strong>"+piastra+"</strong><br> La piastra è stata modificata correttamente."
                    showNotification('alert-success', text, 'top', 'right', null, null);
                },
                error: function(response, stato) {
                    $('#ModalPiastra').modal('hide');
                    text = "Impossibile modificare <strong>"+optionSelected+"</strong> dalle piastre."
                    showNotification('alert-danger', text, 'top', 'right', null, null);
                }
            });
        }
    });

});

$('#text_area_piastre').on('click',function(){
    var nome = $('#text_area_piastre option:selected').attr('nome');
    var superficie = $('#text_area_piastre option:selected').attr('superficie');
    var tipo = $('#text_area_piastre option:selected').attr('tipo');
    var abbreviazione = $('#text_area_piastre option:selected').attr('abbreviazione');
    $('#piastra_nome_modal').val(nome);
    $('#superficie_piastra_modal').val(superficie);
    $('#abbreviazione_piastra_modal').val(abbreviazione);
    $('#tipo_piastra_modal').val(tipo);

})

//---------------------------- FINE SEZIONE TIPOPIASTRA -------------------------------------\\


//---------------------------- SEZIONE STRUTTREP -------------------------------------\\
$('#aggiungi_struttrep').on('click',function(){
    var id_progetto = $('#struttrep_progetti option:selected').val();
    var progetto = $('#struttrep_progetti option:selected').text();

    var id_struttura = $('#struttrep_strutture').attr('id_value');
    var struttura = $('#struttrep_strutture').val();

    var id_reparto = $('#struttrep_reparti').attr('id_value');
    var reparto = $('#struttrep_reparti').val();

    var area_partizione = $('#struttrep_area_partizione').val();
    var codice_area_part = $('#struttrep_codice_area').val();


    var total = "";

    if (id_progetto == ""){
        text = "Inserire un progetto valido"
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    total+="Progetto: "+progetto;
    if (id_struttura == ""){
        text = "Inserire una struttura valida"
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }
    total+=" Struttura: "+struttura;
    if (id_reparto == ""){
        text = "Inserire un reparto valido"
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }
    total+=" Reparto: "+reparto;

   
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:"/struttrep",
        type:"POST",
        dataType: "json",
        data: {
            id_progetto: id_progetto,
            id_struttura: id_struttura,
            id_reparto: id_reparto,
            area_partizione: area_partizione,
            codice_area_part: codice_area_part,
        },
        success: function(returnValue){
            $('#struttrep_progetti').val("").trigger('change');
            $('#struttrep_reparti').val("")
            $('#struttrep_strutture').val("")
            $('#struttrep_codice_area').val("")
            $('#struttrep_area_partizione').val("")
            var newOption = new Option(total ,returnValue['id']);
            newOption.setAttribute('progetto',progetto);
            newOption.setAttribute('id_progetto',returnValue['id_progetto']);
            newOption.setAttribute('struttura',struttura);
            newOption.setAttribute('id_struttura',returnValue['id_struttura']);
            newOption.setAttribute('reparto',reparto);
            newOption.setAttribute('id_reparto',returnValue['id_reparto']);
            newOption.setAttribute('id_associazione',returnValue['id_associazione']);
            $("#text_area_struttrep").append(newOption);
            $.AdminBSB.select.refresh();
            text = "<strong>"+total+"</strong> aggiunto correttamente."
            showNotification('alert-success', text, 'top', 'right', null, null);
        },
        error: function(response, stato) {
            if (stato = "403")
            {
                text = "<strong>"+total+"</strong> già presente.";
                showNotification('alert-danger', text, 'top', 'right', null, null);
            }
        }
    });
});

$('#cancella_struttrep_button').on('click',function(){
    $('#deleteModalLabel').text('Inserisci il motivo della cancellazione dell\'associazione struttura - reparto');
    $('.elimina_modal').attr('id','cancella_struttrep');

    $('#cancella_struttrep').on('click',function(){
        var idOption = $("#text_area_struttrep option:selected").val();
        var optionSelected = $("#text_area_struttrep option:selected").text();
        var motivo = $('#cancel_motivo_annullamento').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro?",
            text: "Sei sicuro di voler eliminare il seguente assegnamento: "+optionSelected+" ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, procedi",
            confirmButtonColor: "#DD6B55",
            cancelButtonText: "No, annulla",
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url:"/struttrep/"+idOption,
                    type:"POST",
                    dataType: "json",
                    data: {
                        id: idOption,
                        motivo:motivo
                    },
                    success: function(returnValue){
                        $("#text_area_struttrep option:selected").remove();
                        $('#cancella_struttrep').prop('disabled',true);
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        $.AdminBSB.select.refresh();
                        text = "<strong>"+optionSelected+"</strong> rimosso correttamente."
                        showNotification('alert-success', text, 'top', 'right', null, null);
                    },
                    error: function(response, stato) {
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        text = "Impossibile rimuovere <strong>"+optionSelected+"</strong>."
                        showNotification('alert-danger', text, 'top', 'right', null, null);
                    }
                });
            }
        });
    });
});

$('#modifica_struttrep_salva').on('click',function(){
    var optionSelected = $('#text_area_struttrep option:selected').text();
    var id = $('#text_area_struttrep option:selected').val();
    var id_progetto = $('#struttrep_progetti_modal option:selected').val();
    var progetto = $('#struttrep_progetti_modal option:selected').text();

    var id_struttura = $('#struttrep_strutture_modal').attr('id_value');
    var struttura = $('#struttrep_strutture_modal').val();

    var id_reparto = $('#struttrep_reparti_modal').attr('id_value');
    var reparto = $('#struttrep_reparti_modal').val();

    var id_associazione = $('#text_area_struttrep option:selected').attr('id_associazione');
    var area_partizione = $('#struttrep_area_partizione_modal').val();
    var codice_area = $('#struttrep_codice_area_modal').val();

    var motivo = $('#motivo_struttrep_modal').val();

    if(motivo == "")
    {
        text = "Inserisci il motivo della modifica.";
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    var total = "";

    if (id_progetto == ""){
        text = "Inserire un progetto valido"
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    total+="Progetto: "+progetto;
    if (id_struttura == ""){
        text = "Inserire una struttura valida"
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }
    total+=" Struttura: "+struttura;
    if (id_reparto == ""){
        text = "Inserire un reparto valido"
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }
    total+=" Reparto: "+reparto;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
        title: "Sei sicuro?",
        text: "Sei sicuro di voler modificare: "+optionSelected+". Ti ricordo che la modifica comporta la sostituzione dell'elemento con un nuovo elemento. Il vecchio elemento NON sarà più disponibile",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, procedi",
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "No, annulla",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url:"/struttrep/update/"+id,
                type:"POST",
                dataType: "json",
                data: {
                    id: id,
                    id_progetto: id_progetto,
                    id_struttura: id_struttura,
                    id_reparto: id_reparto,
                    id_associazione: id_associazione,
                    area_partizione: area_partizione,
                    codice_area: codice_area,
                    motivo:motivo
                },
                success: function(returnValue){
                    console.log(returnValue);
                    $('#ModalStruttRep').modal('hide');
                    $("#text_area_struttrep option:selected").remove();
                    var newOption = new Option(total ,returnValue['id']);
                    newOption.setAttribute('progetto',progetto);
                    newOption.setAttribute('id_progetto',returnValue['id_progetto']);
                    newOption.setAttribute('struttura',struttura);
                    newOption.setAttribute('id_struttura',returnValue['id_struttura']);
                    newOption.setAttribute('reparto',reparto);
                    newOption.setAttribute('id_reparto',returnValue['id_reparto']);
                    newOption.setAttribute('id_associazione',returnValue['id_associazione']);
                    $("#text_area_struttrep").append(newOption);
                    $.AdminBSB.select.refresh();
                    text = "<strong>"+total+"</strong><br> stata modificata correttamente."
                    showNotification('alert-success', text, 'top', 'right', null, null);
                },
                error: function(response, stato) {
                    console.log(response);
                    $('#ModalStruttRep').modal('hide');
                    text = "Impossibile modificare <strong>"+optionSelected+"</strong>."
                    showNotification('alert-danger', text, 'top', 'right', null, null);
                }
            });
        }
    });

});

$('#text_area_struttrep').on('click',function(){
    var id_progetto = $('#text_area_struttrep option:selected').attr('id_progetto');
    var id_struttura = $('#text_area_struttrep option:selected').attr('id_struttura');
    var struttura = $('#text_area_struttrep option:selected').attr('struttura');
    var reparto = $('#text_area_struttrep option:selected').attr('reparto');
    var id_reparto = $('#text_area_struttrep option:selected').attr('id_reparto');
    var id_associazione = $('#text_area_struttrep option:selected').attr('id_associazione');
    var area_partizione = "";
    var codice_area = "";

    $.ajax({
        url:"/getAreaPart",
        type:"GET",
        dataType: "json",
        data: {
            id: id_associazione
        },
        success: function(returnValue){
            area_partizione = returnValue['area_partizione'];
            codice_area = returnValue['codice_area_partizione'];
            $('#struttrep_area_partizione_modal').val(area_partizione);
            $('#struttrep_codice_area_modal').val(codice_area);
        },
        error: function(response, stato) {
            text = "Errore nel recuperare le informazioni richieste <strong>"+optionSelected+"</strong>."
            showNotification('alert-danger', text, 'top', 'right', null, null);
        }
    });

    $('#struttrep_progetti_modal').val(id_progetto).trigger('change');
    $('#struttrep_strutture_modal').val(struttura);
    $('#struttrep_reparti_modal').val(reparto);
    $('#struttrep_strutture_modal').attr('id_value',id_struttura);
    $('#struttrep_reparti_modal').attr('id_value',id_reparto);
    

})

$('#struttrep_area_partizione').typeahead({
	source: function(query, result) {
		$.ajax({
			url: "/reparto/areapartizione",
			type: "GET",
			dataType: "json",
			data: 'query=' + query,
			success: function(data) {
				result($.map(data, function(item) {
					console.log(data)
					if(item.id_reparto == $('#struttrep_reparti').attr('id_value'))
					{
						return item.area_partizione;
					}
				}));
				
			}
		});
	},
	afterSelect: function(item){
		retrieve_id(item,false,'strutture');
	}
});



//---------------------------- FINE SEZIONE STRUTTREP -------------------------------------\\


//---------------------------- SEZIONE MICROPIASTRA -------------------------------------\\
$('#aggiungi_micropiastra').on('click',function(){
    //stringa per immagazinare la stringa totale
    var id_microrganismo = $('#microrganismo_micropiastra option:selected').val();
    var id_piastra = $('#piastra_micropiastra option:selected').val();
    var nome_microrganismo = $('#microrganismo_micropiastra option:selected').attr('nome_microrganismo');
    var nome_piastra = $('#piastra_micropiastra option:selected').attr('nome_piastra');
    var textNewOption = nome_piastra+" - "+nome_microrganismo;
    if (id_microrganismo == ""){
        text = "Inserire un microrganismo valido."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    if (id_piastra == ""){
        text = "Inserire una piastra valida."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:"/micropiastra",
        type:"POST",
        dataType: "json",
        data: {
            id_microrganismo: id_microrganismo,
            id_piastra: id_piastra
        },
        success: function(returnValue){
            $("#microrganismo_micropiastra").val("").trigger('change');
            $("#piastra_micropiastra").val("").trigger('change');
            var newOption = new Option(textNewOption ,returnValue['id']);
            newOption.setAttribute('nome_microrganismo',nome_microrganismo);
            newOption.setAttribute('nome_piastra',nome_piastra);
            newOption.setAttribute('id_microrganismo',id_microrganismo);
            newOption.setAttribute('id_piastra',id_piastra);
            $("#text_area_micropiastra").append(newOption);
            $.AdminBSB.select.refresh();
            text = "<strong>"+textNewOption+"</strong> assegnamento effettuato correttamente."
            showNotification('alert-success', text, 'top', 'right', null, null);
        },
        error: function(response, stato) {
            console.log(stato);
            if (stato = "403"){
                text = "<strong>"+textNewOption+"</strong> assegnamento già presente.";
                showNotification('alert-danger', text, 'top', 'right', null, null);
            }
        }
    });
});

$('#cancella_micropiastra_button').on('click',function(){
    $('#deleteModalLabel').text('Inserisci il motivo della cancellazione dell\'assegnamento scelto');
    $('.elimina_modal').attr('id','cancella_micropiastra');

    $('#cancella_micropiastra').on('click',function(){
        var idOption = $("#text_area_micropiastra option:selected").val();
        var optionSelected = $("#text_area_micropiastra option:selected").text();
        var motivo = $('#cancel_motivo_annullamento').val();

        if(motivo == "")
        {
            text = "Inserire un motivo valido."
            showNotification('alert-danger', text, 'top', 'right', null, null);
            return;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro?",
            text: "Sei sicuro di voler eliminare il seguente assegnamento: "+optionSelected,
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, procedi",
            confirmButtonColor: "#DD6B55",
            cancelButtonText: "No, annulla",
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url:"/micropiastra/"+idOption,
                    type:"POST",
                    dataType: "json",
                    data: {
                        id: idOption,
                        motivo:motivo
                        },
                    success: function(returnValue){
                        $("#text_area_micropiastra option:selected").remove();
                        $('#cancel_motivo_annullamento').val("");
                        $('#cancella_micropiastra').prop('disabled',true);
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        $.AdminBSB.select.refresh();
                        text = "<strong>"+optionSelected+"</strong> rimosso correttamente."
                        showNotification('alert-success', text, 'top', 'right', null, null);
                    },
                    error: function(response, stato) {
                        $('#deleteModal').modal('hide');
                        $('#deleteModal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('.elimina_modal').prop('disabled',false);
                        text = "Impossibile rimuovere l'assegnamento <strong>"+optionSelected+"</strong>."
                        showNotification('alert-danger', text, 'top', 'right', null, null);
                    }
                });
            }
        });
    });
});

$('#modifica_micropiastra_salva').on('click',function(){
    var id = $('#text_area_micropiastra option:selected').val();
    var nome_vecchio = $('#text_area_micropiastra option:selected').text();
    var id_microrganismo = $('#microrganismo_micropiastra_modal option:selected').val();
    var id_piastra = $('#piastra_micropiastra_modal option:selected').val();
    var nome_microrganismo = $('#microrganismo_micropiastra option:selected').attr('nome_microrganismo');
    var nome_piastra = $('#piastra_micropiastra option:selected').attr('nome_piastra');
    var motivo = $('#motivo_micropiastra_modal').val();

    if(motivo == "")
    {
        text = "Inserire un motivo valido."
        showNotification('alert-danger', text, 'top', 'right', null, null);
        return;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
        title: "Sei sicuro?",
        text: "Sei sicuro di voler modificare il seguente assegnamento: "+nome_vecchio+". Ti ricordo che la modifica comporta la sostituzione dell'elemento con un nuovo elemento. Il vecchio elemento NON sarà più disponibile",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, procedi",
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "No, annulla",
        closeOnConfirm: true,
        closeOnCancel: true,
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url:"/micropiastra/update/"+id,
                type:"POST",
                dataType: "json",
                data: {
                    id: id,
                    id_microrganismo:id_microrganismo,
                    id_piastra:id_piastra,
                    motivo:motivo
                    },
                success: function(returnValue){
                    console.log(returnValue);
                    $('#ModalMicropiastra').modal('hide');
                    $('#motivo_micropiastra_modal').val("");
                    var textOption = returnValue['nome_piastra'] + " - " + returnValue['nome_microrganismo'];
                    var newOption = new Option(textOption,returnValue['id']);
                    newOption.setAttribute('nome_microrganismo',nome_microrganismo);
                    newOption.setAttribute('nome_piastra',nome_piastra);
                    newOption.setAttribute('id_microrganismo',id_microrganismo);
                    newOption.setAttribute('id_piastra',id_piastra);;
                    $("#text_area_micropiastra option:selected").remove();
                    $("#text_area_micropiastra").append(newOption);
                    $.AdminBSB.select.refresh();
                    text = "<strong>"+nome_vecchio+"</strong><br> L'assegnamento è stato modificato correttamente."
                    showNotification('alert-success', text, 'top', 'right', null, null);
                },
                error: function(response, stato) {
                    $('#ModalMicropiastra').modal('hide');
                    text = "Impossibile modificare l'assegnamento <strong>"+nome_vecchio+"</strong>."
                    showNotification('alert-danger', text, 'top', 'right', null, null);
                }
            });
        }
    });
});



$('#text_area_micropiastra').on('click',function(){
    var id_microrganismo = $('#text_area_micropiastra option:selected').attr('id_microrganismo');
    var id_piastra = $('#text_area_micropiastra option:selected').attr('id_piastra');    
    $('#microrganismo_micropiastra_modal').val(id_microrganismo).trigger('change');
    $('#piastra_micropiastra_modal').val(id_piastra).trigger('change');
})

//---------------------------- FINE SEZIONE MICROPIASTRA -------------------------------------\\

function retrieve_id(item,modal,div)
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/gestioneinterna/getId",
        type: "GET",
        dataType: "json",
        data: {
            item:item,
            div: div
        },
        success: function(returnValue) {
            if(modal == true)
            {
                $('#struttrep_'+div+'_modal').attr('id_value',returnValue['id']);
                console.log($('#struttrep_'+div+'_modal').attr('id_value'));
            }
            else
            {
                $('#struttrep_'+div).attr('id_value',returnValue['id']);
                console.log($('#struttrep_'+div).attr('id_value'));
            }
        },
        error: function() {
            //
        },
    });
}

jQuery.event.special.touchstart = {
    setup: function( _, ns, handle ){
      if ( ns.includes("noPreventDefault") ) {
        this.addEventListener("touchstart", handle, { passive: false });
      } else {
        this.addEventListener("touchstart", handle, { passive: true });
      }
    }
};

jQuery.event.special.touchmove = {
    setup: function( _, ns, handle ){
      if ( ns.includes("noPreventDefault") ) {
        this.addEventListener("touchmove", handle, { passive: false });
      } else {
        this.addEventListener("touchmove", handle, { passive: true });
      }
    }
};