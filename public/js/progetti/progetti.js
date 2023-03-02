$('#aggiungi_progetto').on('click',function(e){
    e.preventDefault();
    var nome = $('#nome_progetto').val();
    var codice = $('#codice_progetto').val();
    var societa = $('#societa_progetto option:selected').val();
    var data_inizio = $('#data_inizio_progetto').val();
    var tipo = $('#tipo option:selected').val();
    var stato = $('#attivo').val();

    var nome_societa = $('#societa_progetto option:selected').text();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    swal({
        title: "Sei sicuro?",
        text: "Sei sicuro di aggiungere un nuovo Progetto per la società: "+nome_societa+"?",
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
                url: "/progetti",
                type: "POST",
                dataType: "json",
                data: {
                    nome: nome,
                    codice: codice,
                    societa: societa,
                    data: data_inizio,
                    tipo: tipo,
                    stato: stato,
                },
                success: function(returnValue) {
                    $('#nome_progetto').val('');
                    $('#codice_progetto').val('');
                    $('#societa_progetto').val('');
                    $('#societa_progetto').trigger('change');
                    $('#tipo').val('');
                    $('#tipo').trigger('change');
                    $('#data_inizio_progetto').val('');
                    $('#attivo').val('');
                    showNotification('alert-success',"Attività inserita correttamente", 'top', 'right', null, null);
                }, 
                error: function(response, stato) {
                    showNotification('alert-danger',"Si è verificato un problema con l'inserimento della nuova attività, riprovare", 'top', 'right', null, null);
                }
            });
        }
    });
});
