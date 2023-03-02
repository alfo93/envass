@is(['admin','gestore'])
<div class="block-header">
    <small>Scegli il Committente, l'attività ad esso associato e la struttura - partizione per generare correttamente il documento.
    </small>
</div>

{{-- @if ($errors->any())
    <div id="errors-container_committente" class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ ucfirst($error) }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-collapsable">
            <div class="header">
                <h2 class="collapsable-handler">&#9658; &#32; Selezione</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="collapsable-handler">
                            <i class="material-icons">more_vert</i>
                        </a>
                    </li>
                </ul>
            </div>
            <form action="{{ URL::action('RapportoRelazioneController@createDocumento_committente') }}" method="get">
            <div class="body body-collapsable demo-masked-input">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label>Committente</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control show-tick" id="societa_campagna_committente" name="id_societa">
                                    <option value="tutti">Tutti</option>
                                    @foreach($societa as $s)
                                        <option value="{{ old('id_societa') ?? $s->id }}">{{ $s->nome }}</option>
                                    @endforeach
                                </select>     
                                <div class="help-info">Nome del Committente</div>                           
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label>Attività</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control show-tick" id="progetti_campagna_committente" name="id_progetto">
                                    <option value="{{ old('id_progetto') ?? 'tutti' }}">Tutti</option>
                                    
                                </select>     
                                <div class="help-info">Attività</div>                           
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label>Struttura</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control show-tick" id="struttura_campagna_committente" name="id_struttura">
                                    <option value="{{ old('id_struttura') ?? 'tutti' }}">Tutti</option>
                                    
                                </select>     
                                <div class="help-info">Struttura</div>                           
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label>Partizione</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control show-tick" id="partizione_campagna_committente" name="id_reparto">
                                    <option value="{{ old('id_reparto') ?? 'tutti' }}">Tutti</option>
                                    
                                </select>     
                                <div class="help-info">Partizione</div>                           
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label>Area partizione</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control show-tick" id="areapartizione_campagna_committente" name="areapartizione">
                                    <option value="{{ old('area_reparto') ?? 'tutti' }}">Tutti</option>
                                    
                                </select>     
                                <div class="help-info">Area della partizione scelta</div>                           
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <label>Data campagna</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="date" class="form-control" id="data_campagna_committente" name="data_campagna" value="{{ old('data_campagna') ?? ''}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix" style="text-align: end">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button type="submit" class="btn btn-primary waves-effect" id="genera_rapporto_committente">Crea Rapporto</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endis

