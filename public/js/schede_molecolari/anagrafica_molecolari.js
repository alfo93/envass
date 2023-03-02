var $tipoDocumento = "";
var length_codice_struttura = 0;

$(document).ready(function(){
	$('#nome_struttura').selectpicker();
	$('.body-collapsable').addClass('open');
	$('.body-collapsable').css('display','block');
	$('#superficie').prop('checked',true);

	var s = $('#superficie').is(':checked');
	var a = $('#aria').is(':checked');
	var o = $('#operational').is(':checked');

	if(s == true)
	{
		$('.aria').addClass('hidden');
	}

	if(a == true)
	{
		$('.superficie').addClass('hidden');
	}

	if(o == true)
	{
		$('.operational').removeClass('hidden');
	}
});


$('#superficie').on('change',function(){
	var s = $('#superficie').is(':checked');
	var a = $('#aria').is(':checked');
	if(s == true)
	{
		$('.aria').addClass('hidden');
		$('.superficie').removeClass('hidden');
	}
	
});

$('#aria').on('change',function(){
	var s = $('#superficie').is(':checked');
	var a = $('#aria').is(':checked');
	if(a == true)
	{
		$('.aria').removeClass('hidden');
		$('.superficie').addClass('hidden');
	}
});
 
$('#operational').on('change',function(){
	var o = $('#operational').is(':checked');
	if(o == true)
	{
		$('.operational').removeClass('hidden');
	}
	else
	{
		$('.operational').addClass('hidden');
	}
});

$('#at_rest').on('change',function(){
	var o = $('#operational').is(':checked');
	if(o == true)
	{
		$('.operational').removeClass('hidden');
	}
	else
	{
		$('.operational').addClass('hidden');
	}
});

// window.onbeforeunload = function(e)
// {
// 	e.returnValue =  "Sei sicuro? Procedendo potresti perdere tutte le modifiche fatte";
// }

/*$('#progetto').on('change',function(){
	var progetto = $('#progetto option:selected').attr('nome_progetto');
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/progetti/"+progetto+"/getData",
        type: "GET",
        dataType: "json",
        data: {
            progetto: progetto
        },
        success: function(returnValue) {
			$('#nome_societa').val(returnValue['nome_societa']);
			$('#nome_societa').attr('id_societa',returnValue['id_societa']);
			$('#indirizzo_societa').val(returnValue['indirizzo_societa']);
			replace_options_strutture($('#nome_struttura'),$('#nome_struttura').prev("div"),returnValue['struttureProgetto']);
			replace_options_reparti($('#reparto'),$('#reparto').prev("div"),returnValue['repartiProgetto']);
			var id_struttura = $('#nome_struttura option:selected').val();
			var id_reparto = $('#reparto option:selected').val();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "/struttrep/getCodice",
				type: "GET",
				data: {
					progetto: progetto,
					id_struttura: id_struttura,
					id_reparto: id_reparto
				},
				success: function(valore) {
					
				},
				error: function(response) {
					showNotification('alert-danger',"impossibile trovare il codice della struttura, riprovare", 'top', 'right', null, null);
				}
			});

        }, 
        error: function(response, stato) {
            showNotification('alert-danger',"Si è verificato un problema con l'inserimento del nuovo progetto, riprovare", 'top', 'right', null, null);
        }
    });  
});

$('#nome_struttura').on('change',function() {
	var progetto = $('#progetto option:selected').attr('nome_progetto');
	var id_struttura = $(this).val();
	var id_reparto = $('#reparto option:selected').val();
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		url: "/strutture/getDataOfStrutture",
		type: "GET",
		data: {
			progetto: progetto,
			id_struttura: id_struttura,
			id_reparto: id_reparto
		},
		success: function(reparti) {
			replace_options_reparti($('#reparto'),$('#reparto').prev("div"),reparti);
		},
		error: function(response) {
			showNotification('alert-danger',"impossibile trovare il codice della struttura, riprovare", 'top', 'right', null, null);
		}
	});
});


$('#reparto').on('change',function() {
	var progetto = $('#progetto option:selected').val();
	var id_struttura = $('#nome_struttura option:selected').val();
	var id_reparto = $(this).val();
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		url: "/struttrep/getCodice",
		type: "GET",
		data: {
			progetto: progetto,
			id_struttura: id_struttura,
			id_reparto: id_reparto
		},
		success: function(valore) {
			
		},
		error: function(response) {
			showNotification('alert-danger',"impossibile trovare il codice della struttura, riprovare", 'top', 'right', null, null);
		}
	});
});


function get_reparto()
{
	var progetto = $('#progetto option:selected').val();
	var id_struttura = $('#nome_struttura option:selected').val();
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		url: "/struttrep/reparti/getReparto",
		type: "GET",
		data: {
			progetto: progetto,
			id_struttura: id_struttura,
		},
		success: function(returnValue) {
			replace_options_reparti($('#reparto'),$('#reparto').prev("div"),returnValue);
		},
		error: function(response) {
			showNotification('alert-danger',"impossibile trovare il reparto, riprovare", 'top', 'right', null, null);
		}
	});
}*/
function replace_options_strutture(select,dropdownSelect,array)
{
	$(select).empty();
	$(dropdownSelect).children().empty();
	if(array.length == 0)
	{
		let newOption = new Option('-- Non sono presenti strutture --', 'nessuna');
		$(select).append(newOption);
		liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti strutture -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
		$(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti strutture --');
		$(dropdownSelect).children().append(liOption);
	}
	else
	{
		$.each(array, function (i, item) {
				let newOption = new Option(item.struttura, item.id);
				$(select).append(newOption);
				let liOption;
				if(i == 0)
				{
					liOption = '<li data-original-index="'+i+'" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.struttura+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
					$(dropdownSelect).prev('button').attr('title',item.struttura);
					$(dropdownSelect).prev('button').children('.filter-option').text(item.struttura);
				}
				else
				{
					liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.struttura+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
				}
				$(dropdownSelect).children().append(liOption);
		});
	}
}

function replace_options_reparti(select,dropdownSelect,array)
{
	$(select).empty();
	$(dropdownSelect).children().empty();
	if(array.length == 0)
	{
		let newOption = new Option('-- Non sono presenti reparti --', 'nessuna');
		$(select).append(newOption);
		liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti reparti -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
		$(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti reparti --');
		$(dropdownSelect).children().append(liOption);
	}
	else
	{
		$.each(array, function (i, item) {
				let newOption = new Option(item.reparto, item.id);
				$(select).append(newOption);
				let liOption;
				if(i == 0)
				{
					liOption = '<li data-original-index="'+i+'" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.reparto+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
					$(dropdownSelect).prev('button').attr('title',item.reparto);
					$(dropdownSelect).prev('button').children('.filter-option').text(item.reparto);
				}
				else
				{
					liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.reparto+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
				}
				$(dropdownSelect).children().append(liOption);
		});
	}
}

$('#rilevatore_campionamento').on('change',function(){
	var descrizione = $('#rilevatore_campionamento option:selected').attr('descrizione');
	$('.rilevatore_descrizione').text(descrizione);
})

if($('#rilevatore_campionamento option:selected').val())
{
	var descrizione = $('#rilevatore_campionamento option:selected').attr('descrizione');
	$('.rilevatore_descrizione').text(descrizione);
}

if($('#rilevatore_campionamento option:selected').val() == "tutti")
{
	$('.rilevatore_descrizione').text('Rilevatore del campionamento');
}


$(window).on('load',function(){
	if($('.id_campione').attr('id_campione') == "")
	{
		var id_reparto = $('#reparto option:selected').val();

		length_codice_struttura = $('#codice_struttura').val().length;
	   
		if(id_reparto != '')
		{
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "/reparto/getReparto",
				type: "GET",
				dataType: "json",
				data: {
					id: id_reparto,
				},
				success: function(returnValue) {
					if(returnValue['reparto'] != null)
					{
						codice = $('#codice_struttura').val();
						codice = codice + "_" + returnValue['reparto'].codice_partizione;
						$('#codice_struttura').val(codice);
					}
				},
				error: function(status)
				{
					console.log(status);
				},
			});
		}
	}
    
})




$('#reparto').on('change',function(){
	$('#area_reparto').val('');
	var id_reparto = $(this).val();
	length_codice_struttura_modified = $('#codice_struttura').val().length;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/reparto/getReparto",
        type: "GET",
        dataType: "json",
        data: {
            id: id_reparto,
        },
        success: function(returnValue) {
			if(returnValue['reparto'] != null)
			{
				codice = $('#codice_struttura').val();
				codice = codice + "_" + returnValue['reparto'].codice_partizione;
				$('#codice_struttura').val(codice);
				length_codice_struttura_modified = $('#codice_struttura').val().length;
			}
			else
			{
				if(codice.length > length_codice_struttura)
				{
					codice = $('#codice_struttura').val();
					codice = codice.substring(0, codice.lastIndexOf("_"));
					$('#codice_struttura').val(codice);	
				}
			}
        },
        error: function(status)
        {
            console.log(status);
        },
    });
})