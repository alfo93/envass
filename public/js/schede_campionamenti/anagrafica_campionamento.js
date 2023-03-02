var $tipoDocumento = "";
var length_codice_struttura = 0;

function CalcOre()
{
	diff = CalcDiff($('#dataInizio').val(), $('#oraInizio').val(), 
		  $('#dataFine').val(),$('#oraFine').val());
	if (diff<0)
		$('#durata_campionamento').html("<font color='red'>errore</font>");
	else
		{
			ore = parseInt(diff / 60);
			min = Math.round((diff / 60 - ore)*60);
			if ($('#oraInizio').val() != "" && $('#oraFine').val() != "")
				$('#durata_campionamento').val( ore + ":" + (min<10?"0":"")+min);
			else
				$('#durata_campionamento').val("");
		}
		
	diff = CalcDiff($('#dataFine').val(), $('#oraFine').val(), 
		$('#dataArrivo').val(), $('#oraArrivo').val());
	if (diff<0)
		$('#durata_trasporto').html("<font color='red'>errore</font>");
	else
	{
		ore = parseInt(diff / 60);
		min = Math.round((diff / 60 - ore)*60);
		if ($('#oraFine').val() != "" && $('#oraArrivo').val() != "")
			$('#durata_trasporto').val( ore + ":" + (min<10?"0":"")+min);
		else
			$('#durata_trasporto').val("");
	}
};

function CalcDiff(dataI,oraI,dataF,oraF)
{
	// annoI = parseInt(dataI.substr(6),10);
	// meseI = parseInt(dataI.substr(3, 2),10);
	// giornoI = parseInt(dataI.substr(0, 2),10);
	// oreI = parseInt(oraI.substr(0, 2),10);
	// minutiI = parseInt(oraI.substr(3, 2),10);
	
	// annoF = parseInt(dataF.substr(6),10);
	// meseF = parseInt(dataF.substr(3, 2),10);
	// giornoF = parseInt(dataF.substr(0, 2),10);
	// oreF = parseInt(oraF.substr(0, 2),10);
	// minutiF = parseInt(oraF.substr(3, 2),10);
	
	// var dateI = new Date (annoI, meseI, giornoI, oreI, minutiI, 0);
	// var dateF = new Date (annoF, meseF, giornoF, oreF, minutiF, 0);
	
	// return (dateF.valueOf() - dateI.valueOf()) / 60000;

	// Convert the strings to Date objects
	const dateTime1 = new Date(`${dataI} ${oraI}`);
	const dateTime2 = new Date(`${dataF} ${oraF}`);
	
	// Calculate the difference in milliseconds
	const diffInMs = Math.abs(dateTime1 - dateTime2);
	
	// Convert milliseconds to hours
	const diffInHours = diffInMs / 1000 / 60;
	
	return diffInHours;
};

$(document).ready(function(){
	var ruolo = $('.role').attr('id');
	if(ruolo.localeCompare('admin') && ruolo.localeCompare('gestore'))
	{
		$('input').prop('disabled',true);
		$('button').prop('disabled',true);
	}
	$('.carica_immagine_piastra').hide();
	$('#nome_struttura').selectpicker();
	$('.body-collapsable').addClass('open');
	$('.body-collapsable').css('display','block');
	$('.qrcode_card').removeClass('open');
	$('.qrcode_card').css('display','none');
	$('#superficie').prop('checked',true);
	setInterval(function(){   
		CalcOre();
	}, 500);
	
	var l1 = $('#lineeGuida1').is(':checked'); 
	var l2 = $('#lineeGuida2').is(':checked');
	var l3 = $('#lineeGuida3').is(':checked');
	var l4 = $('#lineeGuida4').is(':checked');
	var s = $('#superficie').is(':checked');
	var a = $('#aria').is(':checked');
	var o = $('#operational').is(':checked');
	var siGram = $('#siGramRil').is(':checked');

	if(l1 == true || l2 == true || l3 == true || l4 == true)
	{
		$('.iso_gmp').removeClass('hidden');
	}

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

	if(siGram == true)
	{
		$('.colonie').removeClass('hidden');	
	}

	if($('#dataCampagna').val() != $('#dataCampionamento').val())
	{
		$('#dataPartenza').val($('#dataCampionamento').val());
		$('#dataArrivo').val($('#dataCampionamento').val());
		$('#dataInizio').val($('#dataCampionamento').val());
		$('#dataFine').val($('#dataCampionamento').val());
	}

	$('#data_accettazione').val($('#dataCampagna').val());
});

$('#dataCampionamento').on('change',function(){
	$('#dataPartenza').val($('#dataCampionamento').val());
	$('#dataArrivo').val($('#dataCampionamento').val());
	$('#dataInizio').val($('#dataCampionamento').val());
	$('#dataFine').val($('#dataCampionamento').val());
	$('#dataAnalisi').val($('#dataCampionamento').val());
	$('#dataFineAnalisi').val($('#dataCampionamento').val());
})

$('#dataFine').on('change',function(){
	$('#dataArrivo').val($('#dataFine').val());
	$('#dataAnalisi').val($('#dataFine').val());
})

$('#dataPartenza').on('change',function(){
	$('#dataInizio').val($('#dataPartenza').val());
	$('#dataArrivo').val($('#dataPartenza').val());
	$('#dataFine').val($('#dataPartenza').val());
	$('#dataAnalisi').val($('#dataPartenza').val());
	$('#dataFineAnalisi').val($('#dataPartenza').val());
})

$('#dataInizio').on('change',function(){
	$('#dataArrivo').val($('#dataInizio').val());
	$('#dataFine').val($('#dataInizio').val());
	$('#dataAnalisi').val($('#dataInizio').val());
	$('#dataFineAnalisi').val($('#dataInizio').val());
})

$('#lineeGuida1').on('change',function() {
	var l1 = $('#lineeGuida1').is(':checked'); 
	var l2 = $('#lineeGuida2').is(':checked');
	var l3 = $('#lineeGuida3').is(':checked');
	var l4 = $('#lineeGuida4').is(':checked');

	if(l1 == true || l2 == true || l3 == true || l4 == true)
	{
		$('.iso_gmp').removeClass('hidden');
	}
	else
	{
		$('.iso_gmp').addClass('hidden');
	}
});

$('#lineeGuida2').on('change',function() {
	var l1 = $('#lineeGuida1').is(':checked'); 
	var l2 = $('#lineeGuida2').is(':checked');
	var l3 = $('#lineeGuida3').is(':checked');
	var l4 = $('#lineeGuida4').is(':checked');

	if(l1 == true || l2 == true || l3 == true || l4 == true)
	{
		$('.iso_gmp').removeClass('hidden');
	}
	else
	{
		$('.iso_gmp').addClass('hidden');
	}
});

$('#lineeGuida3').on('change',function() {
	var l1 = $('#lineeGuida1').is(':checked'); 
	var l2 = $('#lineeGuida2').is(':checked');
	var l3 = $('#lineeGuida3').is(':checked');
	var l4 = $('#lineeGuida4').is(':checked');

	if(l1 == true || l2 == true || l3 == true || l4 == true)
	{
		$('.iso_gmp').removeClass('hidden');
	}
	else
	{
		$('.iso_gmp').addClass('hidden');
	}
});

$('#lineeGuida4').on('change',function() {
	var l1 = $('#lineeGuida1').is(':checked'); 
	var l2 = $('#lineeGuida2').is(':checked');
	var l3 = $('#lineeGuida3').is(':checked');
	var l4 = $('#lineeGuida4').is(':checked');

	if(l1 == true || l2 == true || l3 == true || l4 == true)
	{
		$('.iso_gmp').removeClass('hidden');
	}
	else
	{
		$('.iso_gmp').addClass('hidden');
	}
});

$('#superficie').on('change',function(){
	var s = $('#superficie').is(':checked');
	if(s == true)
	{
		$('.aria').addClass('hidden');
		$('.superficie').removeClass('hidden');
	}
	
});

$('#aria').on('change',function(){
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

$('#siGramRil').on('change',function(){
	var si = $('#siGramRil').is(':checked');
	if(si == true)
	{
		$('.colonie').removeClass('hidden');
	}
	else
	{
		$('.colonie').addClass('hidden');
	}
});

$('#noGramRil').on('change',function(){
	var si = $('#siGramRil').is(':checked');
	if(si == true)
	{
		$('.colonie').removeClass('hidden');
	}
	else
	{
		$('.colonie').addClass('hidden');
	}

	
});

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

$('#tecnico').on('change',function(){
	var descrizione = $('#tecnico option:selected').attr('descrizione');
	$('.rilevatore_descrizione_tecnico').text(descrizione);
})

if($('#tecnico option:selected').val())
{
	var descrizione = $('#tecnico option:selected').attr('descrizione');
	$('.rilevatore_descrizione_tecnico').text(descrizione);
}

if($('#tecnico option:selected').val() == "tutti")
{
	$('.rilevatore_descrizione_tecnico').text('Rilevatore del campionamento');
}

function replace_options_procedure(select,dropdownSelect,array)
{
	$(select).empty();
	$(dropdownSelect).children().empty();
	if(array.length == 0)
	{
		let newOption = new Option('-- Non sono presenti elementi --', 'nessuna');
		$(select).append(newOption);
		liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti elementi -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
		$(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti elementi --');
		$(dropdownSelect).children().append(liOption);
	}
	else
	{
		$.each(array, function (i, item) {
				let newOption = new Option(item.note, item.id);
				$(select).append(newOption);
				let liOption;
				if(i == 0)
				{
					liOption = '<li data-original-index="'+i+'" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.note+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
					$(dropdownSelect).prev('button').attr('title',item.note);
					$(dropdownSelect).prev('button').children('.filter-option').text(item.note);
				}
				else
				{
					liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.note+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
				}
				$(dropdownSelect).children().append(liOption);
		});
	}
}

$('#area_reparto').typeahead({
	source: function(query, result) {
		$.ajax({
			url: "/reparto/areapartizione",
			type: "GET",
			dataType: "json",
			data: 'query=' + query,
			success: function(data) {
				result($.map(data, function(item) {
					console.log(data)
					if(item.id_reparto == $('#reparto option:selected').val())
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

/**MODIFICA IN TEMPO REALE DEL CODICE CIAS DURANTE COMPILAZIONE SCHEDA */
// $(window).on('load',function(){
// 	if($('.id_campione').attr('id_campione') == "")
// 	{
// 		var id_reparto = $('#reparto option:selected').val();

// 		length_codice_struttura = $('#codice_struttura').val().length;
	   
// 		if(id_reparto != '')
// 		{
// 			$.ajaxSetup({
// 				headers: {
// 					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
// 				}
// 			});
// 			$.ajax({
// 				url: "/reparto/getReparto",
// 				type: "GET",
// 				dataType: "json",
// 				data: {
// 					id: id_reparto,
// 				},
// 				success: function(returnValue) {
// 					if(returnValue['reparto'] != null)
// 					{
						
// 						codice = $('#codice_struttura').val();
// 						codice = codice +"_"+ returnValue['reparto'].codice_partizione;
// 						$('#codice_struttura').val(codice);
// 						$('#codiceCIAS').val(codice);
// 					}
// 				},
// 				error: function(status)
// 				{
// 					console.log(status);
// 				},
// 			});
// 		}
// 	}
    
// })



// $('#reparto').on('change',function(){
// 	$('#area_reparto').val('');
// 	var id_reparto = $(this).val();
// 	var codeCias = $('#codice_struttura').val();
// 	var token_code = codeCias.split("_");
// 	$.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//     $.ajax({
//         url: "/reparto/getReparto",
//         type: "GET",
//         dataType: "json",
//         data: {
//             id: id_reparto,
//         },
//         success: function(returnValue) {
// 			if(returnValue['reparto'] != null)
// 			{
// 				token_code[3] = returnValue['reparto'].codice_partizione;
// 			}
// 			$('#codice_struttura').val(token_code.join("_"));
// 			$('#codiceCIAS').val(token_code.join("_"));
//         },
//         error: function(status)
//         {
//             console.log(status);
//         },
//     });
// });

// $('#area_reparto').on('change',function(){
// 	var code_area_reparto = $('#area_reparto').val(); // campo dove inserire l'area del reparto (opzionale)
// 	var codeCias = $('#codice_struttura').val(); //codice completo o in fase di completamento
// 	var token_code = codeCias.split("_"); //tokenizzo il codice nelle sue parti
// 	if(code_area_reparto == "" && token_code.hasOwnProperty(3)) //sto cancellando l'area reparto opzionale
// 	{
// 		var code_reparto = token_code[3]; //prendo quella riferita al reparto+area_reparto
// 		var token_code_area_reparto = code_reparto.split("-"); //effettuo lo split
// 		code_reparto = token_code_area_reparto[0];//prendo solo la parte riferita al reparto e sovrascrivo quindi il codice riferito a quella parte
// 		token_code[3] = code_reparto;//sovrascrivo nel token del codice completo la parte del reparto
// 		$('#codice_struttura').val(token_code.join("_")); //aggiorno il codice.
// 		$('#codiceCIAS').val(token_code.join("_")); //aggiorno il codice.
// 	}
// 	else
// 	{
// 		var code_reparto = token_code[3];//prendo quella riferita al reparto+area_reparto
// 		var token_code_area_reparto = code_reparto.split("_"); //effettuo lo split
// 		if(token_code_area_reparto.hasOwnProperty(1))//se esiste la property 1 (reparto)
// 		{
// 			token_code_area_reparto[1] = code_area_reparto; //allora aggiorno il valore riferito all'indice 1
			
// 		}
// 		else
// 		{
// 			token_code_area_reparto.push(code_area_reparto); //altrimenti inserisco ex novo questo valore. (significa che sto generando il codice)
// 		}
// 		token_code[3] = token_code_area_reparto.join("-"); //aggiorno il valore al terzo posto del token che riferisce al reparto
// 		$('#codice_struttura').val(token_code.join("_")); //ricostruisco la stringa
// 		$('#codiceCIAS').val(token_code.join("_"));
// 	}
// })

// $('#numStanza').on('change',function(){
// 	var numStanza = $('#numStanza').val();
// 	var codeCias = $('#codice_struttura').val();
// 	var token_code = codeCias.split("_");
// 	if(numStanza == "" && token_code.hasOwnProperty(4))
// 	{
// 		token_code[4] = "";
// 		$('#codice_struttura').val(token_code.join("_"));
// 		$('#codiceCIAS').val(token_code.join("_"));
// 	}

// 	if(token_code.hasOwnProperty(4))
// 	{
// 		token_code[4] = numStanza;
// 		$('#codice_struttura').val(token_code.join("_"));
// 		$('#codiceCIAS').val(token_code.join("_"));
// 	}
// 	else
// 	{
// 		token_code.push(numStanza);
// 		$('#codice_struttura').val(token_code.join("_"));
// 		$('#codiceCIAS').val(token_code.join("_"));
// 	}
// })

// $('#id_tipo_piastra').on('change',function()
// {
// 	var id_tipo_piastra = $('#id_tipo_piastra option:selected').val();
// 	var codice = $('#id_tipo_piastra option:selected').attr('codice');
// 	var codeCias = $('#codice_struttura').val();
// 	var token_code = codeCias.split("_");
// 	if(id_tipo_piastra == "" && token_code.hasOwnProperty(5))
// 	{
// 		token_code[5] = "";
// 		$('#codice_struttura').val(token_code.join("_"));
// 		$('#codiceCIAS').val(token_code.join("_"));
// 	}

// 	if(token_code.hasOwnProperty(5))
// 	{
// 		token_code[5] = codice;
// 		$('#codice_struttura').val(token_code.join("_"));
// 		$('#codiceCIAS').val(token_code.join("_"));
// 	}
// 	else
// 	{
// 		token_code.push(codice);
// 		$('#codice_struttura').val(token_code.join("_"));
// 		$('#codiceCIAS').val(token_code.join("_"));
// 	}
// })

// $('#punto_campionamento').on('change',function(){
// 	var punto_campionamento = $('#punto_campionamento option:selected').val();
// 	var codice = $('#punto_campionamento option:selected').attr('codPC');
// 	var codeCias = $('#codice_struttura').val();
// 	var token_code = codeCias.split("_");
// 	if(punto_campionamento == "" && token_code.hasOwnProperty(6))
// 	{
// 		token_code[6] = "";
// 		$('#codice_struttura').val(token_code.join("_"));
// 		$('#codiceCIAS').val(token_code.join("_"));
// 	}

// 	if(token_code.hasOwnProperty(6))
// 	{
// 		token_code[6] = codice;
// 		$('#codice_struttura').val(token_code.join("_"));
// 		$('#codiceCIAS').val(token_code.join("_"));
// 	}
// 	else
// 	{
// 		token_code.push(codice);
// 		$('#codice_struttura').val(token_code.join("_"));
// 		$('#codiceCIAS').val(token_code.join("_"));
// 	}
// })