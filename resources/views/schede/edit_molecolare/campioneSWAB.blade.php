<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-collapsable">
            <div class="header">
                <h2 class="collapsable-handler">Campione da Analisi Molecolare</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="collapsable-handler">
                            <i class="material-icons">more_vert</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body body-collapsable demo-masked-input">
                <!-- Data Analisi Nome tecnico -->
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Data di Analisi</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="date" id="dataAnalisi" class="form-control" name="dataAnalisi" placeholder="Inserisci la data" value="{{ old('dataCampagna') ?? (isset($campione) ? (isset($campione->dataAnalisi) ? $campione->dataAnalisi : '') : Carbon\Carbon::now()->format('Y-m-d')) ?? $campagna->dataCampagna ?? '' }}" maxlength="255">                        
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Nome tecnico</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="tecnico" class="form-control" name="tecnico" value="{{ old('tecnico') ?? (isset($campione) ? (isset($campione->tecnico) ? $campione->tecnico : '') : '') ?? '' }}" maxlength="255">                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <!--Codice piastra Tipo piastra-->
                 <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Codice piastra</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="codPiastra" class="form-control" name="codPiastra" value="{{ old('codPiastra') ?? (isset($campione) ? (isset($campione->codPiastra) ? $campione->codPiastra : '') : '') ?? '' }}" maxlength="255">                        
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Tipo piastra</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="tipoPiastra" name="tipoPiastra">
                                            <option value="tutti">-- Seleziona un opzione --</option>
                                            <option value="3" {{ isset($campione) && isset($campione->tipopiastra()->first()->id) ? is_selected_option($campione->tipopiastra()->first()->id, 3) : ''}}>Mac Conkey Agar 90</option>
                                            <option value="5" {{ isset($campione) && isset($campione->tipopiastra()->first()->id) ? is_selected_option($campione->tipopiastra()->first()->id, 5) : ''}}>Cetrimide Agar 90</option>
                                    </select>     
                                    <div class="help-info">tipo di piastra utilizzato</div>                           
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Lotto -->
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">   
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label for="lotto">Lotto</label>
                            <div class="form-group">  
                                <div class="form-line">
                                    <input type="text" id="lotto" class="form-control" name="lotto" placeholder="lotto" value="{{ old('lotto') ?? (isset($campione) ? $campione->lotto : '') }}" maxlength="255">
                                </div>
                                <div class="help-info">lotto</div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label for="scadenza">Data scadenza</label>
                            <div class="form-group">  
                                <div class="form-line">
                                    <input type="date" id="scadenza" class="form-control" name="scadenza" placeholder="scadenza" value="{{ old('scadenza') ?? (isset($campione)) ? ($campione->dataScadenza != null ? $campione->dataScadenza->format('Y-m-d') : $campione->dataScadenza) : '' ?? '' }}" maxlength="255">
                                </div>
                                <div class="help-info">scadenza</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tempo di incubazione -->
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <label for="scadenza">Data Incubazione</label>
                        <div class="form-group">  
                            <div class="form-line">
                                <input type="date" id="dataincubazione" class="form-control" name="dataIncubazione" placeholder="data di incubazione" value="{{ old('dataIncubazione') ?? (isset($campione)) ? ($campione->dataIncubazione != null ? $campione->dataIncubazione->format('Y-m-d') : $campione->dataIncubazione) : '' ?? '' }}" maxlength="255">
                            </div>
                            <div class="help-info">data di incubazione</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <label>Tempo di Incubazione</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="time" id="tempoIncubazione" name="tempoIncubazione" class="form-control" value="{{ old('tempoIncubazione') ?? ((isset($campione) && isset($campione->tempoIncubazione)) ? $campione->floatToTime($campione->tempoIncubazione) : '' ) ?? '' }}">
                            </div>
                            <div class="help-info">tempo di incubazione</div>
                        </div>
                    </div>
                </div>
                <!-- checkbox micro -->
                <div class="row clearfix"> 
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0 mt-2 ">
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 w-a" id="checkbox_extra">
                            <input name="presenzamicro" type="checkbox" id="presenzamicro" class="filled-in chk-col-blue" {{ (isset($campione) && App\ImmaginiPiastreSwab::where('id_campione', $campione->id)->where('tipo','striscio')->first() != null) ? 'checked' : ''  }}>
                            <label for="presenzamicro"><b>Presenza microrganismi</b></label> 
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0 mt-2 ">
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 pl-0 hidden"  id="simicro">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pr-0">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="microrganismi" class="col-md-8 col-form-label text-md-right">Microrganismi</label>
                                            <select class="form-control show-tick" size="10" id="microrganismi" >
                                                <option value="" selected> -- Seleziona un microrganismo -- </option>
                                                @foreach(App\MicrorganismoPiastra::where('id','!=',1)->get() as $m)
                                                    <option value="{{ $m->id }}">{{ $m->microrganismo }}</option>   
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ml-1 align-left">
                                            @if((isset($campione) && $campione->bloccato == 0) || !isset($campione))
                                            <input type="button" id="aggiungi_microrganismo" class="btn btn-primary waves-effect" value="Aggiungi" disabled >
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pr-0">
                                <div class="row clearfix pl-1-2">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <h4 class="align-justify">Microrganismi presenti</h4>
                                                    <select class="form-control ms" multiple="multiple" size="10" name="text_area_microrganismi_segnati" id="text_area_microrganismi_segnati">    
                                                        @php $microsupiastra = get_micro_su_piastraSWAB($campione->id ?? '') @endphp
                                                        @if($microsupiastra != null)
                                                            @foreach ($microsupiastra as $microrganismo)
                                                                <option value="{{ $microrganismo['id'] }}" id_microrganismo="{{ $microrganismo['id_microrganismo'] }}" id_tipopiastra="{{ $microrganismo['id_tipopiastra'] }}" presente={{ $microrganismo['presente'] }} deletable="{{ $microrganismo['deletable'] }}">{{ $microrganismo['nome'] }}</option>   
                                                            @endforeach
                                                        @else
                                                            <option value="">Non sono stati rilevati microrganismi</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-1-2 align-left">
                                                @if((isset($campione) && $campione->bloccato == 0) || !isset($campione))
                                                <input type="button" id="cancella_microrganismo" class="btn btn-danger waves-effect" value="Cancella" disabled >
                                                @endif
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 hidden" id="fotostriscio">
                            @if(isset($campione))
                                @if(App\ImmaginiPiastreSwab::where('id_campione',$campione->id)->where('tipo','striscio')->first() != null)
                                    <div id="dropzone_store" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden">
                                        <form action="{{ URL::action('ImmaginiPiastreSwabController@store') }}" id="dropzoneStriscio" class="dropzone dz-clickable" method="post">
                                            <div class="dz-message">
                                                <div class="drag-icon-cph">
                                                    <i class="material-icons">touch_app</i>
                                                </div>
                                                <h3>Trascina qui il file o clicca per fare l'upload</h3>
                                                <em>(Foto striscio)</em>
                                            </div>
                                            <div class="fallback">
                                                <input name="file" type="file" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}/>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="dropzone_view" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-0">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <a href="#0" data-sub-html="Demo Description">
                                                <img id="img_striscio" data-toggle="modal" data-target="#largeModal" alt="Immagine striscio" class=" thumbnail" src="{{route('immaginiswabpiastre',[$campione->id,getImageNameSwab($campione->id,'striscio')])}}" width="400" height="350">
                                            </a>
                                        </div>
                                    </div>
                                    <div id="dropzone_elimina_button" class="row clearfix hidden">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ml-3 align-left">
                                            <input type="button" tipo="striscio" name="elimina_striscio" id="elimina_striscio" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#eliminaFotoModal" value="Elimina Foto" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }} >    
                                        </div>
                                    </div>
                                @else
                                    <div id="dropzone_store" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <form action="{{ URL::action('ImmaginiPiastreSwabController@store') }}" id="dropzoneStriscio" class="dropzone dz-clickable" method="post">
                                            <div class="dz-message">
                                                <div class="drag-icon-cph">
                                                    <i class="material-icons">touch_app</i>
                                                </div>
                                                <h3>Trascina qui il file o clicca per fare l'upload</h3>
                                                <em>(Foto striscio)</em>
                                            </div>
                                            <div class="fallback">
                                                <input name="file" type="file" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}/>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="dropzone_view" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-0 hidden">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <a href="#0" data-sub-html="Demo Description">
                                                <img id="img_striscio" data-toggle="modal" data-target="#largeModal" alt="Immagine striscio" class=" thumbnail" src="{{route('immaginitemporaneepiastre',[getImageTemporary($code,'striscio')])}}" width="400" height="350">
                                            </a>
                                        </div>
                                    </div>
                                    <div id="dropzone_elimina_button" class="row clearfix hidden">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ml-3 align-left">
                                            <input type="button" tipo="striscio" name="elimina_striscio" id="elimina_striscio" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#eliminaFotoModal" value="Elimina Foto" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }} >    
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div id="dropzone_store" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <form action="{{ URL::action('ImmaginiPiastreController@store') }}" id="dropzone2" class="dropzone dz-clickable" method="post">
                                        <div class="dz-message">
                                            <div class="drag-icon-cph">
                                                <i class="material-icons">touch_app</i>
                                            </div>
                                            <h3>Trascina qui il file o clicca per fare l'upload</h3>
                                            <em>(Foto striscio)</em>
                                        </div>
                                        <div class="fallback">
                                            <input name="file" type="file" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }}/>
                                        </div>
                                    </form>
                                </div>
                                <div id="dropzone_view" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-0 hidden">
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <a href="#0" data-sub-html="Demo Description">
                                            <img id="img_striscio" data-toggle="modal" data-target="#largeModal" alt="Immagine striscio" class=" thumbnail" src="{{route('immaginitemporaneepiastre',[getImageTemporary($code,'striscio')])}}"  width="400" height="350">
                                        </a>
                                    </div>
                                </div>
                                <div id="dropzone_elimina_button" class="row clearfix hidden">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ml-3 align-left ">
                                        <input type="button" tipo="striscio" name="elimina_striscio" id="elimina_striscio" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#eliminaFotoModal" value="Elimina Foto" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }} >    
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div> 
                <!-- NoteCampionamento -->
                <div class="row clearfix mt-2 hidden" id="presenzamicro_note">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <h2 class="card-inside-title">Note
                                <span><i class="help-icon material-icons" data-toggle="tooltip" data-placement="right" title="Questo spazio è dedicato ad eventuali note relative al campionamento">help</i></span>
                            </h2>
                            <div class="form-line">
                                <textarea id="note" name="note" rows="2" class="form-control no-resize" placeholder="Note per il campionamento" style="min-height: 50px;">{{ old('note') ?? (isset($campione) && $numeroProgressivo == 0) ? $campione->note : '' }}</textarea>
                            </div>
                        </div>
                    </div>
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

                <!-- elimina modal-->
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
                                <button type="button" id="elimina_foto_conferma" idScheda="{{ (isset($campione) && checkImmagine($campione->id,'striscio',$code) == 1) ? $campione->id : 'nuova'}}" codeScheda="{{ $code }}" name="elimina_foto" class="btn btn-link waves-effect" tipo="">CONFERMA</button>
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end modal-->       
            </div>
        </div>
    </div>
</div>