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

    .download-grafico {
        position: absolute;
        top: 20px;
        right: 15px;
    }

    .download-grafico i {
        -moz-transition: all 0.5s;
        -o-transition: all 0.5s;
        -webkit-transition: all 0.5s;
        transition: all 0.5s;
        color: #999;
    }

    .download-grafico i:hover {
        color: #000;
    }
</style>
@endsection 


@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>DASHBOARD
            <small>Dashboard Clienti ENVASS</small>
        </h2>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <h2>Numero di attività per committente </h2>
                        </div>
                        <a id="download_grafico_societa_progetti" class="download-grafico" role="button" download="SocietaProgetti">
                            <i class="material-icons">get_app</i>
                        </a>
                    </div>
                </div>
                <div class="body">
                    <div id="real_time_chart" class="dashboard-flot-chart" style="padding: 0px; position: relative;">
                        <canvas id="chart_societa_progetti" class="flot-overlay" width="1505" height="275" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 1505px; height: 275px;"></canvas>                
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Elenco clienti --}}
    @include('clienti.lista_clienti')    
@endsection
</div>