$('#societa_campagna').on('change',function(){
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
            replace_options_progetti($('#progetti_campagna'),$('#progetti_campagna').prev("div"),returnValue['progetti']);

        }, 
        error: function(response, stato) {
            showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
        }
    });  
});

$('#progetti_campagna').on('change',function(){
    var id_progetto = $(this).val();
    var id_societa = $('#societa_campagna').val();
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
            replace_options_strutture($('#struttura_campagna'),$('#struttura_campagna').prev("div"),returnValue['tot_strutture']);
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
            replace_options_reparti($('#partizione_campagna'),$('#partizione_campagna').prev('div'),returnValue['tot_reparti'])            
        }, 
        error: function(response, stato) {
            showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
        }
    });  
});

$('#partizione_campagna').on('change',function(){
    var reparto = $('#partizione_campagna').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/campagna/"+reparto+"/areapartizione",
        type: "GET",
        dataType: "json",
        data: {
            id_partizione: reparto
        },
        success: function(returnValue) {   
            // console.log(returnValue);
            replace_options_areapartizione($('#areapartizione_campagna'),$('#areapartizione_campagna').prev('div'),returnValue['tot_areapartizione'])            
        }, 
        error: function(response, stato) {
            showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
        }
    })          
});

$('#societa_campagna_committente').on('change',function(){
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
            replace_options_progetti($('#progetti_campagna_committente'),$('#progetti_campagna_committente').prev("div"),returnValue['progetti']);

        }, 
        error: function(response, stato) {
            showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
        }
    });  
});

$('#progetti_campagna_committente').on('change',function(){
    var id_progetto = $(this).val();
    var id_societa = $('#societa_campagna_committente').val();
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
            replace_options_strutture($('#struttura_campagna_committente'),$('#struttura_campagna_committente').prev("div"),returnValue['tot_strutture']);
        }, 
        error: function(response, stato) {
            showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
        }
    });  
});

$('#struttura_campagna_committente').on('change',function(){
    var id_progetto = $('#progetti_campagna_committente').val();
    var id_societa = $('#societa_campagna_committente').val();
    var struttura = $(this).val();
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
            replace_options_reparti($('#partizione_campagna_committente'),$('#partizione_campagna_committente').prev('div'),returnValue['tot_reparti'])            
        }, 
        error: function(response, stato) {
            showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
        }
    });  
});

$('#partizione_campagna_committente').on('change',function(){
    var reparto = $('#partizione_campagna_committente').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/campagna/"+reparto+"/areapartizione",
        type: "GET",
        dataType: "json",
        data: {
            id_partizione: reparto
        },
        success: function(returnValue) {   
            // console.log(returnValue);
            replace_options_areapartizione($('#areapartizione_campagna_committente'),$('#areapartizione_campagna_committente').prev('div'),returnValue['tot_areapartizione'])            
        }, 
        error: function(response, stato) {
            showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
        }
    })          
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

function replace_options_reparti(select,dropdownSelect,array)
{
    $(select).empty();
    $(dropdownSelect).children().empty();
    if(array.length == 0)
    {
        let newOption = new Option('-- Non sono presenti reparti --', 'tutti');
        $(select).append(newOption);
        liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti partizioni -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
        $(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti partizioni --');
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

function replace_options_areapartizione(select,dropdownSelect,array)
{
    $(select).empty();
    $(dropdownSelect).children().empty();
    if(array.length == 0)
    {
        let newOption = new Option('-- Non sono presenti aree per le partizioni selezionate --', 'nessuna');
        $(select).append(newOption);
        liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Non sono presenti aree per le partizioni selezionate -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
        $(dropdownSelect).prev('button').children('.filter-option').text('-- Non sono presenti aree per le partizioni selezionate --');
        $(dropdownSelect).children().append(liOption);
    }
    else
    {
        let tutti = new Option('-- Seleziona un\'opzione --','nessuna');
        $(select).append(tutti);
        liOption = '<li data-original-index="0" class="selected"><a tabindex="'+0+'" data-tokens="null"><span class="text"> -- Seleziona un\'opzione -- </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
        $(dropdownSelect).prev('button').children('.filter-option').text('-- Seleziona un\'opzione --');
        $(dropdownSelect).children().append(liOption);

        $.each(array, function (i, item) {
            i = i+1;
            let newOption = new Option(item.areapartizione, item.id); //item.areapartizione corrisponde all'area riferita alla partizione scelta, l'id si riferisce alla coppia (partizione - area)
            $(select).append(newOption);
            let liOption;
            liOption = '<li data-original-index="'+i+'" class><a tabindex="'+0+'" data-tokens="null"><span class="text">'+item.areapartizione+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
            $(dropdownSelect).children().append(liOption);
        });
    }
}

// //display one image uploaded from user
// carica_planimetria.onchange = evt => {
    
//     //delete all child node of div
//     while (document.getElementById('appendIMG').firstChild) {
//         document.getElementById('appendIMG').removeChild(document.getElementById('appendIMG').firstChild);
//     }

//     //display all images uploaded from user
//     for(let i = 0; i < evt.target.files.length; i++) {

        

//         //create element img for every image uploaded
//         const img = document.createElement('img');
//         const [file] = carica_planimetria.files;
//         img.src = URL.createObjectURL(evt.target.files[i]);
//         img.width = 1000;
        
//         //append img element to div
//         document.getElementById('appendIMG').appendChild(img);


//         // const [file] = carica_planimetria.files
//         // if (file) {
//         //     preview_image.src = URL.createObjectURL(file)
//         //     //reduce size of preview image
//         //     preview_image.style.width = "90%";
//         // }
//     }
// }  



// var counter = 0;
// $('#addRows').on('click',function(){
//     counter = (counter*1) + 1;
//     var row = new_row();
//     new_cell(row,'id_campione_'+counter)
//     new_cell(row,'codice_campione_'+counter)
//     new_cell(row,'punto_camp_'+counter)
//     new_cell(row,'tipo_camp_'+counter)
//     new_cell(row,'micro_identificatoSA_'+counter)
//     new_cell(row,'micro_identificatoE_'+counter)
//     new_cell(row,'micro_identificatoP_'+counter)
//     new_cell(row,'micro_identificatoANF_'+counter)
//     var counterRighe = document.getElementById('counterRighe');
//     counterRighe.value = (counter*1) + 1;
// });


// function new_row()
// {
//     var tbodyRef = document.getElementById('addRowTable').getElementsByTagName('tbody')[0];
    
//     return tbodyRef.insertRow();   
// }

// function new_cell(row, name)
// {
//     var newCell = row.insertCell();

//     //creo il div class="row clearfix"
//     var row_div = document.createElement("div");
//     row_div.classList.add("row")
//     row_div.classList.add("clearfix")

//     //creo il div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
//     var col_div = document.createElement("div");
//     col_div.classList.add("col-lg-12");
//     col_div.classList.add("col-md-12");
//     col_div.classList.add("col-sm-12");
//     col_div.classList.add("col-xs-12");
//     col_div.classList.add("mb-0");
//     row_div.appendChild(col_div);

//     //creo il div class="form-group
//     var form_div = document.createElement("div");
//     form_div.classList.add("form-group");
//     form_div.classList.add("mb-0");
//     col_div.appendChild(form_div);

//     //creo input type="text"
//     var input = document.createElement("input");
//     input.type = "text";
//     input.name = name;
//     input.value = "";
//     input.classList.add("form-control");
//     form_div.appendChild(input);

//     //faccio l'append nell'elemento
//     newCell.appendChild(row_div);
// }

$('#approvazione').on('change',function(){
    if($('#no_approvazione').is(':checked'))
    {
        $('#mancata_approvazione').removeClass('hidden');
    }
    else
    {
        $('#mancata_approvazione').addClass('hidden');
    }
})

//get number of files uploaded 
var fileCount = 0;
$('#carica_planimetria').on('change',function(){
    fileCount = this.files.length;
    //delete all child node of div
    while (document.getElementById('appendIMG').firstChild) {
        document.getElementById('appendIMG').removeChild(document.getElementById('appendIMG').firstChild);
    }
    for(let i = 0; i < fileCount; i++)
    {
        var img = document.createElement('img');
        img.src = URL.createObjectURL(this.files[i]);
        img.width = 1000;
        document.getElementById('appendIMG').appendChild(img);
    }
    var html = $('#to_clone').html();
    for(let i = fileCount; i >= 1 ; i--)
    {
        var new_html = html.replace(/0/g,i);
        $('#to_clone').after(new_html);
        $('#label_caption_'+i).attr('for','caption_'+i);
        $('#input_caption_'+i).attr('name','caption_'+i);
        $('#label_caption_'+i).text('Descrizione della foto '+i);
    }
})

$('.elimina_foto').on('click',function(){
    var id_planimetria = $(this).attr('id_planimetria');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/planimetrie_anteprime/delete",
        type: "post",
        dataType: "json",
        data: {
            id_planimetria: id_planimetria
        },
        success: function(returnValue) {   
            showNotification('alert-success',"Foto eliminata con successo", 'top', 'right', null, null);
            $('#planimetria_'+id_planimetria).addClass('hidden');
            $('#caption_planimetria_'+id_planimetria).addClass('hidden');
            $('#elimina_foto_'+id_planimetria).addClass('hidden');
        }, 
        error: function(response, stato) {
            showNotification('alert-danger',"Si è verificato un problema, riprovare", 'top', 'right', null, null);
        }
    }); 
})

