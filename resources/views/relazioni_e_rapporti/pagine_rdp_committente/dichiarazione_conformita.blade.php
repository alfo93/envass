<!--pagina 11 -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group mb-0">
            <ul>
                <li style="font-size: 20px; margin-bottom:0.2cm;">
                    <b>Dichiarazione di conformità</b>
                </li>
                <li style="font-size: 16px; list-style-type: none;">
                    Alla data di produzione del presente documento, in relazione ai soli campioni riportati, i valori di CMT
                    <input class="mr-0 mb-1" style="width: 300px; height: 20px;" type="text" name="superano" class="form-control" value="{{ $anteprima == 1 && isset($rdp_anteprima->superano) ? $rdp_anteprima->superano : '' }}"> i limiti indicati dalle Linee Guida <input class="mr-0 mb-1" style="width: 300px; height: 20px;" type="text" name="lineeguida1_page11" class="form-control" value="{{ $anteprima == 1 && isset($rdp_anteprima->lineeguida1) ? $rdp_anteprima->lineeguida1 : '' }}" ><br>
                    La ricerca dei patogeni indicati nelle Linee Guida <input class="mr-0 mb-1" style="width: 300px; height: 20px;" type="text" name="lineeguida2_page11" class="form-control" value="{{ $anteprima == 1 && isset($rdp_anteprima->lineeguida2) ? $rdp_anteprima->lineeguida2 : '' }}" > ha dato esito <input class="mr-0 mb-1" style="width: 300px; height: 20px;" type="text" name="esito" class="form-control" value="{{ $anteprima == 1 && isset($rdp_anteprima->esito) ? $rdp_anteprima->esito : '' }}" > per il seguente campione: <input class="mr-0 mb-1" style="width: 300px; height: 20px;" type="text" name="campione_esito" class="form-control" value="{{ $anteprima == 1 && isset($rdp_anteprima->campione_esito) ? $rdp_anteprima->campione_esito : '' }}" >
                    <br> La dichiarazione di conformità si basa sul confronto del risultato con i limiti di riferimento, <input class="mr-0 mb-1" style="width: 600px; height: 20px;" type="text" name="no_incertezza" class="form-control" value="{{ ($anteprima == 1 && isset($rdp_anteprima->no_incertezza)) ? $rdp_anteprima->no_incertezza : 'senza considerare l\'incertezza di misura associata al risultato' }}">
                </li>
                <li style="font-size: 20px; margin-bottom:0.2cm;">
                    <b>Obiettivi della prova</b>
                </li>
                <li style="font-size: 16px; list-style-type: none;">
                    Determinazione della carica microbiologica ambientale per la valutazione della qualità dell'aria e dell'efficacia delle sanitizzazioni in ambienti ad elevata sterilità. <br>
                    Nello specifico si sono svolti i controlli per verificare il corretto funzionamento dell'impianto di VCCC (ventilazione e 
                    condizionamento a contaminazione controllata) e la valutazione dell'attività di manutenzione, con particolare riguardo 
                    alla filtrazione dell'aria.
                </li>
            </ul>
        </div>      
    </div>
</div>


