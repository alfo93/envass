@extends('layouts.main')

@section('style')
<style>

    @media (min-width: 1200px){
        .col-lg-12 {
            width: 100%;
        }
    } 
    
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
    
    #table-filter label {
        margin-right: 30px
    }

   

</style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD
                <small>Dashboard procedure di ENVASS</small>
            </h2>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Elenco delle procedure</h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="{{ URL::action('ProceduraController@create') }}" role="button" onclick=""
                                            name="crea_nuovo" id="nuova_procedura" class=" waves-effect waves-block"
                                            value="Nuova Procedura">Nuova procedura</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table">
                            <table id="procedure_table"
                                class="table table-bordered table-striped table-hover dataTable js-exportable" role="grid"
                                aria-describedby="DataTables_Table_1_info" style="width: 100%;  height:100%;"
                                cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>
                                        <th>Titolo</th>
                                        <th>Livello</th>
                                        <th>Attività</th>
                                        <th>Data inserimento</th>
                                        <th class="file">Documento</th>
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
    <!-- modal -->
    <div class="modal fade in" id="largeModal" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">Procedura</h4>
                </div>
                <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="form-label">Titolo</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input id="note_procedura" type="text" class="form-control" name="note" minlength="3" required="" aria-required="true">
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
                                        <select class="form-control show-tick" name="id_progetto" id="id_progetto_procedura" data-size="7">
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
                                        <select class="form-control show-tick" id="livello_procedura" name="livello" data-size="7">
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
                                        <label for="carica_file" class="custom-file-upload mb-1">
                                            <span>Carica Documento</span>
                                        </label>
                                        <input class="custom-file-upload" id="carica_file" name="file" type="file" name="file"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="closeModal" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                            <input type="submit" name="modifica_procedura" id="modifica_procedura_save" class="btn btn-link waves-effect"  value="SALVA" target="_blank">
                        </div>             
                </div>
            </div>
        </div>
    </div>
    <!-- fine modal -->
@endsection

@section('script')
<script type="text/javascript">
        var table;

        $(document).ready(function() {
            /* Inizializzo la DataTable */
            table = $('#procedure_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/procedure/list",
                },
                "columns": [{
                        "data": 'note'
                    },
                    {
                        "data": 'livello'
                    },
                    {
                        "data": 'progetto'
                    },
                    {
                        "data": 'data_inserimento'
                    },
                    {
                        "data": 'documento',
                        searchable: false
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
                "columnDefs": [
                    { className: "azione", targets: [ 5 ] },
                    { className: "dt-center", targets: [4]},
                    { width: "40%", targets: [ 0 ] },
                    { width: "13%", targets: [ 1,2,3] },
                    { width: "1%", targets: [ 4 ] },
                    { width: "20%", targets: [ 5 ] },

                ],
                "drawCallback": function(settings, json) {
                    $(change);
                    $(bind_elimina);
                    $(modifica);
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
                    text: "Procedi alla cancellazione?. Ti ricordo che l'azione è irreversibile e la procedura sarà definitivamente eliminato dal sistema",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Si, procedi",
                    cancelButtonText: "No, annulla",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "/procedure/" + id,
                            type: "post",
                            dataType: "json",
                            data: {
                                id: id,
                            },
                            success: function(data) {
                                table.ajax.reload();
                                swal("Eliminato!", "La procedura è stata cancellata.","success");
                            },
                            error: function(response, stato) {
                                swal.close();
                                console.log(response);
                                console.log(stato);
                                showNotification('alert-danger', response.responseJSON.message, 'top', 'right', null, null);
                                
                            }
                        });
                    } else {
                        swal("Annullato", "L'operazione è stata annullata", "info");
                    }
                });
            });
        }

        var id = "";

        var modifica = function() {
            $('.btn-modifica').on('click', function(e) {
                e.preventDefault();
                id = $(this).prop('id');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/procedure/edit",
                    type: "get",
                    dataType: "json",
                    data: {
                        id: id,
                    },
                    success: function(returnValue) {
                        $('#note_procedura').val(returnValue['note']);
                        $('#id_progetto_procedura').val(returnValue['id_progetto']).trigger('change');
                        $('#livello_procedura').val(returnValue['livello']).trigger('change');
                    },
                    error: function(response, stato) {
                        $('#largeModal').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        showNotification('alert-danger', response.responseJSON.message, 'top', 'right', null, null);
                    }
                });
                
            });
        }

        
        $('#modifica_procedura_save').on('click',function(){
            console.log(id);
            if ($("#carica_file").prop("files")[0] != null) {
                var rawLog = "";
                var note = $('#note_procedura').val();
                var livello = $('#livello_procedura option:selected').val();
                var id_progetto = $('#id_progetto_procedura option:selected').val();
                var file = $("#carica_file").prop("files")[0];
                var nome_file = file['name'];
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(e) {
                    rawLog = reader.result;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "/procedure/" + id +"/edit",
                        type: "post",
                        dataType: "json",
                        data: {
                            id: id,
                            note: note,
                            livello: livello,
                            id_progetto: id_progetto,
                            file: rawLog,
                            filename: nome_file
                        },
                        success: function(returnValue) {
                            //table.ajax.reload();
                            $('#largeModal').modal('hide');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            if(returnValue['file'] != '')
                            {
                                $('#'+id+'_documento').attr('href','/procedure/'+returnValue['file']+'/view')
                            }
                            showNotification('alert-success', returnValue['success'] , 'top', 'right', null, null);
                        },
                        error: function(response, stato) {
                            $('#largeModal').modal('hide');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            if(response.responseJSON[1])
                            {
                                showNotification('alert-danger', response.responseJSON[1], 'top', 'right', null, null);
                            }
                            else
                            {
                                showNotification('alert-danger', response.responseJSON.message, 'top', 'right', null, null);
                            }
                        }
                    });
                };
            }
            else
            {
                var note = $('#note_procedura').val();
                var livello = $('#livello_procedura option:selected').val();
                var id_progetto = $('#id_progetto_procedura option:selected').val();                                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/procedure/" + id +"/edit",
                    type: "post",
                    dataType: "json",
                    data: {
                        id: id,
                        note: note,
                        livello: livello,
                        id_progetto: id_progetto,
                    },
                    success: function(returnValue) {
                        table.ajax.reload();
                        $('#largeModal').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        showNotification('alert-success', returnValue['success'] , 'top', 'right', null, null);
                    },
                    error: function(response, stato) {
                        showNotification('alert-danger', response.responseJSON.message, 'top', 'right', null, null);
                    }
                });
            }
        })

        var change = function() {
            $('#procedure_table_filter label').contents().eq(0).replaceWith('Filtra: ');
        }

        jQuery.event.special.touchstart = {
            setup: function( _, ns, handle ){
                if ( ns.includes("noPreventDefault") ) {
                    this.addEventListener("touchstart", handle, { passive: false });
                } else {
                    this.addEventListener("touchstart", handle, { passive: true });
                }
            }
        };

        jQuery.event.special.touchmove = {
            setup: function( _, ns, handle ){
                if ( ns.includes("noPreventDefault") ) {
                    this.addEventListener("touchmove", handle, { passive: false });
                } else {
                    this.addEventListener("touchmove", handle, { passive: true });
                }
            }
        };
</script>
@endsection
