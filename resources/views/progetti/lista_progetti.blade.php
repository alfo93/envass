<!-- Lista di Progetti -->
<div class="block-header">
    <h2>Elenco delle attività
    </h2>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Elenco delle attività in ENVASS
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ URL::action('ProgettoController@create') }}" role="button" onclick=""
                                    name="crea_nuovo" id="nuovo_progetto" class=" waves-effect waves-block"
                                    value="Nuovo progetto" target= "_blank">Nuova attività</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable Progetti_table" id="progetti_table" role="grid" aria-describedby="DataTables_Table_1_info" style="width: 100%;  height:100%;" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>Attività</th>
                                <th>Codice</th>
                                <th>Tipo</th>
                                <th>Committente</th>
                                <th>Data inizio attività</th>
                                <th>Data fine attività</th>
                                <th>Stato</th>
                                <th>Azioni</th>     
                            </tr>
                        </thead>
                        <tbody><!-- Gestito dalla DataTable AJAX --></tbody>
                    </table>
                </div>
            </div>        
        </div>
    </div>
</div>
<!-- Modal per la modifica -->
<div class="modal fade in" id="ModalModificaProgetto" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Modifica attività</h4>
            </div>
            <div class="modal-body">
                <form id="form_advanced_validation" method="POST" novalidate="novalidate">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="nome">Attività</label>
                            <input type="text" id="nome_progetto" class="form-control" name="minmaxlength" maxlength="35" minlength="3" required="" aria-required="true" value="">                                                          
                        </div>
                        <div class="help-info">Nome del attività</div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="nome">Codice attività</label>
                            <input type="text" id="codProgetto" class="form-control" name="minmaxlength" maxlength="25" minlength="3" required="" aria-required="true" value="">
                        </div>
                        <div class="help-info">Codice identificativo dell'attività</div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="tipo_progetto">Tipo</label>
                            <select class="form-control show-tick" id="tipo_progetto" name="id_societa">
                                <option value="">-- Seleziona un opzione --</option>
                                @foreach(App\Progetto::tipo() as $key => $tipo)
                                    <option value="{{ $key }}">{{ $tipo }}</option>
                                @endforeach
                            </select>     
                        </div>
                        <div class="help-info">Tipo</div>
                    </div>  
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label>Committente</label>
                            <select class="form-control show-tick" id="societa_progetto" name="id_societa">
                                <option value="">-- Seleziona un opzione --</option>
                                @foreach($societa as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                                @endforeach
                            </select>     
                        </div>
                        <div class="help-info">Committente incaricante dell'attività</div>  
                    </div> 
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="data_inizio_progetto">Data inizio progetto</label>
                            <input type="date" id="data_inizio_progetto" class="form-control" name="data_inizio_progetto" aria-required="true" placeholder="" required>
                        </div>
                        <div class="help-info">Data di inizio dell'attività</div>
                    </div>  
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" name="modifica_progetto_modal" id="modifica_progetto_modal" class="btn btn-link waves-effect"  value="Aggiungi" >SALVA</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
            </div>
        </div>
    </div>
</div>
<!--end modal-->     

<!--modal-->
<div class="modal fade in" id="deleteModal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="deleteModalLabel">Elimina attività</h4>
            </div>
            <div class="modal-body">
                <form id="form_advanced_validation" method="POST" novalidate="novalidate">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="nome">Motivo</label>
                            <input type="text" id="progettoMotivo" class="form-control" name="minmaxlength" required="" aria-required="true" value="">                                                          
                        </div>
                        <div class="help-info">Motivo dell'eliminazione</div>
                    </div>                            
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="elimina_progetto_salva" name="elimina_progetto_salva" class="btn btn-link waves-effect" tipo="" >SALVA</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
            </div>
        </div>
    </div>
</div>
<!--end modal-->

@section('script')
<script type="text/javascript">
    var table;
    $(document).ready(function () {

        /* Initializzo la DataTable */
        table = $('#progetti_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/progetti/list",
            },
            "columns" : [
                { "data" : 'progetto', orderable: false},
                { "data" : 'CodPro' },
                { "data" : 'tipo' }, 
                { "data" : 'societa' },
                { "data" : 'data_inizio_progetto' },
                { "data" : 'data_fine_progetto' },
                { "data" : 'attivo' },
                { "data" : 'azione', orderable: false, searchable: false}
            ],
            "lengthMenu": [25, 50, 100, 200],
            "pageLength": 25,
            "order": [[ 3, "desc" ]],
            "language": {
                "url": "{!! url('vendor/datatables/Italian.json') !!}"
            },
            "columnDefs": [
                { className: "azione", targets: [ 7 ] },
                { width: 50, targets: [ 1, 6 ] },
                { width: 100, targets: [ 0, 2, 3 ] },
                { width: 150, targets: [ 4, 5 ] },
                { width: 150, targets: [ 7 ] }
            ],
            "drawCallback":function( settings, json) {
                //console.log('drawCallback');
                $(bind_elimina);
                //$(checkPermission);
                $(change);
                $(getDati);
                //$(filtra);
            },
            "initComplete":function( settings, json) {
                // Ultima ad essere chiamata
                //console.log('initComplete');
                $('.dataTables_length select.form-control').addClass('ms'); // Aggiungo la classe ms per evitare che la select si scombini
                $.AdminBSB.select.refresh();    // Rilancio l'attivatore del plugin selectpicker
            },
            
        });

        /** 
        * Bind del bottone Elimina
        */
        var bind_elimina = function() {
            $('.button-elimina').on('click',function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                $('#elimina_progetto_salva').on('click',function(){
                    var motivo = $('#progettoMotivo').val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    swal({
                        title: "Sei sicuro?",
                        text: "Sei sicuro di voler eliminare il progetto?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Si, procedi",
                        confirmButtonColor: "#DD6B55",
                        cancelButtonText: "No, annulla",
                        closeOnConfirm: true,
                        closeOnCancel: true,
                    }, function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: "/progetti/"+id,
                                type: "POST",
                                dataType: "json",
                                data: {
                                    id:id,
                                    motivo: motivo
                                },
                                success: function(returnValue) {
                                    $('#deleteModal').modal('hide');
                                    table.ajax.reload();
                                    showNotification('alert-success',"Attività eliminata correttamente", 'top', 'right', null, null);
                                }, 
                                error: function(response, stato) {
                                    $('#deleteModal').modal('hide');
                                    showNotification('alert-danger',response['responseJSON']['messaggio'], 'top', 'right', null, null);
                                }
                            });
                        }
                    });
                })   
            });
        }
    });

    var getDati = function() {
        $('.modifica_button').on('click',function(event){
            event.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
                url: "/progetti/"+id,
                type: "get",
                dataType: "json",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id
                },
                success: function(data) {
                    $('#nome_progetto').val(data['nome_progetto']);
                    $('#codProgetto').val(data['codProgetto']);
                    $('#tipo_progetto').val(data['tipo_progetto']);
                    $('#tipo_progetto').trigger('change');
                    $('#societa_progetto').val(data['societa_progetto']);
                    $('#societa_progetto').trigger('change');
                    $('#data_inizio_progetto').val(data['data_inizio_progetto']);
                    $('#attivo').val(data['attivo']);
                    $('#attivo').trigger('change');

                    $('#modifica_progetto_modal').on('click',function(){
                        var nome_progetto = $('#nome_progetto').val();
                        var codProgetto = $('#codProgetto').val();
                        var tipo_progetto = $('#tipo_progetto option:selected').text();
                        var societa_progetto = $('#societa_progetto option:selected').val();
                        var data_inizio_progetto = $('#data_inizio_progetto').val();
                        var attivo = $('#attivo option:selected').val();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        swal({
                            title: "Sei sicuro?",
                            text: "Sei sicuro di voler modificare il progetto?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Si, procedi",
                            confirmButtonColor: "#8CD4F5",
                            cancelButtonText: "No, annulla",
                            closeOnConfirm: true,
                            closeOnCancel: true,
                        }, function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    url: "/progetti/"+id+"/modifica",
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        id:id,
                                        progetto: nome_progetto,
                                        CodPro: codProgetto,
                                        tipo: tipo_progetto,
                                        id_societa: societa_progetto,
                                        data_inizio_progetto: data_inizio_progetto,
                                        attivo: attivo
                                    },
                                    success: function(returnValue) {
                                        if(returnValue == "Errore, progetto non trovato")
                                        {
                                            showNotification('alert-danger',returnValue, 'top', 'right', null, null);
                                        }
                                        $('#ModalModificaProgetto').modal('hide');
                                        $('body').removeClass('modal-open');
                                        $('.modal-backdrop').remove();
                                        table.ajax.reload();
                                        showNotification('alert-success','L\'attività è stata modificata correttamente', 'top', 'right', null, null);
                                    }, 
                                    error: function(response, stato) {
                                        $('#ModalModificaProgetto').modal('hide');
                                        $('body').removeClass('modal-open');
                                        $('.modal-backdrop').remove();
                                        showNotification('alert-danger',"Si è verificato un problema con la modifica dell\'attività, riprovare", 'top', 'right', null, null);
                                    }
                                });
                            }
                        });
                    });
                }, 
                error: function(response, stato) {
                    console.log(response);
                }
            });
        })

        
    }
    
    

    var change = function(){
        $('#progetti_table_filter label').contents().eq(0).replaceWith('Filtro:');
        //  add hidden class to lable and input
        $('#progetti_table_filter label').addClass('hidden');
        $('#progetti_table_filter input').addClass('hidden');
    }

    $('#cancel_motivo_annullamento').change(function(){
        if ($('#cancel_motivo_annullamento').val()) {
            $('#delete_referto').prop('disabled', false);
        } else {
            $('#delete_referto').prop('disabled', true);
        }
    });

    //grafico rapporto campioni mesi
    const progetti_campioni = {!! json_encode($progetti_campioni) !!};
    const palette = {!! json_encode($palette_colori) !!};
    const palette_bg = {!! json_encode($palette_colori_bg) !!};
    const palette_bg_point = {!! json_encode($palette_colori_bg_point) !!};

    label_progetti = [];
    var tot_mesi = [];
    progetti_campioni.forEach((progetti) => {
        label_progetti.push(progetti['nome_progetto'])
        tot_mesi.push(progetti['totale_mesi'])
    })
    var month_progetti = [];
    var num_progetti = [];
    var somma_campioni = [];
    var dataset_value = [];
    var j = 0;
    var count = 0;

    console.log(tot_mesi);

    tot_mesi.forEach((element) => {
        count = 0
        num_progetti = [];
        while(count < element.length) {
            month_progetti.push(element[count].mesi);
            num_progetti.push(element[count].totale);
            somma_campioni.push(element[count].mesi);
            count++;
        }
        name = progetti_campioni[j]['nome_progetto'];
        dataset_value[name] = num_progetti;
        j++;
    })
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

    const context_rapporto_campioni_tipoProgetto = document.getElementById('chart_rapporto_campioni_tipoProgetto').getContext('2d');
    var chart_rapporto_campioni_tipoProgetto = new Chart(context_rapporto_campioni_tipoProgetto, {
        type: 'line',
        data: {
            labels: monthNames,
            datasets: [], 
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
                    $('#download_grafico_rapporto_campioni_tipoProgetto').attr("href", chart_rapporto_campioni_tipoProgetto.toBase64Image());
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
    
    for(var i = 0; i < label_progetti.length; i++)
    {
        
        var newDataset = {
            label: label_progetti[i],
            data: dataset_value[label_progetti[i]],
            borderColor: palette[i],
            backgroundColor: palette_bg[i] ,
            pointBorderColor: 'rgba(0, 188, 212, 0)',
            pointBackgroundColor: palette_bg_point[i],
            pointBorderWidth: 1,
        }
        chart_rapporto_campioni_tipoProgetto.data.datasets.push(newDataset);
        chart_rapporto_campioni_tipoProgetto.update();
    }
    

   
</script>
@endsection