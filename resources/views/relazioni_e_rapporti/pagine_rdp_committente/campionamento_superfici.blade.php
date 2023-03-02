<!--pagina 8 -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-striped table-hover dataTable js-exportable campionamenti_table" role="grid" aria-describedby="DataTables_Table_1_info"cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="tabellaGridPage6" colspan="1" style="background-color: rgb(189, 183, 183); text-align:left;">
                        <b>DESCRIZIONE CAMPIONAMENTO SUPERFICI</b>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="tabellaGridPage6">
                    <td class="col1_page6 tabellaGridPage6">
                        Matrice: Supporti da campionamento superfici di camere bianche ed ambienti controllati associati
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@php $all_campioni_sup = get_campioni_given_tipoCampionamento_tipoCampione($campioni, 'S') @endphp
@php $tipi_piastre_superficie = [];  @endphp
@php $lineeguida_superficie = [];  @endphp
@php $tipo_di_campione = []; @endphp



@foreach($all_campioni_sup as $tipo_campione => $c_sup)
   
    @foreach($c_sup as $piastra => $camp)
       
        @if(count($camp) > 0)
            @php $tipi_piastre_superficie[$piastra == 'pca' ? 26 : 27] = $piastra  @endphp
            @php array_push($tipo_di_campione,$tipo_campione) @endphp
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                        <table class="table table-bordered table-striped table-hover campionamenti_table" role="grid" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="" colspan="6">
                                        <b>Data e ora inizio incubazione:<!--var --> </b><input class="form-control" type="text" style="width:20%"  name="dataOraInizioIncubazioneSuperficie_{{ $piastra }}" value="{{ Carbon\Carbon::parse($camp[0]->dataAnalisi)->format('d/m/Y') ." - h. ".Carbon\Carbon::parse($camp[0]->oraInizioAnalisi)->format('H:i')  }}"><br>
                                        <b>Data e ora fine incubazione:<!--var --> </b><input class="form-control" type="text" style="width:20%"  name="dataOraFineIncubazioneSuperficie_{{ $piastra }}" value="{{ $camp[0]->dataFineAnalisi->format('d/m/Y') ." - h. ".Carbon\Carbon::parse($camp[0]->oraFineAnalisi)->format('H:i') }}">
                                    </th>
                                </tr>
                                <tr>
                                    <th class="" colspan="6">
                                        <b>Metodo:</b> <input class="form-control" type="text" style="width:50%"  name="metodo_superficie_{{ $piastra }}" value="{{ getMetodo($camp) }}"><br>
                                        <b>Denominazione della prova:</b> <input class="form-control" type="text" style="width:50%" name="descrizione_metodo_superficie_{{ $piastra }}" value="{{ getDescrizioneMetodo($camp) }}"><br>
                                        <b>Tecnico incaricato dell'analisi:</b><input class="form-control" style="width: 50%" type="text" name="tecnico_superficie_{{ $piastra }}" value="{{ get_tecnico_analisi_campione($camp) }}">
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <b>Campione N.</b>
                                    </th>
                                    <th>
                                        <b>Codice campione</b>
                                    </th>
                                    <th>
                                        <b>Punto di campionamento</b>
                                    </th>
                                    <th>
                                        @if($tipo_campione == 'piastra')
                                            <b>CFU/Piastra;</b>
                                        @else
                                            <b>CFU/100cm &#178;</b>
                                        @endif
                                    </th>
                                    <th>
                                        <b>U(¹)</b>
                                    </th>
                                    <th>
                                        @if($tipo_campione == 'piastra')
                                            <b>Valori di riferimento CFU/Piastra</b>
                                        @else
                                            <b>Valori di riferimento CFU/100cm &#178;</b>
                                        @endif
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($rdp_anteprima_descrizione) && $anteprima == 1)
                                    @php $rdp_anteprima_descrizione_superficie = $rdp_anteprima_descrizione->where($piastra,1)->where('superficie',1) @endphp
                                @endif
                                @foreach ($camp as $c)
                                    @php $punto_camp = get_punto_camp($c) @endphp
                                    @php $cfu = get_cfu_micro_piastra($c) @endphp
                                    @php $lg = get_linea_guida_piastra($c) @endphp
                                    @php $lineeguida_superficie[$piastra == 'pca' ? 26 : 27] = $lg  @endphp
                                    <tr style="width:auto">
                                        <td>
                                            <input style="width: 100px" class="form-control" type="text" name="id_campione_superficie_{{ $c->id }}" value="{{ $c->id }}">
                                        </td>
                                        <td>
                                            <input style="width: 300px" class="form-control" type="text" name="codice_cias_superficie_{{ $c->id }}" value="{{ $c->codiceCIAS }}">
                                        </td>
                                        <td>
                                            <input style="width: 300px" class="form-control" type="text" name="punto_camp_superficie_{{ $c->id }}" value="{{ $punto_camp }}">
                                        </td>
                                        <td>
                                            <input style="width: 100px" class="form-control" type="text" name="CFU_superficie_{{ $c->id }}" value="{{ $cfu != 0 ? $cfu : '< 1' }}">
                                        </td>
                                        <td>
                                            <input style="width: 100px" class="form-control" type="text" name="U_superficie_{{ $c->id }}" value="{{ getIncertezza($c) }}">
                                        </td>
                                        @if(isset($rdp_anteprima_descrizione_superficie))
                                            <td>
                                                <input style="width: 100px" class="form-control" type="text" name="valori_riferimento_superficie_{{ $c->id }}" value="{{ $rdp_anteprima_descrizione_superficie->where('id_campione',$c->id)->first() != null ? $rdp_anteprima_descrizione_superficie->where('id_campione',$c->id)->first()->valori_riferimento : '200' }}">
                                            </td>
                                        @else
                                            <td>
                                                <input style="width: 100px" class="form-control" type="text" name="valori_riferimento_superficie_{{ $c->id }}" value="200">
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                <tr class="hidden">
                                    <td class="hidden">
                                        <input class="hidden" name="tipi_piastre_superficie"  value="{{ serialize($tipi_piastre_superficie) }}">
                                    </td>
                                    <td class="hidden">
                                        <input class="hidden" name="tipo_di_campione_superficie"  value="{{ serialize($tipo_di_campione) }}">
                                    </td>
                                    <td class="hidden">
                                        <input class="hidden" name="lineeGuida_superficie" value="{{ serialize($lineeguida_superficie) }}">
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot >
                                <tr>
                                    <th colspan="6"> I valori di riferimento sono tratti dalle Linee Guida {{ $lg }}</th>
                                    <td class="hidden"> </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endforeach

