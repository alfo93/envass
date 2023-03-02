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

    ul.typeahead.dropdown-menu {
        top: 65px !important;
    }

</style>
@endsection  


@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>DASHBOARD 
            <small>Aggiungi un nuovo campionatore al sistema</small>
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

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2 class="collapsable-handler">Aggiungi campionatore</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="collapsable-handler">
                                <i class="material-icons">more_vert</i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="body body-collapsable demo-masked-input">
                    <form id="form_advanced_validation" enctype="multipart/form-data" action="{{ URL::action('RilevatoreController@store') }}" method="POST" novalidate="novalidate">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label for="progetto">Nome</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="nome" class="form-control" name="nome" placeholder="nome" value="{{ old('nome') ?? '' }}" maxlength="255">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label for="progetto">Cognome</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="cognome" class="form-control" name="cognome" placeholder="cognome" value="{{ old('cognome') ?? '' }}" maxlength="255">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label for="progetto">Attività</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control show-tick" name="id_progetto" id="progetti_rilevatore" data-size="7">
                                                    <option selected value="nessuna">-- Seleziona un'opzione --</option>
                                                    @foreach ($progetti as $progetto)
                                                        <option value="{{ $progetto->id }}">{{ $progetto->progetto }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label for="struttura">Struttura</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control show-tick" name="id_struttura" id="struttura_rilevatore" data-size="7">
                                                    <option selected value="nessuna">-- Seleziona un'opzione --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label for="reparto">Interno</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control show-tick" id="interno_rilevatore" name="interno">
                                                    <option value="tutti">-- Seleziona un'opzione --</option>
                                                    <option value="si">Si</option>
                                                    <option value="no">No</option>
                                                </select>     
                                                <div class="help-info">Interno</div>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-primary waves-effect" type="submit">Salva</button>
                            </div>
                        </div>
                    </form>        
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script type="text/javascript">


    $('#progetti_rilevatore').on('change',function(){
        var id_progetto = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/rilevatori/"+id_progetto+"/getStruttureProgetto",
            type: "GET",
            dataType: "json",
            data: {
                id_progetto: id_progetto,
            },
            success: function(returnValue) {
                replace_options_strutture($('#struttura_rilevatore'),$('#struttura_rilevatore').prev("div"),returnValue['tot_strutture']);
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
        
</script>
@endsection



</div>