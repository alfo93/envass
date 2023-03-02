<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <!-- div contenitore di informazioni utili per la corretta compilazione e salvataggio -->
        <div code="{{ $code }}" numeroProgressivo="{{ $numeroProgressivo ?? 0 }}" id_campione="{{ (isset($campione) && $numeroProgressivo == 0) ? $campione->id : '' }}" id_campagna="{{ $campagna->id }}" class="code_image nprogressivo id_campione id_campagna"></div>
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
                 <!-- -->
                <div class="hidden">
                    <input type="number" id="id_campagna" name="id_campagna" value="{{ $campagna->id }}" class="form-control">
                </div>
                <!-- -->
                <!-- Progetto -->
                <div class="row clearfix mt-2">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label>Attività</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control show-tick" id="progetto" name="id_progetto">
                                    <option value="tutti">-- Seleziona un opzione --</option>
                                    @if(isset($campione))
                                        <option value="{{ $progetti->id }}" {{ isset($campione) ? is_selected_option($campione->progetto->progetto, $progetti->progetto) : ''}}>{{ $progetti->progetto }}</option>
                                    @else
                                        @if(count($progetti) > 1)
                                            @foreach($progetti as $p)
                                                <option value="{{ $p->id }}">{{ $p->progetto }}</option>
                                            @endforeach
                                        @else
                                            <option selected value="{{ $progetti[0]->id }}">{{ $progetti[0]->progetto }}</option>
                                        @endif
                                    @endif
                                </select>     
                                <div class="help-info">attività</div>                           
                            </div>
                        </div>
                    </div>
                </div>
                <!-- DataCampagna DataCampionamento OraCampionamento-->
                <div class="row clearfix">
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
                                <input type="date" id="dataCampionamento" class="form-control" name="data" placeholder="Inserisci la data" value="{{ old('data') ?? (isset($campione) ?  (isset($campione->data) ? $campione->data->format('Y-m-d') : '') : Carbon\Carbon::now()->format('Y-m-d')) ?? '' }}" maxlength="255">
                            </div>
                            <div class="help-info">data campionamento</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>Ora campionamento</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="time" id="ora" name="ora" class="form-control" value="{{ old('ora') ?? (isset($campione) ? $campione->ora : '' ) ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                        <label for="rilevatori">Campionatore</label>
                        <div class="form-group"> 
                            <select class="form-control show-tick" multiple id="rilevatore_campionamento" name="id_rilevatore[]">
                                <option value="tutti">-- Seleziona un opzione --</option>
                                @if(isset($campione))
                                    @foreach($rilevatori as $rilevatore)
                                            @if($cp[$rilevatore->id] == 1)
                                                <option value="{{ old('id_rilevatore[]') ?? $rilevatore->id }}" selected descrizione="{{ getDescrizioneRilevatore($rilevatore->getDescrizione(),$rilevatore->rilevatore) }}">{{ $rilevatore->rilevatore }}</option>
                                            @else
                                                <option value="{{ old('id_rilevatore[]') ?? $rilevatore->id }}" descrizione="{{ getDescrizioneRilevatore($rilevatore->getDescrizione(),$rilevatore->rilevatore) }}">{{ $rilevatore->rilevatore }}</option>                       
                                            @endif
                                    @endforeach
                                @else
                                    @foreach($rilevatori as $rilevatore)
                                        <option value="{{ old('id_rilevatore[]') ?? $rilevatore->id }}" descrizione="{{ getDescrizioneRilevatore($rilevatore->getDescrizione(),$rilevatore->rilevatore) }}">{{ $rilevatore->rilevatore }}</option>
                                    @endforeach
                                @endif
                            </select>    
                            <div class="rilevatore_descrizione help-info"></div>
                        </div>
                    </div>
                </div>
                <!-- Stuttura Reparto -->
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label>Struttura</label>
                        <div class="form-group">
                            <select class="form-control show-tick" id="nome_struttura" name="id_struttura">
                                <option value="tutti">-- Seleziona un opzione --</option>
                                <option selected value="{{ old('id_struttura') ?? $strutture->id }}">{{ $strutture->struttura }}</option>
                            </select>  
                            <div class="help-info">Struttura</div>                           
                        </div>
                    </div>
                </div>
                <!-- Reparto CodiceStruttura -->
                <div class="row clearfix mt-2">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label>Reparto</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control show-tick" id="reparto" name="id_reparto">
                                    <option value="">-- Seleziona un opzione --</option>
                                     @foreach($areareparto as $ar)
                                         <option selected value="{{ old('reparto') ?? $ar->id_reparto }}" {{ (isset($campione) && isset($campione->reparto)) ? (is_selected_option($campione->reparto->id_reparto, $ar->id_reparto)) : ''}}>{{ App\Reparto::find($ar->id_reparto)->partizione }}</option> 
                                     @endforeach
                                </select>
                                <div class="help-info">Reparto</div>                           
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
                         <label for="area_reparto">area reparto</label>
                         <div class="form-group">  
                             <div class="form-line">
                                 <input type="text" id="area_reparto" class="form-control" name="area_reparto" placeholder="" value="{{ old('area_reparto') ?? (isset($campione) && isset($campione->reparto) ? $campione->reparto->area_partizione : '') ?? '' }}" maxlength="255">
                             </div>
                             <div class="help-info">area relativa al reparto di campionamento</div>
                         </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
                        <label for="codice_struttura">Codice struttura</label>
                        <div class="form-group">  
                            <div class="form-line">
                                <input type="text" id="codice_struttura" class="form-control" name="codice_struttura" value="{{ generaCodice($campagna->dataCampagna,codiceRepArea(null,null),null,null,null,null) }}" maxlength="255">
                            </div>
                            <div class="help-info">Codice identificativo della struttura per quel reparto associata all'attività</div>
                        </div>
                    </div>
                </div>
                <!-- numStanza Dettaglio -->
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
                        <label for="numStanza">Numero stanza</label>
                        <div class="form-group">  
                            <div class="form-line">
                                <input type="text" id="numStanza" class="form-control" name="numStanza" placeholder="Inserisci il numero della stanza" value="{{ old('numStanza') ?? $campione->numstanze ?? '' }}" maxlength="3">
                            </div>
                            <div class="help-info">il numero identificativo della stanza</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
                        <label for="dettaglio">Dettaglio</label>
                        <div class="form-group">  
                            <div class="form-line">
                                <input type="text" id="dettaglio" class="form-control" name="dettaglio" placeholder="Inserisci eventuali dettagli" value="{{ old('dettaglio') ?? $campione->dettaglio ?? '' }}" maxlength="255">
                            </div>
                            <div class="help-info">dettaglio</div>
                        </div>
                    </div>
                </div>
                <!-- Anomalie -->
                <div class="row clearfix  mr-1">
                    <!--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">spazio</div>-->
                    <!--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">spazio</div>-->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <h2 class="card-inside-title">Anomalie
                                <span><i class="help-icon material-icons" data-toggle="tooltip" data-placement="right" title="Questo spazio è dedicato ad eventuali note sulle anomalie">help</i></span>
                            </h2>
                            <div class="form-line">
                                <textarea id="anomalie" name="anomalie" rows="3" class="form-control no-resize" placeholder="Note per le anomalie" style="min-height: 50px;">{{ old('anomalie') ?? $campione->anomalie ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>