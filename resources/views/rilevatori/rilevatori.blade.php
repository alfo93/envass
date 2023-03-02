
@if ($errors->any())
<div id="errors-container" class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ ucfirst($error) }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Lista di schede campionamenti -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Elenco dei campionatori
                </h2>
                @shield('users.create')
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ URL::action('RilevatoreController@create') }}" name="crea_rilevatore" id="crea_rilevatore" class=" waves-effect waves-block" value="Aggiungi nuovo campionatore">Aggiungi nuovo campionatore</a></li>
                        </ul>
                    </li>
                </ul>
                @endshield
            </div>
            <div class="body">
                <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable rilevatori_table" id="rilevatori_table" role="grid" aria-describedby="DataTables_Table_1_info" style="width: 100%;  height:100%;" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>Campionatore</th>
                                <th>Attività</th>
                                <th>Interno</th>
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

<!-- Modifica modal-->
<div class="modal fade in" id="modificaRilevatoreModal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modificaModalLabel">Specificare il motivo della modifica</h4>
            </div>
            <form id="form_advanced_validation" enctype="multipart/form-data" action="{{ URL::action('RilevatoreController@update') }}" method="POST" novalidate="novalidate">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="progetto">Nome</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="nome_modal" class="form-control" name="nome" placeholder="nome" value="{{ old('nome') ?? '' }}" maxlength="255">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="progetto">Cognome</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="cognome_modal" class="form-control" name="cognome" placeholder="cognome" value="{{ old('cognome') ?? '' }}" maxlength="255">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="progetto">Attività</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="id_progetto" id="progetti_rilevatore_modal" data-size="7">
                                                <option selected value="nessuna">-- Seleziona un'opzione --</option>
                                                <option selected value="0">Nessuna</option>
                                                @foreach ($progetti as $progetto)
                                                    <option value="{{ $progetto->id }}">{{ $progetto->progetto }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="struttura">Struttura</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="id_struttura" id="struttura_rilevatore_modal" data-size="7">
                                                <option selected value="nessuna">-- Seleziona un'opzione --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label for="reparto">Interno</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="interno_rilevatore_modal" name="interno">
                                                <option value="tutti">-- Seleziona un'opzione --</option>
                                                <option value="1">Si</option>
                                                <option value="0">No</option>
                                            </select>     
                                            <div class="help-info">Interno</div>  
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <label for="progetto">Motivo</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="modifica_rilevatore_motivo" class="form-control" name="motivo" placeholder="motivo" value="{{ old('motivo') ?? '' }}" maxlength="255">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="modifica_rilevatore_salva" name="modifica_rilevatore_salva" value="ciao" class="btn btn-link waves-effect">CONFERMA</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                </div>
            </form>        
        </div>
    </div>
</div>
<!--end modal--> 

<!--modal-->
<div class="modal fade in" id="deleteModal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="deleteModalLabel">Specificare il motivo dell'eliminazione del campionatore dal sistema</h4>
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
                <button type="button" name="cancella_rilevatore" id="cancella_rilevatore" class="btn btn-link waves-effect elimina_modal">CONFERMA</button>
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
        let data = moment(new Date()).format("YYYY-MM-DD");
        let cl = console.log;
        // imposta lo sfondo di colore bianco nei grafici da scaricare come immagini
        const backgroundColor = 'white';
        /* Initializzo la DataTable */
        table = $('#rilevatori_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/rilevatori/list/tutti/tutti", 
            },
            "columns" : [
                { "data" : 'rilevatore' },
                { "data" : 'progetto' },
                { "data" : 'interno' },
                { "data" : 'azione', orderable: false, searchable: false }

            ],
            "lengthMenu": [25, 50, 100, 200],
            "pageLength": 25,
            "order": [[ 0, "desc" ]],
            "language": {
                "url": "{!! url('vendor/datatables/Italian.json') !!}"
            },
            "columnDefs": [
                { className: "azione", targets: [ 3 ] },
                { width: 150, targets: [ 0 ] },
                { width: 100, targets: [ 1 ] },
                { width: 150, targets: [ 2 ] },
                { width: 150, targets: [ 3 ] },
            ],
            "drawCallback":function( settings, json) {
                //$(filtra);
                $(bind_elimina);
                $(change);
                $(getData);
            },
            "initComplete":function( settings, json) {
                // Ultima ad essere chiamata
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
            $('.btn-elimina').on('click',function(){
                var id = $(this).attr('id');
                $('#cancella_rilevatore').bind('click', function(event) {
                    event.preventDefault();
                    var motivo = $('#cancel_motivo_annullamento').val();
                    swal({
                        title: "Sei sicuro?",
                        text: "Procedi alla cancellazione?. Ti ricordo che l'azione è irreversibile e il campionatore sarà definitivamente eliminato dal sistema",
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
                                url: "/rilevatori/delete",
                                type: "post",
                                dataType: "json",
                                data: {
                                    id: id,
                                    motivo: motivo
                                },
                                success: function(data) {
                                    $('#deleteModal').modal('hide');
                                    table.ajax.reload();
                                    swal("Eliminato!", "Il campionatore è stato cancellato.","success");
                                },
                                error: function(response, stato) {
                                    $('#deleteModal').modal('hide');
                                    swal.close();
                                    showNotification('alert-danger', response.responseJSON.message, 'top', 'right', null, null);
                                    
                                }
                            });
                        } else {
                            swal("Annullato", "L'operazione è stata annullata", "info");
                        }
                    });
                });
            })
        }
    });

    var change = function(){
        $('#rilevatori_table_filter label').contents().eq(0).replaceWith('Filtro:');
        //add hidden class to the search input
        $('#rilevatori_table_filter input').addClass('hidden');
        $('#rilevatori_table_filter label').addClass('hidden');

    }

    var getData = function(){
        $('.modifica-rilevatore').on('click',function(){
            var id = $(this).attr('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/rilevatori/"+id+"/getData",
                type: "GET",
                dataType: "json",
                data: {
                    id: id
                },
                success: function(returnValue) {
                    console.log(returnValue);
                    $('#nome_modal').val(returnValue['nome']);
                    $('#cognome_modal').val(returnValue['cognome']);
                    $('#progetti_rilevatore_modal').val(returnValue['progetto']).trigger('change');
                    $('#interno_rilevatore_modal').val(returnValue['interno']).trigger('change');
                    $('#modifica_rilevatore_salva').val(returnValue['id']);
                }, 
                error: function(response, stato) {
                    showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
                }
            });  
        })
    }
   
    $('#societa_rilevatori').on('change',function(){
        var id_societa = $(this).val();
        var progetto = $('#progetto_rilevatori option:selected').val();
        // var struttura = $('#struttura_rilevatori option:selected').val();
        var interno = $('#interno_rilevatori option:selected').val();
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
                replace_options_progetti($('#progetto_rilevatori'),$('#progetto_rilevatori').prev("div"),returnValue['progetti']);
            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });

    $('#progetto_rilevatori').on('change',function(){
        var id_progetto = $(this).val();
        var id_societa = $('#societa_rilevatori option:selected').val();
        var interno = $('#interno_rilevatori option:selected').val();
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
                // replace_options_strutture($('#struttura_rilevatori'),$('#struttura_rilevatori').prev("div"),returnValue['tot_strutture']);
                id_progetto = $('#progetto_rilevatori').val();
                id_societa = $('#societa_rilevatori').val();
                interno = $('#interno_rilevatori').val();
                table.ajax.url( "/rilevatori/list/"+id_progetto+"/"+interno).load();
                // $('#struttura_rilevatori').val('tutti').change();
                //$('#struttura_rilevatori').trigger('change');
                $('#interno_rilevatori').val('tutti').change();
                //$('#interno_rilevatori').trigger('change');
            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });

    // $('#struttura_rilevatori').on('change',function(){
    //     var id_progetto = $('#progetto_rilevatori option:selected').val();
    //     var id_societa = $('#societa_rilevatori option:selected').val();
    //     var struttura = $(this).val();
    //     var interno = $('#interno_rilevatori option:selected').val();
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $.ajax({
    //         url: "/campagna/"+id_societa+"/"+id_progetto+"/"+struttura+"/getStruttureReparti",
    //         type: "GET",
    //         dataType: "json",
    //         data: {
    //             id_progetto: id_progetto,
    //             struttura: struttura
    //         },
    //         success: function(returnValue) {               
    //             id_progetto = $('#progetto_rilevatori option:selected').val();
    //             id_societa = $('#societa_rilevatori option:selected').val();
    //             struttura = $('#struttura_rilevatori option:selected').val();
    //             interno = $('#interno_rilevatori option:selected').val();
    //             table.ajax.url("/rilevatori/list/"+id_progetto+"/"+struttura+"/"+interno).load();
    //             $('#interno_rilevatori').val('tutti').change();
    //             //$('#interno_rilevatori').trigger('change');
    //             table.ajax.url("/rilevatori/list/"+id_progetto+"/"+struttura+"/"+interno).load();
    //         }, 
    //         error: function(response, stato) {
    //             showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
    //         }
    //     });  
    // });

    $('#interno_rilevatori').on('change',function(){
        var id_progetto = $('#progetto_rilevatori option:selected').val();
        var id_societa = $('#societa_rilevatori option:selected').val();
        var interno = $('#interno_rilevatori option:selected').val();

        table.ajax.url("/rilevatori/list/"+id_progetto+"/"+interno).load();    
    });


    // $('#progetti_rilevatore_modal').on('change',function(){
    //     var id_progetto = $(this).val();
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $.ajax({
    //         url: "/rilevatori/"+id_progetto+"/getStruttureProgetto",
    //         type: "GET",
    //         dataType: "json",
    //         data: {
    //             id_progetto: id_progetto,
    //         },
    //         success: function(returnValue) {
    //             if(typeof returnValue == 'string')
    //             {
    //                 replace_options_strutture($('#struttura_rilevatore_modal'),$('#struttura_rilevatore_modal').prev("div"),returnValue);
    //             }
    //             else
    //             {
    //                 replace_options_strutture($('#struttura_rilevatore_modal'),$('#struttura_rilevatore_modal').prev("div"),returnValue['tot_strutture']);
    //             }
    //         }, 
    //         error: function(response, stato) {
    //             showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
    //         }
    //     });  
    // });


    // function replace_options_strutture(select,dropdownSelect,array)
    // {
    //     if(array == "nessun progetto selezionato")
    //     {
    //         $(select).empty();
    //         $(dropdownSelect).children().empty();
    //         let newOption = new Option('-- Non sono presenti strutture --', 'tutti');
    //         $(select).append(newOption);
    //         liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti strutture -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
    //         $(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti strutture --');
    //         $(dropdownSelect).children().append(liOption);
    //         return;
    //     }

    //     $(select).empty();
    //     $(dropdownSelect).children().empty();
    //     if(array.length == 0)
    //     {
    //         let newOption = new Option('-- Non sono presenti strutture --', 'tutti');
    //         $(select).append(newOption);
    //         liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti strutture -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
    //         $(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti strutture --');
    //         $(dropdownSelect).children().append(liOption);
    //     }
    //     else
    //     {
    //         let tutti = new Option('-- Seleziona un\'opzione --','tutti');
    //         $(select).append(tutti);
    //         liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Seleziona un\'opzione -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
    //         $(dropdownSelect).prev('button').children('.filter-option').text('-- Seleziona un\'opzione --');
    //         $(dropdownSelect).children().append(liOption);

    //         $.each(array, function (i, item) {
    //             i = i+1;
	// 			let newOption = new Option(item.struttura, item.id);
	// 			$(select).append(newOption);
	// 			let liOption;
	// 			liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.struttura+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
	// 			$(dropdownSelect).children().append(liOption);
	// 	    });
    //     }
    // }

    function replace_options_progetti(select,dropdownSelect,array)
    {
        $(select).empty();
        $(dropdownSelect).children().empty();
        if(array.length == 0)
        {
            let newOption = new Option('-- Non sono presenti attività --', 'tutti');
            $(select).append(newOption);
            liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti attività -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti attività --');
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