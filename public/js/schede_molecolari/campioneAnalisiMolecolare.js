var presenza_micro = $('#presenzamicro').is(':checked');
//var idCampione = $('.id_campione').attr('id_campione');
var code = $('.code_image').attr('code');
var token = $('meta[name="csrf-token"]').attr('content');

if(presenza_micro){
    $('#simicro').removeClass('hidden');
    $('#fotostriscio').removeClass('hidden');
    $('#sez_antibiogrammi').removeClass('hidden');
}

$('#presenzamicro').on('change',function(){
    if($('#presenzamicro').is(':checked'))
    {
        $('#simicro').removeClass('hidden');
        $('#fotostriscio').removeClass('hidden');
        $('#presenzamicro_note').removeClass('hidden');
        $('#sez_antibiogrammi').removeClass('hidden');
    }
    else
    {
        $('#simicro').addClass('hidden');
        $('#fotostriscio').addClass('hidden');
        $('#presenzamicro_note').addClass('hidden');
        $('#sez_antibiogrammi').addClass('hidden');
    }
})

$('#microrganismi').on('change',function(){
    if($('#microrganismi option:selected').val() != "")
    {
        $('#aggiungi_microrganismo').prop('disabled',false);
    }
    else
    {
        $('#aggiungi_microrganismo').prop('disabled',true);
    }
});

$("#text_area_microrganismi_segnati").on('change',function(e) {
    e.preventDefault();
    var $optionSelected = $("option:selected", this);
    var selectedValue = $optionSelected.val();   
    if (selectedValue != "" ) {
        $('#cancella_microrganismo').prop("disabled", false);
    } 
    else {
        $('#cancella_microrganismo').prop("disabled", true)
    }
    
});

$('#aggiungi_microrganismo').on('click',function(e){
    e.preventDefault();
    var nome = $('#microrganismi option:selected').text();
    var id_microrganismo = $('#microrganismi option:selected').val();
    var id_tipopiastra = $('#tipoPiastra option:selected').val();
    var presente = 1;
    var newOption = new Option(nome, id_microrganismo);
    newOption.setAttribute('id_microrganismo',id_microrganismo);
    newOption.setAttribute('id_tipopiastra',id_tipopiastra);
    newOption.setAttribute('presente',presente);
    newOption.setAttribute('deletable',0);       
    showNotification('alert-success',"Microrganismo inserito correttamente", 'top', 'right', null, null);     
    $('#text_area_microrganismi_segnati').append(newOption);
    $('#text_area_microrganismi_segnati option:contains("Non sono stati rilevati microrganismi")').remove();
    $('#microrganismi').val('');
    $('#microrganismi').trigger('change');
});

$('#cancella_microrganismo').on('click',function(e){
    e.preventDefault();
    var microsupiastra_id = $('#text_area_microrganismi_segnati option:selected').val();
    var deletable = $('#text_area_microrganismi_segnati option:selected').attr('deletable');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/microsupiastraswab/delete",
        type: "POST",
        dataType: "json",
        data: {
            id: microsupiastra_id,
            deletable: deletable
        },
        success: function(returnValue) {
            showNotification('alert-success',"Microrganismo eliminato correttamente", 'top', 'right', null, null);
            $('#text_area_microrganismi_segnati option:selected').remove();
            $('#cancella_microrganismo').prop('disabled',true);
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

Dropzone.options.dropzoneStriscio = {
    init: function() {
        this.on("addedfile", function(file) { 
            // alert("File Caricato."); 
        });
        this.on("sending", function(file, xhr, formData){
            formData.append('code',code);
            formData.append('tipo','striscio');
            //formData.append("id_campione", idCampione);
            //formData.append("_token", token);
            //formData.append("tipo", $tipoDocumento);
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
    success: function(data, returnValue) {
		text = "Foto striscio aggiunta correttamente.";
		showNotification('alert-success', text, 'top', 'right', null, null);
        var url = $('#dropzone_view').children().children().children().attr('src');
        url = url + "/"+data.name;
        $('#dropzone_view').children().children().children().attr('src',url);
        $('#dropzone_store').addClass('hidden');
        $('#dropzone_view').removeClass('hidden');
        $('#dropzone_elimina_button').removeClass('hidden');
		$.AdminBSB.select.refresh();
	},
    error: function(response) {
        if(response.responseJSON.message == "Undefined variable: from") 
        {
            showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
        }
        else 
        {
            showNotification('alert-danger', response.responseJSON.error, 'top', 'right', null, null);
        }
        return false;
    }
}

$('#elimina_striscio').on('click',function(){
    $('#eliminaFotoMotivo').val("");
    elimina_striscio();
})

function elimina_striscio()
{
    $('#elimina_foto_conferma').on('click',function(e){
        var id = $(this).attr('idScheda') == 'nuova' ? $(this).attr('codeScheda') : $(this).attr('idScheda');
        var tipoTabella = $(this).attr('idScheda') == 'nuova' ? 'temporary' : 'campioni';
        var tipoFoto = $('#elimina_striscio').attr('tipo');
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
                    url:"/immaginipiastreswab/delete",
                    type:"POST",
                    dataType: "json",
                    data: {
                        id: id,
                        tipoTabella: tipoTabella,
                        tipoFoto: tipoFoto,
                        motivo: motivo
                    },	
                    success: function(html){
                        text = "Foto striscio rimossa correttamente";
                        $('#eliminaFotoModal').modal('hide');
                        if(tipoTabella == 'temporary')
                        {
                            var oldsrc = $('#dropzone_view').children().children().children().attr('src');
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
                            $('#dropzone_view').children().children().children().attr('src',newsrc);
                            console.log(newsrc);
                        }
                        if(tipoTabella == 'campioni')
                        {
                            var oldsrc = $('#dropzone_view').children().children().children().attr('src');
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
                            $('#dropzone_view').children().children().children().attr('src',newsrc);
                            console.log(newsrc);
                        }
                        
                        $('#dropzone_store').removeClass('hidden');
                        $('#dropzone_view').addClass('hidden');
                        $('#dropzone_elimina_button').addClass('hidden');
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

$('#img_striscio').on('click',function(){
    var modalImg = $('#imageBigger');
    var captionText = $('#defaultModalLabel');

    modalImg.attr('src',$(this).attr('src'));
    captionText.text($(this).attr('alt'));
});