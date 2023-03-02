<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-collapsable">
            <div class="header">
                <h2 class="collapsable-handler">Campione</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="collapsable-handler">
                            <i class="material-icons">more_vert</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body body-collapsable demo-masked-input">
                <!-- CodiceCampione(piastra) CodiceCIAS -->
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="row clearfix mt-2 scelta_tipo_campionamento">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Tipo di campionamento</label>
                                <div id="select_tipocampione_superficie" class="form-group hidden">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="tipocampione_superficie" name="tipocampione_superficie">
                                            <option value="">-- Seleziona un opzione --</option>
                                            <option value="{{ old('tipocampione') ?? 'piastra' }}" {{ isset($campione) ? is_selected_option($campione->tipoCampione, 'piastra') : '' }}>Piastra per contatto</option>
                                            <option value="{{ old('tipocampione') ?? 'tampone' }}" {{ isset($campione) ? is_selected_option($campione->tipoCampione, 'tampone') : '' }}>Tampone</option>
                                        </select>
                                        <div class="help-info">tipo di campionamento effettuato</div>
                                    </div>
                                </div>
                                <div id="select_tipocampione_aria" class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="tipocampione_aria" name="tipocampione_aria">
                                            <option value="">-- Seleziona un opzione --</option>
                                            <option value="{{ old('tipocampione') ?? 'attivo' }}" {{ isset($campione) ? is_selected_option($campione->tipoCampione, 'attivo') : '' }}>Attivo</option>
                                            <option value="{{ old('tipocampione') ?? 'passivo' }}" {{ isset($campione) ? is_selected_option($campione->tipoCampione, 'passivo') : '' }}>Passivo</option>
                                        </select>
                                        <div class="help-info">tipo di campionamento effettuato</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <label>Codice piastra</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="codiceCampione" class="form-control" name="id" placeholder="" value="{{ old('id') ?? (isset($campione) && $numeroProgressivo > 0) ? 'Da assegnare' : $campione->id ?? 'Da assegnare' }}" maxlength="255" readonly>
                                        <div class="help-info">Codice identificativo del campione associato alla pistra</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
                                <label for="codiceCIAS">Codice CIAS</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="codiceCIAS" class="form-control" name="codiceCIAS" placeholder="codiceCIAS" value="{{ old('codiceCIAS') ?? (isset($campione) && $numeroProgressivo > 0 ? 'Da assegnare' : (!isset($campione) ? 'Da assegnare' : $campione->codiceCIAS)) }}" maxlength="255" readonly>
                                    </div>
                                    <div class="help-info">codice cias</div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
                                <label for="codiceCIAS_appendice">Info</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="codiceCIAS_appendice" class="form-control" name="codiceCIAS_appendice" value="{{ old('codiceCIAS_appendice') }}" maxlength="255">
                                    </div>
                                    <div class="help-info">eventuale aggiunta di informazioni al codice (opzionale)</div>
                                </div>
                            </div>
                        </div>
                        <!-- TipoPiastra Lotto DataScadenza DataScadenza -->
                        <div class="row clearfix ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Tipo piastra</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="id_tipo_piastra" name="id_tipo_piastra">
                                            @if($tipo == 'N' || $tipo == 'B')
                                                <option value="">-- Seleziona un opzione --</option>
                                                @foreach($piastre as $piastra)
                                                <option value="{{ $piastra->id }}" codice="{{ $piastra->abbreviazione }}" {{ (isset($campione) && $numeroProgressivo >= 0) ? is_selected_option($campione->tipopiastra->id, $piastra->id) : '' }}>{{ ucfirst($piastra->piastra) }}</option>
                                                @endforeach
                                            @else
                                            <option value="">-- Seleziona un opzione --</option>
                                            <option value="12" codice="PCA" {{ (isset($campione) && $numeroProgressivo >= 0) ? is_selected_option($campione->tipopiastra->id, 12) : '' }}>Plate Count Agar</option>
                                            <option value="13" codice="DG18" {{ (isset($campione) && $numeroProgressivo >= 0) ? is_selected_option($campione->tipopiastra->id, 13) : '' }}>Dichloran Glycerol Agar</option>
                                            @endif
                                        </select>
                                        <div class="help-info">tipo di piastra utilizzata</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 ">
                                <label for="lotto">Lotto</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="lotto" class="form-control" name="lotto" placeholder="lotto" value="{{ old('lotto') ?? (isset($campione) && $numeroProgressivo >= 0) ? $campione->lotto : '' }}" maxlength="255">
                                    </div>
                                    <div class="help-info">lotto</div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                <label for="scadenza">Data scadenza</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" id="scadenza" class="form-control" name="scadenza" placeholder="scadenza" value="{{ old('scadenza') ?? (isset($campione) && $numeroProgressivo >= 0) ? ($campione->scadenza != null ? $campione->scadenza->format('Y-m-d') : $campione->scadenza) : '' ?? '' }}" maxlength="255">
                                    </div>
                                    <div class="help-info">scadenza</div>
                                </div>
                            </div>
                        </div>
                        <!--  TempoIncubazione  Data di incubazione -->
                        <!--<div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                <label for="DII">Data inizio incubazione</label>
                                <div class="form-group">  
                                    <div class="form-line">
                                        <input type="date" id="DII" class="form-control" name="DII" placeholder="DII" value="{{-- old('DII')??(isset($campione))?($campione->DII!=null?$campione->DII->format('Y-m-d'):$campione->DII):$campagna->dataCampagna??'' --}}" maxlength="255">
                                    </div>
                                    <div class="help-info">inizio incubazione</div>
                                </div>
                            </div>
                        </div>-->
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="row clearfix">
                            @if(isset($campione) && $numeroProgressivo == 0)
                            <!--Se il campione è settato, devo verificare se sto modificando il campione aggiungendo una immagine o se le immagini ci sono già. Inoltre posso visualizzare immagine solo in edit-->
                            @if(checkImmagine($campione->id,'piastra1',$code) == 1)
                            <!-- esiste la foto -->
                            <div id="1_dropzone_1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden">
                                @if((isset($campione) && $campione->bloccato == 0) || !isset($campione))
                                <form action="{{ URL::action('ImmaginiPiastreController@store') }}" id="dropzone1" class="dropzone dz-clickable" method="post">
                                    <div class="dz-message">
                                        <div class="drag-icon-cph">
                                            <i class="material-icons">touch_app</i>
                                        </div>
                                        <h3>Trascina qui il file o clicca per fare l'upload</h3>
                                        <em>(Foto piastra)</em>
                                    </div>
                                    <div class="fallback">
                                        <input name="file" type="file"/>
                                    </div>
                                </form>
                                @endif
                            </div>
                            <div id="1_dropzone_2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <a href="#0" data-sub-html="Demo Description">
                                            <img id="img_piastra1" data-toggle="modal" data-target="#largeModal" min-height="300" min-width="300" alt="Immagine piastra" class=" thumbnail" src="{{ route('immaginipiastre',[getImageName($campione->id,'piastra1'),$campione->id]) }}" width="400" height="350">
                                        </a>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-1-2 align-left">
                                        <input type="button" tipo="piastra1" name="elimina_foto_1" id="elimina_foto_1" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#eliminaFotoModal" value="Elimina" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div id="1_dropzone_1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                @if((isset($campione) && $campione->bloccato == 0) || !isset($campione))
                                <form action="{{ URL::action('ImmaginiPiastreController@store') }}" id="dropzone1" class="dropzone dz-clickable" method="post">
                                    <div class="dz-message">
                                        <div class="drag-icon-cph">
                                            <i class="material-icons">touch_app</i>
                                        </div>
                                        <h3>Trascina qui il file o clicca per fare l'upload</h3>
                                        <em>(Foto piastra)</em>
                                    </div>
                                    <div class="fallback">
                                        <input name="file" type="file"/>
                                    </div>
                                </form>
                                @endif
                            </div>
                            <div id="1_dropzone_2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <a href="#0" data-sub-html="Demo Description">
                                            <img id="img_piastra1" data-toggle="modal" data-target="#largeModal" min-height="300" min-width="300" alt="Immagine piastra" class=" thumbnail" src="{{route('immaginitemporaneepiastre',[getImageTemporary($code,'piastra1')])}}" width="400" height="350">
                                        </a>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-1-2 align-left">
                                        <input type="button" name="elimina_foto_1" tipo="piastra1" id="elimina_foto_1" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#eliminaFotoModal" value="Elimina Foto" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @else
                            <!--Se il campione non è settato, allora non è possibile che esista una immagine associata ad esso nella tabella definitiva-->
                            <div id="1_dropzone_1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                @if((isset($campione) && $campione->bloccato == 0) || !isset($campione))
                                <form action="{{ URL::action('ImmaginiPiastreController@store') }}" id="dropzone1" class="dropzone dz-clickable" method="post">
                                    <div class="dz-message">
                                        <div class="drag-icon-cph">
                                            <i class="material-icons">touch_app</i>
                                        </div>
                                        <h3>Trascina qui il file o clicca per fare l'upload</h3>
                                        <em>(Foto piastra)</em>
                                    </div>
                                    <div class="fallback">
                                        <input name="file" type="file"/>
                                    </div>
                                </form>
                                @endif
                            </div>
                            <div id="1_dropzone_2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <a href="#0" data-sub-html="Demo Description">
                                            <img id="img_piastra1" data-toggle="modal" data-target="#largeModal" min-height="300" min-width="300" alt="Immagine piastra" class=" thumbnail" src="{{route('immaginitemporaneepiastre',[getImageTemporary($code,'piastra2')])}}" width="400" height="350">
                                        </a>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-1-2 align-left">
                                        <input type="button" tipo="piastra1" name="elimina_foto_1" id="elimina_foto_1" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#eliminaFotoModal" value="Elimina Foto" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <!-- Show Modal -->
                        <div class="modal fade in" id="largeModal" tabindex="-1" role="dialog" style="display: none; padding-right: 15px;">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="defaultModalLabel">Modal title</h4>
                                    </div>
                                    <div class="modal-body">
                                        <img class="modal-content thumbnail img-responsive" id="imageBigger">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end show modal -->
                        <!--modal-->
                        <div class="modal fade in" id="eliminaFotoModal" tabindex="-1" role="dialog" style="display: none;">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="eliminaFotoModalLabel">Specifica il motivo dell'eliminazione della foto</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="form_advanced_validation" method="POST" novalidate="novalidate">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label for="eliminaFotoMotivo">Motivo</label>
                                                    <input type="text" id="eliminaFotoMotivo" class="form-control" name="minmaxlength" required="" aria-required="true" value="">
                                                </div>
                                                <div class="help-info">Motivo dell'eliminazione</div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="elimina_foto_conferma" idScheda="{{ (isset($campione) && checkImmagine($campione->id,'piastra1',$code) == 1) ? $campione->id : 'nuova'}}" codeScheda="{{ $code }}" name="elimina_foto" class="btn btn-link waves-effect" tipo="">CONFERMA</button>
                                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end modal-->
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0 mt-2 ">
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 w-a" id="checkbox_extra">
                            <input name="piastraextra" type="checkbox" id="piastraextra" class="filled-in chk-col-blue" {{ (isset($campione) && $numeroProgressivo == 0 && (App\ImmaginiPiastre::where('id_campione',$campione->id)->where('tipo','piastra2')->first() != null)) ? 'checked' : ''  }} {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}>
                            <label for="piastraextra"><b>Piastra extra</b></label>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 w-a">
                        </div>
                        {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 hidden w-a" id="tiextra">
                            <label>Tempo di incubazione extra</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="t_inc_extra" name="t_inc_extra">
                                        @if(isset($campione) && $numeroProgressivo == 0)
                                        <option value="">-- Seleziona un opzione --</option>
                                        @foreach($campione->get_tInc() as $t_inc)
                                        <option value="{{ $t_inc }}" {{ (isset($campione)) ? is_selected_option($campione->t_inc_extra, $t_inc) : '' }}>{{ $t_inc }}</option>
                                        @endforeach
                                        @else
                                        <option value="">-- Seleziona un opzione --</option>
                                        <option value="24">24</option>
                                        <option value="48">48</option>
                                        <option value="72">72</option>
                                        <option value="120">120</option>
                                        @endif
                                    </select>
                                    <div class="help-info">tempo di incubazione per piastra aggiuntiva</div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 hidden" id="fotopiastraextra">
                            @if(isset($campione) && $numeroProgressivo == 0)
                            <!-- posso visualizzare l'immagine solo se faccio edit -->
                            @if(checkImmagine($campione->id,'piastra2',$code) == 1)
                            <div id="2_dropzone_1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden">
                                <form action="{{ URL::action('ImmaginiPiastreController@store') }}" id="dropzone2" class="dropzone dz-clickable" method="post">
                                    <div class="dz-message">
                                        <div class="drag-icon-cph">
                                            <i class="material-icons">touch_app</i>
                                        </div>
                                        <h3>Trascina qui il file o clicca per fare l'upload</h3>
                                        <em>(Foto piastra extra)</em>
                                    </div>
                                    <div class="fallback">
                                        <input name="file" type="file" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }} />
                                    </div>
                                </form>
                            </div>
                            <div id="2_dropzone_2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <a href="#0" data-sub-html="Demo Description">
                                            <img id="img_piastra2" data-toggle="modal" data-target="#largeModal" min-height="300" min-width="300" alt="Immagine piastra extra" class=" thumbnail" src="{{route('immaginipiastre',[getImageName($campione->id,'piastra2'),$campione->id])}}" width="400" height="350">
                                        </a>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-1-2 align-left">
                                        <input type="button" tipo="piastra2" name="elimina_foto_2" id="elimina_foto_2" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#eliminaFotoModal" value="Elimina Foto" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div id="2_dropzone_1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <form action="{{ URL::action('ImmaginiPiastreController@store') }}" id="dropzone2" class="dropzone dz-clickable" method="post">
                                    <div class="dz-message">
                                        <div class="drag-icon-cph">
                                            <i class="material-icons">touch_app</i>
                                        </div>
                                        <h3>Trascina qui il file o clicca per fare l'upload</h3>
                                        <em>(Foto piastra extra)</em>
                                    </div>
                                    <div class="fallback">
                                        <input name="file" type="file" />
                                    </div>
                                </form>
                            </div>
                            <div id="2_dropzone_2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <a href="#0" data-sub-html="Demo Description">
                                            <img id="img_piastra2" data-toggle="modal" data-target="#largeModal" min-height="300" min-width="300" alt="Immagine piastra extra" class=" thumbnail" src="{{route('immaginitemporaneepiastre',[getImageTemporary($code,'piastra2')])}}" width="400" height="350">
                                        </a>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-1-2 align-left">
                                        <input type="button" tipo="piastra2" name="elimina_foto_2" id="elimina_foto_2" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#eliminaFotoModal" value="Elimina Foto" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @else
                            <div id="2_dropzone_1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <form action="{{ URL::action('ImmaginiPiastreController@store') }}" id="dropzone2" class="dropzone dz-clickable" method="post">
                                    <div class="dz-message">
                                        <div class="drag-icon-cph">
                                            <i class="material-icons">touch_app</i>
                                        </div>
                                        <h3>Trascina qui il file o clicca per fare l'upload</h3>
                                        <em>(Foto piastra extra)</em>
                                    </div>
                                    <div class="fallback">
                                        <input name="file" type="file" />
                                    </div>
                                </form>
                            </div>
                            <div id="2_dropzone_2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <a href="#0" data-sub-html="Demo Description">
                                            <img id="img_piastra2" data-toggle="modal" data-target="#largeModal" min-height="300" min-width="300" alt="Immagine piastra extra" class=" thumbnail" src="{{route('immaginitemporaneepiastre',[getImageTemporary($code,'piastra2')])}}" width="400" height="350">
                                        </a>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-1-2 align-left">
                                        <input type="button" tipo="piastra2" name="elimina_foto_2" id="elimina_foto_2" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#eliminaFotoModal" value="Elimina Foto" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Microrganismi -->
                <hr>
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="row clearfix mt-2">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="microrganismi" class="col-md-8 col-form-label text-md-right">Microrganismi</label>
                                            <select class="form-control show-tick" size="30" id="microrganismi">
                                                <option value="" selected> -- Seleziona un microrganismo -- </option>
                                                @if($tipo == 'Q')
                                                    <option class="reperibilitaconta" value="1">Conta Totale</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="CFU">CFU</label>
                                                <input type="number" id="CFU" class="form-control" name="CFU" placeholder="" value="{{ old('CFU') ?? '' }}" min="0" max="999" style="border-style: solid; border-width: 1px; padding-left: 2px">
                                            </div>
                                            <div class="help-info">Colony Forming Units</div>
                                        </div>
                                    </div>
                                    {{Log::info($tipo)}}
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-3">
                                        @if(((isset($campione) && $campione->bloccato == 0) || !isset($campione)) && $tipo != 'Q')
                                        <input name="incertezza" type="checkbox" id="incertezza" incertezza="{{ (isset($campione) && $campione->metodo != null) ? $campione->metodo->incertezza : '' }}" class="filled-in chk-col-blue" {{ (isset($campione) && $numeroProgressivo == 0 && isset($campione->incertezza) && ($campione->incertezza == 1)) ? 'checked' : ''  }} {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}>
                                        <label style="padding-left: 40px;" for="incertezza"><b>Calcola incertezza</b></label>
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 align-left">
                                        @if((isset($campione) && $campione->bloccato == 0) || !isset($campione))
                                        <input name="speciazione" type="checkbox" id="speciazione" class="filled-in chk-col-blue" {{ (isset($campione) && $numeroProgressivo == 0 && isset($campione->speciazione) && ($campione->speciazione == 1)) ? 'checked' : ''  }} {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}>
                                        <label style="padding-left: 29px;" for="speciazione"><b>Speciazione patogeni</b></label>
                                        @endif
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 align-right">
                                        @if((isset($campione) && $campione->bloccato == 0) || !isset($campione))
                                        <select class="form-control show-tick" size="30" id="speciazione_risultato">
                                            <option value="" selected> -- Seleziona un'opzione -- </option>         
                                            <option value="NA">Non applicato</option>      
                                            <option value="NR">Non rilevato</option>       
                                            <option value="R">Rilevato</option>        
                                        </select>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 align-left">
                                        @if((isset($campione) && $campione->bloccato == 0) || !isset($campione))
                                        <input type="button" id="aggiungi_microrganismo" class="btn btn-primary waves-effect" value="Aggiungi" disabled {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="row clearfix mt-2 pl-1-2">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <h4 class="align-justify">Microrganismi segnati</h4>
                                            <select class="form-control ms" multiple="multiple" size="10" name="text_area_microrganismi_segnati" id="text_area_microrganismi_segnati">
                                                @if(isset($campione) && $numeroProgressivo == 0)
                                                <!-- sto facendo edit -->
                                                @php $microsupiastra = get_micro_su_piastra($campione->id ?? '') @endphp
                                                @if($microsupiastra != null)
                                                    @foreach ($microsupiastra as $microrganismo)
                                                        @if(($microrganismo['incertezzasx'] != null || $microrganismo['incertezzasx'] != '') && ($microrganismo['incertezzadx'] != null || $microrganismo['incertezzadx'] != ''))
                                                            <option value="{{ $microrganismo['id'] }}" id_microrganismo="{{ $microrganismo['id_microrganismo'] }}" id_tipopiastra="{{ $microrganismo['id_tipopiastra'] }}" cfu={{ $microrganismo['cfu'] }} $cfu_m="{{ $microrganismo['cfu_m'] }}" cfu_m_s="{{ $microrganismo['cfu_m_s'] }}" cfu_m_a="{{ $microrganismo['cfu_m_a'] }}" cfu_m_h="{{ $microrganismo['cfu_h'] }}" incertezzaSx="{{$microrganismo['incertezzasx']}}" incertezzaDx="{{$microrganismo['incertezzadx']}}" deletable="{{ $microrganismo['deletable'] }}">{{ $microrganismo['nome'] ." - ". $microrganismo['cfu'] ." CFU - " . $microrganismo['cfu_m'] . " CFU/m²" .  " - " . "incertezza: sx " . $microrganismo['incertezzasx'] . ", dx " . $microrganismo['incertezzadx']  }}</option>
                                                        @else
                                                            <option value="{{ $microrganismo['id'] }}" id_microrganismo="{{ $microrganismo['id_microrganismo'] }}" id_tipopiastra="{{ $microrganismo['id_tipopiastra'] }}" cfu={{ $microrganismo['cfu'] }} $cfu_m="{{ $microrganismo['cfu_m'] }}" cfu_m_s="{{ $microrganismo['cfu_m_s'] }}" cfu_m_a="{{ $microrganismo['cfu_m_a'] }}" cfu_m_h="{{ $microrganismo['cfu_h'] }}" incertezzaSx="{{$microrganismo['incertezzasx']}}" incertezzaDx="{{$microrganismo['incertezzadx']}}" deletable="{{ $microrganismo['deletable'] }}">{{ $microrganismo['nome'] ." - ". $microrganismo['cfu'] ." CFU - " . $microrganismo['cfu_m_s'] . " CFU/m² "  }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-1-2 align-left">
                                        @if((isset($campione) && $campione->bloccato == 0) || !isset($campione))
                                        <input type="button" id="cancella_microrganismo" class="btn btn-danger waves-effect" value="Cancella" disabled>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- PresenzaGram- NumGram- -->
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <table class="ml-1">
                            <tbody>
                                <!-- Batteri Gram - -->
                                <tr>
                                    <td class="pl-1 pt-1 pr-2 pb-1">
                                        <label for="gramN">Presenza batteri Gram- : </label>
                                    </td>
                                    <td class="pb-1 pt-1">
                                        <input type="radio" name="gramRil" id="siGramRil" class="with-gap" {{ (isset($campione) && $numeroProgressivo == 0) ? is_checked($campione->gramN != 0 ? 1 : '') : '' }} {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}>
                                        <label for="siGramRil"><b>Si</b></label>
                                    </td>
                                    <td>
                                        <input type="radio" name="gramRil" id="noGramRil" class="with-gap" {{ (isset($campione) && $numeroProgressivo == 0) ? is_checked($campione->gramN == 0 ? 1 : '') : 'checked'}} {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}>
                                        <label for="noGramRil" class="m-l-20"><b>No</b></label>
                                    </td>
                                    <td class="p-l-40">
                                        <div class="colonie hidden">
                                            <label for="gramN">Numero colonie Gram-</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" id="gramN" class="form-control" name="gramN" placeholder="gramN" value="{{ old('gramN') ?? ((isset($campione) && $numeroProgressivo == 0) ? $campione->gramN : 0) ?? 0 }}" min="0" style="border-style: solid; border-width: 1px; padding-left: 2px">
                                                </div>
                                                <div class="help-info">numero di colonie</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 container_alert">
                        <table id="container_alert_table" class="ml-1">
                            <tr>
                                <td><span class="badge bg-red siGram- hidden">Presenza batteri Gram-</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>

                <!-- SPECIAZIONE SPECIE PATOGENE -->
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 align-left">
                        @if((isset($campione) && $campione->bloccato == 0) || !isset($campione))
                        <input name="flag_speciazione" type="checkbox" id="flag_speciazione" class="filled-in chk-col-blue" {{ (isset($campione) && isset($campione->speciazione) && ($campione->speciazione == 1)) ? 'checked' : ''  }} {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}>
                        <label style="padding-left: 29px;" for="flag_speciazione"><b>Speciazione patogeni</b></label>
                        @endif
                    </div>
                </div>
                <div class="row clearfix ricerca-speciazione hidden">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="row clearfix mt-2">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row clearfix">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="form-group">
                                            <label for="speciazione_microrganismi" class="col-md-8 col-form-label text-md-right">Indetificazione specie patogene</label>
                                            <select class="form-control show-tick" size="30" id="speciazione_microrganismi">
                                                <option value="" selected> -- Seleziona un microrganismo -- </option>
                                                @if($tipo == 'Q')
                                                <option class="reperibilitaconta" value="1">Conta Totale</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        @if((isset($campione) && $campione->bloccato == 0) || !isset($campione))
                                        <label for="esito_microrganismi" class="col-md-4 col-form-label text-md-left">Esito</label>
                                        <select class="form-control show-tick" size="30" id="esito_speciazione">
                                            <option value="" selected> -- Seleziona un'opzione -- </option>         
                                            <option value="NA">Non applicato</option>      
                                            <option value="NR">Non rilevato</option>       
                                            <option value="R">Rilevato</option>        
                                        </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 align-left">
                                        @if((isset($campione) && $campione->bloccato == 0) || !isset($campione))
                                        <input type="button" id="aggiungi_speciazione" class="btn btn-primary waves-effect" value="Aggiungi" disabled {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="row clearfix mt-2 pl-1-2">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <h4 class="align-justify">Microrganismi ricercati</h4>
                                            <select class="form-control ms" multiple="multiple" size="10" name="text_area_microrganismi_ricercati" id="text_area_microrganismi_ricercati">
                                                @if(isset($campione) && $numeroProgressivo == 0)
                                                <!-- sto facendo edit -->
                                                    @php $speciazioni = get_speciazioni($campione->id ?? '') @endphp
                                                    @if($speciazioni != null)
                                                        @foreach ($speciazioni as $speciazione)
                                                        <option value="{{ $speciazione['id'] }}" id_microrganismo="{{ $speciazione['id_microrganismo'] }}" speciazione_risultato="{{ $speciazione['speciazione_risultato'] }}" tipoCamp="{{ $speciazione['tipoCamp'] }}" id_tipopiastra="{{ $speciazione['id_tipopiastra'] }}"  deletable="{{ $speciazione['deletable'] }}">{{ $speciazione['nome'] ." - ". $speciazione['speciazione_risultato'] }}</option>
                                                        @endforeach
                                                    @endif
                                                @elseif(isset($campione) && $numeroProgressivo != 0)
                                                    @php $speciazioni = get_speciazioni($campione->id ?? '') @endphp
                                                    @if($speciazioni != null)
                                                        @foreach ($speciazioni as $speciazione)
                                                        <option value="{{ $speciazione['id'] }}" id_microrganismo="{{ $speciazione['id_microrganismo'] }}" speciazione_risultato="{{ $speciazione['speciazione_risultato'] }}" tipoCamp="{{ $speciazione['tipoCamp'] }}" id_tipopiastra="{{ $speciazione['id_tipopiastra'] }}"  deletable="0">{{ $speciazione['nome'] ." - ". $speciazione['speciazione_risultato'] }}</option>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-1-2 align-left">
                                        @if((isset($campione) && $campione->bloccato == 0) || !isset($campione))
                                        <input type="button" id="cancella_microrganismo_speciazione" class="btn btn-danger waves-effect" value="Cancella" disabled>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>        
                <hr>                
                <!-- NoteCampionamento -->
                <div class="row clearfix mt-2">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <h2 class="card-inside-title">Note al campionamento
                                <span><i class="help-icon material-icons" data-toggle="tooltip" data-placement="right" title="Questo spazio è dedicato ad eventuali note relative al campionamento">help</i></span>
                            </h2>
                            <div class="form-line">
                                <textarea id="note" name="note" rows="2" class="form-control no-resize" placeholder="Note per il campionamento" style="min-height: 50px;">{{ old('note') ?? (isset($campione) && $numeroProgressivo >= 0) ? $campione->note : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
