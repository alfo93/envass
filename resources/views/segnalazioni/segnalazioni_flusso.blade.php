@extends('layouts.main')

@section('style')
<style>
    .thumbnail {
        /* mantiene solo il bordo in basso, per dividere le varie thumbnails */
        border-style: none none solid none;

        padding-bottom: 40px;
        padding-top:10px;
        margin-top: 0px;
        margin-bottom: 0px;
    }

    .thumbnail h3 {
        font-size: 24px;
        margin-bottom: 5px;
    }

    .label {
        padding: 5px;
        margin-right: 5px;
        border-radius: 5%;
    }

    .btn-ignora {
        margin-top: 10px;
        margin-bottom: 5px;
    }

    .btn-vedipdf {
        margin-top: 10px;
        margin-bottom: 5px;
    }

    .btn-riprocessa {
        margin-top: 10px;
        margin-bottom: 5px;
    }

    .messaggio {
        margin-top: 20px;
        margin-bottom: 10px;
    }

</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>DASHBOARD
            <small>Dashboard segnalazioni di ENVASS</small>
        </h2>
    </div>

    <!-- Custom Content -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Elenco delle segnalazioni</h2>
                </div>
                <div class="body">
                    <div class="row">
                        @php $nSegnalazioni = 0 @endphp
                            <div class="col-md-6 col-md-offset-3">
                                @foreach ($segnalazioni as $segnalazione)
                                        @if(!$segnalazione->controllato)
                                            @php $nSegnalazioni++ @endphp
                                            <div class="thumbnail">
                                                <h3>{{ $segnalazione->titolo }}</h3>
                                                <p>
                                                    <span class="label bg-grey">{{ $segnalazione->id }}</span>
                                                    @if ($segnalazione->controllato)
                                                        <span class="label bg-green">Ignorato</span>
                                                    @else
                                                        <span id="{{ $segnalazione->id }}" class="label bg-grey">Da risolvere</span>
                                                    @endif
                                                    <small>{{ format_date($segnalazione->data) }}</small>
                                                </p>
                                                <div class="text messaggio">{!! $segnalazione->messaggio !!}</div>
                                                @if(!$segnalazione->controllato)
                                                    <button id="{{ $segnalazione->id }}_ignora" id_segnalazione="{{ $segnalazione->id }}" data_segnalazione="{{ $segnalazione->data }}" msg_segnalazione= "{{ $segnalazione->messaggio }}" class="btn btn-warning waves-effect btn-small btn-ignora">Ignora</button>
                                                    @if($segnalazione->codice != '6')
                                                        <!--<a href="{{ URL::action('SegnalazioneController@vediPDF',$segnalazione->id) }}" id="{{ $segnalazione->id }}_vedipdf" id_segnalazione="{{ $segnalazione->id }}" data_segnalazione="{{ $segnalazione->data }}" msg_segnalazione= "{{ $segnalazione->messaggio }}" target="_blank" class="btn btn-success waves-effect btn-small btn-vedipdf">Vedi PDF</a>-->
                                                        <button id="{{ $segnalazione->id }}_vedipdf" id_segnalazione="{{ $segnalazione->id }}" data_segnalazione="{{ $segnalazione->data }}" msg_segnalazione= "{{ $segnalazione->messaggio }}" class="btn btn-success waves-effect btn-small btn-vedipdf">Vedi PDF</button>
                                                        <button id="{{ $segnalazione->id }}_riprocessa" id_segnalazione="{{ $segnalazione->id }}" data_segnalazione="{{ $segnalazione->data }}" msg_segnalazione= "{{ $segnalazione->messaggio }}" class="btn btn-primary waves-effect btn-small btn-riprocessa">Tenta di risolvere</button>
                                                    @endif
                                                @endif
                                            </div>
                                        @endif
                                @endforeach
                            @if($nSegnalazioni == 0)
                                    <h3 class="text-center">Nessuna segnalazione</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Custom Content -->

</div>
@endsection
