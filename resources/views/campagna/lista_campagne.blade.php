
<!-- Lista di schede campionamenti -->
@if ($errors->any())
    <div id="errors-container" class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ ucfirst($error) }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Elenco dei campionamenti
                </h2>
                @shield('campagna.store')
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a name="crea_campagna" id="crea_campagna" class=" waves-effect waves-block" value="Nuova Campagna" data-toggle="modal" data-target="#largeModal">Nuovo campionamento</a></li>
                        </ul>
                    </li>
                </ul>
                @endshield
            </div>
            <div class="body">
                <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable campagne_table" id="campagne_table" role="grid" aria-describedby="DataTables_Table_1_info" style="width: 100%;  height:100%;" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>Committente</th>
                                <th>Attività</th>
                                <th>Struttura</th>
                                <th>Data</th>
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

<!-- modal per creazione campagna -->
<div class="modal fade in" id="largeModal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel">Campionamento</h4>
            </div>
            <form action="{{ URL::action('CampagnaController@store') }}" id="form_advanced_validation" method="POST" novalidate="novalidate">
            {{-- <form action="" id="form_advanced_validation" method="POST" novalidate="novalidate"> --}}
                <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>Committente</label>
                                <select class="form-control show-tick" id="societa_campagna_modal" name="id_societa" required aria-required="true">
                                    <option value="tutti">-- Seleziona un opzione --</option>
                                    @foreach($societa as $s)
                                        <option value="{{ $s->id }}">{{ $s->nome }}</option>
                                    @endforeach
                                </select>                               
                            </div>
                            <div class="help-info">Nome del committente</div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>Attività</label>
                                <select class="form-control show-tick" id="progetti_campagna_modal" name="id_progetto">
                                    <option value="tutti">Tutti</option>
                                </select>     
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>Struttura</label>
                                <select class="form-control show-tick" id="struttura_campagna_modal" name="id_struttura" required aria-required="true">
                                    <option value="tutti">-- Seleziona un opzione --</option>
                                   
                                </select>  
                            </div>
                            <div class="help-info">Struttura</div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>Data campagna</label>
                                <input type="date" id="dataCampagna_modal" class="form-control" name="dataCampagna" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                            <div class="help-info">Data di inizio della campagna</div>
                        </div>                                    
                </div>
                <div class="modal-footer">
                    <input type="submit" name="crea_campagna" id="crea_campagna_save" class="btn btn-link waves-effect"  value="SALVA" target="_blank">
                    <!--<button type="button" name="crea_campagna" id="crea_campagna" class="btn btn-link waves-effect"  value="Aggiungi" >SALVA</button>-->
                    <button type="button" id="closeModal" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                </div>
            </form>
        </div>
    </div>
</div>


@section('script')
<script type="text/javascript">
    $.fn.dataTable.ext.errMode = 'throw'; //evita di presentare un alert all'utente su l'errore che a volte genera il cambio di data che non è bloccante.
    var table;

    $(document).ready(function () {
        let data = moment(new Date()).format("YYYY-MM-DD");
        let cl = console.log;
        // imposta lo sfondo di colore bianco nei grafici da scaricare come immagini
        const backgroundColor = 'white';
       
        /* Initializzo la DataTable */
        table = $('#campagne_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/campagna/list/tutti/tutti/tutti/tutti",
            },
            "columns" : [
                { "data" : 'societa'},
                { "data" : 'progetto' },
                { "data" : 'struttura' },
                { "data" : 'dataCampagna', render: function(data, type, row) {
                        return moment(data).format("DD/MM/YYYY");
                    }
                },
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
                { width: 200, targets: [ 0 ] },
                { width: 150, targets: [ 1,2,3] },
                { width: 50, targets: [ 4 ] }

            ],
            "drawCallback":function( settings, json) {
                //console.log('drawCallback');
                //$(filtra);
                $(change);
            },
            "initComplete":function( settings, json) {
                // Ultima ad essere chiamata
                //console.log('initComplete');
                $('.dataTables_length select.form-control').addClass('ms'); // Aggiungo la classe ms per evitare che la select si scombini
                $.AdminBSB.select.refresh();    // Rilancio l'attivatore del plugin selectpicker
            },
            
        });
    });

    var change = function(){
        $('#campagne_table_filter label').contents().eq(0).replaceWith('Filtro:');
        //$('#referti_table_filter input').addClass('filtro');
    }

    /*
    * Sezione modal
    */
    $('#societa_campagna_modal').on('change',function(){
        var id_societa = $(this).val();
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
                replace_options_progetti($('#progetti_campagna_modal'),$('#progetti_campagna_modal').prev("div"),returnValue['progetti']);
                $('#progetti_campagna_modal').val('tutti').change();
                //$('#progetti_campagna_modal').trigger('change');
                $('#struttura_campagna_modal').val('tutti').change();
                //$('#struttura_campagna_modal').trigger('change');
            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });

    $('#progetti_campagna_modal').on('change',function(){
        var id_progetto = $(this).val();
        var id_societa = $('#societa_campagna_modal').val();
        var struttura = $('#struttura_campagna_modal').val();
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
                replace_options_strutture($('#struttura_campagna_modal'),$('#struttura_campagna_modal').prev("div"),returnValue['tot_strutture']);
                $('#struttura_campagna_modal').val('tutti').change();
                //$('#struttura_campagna_modal').trigger('change');
            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });

    // $('#struttura_campagna_modal').on('change',function(){
    //     var id_progetto = $('#progetti_campagna_modal').val();
    //     var id_societa = $('#societa_campagna_modal').val();
    //     var struttura = $(this).val();
    //     var reparto = $('#reparto_campagna_modal').val();
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
    //             replace_options_reparti($('#reparto_campagna_modal'),$('#reparto_campagna_modal').prev("div"),returnValue['tot_reparti']);
    //             $('#reparto_campagna_modal').val('tutti').change();
    //             //$('#reparto_campagna_modal').trigger('change');
    //         }, 
    //         error: function(response, stato) {
    //             showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
    //         }
    //     });  
    // });

    /*
    * Fine sezione modal
    */

    $('#societa_campagna').on('change',function(){
        var id_societa = $(this).val();
        var struttura = $('#struttura_campagna').val();
        var dataCampagna = $('#dataCampagna').val() != null ? $('#dataCampagna').val() : 'tutti';
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
                replace_options_progetti($('#progetti_campagna'),$('#progetti_campagna').prev("div"),returnValue['progetti']);
                id_progetto = $('#progetti_campagna').val();
                id_societa = $('#societa_campagna').val();
                struttura = $('#struttura_campagna').val();
                dataCampagna = $('#dataCampagna').val() != null ? $('#dataCampagna').val() : 'tutti';
                table.ajax.url( "/campagna/list/"+id_societa+"/"+struttura+"/"+id_progetto+"/"+dataCampagna).load();
                $('#progetti_campagna').val('tutti').change();
                //$('#progetti_campagna').trigger('change');
                $('#struttura_campagna').val('tutti').change();
                //$('#struttura_campagna').trigger('change');

            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });

    $('#progetti_campagna').on('change',function(){
        var id_progetto = $(this).val();
        var id_societa = $('#societa_campagna').val();
        var struttura = $('#struttura_campagna').val();
        var dataCampagna = $('#dataCampagna').val() != null ? $('#dataCampagna').val() : 'tutti';
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
                replace_options_strutture($('#struttura_campagna'),$('#struttura_campagna').prev("div"),returnValue['tot_strutture']);
                id_progetto = $('#progetti_campagna').val();
                id_societa = $('#societa_campagna').val();
                struttura = $('#struttura_campagna').val();
                dataCampagna = $('#dataCampagna').val() != null ? $('#dataCampagna').val() : 'tutti';
                table.ajax.url( "/campagna/list/"+id_societa+"/"+struttura+"/"+id_progetto+"/"+dataCampagna).load();
                $('#struttura_campagna').val('tutti').change();
                //$('#struttura_campagna').trigger('change');


            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });

    $('#struttura_campagna').on('change',function(){
        var id_progetto = $('#progetti_campagna').val();
        var id_societa = $('#societa_campagna').val();
        var struttura = $(this).val();
        var dataCampagna = $('#dataCampagna').val() != null ? $('#dataCampagna').val() : 'tutti';
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
                id_progetto = $('#progetti_campagna').val();
                id_societa = $('#societa_campagna').val();
                struttura = $('#struttura_campagna').val();
                dataCampagna = $('#dataCampagna').val() != null ? $('#dataCampagna').val() : 'tutti';
                table.ajax.url( "/campagna/list/"+id_societa+"/"+struttura+"/"+id_progetto+"/"+dataCampagna).load();
            }, 
            error: function(response, stato) {
                showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
            }
        });  
    });


    $('#data_campagna').on('change',function(){
        var id_progetto = $('#progetti_campagna').val();
        var id_societa = $('#societa_campagna').val();
        var struttura = $('#struttura_campagna').val();
        var dataCampagna = $(this).val();
        table.ajax.url( "/campagna/list/"+id_societa+"/"+struttura+"/"+id_progetto+"/"+dataCampagna).load();
              
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

    // function replace_options_reparti(select,dropdownSelect,array)
    // {
    //     $(select).empty();
    //     $(dropdownSelect).children().empty();
    //     if(array.length == 0)
    //     {
    //         let newOption = new Option('-- Non sono presenti reparti --', 'tutti');
    //         $(select).append(newOption);
    //         liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti reparti -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
    //         $(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti reparti --');
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
    //             let newOption = new Option(item.reparto, item.id);
    //             $(select).append(newOption);
    //             let liOption;
    //             liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.reparto+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
    //             $(dropdownSelect).children().append(liOption);
    //         });
    //     }
    // }

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
</script>
@endsection