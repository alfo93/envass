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
        background-color: rgb(213, 208, 208);
        padding: 10px;
        padding-left: 1em;
    }

    input[type=date] {
        background-color: rgb(213, 208, 208);
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
@if($view_documento == 1)
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-collapsable">
            <div class="header">
                <h2 class="collapsable-handler">&#9662; &#32; Anteprima rapporto di prova</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="collapsable-handler">
                            <i class="material-icons">more_vert</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body">
                
            </div>
            <div class="body body-collapsable demo-masked-input open" style="display: block">
                <form action="{{ URL::action('RapportoRelazioneController@generaPDF') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                        <li role="presentation" class="active"><a href="#pagina1" data-toggle="tab" aria-expanded="true">Dati generali</a></li>
                        <li role="presentation" class=""><a href="#pagina2" data-toggle="tab" aria-expanded="false">Piano di campionamento</a></li>
                        <li role="presentation" class=""><a href="#pagina3-4" data-toggle="tab" aria-expanded="false">Note di campionamento</a></li>
                        <li role="presentation" class=""><a href="#pagina5" data-toggle="tab" aria-expanded="false">Planimetria</a></li>
                        <li role="presentation" class=""><a href="#pagina6" data-toggle="tab" aria-expanded="false">Anagrafica campionamento</a></li>
                        <li role="presentation" class=""><a href="#pagina7" data-toggle="tab" aria-expanded="false">Descrizione campionemento aria</a></li>
                        <li role="presentation" class=""><a href="#pagina8-9" data-toggle="tab" aria-expanded="false">Descrizione campionamento superfici</a></li>
                        <li role="presentation" class=""><a href="#pagina10" data-toggle="tab" aria-expanded="false">Identificazione specie patogene</a></li>
                        <li role="presentation" class=""><a href="#pagina11" data-toggle="tab" aria-expanded="false">Dichiarazione di conformità e obiettivi</a></li>
                        <li role="presentation" class=""><a href="#pagina13" data-toggle="tab" aria-expanded="false">Appendice</a></li>
                        <li role="presentation" class=""><a href="#pagina14" data-toggle="tab" aria-expanded="false">Opinioni e Firma</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="pagina1">
                            @include('relazioni_e_rapporti.pagine.pagina1') 
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="pagina2">
                            @include('relazioni_e_rapporti.pagine.pagina2') 
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="pagina3-4">
                            @include('relazioni_e_rapporti.pagine.pagina3-4')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="pagina5">
                            @include('relazioni_e_rapporti.pagine.pagina5')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="pagina6">
                            @include('relazioni_e_rapporti.pagine.pagina6')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="pagina7">
                            @include('relazioni_e_rapporti.pagine.pagina7')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="pagina8-9">
                            @include('relazioni_e_rapporti.pagine.pagina8-9')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="pagina10">
                            @include('relazioni_e_rapporti.pagine.pagina10')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="pagina11">
                            @include('relazioni_e_rapporti.pagine.pagina11')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="pagina13">
                            @include('relazioni_e_rapporti.pagine.pagina13')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="pagina14">
                            @include('relazioni_e_rapporti.pagine.pagina14')
                        </div>
                        <div class="row clearfix" style="text-align: end">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button type="submit" name="campagna" value="{{ $campagna->id }}" class="btn btn-primary waves-effect" id="genera_documento" formtarget="_blank">Genera Documento</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@elseif($view_documento_committente == 1)
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-collapsable">
            <div class="header">
                <h2 class="collapsable-handler">&#9662; &#32; Anteprima rapporto di prova</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="collapsable-handler">
                            <i class="material-icons">more_vert</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body">
                
            </div>
            <div class="body body-collapsable demo-masked-input open" style="display: block">
                <form action="{{ URL::action('RapportoRelazioneController@generaPDF_committente') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                        <li role="presentation" class="active"><a href="#dati_generali" data-toggle="tab" aria-expanded="true">Dati generali</a></li>
                        <li role="presentation" class=""><a href="#piano_note_campionamento" data-toggle="tab" aria-expanded="false">Piano e Note di campionamento</a></li>
                        <li role="presentation" class=""><a href="#planimetria_valutazione" data-toggle="tab" aria-expanded="false">Planimetria e valutazione</a></li>
                        <li role="presentation" class=""><a href="#campionamento_aria" data-toggle="tab" aria-expanded="false">Descrizione campionemento aria</a></li>
                        <li role="presentation" class=""><a href="#campionamento_superfici" data-toggle="tab" aria-expanded="false">Descrizione campionamento superfici</a></li>
                        <li role="presentation" class=""><a href="#identificazione_specie_patogene" data-toggle="tab" aria-expanded="false">Identificazione specie patogene</a></li>
                        <li role="presentation" class=""><a href="#dichiarazione_conformita" data-toggle="tab" aria-expanded="false">Dichiarazione di conformità e obiettivi</a></li>
                        <li role="presentation" class=""><a href="#appendice" data-toggle="tab" aria-expanded="false">Appendice</a></li>
                        <li role="presentation" class=""><a href="#opinioni_firme" data-toggle="tab" aria-expanded="false">Opinioni e Firma</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="dati_generali">
                            @include('relazioni_e_rapporti.pagine_rdp_committente.dati_generali') 
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="piano_note_campionamento">
                            @include('relazioni_e_rapporti.pagine_rdp_committente.piano_note_campionamento') 
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="planimetria_valutazione">
                            @include('relazioni_e_rapporti.pagine_rdp_committente.planimetria_valutazione')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="campionamento_aria">
                            @include('relazioni_e_rapporti.pagine_rdp_committente.campionamento_aria')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="campionamento_superfici">
                            @include('relazioni_e_rapporti.pagine_rdp_committente.campionamento_superfici')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="identificazione_specie_patogene">
                            @include('relazioni_e_rapporti.pagine_rdp_committente.identificazione_specie_patogene')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="dichiarazione_conformita">
                            @include('relazioni_e_rapporti.pagine_rdp_committente.dichiarazione_conformita')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="appendice">
                            @include('relazioni_e_rapporti.pagine_rdp_committente.appendice')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="opinioni_firme">
                            @include('relazioni_e_rapporti.pagine_rdp_committente.opinioni_firme')
                        </div>
                        <div class="row clearfix" style="text-align: end">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button type="submit" name="campagna" value="{{ $campagna->id }}" class="btn btn-primary waves-effect" id="genera_documento_committente" formtarget="_blank" >Genera Documento</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
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
        if($('input[type="file"]').val()) {
            $('#checkfile_relazione').removeClass('hidden');
            $('#checkfile_relazione').text($('input[type="file"]')[0].files[0].name);
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