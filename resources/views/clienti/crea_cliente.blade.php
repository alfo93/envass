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
        <h2>Gestione committenti
            <small>Inserisci un nuovo committente nel sistema ENVASS</small>
        </h2>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Crea committente</h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="nome_societa">Nome</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="nome_societa" class="form-control" name="name" aria-required="true" placeholder="nome" required>
                                        </div>
                                        <div class="help-info">Nome del committente</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="email_societa">E-mail</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="email" id="email_societa" class="form-control" name="email" aria-required="true" placeholder="E-mail" required>
                                        </div>
                                        <div class="help-info">Recapito elettronico del committente</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="indirizzo_societa">Indirizzo</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="indirizzo_societa" class="form-control" name="indirizzo" aria-required="true" placeholder="indirizzo" required>
                                        </div>
                                        <div class="help-info">Indirizzo del committente</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label id="carica_contratto_label" for="carica_contratto" class="custom-file-upload">
                                        <span id="carica_contratto_text">Carica Documento</span>
                                    </label>
                                    <input class="custom-file-upload" id="carica_contratto" name="file" type="file" name="file"/>
                                    <span id="checkfile_contratto" class="label hidden label-success ml-2 font-13"></span>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <button class="btn btn-lg btn-primary waves-effect mt-2" id="aggiungi_cliente" type="submit" style="text-align: center">Crea committente</button>
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
<script src="{{ asset('js/clienti/clienti.js') }}"></script>
@endsection