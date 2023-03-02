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
	if($('#pCampAria option:selected').val() == "1")
	{
		$('#codDiffHide').removeClass('hidden');
	}
	else
	{
		$('#codDiffHide').addClass('hidden');
	}
})

if($('#pCampAria option:selected').val() == "1")
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
	}

	if($('#superficie').is(':checked'))
	{
		$('.superficie').removeClass('hidden');
		$('.aria').addClass('hidden');
	}
})


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
				let newOption = new Option(item.punto_campionamento, item.id);
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
