<!-- Lista di Societa -->
<div class="block-header">
    <h2>Elenco dei committenti
    </h2>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Elenco dei committenti
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ URL::action('SocietaController@create') }}" role="button" onclick=""
                                    name="crea_nuovo" id="nuova_societa" class=" waves-effect waves-block"
                                    value="Nuovo cliente" target="_blank">Nuovo committente</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable societa_table" id="societa_table" role="grid" aria-describedby="DataTables_Table_1_info" style="width: 100%;  height:100%;" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Indirizzo</th>
                                <th>E-Mail</th>
                                <th>Contratto</th>
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
<div class="modal fade in" id="ModalModificaCliente" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Modifica cliente</h4>
            </div>
            <div class="modal-body">
                <form id="form_advanced_validation" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="nome">Cliente</label>
                            <input type="text" id="nome_cliente" class="form-control" name="minmaxlength" maxlength="35" minlength="3" required="" aria-required="true" value="">                                                          
                        </div>
                        <div class="help-info">Nome del cliente</div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="nome">Indirizzo</label>
                            <input type="text" id="indirizzo" class="form-control" name="minmaxlength" maxlength="100" minlength="3" required="" aria-required="true" value="">
                        </div>
                        <div class="help-info">Indirizzo della sede principale del cliente</div>
                    </div> 
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label for="mail">E-mail</label>
                            <input type="text" id="mail" class="form-control" name="mail" aria-required="true" placeholder="" required>
                        </div>
                        <div class="help-info">Contatti del cliente</div>
                    </div> 
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label id="carica_contratto_label" for="carica_contratto" class="custom-file-upload">
                                        <span id="carica_contratto_text">Carica Documento</span>
                                    </label>
                                    <input class="custom-file-upload" id="carica_contratto" name="file" type="file" name="file"/>
                                    <span id="checkfile_contratto" class="label hidden label-success ml-2 font-13"></span>
                                </div>
                            </div>
                        </div>
                    </div>                                
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" name="modifica_cliente_modal" id="modifica_cliente_modal" class="btn btn-link waves-effect" value="Aggiungi">SALVA</button>
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
                            <input type="text" id="societaMotivo" class="form-control" name="minmaxlength" required="" aria-required="true" value="">                                                          
                        </div>
                        <div class="help-info">Motivo dell'eliminazione</div>
                    </div>                            
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="elimina_societa_salva" name="elimina_societa_salva" class="btn btn-link waves-effect" tipo="" >SALVA</button>
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
        table = $('#societa_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/societa/list",
            },
            "columns" : [
                { "data" : 'nome'},
                { "data" : 'indirizzo'},
                { "data" : 'email'},
                { "data" : 'file'},
                { "data" : 'azione', orderable: false, searchable: false}
            ],
            "lengthMenu": [25, 50, 100, 200],
            "pageLength": 25,
            "order": [[ 0, "desc" ]],
            "language": {
                "url": "{!! url('vendor/datatables/Italian.json') !!}"
            },
            "columnDefs": [
                { className: "azione", targets: [ 4 ] },
                { width: 100, targets: [ 0 ] },
                { width: 200, targets: [ 1, 2 ] },
                { width: 50, targets: [ 3 ] },
                { width: 100, targets: [ 4 ] },


            ],
            "drawCallback":function( settings, json) {
                //console.log('drawCallback');
                $(bind_elimina);
                //$(checkPermission);
                $(change);
                $(getCliente);
                //$(filtra);
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

    });

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

    var change = function(){
        $('#societa_table_filter label').contents().eq(0).replaceWith('Filtro:');
        // add hidden class to input and to label
        $('#societa_table_filter label').addClass('hidden');
        $('#societa_table_filter input').addClass('hidden');
    }
   
    var getCliente = function() {
        $('.modifica-cliente').on('click',function(event){
            event.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
                url: "/societa/"+id,
                type: "get",
                dataType: "json",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id
                },
                success: function(data) {
                    $('#nome_cliente').val(data['nome']);
                    $('#indirizzo').val(data['indirizzo']);
                    $('#mail').val(data['mail']);

                    $('#modifica_cliente_modal').on('click',function(){
                        var nome = $('#nome_cliente').val();
                        var indirizzo = $('#indirizzo').val();
                        var mail = $('#mail').val();
                        var file = $("#carica_contratto").prop("files")[0];
                        if(file == null)
                        {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            swal({
                                title: "Sei sicuro?",
                                text: "Sei sicuro di voler modificare l'attività scelta?",
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
                                        url: "/societa/"+id+"/modifica",
                                        type: "POST",
                                        dataType: "json",
                                        data: {
                                            id:id,
                                            nome: nome,
                                            indirizzo: indirizzo,
                                            mail: mail,
                                            nome_contratto: nome_file
                                        },
                                        success: function(returnValue) {
                                            if(returnValue == "Errore, cliente non trovato")
                                            {
                                                showNotification('alert-danger',returnValue, 'top', 'right', null, null);
                                            }
                                            $('#ModalModificaCliente').modal('hide');
                                            $('body').removeClass('modal-open');
                                            $('.modal-backdrop').remove();
                                            table.ajax.reload();
                                            showNotification('alert-success','Il cliente è stato modificato correttamente', 'top', 'right', null, null);
                                        }, 
                                        error: function(response, stato) {
                                            $('#ModalModificaCliente').modal('hide');
                                            $('body').removeClass('modal-open');
                                            $('.modal-backdrop').remove();
                                            showNotification('alert-danger',"Si è verificato un problema con la modifica del cliente, riprovare", 'top', 'right', null, null);
                                        }
                                    });
                                }
                            });
                        }
                        else
                        {
                            var nome_file = file['name'];
                            const reader = new FileReader();
                            reader.onloadend = () => {
                                // log to console
                                // logs data:<type>;base64,wL2dvYWwgbW9yZ...
                            };
                            reader.readAsDataURL(file)
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            swal({
                                title: "Sei sicuro?",
                                text: "Sei sicuro di voler modificare l'attività scelta?",
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
                                        url: "/societa/"+id+"/modifica",
                                        type: "POST",
                                        dataType: "json",
                                        data: {
                                            id:id,
                                            nome: nome,
                                            indirizzo: indirizzo,
                                            mail: mail,
                                            contratto: reader.result,
                                            nome_contratto: nome_file
                                        },
                                        success: function(returnValue) {
                                            if(returnValue == "Errore, cliente non trovato")
                                            {
                                                showNotification('alert-danger',returnValue, 'top', 'right', null, null);
                                            }
                                            $('#ModalModificaCliente').modal('hide');
                                            $('body').removeClass('modal-open');
                                            $('.modal-backdrop').remove();
                                            table.ajax.reload();
                                            showNotification('alert-success','Il cliente è stato modificato correttamente', 'top', 'right', null, null);
                                        }, 
                                        error: function(response, stato) {
                                            $('#ModalModificaCliente').modal('hide');
                                            $('body').removeClass('modal-open');
                                            $('.modal-backdrop').remove();
                                            showNotification('alert-danger',"Si è verificato un problema con la modifica del cliente, riprovare", 'top', 'right', null, null);
                                        }
                                    });
                                }
                            });
                        }
                        
                        
                    });
                }, 
                error: function(response, stato) {
                    console.log(response);
                }
            });
        })
    }

    /** 
     * Bind del bottone Elimina
     */
     var bind_elimina = function() {
        $('.button-elimina').on('click',function(){
            var id = $(this).attr('id');
            $('#elimina_societa_salva').on('click',function(){
                var motivo = $('#societaMotivo').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                swal({
                    title: "Sei sicuro?",
                    text: "Sei sicuro di voler eliminare il committente? Se esistono attività associate a questo committente, l'azione non verrà eseguita",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Si, procedi",
                    confirmButtonColor: "#DD6B55",
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
                            url: "/societa/"+id,
                            type: "POST",
                            dataType: "json",
                            data: {
                                id:id,
                                motivo: motivo
                            },
                            success: function(returnValue,stato, code) {
                                $('#deleteModal').modal('hide');
                                showNotification('alert-success',"Committente eliminato correttamente", 'top', 'right', null, null);
                                //reload the page after 1 second
                                setTimeout(function(){
                                    location.reload();
                                }, 1000);
                            }, 
                            error: function(returnValue,response, stato) {
                                console.log(returnValue['responseJSON']['messaggio']);
                                $('#deleteModal').modal('hide');
                                showNotification('alert-danger',returnValue['responseJSON']['messaggio'], 'top', 'right', null, null);
                            }
                        });
                    }
                });
            })
        });
    }

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
                //backgroundColor: generaColoreOggetto(societa_progetti,colori_situazione,situazione_length), 
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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
        
    
    

</script>
@endsection