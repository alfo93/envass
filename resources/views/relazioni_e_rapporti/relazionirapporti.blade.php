
<!-- Lista di schede campionamenti -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Relazioni e rapporti di prova
                </h2>
                @shield('rapp_rel.store')
                {{-- <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ URL::action('RapportoRelazioneController@create') }}" name="crea_relazionerapporto" id="crea_relazionerapporto" class=" waves-effect waves-block" value="Upload nuovo documento">Upload nuovo documento</a></li>
                            <li><a href="{{ URL::action('CampioneController@createRapportoProva') }}" onclick="" name="crea_rapporto_prova" id="crea_rapporto_prova" class=" waves-effect waves-block" value="Crea Rapporto di Prova" target="_blank">Crea rapporto di prova</a></li>
                        </ul>
                    </li>
                </ul> --}}
                @endshield
            </div>
            <div class="body">
                <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable relazionirapporti_table" id="relazionirapporti_table" role="grid" aria-describedby="DataTables_Table_1_info" style="width: 100%;  height:100%;" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>Data Campagna</th>
                                <th>Attività</th>
                                <th>Struttura</th>
                                <th>Partizione</th>
                                <th>Tipo</th>
                                <th class="file">File</th> 
                                <th>Note</th>
                                @shield('rapp_rel.sendEmail')    
                                    <th>Azioni</th>
                                @endshield     
                            </tr>
                        </thead>
                        <tbody><!-- Gestito dalla DataTable AJAX --></tbody>
                    </table>
                </div>
            </div>        
        </div>
    </div>
</div>

<!--modal-->
<div class="modal fade in" id="deleteModal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="deleteModalLabel">Specificare il motivo per cui si vuole eliminare il rapporto o la relazione seguente</h4>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                        <label for="" id="deleteModalLabel">Motivo: </label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                        <div class="form-group">
                            <div class="form-line focused">
                                <input type="text" class="form-control" id="cancel_motivo_annullamento" name="cancel_motivo_annullamento">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="cancella_elemento" id="cancella_elemento" class="btn btn-link waves-effect elimina_modal">CONFERMA</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id="approvaModal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="approvaModalLabel">Approvazione rapporto di prova</h4>
            </div>
            <div class="modal-body">
                <div class="row clearfix mt-2">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div id="approvazione" name="approvazione">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <label for="approvazione">Approvato: </label> 
                            </div>
                            <div class="form-group">
                                <input type="radio" name="approvato" id="si_approvazione" class="with-gap" value="si">
                                <label for="si_approvazione" class="m-l-30 mb-1" ><b>Si</b></label>

                                <input type="radio" name="approvato" id="no_approvazione" class="with-gap" value="no">
                                <label for="no_approvazione" class="m-l-20 mb-1"><b>No</b></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix hidden" id="mancata_approvazione">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                        <label for="" id="approvaModalLabel">Motivo: </label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                        <div class="form-group">
                            <div class="form-line focused">
                                <textarea style="background-color: #a1b6c07b;" id="motivo_mancata_approvazione" name="motivo_mancata_approvazione" rows="5" class="form-control no-resize" style="min-height: 70px;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="approva_elemento" id="approva_elemento" class="btn btn-link waves-effect approva_modal">CONFERMA</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
            </div>
        </div>
    </div>
</div>

<!--end modal--> 

@is(['admin','gestore'])
@section('script')
<script type="text/javascript">
    var table;

    $(document).ready(function () {
        let data = moment(new Date()).format("YYYY-MM-DD");
        let cl = console.log;
        // imposta lo sfondo di colore bianco nei grafici da scaricare come immagini
        const backgroundColor = 'white';
        /* Initializzo la DataTable */
        table = $('#relazionirapporti_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/rapprel/list/tutti/tutti/tutti", // /rapprel{function}{progetto}{struttura}{reparto}
            },
            "columns" : [
                { "data" : 'dataCampagna', render: function(data, type, row) {
                        return moment(data).format("DD/MM/YYYY");
                    }
                },
                { "data" : 'progetto' },
                { "data" : 'struttura' },
                { "data" : 'reparto' },
                { "data" : 'tipo', orderable: false },
                { "data" : 'file', orderable: false, searchable: false },
                { "data" : 'note', orderable: false },
                { "data" : 'azione', orderable: false, searchable: false }

            ],
            "lengthMenu": [25, 50, 100, 200],
            "pageLength": 25,
            "order": [[ 0, "desc" ]],
            "language": {
                "url": "{!! url('vendor/datatables/Italian.json') !!}"
            },
            "columnDefs": [
                { className: "azione", targets: [ 7 ] },
                { width: 50, targets: [ 0,1,2,3,4,5,6 ] },
                { width: 225, targets: [ 7 ] },
            ],
            "drawCallback":function( settings, json) {
                //console.log('drawCallback');
                //$(filtra);
                $(bind_elimina);
                $(change);
                $(sendmail);
                $(sendmail_dir);
                $(approva);
                $(firmaDirettore);
                $(firmaResponsabile);
                $(annullaFirmaDirettore);
                $(annullaFirmaResponsabile);
            },
            "initComplete":function( settings, json) {
                // Ultima ad essere chiamata
                //console.log('initComplete');
                $('.dataTables_length select.form-control').addClass('ms'); // Aggiungo la classe ms per evitare che la select si scombini
                $.AdminBSB.select.refresh();    // Rilancio l'attivatore del plugin selectpicker
            },
            
        });

        /* Search nella DataTable custom */
        /*$('#search-input').keyup(function(){
            table.search($(this).val()).draw();
        });*/

        /** 
         * Bind del bottone Elimina
         */
        var bind_elimina = function() {
            $('.btn-elimina').bind('click', function(event) {
                event.preventDefault();
                var id = $(this).attr('id');
                var bloccato = $(this).attr('bloccato');
                var messaggio = "";
                $('#cancella_elemento').on('click',function(){
                    if(bloccato == 1)
                    {
                        messaggio = "Procedi alla cancellazione? Tale documento è stato inviato al committente e ti ricordo che l'azione è irreversibile e il documento sarà definitivamente eliminato dal sistema";
                    }
                    else
                    {
                        messaggio = "Procedi alla cancellazione?. Ti ricordo che l'azione è irreversibile e il documento sarà definitivamente eliminato dal sistema";
                    }
                    swal({
                        title: "Sei sicuro?",
                        text: messaggio,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Si, procedi",
                        cancelButtonText: "No, annulla",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    }, 
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: "/rapprel/" + id,
                                type: "post",
                                dataType: "json",
                                data: {
                                    id: id,
                                },
                                success: function(data) {
                                    table.ajax.reload();
                                    $('#deleteModal').modal('hide');
                                    $('#deleteModal').hide();
                                    $('body').removeClass('modal-open');
                                    $('.modal-backdrop').remove();
                                    swal("Eliminato!", "Il documento è stato cancellato.","success");
                                },
                                error: function(response, stato) {
                                    swal.close();
                                    $('#deleteModal').modal('hide');
                                    $('#deleteModal').hide();
                                    $('body').removeClass('modal-open');
                                    $('.modal-backdrop').remove();
                                    showNotification('alert-danger', response.responseJSON.message, 'top', 'right', null, null);
                                    
                                }
                            });
                            } else {
                                swal("Annullato", "L'operazione è stata annullata", "info");
                            }
                        });
                    })
                 
            });
        }

        /** 
         * Bind del bottone Elimina
         */
         var approva = function() {
            $('.btn-approva').bind('click', function(event) {
                event.preventDefault();
                $('#motivo_mancata_approvazione').val("");
                var id = $(this).attr('id_rapprel');
                console.log(id);
                var bloccato = $(this).attr('bloccato');
                var motivo = "";
                var messaggio = "Stai notificando al tecnico cias che ha generato il rapporto di prova l'approvazione finale. Vuoi procedere?"
                
                $('#approva_elemento').on('click',function(){
                    var approvazione = $('#si_approvazione').is(':checked') ? 'si' : 'no';
                    if(approvazione == 'no')
                    {
                        motivo = $('#motivo_mancata_approvazione').val();
                        messaggio = "Stai notificando al tecnico cias che ha generato il rapporto di prova la mancata approvazione. Vuoi procedere?"
                    }
                    if(approvazione == 'no' && (motivo == '' || motivo == null))
                    {
                        text = 'Specificare il motivo della mancata approvazione.'
                        showNotification('alert-danger', text, 'top', 'right', null, null);
                        return;
                    }
                    swal({
                        title: "Sei sicuro?",
                        text: messaggio,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#8CD4F5",
                        confirmButtonText: "Si, procedi",
                        cancelButtonText: "No, annulla",
                        closeOnConfirm: false,
                        closeOnCancel: false,
                        showLoaderOnConfirm: true,
                    }, 
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: "/rapprel/" + id + "/sendemail/approva",
                                type: "post",
                                dataType: "json",
                                data: {
                                    id: id,
                                    approvazione: approvazione,
                                    motivo: motivo
                                },
                                success: function(data) {
                                    $('#approvaModal').modal('hide');
                                    $('#approvaModal').hide();
                                    $('body').removeClass('modal-open');
                                    $('.modal-backdrop').remove();
                                    swal("Inviato!", "La mail è stata invaita con successo","success");
                                },
                                error: function(response, stato) {
                                    swal.close();
                                    $('#approvaModal').modal('hide');
                                    $('#approvaModal').hide();
                                    $('body').removeClass('modal-open');
                                    $('.modal-backdrop').remove();
                                    showNotification('alert-danger', response.responseJSON.message, 'top', 'right', null, null);  
                                }
                            });
                            } else {
                                swal("Annullato", "L'operazione è stata annullata", "info");
                            }
                        });
                    })
                 
            });
        }

        // invio della mail di approvazione alla dir
        var sendmail_dir = function()
        {
            $('.btn-spediscimaildir').on('click',function(){
                var id_progetto = $(this).attr('id_progetto');
                var id = $(this).attr('id_rapprel');
                swal({
                    title: "Sei sicuro?",
                    text: "Stai effettuando l'invio del rapporto di prova alla dir ai fini di approvazione, procedi?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#8CD4F5",
                    confirmButtonText: "Si, procedi",
                    cancelButtonText: "No, annulla",
                    closeOnConfirm: false,
                    closeOnCancel: false,
                    showLoaderOnConfirm: true,
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "/rapprel/" + id + "/sendemail/dir",
                            type: "post",
                            dataType: "json",
                            data: {
                                id: id,
                                id_progetto:id_progetto
                            },
                            success: function(data) {
                                swal("Inviato!", "La mail è stata invaita con successo","success");
                            },
                            error: function(response, stato) {
                                swal.close();
                                showNotification('alert-danger', response.responseJSON.message, 'top', 'right', null, null);
                                
                            }
                        });
                    } else {
                        swal("Annullato", "L'operazione è stata annullata", "info");
                    }
                });
            })
        }

        // invio della mail del rapporto di prova al committente
        var sendmail = function()
        {
            $('.btn-spediscimail').on('click',function(){
                var id_progetto = $(this).attr('id_progetto');
                var id = $(this).attr('id_rapprel');
                swal({
                    title: "Sei sicuro?",
                    text: "Procedi all'invio dell'email?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#8CD4F5",
                    confirmButtonText: "Si, procedi",
                    cancelButtonText: "No, annulla",
                    closeOnConfirm: false,
                    closeOnCancel: false,
                    showLoaderOnConfirm: true,
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "/rapprel/" + id + "/sendemail/committente",
                            type: "post",
                            dataType: "json",
                            data: {
                                id: id,
                                id_progetto:id_progetto
                            },
                            success: function(data) {
                                swal("Inviato!", "La mail è stata invaita con successo","success");
                            },
                            error: function(response, stato) {
                                swal.close();
                                showNotification('alert-danger', response.responseJSON.message, 'top', 'right', null, null);
                                
                            }
                        });
                    } else {
                        swal("Annullato", "L'operazione è stata annullata", "info");
                    }
                });
            })
        }
    });

    var change = function(){
        //$('#relazionirapporti_table_filter label').contents().eq(0).replaceWith('Filtro:');
        //$('#referti_table_filter input').addClass('filtro');
        $('#relazionirapporti_table_filter').addClass('hidden');
    }

   
    $('#societa_relazionirapporti').on('change',function(){
        var id_societa = $(this).val();
        var progetto = $('#progetto_relazionirapporti option:selected').val();
        var struttura = $('#struttura_relazionirapporti option:selected').val();
        var reparto = $('#reparto_relazionirapporti option:selected').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/campagna/"+id_societa+"/getData",
            type: "GET",
            dataType: "json",
            data: {
                id_societa: id_societa
            },
            success: function(returnValue) {
                replace_options_progetti($('#progetti_relazionirapporti'),$('#progetti_relazionirapporti').prev("div"),returnValue['progetti']);
                id_progetto = $('#progetti_relazionirapporti').val();
                id_societa = $('#societa_relazionirapporti').val();
            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });

    $('#progetti_relazionirapporti').on('change',function(){
        var id_progetto = $(this).val();
        var id_societa = $('#societa_relazionirapporti option:selected').val();
        var struttura = $('#struttura_relazionirapporti option:selected').val();
        var reparto = $('#reparto_relazionirapporti option:selected').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/campagna/"+id_progetto+"/"+id_societa+"/getStruttureProgetto",
            type: "GET",
            dataType: "json",
            data: {
                id_progetto: id_progetto,
                id_societa: id_societa
            },
            success: function(returnValue) {
                replace_options_strutture($('#struttura_relazionirapporti'),$('#struttura_relazionirapporti').prev("div"),returnValue['tot_strutture']);
                id_progetto = $('#progetti_relazionirapporti').val();
                id_societa = $('#societa_relazionirapporti').val();
                struttura = $('#struttura_relazionirapporti').val();
                reparto = $('#reparto_relazionirapporti').val();
                table.ajax.url( "/rapprel/list/"+id_progetto+"/"+struttura+"/"+reparto).load();
                $('#struttura_relazionirapporti').val('tutti').change();
                //$('#struttura_relazionirapporti').trigger('change');
                $('#reparto_relazionirapporti').val('tutti').change();
                //$('#reparto_relazionirapporti').trigger('change');

            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });

    $('#struttura_relazionirapporti').on('change',function(){
        var id_progetto = $('#progetti_relazionirapporti option:selected').val();
        var id_societa = $('#societa_relazionirapporti option:selected').val();
        var struttura = $(this).val();
        var reparto = $('#reparto_relazionirapporti option:selected').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/campagna/"+id_societa+"/"+id_progetto+"/"+struttura+"/getStruttureReparti",
            type: "GET",
            dataType: "json",
            data: {
                id_progetto: id_progetto,
                struttura: struttura
            },
            success: function(returnValue) {
                replace_options_reparti($('#reparto_relazionirapporti'),$('#reparto_relazionirapporti').prev("div"),returnValue['tot_reparti']);
               
                id_progetto = $('#progetti_relazionirapporti option:selected').val();
                id_societa = $('#societa_relazionirapporti option:selected').val();
                struttura = $('#struttura_relazionirapporti option:selected').val();
                reparto = $('#reparto_relazionirapporti option:selected').val();
               table.ajax.url("/rapprel/list/"+id_progetto+"/"+struttura+"/"+reparto).load();
                $('#reparto_relazionirapporti').val('tutti').change();
                //$('#reparto_relazionirapporti').trigger('change');
               table.ajax.url("/rapprel/list/"+id_progetto+"/"+struttura+"/"+reparto).load();
            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });

    $('#reparto_relazionirapporti').on('change',function(){
        var id_progetto = $('#progetti_relazionirapporti option:selected').val();
        var id_societa = $('#societa_relazionirapporti option:selected').val();
        var struttura = $('#struttura_relazionirapporti option:selected').val();
        var reparto = $('#reparto_relazionirapporti option:selected').val();

       table.ajax.url("/rapprel/list/"+id_progetto+"/"+struttura+"/"+reparto).load();    
    });


    function replace_options_strutture(select,dropdownSelect,array)
    {
        $(select).empty();
        $(dropdownSelect).children().empty();
        if(array.length == 0)
        {
            let newOption = new Option('-- Non sono presenti strutture --', 'tutti');
            $(select).append(newOption);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti strutture -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti strutture --');
            $(dropdownSelect).children().append(liOption);
        }
        else
        {
            let tutti = new Option('-- Seleziona un\'opzione --','tutti');
            $(select).append(tutti);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Seleziona un\'opzione -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Seleziona un\'opzione --');
            $(dropdownSelect).children().append(liOption);

            $.each(array, function (i, item) {
                i = i+1;
				let newOption = new Option(item.struttura, item.id);
				$(select).append(newOption);
				let liOption;
				liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.struttura+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
				$(dropdownSelect).children().append(liOption);
		    });
        }
    }

    function replace_options_reparti(select,dropdownSelect,array)
    {
        $(select).empty();
        $(dropdownSelect).children().empty();
        if(array.length == 0)
        {
            let newOption = new Option('-- Non sono presenti reparti --', 'tutti');
            $(select).append(newOption);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti reparti -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti reparti --');
            $(dropdownSelect).children().append(liOption);
        }
        else
        {
            let tutti = new Option('-- Seleziona un\'opzione --','tutti');
            $(select).append(tutti);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Seleziona un\'opzione -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Seleziona un\'opzione --');
            $(dropdownSelect).children().append(liOption);

            $.each(array, function (i, item) {
                i = i+1;
                let newOption = new Option(item.reparto, item.id);
                $(select).append(newOption);
                let liOption;
                liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.reparto+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
                $(dropdownSelect).children().append(liOption);
            });
        }
    }

    function replace_options_progetti(select,dropdownSelect,array)
    {
        $(select).empty();
        $(dropdownSelect).children().empty();
        if(array.length == 0)
        {
            let newOption = new Option('-- Non sono presenti progetti --', 'tutti');
            $(select).append(newOption);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti progetti -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti progetti --');
            $(dropdownSelect).children().append(liOption);
        }
        else
        {
            let tutti = new Option('-- Seleziona un\'opzione --','tutti');
            $(select).append(tutti);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Seleziona un\'opzione -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Seleziona un\'opzione --');
            $(dropdownSelect).children().append(liOption);

            $.each(array, function (i, item) {
                i = i+1;
                let newOption = new Option(item.progetto, item.id);
                $(select).append(newOption);
                let liOption;
                liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.progetto+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
                $(dropdownSelect).children().append(liOption);
            });
        }
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

    var firmaDirettore = function()
    {
        $('.btn-firma-direttore').on('click',function(){
            var id_rapprel = $(this).attr('id_rapprel');
            var amministratore = 'direttore';
            var azione = 'aggiungi';
            swal({
                title: "Sei sicuro?",
                text: "Stai firmando il rapporto di prova, vuoi procedere?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, procedi",
                confirmButtonColor: "#8CD4F5",
                cancelButtonText: "No, annulla",
                closeOnConfirm: true,
                closeOnCancel: true,
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "/rapportodiprova/firma",
                        type: "POST",
                        dataType: "json",
                        data: {
                            id_rapprel: id_rapprel,
                            amministratore: amministratore,
                            azione: azione
                        },
                        success: function(returnValue) {   
                            showNotification('alert-success',"Firma del direttore aggiunta con successo", 'top', 'right', null, null);
                            //wait 1 second and then reload the page
                            setTimeout(function(){
                                location.reload();
                            }, 1000);
                        }, 
                        error: function(response, stato) {
                            showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
                        }
                    })
                }
            }); 
        })
    }
    
    var annullaFirmaDirettore = function()
    {
        $('.btn-annulla-firma-direttore').on('click',function(){
            var id_rapprel = $(this).attr('id_rapprel');
            var amministratore = 'direttore';
            var azione = 'annulla';
            swal({
                title: "Sei sicuro?",
                text: "Stai annullando la firma sul rapporto di prova, vuoi procedere?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, procedi",
                confirmButtonColor: "#8CD4F5",
                cancelButtonText: "No, annulla",
                closeOnConfirm: true,
                closeOnCancel: true,
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "/rapportodiprova/firma",
                        type: "POST",
                        dataType: "json",
                        data: {
                            id_rapprel: id_rapprel,
                            amministratore: amministratore,
                            azione: azione
                        },
                        success: function(returnValue) {   
                            showNotification('alert-success',"Firma del direttore annullata con successo", 'top', 'right', null, null);
                            //wait 1 second and then reload the page
                            setTimeout(function(){
                                location.reload();
                            }, 1000);
                        }, 
                        error: function(response, stato) {
                            showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
                        }
                    }) 
                }
            }); 
        })
    }
    
    var firmaResponsabile = function()
    {
        $('.btn-firma-responsabile').on('click',function(){
            var id_rapprel = $(this).attr('id_rapprel');
            var amministratore = 'responsabile';
            var azione = 'aggiungi';
            swal({
                title: "Sei sicuro?",
                text: "Stai firmando il rapporto di prova, vuoi procedere?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, procedi",
                confirmButtonColor: "#8CD4F5",
                cancelButtonText: "No, annulla",
                closeOnConfirm: true,
                closeOnCancel: true,
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "/rapportodiprova/firma",
                        type: "POST",
                        dataType: "json",
                        data: {
                            id_rapprel: id_rapprel,
                            amministratore: amministratore,
                            azione: azione
                        },
                        success: function(returnValue) {   
                            showNotification('alert-success',"Firma del responsabile aggiunta con successo", 'top', 'right', null, null);
                            //wait 1 second and then reload the page
                            setTimeout(function(){
                                location.reload();
                            }, 1000);
                        }, 
                        error: function(response, stato) {
                            showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
                        }
                    }) 
                }
            }); 
        })
    }

    var annullaFirmaResponsabile = function()
    {
        $('.btn-annulla-firma-responsabile').on('click',function(){
            var id_rapprel = $(this).attr('id_rapprel');
            var amministratore = 'responsabile';
            var azione = 'annulla';
            swal({
                title: "Sei sicuro?",
                text: "Stai annullando la firma sul rapporto di prova, vuoi procedere?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, procedi",
                confirmButtonColor: "#8CD4F5",
                cancelButtonText: "No, annulla",
                closeOnConfirm: true,
                closeOnCancel: true,
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "/rapportodiprova/firma",
                        type: "POST",
                        dataType: "json",
                        data: {
                            id_rapprel: id_rapprel,
                            amministratore: amministratore,
                            azione: azione
                        },
                        success: function(returnValue) {   
                            showNotification('alert-success',"Firma del responsabile annullata con successo", 'top', 'right', null, null);
                            //wait 1 second and then reload the page
                            setTimeout(function(){
                                location.reload();
                            }, 1000);
                        }, 
                        error: function(response, stato) {
                            showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
                        }
                    })
                }
            });    
        })
    }
</script>
@endsection
@endis

@is(['committente','utente'])
@section('script')
<script type="text/javascript">
    var table;

    $(document).ready(function () {
        let data = moment(new Date()).format("YYYY-MM-DD");
        let cl = console.log;
        // imposta lo sfondo di colore bianco nei grafici da scaricare come immagini
        const backgroundColor = 'white';
        /* Initializzo la DataTable */
        table = $('#relazionirapporti_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/rapprel/list/tutti/tutti/tutti", // /rapprel{function}{progetto}{struttura}{reparto}
            },
            "columns" : [
                { "data" : 'dataCampagna', render: function(data, type, row) {
                        return moment(data).format("DD/MM/YYYY");
                    }
                },
                { "data" : 'progetto' },
                { "data" : 'struttura' },
                { "data" : 'reparto' },
                { "data" : 'tipo', orderable: false },
                { "data" : 'file', orderable: false, searchable: false },
                { "data" : 'note', orderable: false },
            ],
            "lengthMenu": [25, 50, 100, 200],
            "pageLength": 25,
            "order": [[ 0, "desc" ]],
            "language": {
                "url": "{!! url('vendor/datatables/Italian.json') !!}"
            },
            "columnDefs": [
                { width: 25, targets: [ 0 ] },
                { width: 50, targets: [ 1 ] },
                { width: 150, targets: [ 2 ] },
                { width: 150, targets: [ 3 ] },
                { width: 150, targets: [ 4 ] },
                { width: 25, targets: [ 5 ] },
                { width: 125, targets: [ 6 ] },
            ],
            "drawCallback":function( settings, json) {
                //console.log('drawCallback');
                //$(filtra);
                // $(bind_elimina);
                $(change);
                // $(sendmail);
            },
            "initComplete":function( settings, json) {
                // Ultima ad essere chiamata
                //console.log('initComplete');
                $('.dataTables_length select.form-control').addClass('ms'); // Aggiungo la classe ms per evitare che la select si scombini
                $.AdminBSB.select.refresh();    // Rilancio l'attivatore del plugin selectpicker
            },
            
        });

        /* Search nella DataTable custom */
        /*$('#search-input').keyup(function(){
            table.search($(this).val()).draw();
        });*/

        /** 
         * Bind del bottone Elimina
         */
        var bind_elimina = function() {
            $('.btn-elimina').bind('click', function(event) {
                event.preventDefault();
                var id = $(this).attr('id');
                swal({
                    title: "Sei sicuro?",
                    text: "Procedi alla cancellazione?. Ti ricordo che l'azione è irreversibile e il documento sarà definitivamente eliminato dal sistema",
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
                            url: "/rapprel/" + id,
                            type: "post",
                            dataType: "json",
                            data: {
                                id: id,
                            },
                            success: function(data) {
                                table.ajax.reload();
                                swal("Eliminato!", "Il documento è stato cancellato.","success");
                            },
                            error: function(response, stato) {
                                swal.close();
                                showNotification('alert-danger', response.responseJSON.message, 'top', 'right', null, null);
                                
                            }
                        });
                    } else {
                        swal("Annullato", "L'operazione è stata annullata", "info");
                    }
                });
            });
        }

        var sendmail = function()
        {
            $('.btn-spediscimail').on('click',function(){
                var id_progetto = $(this).attr('id_progetto');
                var id = $(this).attr('id_rapprel');
                swal({
                    title: "Sei sicuro?",
                    text: "Procedi all'invio dell'email?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#8CD4F5",
                    confirmButtonText: "Si, procedi",
                    cancelButtonText: "No, annulla",
                    closeOnConfirm: false,
                    closeOnCancel: false,
                    showLoaderOnConfirm: true,
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "/rapprel/" + id + "/sendemail",
                            type: "post",
                            dataType: "json",
                            data: {
                                id: id,
                                id_progetto:id_progetto
                            },
                            success: function(data) {
                                swal("Inviato!", "La mail è stata invaita con successo","success");
                            },
                            error: function(response, stato) {
                                swal.close();
                                showNotification('alert-danger', response.responseJSON.message, 'top', 'right', null, null);
                                
                            }
                        });
                    } else {
                        swal("Annullato", "L'operazione è stata annullata", "info");
                    }
                });
            })
        }
    });

    var change = function(){
        $('#relazionirapporti_table_filter label').contents().eq(0).replaceWith('Filtro:');
        //$('#referti_table_filter input').addClass('filtro');
    }

   
    $('#societa_relazionirapporti').on('change',function(){
        var id_societa = $(this).val();
        var progetto = $('#progetto_relazionirapporti option:selected').val();
        var struttura = $('#struttura_relazionirapporti option:selected').val();
        var reparto = $('#reparto_relazionirapporti option:selected').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/campagna/"+id_societa+"/getData",
            type: "GET",
            dataType: "json",
            data: {
                id_societa: id_societa
            },
            success: function(returnValue) {
                console.log(returnValue);
                replace_options_progetti($('#progetti_relazionirapporti'),$('#progetti_relazionirapporti').prev("div"),returnValue['progetti']);
                id_progetto = $('#progetti_relazionirapporti').val();
                id_societa = $('#societa_relazionirapporti').val();
            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });

    $('#progetti_relazionirapporti').on('change',function(){
        var id_progetto = $(this).val();
        var id_societa = $('#societa_relazionirapporti option:selected').val();
        var struttura = $('#struttura_relazionirapporti option:selected').val();
        var reparto = $('#reparto_relazionirapporti option:selected').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/campagna/"+id_progetto+"/"+id_societa+"/getStruttureProgetto",
            type: "GET",
            dataType: "json",
            data: {
                id_progetto: id_progetto,
                id_societa: id_societa
            },
            success: function(returnValue) {
                console.log(returnValue['tot_strutture']);
                replace_options_strutture($('#struttura_relazionirapporti'),$('#struttura_relazionirapporti').prev("div"),returnValue['tot_strutture']);
                id_progetto = $('#progetti_relazionirapporti').val();
                id_societa = $('#societa_relazionirapporti').val();
                struttura = $('#struttura_relazionirapporti').val();
                reparto = $('#reparto_relazionirapporti').val();
               table.ajax.url("/rapprel/list/"+id_progetto+"/"+struttura+"/"+reparto).load();
                $('#struttura_relazionirapporti').val('tutti').change();
                //$('#struttura_relazionirapporti').trigger('change');
                $('#reparto_relazionirapporti').val('tutti').change();
                //$('#reparto_relazionirapporti').trigger('change');
                console.log(id_societa);
                console.log(id_progetto);
                console.log(struttura);
                console.log(reparto)

            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });

    $('#struttura_relazionirapporti').on('change',function(){
        var id_progetto = $('#progetti_relazionirapporti option:selected').val();
        var id_societa = $('#societa_relazionirapporti option:selected').val();
        var struttura = $(this).val();
        var reparto = $('#reparto_relazionirapporti option:selected').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/campagna/"+id_societa+"/"+id_progetto+"/"+struttura+"/getStruttureReparti",
            type: "GET",
            dataType: "json",
            data: {
                id_progetto: id_progetto,
                struttura: struttura
            },
            success: function(returnValue) {
                replace_options_reparti($('#reparto_relazionirapporti'),$('#reparto_relazionirapporti').prev("div"),returnValue['tot_reparti']);
               
                id_progetto = $('#progetti_relazionirapporti option:selected').val();
                id_societa = $('#societa_relazionirapporti option:selected').val();
                struttura = $('#struttura_relazionirapporti option:selected').val();
                reparto = $('#reparto_relazionirapporti option:selected').val();
               table.ajax.url("/rapprel/list/"+id_progetto+"/"+struttura+"/"+reparto).load();
                $('#reparto_relazionirapporti').val('tutti').change();
                //$('#reparto_relazionirapporti').trigger('change');
               table.ajax.url("/rapprel/list/"+id_progetto+"/"+struttura+"/"+reparto).load();
            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });

    $('#reparto_relazionirapporti').on('change',function(){
        var id_progetto = $('#progetti_relazionirapporti option:selected').val();
        var id_societa = $('#societa_relazionirapporti option:selected').val();
        var struttura = $('#struttura_relazionirapporti option:selected').val();
        var reparto = $('#reparto_relazionirapporti option:selected').val();
        console.log(id_societa);
        console.log(id_progetto);
        console.log(struttura);
        console.log(reparto);

       table.ajax.url("/rapprel/list/"+id_progetto+"/"+struttura+"/"+reparto).load();    
    });


    function replace_options_strutture(select,dropdownSelect,array)
    {
        $(select).empty();
        $(dropdownSelect).children().empty();
        if(array.length == 0)
        {
            let newOption = new Option('-- Non sono presenti strutture --', 'tutti');
            $(select).append(newOption);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti strutture -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti strutture --');
            $(dropdownSelect).children().append(liOption);
        }
        else
        {
            let tutti = new Option('-- Seleziona un\'opzione --','tutti');
            $(select).append(tutti);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Seleziona un\'opzione -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Seleziona un\'opzione --');
            $(dropdownSelect).children().append(liOption);

            $.each(array, function (i, item) {
                i = i+1;
				let newOption = new Option(item.struttura, item.id);
				$(select).append(newOption);
				let liOption;
				liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.struttura+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
				$(dropdownSelect).children().append(liOption);
		    });
        }
    }

    function replace_options_reparti(select,dropdownSelect,array)
    {
        $(select).empty();
        $(dropdownSelect).children().empty();
        if(array.length == 0)
        {
            let newOption = new Option('-- Non sono presenti reparti --', 'tutti');
            $(select).append(newOption);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti reparti -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti reparti --');
            $(dropdownSelect).children().append(liOption);
        }
        else
        {
            let tutti = new Option('-- Seleziona un\'opzione --','tutti');
            $(select).append(tutti);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Seleziona un\'opzione -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Seleziona un\'opzione --');
            $(dropdownSelect).children().append(liOption);

            $.each(array, function (i, item) {
                i = i+1;
                let newOption = new Option(item.reparto, item.id);
                $(select).append(newOption);
                let liOption;
                liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.reparto+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
                $(dropdownSelect).children().append(liOption);
            });
        }
    }

    function replace_options_progetti(select,dropdownSelect,array)
    {
        $(select).empty();
        $(dropdownSelect).children().empty();
        if(array.length == 0)
        {
            let newOption = new Option('-- Non sono presenti progetti --', 'tutti');
            $(select).append(newOption);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti progetti -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti progetti --');
            $(dropdownSelect).children().append(liOption);
        }
        else
        {
            let tutti = new Option('-- Seleziona un\'opzione --','tutti');
            $(select).append(tutti);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Seleziona un\'opzione -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Seleziona un\'opzione --');
            $(dropdownSelect).children().append(liOption);

            $.each(array, function (i, item) {
                i = i+1;
                let newOption = new Option(item.progetto, item.id);
                $(select).append(newOption);
                let liOption;
                liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.progetto+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
                $(dropdownSelect).children().append(liOption);
            });
        }
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
@endis
