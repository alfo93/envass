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
        <h2>Gestione Attività
            <small>Inserisci una nuova attività nel sistema ENVASS</small>
        </h2>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Crea attività</h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <label for="nome_progetto">Attività</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="nome_progetto" class="form-control" name="progetto" aria-required="true" placeholder="nome" required>
                                        </div>
                                        <div class="help-info">Nome dell'attività</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label for="tipo_progetto">Tipo</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="tipo" name="tipo">
                                                <option value="">-- Seleziona un opzione --</option>
                                                @foreach(App\Progetto::tipo() as $tipo)
                                                    <option value="{{ $tipo }}">{{ $tipo }}</option>
                                                @endforeach
                                            </select>     
                                        </div>
                                        <div class="help-info">tipo del progetto</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <label for="codice_progetto">Codice attività</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="codice_progetto" class="form-control" name="CodPro" aria-required="true" placeholder="CodPro" required>
                                        </div>
                                        <div class="help-info">Codice identificativo dell'attività</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label>Stato</label>
                                            <select class="form-control show-tick" id="attivo" name="attivo">
                                                <option value="">-- Seleziona un opzione --</option>
                                                @foreach(App\Progetto::stato() as $key => $stato)
                                                    <option value="{{ $key }}">{{ $stato }}</option>
                                                @endforeach
                                            </select>                         
                                        </div>
                                        <div class="help-info">Stato dell'attività</div>
                                    </div>        
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Committente</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="societa_progetto" name="societa_progetto">
                                        <option value="">-- Seleziona un opzione --</option>
                                        @foreach($societa as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                                        @endforeach
                                    </select>     
                                    <div class="help-info">Committente incaricante del progetto</div>                           
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="data_inizio_progetto">Data inizio attività</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="date" id="data_inizio_progetto" class="form-control" name="data_inizio_progetto" aria-required="true" placeholder="" required>
                                </div>
                                <div class="help-info">Data di inizio dell'attività</div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <button class="btn btn-lg btn-primary waves-effect mt-2" id="aggiungi_progetto" type="submit" style="text-align: center">Crea progetto</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('js/progetti/progetti.js') }}"></script>
@endsection