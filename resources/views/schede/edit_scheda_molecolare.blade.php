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
    input[type="file"] {
        display: none;
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

    #text_file {
        margin-left: 34px;
        position: relative;
        top: 3px;
        bottom: 0.5rem;
        color: #fff;
        font-size: 12px;
        cursor: pointer;
    }
</style>
@endsection  


@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>DASHBOARD 
            <small>modifica scheda analisi molecolare</small>
        </h2>
    </div>

    {{-- Strumenti --}}
    {{-- @include('schede.edit.strumenti') --}}

    
    
    @if ($errors->any())
        <div id="errors-container" class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ ucfirst($error) }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div id="errors-container2" style="display: none">
    </div>

    <form action="{{ URL::action('CampioneAnalisiMolecolareController@store') }}" enctype="multipart/form-data" method="POST" class="">
        {{ csrf_field() }}

        {{-- Dati sull'anagrafica --}}
        <div class="block-header">
            <h2>
                <small>Anagrafica campionamento</small>
            </h2>
        </div>
        @include('schede.edit_molecolare.anagrafica_campionamento_molecolare')
        
        
        {{-- Dati sul campionamento --}}
        <div class="block-header">
            <h2>
                <small>Campionamento</small>
            </h2>
        </div>
        @include('schede.edit_molecolare.campionamento_molecolare')

        {{-- Dati sull'analisi effettuata--}}
        <div class="block-header">
            <h2>
                <small>Analisi</small>
            </h2>
        </div>
        @include('schede.edit_molecolare.analisi_molecolare')

        {{--  Bottone per salvare i dati --}}
        @shield('campioni_analisi_molecolari.store')
            @if(!isset($campione))
            <div class="row m-b-20">
                <div class="col-md-12 align-center">
                    <input type="submit" name="submit" class="btn btn-primary btn-lg waves-effect"  id="salva_chiudi_dati" value="Salva e chiudi">
                    <input type="submit" name="submit" class="btn btn-primary btn-lg waves-effect"  id="salva_procedi_dati" value="Salva e procedi">        
                </div>
            </div>
            @endif
        @endshield
    </form>

    {{-- Dati sull'analisi effettuata--}}
    <div class="{{ isset($campione) ? '' : 'hidden' }}" id="sez_analisi_molecolare">
        <div class="block-header">
            <h2>
                <small>Campione da Analisi Molecolare</small>
            </h2>
        </div>
        @include('schede.edit_molecolare.campioneSWAB')
    </div>
    
    {{-- Dati sull'analisi effettuata--}}
    <div class="{{ (isset($campione) && $campione->presenzaMicro == 1) ? '' : 'hidden' }}" id="sez_antibiogrammi">
        <div class="block-header">
            <h2>
                <small>Antibiogrammi</small>
            </h2>
        </div>
        @include('schede.edit_molecolare.antibiogramma_molecolare')
    </div>

    {{--  Bottone per salvare i dati --}}
    @shield('campioni_analisi_molecolari.update')
        @if(isset($campione))
        <div class="row m-b-20">
            <div class="col-md-12 align-center">
                <input type="submit" class="btn btn-primary btn-lg waves-effect" id_campione="{{ $campione->id }}"  id="modifica_dati_swab" value="Modifica">
            </div>
        </div>
        @endif
    @endshield

@endsection

@section('script')
<script src="{{ asset('js/pages/ui/dialogs.js') }}"></script>
<script src="{{ asset('js/schede_molecolari/anagrafica_molecolari.js') }}"></script>
<script src="{{ asset('js/schede_molecolari/analisi_molecolari.js') }}"></script>
<script src="{{ asset('js/schede_molecolari/campionamento_molecolari.js') }}"></script>
<script src="{{ asset('js/schede_campionamenti/antibiogramma.js') }}"></script>
<script src="{{ asset('js/schede_molecolari/campioneAnalisiMolecolare.js') }}"></script>
<script src="{{ asset('js/schede_molecolari/update_molecolari.js') }}"></script>
<script src="{{ asset('js/schede_molecolari/antibiogramma_esteso.js') }}"></script>
@endsection
</div>