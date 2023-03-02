const MicroListBGN = [];
const MicroListBGP = [];
const MicroListEB = [];
const MicroListCOL = [];

var tipoScheda = $('.tipo').attr('tipo');

$(window).on('load',function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/microrganismopiastra/group",
        type: "GET",
        dataType: "json",
        success: function(returnValue) {
            returnValue['BGN'].forEach(element => {
                MicroListBGN.push(element);
            });
            returnValue['BGP'].forEach(element => {
                MicroListBGP.push(element);
            });
            returnValue['EB'].forEach(element => {
                MicroListEB.push(element);
            });
            returnValue['COL'].forEach(element => {
                MicroListCOL.push(element);
            });
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

    if(tipoScheda == 'N' || tipoScheda == 'B')
    {
        var id_tipopiastra = $('#id_tipo_piastra').val();
        load_microrganismo(id_tipopiastra);
    }

    if(tipoScheda == 'B')
    {
        $('.scelta_tipo_campionamento').addClass('hidden')
    }
})

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

$("#text_area_microrganismi_ricercati").on('change',function(e) {
    e.preventDefault();
    var $optionSelected = $("option:selected", this);
    var selectedValue = $optionSelected.val();  
    console.log(selectedValue) 
    if (selectedValue != "" ) {
        $('#cancella_microrganismo_speciazione').prop("disabled", false);
    } 
    else {
        $('#cancella_microrganismo_speciazione').prop("disabled", true)
    }
    
});

$('#microrganismi').on('change',function(){
    if($('#microrganismi option:selected').val() != "")
    {
        $('#aggiungi_microrganismo').prop('disabled',false);
    }
    else
    {
        $('#aggiungi_microrganismo').prop('disabled',true);
    }
})

$('#flag_speciazione').is(':checked') ? $('.ricerca-speciazione').removeClass('hidden') : $('.ricerca-speciazione').addClass('hidden');

$('#flag_speciazione').on('click',function(){
    if($('#flag_speciazione').is(':checked'))
    {
        $('.ricerca-speciazione').removeClass('hidden');
    }
    else
    {
        $('.ricerca-speciazione').addClass('hidden');
    }
});

$('#speciazione_microrganismi').on('change',function(){
    if($('#speciazione_microrganismi option:selected').val() != "")
    {
        $('#aggiungi_speciazione').prop('disabled',false);
    }
    else
    {
        $('#aggiungi_speciazione').prop('disabled',true);
    }
})


$('#piastraextra').on('click',function(){
    if($('#piastraextra').is(':checked'))
    {
        // $('#tiextra').removeClass('hidden');
        $('#fotopiastraextra').removeClass('hidden');
    }
    else
    {
        // $('#tiextra').addClass('hidden');
        $('#fotopiastraextra').addClass('hidden');
    }
});

if($('#piastraextra').is(':checked'))
{
    // $('#tiextra').removeClass('hidden');
    $('#fotopiastraextra').removeClass('hidden');
}
else
{
    // $('#tiextra').addClass('hidden');
    $('#fotopiastraextra').addClass('hidden');
}

// if($('#tiextra option:selected').val() != '')
// {
//     $('#piastraextra').prop('checked',true);
//     // $('#tiextra').removeClass('hidden');
//     $('#fotopiastraextra').removeClass('hidden');
// }

$('#id_tipo_piastra').on('change',function(){
    if(tipoScheda == 'N' || tipoScheda == 'B')
    {
        var id = $(this).val();
        load_microrganismo(id);
    }
});

function load_microrganismo(id)
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/micropiastra/getMicro",
        type: "GET",
        dataType: "json",
        data: {
            id: id,
        },
        success: function(returnValue) {
            clear_options_micro($('#microrganismi'),$('#microrganismi').prev("div"),[]);
            clear_options_micro($('#speciazione_microrganismi'),$('#speciazione_microrganismi').prev("div"),[]);
            var newOption = new Option('-- Seleziona un microrganismo --','');
            $('#microrganismi').append(newOption);
            $('#speciazione_microrganismi').append(newOption);
            replace_options_micro($('#microrganismi'),$('#microrganismi').prev("div"),returnValue['microrganismo']);
            replace_options_micro($('#speciazione_microrganismi'),$('#speciazione_microrganismi').prev("div"),returnValue['microrganismo']);
        },
        error: function(status)
        {
            console.log(status);
        },
    });
}

function clear_options_micro(select,dropdownSelect,array)
{
    $(select).empty();
    $(dropdownSelect).children().empty();
    if(array.length == 0)
    {
        let newOption = new Option('-- Seleziona un microrganismo --','');
        $(select).append(newOption);
        liOption = '<li data-original-index="0" class="selected"><a tabindex?"'+0+'" data-tokens="null"><span class="text"> -- Seleziona un microrganismo -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
        $(dropdownSelect).prev('button').children('.filter-option').text('-- Seleziona un microrganismo --');
        $(dropdownSelect).children().append(liOption); 
    }
}

function replace_options_micro(select,dropdownSelect,array)
{
	$(select).empty();
	$(dropdownSelect).children().empty();
	if(array.length == 0)
	{
		let newOption = new Option('-- Non sono presenti microrganismi --', 'nessuna');
		$(select).append(newOption);
		liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti microrganismi -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
		$(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti microrganismi --');
		$(dropdownSelect).children().append(liOption);
	}
	else
	{
		$.each(array, function (i, item) {
			let newOption = new Option(item.microrganismo, item.id);
			$(select).append(newOption);
			let liOption;
			if(item.id == 1)
			{
				liOption = '<li data-original-index="'+i+'" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.microrganismo+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
				$(dropdownSelect).prev('button').attr('title',item.microrganismo);
				$(dropdownSelect).prev('button').children('.filter-option').text(item.microrganismo);
                $('#aggiungi_microrganismo').prop('disabled',false);
                $('#microrganismi option:selected').val(item.id);
			}
			else
			{
				liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.microrganismo+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
			}
			$(dropdownSelect).children().append(liOption);
		});
	}
}


$('#aggiungi_microrganismo').on('click',function(e){
    e.preventDefault();
    var id_microrganismo = $('#microrganismi option:selected').val();
    console.log(id_microrganismo);
    var id_tipopiastra = $('#id_tipo_piastra option:selected').val();
    var cfu = $('#CFU').val();
    var tipoCamp = $('#superficie').is(':checked') ? "S" : "A";
    var incertezza = $('#incertezza').is(':checked');
    var speciazione = $('#speciazione').is(':checked');
    var speciazione_risultato = $('#speciazione_risultato option:selected').val();
    var u = $('#incertezza').attr('incertezza');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/microsupiastra/getMicro",
        type: "POST",
        dataType: "json",
        data: {
            id_microrganismo: id_microrganismo,
            id_tipopiastra: id_tipopiastra,
            cfu: cfu,
            tipoCamp: tipoCamp,
            incertezza: incertezza,
            speciazione: speciazione,
            speciazione_risultato: speciazione_risultato,
            u: u
        },
        success: function(returnValue) {
            showNotification('alert-success',"Microrganismo inserito correttamente", 'top', 'right', null, null);
            var s = $('#superficie').is(':checked');
	        var a = $('#aria').is(':checked');
            var descrizione = "";
            if(s == true || tipoScheda == 'B')
            {
                if($('#tipocampione_superficie option:selected').val() == 'piastra')
                {
                    if(returnValue['incertezzaSx'] != null && returnValue['incertezzaDx'] != null)
                    {
                        descrizione = returnValue['nome_microrganismo'] + " - " + returnValue['cfu'] + " CFU - " + returnValue['cfu_s']  + " CFU/m²" + " - incertezza: " + returnValue['incertezzaSx'] + ", " + returnValue['incertezzaDx'];
                    }
                    else
                    {
                        descrizione = returnValue['nome_microrganismo'] + " - " + returnValue['cfu'] + " CFU - " + returnValue['cfu_s']  + " CFU/m²" ;
                    }
                }
                else
                {
                    if(returnValue['incertezzaSx'] != null && returnValue['incertezzaDx'] != null)
                    {
                        descrizione = returnValue['nome_microrganismo'] + " - " + returnValue['cfu'] + " CFU - " + returnValue['cfu'] + " CFU/m²" + " - incertezza: " + returnValue['incertezzaSx'] + ", " + returnValue['incertezzaDx'];
                    }
                    else
                    {
                        descrizione = returnValue['nome_microrganismo'] + " - " + returnValue['cfu'] + " CFU - " + returnValue['cfu'] + " CFU/m²"                    
                    }

                }
            }
            if(a == true || tipoScheda == 'B')
            {

                if($('#tipocampione_aria option:selected').val() == 'attivo')
                {
                    if(returnValue['incertezzaSx'] != null && returnValue['incertezzaDx'] != null)
                    {
                        descrizione = returnValue['nome_microrganismo'] + " - " + returnValue['cfu'] + " CFU - " + returnValue['cfu_a'] + " - incertezza: " + returnValue['incertezzaSx'] + ", " + returnValue['incertezzaDx'];
                    }
                    else
                    {
                        descrizione = returnValue['nome_microrganismo'] + " - " + returnValue['cfu'] + " CFU - " + returnValue['cfu_a'];
                    }
                }
                else
                {
                    if(returnValue['incertezzaSx'] != null && returnValue['incertezzaDx'] != null)
                    {
                        descrizione = returnValue['nome_microrganismo'] + " - " + returnValue['cfu'] + " CFU - " + returnValue['cfu_h'] + " - incertezza: " + returnValue['incertezzaSx'] + ", " + returnValue['incertezzaDx'];
                    }
                    else
                    {
                        descrizione = returnValue['nome_microrganismo'] + " - " + returnValue['cfu'] + " CFU - " + returnValue['cfu_h'];
                    }
                }
            }
            var newOption = new Option(descrizione, returnValue['id']);
            newOption.setAttribute('id_microrganismo',id_microrganismo);
            newOption.setAttribute('id_tipopiastra',id_tipopiastra);
            newOption.setAttribute('cfu',cfu);
            newOption.setAttribute('cfu_m_s',returnValue['cfu_s']);
            newOption.setAttribute('cfu_m_a',returnValue['cfu_a']);
            newOption.setAttribute('cfu_m_h',returnValue['cfu_h']);
            newOption.setAttribute('incertezzaSx',returnValue['incertezzaSx']);
            newOption.setAttribute('incertezzaDx',returnValue['incertezzaDx']);
            newOption.setAttribute('deletable',0);            
            $('#text_area_microrganismi_segnati').append(newOption);
            $('#text_area_microrganismi_segnati option:contains("Non sono stati rilevati microrganismi")').remove();
            $('#microrganismi').val('');
            $('#microrganismi').trigger('change');
            $('#CFU').val('');
            $('#speciazione_risultato').val('').trigger('change');
            $('#speciazione').prop('checked',false);
            $('#incertezza').prop('checked',false);
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

$('#aggiungi_speciazione').on('click',function(e){
    e.preventDefault();
    var id_microrganismo = $('#speciazione_microrganismi option:selected').val();
    var id_tipopiastra = $('#id_tipo_piastra option:selected').val();
    var tipoCamp = $('#superficie').is(':checked') ? "S" : "A";
    var speciazione_risultato = $('#esito_speciazione option:selected').val();

    if(id_microrganismo == '' || speciazione_risultato == '')
    {
        showNotification('alert-danger','Inserire correttamente tutti i campi', 'top', 'right', null, null);
        return '';
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/speciazione/getMicro",
        type: "POST",
        dataType: "json",
        data: {
            id_microrganismo: id_microrganismo,
            id_tipopiastra: id_tipopiastra,
            tipoCamp: tipoCamp,
            speciazione_risultato: speciazione_risultato,
        },
        success: function(returnValue) {
            showNotification('alert-success',"Microrganismo inserito correttamente", 'top', 'right', null, null);
            var newOption = new Option(returnValue['descrizione'], returnValue['id']);
            newOption.setAttribute('id_microrganismo',id_microrganismo);
            newOption.setAttribute('id_tipopiastra',id_tipopiastra);
            newOption.setAttribute('speciazione_risultato',returnValue['esito']);
            newOption.setAttribute('tipoCamp',returnValue['tipoCamp']);
            newOption.setAttribute('deletable',0);            
            $('#text_area_microrganismi_ricercati').append(newOption);
            $('#text_area_microrganismi_ricercati option:contains("Non sono stati rilevati microrganismi")').remove();
            $('#speciazione_microrganismi').val('');
            $('#speciazione_microrganismi').trigger('change');
            $('#esito_speciazione').val('').trigger('change');
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
        url: "/microsupiastra/delete",
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

$('#cancella_microrganismo_speciazione').on('click',function(e){
    e.preventDefault();
    var speciazione_id = $('#text_area_microrganismi_ricercati option:selected').val();
    var deletable = $('#text_area_microrganismi_ricercati option:selected').attr('deletable');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/speciazione/delete",
        type: "POST",
        dataType: "json",
        data: {
            id: speciazione_id,
            deletable: deletable
        },
        success: function(returnValue) {
            showNotification('alert-success',"Microrganismo eliminato correttamente", 'top', 'right', null, null);
            $('#text_area_microrganismi_ricercati option:selected').remove();
            $('#cancella_microrganismo_speciazione').prop('disabled',true);
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

$(window).on('load',function(){
    var s = $('#superficie').is(':checked');
	var a = $('#aria').is(':checked');

    if(s == true)
	{
		$('.aria').addClass('hidden');
		var optionText = [];
		var optionAttr = [];
		var nuovoCFU = "";
		var nuovoText = "";
		var oldText = [];
		$("#text_area_microrganismi_segnati > option").each(function(item,opt) {
            optionText[item] = $(opt).text();
            if($('#tipocampione_superficie option:selected').val() == 'piastra')
            {
                optionAttr[optionText[item]] = $(opt).attr('cfu_m_s');            
            }
            else
            {
                optionAttr[optionText[item]] = $(opt).attr('cfu');            
            }
            oldText[optionText[item]] = opt;
		});
		optionText.forEach(element => {
			const array = element.split("-");
			nuovoCFU = optionAttr[element];
			array[2] = nuovoCFU;
            if(array[3] != undefined)
            {
                nuovoText = array[0] + " - " + array[1] + " - " + array[2] + " - " + array[3];
            }
            else
            {
                nuovoText = array[0] + " - " + array[1] + " - " + array[2];
            }
			$(oldText[element]).text(nuovoText);
		});
	}

	if(a == true)
	{
		$('.superficie').addClass('hidden');
		var optionText = [];
		var optionAttr = [];
		var nuovoCFU = "";
		var nuovoText = "";
		var oldText = [];
		$("#text_area_microrganismi_segnati > option").each(function(item,opt) {
            optionText[item] = $(opt).text();
            if($('#tipocampione_aria option:selected').val() == 'attivo')
            {
                optionAttr[optionText[item]] = $(opt).attr('cfu_m_a');
            }
            else
            {
                optionAttr[optionText[item]] = $(opt).attr('cfu_m_h');
            }
            oldText[optionText[item]] = opt;
		});
		optionText.forEach(element => {
			const array = element.split("-");
			nuovoCFU = optionAttr[element];
			array[2] = nuovoCFU;
            if(array[3] != undefined)
            {
                nuovoText = array[0] + " - " + array[1] + " - " + array[2] + " - " + array[3];
            }
            else
            {
                nuovoText = array[0] + " - " + array[1] + " - " + array[2];
            }
			$(oldText[element]).text(nuovoText);
		});
	}
})

$('#superficie').on('click',function(){
    var optionText = [];
    var optionAttr = [];
    var nuovoCFU = "";
    var nuovoText = "";
    var oldText = [];
    $("#text_area_microrganismi_segnati > option").each(function(item,opt) {
        optionText[item] = $(opt).text();
        if($('#tipocampione_superficie option:selected').val() == 'piastra')
        {
            optionAttr[optionText[item]] = $(opt).attr('cfu_m_s');            
        }
        else
        {
            optionAttr[optionText[item]] = $(opt).attr('cfu') + " CFU/Piastra";            
        }
        oldText[optionText[item]] = opt;
    });
    optionText.forEach(element => {
        const array = element.split("-");
        nuovoCFU = optionAttr[element];
        array[2] = nuovoCFU;
        if(array[3] != undefined)
        {
            nuovoText = array[0] + " - " + array[1] + " - " + array[2] + " - " + array[3];
        }
        else
        {
            nuovoText = array[0] + " - " + array[1] + " - " + array[2];
        }
        $(oldText[element]).text(nuovoText);
    });
})

$('#aria').on('click',function(){
    var optionText = [];
    var optionAttr = [];
    var nuovoCFU = "";
    var nuovoText = "";
    var oldText = [];
    $("#text_area_microrganismi_segnati > option").each(function(item,opt) {
        optionText[item] = $(opt).text();
        if($('#tipocampione_aria option:selected').val() == 'attivo')
        {
            optionAttr[optionText[item]] = $(opt).attr('cfu_m_a');
        }
        else
        {
            optionAttr[optionText[item]] = $(opt).attr('cfu_m_h');
        }
        oldText[optionText[item]] = opt;
    });
    optionText.forEach(element => {
        const array = element.split("-");
        nuovoCFU = optionAttr[element];
        array[2] = nuovoCFU;
        if(array[3] != undefined)
        {
            nuovoText = array[0] + " - " + array[1] + " - " + array[2] + " - " + array[3];
        }
        else
        {
            nuovoText = array[0] + " - " + array[1] + " - " + array[2];
        }
        $(oldText[element]).text(nuovoText);
    });
})

$('#tipocampione_aria').on('change',function(){
    var value = $(this).val();
    var optionText = [];
    var optionAttr = [];
    var nuovoCFU = "";
    var nuovoText = "";
    var oldText = [];
    $("#text_area_microrganismi_segnati > option").each(function(item,opt) {
        optionText[item] = $(opt).text();
        if(value == 'attivo')
        {
            optionAttr[optionText[item]] = $(opt).attr('cfu_m_a');            
        }
        else
        {
            optionAttr[optionText[item]] = $(opt).attr('cfu_m_h');            
        }
        oldText[optionText[item]] = opt;
    });
    optionText.forEach(element => {
        const array = element.split("-");
        nuovoCFU = optionAttr[element];
        array[2] = nuovoCFU;
        if(array[3] != undefined)
        {
            nuovoText = array[0] + " - " + array[1] + " - " + array[2] + " - " + array[3];
        }
        else
        {
            nuovoText = array[0] + " - " + array[1] + " - " + array[2];
        }        
        $(oldText[element]).text(nuovoText);
    });
})

$('#tipocampione_superficie').on('change',function(){
    var value = $(this).val();
    var optionText = [];
    var optionAttr = [];
    var nuovoCFU = "";
    var nuovoText = "";
    var oldText = [];
    $("#text_area_microrganismi_segnati > option").each(function(item,opt) {
        optionText[item] = $(opt).text();
        if(value == 'piastra')
        {
            optionAttr[optionText[item]] = $(opt).attr('cfu_m_s');            
        }
        else
        {
            optionAttr[optionText[item]] = $(opt).attr('cfu') + " CFU/Piastra";            
        }
        oldText[optionText[item]] = opt;
    });
    optionText.forEach(element => {
        const array = element.split("-");
        nuovoCFU = optionAttr[element];
        array[2] = nuovoCFU;
        if(array[3] != undefined)
        {
            nuovoText = array[0] + " - " + array[1] + " - " + array[2] + " - " + array[3];
        }
        else
        {
            nuovoText = array[0] + " - " + array[1] + " - " + array[2];
        }
        $(oldText[element]).text(nuovoText);
    });
})

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

//var idCampione = $('.id_campione').attr('id_campione');
var code = $('.code_image').attr('code');
var token = $('meta[name="csrf-token"]').attr('content');

Dropzone.options.dropzone1 = {
    init: function() {
        this.on("addedfile", function(file) { 
            // alert("File Caricato."); 
        });
        this.on("sending", function(file, xhr, formData){
            formData.append('code',code);
            formData.append('tipo','piastra1');
            //formData.append("id_campione", idCampione);
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
		text = "Foto piastra 1 aggiunta correttamente.";
		showNotification('alert-success', text, 'top', 'right', null, null);
        var url = $('#1_dropzone_2').children().children().children().children().attr('src');
        url = url + "/"+returnValue['nome'];
        $('#1_dropzone_2').children().children().children().children().attr('src',url);
        $('#1_dropzone_1').addClass('hidden');
        $('#1_dropzone_2').removeClass('hidden');
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

Dropzone.options.dropzone2 = {
    init: function() {
        this.on("addedfile", function(file) { 
            // alert("File Caricato."); 
        });
        this.on("sending", function(file, xhr, formData){
            formData.append('code',code);
            formData.append('tipo','piastra2');
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
		text = "Foto piastra 2 aggiunta correttamente.";
		showNotification('alert-success', text, 'top', 'right', null, null);
        var url = $('#2_dropzone_2').children().children().children().children().attr('src');
        url = url + "/"+returnValue['nome'];
        $('#2_dropzone_2').children().children().children().children().attr('src',url);
        $('#2_dropzone_1').addClass('hidden');
        $('#2_dropzone_2').removeClass('hidden');
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

$('#elimina_foto_1').on('click',function(){
    $('#eliminaFotoMotivo').val("");
    elimina_immagine(1);
})

$('#elimina_foto_2').on('click',function(){
    $('#eliminaFotoMotivo').val("");
    elimina_immagine(2);
})

function elimina_immagine(k)
{
    $('#elimina_foto_conferma').on('click',function(e){
        var id = $(this).attr('idScheda') == 'nuova' ? $(this).attr('codeScheda') : $(this).attr('idScheda');
        var tipoTabella = $(this).attr('idScheda') == 'nuova' ? 'temporary' : 'campioni';
        var tipoFoto = $('#elimina_foto_'+k).attr('tipo');
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
                    url:"/immaginipiastre/delete",
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
                        var i = (tipoFoto == 'piastra1') ? 1 : 2;
                        if(tipoTabella == 'temporary')
                        {
                            var oldsrc = $('#'+i+'_dropzone_2').children().children().children().children().attr('src');
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
                            $('#'+i+'_dropzone_2').children().children().children().children().attr('src',newsrc);
                        }
                        if(tipoTabella == 'campioni')
                        {
                            var oldsrc = $('#'+i+'_dropzone_2').children().children().children().children().attr('src');
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
                            $('#'+i+'_dropzone_2').children().children().children().children().attr('src',newsrc);
                        }
                        
                        $('#'+i+'_dropzone_2').addClass('hidden');
                        $('#'+i+'_dropzone_1').removeClass('hidden');
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


function casuale() {
    num = Math.round(Math.random() * 100);
    document.getElementById("casuale").innerHTML ="Numero casuale " + num;
}

$('#img_piastra1').on('click',function(){
    var modalImg = $('#imageBigger');
    var captionText = $('#defaultModalLabel');

    modalImg.attr('src',$(this).attr('src'));
    captionText.text($(this).attr('alt'));
});

$('#img_piastra2').on('click',function(){
    var modalImg = $('#imageBigger');
    var captionText = $('#defaultModalLabel');

    modalImg.attr('src',$(this).attr('src'));
    captionText.text($(this).attr('alt'));
});

$('#siGramRil').on('change',function(){
    const MicroListID_MO = [];
    const MicroListCFU = [];
    const MicroListMO = []
    $("#text_area_microrganismi_segnati > option").each(function(item,opt) {
        //Da verificare associazione key:value in array. Basta capire questo
        MicroListID_MO[item] = $(opt).attr('id_microrganismo');
        MicroListCFU[item] = $(opt).attr('cfu');
        MicroListMO[item] = $(opt).text();
    });
    aggiornaAlertTable(MicroListID_MO,MicroListCFU,MicroListMO);
})

setInterval(function(){   
    if($('#siGramRil').is(':checked'))
    {
        const MicroListID_MO = [];
        const MicroListCFU = [];
        const MicroListMO = []
        $("#text_area_microrganismi_segnati > option").each(function(item,opt) {
            //Da verificare associazione key:value in array. Basta capire questo
            MicroListID_MO[item] = $(opt).attr('id_microrganismo');
            MicroListCFU[item] = $(opt).attr('cfu');
            MicroListMO[item] = $(opt).text();
        });
        $('#container_alert_table').empty();
        $('#container_alert_table').append('<tr><td><span class="badge bg-red siGram- hidden">Presenza batteri Gram-</span></td></tr>');
        aggiornaAlertTable(MicroListID_MO,MicroListCFU,MicroListMO);
    }
}, 5000);

$('#noGramRil').on('change',function(){
    if($('#noGramRil').is(':checked'))
    {
        $('#container_alert_table').empty();
        $('#container_alert_table').append('<tr><td><span class="badge bg-red siGram- hidden">Presenza batteri Gram-</span></td></tr>');
    }
})

function aggiornaAlertTable(MicroListID_MO, MicroListCFU, MicroListMO)
{
    var AlertList = "";
    var rows = "";
    var lg1 = $('#lineeGuida1').is(':checked');
    var lg2 = $('#lineeGuida2').is(':checked');
    var lg3 = $('#lineeGuida3').is(':checked');
    var lg4 = $('#lineeGuida4').is(':checked');
    var stanza = $('#stanza option:selected').attr('id_stanza');
    var colore;
	var AlertPat;
	var tflusso;
    var idciso;
    var idgmp;
    var oper;
    var at_rest;
    var idcamparia;
    var tc;
	if ($('#aria').is(':checked'))
	{
		if ($('#laminare').is(':checked'))
			tflusso = 'L';
		else if ($('#turbolento').is(':checked'))
			tflusso = 'T';
	}
	if ($('#classificazioneISO option:selected').val() != "")
		idciso = $('#classificazioneISO option:selected').val();
	else
		idciso = 0;
	if ($('#classeGMP option:selected').val())
		idgmp = $('#classeGMP option:selected').val();
	else
		idgmp = 0;
	if ($('#operational').is(':checked'))
		oper = "O";
	else
		oper = "R";
    if ($('#at_rest').is(':checked'))
		at_rest = "R";
	else
		at_rest = "O";
	if ($('#pCampAria option:selected').val() != "")
		idcamparia = $('#pCampAria option:selected').val();
	else
		idcamparia = 0;
	if ($('#aria').is(':checked'))
		tc='A';
	else
		tc='S';
	for (i=0; i < MicroListID_MO.length; i++)
	{ 
		AlertPat = AlertPatogeno(MicroListID_MO[i],MicroListCFU[i], lg1, lg2, lg3, lg4, idciso, idgmp, tc, oper, stanza, idcamparia ,tflusso);
		/*if (TipoScheda=='B')
		{
			if (MicroListID_MO[i]==1)
			{
				if (MicroListCFU[i]==0)
					AlertList = AlertList + "Eseguito controllo falso positivo (Bianco) con esito negativo, risultato CONFORME</br>";
				else
					AlertList = AlertList + "Eseguito controllo falso positivo (Bianco) con esito positivo, risultato NON CONFORME</br>";
			}
		}*/
		if (AlertPat>0)
		{
		    colore = "#ff0000";
            if(Motivo(AlertPat) == 'Patogeno con Gram-')
            {
                $('.siGram-').removeClass('hidden');
            }
            rows = rows + "<tr><td style=\"color:"+colore+"\">" + Motivo(AlertPat)+" "+MicroListMO[i]+"</td></tr>";

		}
	}
    
    $('#container_alert_table').append(rows);
}

//id_microrganismo, cfu, lineeguida1/4, iso, gmp, tipocampionamento, operat, stanza, pcamparia, tflusso
function AlertPatogeno(idmo,cfu,lg1,lg2,lg3,lg4,iso,gmp,tc,oper,stanza,pcamparia,tflusso)
{
	bn = MicroListBGN[idmo] != null ? 1 : 0;
	bp = MicroListBGP[idmo];
	eb = MicroListEB[idmo];
	col = MicroListCOL[idmo];
	//Ritorna combinazione di:
	//		  1 se GramN
	//		  2 se GramP
	//		  4 se EntBac
	//		  8 se Colif
	//		  16 se uno dei batteri in elenco
	//		  32 se supera soglia
	
	//alert (idmo+"->"+bn+","+bp);
	vr=0;
	msg="";
	//Regole ALERT
	if (lg1) //ISPESL 2003
	{
		if (tc=="A")
		{
			if (bn==1)	//ci sono batteri gram-
				vr=vr+1;
			if (cfu>0)
			{
				if (idmo == 63 || idmo == 12 || idmo == 11)	//Staphylococcus aureus || //Aspergillus niger || //Aspergillus fumigatus
                {
					vr=vr+16;
                }
			}
			if (oper=='R') //At Rest
			{
				if (pcamparia==1)	//bocchettone
				{
					if (cfu>1)
						vr=vr+32;
					if (tflusso=='L') //Laminare
					{
                        //
					}
					if (tflusso=='T') //Turbolento
					{
                        //
					}
				}
				else if (pcamparia==2)	//centro stanza
				{
					if (cfu>35)
						vr=vr+32;
					if (tflusso=='L') //Laminare
					{
					}
					if (tflusso=='T') //Turbolento
					{
					}
				}
			}
			else //Operational
			{
				if (tflusso=='L') //Laminare
				{
                    //
				}
				if (tflusso=='T') //Turbolento
				{
                    //
				}
			}
		}					
	}
	if (lg2) //ISPESL 2009
	{
		if (tc=="S")
		{
			if (bn==1)	//ci sono batteri gram-
				vr=vr+1;
			if (eb==1)	//ci sono enterobacteriacee
				vr=vr+4;
			if (cfu>0)
			{
				if (idmo==63 || (idmo>=10) && (idmo<=14) || (((idmo>=54) && (idmo<=58)) || (idmo==80)) )	//Staphylococcus aureus || Aspergillus spp || Pseudomonas spp
				{
                    vr=vr+16; 
                }	
			}
			//Stanza -> 1:Degenza 2:Sala operatoria 3:laboratorio 4:magazzini 5:corridoio 6:bagno 7:bagno degenza 8:sala attesa 9:Ambulatorio
			if (stanza==1)
			{
				if (vr&16)
					msg = "inaccettabile. Ripetere il controllo e rivedere interamente il protocollo di pulizia";
			}
			else if (stanza==2)
			{
				if ((cfu>5) && (cfu<=15))
					msg = "accettabile";
				else if (cfu>15)
					vr=vr+32;
			}
			else if (stanza==3)
			{
                //
			}
			else if (stanza==4)
			{
                //
			}
			else if (stanza==5)
			{
                //
			}
			else if (stanza==6)
			{
                //
			}
			else if (stanza==7)
			{
                //
			}
			else if (stanza==8)
			{
                //
			}
			else if (stanza==9)
			{
                //
			}
		}
		if (tc=="A")
		{
			if (stanza==2)
			{
				if (oper=='R') //At Rest
				{
					if (bn==1)	//ci sono batteri gram-
						vr=vr+1;
					if (cfu>0)
					{
						if (idmo==63 || idmo == 12 || idmo == 11)	//Staphylococcus aureus || //Aspergillus niger || //Aspergillus fumigatus
                        {
							vr=vr+16;
                        }
					}	
					if (tflusso=='L') //Laminare
					{
						if (cfu>20)
						{
							vr=vr+32;
						}
					}
					if (tflusso=='T') //Turbolento
					{
						if (cfu>35)
						{
							vr=vr+32;
						}
					}
				}
			}
		}
	}
	//alert (vr);
	return vr;
}

function Motivo(id)
{
	var mot="";
	switch (id)
	{
		case 1: mot = "Patogeno con Gram-"; break;
		case 4: mot = "Patogeno con Enterobacteriacee"; break;
		case 16: mot = "Patogeno in elenco"; break;
		case 32: mot = "Superamento soglia CFU"; break;
	}
	return mot;
}