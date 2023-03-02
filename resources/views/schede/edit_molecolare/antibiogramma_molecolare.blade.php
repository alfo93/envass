<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-collapsable">
            <div class="header">
                <h2 class="collapsable-handler">Antibiogramma molecolari</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="collapsable-handler">
                            <i class="material-icons">more_vert</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body body-collapsable demo-masked-input">
                <div class="row clearfix mt-2">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <div class="form-group">
                            <label for="microrganismi_antibiogramma" class="col-md-8 col-form-label text-md-right">Microrganismi</label>
                            <select class="form-control show-tick" size="10" id="microrganismi_antibiogramma">
                                <option value="" selected> -- Seleziona un microrganismo -- </option>
                                @foreach(App\MicrorganismoPiastra::all() as $m)
                                    @if($m->microrganismo != "Nessuno")
                                        <option value="{{ $m->id }}" {{ isset($campione) ? (is_selected_option(old('microrganismi_antibiogramma') ?? $campione->microantibiogramma->where('NAB',0)->first()['id_microrganismo'] ?? null,$m->id )) : '' }}>{{ $m->microrganismo }}</option>   
                                    @endif        
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
                    @if(isset($campione))
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
                        <div id="form_for_antibiogramma0" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 {{ (checkImmagine($campione->id,'antibiogramma0',$code,true) == 0) ? '' : 'hidden' }}">
                            <div class="row clearfix drop-file p-t-10">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <form action="{{ URL::action('ImmagineMicroAntibiogrammaSwabController@store') }}" id="dropzone" class="dropzone dz-clickable" method="post">
                                        {{csrf_field()}}
                                        <div class="dz-message">
                                            <div class="drag-icon-cph">
                                                <i class="material-icons">touch_app</i>
                                            </div>
                                            <h3>Trascina qui il file o clicca per effettuare l'upload</h3>
                                        </div>
                                        <div class="fallback">
                                            <input id="fimage" name="file" type="file" disabled />
                                        </div>
                                    </form>
                                    <!--<button type="button" class="btn btn-danger" id="hide_dropzone">
                                        Annulla
                                    </button>-->
                                </div>
                            </div>
                        </div>
                        <div id="image_dropzone_antibiogramma0" class="col-lg-4 col-md-4 col-sm-4 col-xs-4 {{ (checkImmagine($campione->id,'antibiogramma0',$code,true) == 0) ? 'hidden' : '' }}">
                            <a href="#0" data-sub-html="Demo Description">
                                <img id="antibiogramma0" data-toggle="modal" data-target="#largeModal" alt="Immagine Antibiogramma" class="img-responsive thumbnail" @if (checkImmagine($campione->id,'antibiogramma0',$code,true) == 1) src="{{route('immaginiantibiogrammaswab',[getImageMicroAntibioSwab($campione->id,'antibiogramma0'),$campione->id])}}" @else src="{{route('immaginitemporaneepiastre',[getImageTemporary($code,'antibiogramma0')]) }}" @endif>
                            </a>
                        </div>
                        <div id="button_dropzone_antibiogramma0" class="row clearfix mr-0 hidden">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-right">
                                <input type="button" tipo="antibiogramma0" name="elimina_foto_conta" id="elimina_foto_conta" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#eliminaFotoModal" value="Elimina Foto">    
                            </div>
                        </div>
                    @else
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="row clearfix drop-file p-t-10">
                                <div id="form_for_antibiogramma0" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <form action="{{ URL::action('ImmagineMicroAntibiogrammaSwabController@store') }}" id="dropzone" class="dropzone dz-clickable" method="post">
                                        <div class="dz-message">
                                            <div class="drag-icon-cph">
                                                <i class="material-icons">touch_app</i>
                                            </div>
                                            <h3>Trascina qui il file o clicca per effettuare l'upload</h3>
                                        </div>
                                        <div class="fallback">
                                            <input id="fimage" name="file" type="file" disabled />
                                        </div>
                                    </form>
                                    <!--<button type="button" class="btn btn-danger" id="hide_dropzone">
                                        Annulla
                                    </button>-->
                                </div>
                                <div id="image_dropzone_antibiogramma0" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden">
                                    <a href="#0" data-sub-html="Demo Description">
                                        <img id="antibiogramma0_image" data-toggle="modal" data-target="#largeModal" alt="Immagine antibiogramma" class="img-responsive thumbnail" src="{{route('immaginitemporaneepiastre',[getImageTemporary($code,'antibiogramma0')])}}">
                                    </a>
                                </div>
                                <div id="button_dropzone_antibiogramma0" class="row clearfix mr-0 hidden">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-right">
                                        <input type="button" tipo="antibiogramma0" name="elimina_foto_conta" id="elimina_foto_conta" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#eliminaFotoModal" value="Elimina Foto">    
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <hr>
                </div>
                @if(isset($campione))
                    @php $tot_occorrenza = 0 @endphp
                    @for($i = 1; $i <= $occorrenza; $i++ )
                        @php $tot_occorrenza++ @endphp
                        @include('schede.edit_molecolare.antibiogrammi_campione_molecolare',['occorrenza' => $i])
                    @endfor
                @endif
                <div class="container1"></div>
                <div class="row-clearfix hidden" id="to_clone">
                    <hr>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 pl-0">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 mb-0">
                                <label for="NAB">Codice piastra</label>
                                <div class="form-group">  
                                    <div class="form-line">
                                        <input type="number" id="NAB" class="form-control" name="NAB" value="{{ old('NAB') ?? '' }}" maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 pl-0">
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                        <div class="row clearfix mt-2 pl-1-2">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="antibiotici" class="col-md-8 col-form-label text-md-right">Antibiotico</label>
                                                            <select class="form-control show-tick" size="10" id="antibiotici">
                                                                <option value="" selected> -- Seleziona un antibiotico -- </option>
                                                                @foreach(App\Antibiotico::all() as $a)
                                                                    <option value="{{ $a->id }}">{{ $a->nome }}</option>   
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="form-group">
                                                            <label for="resistenza" class="col-md-8 col-form-label text-md-right">Resistenza</label>
                                                            <select class="form-control show-tick" size="10" id="resistenza" >
                                                                <option value="" selected> -- Seleziona una resistenza -- </option>
                                                                @foreach(App\Antibiotico::resistenza() as $key => $r)
                                                                    <option value="{{ $key }}">{{ $r }}</option>   
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-clearfix mb-2">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-left pl-0">
                                                        <input name="colonia" value="1" type="checkbox" id="colonia" class="filled-in chk-col-blue">
                                                        <label id="label_colonia" for="colonia">Presenza di colonie satelliti</label>                                                      
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-left">
                                                        <input type="button" id="aggiungi_antibiotico_resistenza" class="btn btn-primary waves-effect" value="Aggiungi" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                        <div class="row clearfix pl-1-2">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <h4 class="align-justify">Antibiotico resistenza</h4>
                                                            <select class="form-control ms" multiple="multiple" size="10" name="text_area_antibiotico_resistenza" id="text_area_antibiotico_resistenza">    
                                                                <option value="">Non sono presenti antibiotici con le relative resistenze</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-1-2 align-left">
                                                        <input type="button" id="cancella_antibiotico_resistenza" class="btn btn-danger waves-effect" value="Cancella" disabled>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <div class="row clearfix drop-file p-t-10">
                                <div id="dropzone_to_hidden" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-9">
                                    <form action="{{ URL::action('ImmagineMicroAntibiogrammaController@store') }}" id="dropzoneAltri" class="dropzone dz-clickable" method="post">
                                        {{csrf_field()}}
                                        <div class="dz-message">
                                            <div class="drag-icon-cph">
                                                <i class="material-icons">touch_app</i>
                                            </div>
                                            <h3>Drop files here or click to upload.</h3>
                                        </div>
                                        <div class="fallback">
                                            <input name="file" type="file" />
                                        </div>
                                    </form>
                                </div>
                                <div id="image_dropzone" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <a href="#0" data-sub-html="Demo Description">
                                            <img id="img_antibio_n" data-toggle="modal" data-target="#largeModal" alt="Immagine antibiogramma" class="img-responsive thumbnail" src="{{route('immaginitemporaneepiastre',[getImageTemporary($code,'antibiogramma')])}}">
                                        </a>
                                    </div>
                                </div>
                                <div id="button_dropzone" class="row clearfix mr-1-2 hidden">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-right">
                                        <input type="button" tipo="" name="elimina_foto_antibiogramma" id="elimina_foto_antibiogramma" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#eliminaFotoModal" value="Elimina Foto">    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row-clearfix">
                    @php $occorrenze = 0 @endphp
                        <input type="submit" class="btn bg-blue-grey waves-effect" occorrenza_iniziale={{ isset($campione) ? $tot_occorrenza : 0 }} occorrenze={{ isset($campione) ? $tot_occorrenza : $occorrenze }} id="aggiungi_antibiogramma" value="Aggiungi antibiogramma" disabled>
                </div>
            </div>
        </div>
    </div>
</div>