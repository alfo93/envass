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
            <small>Dashboard campionatori ENVASS</small>
        </h2>
    </div>

    @is(['admin'])
    <div class="block-header">
        <h2>Scegli i campionatori da visualizzare, filtrali in base all'attività, alla struttura e all'area di lavoro di appartenenza
        </h2>
    </div>
    
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card card-collapsable">
                <div class="header">
                    <h2 class="collapsable-handler">Filtro</h2>
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
                                    <select class="form-control show-tick" id="societa_rilevatori" name="societa_rilevatori">
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
                                    <select class="form-control show-tick" id="progetto_rilevatori" name="progetto_rilevatori">
                                        <option value="tutti">Tutti</option>
                                        
                                    </select>     
                                    <div class="help-info">attività</div>                           
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Struttura</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="struttura_rilevatori" name="struttura_rilevatori">
                                        <option value="tutti">Tutti</option>
                                        
                                    </select>     
                                    <div class="help-info">Struttura</div>                           
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Interno</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="interno_rilevatori" name="interno_rilevatori">
                                        <option value="tutti">Tutti</option>
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
        </div>
    </div>
    @endis


    {{-- RapportiRelazioni --}}
    @include('rilevatori.rilevatori')   
    
</div> 
@endsection

