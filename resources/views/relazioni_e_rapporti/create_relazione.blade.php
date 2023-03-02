<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-collapsable">
            <div class="header">
                <h2 class="collapsable-handler">&#9658; &#32; Upload relazione</h2>
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
                                        <select class="form-control show-tick" name="id_progetto" id="progetti_relazioni" data-size="20">
                                            <option selected value="">-- Seleziona un'opzione --</option>
                                            @foreach (App\Progetto::where('versione',2)->get() as $progetto)
                                                <option value="{{ $progetto->id }}">{{ $progetto->progetto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="struttura">Struttura</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="ospedale" id="struttura_relazioni" data-size="100">
                                            <option selected value="">-- Seleziona un'opzione --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="reparto">Partizione</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="id_reparto" id="reparto_relazioni" data-size="100">
                                            <option selected value="">-- Seleziona un'opzione --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label>Area partizione</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="areapartizione_relazioni" name="areapartizione">
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
                                        <input type="text" class="form-control" name="tipo" value="Relazione" minlength="3" required="" aria-required="true" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <label>Data della campagna</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" name="dataCampagna" class="form-control" value="{{ old('dataPartenza') ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group">
                                    <label>Rev del documento</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" id="revRelazione" name="rev" class="form-control" value="{{ old('rev') ?? '' }}">
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
                                    <textarea id="noterelazione" name="note" rows="3" class="form-control no-resize" placeholder="Note per il rapporto" style="min-height: 50px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label id="labelFirma_relazione" for="carica_firma_relazione" class="custom-file-upload">
                                        <span id="text_firma_relazione">Carica Documento</span>
                                    </label>
                                    <input class="custom-file-upload" id="carica_firma_relazione" name="file" type="file" name="file"/>
                                    <span id="checkfile_relazione" class="label hidden label-success ml-2 font-13"></span>
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

           
                    