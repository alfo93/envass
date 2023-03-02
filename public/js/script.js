/** 
 * Ritorna il formato data da utilizzare 
 */
function custom_date_format() {
    return 'dd/mm/yyyy';
}

/** 
 * Card Collassabile 
 * TODO: Servirebbe una piccola animazione per lo sliding
 */
function toggleCardCollapse($card) {
    var $body = $card.find('.body-collapsable')
    $body.toggleClass("open");
    if ($body.hasClass("open")) {
        $body.show();
        if ($body.hasClass("diagnosi-section") && typeof(morris) !== 'undefined') {
            if (morris == 0) {
                console.log("drawMorris");
                drawMorris();
                morris = 1;
            }
        }
    } else {
        $body.hide();
    }

}

$(document).ready(function() {
        
    /**
     * Attivo i tooltips
     */
    $("body").tooltip({ selector: '[data-toggle=tooltip]' });

    /** 
     * Gestisco il click per collassare o espandere le card
     */
    $('.collapsable-handler').bind('click', function() {
        var $card = $(this).parents('.card-collapsable');
        toggleCardCollapse($card);
    });

    /** 
     * Gestisco se sono prenseti errori nel form 
     */
    if ($('#errors-container').length > 0) {
        $('.card-collapsable').each(function(i, el) {
            toggleCardCollapse($(el));
        });
    }
    
    /** 
     * Disabilito l'autocompletamento per tutti i form
     * ATTENZIONE: Non funziona per Chrome
     */
    $('form').attr({
        autocorrect: "off",
        spellcheck: "false",
        autocomplete: "off"
    });

    $('input').attr({
        autocorrect: "off",
        spellcheck: "false",
        autocomplete: "off",
        autofill: "off"
    });

});
