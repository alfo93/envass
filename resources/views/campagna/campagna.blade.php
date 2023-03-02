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
            <small>Dashboard campionamenti ENVASS</small>
        </h2>
    </div>

    @is(['admin','gestore'])
    <div class="block-header">
        <h2>Scegli i campionamenti da visualizzare, filtrali in base al committente, la struttura, la partizione e la data
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
                            <label>Committente</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="societa_campagna" name="societa_campagna">
                                        <option value="tutti">Tutti</option>
                                        @foreach($societa as $s)
                                            <option value="{{ $s->id }}">{{ $s->nome }}</option>
                                        @endforeach
                                    </select>     
                                    <div class="help-info">Nome del committente</div>                           
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Attività</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="progetti_campagna" name="progetti_campagna">
                                        <option value="tutti">Tutti</option>
                                        
                                    </select>     
                                    <div class="help-info">progetto</div>                           
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Struttura</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="struttura_campagna" name="struttura_campagna">
                                        <option value="tutti">Tutti</option>
                                        
                                    </select>     
                                    <div class="help-info">Struttura</div>                           
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <label>Data campagna</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="date" class="form-control" id="data_campagna" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endis
    
    {{-- Campagne --}}
    @include('campagna.lista_campagne')    
@endsection

</div>