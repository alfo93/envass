<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-collapsable">
            <div class="header">
                <h2 class="collapsable-handler">&#9658; &#32; Upload rapporto di prova</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="collapsable-handler">
                            <i class="material-icons">more_vert</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body body-collapsable demo-masked-input">
                <form id="form_advanced_validation" enctype="multipart/form-data" action="{{ URL::action('RapportoRelazioneController@store') }}" method="POST" novalidate="novalidate">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="progetto">Attività</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="id_progetto" id="progetti_rapporti" data-size="20">
                                            <option selected value="{{old('id_progetto') ?? 'nessuna'}}">-- Seleziona un'opzione --</option>
                                            @foreach (App\Progetto::where('versione',2)->get() as $progetto)
                                                <option value="{{ old('id_progetto') ?? $progetto->id }}">{{ $progetto->progetto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="struttura">Struttura</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="ospedale" id="struttura_rapporti" data-size="100">
                                            <option selected value="{{ old('ospedale') ?? 'nessuna'}}">-- Seleziona un'opzione --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="reparto">Partizione</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="id_reparto" id="reparto_rapporti" data-size="100">
                                            <option selected value="{{ old('reparto_rapporti') ?? ''}}">-- Seleziona un'opzione --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Area partizione</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="areapartizione_rapporti" name="areapartizione">
                                            <option value="{{ old('area_reparto') ?? '' }}">Tutti</option>
                                        </select>     
                                        <div class="help-info">Area della partizione scelta</div>                           
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <label for="livello">Tipo</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="tipo" id="tipo" value="Rapporto di prova" minlength="3" required="" aria-required="true" placeholder="Rapporto di Prova" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <label>Data della campagna</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" id="dataCampagna" name="dataCampagna" class="form-control" value="{{ old('dataCampagna') ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group">
                                    <label>Rev del documento</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" id="revRapporto" name="rev" class="form-control" value="{{ old('rev') ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <h2 class="card-inside-title">Note
                                    <span><i class="help-icon material-icons" data-toggle="tooltip" data-placement="right" title="Questo spazio è dedicato ad eventuali note">help</i></span>
                                </h2>
                                <div class="form-line">
                                    <textarea id="noterapporto" name="note" rows="3" class="form-control no-resize" placeholder="Note per il rapporto" style="min-height: 50px;" value=" {{ old('note') ?? ''}} "></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label id="labelFirma_rapporto" for="carica_firma_rapporto" class="custom-file-upload">
                                        <span id="text_firma_rapporto">Carica Documento</span>
                                    </label>
                                    <input class="custom-file-upload" id="carica_firma_rapporto" name="file" type="file" name="file"/>
                                    <span id="checkfile_rapporto" class="label hidden label-success ml-2 font-13"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary waves-effect" type="submit">UPLOAD</button>
                        </div>
                    </div>
                </form>        
            </div>
        </div>
    </div>
</div>

           
                    