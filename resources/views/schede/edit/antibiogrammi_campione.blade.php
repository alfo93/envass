<hr>
<div id="deletable_{{ $occorrenza }}" class="row-clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 pl-0">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 mb-0">
                <p type="text" id="NAB_{{ $occorrenza }}" class="font-bold" name="NAB" nab_value="{{ App\MicroAntibiogramma::where('NAB','!=',0)->where('id_campione',$campione->id)->take($occorrenza)->skip($occorrenza-1)->first()['NAB'] }}" maxlength="255">{{ (App\MicroAntibiogramma::where('NAB','!=',0)->where('id_campione',$campione->id)->take($occorrenza)->skip($occorrenza-1)->first() != null) ? 'Codice piastra: '.App\MicroAntibiogramma::where('NAB','!=',0)->where('id_campione',$campione->id)->take($occorrenza)->skip($occorrenza-1)->first()['NAB'] : '' }}</p>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 pl-0">
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row clearfix pl-1-2">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <h4 class="align-justify">Antibiotico resistenza</h4>
                                            <select class="form-control ms" multiple="multiple" size="10" name="text_area_antibiotico_resistenza" id="text_area_antibiotico_resistenza_{{ $occorrenza }}" style="background-color: #f0f8ff">    
                                                @php $ar = get_antibio_res($campione->id ?? -1,App\MicroAntibiogramma::where('NAB','!=',0)->where('id_campione',$campione->id)->take($occorrenza)->skip($occorrenza-1)->first()['NAB']) @endphp
                                                @if($ar != null)
                                                    @foreach ($ar as $value)
                                                        <option value="{{ $value['id_ar'] }}" id_antibiotico="{{ $value['id_antibiotico'] }}" key_resistenza="{{ $value['key_resistenza'] }}" deletable="{{ $value['deletable'] }}">{{ $value['nome_antibiotico'] ." ". $value['resistenza'] }}</option>   
                                                    @endforeach
                                                @else
                                                    <option value="">Non sono presenti antibiotici con le relative resistenze</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-clearfix mb-2">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-left">
                                <p name="colonia" colonia_value="{{ App\MicroAntibiogramma::where('NAB','!=',0)->where('id_campione',$campione->id)->take($occorrenza)->skip($occorrenza-1)->first()['colonia'] }}" type="text" id="colonia_{{ $occorrenza }}" class="font-bold" >{{ App\MicroAntibiogramma::where('NAB','!=',0)->where('id_campione',$campione->id)->take($occorrenza)->skip($occorrenza-1)->first()['colonia'] == 1 ? 'Presenza di colonie satelliti: SI' : 'Presenza di colonie satelliti: NO' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-1-2 ml-1 align-left">
                    <input type="button" id="cancella_antibiogramma_{{ $occorrenza }}" class="btn btn-danger waves-effect" value="Cancella antibiogramma" {{ isset($campione) && $campione->bloccato == 1 ? 'disabled' : '' }} >
                </div>
            </div> 
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="row clearfix drop-file p-t-10">
                <div id="image_dropzone_{{ $occorrenza }}" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <a href="#0" data-sub-html="Demo Description">
                            <img id="img_piastra_{{ $occorrenza }}" data-toggle="modal" data-target="#largeModal" alt="Immagine antibiogramma" class="img-responsive thumbnail" tipo="antibiogramma{{$occorrenza}}" nome_file="{{ getImageMicroAntibio($campione->id,"antibiogramma$occorrenza") }}" src="{{route('immaginiantibiogramma',[getImageMicroAntibio($campione->id,"antibiogramma$occorrenza"),$campione->id])}}">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>