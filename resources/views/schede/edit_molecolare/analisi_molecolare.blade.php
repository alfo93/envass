<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-collapsable">
            <div class="header">
                <h2 class="collapsable-handler">Analisi Molecolari</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="collapsable-handler">
                            <i class="material-icons">more_vert</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body body-collapsable demo-masked-input">
                <!-- CodificaCias -->
                <div class="row clearfix mt-2">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <label>Codifica CIAS </label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="codifica_cias" class="form-control" name="numProg" aria-required="true" value="{{ old('numProg') ?? (isset($campione) ? $campione->numProg : $strutture->codice . "-" . "1") ?? '' }}">     
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <label>Codice ENVASS: </label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="codice_envass" class="form-control" name="id" aria-required="true" value="{{ old('id') ?? (isset($campione) ? $campione->id : 'DA ASSEGNARE') ?? ''}}" readonly>     
                            </div>
                        </div>
                    </div>
                </div>
                <!-- caricamento file -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label id="labelFile" for="carica_file" class="custom-file-upload">
                                    <span id="text_file">Carica Documento</span>
                                </label>
                                <input class="custom-file-upload" id="carica_file" name="file" type="file" name="file"/>
                                <span id="checkfile" class="label hidden label-success ml-2 font-13"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>