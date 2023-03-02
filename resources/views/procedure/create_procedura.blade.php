@extends('layouts.main')

@section('style')
<style>
   
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

    #text_firma {
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
        <h2>Gestione Procedure
            <small>Inserisci una nuova procedura</small>
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
                    <h2>Crea Procedura</h2>
                </div>
                <div class="body">
                    <form id="form_advanced_validation" enctype="multipart/form-data" action="{{ URL::action('ProceduraController@store') }}" method="POST" novalidate="novalidate">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="form-label">Titolo</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="note" minlength="3" required="" aria-required="true">
                                    </div>
                                    <div class="help-info">Titolo del documento</div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="progetto">Attività</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="id_progetto" id="progetto" data-size="7">
                                            <option selected value="">-- Seleziona un'opzione --</option>
                                            <option value="0">Generale</option>
                                            @foreach (App\Progetto::all() as $progetto)
                                                <option value="{{ $progetto->id }}">{{ $progetto->progetto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="livello">Livello</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="livello" name="livello" data-size="7">
                                            <option selected value="">-- Seleziona un'opzione --</option>
                                            @foreach (App\Procedura::livello() as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label id="labelFirma" for="carica_firma" class="custom-file-upload">
                                            <span id="text_firma">Carica Documento</span>
                                        </label>
                                        <input class="custom-file-upload" id="carica_firma" name="file" type="file" name="file"/>
                                        <span id="checkfile" class="label hidden label-success ml-2 font-13"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-primary waves-effect" type="submit">SALVA</button>
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

$('#carica_firma').on('change',function(){
    check_submit();
});

function check_submit()
{
    if($('input[type="file"]').val()) {
        $('#checkfile').removeClass('hidden');
        $('#checkfile').text($('input[type="file"]')[0].files[0].name);
    }
}
    
</script>
@endsection