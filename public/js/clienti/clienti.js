$('#aggiungi_cliente').on('click',function(e){
    e.preventDefault();
    var nome = $('#nome_societa').val();
    var mail = $('#email_societa').val();
    var indirizzo = $('#indirizzo_societa').val();
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
            text: "Sei sicuro di aggiungere un nuovo committente?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, procedi",
            confirmButtonColor: "#8CD4F5",
            canceswallButtonText: "No, annulla",
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "/societa",
                    type: "POST",
                    dataType: "json",
                    data: {
                        nome: nome,
                        mail: mail,
                        indirizzo: indirizzo,
                        nome_contratto: nome_file
                    },
                    success: function(returnValue) {
                        $('#nome_societa').val('');
                        $('#email_societa').val('');
                        $('#indirizzo_societa').val('');
                        showNotification('alert-success',"Committente inserito correttamente", 'top', 'right', null, null);
                    }, 
                    error: function(response, stato) {
                        showNotification('alert-danger',"Si è verificato un problema con l'inserimento del committente, riprovare", 'top', 'right', null, null);
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
            text: "Sei sicuro di aggiungere un nuovo committente?",
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
                    url: "/societa",
                    type: "POST",
                    dataType: "json",
                    data: {
                        nome: nome,
                        mail: mail,
                        indirizzo: indirizzo,
                        contratto: reader.result,
                        nome_contratto: nome_file
                    },
                    success: function(returnValue) {
                        $('#nome_societa').val('');
                        $('#email_societa').val('');
                        $('#indirizzo_societa').val('');
                        //svuota l'input file
                        $('#carica_contratto').val('');
                        showNotification('alert-success',"Committente inserito correttamente", 'top', 'right', null, null);
                    }, 
                    error: function(response, stato) {
                        showNotification('alert-danger',"Si è verificato un problema con l'inserimento del nuovo committente, riprovare", 'top', 'right', null, null);
                    }
                });
            }
        });
    }
});