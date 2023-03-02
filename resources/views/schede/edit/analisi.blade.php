<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-collapsable">
            <div class="header">
                <h2 class="collapsable-handler">Analisi</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="collapsable-handler">
                            <i class="material-icons">more_vert</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body body-collapsable demo-masked-input">
                <!-- Rilevatore -->
                <div class="row clearfix mt-2">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <label>Tecnico che ha eseguito l'analisi</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control show-tick" id="tecnico" name="tecnico">
                                    <option value="">-- Seleziona un opzione --</option>
                                    @foreach($rilevatori as $rilevatore)
                                        <option value="{{ $rilevatore->id }}" {{ (isset($campione) && $numeroProgressivo >= 0) ? is_selected_option($campione->tecnico, $rilevatore->id) : '' }} descrizione="{{ getDescrizioneRilevatore($rilevatore->getDescrizione(),$rilevatore->rilevatore) }}">{{ $rilevatore->rilevatore }}</option>
                                    @endforeach
                                </select>     
                                <div class="rilevatore_descrizione_tecnico help-info"></div>                           
                            </div>
                        </div>
                    </div>
                </div>
                <!-- DataInizioProva OraInizioProva DataFineIncubazione OraFineIncubazione -->
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label for="dataAnalisi">Data inizio incubazione</label>
                        <div class="form-group">  
                            <div class="form-line">
                                <input type="date" id="dataAnalisi" class="form-control" name="dataAnalisi" placeholder="Inserisci la data" value="{{ old('dataAnalisi') ?? ((isset($campione) && $numeroProgressivo >= 0) && isset($campione->dataAnalisi) ? $campione->dataAnalisi : $campagna->dataCampagna) ?? '' }}" maxlength="255">
                            </div>
                            <div class="help-info">data inizio analisi</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 ">
                        <label for="oraInizioAnalisi">Ora inizio incubazione</label>
                        <div class="form-group">  
                            <div class="form-line">
                                <input type="time" id="oraInizioAnalisi" class="form-control" name="oraInizioAnalisi" placeholder="Inserisci la data" value="{{ old('oraInizioAnalisi') ?? ((isset($campione) && $numeroProgressivo >= 0) && isset($campione->oraInizioAnalisi) ? $campione->oraInizioAnalisi : '') ?? '' }}" maxlength="255">
                            </div>
                            <div class="help-info">Ora inizio analisi</div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    
                </div>
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 ">
                        <label for="dataFineAnalisi">Data fine incubazione</label>
                        <div class="form-group">  
                            <div class="form-line">
                                <input type="date" id="dataFineAnalisi" class="form-control" name="dataFineAnalisi" placeholder="Inserisci la data" value="{{ old('dataFineAnalisi') ?? ((isset($campione) && $numeroProgressivo >= 0) && isset($campione->dataFineAnalisi) ? $campione->dataFineAnalisi->format('Y-m-d') : $campagna->dataCampagna) ?? '' }}" maxlength="255">
                            </div>
                            <div class="help-info">Data fine analisi</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 ">
                        <label for="oraFineAnalisi">Ora fine incubazione</label>
                        <div class="form-group">  
                            <div class="form-line">
                                <input type="time" id="oraFineAnalisi" class="form-control" name="oraFineAnalisi" placeholder="Inserisci la data" value="{{ old('oraFineAnalisi') ?? ((isset($campione) && $numeroProgressivo >= 0) && isset($campione->oraFineAnalisi) ? $campione->oraFineAnalisi : '') ?? '' }}" maxlength="255">
                            </div>
                            <div class="help-info">ora fine analisi</div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    
                </div>
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>Tempo di incubazione</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control show-tick" id="t_inc" name="t_inc">
                                    @if(isset($campione))
                                        <option value="">-- Seleziona un opzione --</option>                                   
                                        @foreach($campione->get_tInc() as $key => $t_inc)
                                            @if($key != '120')
                                            <option value="{{ $key }}" {{ (isset($campione) && $numeroProgressivo >= 0) ? is_selected_option($campione->t_inc, $key) : '' }}>{{ $t_inc . " ± 3 h" }}</option>
                                            @else
                                            <option value="{{ $key }}" {{ (isset($campione) && $numeroProgressivo >= 0) ? is_selected_option($campione->t_inc, $key) : '' }}>{{ $t_inc }}</option>    
                                            @endif    
                                        @endforeach
                                    @else
                                        <option value="">-- Seleziona un opzione --</option>                                   
                                        <option value="24">24 ± 3 h</option>
                                        <option value="48">48 ± 3 h</option>
                                        <option value="72">72 ± 3 h</option>
                                        <option value="120">da 120 a 168 h</option>
                                    @endif
                                </select>     
                                <div class="help-info">tempo di incubazione espresso in ore</div>                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>Condizione di incubazione</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control show-tick" id="condizione_incubazione" name="condizione_incubazione">
                                    <option value="">-- Seleziona un opzione --</option>
                                    @if(isset($campione)) 
                                        @foreach($campione->get_condizioneIncubazione() as $c)
                                                <option value="{{ $c }}" {{ (isset($campione) && $numeroProgressivo >= 0) ? is_selected_option($campione->condizione_incubazione, $c) : '' }}>{{ $c ." ± 1" }}</option>   
                                        @endforeach 
                                    @else
                                    <option value="25">25 ± 1</option>
                                    <option value="30">30 ± 1</option>
                                    <option value="37">37 ± 1</option>
                                    @endif
                                </select>     
                                <div class="help-info">condizioni di incubazione espressa in gradi °C</div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>