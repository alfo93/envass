$('#tipotest').on('change',function(){
    if($('#tipotest option:selected').val() != 1)
    {
        $('#campionamento_qualita').removeClass('hidden');
        $('.reperibilitaconta').addClass('hidden');

        if($('#tipotest option:selected').val() == 3)
        {
            $('#superficie').prop('disabled',true);
            $('#aria').prop('disabled',true);
        }
        else
        {
            $('#superficie').prop('disabled',false);
            $('#aria').prop('disabled',false);
        }
    }
    else
    {
        $('#campionamento_qualita').addClass('hidden');
        $('.reperibilitaconta').removeClass('hidden');
        replace_options_micro_qualita($('#microrganismi'),$('#microrganismi').prev("div"),1)
    }
})

$('#id_tipo_piastra').on('change',function(){
    if($('#tipotest option:selected').val() != 1)
    {
        if($('#id_tipo_piastra option:selected').val() == 12)
        {
            replace_options_micro_qualita($('#microrganismi'),$('#microrganismi').prev("div"),12)
        }
        else
        {
            replace_options_micro_qualita($('#microrganismi'),$('#microrganismi').prev("div"),13)
        }
    }
})

$('#superficie').on('click',function(){
    $('#p_superficie').removeClass('hidden');
    $('#p_aria').addClass('hidden');
    $('#help_aria').addClass('hidden');
});

$('#aria').on('click',function(){
    $('#p_aria').removeClass('hidden');
    $('#p_superficie').addClass('hidden');
    $('#help_aria').removeClass('hidden');
});

function replace_options_micro_qualita(select,dropdownSelect,piastra)
{
    if(piastra == 13)
    {
        $(select).empty();
        $(dropdownSelect).children().empty();
        
        let newOption = new Option('-- Seleziona un opzione --', '');
        $(select).append(newOption);
        let liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Seleziona un opzione -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
        $(dropdownSelect).prev('button').children('.filter-option').text('-- Seleziona un opzione --');
        $(dropdownSelect).children().append(liOption);
    
        let newOption2 = new Option("Conta Totale ISO 21527-2:2008", 1);
        $(select).append(newOption2);
        let liOption2;
        liOption2 = '<li data-original-index="'+1+'" class="selected"><a tabindex="'+1+'" data-tokens="null">Conta Totale ISO 21527-2:2008<span class="text"></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
        $(dropdownSelect).prev('button').attr('title',"Conta Totale ISO 21527-2:2008");
        $(dropdownSelect).prev('button').children('.filter-option').text("Conta Totale ISO 21527-2:2008");
        liOption2 = '<li data-original-index="'+1+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">Conta Totale ISO 21527-2:2008</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
        $(dropdownSelect).children().append(liOption2);
    }
    if(piastra == 12)
    {
        $(select).empty();
        $(dropdownSelect).children().empty();
        
        let newOption = new Option('-- Seleziona un opzione --', '');
        $(select).append(newOption);
        let liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Seleziona un opzione -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
        $(dropdownSelect).prev('button').children('.filter-option').text('-- Seleziona un opzione --');
        $(dropdownSelect).children().append(liOption);

        let newOption2 = new Option("Conta Totale ISO 4833-2:2013", 1);
        $(select).append(newOption2);
        let liOption2;
        liOption2 = '<li data-original-index="'+1+'" class="selected"><a tabindex="'+1+'" data-tokens="null">Conta Totale ISO 4833-2:2013<span class="text"></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
        $(dropdownSelect).prev('button').attr('title',"Conta Totale ISO 4833-2:2013");
        $(dropdownSelect).prev('button').children('.filter-option').text("Conta Totale ISO 4833-2:2013");
        liOption2 = '<li data-original-index="'+1+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">Conta Totale ISO 4833-2:2013</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
        $(dropdownSelect).children().append(liOption2);
    }
    if(piastra == 1)
    {
        $(select).empty();
        $(dropdownSelect).children().empty();
        
        let newOption = new Option('-- Seleziona un opzione --', '');
        $(select).append(newOption);
        let liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Seleziona un opzione -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
        $(dropdownSelect).prev('button').children('.filter-option').text('-- Seleziona un opzione --');
        $(dropdownSelect).children().append(liOption);

        let newOption2 = new Option("Conta Totale", 1);
        $(select).append(newOption2);
        let liOption2;
        liOption2 = '<li data-original-index="'+1+'" class="selected"><a tabindex="'+1+'" data-tokens="null">Conta Totale<span class="text"></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
        $(dropdownSelect).prev('button').attr('title',"Conta Totale");
        $(dropdownSelect).prev('button').children('.filter-option').text("Conta Totale");
        liOption2 = '<li data-original-index="'+1+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">Conta Totale</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
        $(dropdownSelect).children().append(liOption2);
    }
	
	
	
}
