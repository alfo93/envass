<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-collapsable">
            <div class="header">
                <h2 class="collapsable-handler">Sito campionamento</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="collapsable-handler">
                            <i class="material-icons">more_vert</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body body-collapsable demo-masked-input"> 
                <!-- Stanza numStanza -->
                <div class="row clearfix">
                    {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
                        <label for="stanza">Stanza</label>
                        <div class="form-group">  
                            <div class="form-line">
                                <select class="form-control show-tick" id="stanza" name="stanza">
                                    <option value="">-- Seleziona un opzione --</option>
                                    @foreach($stanze as $stanza)
                                        <option id_stanza="{{ $stanza->id }}" value="{{ $stanza->stanza }}" {{ isset($campione) ? is_selected_option($campione->stanza()->first()->stanza, $stanza->stanza) : ''}}>{{ $stanza->stanza }}</option>
                                    @endforeach
                                </select>     
                                <div class="help-info">Stanza</div>
                                <input type="text" id="stanza_campionamento" class="form-control" name="stanza" placeholder="indirizzo" value="{{ old('stanza') ?? $campione->stanza ?? '' }}" maxlength="255">
                            </div>
                            <div class="help-info">Stanza in cui è avvenuto il campionamento</div>
                        </div>
                    </div> --}}
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
                        <label for="numStanza">Numero stanza</label>
                        <div class="form-group">  
                            <div class="form-line">
                                <input type="text" id="numStanza" class="form-control" name="numStanza" placeholder="Inserisci il numero della stanza" value="{{ old('numStanza') ?? $campione->numStanza ?? '' }}" maxlength="255">
                            </div>
                            <div class="help-info">il numero identificativo della stanza</div>
                        </div>
                    </div>
                </div>

                <!-- Umidità Temperatura Dettaglio -->

                <div class="row clearfix ">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pl-0">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
                            <label class="mb-1" for="umidAmb">Umidità ambientale</label>
                            <div class="form-group">  
                                <div class="form-line">
                                    <input type="number" id="umidAmb" class="form-control" name="umidAmb" placeholder="Inserisci il valore dell'umidità" value="{{ old('umidAmb') ?? $campione->umidAmb ?? '' }}" maxlength="3" style="border-style: solid; border-width: 1px; padding-left: 2px">
                                </div>
                                <div class="help-info">il valore dell'umidità ambientale espresso in % UR</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pr-1">
                            <label class="mb-1" for="tempAmb">Temperatura ambiente</label>
                            <div class="form-group">  
                                <div class="form-line">
                                    <input type="number" id="tempAmb" class="form-control" name="tempAmb" placeholder="Inserisci il valore della temperatura" value="{{ old('tempAmb') ?? $campione->tempAmb ?? '' }}" maxlength="3" style="border-style: solid; border-width: 1px; padding-left: 2px">
                                </div>
                                <div class="help-info">il valore della temperatura ambientale espresso in °C</div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                            <label class="mb-3" for="dettaglio">Dettaglio</label>
                            <div class="form-group">  
                                <div class="form-line">
                                    <input type="text" id="dettaglio" class="form-control" name="dettaglio" placeholder="Inserisci eventuali dettagli" value="{{ old('dettaglio') ?? $campione->dettaglio ?? '' }}" maxlength="255">
                                </div>
                                <div class="help-info">dettaglio</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Linee Guida -->

                <div class="row clearfix ">
                   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                       <div id="lineeguida">   
                           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                               <input name="lineeGuida1" value="{{ $campione->lineeGuida1 ?? 0 }}" type="checkbox" id="lineeGuida1" class="filled-in chk-col-blue" {{ is_checked(old('lineeGuida1') ?? $campione->lineeGuida1 ?? '' ) }}>
                               <label for="lineeGuida1">ISPESL 2003</label>
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                               <input name="lineeGuida2" value="{{ $campione->lineeGuida2 ?? 0 }}" type="checkbox" id="lineeGuida2" class="filled-in chk-col-blue"  {{ is_checked(old('lineeGuida2') ?? $campione->lineeGuida2 ?? '' ) }}>
                               <label for="lineeGuida2">ISPESL 2009</label>
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                               <input name="lineeGuida3" value="{{ $campione->lineeGuida3 ?? 0 }}" type="checkbox" id="lineeGuida3" class="filled-in chk-col-blue"  {{ is_checked(old('lineeGuida3') ?? $campione->lineeGuida3 ?? '' ) }}>
                               <label for="lineeGuida3">GMP 2008</label>
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                               <input name="lineeGuida4" value="{{ $campione->lineeGuida4 ?? 0 }}" type="checkbox" id="lineeGuida4" class="filled-in chk-col-blue"  {{ is_checked(old('lineeGuida4') ?? $campione->lineeGuida4 ?? '' ) }}>
                               <label for="lineeGuida4">Standart IQM</label>
                           </div>
                       </div>
                   </div>
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 iso_gmp hidden">
                       <label for="classificazioneISO">Classificazione ISO</label>
                       <div class="form-group"> 
                           <div class="form-line">
                               <select class="form-control show-tick" id="classificazioneISO" name="classificazioneISO">
                                    @if(isset($campione))
                                        <option value="">-- Seleziona un opzione --</option>
                                        @foreach($campione->get_iso() as $key => $classificazione)
                                        <option value="{{ $key }}" {{ is_selected_option($campione->classificazioneISO, $key) }}>{{ $classificazione }}</option>
                                        @endforeach
                                    @else
                                        <option value="">-- Seleziona un opzione --</option>
                                        <option value="1">ISO 5</option>
                                        <option value="2">ISO 7</option>
                                        <option value="3">ISO 8</option>
                                    @endif
                               </select>     
                               <div class="help-info">Classificazione ISO</div>                              
                           </div>
                       </div>
                   </div>
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 iso_gmp hidden">
                       <label for="classeGMP">Classe GMP</label>
                       <div class="form-group"> 
                           <div class="form-line">
                               <select class="form-control show-tick" id="classeGMP" name="classeGMP">
                                    @if(isset($campione))
                                        <option value="">-- Seleziona un opzione --</option>
                                        @foreach($campione->get_gmp() as $key => $classe)
                                        <option value="{{ $key }}" {{ is_selected_option($campione->classeGMP, $key) }}>{{ $classe }}</option>
                                        @endforeach
                                    @else
                                        <option value="">-- Seleziona un opzione --</option>
                                        <option value="1">A</option>
                                        <option value="2">B</option>
                                        <option value="3">C</option>
                                        <option value="4">D</option>
                                    @endif
                               </select>     
                               <div class="help-info">Classe GMP</div>                              
                           </div>
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