<!-- Filtro tipo -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Filtra schede campionamenti</h2>
            </div>
            <div class="body">            
                <h2 class="card-inside-title">
                    Seleziona le schede da visualizzare
                </h2>
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div id="table-filter" class="switch">
                            <input name="group1" value="campioni" type="radio" id="radio_30" class="with-gap radio-col-blue" checked="">
                            <label for="radio_30">Piastre e Tamponi</label>
                            <input name="group1" value="analisimolecolari" type="radio" id="radio_32" class="with-gap radio-col-blue">
                            <label for="radio_32">Analisi Molecolari</label>
                            <input name="group1" value="bianco" type="radio" id="radio_33" class="with-gap radio-col-blue">
                            <label for="radio_33">Scheda bianco</label>
                            <input name="group1" value="qualita" type="radio" id="radio_34" class="with-gap radio-col-blue">
                            <label for="radio_34">Scheda qualità</label>
                        </div>
                    </div>
                </div>                  
            </div>
        </div>
    </div>
</div>

<!-- Lista di schede campionamenti -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Elenco delle schede campionamento
                </h2>
                @shield('campioni.store')
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ URL::action('CampioneController@create',['campagna_id' => $campagna->id, 'tipo' => 'N']) }}" onclick="" name="crea_nuovo" id="crea_nuovo" class=" waves-effect waves-block" value="Nuova Scheda" target="_blank">Nuova scheda</a></li>
                            <li><a href="{{ URL::action('CampioneAnalisiMolecolareController@create', $campagna->id) }}" onclick="" name="crea_nuovo_molecolari" id="crea_nuovo_molecolari" class=" waves-effect waves-block" value="Nuova Scheda Analisi Molecolari" target="_blank">Nuova scheda Analisi Molecolari</a></li>
                            <li><a href="{{ URL::action('CampioneController@create',['campagna_id' => $campagna->id, 'tipo' => 'B']) }}" onclick="" name="crea_nuovo_bianco" id="crea_nuovo_bianco" class=" waves-effect waves-block" value="Nuova Scheda Bianco" target="_blank">Nuova scheda Bianco</a></li>
                            <li><a href="{{ URL::action('CampioneController@create',['campagna_id' => $campagna->id, 'tipo' => 'Q']) }}" onclick="" name="crea_nuovo_qualita" id="crea_nuovo_qualita" class=" waves-effect waves-block" value="Nuova Scheda Qualita" target="_blank">Nuova scheda Qualità</a></li>
                        </ul>
                    </li>
                </ul>
                @endshield
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable campionamenti_table" id="campionamenti_table" role="grid" aria-describedby="DataTables_Table_1_info" style="width: 100%;  height:100%;" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>Campione N°</th>
                                <th>Struttura</th>
                                <th>Partizione</th>
                                <th>Area Partizione</th>
                                <th>Data campionamento</th>
                                <th>Matrice</th>
                                <th>Punto di campionamento</th>
                                <th>Terreno</th>
                                <th>Stanza</th>
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

@section('script')
<script type="text/javascript">
    var table;
    var id_campagna = $('.id_campagna').attr('id_campagna');

    $(document).ready(function () {
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
        

        /* Initializzo la DataTable */
        table = $('#campionamenti_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/campioni/list/"+id_campagna+"/campioni",
            },
            "columns" : [
                { "data" : 'id' },
                { "data" : 'struttura', orderable: false },
                { "data" : 'reparto', orderable: false },
                { "data" : 'area', orderable: false },
                { "data" : 'dataCampionamento', render: function(data, type, row) {
                        return moment(data).format("DD/MM/YYYY");
                    }
                },
                { "data" : 'tipoCamp', orderable: false },
                { "data" : 'puntoCamp', orderable: false },
                { "data" : 'tipoPiastra', orderable: false },               
                // { "data" : 'dataFineProva', render: function(data, type, row) {
                //         return data ? moment(data).format("DD/MM/YYYY") : '';
                //     } 
                // },
                { "data" : 'stanza'},
                // { "data" : 'rilevatore', orderable: false, searchable: false},
                { "data" : 'azione', orderable: false, searchable: false}
            ],
            "lengthMenu": [25, 50, 100, 200],
            "pageLength": 25,
            "order": [[ 0, "desc" ]],
            "language": {
                "url": "{!! url('vendor/datatables/Italian.json') !!}"
            },
            "columnDefs": [
                { className: "azione", targets: [ 9 ] },
                { className: "id_campione", targets: [ 0 ]},
                { width: 100, targets: [ 0, 2, 3, 5, 7, 8 ] },
                { width: 200, targets: [ 1,6 ] },
                { width: 50, targets: [ 4 ] },

            ],
            "drawCallback":function( settings, json) {
                //console.log('drawCallback');
                $(bind_elimina);
                $(checkPermission);
                $(change);
                //$(filtra);
            },
            "initComplete":function( settings, json) {
                // Ultima ad essere chiamata
                //console.log('initComplete');
                $('.dataTables_length select.form-control').addClass('ms'); // Aggiungo la classe ms per evitare che la select si scombini
                $.AdminBSB.select.refresh();    // Rilancio l'attivatore del plugin selectpicker
            },
            
        });

        /* Filtro del contenuto della DataTable in base al tipo di Campione */
        $('#table-filter input').change(function(){ 
            var check = $(this).val();
            table.ajax.url("/campioni/list/"+id_campagna+"/"+check).load();
        });

        /* Search nella DataTable custom */
        /*$('#search-input').keyup(function(){
            table.search($(this).val()).draw();
        });*/

        
    });

    var change = function(){
        $('#campionamenti_table_filter label').contents().eq(0).replaceWith('Filtro:');
        //$('#referti_table_filter input').addClass('filtro');
    }

    /** 
     * Bind del bottone Elimina
     */
    var bind_elimina = function() {
            $('.btn-elimina').bind('click', function(event) {
            event.preventDefault();
            var id = $(this).attr('id');
            var checkpath = $('#radio_31').is(':checked') ? '/campionianalisimolecolare/' : '/campioni/';
            swal({
                title: "Sei sicuro?",
                text: "Vuoi eliminare la seguente scheda? La seguente azione non è reversibile",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, procedi",
                cancelButtonText: "No, annulla",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: checkpath+id+"/delete",
                        type: "POST",
                        dataType: "json",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            id: id
                        },
                        success: function(data) {
                            //location.reload(true);
                            table.ajax.reload();
                        }, 
                        error: function(response, stato) {
                            console.log(response);
                        }
                    });
                } else {
                    swal("Annullato", "L'operazione è stata annullata", "info");
                }
            });
        });
    }

    function checkPermission() {
        var ruolo = $('.role').attr('id');
        if(ruolo.localeCompare("admin")) { //if non è admin then
            // $('.btn-elimina').attr('title','Non possiedi i permessi per eseguire quest\'azione');
            // $('.btn-elimina').addClass('bg-grey')
            // $('.btn-elimina').removeClass('btn-danger');
            // $('.btn-elimina').removeClass('btn-elimina');
            // $('.button-elimina').attr('data-target','#');
            $('.btn-elimina').addClass('hidden');
        }
    }
</script>
@endsection