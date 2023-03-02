/**
* Per Campione SWAB
*/
elimina_antibiogrammaswab(1);
elimina_antibiogrammaswab(2);
elimina_antibiogrammaswab(3);
elimina_antibiogrammaswab(4);
elimina_antibiogrammaswab(5);
elimina_antibiogrammaswab(6);
elimina_antibiogrammaswab(7);
elimina_antibiogrammaswab(8);
elimina_antibiogrammaswab(9);
elimina_antibiogrammaswab(10);
elimina_antibiogrammaswab(11);
elimina_antibiogrammaswab(12);


function elimina_antibiogrammaswab(occorrenza)
{
    $('#cancella_antibiogramma_swab_'+occorrenza).on('click',function(e){
        e.preventDefault();
        let aa = [];
        var nab = $('#NAB_'+occorrenza).attr('nab_value');
        $("#text_area_antibiotico_resistenza_"+occorrenza+" > option").each(function() {
            var antibiotico_antibiogramma = {'id_aa':$(this).val()};
            aa.push(antibiotico_antibiogramma);
        });
        var colonia = $('#colonia_'+occorrenza).attr('colonia_value');
        var nome_file = $('#img_piastra_'+occorrenza).attr('nome_file');
        var tipo = $('#img_piastra_'+occorrenza).attr('tipo');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        swal({
            title: "Sei sicuro?",
            text: "Confermi di voler eliminare il seguente antibiogramma?",
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
                    url: "/microantibiogrammaswab/delete",
                    type: "POST",
                    dataType: "json",
                    data: {
                        aa:aa,
                        nab:nab,
                        colonia:colonia,
                        nome_file:nome_file,
                        id_campione:idCampione,
                        tipo:tipo
                    },
                    success: function(returnValue) {
                        $('#deletable_'+occorrenza).addClass('hidden');
                        showNotification('alert-success',"Antibiogramma eliminato correttamente", 'top', 'right', null, null);
                    }, 
                    error: function(response, stato) {
                        showNotification('alert-danger',"Si è verificato un problema con l'eliminazione di un antibiogramma, riprovare", 'top', 'right', null, null);
                    }
                });
            }
        });
    })
}
/**************************************************************************** */
