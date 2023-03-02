@extends('layouts.main')

@section('style')
<style>
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

    <div class="container-fluid">
        <!-- Infobox con Hover Expand Effect -->
        <div class="row">
            @is(['admin','gestore'])
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            @endis
            @is(['committente','utente'])
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            @endis
                <div class="info-box bg-indigo hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">business_center</i>
                    </div>
                    <div class="content">
                        <div class="text"> Numero di campioni </div>
                        <div class="number"> {{ $n_campioni }} </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-blue hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">pending_actions</i>
                    </div>
                    <div class="content">
                        <!--<div class="text">REFERTI APERTI DAL {{ Carbon\Carbon::now()->subMonths(1)->format('d/m/Y') }}</div>-->
                        <div class="text"> Numero di campagne </div>
                        <div class="number"> {{ $n_campagne }} </div>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-light-blue hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">today</i>
                    </div>
                    <div class="content">
                        <div class="text"> Prossima rilevazione </div>
                        <div id="prenotazioni-giornaliere" class="number"> {{ Carbon\Carbon::now()->format('d-M-Y') }} </div>
                    </div>
                </div>
            </div> --}}
            @is(['admin','gestore'])
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-teal hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">business</i>
                    </div>
                    <div class="content">
                        <div class="text"> Numero di committenti </div>
                        <div class="number"> {{ App\Societa::count() }} </div>
                        
                    </div>
                </div>
            </div>
            @endis
            @is(['admin','gestore'])
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            @endis
            @is(['committente','utente'])
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            @endis
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">groups</i>
                    </div>
                    <div class="content">
                        <div class="text"> Numero di attività </div>
                        <div class="number"> {{ $n_progetti }} </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Infobox con Hover Expand Effect -->
    </div>

    <div class="block-header">
        <h2>Situazione ENVASS
            <small>I dati si riferiscono ...</small>
        </h2>
    </div>

    <!-- Grafici -->
    @is(['admin','gestore'])
    <div class="row clearfix">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <h2> Numero di campionamenti effettuati per attività </h2>
                        </div>
                        <a id="download_grafico_campioni_progetti" class="download-grafico" role="button" download="GraficoCampioniProgetti">
                            <i class="material-icons">get_app</i>
                        </a>
                    </div>
                </div>
                <div class="body">
                    <canvas id="chart_campioni_progetti"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
                    <canvas id="chart_societa_progetti"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <h2>Numero di campionamenti: confronto tra l'anno {{  Carbon\Carbon::now()->subMonths(Carbon\Carbon::now()->format('m'))->format('Y') }} e {{  Carbon\Carbon::now()->format('Y') }} </h2>
                        </div>
                        <a id="download_grafico_rapporto_campioni_mesi" class="download-grafico" role="button" download="GraficoRapportoCampioniMesi">
                            <i class="material-icons">get_app</i>
                        </a>
                    </div>
                </div>
                <div class="body">
                    <canvas id="chart_rapporto_campioni_mesi"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Grafici -->
    @endis
    @is(['utente','committente'])
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <h2>Numero di campionamenti: confronto tra l'anno {{  Carbon\Carbon::now()->subMonths(Carbon\Carbon::now()->format('m'))->format('Y') }} e {{  Carbon\Carbon::now()->format('Y') }} </h2>
                        </div>
                        <a id="download_grafico_rapporto_campioni_mesi" class="download-grafico" role="button" download="GraficoRapportoCampioniMesi">
                            <i class="material-icons">get_app</i>
                        </a>
                    </div>
                </div>
                <div class="body">
                    <canvas id="chart_rapporto_campioni_mesi"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endis
</div>
@endsection

@section('script')
<script type="text/javascript">

$('document').ready(function() {
    var ruolo = {!! json_encode($role) !!};
    console.log(ruolo)
    if(ruolo == "admin" || ruolo == "gestore") { //admin e gestore
        let data = moment(new Date()).format("YYYY-MM-DD");
        let cl = console.log;

        // imposta lo sfondo di colore bianco nei grafici da scaricare come immagini
        const backgroundColor = 'white';
        Chart.plugins.register({
            beforeDraw: function(c) {
                let ctx = c.chart.ctx;
                ctx.fillStyle = backgroundColor;
                ctx.fillRect(0, 0, c.chart.width, c.chart.height);
            }
        });
        
        const palette_colori = {!! json_encode($palette_colori) !!};
       
        // grafico dei campionamenti di ogni progetto
        const campioni_progetti = {!! json_encode($campioni_progetti) !!};
        const context_campioni_progetti = document.getElementById('chart_campioni_progetti').getContext('2d');
        
        var campioni_progetti_length = Object.keys(campioni_progetti).length;
        let projects = [];
        let total_num = [];
        campioni_progetti.forEach((cp) => {
            projects.push(cp['nome_progetto']);
            total_num.push(cp['totale']);
        });
        var chart_campioni_progetti = new Chart(context_campioni_progetti, {
            type: 'horizontalBar',
            data: {
                labels: ['SANICA COPMA','ROUTINE COPMA','ROUTINE ETABETA','ACCREDIA','LAB PMA','GANT_COPMA','ATM_COPMA'],
                datasets: [{
                    data: total_num,
                    backgroundColor: 'rgba(0, 188, 212, 0.8)',
                }],
            },
            options: {
                responsive: true,
                legend: false,
                animation: {
                    onComplete: function() {
                        // imposta il link all'immagine da scaricare
                        $('#download_grafico_campioni_progetti').attr("href", chart_campioni_progetti.toBase64Image());
                    }
                }
            },  
        });

        // grafico dei progetti per ogni società
        const societa_progetti = {!! json_encode($societa_progetti) !!};
        const context_societa_progetti = document.getElementById('chart_societa_progetti').getContext('2d');
        var societa_progetti_length = Object.keys(societa_progetti).length;
        let societa = [];
        let num_prog_societa = [];
        societa_progetti.forEach((sp) => {
            societa.push(sp['nome_societa']);
            num_prog_societa.push(sp['tot_progetti']);
        });
        var chart_societa_progetti = new Chart(context_societa_progetti, {
            type: 'horizontalBar',
            data: {
                labels: societa,
                datasets: [{
                    data: num_prog_societa,
                    backgroundColor: ['rgba(95, 94, 239, 1)','rgba(0,255,127,0.8)', 'rgba(255,228,90,0.8)', 'rgba(26, 142, 67, 1)'],
                }],
            },
            options: {
                responsive: true,
                legend: false,
                animation: {
                    onComplete: function() {
                        // imposta il link all'immagine da scaricare
                        $('#download_grafico_societa_progetti').attr("href", chart_societa_progetti.toBase64Image());
                    }
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true,
                            userCallback: function(label, index, labels) {
                                // when the floored value is the same as the value we have a whole number
                                if (Math.floor(label) === label) {
                                    return label;
                                }

                            },
                        }
                    }],
                },
            }
        });

        //grafico rapporto campioni mesi
        const anno_attuale = {!! json_encode($anno_attuale) !!};
        const anno_precedente = {!! json_encode($anno_precedente) !!};
        //console.log(anno_attuale);
        //console.log(anno_precedente);
        let month_attuale = [];
        let num_attuale = [];
        var somma_campioni = [];
        anno_attuale.forEach((campionamenti) => {
            month_attuale.push(campionamenti['mesi']);
            num_attuale.push(campionamenti['totale']);
            somma_campioni.push(campionamenti['mesi']);
        });

        let month_precedente = [];
        let num_precedente = [];
        anno_precedente.forEach((campionamenti) => {
            month_precedente.push(campionamenti['mesi']);
            num_precedente.push(campionamenti['totale']);
            if(!somma_campioni.includes(campionamenti['mesi'])) 
            {
                somma_campioni.push(campionamenti['mesi']);
            } 
        });
        var monthNames = [ "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno",
                        "Luglio", "Agosto", "Settebre", "Ottobre", "Novembre", "Dicembre" ];
        var mesi_totali = [];
        somma_campioni.forEach(element => {
            switch (element) {
                case 1:
                    mesi_totali.push('Gennaio');
                    break;
                case 2:
                    mesi_totali.push('Febbraio');
                    break;
                case 3:
                    mesi_totali.push('Marzo');
                    break;
                case 4:
                    mesi_totali.push('Aprile');
                    break;
                case 5:
                    mesi_totali.push('Maggio');
                    break;
                case 6:
                    mesi_totali.push('Giugno');
                    break;
                case 7:
                    mesi_totali.push('Luglio');
                    break;
                case 8:
                    mesi_totali.push('Agosto');
                    break;
                case 9:
                    mesi_totali.push('Settembre');
                    break;
                case 10:
                    mesi_totali.push('Ottobre');
                    break;
                case 11:
                    mesi_totali.push('Novembre');
                    break;
                case 12:
                    mesi_totali.push('Dicembre');
                    break;
                default:
                    break;
            }
        });
        const context_rapporto_campioni_mesi = document.getElementById('chart_rapporto_campioni_mesi').getContext('2d');
        
        var chart_rapporto_campioni_mesi = new Chart(context_rapporto_campioni_mesi, {
            type: 'line',
            data: {
                labels: mesi_totali,
                datasets: [{
                        label: 'Campionamenti dell\'anno attuale',
                        data: num_attuale,
                        borderColor: 'rgba(0, 188, 212, 0.75)',
                        backgroundColor: 'rgba(0, 188, 212, 0.3)',
                        pointBorderColor: 'rgba(0, 188, 212, 0)',
                        pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                        pointBorderWidth: 1,
                        
                    },{
                        label: 'Campionamenti dell\'anno precedente',
                        data: num_precedente,
                        borderColor: 'rgba(233, 30, 99, 0.75)',
                        backgroundColor: 'rgba(233, 30, 99, 0.3)',
                        pointBorderColor: 'rgba(233, 30, 99, 0)',
                        pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
                        pointBorderWidth: 1,
        
                    }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 12,
                    },
                },
                animation: {
                    onComplete: function() {
                        // imposta il link all'immagine da scaricare
                        $('#download_grafico_rapporto_campioni_mesi').attr("href", chart_rapporto_campioni_mesi.toBase64Image());
                    }
                },
                hover: {
                    mode: 'point'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            //beginAtZero: true,
                            userCallback: function(label, index, labels) {
                                // when the floored value is the same as the value we have a whole number
                                if (Math.floor(label) === label) {
                                    return label;
                                }

                            },
                        }
                    }],
                },
            }
        });

        chart_rapporto_campioni_mesi.resize()

        /**
         * La funzione genera dinamicamente i colori assegnati ad ogni etichetta
         */
        function generaColoreOggetto(colori,dati_grafico_length) {
            var colore = new Array();
            for(var i = 0; i < dati_grafico_length; i++){
                colore[i] = colori[i];
                if(i > colori.length)
                {
                    break;
                }
            }
            
            return colore
        }
    }
    else //utenti e committenti
    {
        let data = moment(new Date()).format("YYYY-MM-DD");
        let cl = console.log;

        // imposta lo sfondo di colore bianco nei grafici da scaricare come immagini
        const backgroundColor = 'white';
        Chart.plugins.register({
            beforeDraw: function(c) {
                let ctx = c.chart.ctx;
                ctx.fillStyle = backgroundColor;
                ctx.fillRect(0, 0, c.chart.width, c.chart.height);
            }
        });
        
        const palette_colori = {!! json_encode($palette_colori) !!};

        //grafico rapporto campioni mesi
        const anno_attuale = {!! json_encode($anno_attuale) !!};
        const anno_precedente = {!! json_encode($anno_precedente) !!};
        //console.log(anno_attuale);
        //console.log(anno_precedente);
        let month_attuale = [];
        let num_attuale = [];
        var somma_campioni = [];
        anno_attuale.forEach((campionamenti) => {
            month_attuale.push(campionamenti['mesi']);
            num_attuale.push(campionamenti['totale']);
            somma_campioni.push(campionamenti['mesi']);
        });

        let month_precedente = [];
        let num_precedente = [];
        anno_precedente.forEach((campionamenti) => {
            month_precedente.push(campionamenti['mesi']);
            num_precedente.push(campionamenti['totale']);
            if(!somma_campioni.includes(campionamenti['mesi'])) 
            {
                somma_campioni.push(campionamenti['mesi']);
            } 
        });
        var monthNames = [ "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno",
                        "Luglio", "Agosto", "Settebre", "Ottobre", "Novembre", "Dicembre" ];
        var mesi_totali = [];
        somma_campioni.forEach(element => {
            switch (element) {
                case 1:
                    mesi_totali.push('Gennaio');
                    break;
                case 2:
                    mesi_totali.push('Febbraio');
                    break;
                case 3:
                    mesi_totali.push('Marzo');
                    break;
                case 4:
                    mesi_totali.push('Aprile');
                    break;
                case 5:
                    mesi_totali.push('Maggio');
                    break;
                case 6:
                    mesi_totali.push('Giugno');
                    break;
                case 7:
                    mesi_totali.push('Luglio');
                    break;
                case 8:
                    mesi_totali.push('Agosto');
                    break;
                case 9:
                    mesi_totali.push('Settembre');
                    break;
                case 10:
                    mesi_totali.push('Ottobre');
                    break;
                case 11:
                    mesi_totali.push('Novembre');
                    break;
                case 12:
                    mesi_totali.push('Dicembre');
                    break;
                default:
                    break;
            }
        });
        const context_rapporto_campioni_mesi = document.getElementById('chart_rapporto_campioni_mesi').getContext('2d');
        var chart_rapporto_campioni_mesi = new Chart(context_rapporto_campioni_mesi, {
            type: 'line',
            data: {
                labels: mesi_totali,
                datasets: [{
                        label: 'Campionamenti dell\'anno attuale',
                        data: num_attuale,
                        borderColor: 'rgba(0, 188, 212, 0.75)',
                        backgroundColor: 'rgba(0, 188, 212, 0.3)',
                        pointBorderColor: 'rgba(0, 188, 212, 0)',
                        pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                        pointBorderWidth: 1,
                        
                    },{
                        label: 'Campionamenti dell\'anno precedente',
                        data: num_precedente,
                        borderColor: 'rgba(233, 30, 99, 0.75)',
                        backgroundColor: 'rgba(233, 30, 99, 0.3)',
                        pointBorderColor: 'rgba(233, 30, 99, 0)',
                        pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
                        pointBorderWidth: 1,
        
                    }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 12,
                    },
                },
                animation: {
                    onComplete: function() {
                        // imposta il link all'immagine da scaricare
                        $('#download_grafico_rapporto_campioni_mesi').attr("href", chart_rapporto_campioni_mesi.toBase64Image());
                    }
                },
                hover: {
                    mode: 'point'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            //beginAtZero: true,
                            userCallback: function(label, index, labels) {
                                // when the floored value is the same as the value we have a whole number
                                if (Math.floor(label) === label) {
                                    return label;
                                }

                            },
                        }
                    }],
                },
            }
        });

        /**
         * La funzione genera dinamicamente i colori assegnati ad ogni etichetta
         */
        function generaColoreOggetto(colori,dati_grafico_length) {
            var colore = new Array();
            for(var i = 0; i < dati_grafico_length; i++){
                colore[i] = colori[i];
                if(i > colori.length)
                {
                    break;
                }
            }
            
            return colore
        }
    }
});
</script>
@endsection
