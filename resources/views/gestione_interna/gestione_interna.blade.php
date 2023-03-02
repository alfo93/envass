@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row clearfix"> 
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Gestione interna</h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="alert alert-danger" style="display:none">
                            </div>
                        </div>
                    </div>

                    <!-- Gestione Antibiotici -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="mb-3">Gestione degli antibiotici</h3>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="row clearfix">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label for="nome">Nome</label>
                                                    <input type="text" class="form-control" name="antibiotico_nome" placeholder="" id="antibiotico_nome">
                                                </div>
                                                <div class="help-info">Nome dell'antibiotico</div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-right" style="margin-top:30px;">
                                                <input type="button" name="aggiungi_antibiotico" id="aggiungi_antibiotico" class="btn btn-primary btn-lg waves-effect" value="Aggiungi">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <div class="row clearfix">
                                        <div id="contenitore_antibiotici" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <h3 id="titolo_antibiotici" class="align-justify">Antibiotici inseriti</h3>
                                                <select class="form-control ms" multiple="multiple" size="24" name="text_area_antibiotici" id="text_area_antibiotici">
                                                    @foreach($antibiotici as $a)
                                                        <option value="{{ $a->id }}" nome="{{$a->nome}}"> {{ $a->nome}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0 align-right">
                                            <input type="button" id="cancella_antibiotico_button" class="btn btn-danger waves-effect" value="Cancella"  data-toggle="modal" data-target="#deleteModal" disabled>
                                            <!--<input type="button" name="rendi_non_disponibile_principio_attivo" id="rendi_non_disponibile_principio_attivo" class="btn btn-warning btn waves-effect" value="Non Disponibile" disabled>
                                            <input type="button" name="rendi_disponibile_principio_attivo" id="rendi_disponibile_principio_attivo" class="btn btn-success btn waves-effect" value="Disponibile" disabled>-->
                                            <input type="button" name="modifica_antibiotico" id="modifica_antibiotico" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#ModalAntibiotico"  value="Modifica"  disabled>    
                                        </div>
                                    </div>
                                <!--modal-->
                                <div class="modal fade in" id="ModalAntibiotico" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="ModalAntibioticoLabel">Modifica Antibiotico</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form_advanced_validation" method="POST" novalidate="novalidate">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="nome">Nome</label>
                                                            <input type="text" id="aNome" class="form-control" name="minmaxlength" maxlength="35" minlength="3" required="" aria-required="true" value="">                                                          
                                                        </div>
                                                        <div class="help-info">Nome dell'antibiotico</div>
                                                    </div>  
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="nome">Motivo</label>
                                                            <input type="text" id="aMotivo" class="form-control" name="minmaxlength" required="" aria-required="true" value="">                                                          
                                                        </div>
                                                        <div class="help-info">Motivo della modifica</div>
                                                    </div>                            
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="modifica_antibiotico_salva" name="modifica_antibiotico_salva" class="btn btn-link waves-effect" tipo="" >SALVA</button>
                                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end modal-->
                            </div>
                        </div>
                    </div>
                    <!-- FINE gestione antibiotici -->
                    <hr>
                    <!-- Gestione Materiali -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="mb-3">Gestione dei materiali</h3>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="row clearfix">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label for="nome">Nome</label>
                                                    <input type="text" class="form-control" name="materiale_nome" placeholder="" id="materiale_nome">
                                                </div>
                                                <div class="help-info">Nome del materiale</div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-right" style="margin-top:30px;">
                                                <input type="button" name="aggiungi_materiale" id="aggiungi_materiale" class="btn btn-primary btn-lg waves-effect" value="Aggiungi">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <div class="row clearfix">
                                        <div id="contenitore_materiali" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <h3 id="titolo_materiali_inseriti" class="align-justify">Materiali inseriti</h3>
                                                <select class="form-control ms" multiple="multiple" size="24" name="text_area_materiali" id="text_area_materiali">
                                                    @foreach($materiali as $m)
                                                        <option value="{{ $m->id }}" nome="{{$m->materiale}}"> {{ $m->materiale}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0 align-right">
                                            <input type="button" id="cancella_materiale_button" class="btn btn-danger waves-effect" value="Cancella" data-toggle="modal" data-target="#deleteModal" disabled>
                                            <!--<input type="button" name="rendi_non_disponibile_principio_attivo" id="rendi_non_disponibile_principio_attivo" class="btn btn-warning btn waves-effect" value="Non Disponibile" disabled>
                                            <input type="button" name="rendi_disponibile_principio_attivo" id="rendi_disponibile_principio_attivo" class="btn btn-success btn waves-effect" value="Disponibile" disabled>-->
                                            <input type="button" name="modifica_materiale" id="modifica_materiale" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#ModalMateriale"  value="Modifica"  disabled>    
                                        </div>
                                    </div>
                                <!--modal-->
                                <div class="modal fade in" id="ModalMateriale" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="ModalMaterialeLabel">Modifica Materiale</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form_advanced_validation" method="POST" novalidate="novalidate">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="nome">Nome</label>
                                                            <input type="text" id="mNome" class="form-control" name="minmaxlength" maxlength="35" minlength="3" required="" aria-required="true" value="">                                                          
                                                        </div>
                                                        <div class="help-info">Nome del materiale</div>
                                                    </div> 
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="mMotivo">Motivo</label>
                                                            <input type="text" id="mMotivo" class="form-control" name="minmaxlength" required="" aria-required="true" value="">                                                          
                                                        </div>
                                                        <div class="help-info">Motivo della modifica</div>
                                                    </div>                         
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="modifica_materiale_salva" name="modifica_materiale_salva" class="btn btn-link waves-effect" tipo="" >SALVA</button>
                                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end modal-->
                            </div>
                        </div>
                    </div>
                    <!-- FINE gestione materiali -->
                    <hr>
                    <!-- Gestione Microrganismi -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="mb-3">Gestione dei microrganismi</h3>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="row clearfix">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="microrganismo_nome">Nome</label>
                                                        <input type="text" class="form-control" name="microrganismo_nome" placeholder="" id="microrganismo_nome">
                                                    </div>
                                                    <div class="help-info">Nome del microrganismo</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label for="gram">Batterio Gram: </label>
                                                    <select class="form-control show-tick" name="gram" id="gram">
                                                        <option value="">-- Seleziona un'opzione --</option>
                                                        <option value="positivo">Positivo</option>
                                                        <option value="negativo">Negativo</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 pl-0">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label for="entbac">Enterobacteriaceae: </label>
                                                    <select class="form-control show-tick" name="entbac" id="entbac">
                                                        <option value="">-- Seleziona un'opzione --</option>
                                                        <option value="si">Si</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                            <div class="row clearfix">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="colif">Coliformi: </label>
                                                        <select class="form-control show-tick" name="colif" id="colif">
                                                            <option value="">-- Seleziona un'opzione --</option>
                                                            <option value="si">Si</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label for="gruppo">Gruppo: </label>
                                                    <input type="number" id="gruppo" name="gruppo" class="form-control" value="" maxlength="11">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                        
                                        
                                    </div>
                                    <div class="row clearfix mr-1">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-right" style="margin-top:30px;">
                                            <input type="button" name="aggiungi_microrganismo" id="aggiungi_microrganismo" class="btn btn-primary btn-lg waves-effect" value="Aggiungi">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <div class="row clearfix">
                                        <div id="contenitore_microrganismi" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <h3 id="titolo_microrganismi_inseriti" class="align-justify">Microrganismi</h3>
                                                <select class="form-control ms" multiple="multiple" size="24" name="text_area_microrganismi" id="text_area_microrganismi">
                                                    @if($m->microrganismo != "Nessuno")
                                                    @foreach($microrganismi as $m)
                                                        <option value="{{ $m->id }}" nome="{{$m->microrganismo}}" batGram="{{ $m->batGramN == 1 ? 'negativo' : 'positivo'  }}" entBac="{{ $m->entBac }}" colif="{{ $m->colif }}" gruppo="{{ $m->gruppo }}"> {{ $m->microrganismo . " " . ($m->batGramN == 1 ? 'Gram:-' : 'Gram:+') . " " . ($m->entBac == 1 ? 'Enterobacteriaceae' : '') . " " . ($m->colif == 1 ? 'coliforme' : '') . " " . ($m->gruppo > 0 ? $m->gruppo : '') }}  </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0 align-right">
                                            <input type="button" id="cancella_microrganismo_button" class="btn btn-danger waves-effect" value="Cancella" data-toggle="modal" data-target="#deleteModal" disabled>
                                            <!--<input type="button" name="rendi_non_disponibile_principio_attivo" id="rendi_non_disponibile_principio_attivo" class="btn btn-warning btn waves-effect" value="Non Disponibile" disabled>
                                            <input type="button" name="rendi_disponibile_principio_attivo" id="rendi_disponibile_principio_attivo" class="btn btn-success btn waves-effect" value="Disponibile" disabled>-->
                                            <input type="button" name="modifica_microrganismo" id="modifica_microrganismo" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#ModalMicrorganismo"  value="Modifica"  disabled>    
                                        </div>
                                    </div>
                                <!--modal-->
                                <div class="modal fade in" id="ModalMicrorganismo" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="ModalMicrorganismoLabel">Modifica Principio Attivo</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form_advanced_validation" method="POST" novalidate="novalidate">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="row clearfix pl-1 pr-1">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <label for="nome">Nome</label>
                                                                        <input type="text" class="form-control" name="microrganismo_nome_modal" placeholder="" id="microrganismo_nome_modal">
                                                                    </div>
                                                                    <div class="help-info">Nome del microrganismo</div>
                                                                </div>
                                                            </div>
                                                            <div class="row clearfix pl-1 pr-1">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <label for="gram_modal">Batterio Gram: </label>
                                                                        <select class="form-control show-tick" name="gram_modal" id="gram_modal">
                                                                            <option value="positivo">Positivo</option>
                                                                            <option value="negativo">Negativo</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row clearfix pl-1 pr-1">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <label for="entbac_modal">Enterobacteriaceae: </label>
                                                                        <select class="form-control show-tick" name="entbac_modal" id="entbac_modal">
                                                                            <option value="si">Si</option>
                                                                            <option value="no">No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row clearfix pl-1 pr-1">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <label for="coli_modal">Coliformi: </label>
                                                                        <select class="form-control show-tick" name="colif_modal" id="colif_modal">
                                                                            <option value="si">Si</option>
                                                                            <option value="no">No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row clearfix pl-1 pr-1">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <label for="gruppo_modal">Gruppo: </label>
                                                                        <input type="number" id="gruppo_modal" name="gruppo_modal" class="form-control" value="" maxlength="11">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row clearfix pl-1 pr-1">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <label for="motivo_microrganismo_modal">Motivo</label>
                                                                        <input type="text" id="motivo_microrganismo_modal" class="form-control" name="minmaxlength" required="" aria-required="true" value="">                                                          
                                                                    </div>
                                                                    <div class="help-info">Motivo della modifica</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                       
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="modifica_microrganismo_salva" name="modifica_microrganismo_salva" class="btn btn-link waves-effect" tipo="" >SALVA</button>
                                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end modal-->
                            </div>
                        </div>
                    </div>
                    <!-- FINE gestione microrganismi -->
                    <hr>
                    <!-- Gestione Categoria -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="mb-3">Gestione delle categorie</h3>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="row clearfix">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label for="categoria_nome">Nome</label>
                                                    <input type="text" class="form-control" name="categoria_nome" placeholder="" id="categoria_nome">
                                                </div>
                                                <div class="help-info">Nome della categoria</div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-right" style="margin-top:30px;">
                                                <input type="button" name="aggiungi_categoria" id="aggiungi_categoria" class="btn btn-primary btn-lg waves-effect" value="Aggiungi">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <div class="row clearfix">
                                        <div id="contenitore_categorie" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <h3 id="titolo_categorie_inseriti" class="align-justify">Categorie inserite</h3>
                                                <select class="form-control ms" multiple="multiple" size="24" name="text_area_categorie" id="text_area_categorie">
                                                    @foreach($categorie as $c)
                                                        <option value="{{ $c->id }}" nome="{{$c->categoria}}"> {{ $c->categoria}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0 align-right">
                                            <input type="button" id="cancella_categoria_button" class="btn btn-danger waves-effect" value="Cancella" data-toggle="modal" data-target="#deleteModal" disabled>
                                            <!--<input type="button" name="rendi_non_disponibile_principio_attivo" id="rendi_non_disponibile_principio_attivo" class="btn btn-warning btn waves-effect" value="Non Disponibile" disabled>
                                            <input type="button" name="rendi_disponibile_principio_attivo" id="rendi_disponibile_principio_attivo" class="btn btn-success btn waves-effect" value="Disponibile" disabled>-->
                                            <input type="button" name="modifica_categoria" id="modifica_categoria" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#ModalCategoria"  value="Modifica"  disabled>    
                                        </div>
                                    </div>
                                <!--modal-->
                                <div class="modal fade in" id="ModalCategoria" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="ModalCategoriaLabel">Modifica Categoria</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form_advanced_validation" method="POST" novalidate="novalidate">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="cNome">Nome</label>
                                                            <input type="text" id="cNome" class="form-control" name="minmaxlength" maxlength="35" minlength="3" required="" aria-required="true" value="">                                                          
                                                        </div>
                                                        <div class="help-info">Nome del materiale</div>
                                                    </div> 
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="cMotivo">Motivo</label>
                                                            <input type="text" id="cMotivo" class="form-control" name="minmaxlength" required="" aria-required="true" value="">                                                          
                                                        </div>
                                                        <div class="help-info">Motivo della modifica</div>
                                                    </div>                         
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="modifica_categoria_salva" name="modifica_categoria_salva" class="btn btn-link waves-effect" tipo="" >SALVA</button>
                                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end modal-->
                            </div>
                        </div>
                    </div>
                    <!-- FINE gestione categorie -->
                    <hr>
                    <!-- Gestione Prodotto -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="mb-3">Gestione dei prodotti</h3>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="row clearfix">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label for="prodotto_nome">Nome</label>
                                                    <input type="text" class="form-control" name="prodotto_nome" placeholder="" id="prodotto_nome">
                                                </div>
                                                <div class="help-info">Nome del prodotto</div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-right" style="margin-top:30px;">
                                                <input type="button" name="aggiungi_prodotto" id="aggiungi_prodotto" class="btn btn-primary btn-lg waves-effect" value="Aggiungi">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <div class="row clearfix">
                                        <div id="contenitore_prodotti" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <h3 id="titolo_prodotti_inseriti" class="align-justify">Prodotti inseriti</h3>
                                                <select class="form-control ms" multiple="multiple" size="24" name="text_area_prodotti" id="text_area_prodotti">
                                                    @foreach($prodotti as $p)
                                                        <option value="{{ $p->id }}" nome="{{$p->prodotto}}"> {{ $p->prodotto}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0 align-right">
                                            <input type="button" id="cancella_prodotto_button" class="btn btn-danger waves-effect" value="Cancella" data-toggle="modal" data-target="#deleteModal" disabled>
                                            <!--<input type="button" name="rendi_non_disponibile_principio_attivo" id="rendi_non_disponibile_principio_attivo" class="btn btn-warning btn waves-effect" value="Non Disponibile" disabled>
                                            <input type="button" name="rendi_disponibile_principio_attivo" id="rendi_disponibile_principio_attivo" class="btn btn-success btn waves-effect" value="Disponibile" disabled>-->
                                            <input type="button" name="modifica_prodotto" id="modifica_prodotto" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#ModalProdotto"  value="Modifica"  disabled>    
                                        </div>
                                    </div>
                                <!--modal-->
                                <div class="modal fade in" id="ModalProdotto" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="ModalProdottoLabel">Modifica Prodotto</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form_advanced_validation" method="POST" novalidate="novalidate">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="pNome">Nome</label>
                                                            <input type="text" id="pNome" class="form-control" name="minmaxlength" maxlength="35" minlength="3" required="" aria-required="true" value="">                                                          
                                                        </div>
                                                        <div class="help-info">Nome del prodotto</div>
                                                    </div>  
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="pMotivo">Motivo</label>
                                                            <input type="text" id="pMotivo" class="form-control" name="minmaxlength" required="" aria-required="true" value="">                                                          
                                                        </div>
                                                        <div class="help-info">Motivo della modifica</div>
                                                    </div>                        
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="modifica_prodotto_salva" name="modifica_prodotto_salva" class="btn btn-link waves-effect" tipo="" >SALVA</button>
                                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end modal-->
                            </div>
                        </div>
                    </div>
                    <!-- FINE gestione prodotto -->
                    <hr>
                    <!-- Gestione Protocolli -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="mb-3">Gestione dei protocolli</h3>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="row clearfix">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label for="protocollo_nome">Nome</label>
                                                    <input type="text" class="form-control" name="protocollo_nome" placeholder="" id="protocollo_nome">
                                                </div>
                                                <div class="help-info">Nome del protocollo</div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-right" style="margin-top:30px;">
                                                <input type="button" name="aggiungi_protocollo" id="aggiungi_protocollo" class="btn btn-primary btn-lg waves-effect" value="Aggiungi">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <div class="row clearfix">
                                        <div id="contenitore_protocolli" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <h3 id="titolo_protocolli_inseriti" class="align-justify">Protocolli inseriti</h3>
                                                <select class="form-control ms" multiple="multiple" size="24" name="text_area_protocolli" id="text_area_protocolli">
                                                    @foreach($protocolli as $p)
                                                        <option value="{{ $p->id }}" nome="{{$p->protocollo}}"> {{ $p->protocollo}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0 align-right">
                                            <input type="button" id="cancella_protocollo_button" class="btn btn-danger waves-effect" value="Cancella" data-toggle="modal" data-target="#deleteModal" disabled>
                                            <!--<input type="button" name="rendi_non_disponibile_principio_attivo" id="rendi_non_disponibile_principio_attivo" class="btn btn-warning btn waves-effect" value="Non Disponibile" disabled>
                                            <input type="button" name="rendi_disponibile_principio_attivo" id="rendi_disponibile_principio_attivo" class="btn btn-success btn waves-effect" value="Disponibile" disabled>-->
                                            <input type="button" name="modifica_protocollo" id="modifica_protocollo" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#ModalProtocollo"  value="Modifica"  disabled>    
                                        </div>
                                    </div>
                                <!--modal-->
                                <div class="modal fade in" id="ModalProtocollo" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="ModalProtocolloLabel">Modifica Protocollo</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form_advanced_validation" method="POST" novalidate="novalidate">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="protocolloNome">Nome</label>
                                                            <input type="text" id="protocolloNome" class="form-control" name="minmaxlength" maxlength="35" minlength="3" required="" aria-required="true" value="">                                                          
                                                        </div>
                                                        <div class="help-info">Nome del protocollo</div>
                                                    </div> 
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="protocolloMotivo">Motivo</label>
                                                            <input type="text" id="protocolloMotivo" class="form-control" name="minmaxlength" required="" aria-required="true" value="">                                                          
                                                        </div>
                                                        <div class="help-info">Motivo della modifica</div>
                                                    </div>                         
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="modifica_protocollo_salva" name="modifica_protocollo_salva" class="btn btn-link waves-effect" tipo="" >SALVA</button>
                                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end modal-->
                            </div>
                        </div>
                    </div>
                    <!-- FINE gestione protocolli -->
                    <hr>
                    <!-- Gestione PuntiCampionamento -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="mb-3">Gestione dei punti campionamento</h3>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="row clearfix pl-0">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pl-0">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pr-2">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="puntocampionamento_nome">Nome</label>
                                                            <input type="text" class="form-control" name="puntocampionamento_nome" placeholder="" id="puntocampionamento_nome">
                                                        </div>
                                                        <div class="help-info">Punto di campionamento</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pl-3">
                                                    <div class="row clearfix">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <label for="codPC">Codice</label>
                                                                <input type="text" class="form-control" name="codPC" placeholder="" id="codPC">
                                                            </div>
                                                            <div class="help-info">Codice identificativo del punto di campionamento</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix pl-0">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pl-0">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label for="categoriaPC">Categoria</label>
                                                            <select id="categoriaPC" class="form-control show-tick" size="24">
                                                                <option selected value="">-- Seleziona un'opzione --</option>
                                                                @foreach($categorie as $c)
                                                                    <option value="{{ $c->id }}" nome="{{$c->categoria}}"> {{ $c->categoria}} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pr-0">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label for="matricePC">Matrice</label>
                                                            <select id="matricePC" class="form-control show-tick" size="24">
                                                                <option selected value="">-- Seleziona un'opzione --</option>
                                                                @foreach(App\PuntoCampionamento::getMatrice() as $key => $m)
                                                                    <option value="{{ $key }}" nome="{{ $m }}"> {{ $m }} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-right" style="margin-top:30px;">
                                                <input type="button" name="aggiungi_puntocampionamento" id="aggiungi_puntocampionamento" class="btn btn-primary btn-lg waves-effect" value="Aggiungi">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <div class="row clearfix">
                                        <div id="contenitore_punticampionamento" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <h3 id="titolo_punticampionamento_inseriti" class="align-justify">Punti campionamento inseriti</h3>
                                                <select class="form-control ms" multiple="multiple" size="24" name="text_area_punticampionamento" id="text_area_punticampionamento">
                                                    @foreach($punticampionamento as $p)
                                                        <option value="{{ $p->id }}" nome="{{$p->punto_campionamento}}" nome_categoria="{{ $p->categoria }}" id_categoria="{{ $p->id_categoria }}" codPC="{{ $p->codPC }}" matrice="{{ $p->matrice }}"> {{ ucfirst($p->punto_campionamento) ." - ".ucfirst($p->categoria)." - ".ucfirst($p->codPC)." - ".$p->matrice }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0 align-right">
                                            <input type="button" id="cancella_puntocampionamento_button" class="btn btn-danger waves-effect" value="Cancella" data-toggle="modal" data-target="#deleteModal" disabled>
                                            <input type="button" name="modifica_puntocampionamento" id="modifica_puntocampionamento" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#ModalPuntoCampionamento"  value="Modifica"  disabled>    
                                        </div>
                                    </div>
                                <!--modal-->
                                <div class="modal fade in" id="ModalPuntoCampionamento" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="ModalPuntoCampionamentoLabel">Modifica Punto campionamento</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form_advanced_validation" method="POST" novalidate="novalidate">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="puntocampionamentoNome">Nome</label>
                                                            <input type="text" id="puntocampionamento_nome_modal" class="form-control" name="minmaxlength" maxlength="35" minlength="3" required="" aria-required="true" value="">                                                          
                                                        </div>
                                                        <div class="help-info">Nome del punto di campionamento</div>
                                                    </div> 
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="gram">Categoria</label>
                                                            <select id="categoriaPC_modal" class="form-control show-tick" size="24">
                                                                <option selected value="">-- Seleziona un'opzione --</option>
                                                                @foreach($categorie as $c)
                                                                    <option value="{{ $c->id }}" nome="{{$c->categoria}}"> {{ $c->categoria}} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div> 
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="codPC_modal">Codice</label>
                                                            <input type="text" class="form-control" name="codPC_modal" placeholder="" id="codPC_modal">
                                                        </div>
                                                        <div class="help-info">Codice identificativo del punto di campionamento</div>
                                                    </div>
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="matricePC_modal">Matrice</label>
                                                            <select id="matricePC_modal" class="form-control show-tick" size="24">
                                                                <option selected value="">-- Seleziona un'opzione --</option>
                                                                @foreach(App\PuntoCampionamento::getMatrice() as $key => $m)
                                                                    <option value="{{ $key }}" nome="{{ $m }}"> {{ $m }} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="motivo_puntocampionamento_modal">Motivo</label>
                                                            <input type="text" id="motivo_puntocampionamento_modal" class="form-control" name="minmaxlength" required="" aria-required="true" value="">                                                          
                                                        </div>
                                                        <div class="help-info">Motivo della modifica</div>
                                                    </div>                          
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="modifica_puntocampionamento_salva" name="modifica_puntocampionamento_salva" class="btn btn-link waves-effect" tipo="" >SALVA</button>
                                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end modal-->
                            </div>
                        </div>
                    </div>
                    <!-- FINE gestione PuntiCampionamento -->
                    <hr>
                    <!-- Gestione Struttura -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="mb-3">Gestione delle strutture</h3>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="row clearfix">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label for="struttura_nome">Nome</label>
                                                    <input type="text" class="form-control" name="struttura_nome" placeholder="" id="struttura_nome">
                                                </div>
                                                <div class="help-info">nome della struttura</div>
                                            </div>
                                        </div>
                                        <div class="row clearfix pl-0">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pl-0">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label for="struttura_sede">Sede</label>
                                                            <input type="text" class="form-control" name="struttura_sede" placeholder="" id="struttura_sede">
                                                        </div>
                                                        <div class="help-info">città sede della struttura</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pr-0">
                                                    <div class="row clearfix">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <label for="struttura_provincia">Provincia</label>
                                                                <input type="text" class="form-control" name="struttura_provincia" placeholder="" id="struttura_provincia" style="text-transform:uppercase;">
                                                            </div>
                                                            <div class="help-info">provincia della città sede della struttura</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix pl-0">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="row clearfix mr-0">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <label for="codice_struttura">Codice struttura</label>
                                                                <input type="text" class="form-control" name="codice_struttura" placeholder="" id="codice_struttura" style="text-transform:uppercase;">
                                                            </div>
                                                            <div class="help-info">Codice identificativo della struttura</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="row clearfix mr-0">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <label for="codice_sede">Codice sede</label>
                                                                <input type="text" class="form-control" name="codice_sede" placeholder="" id="codice_sede" style="text-transform:capitalize;">
                                                            </div>
                                                            <div class="help-info">Codice identificativo della città sede della struttura</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pr-0">
                                                    <div class="row clearfix">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <label for="codice_provincia">Codice provincia</label>
                                                                <input type="text" class="form-control" name="codice_provincia" placeholder="" id="codice_provincia" style="text-transform:uppercase;">
                                                            </div>
                                                            <div class="help-info">Codice identificativo della provincia sede della struttura</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-right" style="margin-top:30px;">
                                                <input type="button" name="aggiungi_struttura" id="aggiungi_struttura" class="btn btn-primary btn-lg waves-effect" value="Aggiungi">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <div class="row clearfix">
                                        <div id="contenitore_struttura" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <h3 id="titolo_struttura_inseriti" class="align-justify">Strutture inserite</h3>
                                                <select class="form-control ms" multiple="multiple" size="24" name="text_area_strutture" id="text_area_strutture">
                                                    @foreach($strutture as $s)
                                                        <option value="{{ $s->id }}" nome="{{$s->struttura}}" provincia="{{$s->provincia}}" sede="{{$s->sede}}" codice_sede="{{ $s->codice_sede }}" codice_provincia="{{ $s->codice_provincia }}" codice_struttura="{{ $s->codice_struttura }}"> {{ ucfirst($s->struttura) }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0 align-right">
                                            <input type="button" id="cancella_struttura_button" class="btn btn-danger waves-effect" value="Cancella" data-toggle="modal" data-target="#deleteModal" disabled>
                                            <input type="button" name="modifica_struttura" id="modifica_struttura" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#ModalStruttura"  value="Modifica"  disabled>    
                                        </div>
                                    </div>
                                <!--modal-->
                                <div class="modal fade in" id="ModalStruttura" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="ModalStrutturaLabel">Modifica Struttura</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form_advanced_validation" method="POST" novalidate="novalidate">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="struttura_nome_modal">Struttura</label>
                                                            <input type="text" id="struttura_nome_modal" class="form-control" name="minmaxlength" maxlength="35" minlength="3" required="" aria-required="true" value="">                                                          
                                                        </div>
                                                    </div> 
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="struttura_sede_modal">Sede</label>
                                                            <input type="text" class="form-control" name="struttura_sede_modal" placeholder="" id="struttura_sede_modal">
                                                        </div>
                                                    </div> 
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="struttura_provincia_modal">Provincia</label>
                                                            <input type="text" class="form-control" name="struttura_provincia_modal" placeholder="" id="struttura_provincia_modal" style="text-transform:uppercase;" min="2" max="2">
                                                        </div>
                                                    </div> 
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="codiceStruttura_modal">Codice struttura</label>
                                                            <input type="text" class="form-control" name="codiceStruttura_modal" placeholder="" id="codiceStruttura_modal" style="text-transform:uppercase;">
                                                        </div>
                                                    </div> 
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="codiceStrutturaSede_modal">Codice sede</label>
                                                            <input type="text" class="form-control" name="codiceStrutturaSede_modal" placeholder="" id="codiceStrutturaSede_modal" style="text-transform:capitalize;" max="3">
                                                        </div>
                                                    </div> 
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="codiceStrutturaProvincia_modal">Codice provincia</label>
                                                            <input type="text" class="form-control" name="codiceStrutturaProvincia_modal" placeholder="" id="codiceStrutturaProvincia_modal" style="text-transform:uppercase;" min="2" max="2">
                                                        </div>
                                                    </div> 
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="motivo_struttura_modal">Motivo</label>
                                                            <input type="text" id="motivo_struttura_modal" class="form-control" name="minmaxlength" required="" aria-required="true" value="" style="text-transform:uppercase;">                                                          
                                                        </div>
                                                        <div class="help-info">Motivo della modifica</div>
                                                    </div>                         
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="modifica_struttura_salva" name="modifica_struttura_salva" class="btn btn-link waves-effect" tipo="" >SALVA</button>
                                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end modal-->
                            </div>
                        </div>
                    </div>
                    <!-- FINE gestione Struttura -->
                    <hr>
                    <!-- Gestione Reparto -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="mb-3">Gestione delle partizioni</h3>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="row clearfix pl-0">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="reparto_nome">Nome</label>
                                                            <input type="text" class="form-control" name="reparto_nome" placeholder="" id="reparto_nome">
                                                        </div>
                                                        <div class="help-info">nome della partizione</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="reparto_nome">Codice partizione</label>
                                                            <input type="text" class="form-control" name="reparto_nome" placeholder="" id="reparto_codice" style="text-transform: lowercase">
                                                        </div>
                                                        <div class="help-info">codice della partizione</div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-right" style="margin-top:30px;">
                                                <input type="button" name="aggiungi_reparto" id="aggiungi_reparto" class="btn btn-primary btn-lg waves-effect" value="Aggiungi">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <div class="row clearfix">
                                        <div id="contenitore_reparto" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <h3 id="titolo_reparto_inseriti" class="align-justify">Partizioni inserite</h3>
                                                <select class="form-control ms" multiple="multiple" size="24" name="text_area_reparti" id="text_area_reparti">
                                                    @foreach($reparti as $r)
                                                        <option value="{{ $r->id }}" nome="{{ $r->partizione }}" codice="{{ $r->codice_partizione }}"> {{ ucfirst($r->partizione) }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0 align-right">
                                            <input type="button" id="cancella_reparto_button" class="btn btn-danger waves-effect" value="Cancella" data-toggle="modal" data-target="#deleteModal" disabled>
                                            <input type="button" name="modifica_reparto" id="modifica_reparto" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#ModalReparto"  value="Modifica"  disabled>    
                                        </div>
                                    </div>
                                <!--modal-->
                                <div class="modal fade in" id="ModalReparto" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="ModalRepartoLabel">Modifica Partizione</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form_advanced_validation" method="POST" novalidate="novalidate">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="reparto_nome_modal">Partizione</label>
                                                            <input type="text" id="reparto_nome_modal" class="form-control" name="minmaxlength" maxlength="35" minlength="3"required="" aria-required="true" value="" style="text-transform: capitalize">                                                          
                                                        </div>
                                                    </div> 
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="reparto_codice_modal">Codice</label>
                                                            <input type="text" id="reparto_codice_modal" class="form-control" name="minmaxlength" maxlength="3" max="3" min="3" required="" aria-required="true" value="" style="text-transform: lowercase">                                                          
                                                        </div>
                                                    </div> 
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="motivo_reparto_modal">Motivo</label>
                                                            <input type="text" id="motivo_reparto_modal" class="form-control" name="minmaxlength" required="" aria-required="true" value="">                                                          
                                                        </div>
                                                        <div class="help-info">Motivo della modifica</div>
                                                    </div>                      
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="modifica_reparto_salva" name="modifica_reparto_salva" class="btn btn-link waves-effect" tipo="" >SALVA</button>
                                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end modal-->
                            </div>
                        </div>
                    </div>
                    <!-- FINE gestione Reparto -->
                    <hr>
                    <!-- Gestione STANZA -->
                    {{-- <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="mb-3">Gestione delle stanze</h3>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="row clearfix">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label for="stanza_nome">Nome</label>
                                                    <input type="text" class="form-control" name="stanza_nome" placeholder="" id="stanza_nome">
                                                </div>
                                                <div class="help-info">nome della stanza</div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-right" style="margin-top:30px;">
                                                <input type="button" name="aggiungi_stanza" id="aggiungi_stanza" class="btn btn-primary btn-lg waves-effect" value="Aggiungi">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <div class="row clearfix">
                                        <div id="contenitore_stanza" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <h3 id="titolo_stanza_inseriti" class="align-justify">Stanze inserite</h3>
                                                <select class="form-control ms" multiple="multiple" size="24" name="text_area_stanze" id="text_area_stanze">
                                                    @foreach($stanze as $s)
                                                        <option value="{{ $s->id }}" nome="{{ $s->stanza }}"> {{ $s->stanza }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0 align-right">
                                            <input type="button" id="cancella_stanza_button" class="btn btn-danger waves-effect" value="Cancella" data-toggle="modal" data-target="#deleteModal" disabled>
                                            <input type="button" name="modifica_stanza" id="modifica_stanza" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#ModalStanza"  value="Modifica" disabled>    
                                        </div>
                                    </div>
                                <!--modal-->
                                <div class="modal fade in" id="ModalStanza" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="ModalStanzaLabel">Modifica Stanza</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form_advanced_validation" method="POST" novalidate="novalidate">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="stanza_nome_modal">Struttura</label>
                                                            <input type="text" id="stanza_nome_modal" class="form-control" name="minmaxlength" maxlength="35" minlength="3" required="" aria-required="true" value="">                                                          
                                                        </div>
                                                    </div>  
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="motivo_stanza_modal">Motivo</label>
                                                            <input type="text" id="motivo_stanza_modal" class="form-control" name="minmaxlength" required="" aria-required="true" value="">                                                          
                                                        </div>
                                                        <div class="help-info">Motivo della modifica</div>
                                                    </div>                     
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="modifica_stanza_salva" name="modifica_stanza_salva" class="btn btn-link waves-effect" tipo="" >SALVA</button>
                                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end modal-->
                            </div>
                        </div>
                    </div> --}}
                    <!-- FINE gestione Stanza -->
                    {{-- <hr> --}}
                    <!-- Gestione PIASTRA -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="mb-3">Gestione delle piastre</h3>
                            <div class="col-lg-6 col-md-ol-md-6 col-sm-12 col-xs-12">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="row clearfix">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="piastra_nome">Piastra</label>
                                                        <input type="text" class="form-control" name="piastra_nome" placeholder="" id="piastra_nome">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label for="superficie_piastra">Superificie</label>
                                                    <input type="number" class="form-control" name="superficie_piastra" placeholder="" id="superficie_piastra">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label for="tipo_piastra">Tipo </label>
                                                            <input type="number" id="tipo_piastra" name="tipo_piastra" class="form-control" value="" maxlength="11">
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label for="abbreviazione_piastra">Abbreviazione </label>
                                                    <input type="text" class="form-control" name="abbreviazione_piastra" id="abbreviazione_piastra" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix mr-1">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-right" style="margin-top:30px;">
                                            <input type="button" name="aggiungi_piastra" id="aggiungi_piastra" class="btn btn-primary btn-lg waves-effect" value="Aggiungi">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                <div class="row clearfix">
                                    <div id="contenitore_piastra" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <h3 id="titolo_piastra_inseriti" class="align-justify">Piastre inserite</h3>
                                            <select class="form-control ms" multiple="multiple" size="24" name="text_area_piastre" id="text_area_piastre">
                                                @foreach($tipopiastra as $p)
                                                    <option value="{{ $p->id }}" id_piastra="{{ $p->id }}" nome="{{ $p->piastra }}" superficie="{{ $p->superficie }}" tipo="{{ $p->tipo }}" abbreviazione={{ $p->abbreviazione }}> {{ $p->piastra }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0 align-right">
                                        <input type="button" id="cancella_piastra_button" class="btn btn-danger waves-effect" value="Cancella" data-toggle="modal" data-target="#deleteModal" disabled>
                                        <input type="button" name="modifica_piastra" id="modifica_piastra" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#ModalPiastra"  value="Modifica" disabled>    
                                    </div>
                                </div>
                                <!--modal-->
                                <div class="modal fade in" id="ModalPiastra" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="ModalPiastraLabel">Modifica Piastra</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form_advanced_validation" method="POST" novalidate="novalidate">
                                                    <div class="form-group form-float">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <div class="row clearfix">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label for="piastra_nome_modal">Piastra</label>
                                                                            <input type="text" class="form-control" name="piastra_nome_modal" placeholder="" id="piastra_nome_modal">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label for="superficie_piastra_modal">Superificie</label>
                                                                        <input type="text" class="form-control" name="superficie_piastra_modal" placeholder="" id="superficie_piastra_modal">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <div class="row clearfix">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <label for="tipo_piastra_modal">Tipo </label>
                                                                                <input type="number" id="tipo_piastra_modal" name="tipo_piastra_modal" class="form-control" value="" maxlength="11">
                                                                            </div>
                                                                        </div>
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label for="abbreviazione_piastra_modal">Abbreviazione </label>
                                                                        <input type="text" class="form-control" name="abbreviazione_piastra_modal" id="abbreviazione_piastra_modal" placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <label for="motivo_piastra_modal">Motivo</label>
                                                                    <input type="text" id="motivo_piastra_modal" class="form-control" name="minmaxlength" required="" aria-required="true" value="">                                                          
                                                                </div>
                                                                <div class="help-info">Motivo della modifica</div>
                                                            </div>
                                                        </div>
                                                    </div>                       
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="modifica_piastra_salva" name="modifica_piastra_salva" class="btn btn-link waves-effect" tipo="" >SALVA</button>
                                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end modal-->
                            </div>
                        </div>
                    </div>
                    <!-- FINE gestione PIASTRA -->
                    <hr>
                    <!-- Gestione StruttureReparti -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="mb-3">Assegnazione Progetti</h3>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="row clearfix">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="struttrep_progetti">Progetto</label>
                                                        <select class="form-control show-tick" id="struttrep_progetti">
                                                            <option  selected value="">-- Seleziona un'opzione --</option>
                                                            @foreach($progetti as $p)
                                                                <option value="{{ $p->id }}" nome="{{ $p->progetto }}"> {{ $p->progetto }} </option>
                                                            @endforeach
                                                        </select>                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="row clearfix">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="struttrep_strutture">Struttura</label>
                                                        <!--<select class="form-control show-tick" id="struttrep_strutture">  
                                                            <option  selected value="">-- Seleziona un progetto --</option>
                                                          
                                                        </select>-->
                                                        <input class="form-control" value="" id_value="" type="text" id="struttrep_strutture" style="text-transform:uppercase;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="row clearfix">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="struttrep_reparti">Partizione</label>
                                                        <input class="form-control" value="" id_value="" type="text" id="struttrep_reparti" style="text-transform:uppercase;">
                                                        <!--<select class="form-control show-tick" id="struttrep_reparti">
                                                            <option  selected value="">-- Seleziona un progetto --</option>
                                                        </select>-->                                               
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="row clearfix">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="struttrep_area_partizione">Area partizione</label>
                                                        <input type="text" class="form-control" name="struttrep_area_partizione" id="struttrep_area_partizione" placeholder="">                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="row clearfix pl-2">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="struttrep_codice_area">Codice area partizione</label>
                                                        <input type="text" class="form-control" name="struttrep_codice_area" id="struttrep_codice_area" style="text-transform: uppercase;" placeholder="">                                             
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix mr-1">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-right" style="margin-top:30px;">
                                            <input type="button" name="aggiungi_struttrep" id="aggiungi_struttrep" class="btn btn-primary btn-lg waves-effect" value="Assegna">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                <div class="row clearfix">
                                    <div id="contenitore_struttrep" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <h3 id="titolo_struttrep_inseriti" class="align-justify">Progetto - Struttura - Partizione</h3>
                                            <select class="form-control ms" multiple="multiple" size="24" name="text_area_struttrep" id="text_area_struttrep">
                                                @foreach($struttrep as $sr)
                                                    <option value="{{ $sr->id }}" progetto="{{ $sr->progetto }}" id_progetto={{ $sr->id_progetto }} struttura="{{ $sr->struttura }}" id_struttura={{ $sr->id_struttura }} reparto="{{ $sr->reparto }}" id_reparto="{{ $sr->id_reparto }}" id_associazione="{{ $sr->id_associazione }}"> {{ 'Progetto: "'.$sr->progetto.'" Struttura: "'.$sr->struttura.'" Partizione: "'.$sr->reparto }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0 align-right">
                                        <input type="button" id="cancella_struttrep_button" class="btn btn-danger waves-effect" value="Cancella" data-toggle="modal" data-target="#deleteModal" disabled>
                                        <input type="button" name="modifica_struttrep" id="modifica_struttrep" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#ModalStruttRep"  value="Modifica" disabled>    
                                    </div>
                                </div>
                                <!--modal-->
                                <div class="modal fade in" id="ModalStruttRep" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="ModalStruttRepLabel">Modifica assegnamento struttura partizione</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form_advanced_validation" method="POST" novalidate="novalidate">
                                                    <div class="form-group form-float">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="row clearfix">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label for="struttrep_progetti_modal">Progetto</label>
                                                                            <select class="form-control show-tick" id="struttrep_progetti_modal">
                                                                                <option  selected value="">-- Seleziona un'opzione --</option>
                                                                                @foreach($progetti as $p)
                                                                                    <option value="{{ $p->id }}" nome="{{ $p->progetto }}"> {{ $p->progetto }} </option>
                                                                                @endforeach
                                                                            </select>                                                    
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <div class="row clearfix">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label for="struttrep_strutture_modal">Struttura</label>
                                                                            <input class="form-control" value="" id_value="" type="text" id="struttrep_strutture_modal" style="text-transform:uppercase;">                                             
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <div class="row clearfix pl-2">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label for="struttrep_reparti_modal">Partizione</label>
                                                                            <input class="form-control" value="" id_value="" type="text" id="struttrep_reparti_modal" style="text-transform:uppercase;">                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <div class="row clearfix">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label for="struttrep_area_partizione_modal">Area Partizione</label>
                                                                            <input type="text" class="form-control" name="struttrep_area_partizione_modal" id="struttrep_area_partizione_modal" placeholder="">                                             
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <div class="row clearfix pl-2">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label for="struttrep_codice_area_modal">Codice area partizione</label>
                                                                            <input type="text" class="form-control" name="struttrep_codice_area_modal" id="struttrep_codice_area_modal" style="text-transform: uppercase;" placeholder="">                                             
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                                                <div class="row clearfix pl-2">
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <label for="motivo_struttrep_modal">Motivo</label>
                                                                            <input type="text" id="motivo_struttrep_modal" class="form-control" name="minmaxlength" required="" aria-required="true" value="">                                                          
                                                                        </div>
                                                                        <div class="help-info">Motivo della modifica</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                       
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="modifica_struttrep_salva" name="modifica_struttrep_salva" class="btn btn-link waves-effect" tipo="" >SALVA</button>
                                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end modal-->
                            </div>
                        </div>
                    </div>
                    <!-- FINE gestione StruttureReparti -->
                    <hr>
                    <!-- Gestione MicroPiastra -->
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="mb-3">Assegnamento Piastra - Microrganismo</h3>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <div class="row clearfix ml-0">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="piastra_micropiastra">Piastra</label>
                                                        <select class="form-control show-tick" id="piastra_micropiastra">
                                                            <option  selected value="">-- Seleziona un'opzione --</option>
                                                            @foreach($tipopiastra as $p)
                                                                <option value="{{ $p->id }}" nome_piastra="{{ $p->piastra }}"> {{ $p->piastra}} </option>
                                                            @endforeach
                                                        </select>                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-3">
                                            <div class="row clearfix mr-0">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="microrganismo_micropiastra">Microrganismo</label>
                                                        <select class="form-control show-tick" id="microrganismo_micropiastra">
                                                            <option  selected value="">-- Seleziona un'opzione --</option>
                                                            @foreach($microrganismi as $m)
                                                                <option value="{{ $m->id }}" nome_microrganismo="{{ $m->microrganismo }}"> {{ $m->microrganismo}} </option>
                                                            @endforeach
                                                        </select>                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix mr-1">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-right">
                                            <input type="button" name="aggiungi_micropiastra" id="aggiungi_micropiastra" class="btn btn-primary btn-lg waves-effect" value="Assegna">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="row clearfix">
                                    <div id="contenitore_micropiastra" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <h3 id="titolo_micropiastra_inseriti" class="align-justify">Piastra - Microrganismo</h3>
                                            <select class="form-control ms" multiple="multiple" size="24" name="text_area_micropiastra" id="text_area_micropiastra">
                                                @foreach($microPiastra as $mp)
                                                    <option value="{{ $mp->id }}" nome_microrganismo="{{ $mp->nome_microrganismo }}"  nome_piastra="{{ $mp->nome_piastra }}" id_microrganismo="{{ $mp->id_microrganismo }}" id_piastra="{{ $mp->id_piastra }}"> {{ $mp->nome_piastra  . " - " . $mp->nome_microrganismo }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0 align-right">
                                        <input type="button" id="cancella_micropiastra_button" class="btn btn-danger waves-effect" value="Cancella" data-toggle="modal" data-target="#deleteModal" disabled>
                                        <input type="button" name="modifica_micropiastra" id="modifica_micropiastra" class="btn bg-blue btn waves-effect" data-toggle="modal" data-target="#ModalMicropiastra"  value="Modifica" disabled>    
                                    </div>
                                </div>
                                <!--modal-->
                                <div class="modal fade in" id="ModalMicropiastra" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="ModalMicropiastraLabel">Modifica assegnamento microrganismo piastra</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form_advanced_validation" method="POST" novalidate="novalidate">
                                                    <div class="form-group form-float">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                                                <div class="row clearfix ml-0">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label for="piastra_micropiastra_modal">Piastra</label>
                                                                            <select class="form-control show-tick" id="piastra_micropiastra_modal">
                                                                                <option  selected value="">-- Seleziona un'opzione --</option>
                                                                                @foreach($tipopiastra as $p)
                                                                                    <option value="{{ $p->id }}" nome_piastra="{{ $p->piastra }}"> {{ $p->piastra}} </option>
                                                                                @endforeach
                                                                            </select>                                                    
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-2">
                                                                <div class="row clearfix mr-0">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label for="microrganismo_micropiastra_modal">Microrganismo</label>
                                                                            <select class="form-control show-tick" id="microrganismo_micropiastra_modal">
                                                                                <option  selected value="">-- Seleziona un'opzione --</option>
                                                                                @foreach($microrganismi as $m)
                                                                                    <option value="{{ $m->id }}" nome_microrganismo="{{ $m->microrganismo }}"> {{ $m->microrganismo}} </option>
                                                                                @endforeach
                                                                            </select>                                                    
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                                                                <div class="row clearfix pl-2">
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <label for="motivo_micropiastra_modal">Motivo</label>
                                                                            <input type="text" id="motivo_micropiastra_modal" class="form-control" name="minmaxlength" required="" aria-required="true" value="">                                                          
                                                                        </div>
                                                                        <div class="help-info">Motivo della modifica</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                       
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="modifica_micropiastra_salva" name="modifica_micropiastra_salva" class="btn btn-link waves-effect" tipo="" >SALVA</button>
                                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end modal-->
                            </div>
                        </div>
                    </div>
                    <!-- FINE gestione MicroPiastra -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--modal-->
<div class="modal fade in" id="deleteModal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="deleteModalLabel"></h4>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                        <label for="" id="deleteModalLabel">Motivo: </label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                        <div class="form-group">
                            <div class="form-line focused">
                                <input type="text" class="form-control" id="cancel_motivo_annullamento" name="cancel_motivo_annullamento">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="cancella_elemento" id="cancella_elemento" class="btn btn-link waves-effect elimina_modal">CONFERMA</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CHIUDI</button>
            </div>
        </div>
    </div>
</div>
<!--end modal--> 
@endsection

@section('script')
<script src="{{ asset('js/pages/ui/dialogs.js') }}"></script>
<script src="{{ asset('js/gestione_interna/gestioneinterna.js') }}"></script>
@endsection