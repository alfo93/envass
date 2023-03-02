$('#categoria').on('change',function(){
    var id = $(this).val();
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		url: "/categoria/"+id+"/getPC",
		type: "GET",
		data: {
			id: id
		},
		success: function(returnValue) {
			replace_options_pc($('#punto_campionamento'),$('#punto_campionamento').prev(),returnValue);
		},
		error: function(response) {
			showNotification('alert-danger',"impossibile trovare il codice della struttura, riprovare", 'top', 'right', null, null);
		}
	});
});

$('#pCampAria').on('change',function(){
	if($('#pCampAria option:selected').val() == "160")
	{
		$('#codDiffHide').removeClass('hidden');
	}
	else
	{
		$('#codDiffHide').addClass('hidden');
	}
})

if($('#pCampAria option:selected').val() == "160")
{
	$('#codDiffHide').removeClass('hidden');
}
else
{
	$('#codDiffHide').addClass('hidden');
}

$(window).on('load',function(){
	if($('#superficie').val() == "S")
	{
		$('#superficie').prop("checked",true);
	}
	else
	{
		
		$('#superficie').prop("checked",false);
		$("#aria").prop("checked",true);
	}

	if($('#aria').is(':checked'))
	{
		$('.superficie').addClass('hidden');
		$('.aria').removeClass('hidden');
		$('#select_tipocampione_superficie').addClass('hidden');
		$('#select_tipocampione_aria').removeClass('hidden');
		

		$('#m_aria').removeClass('hidden');
		$('#m_superficie').addClass('hidden');
		$('#select_tipocampione_superficie').addClass('hidden');
		$('#select_tipocampione_aria').removeClass('hidden');
	}

	if($('#superficie').is(':checked'))
	{
		$('.superficie').removeClass('hidden');
		$('.aria').addClass('hidden');
		$('#select_tipocampione_aria').addClass('hidden');
		$('#select_tipocampione_superficie').removeClass('hidden');
		
		$('#m_superficie').removeClass('hidden');
		$('#m_aria').addClass('hidden');
	}

	changeMetodo($('#metodo_sup').val());
	changeMetodo($('#metodo_aria').val());
	
})

$('#superficie').on('click',function(){
    $('#m_superficie').removeClass('hidden');
    $('#m_aria').addClass('hidden');
	$('#select_tipocampione_superficie').removeClass('hidden');
	$('#select_tipocampione_aria').addClass('hidden');
});

$('#aria').on('click',function(){
    $('#m_aria').removeClass('hidden');
    $('#m_superficie').addClass('hidden');
	$('#select_tipocampione_superficie').addClass('hidden');
	$('#select_tipocampione_aria').removeClass('hidden');
});

function replace_options_pc(select,dropdownSelect,array)
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
			console.log(item);
				let newOption = new Option(item.punto_campionamento, item.id);
				newOption.setAttribute('codPC',item.codPC);
				$(select).append(newOption);
				let liOption;
				if(i == 0)
				{
					liOption = '<li data-original-index="'+i+'" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.punto_campionamento+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
					$(dropdownSelect).prev('button').attr('title',item.punto_campionamento);
					$(dropdownSelect).prev('button').children('.filter-option').text(item.punto_campionamento);
				}
				else
				{
					liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.punto_campionamento+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
				}
				$(dropdownSelect).children().append(liOption);
		});
	}
}


$('#metodo_sup').on('change',function(){
	var id = $(this).val();
	changeMetodo(id);
	$("#microrganismi option[value='1']").attr("selected", "selected").trigger('change');
})

$('#metodo_aria').on('change',function(){
	var id = $(this).val();
	changeMetodo(id);
	$("#microrganismi option[value='1']").attr("selected", "selected").trigger('change');
})



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
			console.log(returnValue)
            clear_options_micro($('#microrganismi'),$('#microrganismi').prev("div"),[]);
            var newOption = new Option('-- Seleziona un microrganismo --','');
            $('#microrganismi').append(newOption);
            replace_options_micro($('#microrganismi'),$('#microrganismi').prev("div"),returnValue['microrganismo']);
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
			if(i == 0)
			{
				liOption = '<li data-original-index="'+i+'" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.microrganismo+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
				$(dropdownSelect).prev('button').attr('title',item.microrganismo);
				$(dropdownSelect).prev('button').children('.filter-option').text(item.microrganismo);
			}
			else
			{
				liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.microrganismo+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
			}
			$(dropdownSelect).children().append(liOption);
		});
	}
}


function changeMetodo(id_metodo) {
	var id = id_metodo
	if(id == '' || id == null)
	{
		return;
	}
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		url: "/metodo/"+id+"/getValues",
		type: "GET",
		data: {
			id: id
		},
		success: function(returnValue) {
			$('#condizione_incubazione').val(returnValue.condizione_incubazione).trigger('change');
			$('#t_inc').val(returnValue.tempo_incubazione).trigger('change');
			$('#id_tipo_piastra').val(returnValue.id_tipo_piastra).trigger('change');
			$('#dataFineAnalisi').val(addHours($('#dataAnalisi').val(),$('#t_inc').val()));
			$('#incertezza').attr('incertezza',returnValue.incertezza);

			//load_microrganismo(returnValue.id_tipo_piastra)
			if(returnValue.tipo_campionamento == 'S')
			{
				$('#descrizione_prova_sup').text(returnValue.descrizione_prova)
			}
			else
			{
				$('#descrizione_prova_aria').text(returnValue.descrizione_prova)
			}
		},
		error: function(response) {
			showNotification('alert-danger',"errore nel reperire le informazioni relative al metodo, riprovare", 'top', 'right', null, null);
		}
	})
}

$('#t_inc').on('change',function(){
	$('#dataFineAnalisi').val(addHours($('#dataAnalisi').val(),$('#t_inc').val()));
})

function addHours(date, hours) {
	date = new Date(date);
	let newDate = new Date(date.getTime() + hours * 60 * 60 * 1000);
	let year = newDate.getFullYear();
	let month = (newDate.getMonth() + 1).toString().padStart(2, "0");
	let day = newDate.getDate().toString().padStart(2, "0");
  	return `${year}-${month}-${day}`;
}
  