@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD
                <small>Dashboard utenti di ENVASS</small>
            </h2>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Elenco degli utenti</h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="{{ URL::action('UserController@create') }}" role="button" onclick=""
                                            name="crea_nuovo" id="nuovo_utente" class=" waves-effect waves-block"
                                            value="Nuovo Utente">Nuovo utente</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table">
                            <table id="utenti_table"
                                class="table table-bordered table-striped table-hover dataTable js-exportable" role="grid"
                                aria-describedby="DataTables_Table_1_info" style="width: 100%;  height:100%;"
                                cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>
                                        <th>uid</th>
                                        <th>Nome</th>
                                        <th>Cognome</th>
                                        <th>Email</th>
                                        <th>Ruolo</th>
                                        <th>Diritti</th>
                                        <th>Gestione</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Gestito dalla DataTable AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var table;

        $(document).ready(function() {
            /* Inizializzo la DataTable */
            table = $('#utenti_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/utenti/list",
                },
                "columns": [{
                        "data": 'uid'
                    },
                    {
                        "data": 'nome'
                    },
                    {
                        "data": 'cognome'
                    },
                    {
                        "data": 'email'
                    },
                    {
                        "data": 'ruolo',
                    },
                    {
                        "data": 'diritti',
                    },
                    {
                        "data": 'pulsante',
                        searchable: false,
                        "orderable": false
                    },

                ],
                "lengthMenu": [25, 50, 100, 200],
                "pageLength": 25,
                "order": [
                    [0, "desc"]
                ],
                "language": {
                    "url": "{!! url('vendor/datatables/Italian.json') !!}"
                },
                "columnDefs": [{
                        width: 50,
                        targets: [0]
                    },
                    {
                        width: 50,
                        targets: [1]
                    },
                    {
                        width: 50,
                        targets: [2]
                    },
                    {
                        width: 100,
                        targets: [3]
                    },
                    {
                        width: 25,
                        targets: [4]
                    },
                    {
                        width: 25,
                        targets: [5]
                    },
                    {
                        width: 125,
                        targets: [6]
                    },
                ],
                "drawCallback": function(settings, json) {
                    $(change);
                    $(bind_elimina);
                },
                "initComplete": function(settings, json) {
                    // Ultima ad essere chiamata
                    //console.log('initComplete');
                    $('.dataTables_length select.form-control').addClass(
                    'ms'); // Aggiungo la classe ms per evitare che la select si scombini
                    $.AdminBSB.select.refresh(); // Rilancio l'attivatore del plugin selectpicker
                },
            });
        });

        /** 
         * Bind del bottone Elimina
         */
        var bind_elimina = function() {
            $('.btn-elimina').bind('click', function(event) {
                event.preventDefault();
                var id = $(this).attr('id');
                swal({
                    title: "Sei sicuro?",
                    text: "Procedi alla cancellazione dell'utente?. Ti ricordo che l'azione è irreversibile e l'utente sarà definitivamente eliminato dal sistema",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Si, procedi",
                    cancelButtonText: "No, annulla",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: "/utenti/" + id + "/delete",
                            type: "post",
                            dataType: "json",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                id: id,
                            },
                            success: function(data) {
                                table.ajax.reload();
                                swal("Eliminato!", "L'utente è stato cancellato.",
                                    "success");
                            },
                            error: function(response, stato) {
                                showNotification('alert-danger', response.responseJSON.error, 'top', 'right', null, null);
                            }
                        });
                    } else {
                        swal("Annullato", "L'operazione è stata annullata", "info");
                    }
                });
            });
        }

        var change = function() {
            $('#utenti_table_filter label').contents().eq(0).replaceWith('Cerca utenti: ');
            //add hidden class
            $('#utenti_table_filter label').addClass('hidden');
            $('#utenti_table_filter input').addClass('hidden');
        }
    </script>
@endsection
