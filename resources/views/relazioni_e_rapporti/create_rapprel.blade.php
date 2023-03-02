@extends('layouts.main')

@section('style')
<style>

    
    @media (min-width: 1200px){
        .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12 {
            float: left;
        }
    }
   
    @media (min-width: 992px){
        .col-md-12 {
            width: 100%;
        }
    }
    @media (min-width: 992px){
        .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
            float: left;
        }
    }
    @media (min-width: 768px){
        .col-sm-12 {
            width: 100%;
        }
    }
    

    @media (min-width: 768px){
        .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
            float: left;
        }
    }

    input[type=text] {
        /* background-color: rgb(213, 208, 208); */
        padding: 10px;
        padding-left: 1em;
    }

    ul.typeahead.dropdown-menu {
        top: 65px !important;
    }

    input[type="file"] {
        display: none;
    }

    #carica_planimetria {
        display: block !important;
    }

    #carica_planimetria_committente {
        display: block !important;
    }
    
    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        width: 195px;
        height: 40px;
        background-color: #607D8B;
        cursor: pointer;

    }

    #text_firma_rapporto {
        margin-left: 34px;
        position: relative;
        top: 3px;
        bottom: 0.5rem;
        color: #fff;
        font-size: 12px;
        cursor: pointer;
    }

    #text_firma_relazione {
        margin-left: 34px;
        position: relative;
        top: 3px;
        bottom: 0.5rem;
        color: #fff;
        font-size: 12px;
        cursor: pointer;
    }

    ul.dashed {
        list-style-type: none;
    }
    ul.dashed > li {
        text-indent: -5px;
    }
    ul.dashed > li:before {
        content: "-";
        text-indent: -5px;
    }

</style>
@endsection  


@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>Upload nuovo documento 
            <small>carica una nuova relazione o un nuovo rapporto di prova</small>
        </h2>
    </div>
    
    @if ($errors->any())
        <div id="errors-container" class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ ucfirst($error) }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Rapporto di prova --}}  
    @include('relazioni_e_rapporti.create_rapporto')

    {{-- Relazione --}}  
    @include('relazioni_e_rapporti.create_relazione')

    <div class="block-header">
        <h2>Genera un nuovo rapporto di prova
        </h2>
    </div>

    {{-- GENERAZIONE Rapporto di prova --}}
    @include('relazioni_e_rapporti.genera_rapporto')

    <div class="block-header">
        <h2>Genera un nuovo rapporto di prova con campionamenti fatti da committente
        </h2>
    </div>

    {{-- GENERAZIONE Rapporto di prova con campionamenti fatti da committente --}}
    @include('relazioni_e_rapporti.genera_rapporto_committente')
   


@endsection

@section('script')
<script type="text/javascript">

    $('#carica_firma_rapporto').on('change',function(){
        check_submit_rapporto();
    });

    $('#carica_firma_relazione').on('change',function(){
        check_submit_relazione();
    });
    
    function check_submit_rapporto()
    {
        if($('input[type="file"]').val()) {
            $('#checkfile_rapporto').removeClass('hidden');
            $('#checkfile_rapporto').text($('input[type="file"]')[0].files[0].name);
        }
    }

    function check_submit_relazione()
    {
        if($('#carica_firma_relazione').val()) {
            $('#checkfile_relazione').removeClass('hidden');
            $('#checkfile_relazione').text($('#carica_firma_relazione')[0].files[0].name);
        }
    }

    $('#progetti_relazioni').on('change',function(){
        var id_progetto = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/rapprel/"+id_progetto+"/getStruttureProgetto",
            type: "GET",
            dataType: "json",
            data: {
                id_progetto: id_progetto,
            },
            success: function(returnValue) {
                replace_options_strutture($('#struttura_relazioni'),$('#struttura_relazioni').prev("div"),returnValue['tot_strutture']);
            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });

    $('#struttura_relazioni').on('change',function(){
        var id_progetto = $('#progetti_relazioni option:selected').val();
        var struttura = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/rapprel/"+id_progetto+"/"+struttura+"/getStruttureReparti",
            type: "GET",
            dataType: "json",
            data: {
                id_progetto: id_progetto,
                struttura: struttura
            },
            success: function(returnValue) {
                replace_options_reparti($('#reparto_relazioni'),$('#reparto_relazioni').prev("div"),returnValue['tot_reparti']);
            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });

    $('#reparto_relazioni').on('change',function(){
        var reparto = $('#reparto_relazioni').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/campagna/"+reparto+"/areapartizione",
            type: "GET",
            dataType: "json",
            data: {
                id_partizione: reparto
            },
            success: function(returnValue) {   
                // console.log(returnValue);
                replace_options_areapartizione($('#areapartizione_relazioni'),$('#areapartizione_relazioni').prev('div'),returnValue['tot_areapartizione'])            
            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        })          
    });

    $('#progetti_rapporti').on('change',function(){
        var id_progetto = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/rapprel/"+id_progetto+"/getStruttureProgetto",
            type: "GET",
            dataType: "json",
            data: {
                id_progetto: id_progetto,
            },
            success: function(returnValue) {
                replace_options_strutture($('#struttura_rapporti'),$('#struttura_rapporti').prev("div"),returnValue['tot_strutture']);
            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });

    $('#struttura_rapporti').on('change',function(){
        var id_progetto = $('#progetti_rapporti option:selected').val();
        var struttura = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/rapprel/"+id_progetto+"/"+struttura+"/getStruttureReparti",
            type: "GET",
            dataType: "json",
            data: {
                id_progetto: id_progetto,
                struttura: struttura
            },
            success: function(returnValue) {
                replace_options_reparti($('#reparto_rapporti'),$('#reparto_rapporti').prev("div"),returnValue['tot_reparti']);
            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });

    $('#reparto_rapporti').on('change',function(){
        var reparto = $('#reparto_rapporti').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/campagna/"+reparto+"/areapartizione",
            type: "GET",
            dataType: "json",
            data: {
                id_partizione: reparto
            },
            success: function(returnValue) {   
                // console.log(returnValue);
                replace_options_areapartizione($('#areapartizione_rapporti'),$('#areapartizione_rapporti').prev('div'),returnValue['tot_areapartizione'])            
            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        })          
    });

    function replace_options_areapartizione(select,dropdownSelect,array)
    {
        $(select).empty();
        $(dropdownSelect).children().empty();
        if(array.length == 0)
        {
            let newOption = new Option('-- Non sono presenti aree per le partizioni selezionate --', 'tutti');
            $(select).append(newOption);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti aree per le partizioni selezionate -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti aree per le partizioni selezionate --');
            $(dropdownSelect).children().append(liOption);
        }
        else
        {
            let tutti = new Option('-- Seleziona un\'opzione --','tutti');
            $(select).append(tutti);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Seleziona un\'opzione -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Seleziona un\'opzione --');
            $(dropdownSelect).children().append(liOption);

            $.each(array, function (i, item) {
                i = i+1;
                let newOption = new Option(item.areapartizione, item.id); //item.areapartizione corrisponde all'area riferita alla partizione scelta, l'id si riferisce alla coppia (partizione - area)
                $(select).append(newOption);
                let liOption;
                liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.areapartizione+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
                $(dropdownSelect).children().append(liOption);
            });
        }
    }

    function replace_options_strutture(select,dropdownSelect,array)
    {
        $(select).empty();
        $(dropdownSelect).children().empty();
        if(array.length == 0)
        {
            let newOption = new Option('-- Non sono presenti strutture --', 'tutti');
            $(select).append(newOption);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti strutture -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti strutture --');
            $(dropdownSelect).children().append(liOption);
        }
        else
        {
            let tutti = new Option('-- Seleziona un\'opzione --','tutti');
            $(select).append(tutti);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Seleziona un\'opzione -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Seleziona un\'opzione --');
            $(dropdownSelect).children().append(liOption);

            $.each(array, function (i, item) {
                i = i+1;
				let newOption = new Option(item.struttura, item.id);
				$(select).append(newOption);
				let liOption;
				liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.struttura+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
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
            let newOption = new Option('-- Non sono presenti reparti --', 'tutti');
            $(select).append(newOption);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti reparti -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti reparti --');
            $(dropdownSelect).children().append(liOption);
        }
        else
        {
            let tutti = new Option('-- Seleziona un\'opzione --','tutti');
            $(select).append(tutti);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Seleziona un\'opzione -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Seleziona un\'opzione --');
            $(dropdownSelect).children().append(liOption);

            $.each(array, function (i, item) {
                i = i+1;
                let newOption = new Option(item.reparto, item.id);
                $(select).append(newOption);
                let liOption;
                liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.reparto+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
                $(dropdownSelect).children().append(liOption);
            });
        }
    }

    function replace_options_progetti(select,dropdownSelect,array)
    {
        $(select).empty();
        $(dropdownSelect).children().empty();
        if(array.length == 0)
        {
            let newOption = new Option('-- Non sono presenti attività --', 'tutti');
            $(select).append(newOption);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti attività -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti attività --');
            $(dropdownSelect).children().append(liOption);
        }
        else
        {
            let tutti = new Option('-- Seleziona un\'opzione --','tutti');
            $(select).append(tutti);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Seleziona un\'opzione -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Seleziona un\'opzione --');
            $(dropdownSelect).children().append(liOption);

            $.each(array, function (i, item) {
                i = i+1;
                let newOption = new Option(item.progetto, item.id);
                $(select).append(newOption);
                let liOption;
                liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.progetto+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
                $(dropdownSelect).children().append(liOption);
            });
        }
    }
    
        
</script>
@endsection



</div>