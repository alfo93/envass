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
            <small>modifica scheda punto di campionamento</small>
        </h2>
    </div>

    {{-- Strumenti --}}
    {{-- @include('schede.edit.strumenti') --}}

    
    
    <div id="errors-container" style="display: none">
    </div>


    @is('admin')
    
        @if(isset($campione) && $campione->bloccato == 1)
        {{-- <div class="block-header">
            <h2>
                <small>Sblocca campione</small>
            </h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- div contenitore di informazioni utili per la corretta compilazione e salvataggio -->
                <div class="card card-collapsable">
                    <div class="header">
                        <h2>Il campione è bloccato</h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="collapsable-handler">
                                    <i class="material-icons">more_vert</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body body-collapsable demo-masked-input">
                        <button type="button" id="sblocca-button" class="btn btn-info waves-effect">Sblocca</button>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="alert alert-warning">
            <strong>Attenzione!</strong> Il campione è bloccato
            <button type="button" id="sblocca-button" class="btn btn-warning waves-effect ml-3" data-toggle="modal" data-target="#sbloccaModal">Sblocca</button>
        </div>
        @endif
    
    @endis

    @if($tipo == 'B' || $tipo == 'N' )
    {{-- Dati sull'anagrafica --}}
    <div class="block-header">
        <h2>
            <small>Anagrafica campionamento</small>
        </h2>
    </div>
    @include('schede.edit.anagrafica_campionamento')
    @endif
    
    @if($tipo == 'Q')
    {{-- Dati sull'anagrafica --}}
    <div class="block-header">
        <h2>
            <small>Anagrafica campionamento</small>
        </h2>
    </div>
    @include('schede.edit.anagrafica_campionamento_qualita')
    @endif

    @if($tipo == 'N' )
    {{-- Dati sul sito di campionamento --}}
    <div class="block-header">
        <h2>
            <small>Sito di campionamento</small>
        </h2>
    </div>
    @include('schede.edit.sito_campionamento')
    @endif

    @if($tipo == 'N' )
    {{-- Dati sul campionamento --}}
    <div class="block-header">
        <h2>
            <small>Campionamento</small>
        </h2>
    </div>
    @include('schede.edit.campionamento')
    @endif
    
    {{-- Dati sull'analisi effettuata--}}
    <div class="block-header">
        <h2>
            <small>Analisi</small>
        </h2>
    </div>
    @include('schede.edit.analisi')

    {{-- Dati sul campione --}}
    <div class="block-header">
        <h2>
            <small>Campione</small>
        </h2>
    </div>
    @include('schede.edit.campione')

    @if($tipo == 'N' )
    {{-- Dati sull'antibiogramma --}}
    <div class="block-header">
        <h2>
            <small>Antibiogramma</small>
        </h2>
    </div>
    @include('schede.edit.antibiogramma')
    @endif

    {{--  Bottone per salvare i dati --}}
    @shield('campioni.store')
    <div class="row m-b-20">
        <div class="col-md-12 align-center">
            @if((isset($campione) && $numeroProgressivo == 0) ?? '')
                <input type="submit" class="btn btn-primary btn-lg waves-effect" id="modifica_dati" data-toggle="modal" data-target="#modificaModal" value="Modifica" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }} >
                <input type="button" class="btn btn-primary btn-lg waves-effect" id_campione="{{ $campione->id }}" tipo="{{ $tipo }}" id="riprendi" value="Riprendi il campionamento" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }} >
            @else
                <input type="submit" class="btn btn-primary btn-lg waves-effect"  tipo="{{ $tipo }}" id="salva_chiudi_dati" value="Salva e chiudi" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }} >
                <input type="submit" class="btn btn-primary btn-lg waves-effect"  tipo="{{ $tipo }}" id="salva_procedi_dati" value="Salva e procedi" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }} >        
            @endif                  
        </div>
    </div>
    @endshield

    <!--modal-->
    @if(isset($campione))
    <div class="modal fade in" id="modificaModal" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modificaModalLabel">Specificare il motivo della modifica</h4>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                            <label for="" id="modificaModalLabel">Motivo: </label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                            <div class="form-group">
                                <div class="form-line focused">
                                    <input type="text" class="form-control" id="modifica_motivo" name="modifica_motivo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id_campione="{{ $campione->id }}" tipo="{{ $tipo }}" id="modifica_dati_salva" name="modifica_dati_salva" class="btn btn-link waves-effect modifica_scheda_modal">CONFERMA</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade in" id="riprendiModal" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="riprendiModalLabel">Specificare il motivo della ripresa</h4>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                            <label for="" id="riprendiModalLabel">Motivo: </label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                            <div class="form-group">
                                <div class="form-line focused">
                                    <input type="text" class="form-control" id="riprendi_motivo" name="riprendi_motivo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id_campione="{{ $campione->id }}" tipo="{{ $tipo }}" id="riprendi_dati_salva" name="riprendi_dati_salva" class="btn btn-link waves-effect modifica_scheda_modal">CONFERMA</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                </div>
            </div>
        </div>
    </div> --}}
    <!--end modal--> 
    @endif

     <!--modal-->
     @if(isset($campione))
     <div class="modal fade in" id="sbloccaModal" tabindex="-1" role="dialog" style="display: none;">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h4 class="modal-title" id="sbloccaModalLabel">Specificare il motivo dello sbloccamento</h4>
                 </div>
                 <div class="modal-body">
                     <div class="row clearfix">
                         <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                             <label for="" id="sbloccaModalLabel">Motivo: </label>
                         </div>
                         <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                             <div class="form-group">
                                 <div class="form-line focused">
                                     <input type="text" class="form-control" id="sblocca_motivo" name="sblocca_motivo">
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" id_campione="{{ $campione->id }}" tipo="{{ $tipo }}" id="sblocca_campione" name="sblocca_campione" class="btn btn-link waves-effect sblocca_scheda_modal">CONFERMA</button>
                     <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                 </div>
             </div>
         </div>
     </div>
     <!--end modal--> 
     @endif

@endsection

@section('script')
<script src="{{ asset('js/pages/ui/dialogs.js') }}"></script>

@if($tipo == 'N' || $tipo == 'B')
<script src="{{ asset('js/schede_campionamenti/anagrafica_campionamento.js') }}"></script>
@endif

@if($tipo == 'Q')
<script src="{{ asset('js/schede_campionamenti/anagrafica_campionamento_qualita.js') }}"></script>
@endif

<script src="{{ asset('js/schede_campionamenti/salva_campionamento.js') }}"></script>
<script src="{{ asset('js/schede_campionamenti/sito_campionamento.js') }}"></script>
<script src="{{ asset('js/schede_campionamenti/campionamento.js') }}"></script>
<script src="{{ asset('js/schede_campionamenti/campione.js') }}"></script>
<script src="{{ asset('js/schede_campionamenti/antibiogramma.js') }}"></script>
@endsection
</div>