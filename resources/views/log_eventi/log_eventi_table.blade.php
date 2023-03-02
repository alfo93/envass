@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>DASHBOARD
            <small>Dashboard eventi di ENVASS</small>
        </h2>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Elenco degli eventi</h2>
                </div>
                <div class="body">
                    <div class="table">
                        <table id ="log_eventi_table"  class="table table-bordered table-striped table-hover dataTable js-exportable" role="grid" aria-describedby="DataTables_Table_1_info" style="width: 100%;  height:100%;" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Ora</th>
                                    <th>Nome Utente</th>
                                    <th>Cognome Utente</th>
                                    <th>Azione</th>
                                    <th>Gestione</th>
                                </tr>
                            </thead>
                            <tbody><!-- Gestito dalla DataTable AJAX --></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade in" id="largeModal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel">Evento</h4>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="body table-responsive">
                        <table class="table table-striped" id="areaDati">
                            <thead>
                                <tr>
                                    <th>Nome Attributo</th>
                                    <th>Valore</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTable">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeModal" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    var table;

    $(document).ready(function () {
        /* Inizializzo la DataTable */
        table = $('#log_eventi_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/logeventi/list",
            },
            "columns" : [
                { "data" : 'created_at', render: function(data, type, row) {
                        return moment(data).format("DD/MM/YYYY");
                    }
                },
                { "data" : 'created_at', render: function(data, type, row) {
                        return moment(data).format("HH:mm:ss");
                    }
                },
                { "data" : 'nome' },
                { "data" : 'cognome' },
                { "data" : 'azione' },
                { "data" : 'pulsante', "orderable" : false},
            ],
            "lengthMenu": [25, 50, 100, 200],
            "pageLength": 25,
            "order": [[ 0, "desc" ]],
            "columnDefs": [
                { width: 100, targets: [ 0, 1, 2, 3 ] },
                { width: 150, targets: [ 4 ] },
                { width: 30, targets: [ 5 ] },
            ],
            "language": {
                "url": "{!! url('vendor/datatables/Italian.json') !!}"
            },
            "drawCallback": function( settings, json) {
                $(change);
                $(getDati);
            },
        });
    });

    /*
    * Funzione che mostra i dati di un record della tabella
    */
    var getDati = function(){
        $('.datiButton').on('click',function(e){
        var id = $(this).attr('evento');
        e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/logeventi/" + id,
                type: "GET",
                dataType: "json",
                data: {
                    id: id
                },
                success: function(returnValue) {
                    $('#areaDati').val(returnValue);
                    $('#areaDati').html(function(){
                        for(var i = 0; i < Object.keys(returnValue).length; i++) {
                            var str = Object.keys(returnValue)[i];
                            var strValue = Object.values(returnValue)[i];
                            if(!(str == 'occorrenze' || str == 'occorrenza_iniziale' || str == 'procedi' || str == 'id' || str == 'NAB' || str == 'created_at' || str == 'updated_at' || str == 'deleted_at' || str == 'numero_immagini_da_inserire'))
                            {
                                str = str.split('_').join(' ');
                                if(str != null && strValue != null){
                                    if(typeof strValue == "object"){
                                        for(var j = 0; j < Object.keys(strValue).length; j++) {
                                            subStr = Object.keys(strValue)[j];
                                            subStr = subStr.split('_').join(' ');
                                            subStrValue = Object.values(strValue)[j];
                                            if(!(subStr == 'occorrenze' || subStr == 'occorrenza_iniziale' || subStr == 'procedi' || subStr == 'id' || subStr == 'NAB' || subStr == 'created_at' || subStr == 'updated_at' || subStr == 'deleted_at' || subStr  == 'numero_immagini_da_inserire'))
                                            {  
                                                if(typeof subStrValue == "object" && subStrValue != null)
                                                {
                                                    for(var k = 0; k < Object.keys(subStrValue).length; k++) {
                                                        subSubStr = Object.keys(subStrValue)[k];
                                                        subSubStr = subSubStr.split('_').join(' ');
                                                        subSubStrValue = Object.values(subStrValue)[k];
                                                        if(!(subSubStr == 'occorrenze' || subSubStr == 'occorrenza_iniziale' || subSubStr == 'procedi' || subSubStr == 'id' || subSubStr == 'NAB' || subSubStr == 'created_at' || subSubStr == 'updated_at' || subSubStr == 'deleted_at' || subSubStr == 'numero_immagini_da_inserire'))
                                                        {
                                                            if(typeof subSubStrValue == "object" && subSubStrValue != null)
                                                            {
                                                                for(var l = 0; l < Object.keys(subSubStrValue).length; l++) {
                                                                    subSubSubStr = Object.keys(subSubStrValue)[l];
                                                                    subSubSubStr = subSubSubStr.split('_').join(' ');
                                                                    subSubSubStrValue = Object.values(subSubStrValue)[l];
                                                                    if(!(subSubSubStr == 'occorrenze' || subSubSubStr == 'occorrenza_iniziale' || subSubSubStr == 'procedi' || subSubSubStr == 'id' || subSubSubStr == 'NAB' || subSubSubStr == 'created_at' || subSubSubStr == 'updated_at' || subSubSubStr == 'deleted_at' || subSubSubStr == 'numero_immagini_da_inserire'))
                                                                    {
                                                                        if(subSubSubStrValue != null)
                                                                        {
                                                                            subSubSubStrValue = subSubSubStrValue.split('_').join(' ');
                                                                            $('#bodyTable').append("<tr><td>" + (subSubSubStr.charAt(0).toUpperCase()) + subSubSubStr.slice(1)  + "</td>" + "<td>" + (subSubSubStrValue.charAt(0).toUpperCase()) + subSubSubStrValue.slice(1)  + "</td></tr>");
                                                                        }
                                                                        else
                                                                        {
                                                                            $('#bodyTable').append("<tr><td>" + (subSubSubStr.charAt(0).toUpperCase()) + subSubSubStr.slice(1)  + "</td>" + "<td>" + "Non presente"  + "</td></tr>");
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            else
                                                            {
                                                                if(subSubStrValue != null)
                                                                {
                                                                    subSubStrValue = subSubStrValue.split('_').join(' ');
                                                                    $('#bodyTable').append("<tr><td>" + (subSubStr.charAt(0).toUpperCase()) + subSubStr.slice(1)  + "</td>" + "<td>" + (subSubStrValue.charAt(0).toUpperCase()) + subSubStrValue.slice(1)  + "</td></tr>");
                                                                }
                                                                else
                                                                {
                                                                    $('#bodyTable').append("<tr><td>" + (subSubStr.charAt(0).toUpperCase()) + subSubStr.slice(1)  + "</td>" + "<td>" + "Non presente"  + "</td></tr>");
                                                                }
                                                            }
                                                        }
                                                    }   
                                                }
                                                else
                                                {
                                                    if(subStrValue != null)
                                                    {
                                                        subStrValue = subStrValue.split('_').join(' ');
                                                        $('#bodyTable').append("<tr><td>" + (subStr.charAt(0).toUpperCase()) + subStr.slice(1)  + "</td>" + "<td>" + (subStrValue.charAt(0).toUpperCase()) + subStrValue.slice(1)  + "</td></tr>");
                                                    }
                                                    else
                                                    {
                                                        $('#bodyTable').append("<tr><td>" + (subStr.charAt(0).toUpperCase()) + subStr.slice(1)  + "</td>" + "<td>" + "Non presente"  + "</td></tr>");
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        if(strValue.toString().includes('_'))
                                        {
                                            strValue = strValue.split('_').join(' ');
                                        }
                                        $('#bodyTable').append("<tr><td>" + (str.charAt(0).toUpperCase()) + str.slice(1)  + "</td>" + "<td>" + (strValue.toString().charAt(0).toUpperCase()) + strValue.toString().slice(1)  + "</td></tr>");
                                    }
                                }
                            }   
                        }
                    });
                }, 
                error: function(response, stato) {
                    showNotification('alert-danger', response.responseJSON.message, 'top', 'right', null, null);
                }
            });
        });
    }

    $('#closeModal').click(function(){
        $('#headTable').html("");
        $('#bodyTable').html("");
    });

    $("#largeModal").on("hidden.bs.modal", function () {
        $('#headTable').html("");
        $('#bodyTable').html("");
    });

    /*var change = function(){
        $('.dataTables_filter').replaceWith( "<div id=\"log_eventi_table_filter\" class=\"dataTables_filter\"><label>Cerca Eventi:<input type=\"search\" class=\"form-control input-sm\" placeholder=\"\" aria-controls=\"log_eventi_table\"></label></div>" );
    }*/
    
    var change = function(){
        $('#log_eventi_table_filter label').contents().eq(0).replaceWith('Cerca Eventi: ');
    }

</script>
@endsection
