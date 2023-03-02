<!--pagina 5 -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-striped table-hover dataTable js-exportable campionamenti_table" role="grid" aria-describedby="DataTables_Table_1_info" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th colspan="1">PLANIMETRIA</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type="file" id="carica_planimetria" accept="image/*" name="planimetria[]" multiple>    
                        {{-- <img id="preview_image" src="#" alt="your image" />  --}}
                        <div id="appendIMG">
                        </div>
                    </td>
                </tr>
                <tr>
                    <div id="to_clone" class="hidden">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label id="label_caption_0" for="caption">Descrizione della foto</label>
                                <input id="input_caption_0" type="text" name="caption" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    <div class="to_append">

                    </div>
                </tr>
                @if(isset($rdp_anteprima))
                    @if(count(App\PlanimetriaRdpAnteprima::where('id_rdp',$id_rapprel)->where('id_rdp_anteprima',$rdp_anteprima->id)->get()) > 0)
                    <tr>
                        <td>
                            <h3>Di seguito le foto già inserite</h3>
                        </td>
                    </tr>
                    @endif
                    @foreach(App\PlanimetriaRdpAnteprima::where('id_rdp',$id_rapprel)->where('id_rdp_anteprima',$rdp_anteprima->id)->get() as $p)
                        
                        <tr id="planimetria_{{ $p->id }}">
                            <td>
                                <img src="{{ route('planimetria_anteprima', [$p->id_rdp, getPlanimetriaName($p->planimetria)]) }}" alt="" width="1000" height="500">
                            </td>
                        </tr>
                        <tr id="caption_planimetria_{{ $p->id }}">
                            <td>
                                <input type="text" class="form-control" name="caption_planimetria_salvata_{{ $p->id }}" value="{{ $p->caption }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <!-- delete button -->
                                <button type="button" id="elimina_foto_{{ $p->id }}" id_planimetria="{{ $p->id }}" class="btn btn-link btn-danger waves-effect elimina_foto" tipo="" >Elimina</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>


