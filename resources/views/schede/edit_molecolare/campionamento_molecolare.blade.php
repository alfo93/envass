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
                                <input type="radio" name="tipoCamp" id="superficie" class="with-gap" value="{{ isset($campione) ? $campione->tipoCamp : 'S'}}">
                                <label for="superficie"><b>Superficie</b></label>
                                <input type="radio" name="tipoCamp" id="aria" class="with-gap" value="{{ isset($campione) ? $campione->tipoCamp : 'A'}}">
                                <label for="aria" class="m-l-20"><b>Aria</b></label>
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
                                    <select class="form-control show-tick" id="categoria" name="id_categoria">
                                        <option value="">-- Seleziona un opzione --</option>
                                        @foreach($categorie as $categoria)
                                        <option value="{{ old('id_categoria') ?? $categoria->id }}" {{ (isset($campione) && $numeroProgressivo == 0) ? ($campione->puntocampionamento != null ? is_selected_option($campione->puntocampionamento->categoria->id, $categoria->id) : '') : '' }}>{{ $categoria->categoria }}</option>
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
                                    <select class="form-control show-tick" id="punto_campionamento" name="id_punto_camp">
                                        <option value="">-- Seleziona un punto di campionamento --</option>
                                        @if((isset($campione) && $numeroProgressivo == 0) && $campione->puntocampionamento != null)
                                            @foreach(getPuntoCampPerCategoria($campione->puntocampionamento->categoria->id, 'S') as $pc)
                                            <option value="{{ old('id_punto_camp') ?? $pc->id }}" {{(isset($campione) && $numeroProgressivo == 0) ? is_selected_option($campione->id_punto_camp, $pc->id) : '' }}>{{ $pc->punto_campionamento }}</option>
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
                                    <select class="form-control show-tick" id="materiale" name="id_superficie">
                                        <option value="">-- Seleziona un opzione --</option>
                                        @foreach($materiali as $materiale)
                                        <option value="{{ old('id_superficie') ?? $materiale->id}}" {{ (isset($campione) && $numeroProgressivo == 0) ? is_selected_option($campione->id_superficie, $materiale->id) : '' }}>{{ $materiale->materiale }}</option>
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
                                    <select class="form-control show-tick" id="prodotto" name="id_prodotto">
                                        <option value="">-- Seleziona un opzione --</option>
                                        @foreach($prodotti as $prodotto)
                                        <option value="{{ old('id_prodotto') ?? $prodotto->id}}" {{(isset($campione) && $numeroProgressivo == 0) ? is_selected_option($campione->id_prodotto, $prodotto->id) : '' }}>{{ $prodotto->prodotto }}</option>
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
                                    <select class="form-control show-tick" id="protocollo" name="id_protocollo">
                                        <option value="">-- Seleziona un opzione --</option>
                                        @foreach($protocolli as $protocollo)
                                        <option value="{{ old('id_protocollo') ?? $protocollo->id }}" {{ (isset($campione) && $numeroProgressivo == 0) ? is_selected_option($campione->id_protocollo, $protocollo->id) : '' }}>{{ $protocollo->protocollo }}</option>
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
                                    <input type="number" id="tdaSanif" class="form-control" name="tdaSanif" placeholder="" value="{{ old('tdaSanif') ?? $campione->tdaSanif ?? '' }}" maxlength="2" style="border-style: solid; border-width: 1px; padding-left: 2px">
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
                                    <input type="number" id="fase_Camp" class="form-control" name="fase_Camp" placeholder="" value="{{ old('fase_Camp') ?? ((isset($campione) && $numeroProgressivo == 0) ? $campione->fase_Camp : '') ?? '' }}" maxlength="1" style="border-style: solid; border-width: 1px; padding-left: 2px">
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
                                        <input name="VCCC" type="checkbox" id="VCCC" class="filled-in chk-col-blue" {{ (isset($campione) && $campione->VCCC == 1) ? 'checked' : '' }}>
                                        <label for="VCCC">Impianto VCCC</label> 
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
                                        <input type="radio" value="L" name="flusso" id="laminare" class="with-gap" {{ (isset($campione) && $numeroProgressivo == 0) ? is_checked($campione->flusso == 'L' ? 1 : '') : '' }}>
                                        <label for="laminare"><b>Laminare/Unidirezionale</b></label>
                                    </td>
                                    <td>
                                        <input type="radio" value="T" name="flusso" id="turbolento" class="with-gap" {{ (isset($campione) && $numeroProgressivo == 0) ? is_checked($campione->flusso == 'T' ? 1 : '') : '' }}>
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
                                        <input type="radio" value="O" name="operat" id="operational" class="with-gap" {{ (isset($campione) && $numeroProgressivo == 0) ? is_checked($campione->operat == 'O' ? 1 : '') : '' }}>
                                        <label for="operational"><b>Operational</b></label>
                                    </td>
                                    <td class="pb-2">
                                        <input type="radio" value="R" name="operat" id="at_rest" class="with-gap" {{ (isset($campione) && $numeroProgressivo == 0) ? is_checked($campione->operat == 'R' ? 1 : '') : '' }}>
                                        <label for="at_rest" class="m-l-20 ml-10"><b>At rest</b></label>
                                    </td>
                                    <td>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mb-3  operational w-a hidden">
                                            <label for="n_persone">Numero di persone</label>
                                            <div class="form-group">  
                                                <div class="form-line">
                                                    <input type="text" id="n_persone" class="form-control" name="n_persone" value="{{ old('n_persone') ?? $campione->n_persone ?? '' }}" maxlength="2" style="border-style: solid; border-width: 1px; padding-left: 2px">
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
                                            {{-- <select class="form-control show-tick" id="pCampAria" name="PCampAria">
                                                @if(isset($campione))
                                                    <option value="">-- Seleziona un opzione --</option>
                                                    @foreach($campione->get_pCampAria() as $key => $pcAria)
                                                    <option value="{{ $key }}" {{ is_selected_option($campione->PCampAria, $key) }}>{{ $pcAria }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">-- Seleziona un opzione --</option>
                                                    <option value="1">Diffusore/Plafone</option>
                                                    <option value="2">Centro stanza</option>
                                                @endif
                                            </select>      --}}
                                            <select class="form-control show-tick" id="pCampAria" name="PCampAria">
                                                <option value="">-- Seleziona un punto di campionamento --</option>
                                                @if((isset($campione) && $numeroProgressivo == 0) && $campione->puntocampionamento != null)
                                                    @foreach(getPuntoCampAria() as $pc)
                                                        <option value="{{ old('id_punto_camp') ?? $pc->id }}" {{(isset($campione) && $numeroProgressivo == 0) ? is_selected_option($campione->id_punto_camp, $pc->id) : '' }}>{{ ucfirst($pc->punto_campionamento) }}</option>
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
                                            <input type="number" id="codDiff" class="form-control" name="codDiff" value="{{ old('codDiff') ?? $campione->codDiff ?? '' }}" maxlength="1" style="border-style: solid; border-width: 1px; padding-left: 2px">
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