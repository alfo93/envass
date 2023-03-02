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
</style>
@endsection  

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>DASHBOARD
            <small>Dashboard relazioni e rapporti di prova ENVASS</small>
        </h2>
    </div>

    @is(['admin','gestore'])
    <div class="block-header">
        <h2>Scegli le relazioni e i rapporti di prova da visualizzare, filtrale in base alla societa, la struttura e il reparto
        </h2>
    </div>
    
    <div class="row clearfix">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="card card-collapsable">
                <div class="header">
                    <h2 class="collapsable-handler"> &#9660; Filtro</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="collapsable-handler">
                                <i class="material-icons">more_vert</i>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="body body-collapsable demo-masked-input">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Societa</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="societa_relazionirapporti" name="societa_relazionirapporti">
                                        <option value="tutti">Tutti</option>
                                        @foreach($societa as $s)
                                            <option value="{{ $s->id }}">{{ $s->nome }}</option>
                                        @endforeach
                                    </select>     
                                    <div class="help-info">Nome del Committente</div>                           
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Attività</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="progetti_relazionirapporti" name="progetti_relazionirapporti">
                                        <option value="tutti">Tutti</option>
                                        
                                    </select>     
                                    <div class="help-info">Attività</div>                           
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Struttura</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="struttura_relazionirapporti" name="struttura_relazionirapporti">
                                        <option value="tutti">Tutti</option>
                                        
                                    </select>     
                                    <div class="help-info">Struttura</div>                           
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Partizione</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="reparto_relazionirapporti" name="reparto_relazionirapporti">
                                        <option value="tutti">Tutti</option>
                                        
                                    </select>     
                                    <div class="help-info">Partizioni</div>                           
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        @shield('rapp_rel.store')
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <!-- crea un bottone -->
            <a style="height: 60px; padding-top:20px; font-weight: bolder; font-size: larger;" href="{{ URL::action('RapportoRelazioneController@create') }}" name="crea_relazionerapporto" id="crea_relazionerapporto" value="Upload nuovo documento" class="btn btn-block btn-lg btn-primary waves-effect">Genera nuovo</a>
        </div>
        @endshield 
    </div>
    @endis


    {{-- RapportiRelazioni --}}
    @include('relazioni_e_rapporti.relazionirapporti')   
    
</div> 
@endsection

