{{-- Strumenti --}}
<div class="row clearfix"> 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="body">
                <div class="form-horizontal">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-0">
                            <div class="demo-splite-button-dropdowns">
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 mb-0">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Immagine piastra campione<span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" id='immagine'>
                                            <li>
                                                <a href="#" id="carica_immagine" class=" waves-effect waves-block">Carica</a>
                                            </li>
                                            <!--<li>
                                                <a href="" target="_blank" class="waves-effect">Vedi</a>
                                            </li>
                                            <li>
                                                <a href="#" id="elimina_immagine" class="waves-effect">Annulla</a>
                                            </li>-->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix drop-file p-t-10 carica_immagine_piastra">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <form action="{{ URL::action('ImmaginiPiastreController@store') }}" id="dropzoneDoc" class="dropzone dz-clickable" method="post">
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
                            <button type="button" class="btn btn-danger" id="hide_dropzone">
                                Annulla
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>