<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-collapsable">
            <div class="header">
                <h2 class="collapsable-handler">Campionamento</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="collapsable-handler">
                            <i class="material-icons">more_vert</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body body-collapsable demo-masked-input">
                <!-- Scelta del tipo di area -> Superficie o Aria -->
                <div class="row clearfix mt-2">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div id="campionamento_area" name="campionamento_area">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <label for="campionamento_area">Campionamento: </label> 
                            </div>
                            <div class="form-group">
                                <input type="radio" name="tipoCamp" id="superficie" class="with-gap" value="{{ isset($campione) ? $campione->tipoCamp : '' }}">
                                <label for="superficie"><b>Superficie</b></label>

                                <input type="radio" name="tipoCamp" id="aria" class="with-gap" value="{{ isset($campione) ? $campione->tipoCamp : '' }}">
                                <label for="aria" class="m-l-20"><b>Aria</b></label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- procedura -->
                {{-- <div id="p_superficie" class="row clearfix hidden">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <label for="procedura">Procedura</label>
                                <div class="form-group">  
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="procedura_aria_sup" name="procedura">
                                            <option value="">-- Seleziona un opzione --</option>
                                            <option selected value="1" {{ is_selected_option($campione->procedura ?? '',1) }}>PR_PDP_01_CONT_TOT_SUP_Rev00(UNI_EN_ISO 14698-1:2004)</option>
                                        </select>     
                                        <div class="help-info">Procedure</div>                              
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="p_aria" class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <label for="procedura">Procedura</label>
                                <div class="form-group">  
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="procedura_aria_sup" name="procedura">
                                            <option value="">-- Seleziona un opzione --</option>
                                            <option value="1" {{ is_selected_option($campione->procedura ?? '',1) }}>PR_PDP_02_CONT_TOT_AIR_LAV_Rev00(UNI EN ISO 13098:2019)</option>
                                            <option value="2" {{ is_selected_option($campione->procedura ?? '',2) }}>PR_PDP_03_CONT_TOT_AIR_OP_Rev00(UNI EN ISO 14698-1:2004)</option>
                                        </select>     
                                        <div class="help-info">Procedure</div>                              
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- metodo -->
                <div id="m_superficie" class="row clearfix hidden">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <label for="metodo">Metodo</label>
                                <div class="form-group">  
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="metodo_sup" name="metodo">
                                            <option value="">-- Seleziona un opzione --</option>
                                            <option value=""> Non Applicato </option>
                                            @foreach($metodi as $metodo)
                                                @if($metodo->tipo_campionamento == 'S')
                                                    <option value="{{ $metodo->id }}" {{ isset($campione) ? is_selected_option($campione->id_metodo ?? '',$metodo->id) : '' }}>{{ $metodo->metodo }}</option>
                                                @endif        
                                            @endforeach
                                        </select>     
                                        <div class="help-info" id="descrizione_prova_sup"></div>                              
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="m_aria" class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <label for="metodo">Metodo</label>
                                <div class="form-group">  
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="metodo_aria" name="metodo">
                                            <option value="">-- Seleziona un opzione --</option>
                                            <option value=""> Non Applicato </option>
                                            @foreach($metodi as $metodo)
                                                @if($metodo->tipo_campionamento == 'A')
                                                    <option value="{{ $metodo->id }}" {{ isset($campione) ? is_selected_option($campione->id_metodo ?? '',$metodo->id) : '' }}>{{ $metodo->metodo }}</option>
                                                @endif        
                                            @endforeach
                                        </select>     
                                        <div class="help-info" id="descrizione_prova_aria"></div>                              
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- -------------------------------- -->
                <!-- Superficie -->
                <!-- -------------------------------- -->
                <div class="superficie">
                    <!-- Punto di campionamento Descrizione Superficie -->
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="categoria">Punto di campionamento</label>
                            <div class="form-group">  
                                <div class="form-line">
                                    <select class="form-control show-tick" id="categoria" name="categoria">
                                        <option value="">-- Seleziona un opzione --</option>
                                        @foreach($categorie as $categoria)
                                        <option value="{{ $categoria->id }}" {{ (isset($campione) && $numeroProgressivo >= 0) ? ($campione->puntocampionamento != null ? is_selected_option(App\ConversioneCategoriaCategorie::categoriaV2($campione->puntocampionamento->categoria->id) ?? $campione->puntocampionamento->categoria->id, $categoria->id) : '') : '' }}>{{ ucfirst($categoria->categoria) }}</option>
                                        @endforeach
                                    </select>     
                                    <div class="help-info">Categoria del punto di campionamento</div>                              
                                </div>
                            </div> 
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="punto_campionamento">Descrizione</label>
                            <div class="form-group">  
                                <div class="form-line">
                                    <select class="form-control show-tick" id="punto_campionamento" name="punto_campionamento">
                                        <option value="">-- Seleziona un punto di campionamento --</option>
                                        @if((isset($campione) && $numeroProgressivo >= 0) && $campione->puntocampionamento != null)
                                            @foreach(getPuntoCampPerCategoria(App\ConversioneCategoriaCategorie::categoriaV2($campione->puntocampionamento->categoria->id) ?? $campione->puntocampionamento->categoria->id, 'S') as $pc)
                                            <option codice="{{ $pc->codPC }}" value="{{ $pc->id }}" {{(isset($campione) && $numeroProgressivo >= 0) ? is_selected_option(App\ConversionePuntiCampionamento::punto_campionamentoV2($campione->id_punto_camp) ?? $campione->id_punto_camp, $pc->id) : '' }}>{{ ucfirst($pc->punto_campionamento) }}</option>
                                            @endforeach
                                        @endif
                                    </select>     
                                    <div class="help-info">Descrizione della categoria del punto di campionamento</div>                              
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="materiale">Superficie</label>
                            <div class="form-group">  
                                <div class="form-line">
                                    <select class="form-control show-tick" id="materiale" name="materiale">
                                        <option value="">-- Seleziona un opzione --</option>
                                        @foreach($materiali as $materiale)
                                        <option value="{{ $materiale->id}}" {{ isset($campione) ? is_selected_option(App\ConversioneMateriale::materialeV2($campione->id_superficie) ?? $campione->id_superficie, $materiale->id) : '' }}>{{ ucfirst($materiale->materiale) }}</option>
                                        @endforeach
                                    </select>     
                                    <div class="help-info">Materiale della superficie</div>                              
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <!-- Prodotto Protocollo Tempo da sanificazione -->
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="prodotto">Prodotto sanificazione</label>
                            <div class="form-group">  
                                <div class="form-line">
                                    <select class="form-control show-tick" id="prodotto" name="prodotto">
                                        <option value="">-- Seleziona un opzione --</option>
                                        @foreach($prodotti as $prodotto)
                                        <option value="{{ $prodotto->id}}" {{(isset($campione) && $numeroProgressivo >= 0) ? is_selected_option($campione->id_prodotto, $prodotto->id) : '' }}>{{ $prodotto->prodotto }}</option>
                                        @endforeach
                                    </select>     
                                    <div class="help-info">Prodotto utilizzato</div>                              
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="protocollo">Protocollo sanificazione</label>
                            <div class="form-group">  
                                <div class="form-line">
                                    <select class="form-control show-tick" id="protocollo" name="protocollo">
                                        <option value="">-- Seleziona un opzione --</option>
                                        @foreach($protocolli as $protocollo)
                                        <option value="{{ $protocollo->id }}" {{ (isset($campione) && $numeroProgressivo >= 0) ? is_selected_option($campione->id_protocollo, $protocollo->id) : '' }}>{{ $protocollo->protocollo }}</option>
                                        @endforeach
                                    </select>     
                                    <div class="help-info">Protocollo utilizzato</div>                              
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 w-a">
                            <label for="tdaSanif">Tempo da sanificazione: H</label>
                            <div class="form-group">  
                                <div class="form-line">
                                    <input type="time" id="tdaSanif" class="form-control" name="tdaSanif" placeholder="" value="{{ old('tdaSanif') ??  (isset($campione) && $numeroProgressivo >= 0) ? gmdate('H:i',$campione->tdaSanif * 60) : '' }}" maxlength="2" style="border-style: solid; border-width: 1px; padding-left: 2px">
                                    <div class="help-info">Tempo dalla sanificazione</div>                              
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FaseCampionamento Protocollo Prodotto TempoDaSanificazione -->                    
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="fase_Camp">Fase campionamento: T</label>
                            <div class="form-group">  
                                <div class="form-line">
                                    <input type="number" id="fase_Camp" class="form-control" name="fase_Camp" placeholder="" value="{{ old('fase_Camp') ?? (isset($campione) && $numeroProgressivo >= 0) ? $campione->fase_Camp : '' ?? '' }}" maxlength="1" style="border-style: solid; border-width: 1px; padding-left: 2px">
                                    <div class="help-info">Fase di campionamento</div>                              
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>

                <!-- -------------------------------- -->
                <!-- Aria  -->
                <!-- -------------------------------- -->
                <div class="aria">
                    <div class="row clearfix">
                        <table>
                            <tbody>
                                <!-- VCCC -->
                                <tr>
                                    <td class="pl-1 pr-2 pb-1">
                                        <span><i class="help-icon material-icons" data-toggle="tooltip" data-placement="right" title="Impianto meccanico di Ventilazione per Ambienti a Contaminazione Controllata">help</i></span>
                                    </td>
                                    <td class="pb-1 pt-1">
                                        <input name="vccc" value="tutti" type="checkbox" id="vccc" class="filled-in chk-col-blue" {{ isset($campione) ? is_checked($campione->VCCC) : ''}}>
                                        <label for="vccc">Impianto VCCC</label> 
                                    </td>
                                    <td>
                                        <!--vuoto-->
                                    </td>
                                    <td>
                                        <!--vuoto-->
                                    </td>
                                    <td>
                                        <!--vuoto-->
                                    </td>
                                </tr>
                                <!-- Flusso -->
                                <tr>
                                    <td class="pl-1 pr-2 pb-1">
                                        <!--vuoto-->
                                    </td>
                                    <td class="pt-1 pb-2">
                                        <label class="mr-1" for="tipo_flusso">Tipo flusso: </label> 
                                    </td>
                                    <td>
                                        <input type="radio" name="flusso" id="laminare" class="with-gap" {{ (isset($campione) && $numeroProgressivo >= 0) ? is_checked($campione->flusso == 'L' ? 1 : '') : '' }}>
                                        <label for="laminare"><b>Laminare/Unidirezionale</b></label>
                                    </td>
                                    <td>
                                        <input type="radio" name="flusso" id="turbolento" class="with-gap" {{ (isset($campione) && $numeroProgressivo >= 0) ? is_checked($campione->flusso == 'T' ? 1 : '') : '' }}>
                                        <label for="turbolento" class="m-l-20"><b>Turbolento</b></label>
                                    </td>
                                    <td>
                                        <!--vuoto-->
                                    </td>
                                </tr>
                                 <!-- operatività -->
                                <tr>
                                    <td class="pl-1 pr-2 pb-2">
                                        <span><i class="help-icon material-icons" data-toggle="tooltip" data-placement="right" title="Analisi eseguite a porte chiuse">help</i></span>
                                    </td>
                                    <td class="pb-2">
                                        <label for="operativita">Operatività: </label> 
                                    </td>
                                    <td class="pb-2">
                                        <input type="radio" name="operat" id="operational" class="with-gap" {{ (isset($campione) && $numeroProgressivo >= 0) ? is_checked($campione->operat == 'O' ? 1 : '') : '' }}>
                                        <label for="operational"><b>Operational</b></label>
                                    </td>
                                    <td class="pb-2">
                                        <input type="radio" name="operat" id="at_rest" class="with-gap" {{ (isset($campione) && $numeroProgressivo >= 0) ? is_checked($campione->operat == 'R' ? 1 : '') : '' }}>
                                        <label for="at_rest" class="m-l-20 ml-10"><b>At rest</b></label>
                                    </td>
                                    <td>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mb-3  operational w-a hidden">
                                            <label for="n_persone">Numero di persone</label>
                                            <div class="form-group">  
                                                <div class="form-line">
                                                    <input type="text" id="n_persone" class="form-control" name="n_persone" placeholder="Inserisci eventuali dettagli" value="{{ old('n_persone') ?? $campione->n_persone ?? '' }}" maxlength="2" style="border-style: solid; border-width: 1px; padding-left: 2px">
                                                    <div class="help-info">numero persone</div>                              
                                                </div>
                                            </div>
                                        </div>                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <!-- PuntoCampionamento CodiceDiffusore/Plafone -->
                            <div class="row clearfix  mt-3">
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                    <label for="PCampAria">Punto di campionamento</label>
                                    <div class="form-group">  
                                        <div class="form-line">
                                            {{-- <select class="form-control show-tick" id="pCampAria" name="pCampAria">
                                                @if((isset($campione) && $numeroProgressivo >= 0))
                                                    <option value="">-- Seleziona un opzione --</option>
                                                    @foreach($campione->get_pCampAria() as $key => $pcAria)
                                                    <option value="{{ $key }}" {{ is_selected_option($campione->pCampAria, $key) }}>{{ $pcAria }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">-- Seleziona un opzione --</option>
                                                    <option value="1">Diffusore/Plafone</option>
                                                    <option value="2">Centro stanza</option>
                                                    <option value="3">Gravitazionale passivo</option>
                                                    <option value="4">Pass-box</option>
                                                @endif
                                            </select>      --}}
                                            <select class="form-control show-tick" id="pCampAria" name="pCampAria">
                                                @if((isset($campione)))
                                                    @foreach(getPuntoCampAria() as $pc)
                                                        <option value="{{ old('id_punto_camp') ?? $pc->id }}" {{(isset($campione)) ? is_selected_option($campione->pCampAria, $pc->id) : '' }}>{{ ucfirst($pc->punto_campionamento) }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach(getPuntoCampAria() as $pc)
                                                        <option value="{{ $pc->id }}">{{ ucfirst($pc->punto_campionamento) }}</option>
                                                    @endforeach
                                                @endif
                                            </select>    
                                            <div class="help-info">punto di campionamento</div>                              
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 hidden" id="codDiffHide">
                                    <label for="codDiff">Codice diffusore/Plafone: M</label>
                                    <div class="form-group">  
                                        <div class="form-line">
                                            <input type="number" id="codDiff" class="form-control" name="codDiff" value="{{ old('codDiff') ?? $campione->codDiff ?? '' }}" min="0" max="9" maxlenght="1" style="border-style: solid; border-width: 1px; padding-left: 2px">
                                            <div class="help-info">codice diffusore</div>                              
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade in" id="ariaModal" tabindex="-1" role="dialog" style="display: none; padding-right: 15px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ariaModalLabel">Campionamento su aria</h4>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="body table-responsive">
                        <table class="table">
                            <tbody>
                                <tr><td><p>Tipo di campionatore: Campionatore attivo monostadio ad impatto ortogonale</p></td></tr>
                                <tr><td>Nome del campionatore: Surface Air System (SAS) super ISO 180</td></tr>
                                <tr>
                                    <td>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pl-0">
                                            <label>Tipo di campionamento</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select class="form-control show-tick" id="tipoCampionamento" name="tipoCampionamento">
                                                        @foreach(App\Campione::$tipoCampionamento as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-info">Tipo di campionamento</div>                           
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr><td>Portata: 180 litri/minuto</td></tr>
                                <tr><td>Volume campionato: 1m3</td></tr>
                                <tr><td>Frazione campionata: frazione inalabile EN 481</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>            
            </div>
            <div class="modal-footer">
                <button type="button" id="chiudiStoria" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
            </div>
        </div>
    </div>
</div>
<!-- -->