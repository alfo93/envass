<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <!-- div contenitore di informazioni utili per la corretta compilazione e salvataggio -->
        <div code="{{ $code }}" tipo="{{ $tipo }}" numeroProgressivo="{{ $numeroProgressivo ?? 0 }}" id_campione="{{ (isset($campione) && $numeroProgressivo == 0) ? $campione->id : '' }}" id_campagna="{{ $campagna->id }}" class="code_image nprogressivo id_campione id_campagna tipo"></div>
        <!-- -->
        <div class="card card-collapsable">
            <div class="header">
                <h2 class="collapsable-handler">Anagrafica campionamento</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="collapsable-handler">
                            <i class="material-icons">more_vert</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body body-collapsable demo-masked-input">
                <!-- DataCampagna DataCampionamento-->
                <div class="row clearfix mt-2">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label for="dataCampagna">Data campagna</label>
                        <div class="form-group">  
                            <div class="form-line">
                                <input type="date" id="dataCampagna" class="form-control" name="dataCampagna" placeholder="Inserisci la data" value="{{ old('dataCampagna') ?? $campagna->dataCampagna ?? (isset($campione) ? (isset($campione->dataCampagna) ? $campione->dataCampagna->format('Y-m-d') : '') : Carbon\Carbon::now()->format('Y-m-d')) ?? '' }}" maxlength="255">
                            </div>
                            <div class="help-info">data inizio campagna</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label for="dataCampionamento">Data campionamento</label>
                        <div class="form-group">  
                            <div class="form-line">
                                <input type="date" id="dataCampionamento" class="form-control" name="data" placeholder="Inserisci la data" value="{{ old('data') ?? ($numeroProgressivo > 0) ? $campione->data->format('Y-m-d') : ((isset($campione) && isset($campione->data)) ? $campione->data->format('Y-m-d') : Carbon\Carbon::now()->format('Y-m-d')) ?? '' }}" maxlength="255">
                            </div>
                            <div class="help-info">data campionamento</div>
                        </div>
                    </div>
                </div>
                <!-- Rilevatori -->
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                        <label for="rilevatore">Campionatori</label>
                        <div class="form-group"> 
                            <select class="form-control show-tick" multiple="" id="rilevatore_campionamento" name="rilevatore">
                                <option value="tutti">-- Seleziona un opzione --</option>
                                @if(isset($campione) && $numeroProgressivo == 0) <!-- sto facendo una edit della scheda -->
                                    @foreach($rilevatori as $rilevatore)
                                            @if($cp[$rilevatore->id] == 1)
                                                <option value="{{ $rilevatore->id }}" selected descrizione="{{ getDescrizioneRilevatore($rilevatore->getDescrizione(),$rilevatore->rilevatore) }}">{{ $rilevatore->rilevatore }}</option>
                                            @else
                                                <option value="{{ $rilevatore->id }}" descrizione="{{ getDescrizioneRilevatore($rilevatore->getDescrizione(),$rilevatore->rilevatore) }}">{{ $rilevatore->rilevatore }}</option>                       
                                            @endif
                                    @endforeach
                                @elseif(isset($campione) && $numeroProgressivo > 0) <!-- sto accedendo ad una nuova scheda a partire da una appena salvata -->
                                    @foreach($rilevatori as $rilevatore)
                                            @if($cp[$rilevatore->id] == 1)
                                                <option value="{{ $rilevatore->id }}" selected descrizione="{{ getDescrizioneRilevatore($rilevatore->getDescrizione(),$rilevatore->rilevatore) }}">{{ $rilevatore->rilevatore }}</option>
                                            @else
                                                <option value="{{ $rilevatore->id }}" descrizione="{{ getDescrizioneRilevatore($rilevatore->getDescrizione(),$rilevatore->rilevatore) }}">{{ $rilevatore->rilevatore }}</option>                       
                                            @endif
                                    @endforeach
                                @else <!-- sto creando una nuova scheda -->
                                    @foreach($rilevatori as $rilevatore)
                                        <option value="{{ $rilevatore->id }}" descrizione="{{ getDescrizioneRilevatore($rilevatore->getDescrizione(),$rilevatore->rilevatore) }}">{{ $rilevatore->rilevatore }}</option>
                                    @endforeach
                                @endif
                            </select>    
                            <div class="rilevatore_descrizione help-info"></div>
                        </div>
                    </div>
                </div>
                <!-- TipoTest -->
                <div class="row clearfix mt-2">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                       <label>Tipo di Test</label>
                       <div class="form-group">
                           <div class="form-line">
                               <select class="form-control show-tick" id="tipotest" name="tipotest">
                                   <option value="">-- Seleziona un opzione --</option>
                                   <option value="1" {{ isset($campione) ? is_selected_option($campione->tipoTest,1) : '' }}>Ripetibilità Conta</option>
                                   <option value="2" {{ isset($campione) ? is_selected_option($campione->tipoTest,2) : '' }}>Ripetibilità Campionamento</option>
                                   <option value="3" {{ isset($campione) ? is_selected_option($campione->tipoTest,3) : '' }}>Proficiency Test</option>
                                   <option value="4" {{ isset($campione) ? is_selected_option($campione->tipoTest,4) : '' }}>Recupero</option></select>
                               </select>
                               <div class="help-info">Tipologia di test</div>                           
                           </div>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="campionamento_qualita" class="row clearfix hidden">
    <div class="block-header pl-1-2">
        <h2>
            <small>Campionamento</small>
        </h2>
    </div>
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
                                <span><i class="help-icon material-icons" id="help_aria" type="button" data-html="true"  data-toggle="modal" data-target="#largeModal">help</i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- procedura -->
                <div id="p_superficie" class="row clearfix hidden">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <label for="procedura">Procedura</label>
                                <div class="form-group">  
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="procedura_aria_sup" name="procedura">
                                            <option value="">-- Seleziona un opzione --</option>
                                            <option value="1">PR_PDP_01_CONT_TOT_SUP_Rev00(UNI_EN_ISO 14698-1:2004)</option>
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
                                            <option value="1">PR_PDP_02_CONT_TOT_AIR_LAV_Rev00(UNI EN ISO 13098:2019)</option>
                                            <option value="2">PR_PDP_03_CONT_TOT_AIR_OP_Rev00(UNI EN ISO 14698-1:2004)</option>
                                        </select>     
                                        <div class="help-info">Procedure</div>                              
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
<div class="modal fade in" id="largeModal" tabindex="-1" role="dialog" style="display: none; padding-right: 15px;">
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