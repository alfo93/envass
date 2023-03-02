<!--pagina 13 -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group mb-0">
            <ul>
                <li style="font-size: 20px; margin-bottom:0.2cm;">
                    <b>Opinioni ed Interpretazioni non oggetto di accreditamento ACCREDIA</b>
                </li>
                <li style="font-size: 16px; list-style-type: none;">
                    <div style="text-align: left; border-collapse: separate; border: 0cm; padding-right: 30px;">
                        In relazione ai risultati ottenuti, in base a quanto indicato dalle Linee Guida di riferimento <input class="mr-0 mb-1" style="width: 300px; height: 20px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143; " type="text" name="opinioni_ed_interpretazioni_lineeguida" value="{{ isset($rdp_anteprima->opinioni_ed_interpretazioni_lineeguida) && $anteprima == 1 ? $rdp_anteprima->opinioni_ed_interpretazioni_lineeguida : $lineeguida_testo }}">
                        si suggerisce di 
                    </div>
                    <div style="text-align: left; border-collapse: separate; border: 0cm; width: 800px; padding-top: 10px;">
                        <select class="form-control show-tick" name="opinioni_ed_interpretazioni" size="10">
                            <option value="procedere con il controllo microbiologico con valutazione temporale come di consueto" {{ is_selected_option(isset($rdp_anteprima->opinioni_ed_interpretazioni) && $anteprima == 1 ? $rdp_anteprima->opinioni_ed_interpretazioni : '','procedere con il controllo microbiologico con valutazione temporale come di consueto')}}>procedere con il controllo microbiologico con valutazione temporale come di consueto</option>
                            <option value="rivedere interamente il protocollo di pulizia e programmare nuovi controlli" {{ is_selected_option(isset($rdp_anteprima->opinioni_ed_interpretazioni) && $anteprima == 1 ? $rdp_anteprima->opinioni_ed_interpretazioni : '','rivedere interamente il protocollo di pulizia e programmare nuovi controlli')}}>rivedere interamente il protocollo di pulizia e programmare nuovi controlli</option>
                        </select>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group mb-0">
            <ul>
                <li style="font-size: 20px; margin-bottom:0.2cm;">
                    <b>Note di revisione</b>
                </li>
                <li style="font-size: 16px; list-style-type: none;">
                    <div style="text-align: left; border-collapse: separate; border: 0cm; padding-right: 30px;">
                        <textarea class="form-control" style="min-height: 50px; padding-left: 10px; background-color: rgb(213, 208, 208);" name="note_di_revisione" rows="5" cols="50" placeholder="Inserisci qui le note"></textarea>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>


