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
                <!-- Progetto DataCampagna DataCampionamento-->
                <div class="row clearfix mt-2">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>Attività</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control show-tick" id="progetto" name="progetto">
                                    <option value="tutti">-- Seleziona un opzione --</option>
                                    @if(isset($campione))
                                    <option value="{{ $progetto->id }}" id_progetto="{{ $progetto->id }}" {{ isset($campione) ? is_selected_option(App\ConversioneProgetto::progettoV2($campione->id_progetto) ?? $campione->id_progetto, $progetto->id) : ''}}>{{ $progetto->progetto }}</option>
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
                                <input type="date" id="dataCampionamento" class="form-control" name="data" placeholder="Inserisci la data" value="{{ old('data') ?? ($numeroProgressivo > 0) ? $campione->data->format('Y-m-d') : ((isset($campione) && isset($campione->data)) ? $campione->data->format('Y-m-d') : Carbon\Carbon::now()->format('Y-m-d')) ?? ''}}" maxlength="255">
                            </div>
                            <div class="help-info">data campionamento</div>
                        </div>
                    </div>
                </div>
                <!-- Societa Indirizzo Rilevatore-->
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>Committente</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id_societa="{{ isset($campione) ? $campione->progetto->societa->nome : ($societa->id ?? '') }}" id="nome_societa" class="form-control" name="nome_societa" placeholder="Societa" value="{{ old('nome_societa') ?? $campione->progetto->societa->nome ?? $societa->nome ?? '' }}" maxlength="255" readonly>
                            </div>
                            <div class="help-info">Nome del Committente</div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                        <label for="indirizzo_societa">Indirizzo del Committente</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="indirizzo_societa" class="form-control" name="indirizzo" placeholder="indirizzo" value="{{ old('indirizzo') ?? $societa->indirizzo ?? $campione->progetto->societa->indirizzo ?? '' }}" maxlength="255" readonly>
                            </div>
                            <div class="help-info">Indirizzo del Committente</div>
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
                                @if(isset($campione) && $numeroProgressivo == 0)
                                <!-- sto facendo una edit della scheda -->
                                    @foreach($rilevatori as $rilevatore)
                                        @if($cp[$rilevatore->id] == 1)
                                            <option value="{{ $rilevatore->id }}" selected descrizione="{{ getDescrizioneRilevatore($rilevatore->getDescrizione(),$rilevatore->rilevatore) }}">{{ $rilevatore->rilevatore }}</option>
                                        @else
                                            <option value="{{ $rilevatore->id }}" descrizione="{{ getDescrizioneRilevatore($rilevatore->getDescrizione(),$rilevatore->rilevatore) }}">{{ $rilevatore->rilevatore }}</option>
                                        @endif
                                    @endforeach
                                @elseif(isset($campione) && $numeroProgressivo > 0)
                                    <!-- sto accedendo ad una nuova scheda a partire da una appena salvata -->
                                    @foreach($rilevatori as $rilevatore)
                                        @if($cp[$rilevatore->id] == 1)
                                            <option value="{{ $rilevatore->id }}" selected descrizione="{{ getDescrizioneRilevatore($rilevatore->getDescrizione(),$rilevatore->rilevatore) }}">{{ $rilevatore->rilevatore }}</option>
                                        @else
                                            <option value="{{ $rilevatore->id }}" descrizione="{{ getDescrizioneRilevatore($rilevatore->getDescrizione(),$rilevatore->rilevatore) }}">{{ $rilevatore->rilevatore }}</option>
                                        @endif
                                    @endforeach
                                @else
                                    <!-- sto creando una nuova scheda -->
                                    @foreach($rilevatori as $rilevatore)
                                        <option value="{{ $rilevatore->id }}" descrizione="{{ getDescrizioneRilevatore($rilevatore->getDescrizione(),$rilevatore->rilevatore) }}">{{ $rilevatore->rilevatore }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="rilevatore_descrizione help-info"></div>
                        </div>
                    </div>
                </div>
                <!-- Stuttura AttrezzaturaProtettiva -->
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label>Struttura</label>
                        <div class="form-group">
                            <select class="form-control show-tick" id="nome_struttura" name="struttura">
                                <option value="tutti">-- Seleziona un opzione --</option>
                                <option selected value="{{ $strutture->id }}" {{ (isset($campione) && isset($campione->struttura)) ? (is_selected_option($campione->struttura->struttura, $strutture->struttura)) : ''}}>{{ $strutture->struttura }}</option>
                            </select>
                            <div class="help-info">Struttura</div>
                        </div>
                    </div>
                </div>
                <!-- Partenza Inizio -->
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>Partenza</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="date" id="dataPartenza" name="dataPartenza" class="form-control" value="{{ old('dataPartenza') ?? (isset($campione->dataPartenza) ? $campione->dataPartenza->format('Y-m-d') : $campagna->dataCampagna) ?? '' }}">
                            </div>
                            <div class="help-info">Data di partenza dal laboratorio / accensione data logger 15-25 °C</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>Ora partenza</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="time" id="oraPartenza" name="oraPartenza" class="form-control" value="{{ old('oraPartenza') ?? (isset($campione->oraPartenza) ? $campione->oraPartenza : '' ) ?? '' }}" min="07:00" max="23:00" step="900">
                            </div>
                            <div class="help-info">Ora di partenza dal laboratorio / accensione data logger 15-25 °C</div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>Inizio</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="date" id="dataInizio" name="dataInizio" class="form-control" value="{{ old('dataInizio') ?? (isset($campione->dataInizio) ? $campione->dataInizio->format('Y-m-d') : $campagna->dataCampagna) ?? '' }}">
                            </div>
                            <div class="help-info">Data inizio campionamento / accensione data logger 2-8 °C</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>Ora inizio</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="time" id="oraInizio" name="oraInizio" class="form-control" value="{{ old('oraInizio') ?? (isset($campione->oraInizio) ? $campione->oraInizio : '') ?? '' }}">
                            </div>
                            <div class="help-info">Ora inizio campionamento / accensione data logger 2-8 °C</div>
                        </div>
                    </div>
                </div>
                <!-- Fine Arrivo -->
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>Fine</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="date" id="dataFine" name="dataFine" class="form-control" value="{{ old('dataFine') ?? (isset($campione->dataFine) ? $campione->dataFine->format('Y-m-d') : $campagna->dataCampagna) ?? '' }}">
                            </div>
                            <div class="help-info">Data fine campionamento / spegnimento data logger 15-25 °C</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>Ora fine</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="time" id="oraFine" name="oraFine" class="form-control" value="{{ old('oraFine') ?? (isset($campione->oraFine) ? $campione->oraFine : '') ?? '' }}">
                            </div>
                            <div class="help-info">Ora fine campionamento / spegnimento data logger 15-25 °C</div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>Arrivo</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="date" id="dataArrivo" name="dataArrivo" class="form-control" value="{{ old('dataArrivo') ?? (isset($campione->dataArrivo) ? $campione->dataArrivo->format('Y-m-d') : $campagna->dataCampagna) ?? '' }}">
                            </div>
                            <div class="help-info">Data di arrivo in laboratorio / spegnimento data logger 2-8 °C</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>Ora arrivo</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="time" id="oraArrivo" name="oraArrivo" class="form-control" value="{{ old('oraArrivo') ?? (isset($campione->oraArrivo) ? $campione->oraArrivo : '') ?? '' }}" maxlength="11">
                            </div>
                            <div class="help-info">Ora di arrivo in laboratorio / spegnimento data logger 2-8 °C</div>
                        </div>
                    </div>
                </div>
                <!-- data accettazione -->
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label>Data accettazione</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="date" id="data_accettazione" name="data_accettazione" class="form-control" value="{{ old('data_accettazione') ?? (isset($campione->data_accettazione) ? $campione->data_accettazione->format('Y-m-d') : '') ?? '' }}">
                            </div>
                            <div class="help-info">Data di accettazione</div>
                        </div>
                    </div>
                </div>
                <!-- durataCampionamento durataTrasporto -->
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>Durata campionamento</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="durata_campionamento" name="durata_campionamento" class="form-control" value="" maxlength="11" readonly>
                            </div>
                            <div class="help-info">durata espressa in ore del campionamento</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <label>Durata trasporto</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="durata_trasporto" name="durata_trasporto" class="form-control" value="" maxlength="11" readonly>
                            </div>
                            <div class="help-info">durata espressa in ore del trasporto</div>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- Reparto CodiceStruttura -->
                <div class="row clearfix mt-2">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label>Partizione</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control show-tick" id="reparto" name="reparto">
                                    <option value="">-- Seleziona un opzione --</option>
                                    @foreach($areareparto as $ar)
                                    <option selected value="{{ $ar->id_reparto }}" {{ (isset($campione) && isset($campione->reparto)) ? (is_selected_option($campione->reparto->id_reparto, $ar->id_reparto)) : ''}}>{{ App\Reparto::find($ar->id_reparto)->partizione }}</option>
                                    @endforeach
                                </select>
                                <div class="help-info">Partizione</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 hidden">
                        <label>Area partizione</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control show-tick" id="areapartizione_campagna" name="areapartizione">
                                    <option value="{{ old('area_reparto') ?? 'tutti' }}">Tutti</option>

                                </select>
                                <div class="help-info">Area della partizione scelta</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="area_reparto">area partizione</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="area_reparto" class="form-control" name="area_reparto" placeholder="" value="{{ old('area_reparto') ?? (isset($campione) && isset($campione->reparto) ? $campione->reparto->area_partizione : '') ?? '' }}" maxlength="255">
                            </div>
                            <div class="help-info">area relativa alla partizione di campionamento</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
                        <label for="codice_struttura">Codice struttura</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="codice_struttura" class="form-control" name="codice_struttura" value="{{old('codice_struttura') ?? (isset($campione) ? ($numeroProgressivo > 0 ? 'Da assegnare': $campione->codiceCIAS) : 'Da assegnare') }}" maxlength="255" readonly>
                            </div>
                            <div class="help-info">Codice identificativo della struttura per quella partizione associata all'attività</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

