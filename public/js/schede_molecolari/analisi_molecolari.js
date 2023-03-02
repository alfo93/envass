$('#carica_file').on('change',function(){
    check_submit();
});

function check_submit()
{
    if($('input[type="file"]').val()) {
        $('#checkfile').removeClass('hidden');
        $('#checkfile').text($('input[type="file"]')[0].files[0].name);
    }
}