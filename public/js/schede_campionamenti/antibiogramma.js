
var idCampione = $('.id_campione').attr('id_campione');
var token = $('meta[name="csrf-token"]').attr('content');
var code = $('.code_image').attr('code');

elimina_antibiogramma(1);
elimina_antibiogramma(2);
elimina_antibiogramma(3);
elimina_antibiogramma(4);
elimina_antibiogramma(5);
elimina_antibiogramma(6);
elimina_antibiogramma(7);
elimina_antibiogramma(8);
elimina_antibiogramma(9);
elimina_antibiogramma(10);


/**
 * Al caricamento della pagina controllo che esista un microantibiogramma, per permettere l'aggiunta di antibioticiantibiogrammi
 */
if($('#microrganismi_antibiogramma option:selected').val() != "")
{
    $('#aggiungi_antibiogramma').prop('disabled',false);
}
else
{
    $('#aggiungi_antibiogramma').prop('disabled',true);
}



/**
 * In fase di costruzione del campione, è possibile aggiungere il microantibiogramma e gli antibioticiantibiogrammi solo in presenza di un microrganismo valido. 
 */
$('#microrganismi_antibiogramma').on('change',function(){
    if($('#microrganismi_antibiogramma option:selected').val() != "")
    {
        $('#aggiungi_antibiogramma').prop('disabled',false);
    }
    else
    {
        $('#aggiungi_antibiogramma').prop('disabled',true);
    }
});

/**
 * Dropzone per l'inserimento dell'antibiogramma 0 (cioè quello al quale si associa il microrganismo)
 */
Dropzone.options.dropzone = {
    init: function() {
        this.on("addedfile", function(file) { 
            // alert("File Caricato."); 
        });
        this.on("sending", function(file, xhr, formData){
            formData.append('NAB',0);
            formData.append('id_micro',$('#microrganismi_antibiogramma option:selected').val());
            formData.append('code',code);
            formData.append('tipo','antibiogramma0');
            formData.append("_token", token);
        });
        this.on("complete", function(file) {
            this.removeFile(file);
        });
    },
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    success: function(data) {
		text = "Colonie selezionate aggiunte correttamente.";
		showNotification('alert-success', text, 'top', 'right', null, null);
        var url = $('#image_dropzone_antibiogramma0').children().children().attr('src');
        url = url + "/"+data.name;
        $('#image_dropzone_antibiogramma0').children().children().attr('src',url);
        $('#form_for_antibiogramma0').addClass('hidden');
        $('#image_dropzone_antibiogramma0').removeClass('hidden');
        $('#button_dropzone_antibiogramma0').removeClass('hidden');
		$.AdminBSB.select.refresh();
		//elimina_immagine();
	},
    error: function(response,stato) {
        console.log(stato);
        showNotification('alert-danger', stato.error, 'top', 'right', null, null);
        
        return false;
    }
}

$('#elimina_foto_conta').on('click',function(){
    $('#eliminaFotoMotivo').val("");
    elimina_immagine_conta();
})

function elimina_immagine_conta()
{
    $('#elimina_foto_conferma').on('click',function(e){
        var id = $(this).attr('idScheda') == 'nuova' ? $(this).attr('codeScheda') : $(this).attr('idScheda');
        var tipoTabella = $(this).attr('idScheda') == 'nuova' ? 'temporary' : 'campioni';
        var tipoFoto = 'antibiogramma0';
        var motivo = $('#eliminaFotoMotivo').val();
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro?",
            text: "Sei sicuro di voler elimina l'immagine relativa al campione?",
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
                    url:"/immaginiantibiogramma/delete",
                    type:"POST",
                    dataType: "json",
                    data: {
                        id: id,
                        tipoTabella: tipoTabella,
                        tipoFoto: tipoFoto,
                        motivo: motivo
                    },	
                    success: function(html){
                        text = "Piastra rimossa correttamente";
                        $('#eliminaFotoModal').modal('hide');
                        if(tipoTabella == 'temporary')
                        {
                            var oldsrc = $('#image_dropzone_antibiogramma0').children().children().attr('src');
                            var newsrc = "http://";
                            var iter_src = oldsrc.split('/');
                            var n = iter_src.length - 1;
                            for(var j = 2; j < n; j++ )
                            {
                                if(j == n - 1)
                                {
                                    newsrc = newsrc + iter_src[j];
                                }
                                else
                                {
                                    newsrc = newsrc + iter_src[j] + "/";
                                }
                            }
                            $('#image_dropzone_antibiogramma0').children().children().attr('src',newsrc);
                        }
                        if(tipoTabella == 'campioni')
                        {
                            var oldsrc = $('#image_dropzone_antibiogramma0').children().children().attr('src');
                            var newsrc = "";
                            var iter_src = oldsrc.split('/');
                            var n = iter_src.length - 1;
                            for(var j = 2; j < n; j++ )
                            {
                                if(j == n - 1)
                                {
                                    newsrc = newsrc + iter_src[j];
                                }
                                else
                                {
                                    newsrc = newsrc + iter_src[j] + "/";
                                }
                            }
                            $('#image_dropzone_antibiogramma0').children().children().attr('src',newsrc);
                        }
                        
                        $('#form_for_antibiogramma0').removeClass('hidden');
                        $('#image_dropzone_antibiogramma0').addClass('hidden');
                        $('#button_dropzone_antibiogramma0').addClass('hidden');
                        showNotification('alert-success', text, 'top', 'right', null, null);               
                    },
                    error: function(response, stato) {
                        $('#eliminaFotoModal').modal('hide');
                        showNotification('alert-danger', response.responseJSON.error, 'top', 'right', null, null);
                    }
                });
            }
        });
    });
}

function elimina_immagine_antibiogramma(k)
{
    $('#elimina_foto_conferma').on('click',function(e){
        console.log('antibiogramma '+ k);
        var id = $(this).attr('idScheda') == 'nuova' ? $(this).attr('codeScheda') : $(this).attr('idScheda');
        var tipoTabella = $(this).attr('idScheda') == 'nuova' ? 'temporary' : 'campioni';
        var tipoFoto = 'antibiogramma'+k;
        var motivo = $('#eliminaFotoMotivo').val();
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro?",
            text: "Sei sicuro di voler elimina l'immagine relativa al campione?",
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
                    url:"/immaginiantibiogramma/delete",
                    type:"POST",
                    dataType: "json",
                    data: {
                        id: id,
                        tipoTabella: tipoTabella,
                        tipoFoto: tipoFoto,
                        motivo: motivo
                    },	
                    success: function(html){
                        text = "Piastra rimossa correttamente";
                        $('#eliminaFotoModal').modal('hide');
                        if(tipoTabella == 'temporary')
                        {
                            var oldsrc = $('#image_dropzone_'+k).children().children().children().attr('src');
                            var newsrc = "http://";
                            var iter_src = oldsrc.split('/');
                            var n = iter_src.length - 1;
                            for(var j = 2; j < n; j++ )
                            {
                                if(j == n - 1)
                                {
                                    newsrc = newsrc + iter_src[j];
                                }
                                else
                                {
                                    newsrc = newsrc + iter_src[j] + "/";
                                }
                            }
                            $('#image_dropzone_'+k).children().children().children().attr('src',newsrc);
                            console.log(newsrc);
                        }
                        if(tipoTabella == 'campioni')
                        {
                            var oldsrc = $('#image_dropzone_'+k).children().children().children().attr('src');
                            var newsrc = "";
                            var iter_src = oldsrc.split('/');
                            var n = iter_src.length - 1;
                            for(var j = 2; j < n; j++ )
                            {
                                if(j == n - 1)
                                {
                                    newsrc = newsrc + iter_src[j];
                                }
                                else
                                {
                                    newsrc = newsrc + iter_src[j] + "/";
                                }
                            }
                            $('#image_dropzone_'+k).children().children().children().attr('src',newsrc);
                            console.log(newsrc);
                        }
                        
                        $('#dropzone_to_hidden_'+k).removeClass('hidden');
                        $('#image_dropzone_'+k).addClass('hidden');
                        $('#button_dropzone_'+k).addClass('hidden');
                        showNotification('alert-success', text, 'top', 'right', null, null);               
                    },
                    error: function(response, stato) {
                        $('#eliminaFotoModal').modal('hide');
                        showNotification('alert-danger', response.responseJSON.error, 'top', 'right', null, null);
                    }
                });
            }
        });
    });
}

$('#antibiogramma0_image').on('click',function(){
    var modalImg = $('#imageBigger');
    var captionText = $('#defaultModalLabel');

    modalImg.attr('src',$(this).attr('src'));
    captionText.text($(this).attr('alt'));
});

/**
 * Aggiunta dinamica del form per l'inserimento di un nuovo antibioticoantibiogramma.
 */
let html = $('#to_clone').html();
$('#aggiungi_antibiogramma').on('click',function(){
    
    $('#aggiungi_antibiogramma').prop('disabled',true);
    occorrenze = $(this).attr('occorrenze') *1; //*1 così converto la stringa in numero
    $('#elimina_foto_antibiogramma_'+occorrenze).prop('disabled',true);
    occorrenze += 1;
    $('.container1').append(html);
    var dropzoneAltri = $('#dropzoneAltri');
    dropzoneAltri.attr('id','dropzoneAltri_'+occorrenze);
    var colonia = $('#colonia');
    var label_colonia = $("#label_colonia");
    var select_antibiotici = $('#antibiotici');
    var select_resistenza = $('#resistenza');
    var text_area_antibiotico_resistenza = $('#text_area_antibiotico_resistenza');
    var cancella_antibiotico_resistenza = $('#cancella_antibiotico_resistenza');
    var aggiungi_antibiotico_resistenza = $('#aggiungi_antibiotico_resistenza');
    var codice_piastra = $('#NAB');
    var image_dropzone = $('#image_dropzone');
    var button_dropzone = $('#button_dropzone');
    var foto = $('#img_antibio_n');
    var dropzone_to_hidden = $('#dropzone_to_hidden');
    var elimina_foto_antibiogramma = $('#elimina_foto_antibiogramma');
    colonia.attr('id','colonia_'+occorrenze);
    label_colonia.attr('id','label_colonia_'+occorrenze);
    label_colonia.attr('for',colonia.attr('id'));
    select_antibiotici.attr('id','antibiotici_'+occorrenze);
    select_resistenza.attr('id','resistenza_'+occorrenze);
    text_area_antibiotico_resistenza.attr('id','text_area_antibiotico_resistenza_'+occorrenze);
    text_area_antibiotico_resistenza.css('background-color','#f0f8ff');
    cancella_antibiotico_resistenza.attr('id','cancella_antibiotico_resistenza_'+occorrenze);
    aggiungi_antibiotico_resistenza.attr('id','aggiungi_antibiotico_resistenza_'+occorrenze);
    codice_piastra.attr('id','NAB_'+occorrenze);
    image_dropzone.attr('id','image_dropzone_'+occorrenze);
    button_dropzone.attr('id','button_dropzone_'+occorrenze);
    dropzone_to_hidden.attr('id','dropzone_to_hidden_'+occorrenze);
    elimina_foto_antibiogramma.attr('id','elimina_foto_antibiogramma_'+occorrenze);
    foto.attr('id','img_antibiogramma'+occorrenze);
    foto.attr('alt','Antibiogramma '+occorrenze);
    
    
   
    select_antibiotici.selectpicker();
    select_resistenza.selectpicker();

    dropzoneAltri.dropzone({
        url:"/immaginiantibiogramma",
        method:"post",
        maxFilesize: 5,
        paramName:"file",
        addRemoveLinks: true,
        init: function() {
            this.on("addedfile", function(file) { 
                // alert("File Caricato."); 
            });
            this.on("sending", function(file, xhr, formData){
                formData.append('NAB',$('#NAB_'+occorrenze).val());
                formData.append('code',code);
                formData.append('tipo','antibiogramma'+occorrenze);
                formData.append("_token", token);
            });
            this.on("complete", function(file) {
                this.removeFile(file);
            });       
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data, returnValue) {
            text = "Immagine Antibiogramma "+ occorrenze +" aggiunta correttamente.";
            showNotification('alert-success', text, 'top', 'right', null, null);
            var url = image_dropzone.children().children().children().attr('src');
            url = url + "/"+data.name;
            image_dropzone.children().children().children().attr('src',url);
            dropzone_to_hidden.addClass('hidden');
            image_dropzone.removeClass('hidden');
            button_dropzone.removeClass('hidden');

            $.AdminBSB.select.refresh();
        },
        error: function(response) {
            console.log(stato);
            showNotification('alert-danger', stato.error, 'top', 'right', null, null);
    
            return false;
        }
    });
   
    $(this).attr('occorrenze',occorrenze);

    update_antibiotico_resistenza(occorrenze);

    button_dropzone.on('click',function(){
        $('#eliminaFotoMotivo').val("");
        elimina_immagine_antibiogramma(occorrenze);
    })

    foto.on('click',function(){
        var modalImg = $('#imageBigger');
        var captionText = $('#defaultModalLabel');
        modalImg.attr('src',$(this).attr('src'));
        captionText.text($(this).attr('alt'));
    })

    $('#NAB_'+occorrenze).on('change',function(){
        var colore = semaforo(occorrenze);
        if(colore == "verde")
        {
            $('#aggiungi_antibiogramma').prop('disabled',false);
        }
        else
        {
            $('#aggiungi_antibiogramma').prop('disabled',true);
        }
    });

    setInterval(function(){  
        verifica_immagine(occorrenze);
	}, 500);

    setInterval(function(){  
        verifica_text_area(occorrenze);
	}, 500);
});


function update_antibiotico_resistenza(occorrenza)
{
    $('#antibiotici_'+occorrenza).on('change',function(){
        if($('#antibiotici_'+occorrenza+' option:selected').val() != "" && $('#resistenza_'+occorrenza+' option:selected').val() != "")
        {
            $('#aggiungi_antibiotico_resistenza_'+occorrenza).prop('disabled',false);   
        }
        else
        {
            $('#aggiungi_antibiotico_resistenza_'+occorrenza).prop('disabled',true);   
        }
    });


    $('#resistenza_'+occorrenza).on('change',function(){
        if($('#antibiotici_'+occorrenza+' option:selected').val() != "" && $('#resistenza'+occorrenza+' option:selected').val() != "")
        {
            $('#aggiungi_antibiotico_resistenza_'+occorrenza).prop('disabled',false);   
        }
        else
        {
            $('#aggiungi_antibiotico_resistenza_'+occorrenza).prop('disabled',true);   
        }
    });

    $('#text_area_antibiotico_resistenza_'+occorrenza).on('change',function(){
        if($('#text_area_antibiotico_resistenza_'+occorrenza+' option:selected').val() != "")
        {
            $('#cancella_antibiotico_resistenza_'+occorrenza).prop('disabled',false);   
        }
        else
        {
            $('#cancella_antibiotico_resistenza_'+occorrenza).prop('disabled',true);   
        }
    });

    $('#aggiungi_antibiotico_resistenza_'+occorrenza).on('click',function(e){
        e.preventDefault();
        var id_antibiotico = $('#antibiotici_'+occorrenza+' option:selected').val();
        var nome_antibiotico = $('#antibiotici_'+occorrenza+' option:selected').text();
        var key_resistenza = $('#resistenza_'+occorrenza+' option:selected').val();
        var resistenza = $('#resistenza_'+occorrenza+' option:selected').text();
        var NAB = $('#NAB_'+occorrenza).val();
        
        showNotification('alert-success',"Antibiotico resistenza inserita correttamente", 'top', 'right', null, null);
        var newOption = new Option(nome_antibiotico + " " + resistenza, id_antibiotico);
        newOption.setAttribute('id_antibiotico',id_antibiotico);
        newOption.setAttribute('key_resistenza',key_resistenza);
        newOption.setAttribute('NAB',NAB);
        newOption.setAttribute('deletable',0);   
        $('#text_area_antibiotico_resistenza_'+occorrenza).append(newOption);
        $('#text_area_antibiotico_resistenza_'+occorrenza+' option:contains("Non sono presenti antibiotici con le relative resistenze")').remove();
        $('#antibiotici_'+occorrenza).val('');
        $('#antibiotici_'+occorrenza).trigger('change');
        $('#resistenza_'+occorrenza).val('');
        $('#resistenza_'+occorrenza).trigger('change');
        $('#aggiungi_antibiotico_resistenza_'+occorrenza).prop('disabled',true);

    })

    $('#cancella_antibiotico_resistenza_'+occorrenza).on('click',function(e){
        e.preventDefault();
        var deletable =  $('#text_area_antibiotico_resistenza_'+occorrenza+' option:selected').attr('deletable');
        var id_ar =  $('#text_area_antibiotico_resistenza_'+occorrenza+' option:selected').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/antibioticiantibiogrammi/delete",
            type: "POST",
            dataType: "json",
            data: {
                id: id_ar,
                deletable: deletable
            },
            success: function(returnValue) {
                showNotification('alert-success',"Antibiotico resistenza eliminata correttamente", 'top', 'right', null, null);
                $('#text_area_antibiotico_resistenza_'+occorrenza+' option:selected').remove();
                $('#cancella_antibiotico_resistenza_'+occorrenza).prop('disabled',true);
                $.AdminBSB.select.refresh();
            }, 
            error: function(response, stato) {
                console.log(response);
                console.log(stato);
                if(stato == 'error')
                {
                    showNotification('alert-danger',response.responseJSON.error, 'top', 'right', null, null);
                }
                else
                {
                    showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
    
                }
            }
        });
    });   
}

function elimina_antibiogramma(occorrenza)
{
    $('#cancella_antibiogramma_'+occorrenza).on('click',function(e){
        e.preventDefault();
        let aa = [];
        var nab = $('#NAB_'+occorrenza).attr('nab_value');
        $("#text_area_antibiotico_resistenza_"+occorrenza+" > option").each(function() {
            var antibiotico_antibiogramma = {'id_aa':$(this).val()};
            aa.push(antibiotico_antibiogramma);
        });
        var colonia = $('#colonia_'+occorrenza).attr('colonia_value');
        var nome_file = $('#img_piastra_'+occorrenza).attr('nome_file');
        var tipo = $('#img_piastra_'+occorrenza).attr('tipo');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro?",
            text: "Confermi di voler eliminare il seguente antibiogramma?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, procedi",
            confirmButtonColor: "#8CD4F5",
            cancelButtonText: "No, annulla",
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "/microantibiogramma/delete",
                    type: "POST",
                    dataType: "json",
                    data: {
                        aa:aa,
                        nab:nab,
                        colonia:colonia,
                        nome_file:nome_file,
                        id_campione:idCampione,
                        tipo:tipo
                    },
                    success: function(returnValue) {
                        $('#deletable_'+occorrenza).addClass('hidden');
                        showNotification('alert-success',"Antibiogramma eliminato correttamente", 'top', 'right', null, null);
                    }, 
                    error: function(response, stato) {
                        showNotification('alert-danger',"Si è verificato un problema con l'eliminazione di un antibiogramma, riprovare", 'top', 'right', null, null);
                    }
                });
            }
        });
    })
}

$('#img_antibio_n').on('click',function(){
    var modalImg = $('#imageBigger');
    var captionText = $('#defaultModalLabel');
    modalImg.attr('src',$(this).attr('src'));
    captionText.text($(this).attr('alt'));
})


function verifica_text_area(occorrenza)
{
    var verifica_text_area = 0;
    $("#text_area_antibiotico_resistenza_"+occorrenza+" > option").each(function() {
        if($(this).val() != "")
        {
            verifica_text_area++;
        }
    });

    if(verifica_text_area != 0)
    {
        var colore = semaforo(occorrenze);
        if(colore == "verde")
        {
            $('#aggiungi_antibiogramma').prop('disabled',false);
        }
        else
        {
            $('#aggiungi_antibiogramma').prop('disabled',true);
        }
    }
}

function verifica_immagine(occorrenza)
{
    var verifica_immagine = false;
     
    var verifica_immagine = $('#image_dropzone_'+occorrenza).hasClass('hidden') ? false : true;


    if(verifica_immagine == true)
    {
        var colore = semaforo(occorrenze);
        if(colore == "verde")
        {
            $('#aggiungi_antibiogramma').prop('disabled',false);
        }
        else
        {
            $('#aggiungi_antibiogramma').prop('disabled',true);
        }
    }
}

function semaforo(occorrenza)
{
    var output = "verde";
    var nab = $('#NAB_'+occorrenza).val();
    var immagine_inserita = $('#image_dropzone_'+occorrenza).hasClass('hidden') ? false : true;

    var lista_antibiotico_resistenza = 0;
    $("#text_area_antibiotico_resistenza_"+occorrenza+" > option").each(function() {
        if($(this).val() != "")
        {
            lista_antibiotico_resistenza++;
        }
    });


    /**
     * Se almeno uno dei tre manca allora non posso procedere, altrimenti procedo n.b: era possibile fare l'esatto opposto, ovvero settare a verde output se tutte erano presente, ma così almeno si hanno chiari i vari casi
     */
    if(nab == "" && lista_antibiotico_resistenza == 0 && immagine_inserita == false)
    {
        output = "rosso";
    }

    if(nab != "" && lista_antibiotico_resistenza == 0 && immagine_inserita == false)
    {
        output = "rosso";
    }

    if(nab != "" && lista_antibiotico_resistenza != 0 && immagine_inserita == false)
    {
        output = "rosso";
    }

    if(nab != "" && lista_antibiotico_resistenza == 0 && immagine_inserita != false)
    {
        output = "rosso";
    }

    if(nab == "" && lista_antibiotico_resistenza != 0 && immagine_inserita != false)
    {
        output = "rosso";
    }

    if(nab == "" && lista_antibiotico_resistenza != 0 && immagine_inserita == false)
    {
        output = "rosso";
    }

    if(nab == "" && lista_antibiotico_resistenza == 0 && immagine_inserita != false)
    {
        output = "rosso";
    }

    return output;
}