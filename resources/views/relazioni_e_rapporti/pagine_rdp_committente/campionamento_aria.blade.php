<!--pagina 7 -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div style="text-align:center;">
            <div>
                <h3>Schede di rilevazione e registrazione</h3><br>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-striped table-hover dataTable js-exportable campionamenti_table" role="grid" aria-describedby="DataTables_Table_1_info"cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="tabellaGridPage6" colspan="1" style="background-color: rgb(189, 183, 183); text-align:left;">
                        <b>DESCRIZIONE CAMPIONAMENTO ARIA</b>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="tabellaGridPage6">
                    <td class="col1_page6 tabellaGridPage6">
                        Matrice: Supporti da campionamento aria di camere bianche ed ambienti controllati associati
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@php $tipi_di_campioni = ['_pca_at_rest_attivo' => 0,'_pca_at_rest_passivo' => 0, '_pca_operat_attivo' => 0, '_pca_operat_passivo' => 0, '_dg18_at_rest_attivo' => 0, '_dg18_at_rest_passivo' => 0] @endphp
<!-- ARIA PCA AT_REST ATTIVO  -->
@if(count($campioni_aria_pca_at_rest_attivo) > 0)

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
            <table class="table table-bordered table-striped table-hover campionamenti_table" role="grid" style="width:100%">
                    <thead>
                        <tr>
                            <th class="" colspan="6">
                                <b>Data e ora inizio incubazione:
                                    <!--var --> </b><input class="form-control" type="text" style="width:20%; background-color: rgb(213, 208, 208);" name="dataOraInizioIncubazioneAria_pca_at_rest_attivo" value="{{ Carbon\Carbon::parse($campioni_aria_pca_at_rest_attivo->first()->dataAnalisi)->format('d/m/Y') ." - h. ".Carbon\Carbon::parse($campioni_aria_pca_at_rest_attivo->first()->oraInizioAnalisi)->format('H:i')  }}"><br>
                                <b>Data e ora fine incubazione:
                                    <!--var --> </b><input class="form-control" type="text" style="width:20%; background-color: rgb(213, 208, 208);" name="dataOraFineIncubazioneAria_pca_at_rest_attivo" value="{{ Carbon\Carbon::parse($campioni_aria_pca_at_rest_attivo->first()->dataFineAnalisi)->format('d/m/Y') ." - h. ".Carbon\Carbon::parse($campioni_aria_pca_at_rest_attivo->first()->oraFineAnalisi)->format('H:i') }}">
                            </th>
                        </tr>
                        <tr>
                            <th class="" colspan="6">
                                <b>Metodo:</b> <input class="form-control" type="text" style="width:50%" name="metodo_aria_pca_at_rest_attivo" value="{{ getMetodo($campioni_aria_pca_at_rest_attivo) }}"><br>
                                <b>Denominazione della prova:</b> <input class="form-control" type="text" style="width:50%" name="descrizione_metodo_aria_pca_at_rest_attivo" value="{{ getDescrizioneMetodo($campioni_aria_pca_at_rest_attivo) }}"><br>
                                <b>Tecnico incaricato dell'analisi:</b><input class="form-control" style="width: 50%" type="text" name="tecnico_aria_pca_at_rest_attivo" value="{{ get_tecnico_analisi_campione($campioni_aria_pca_at_rest_attivo) }}">
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
                                <b> CFU/m &#179;</b>
                            </th>
                            <th>
                                <b>U(¹)</b>
                            </th>
                            <th>
                                <b>Valori di riferimento CFU/m &#179;</b>
                            </th>
                        </tr>
                    </thead>
                    @if(isset($rdp_anteprima_descrizione) && $anteprima == 1)
                            @php $rdp_anteprima_descrizione_pca_at_rest_attivo = $rdp_anteprima_descrizione->where('pca',1)->where('at_rest',1)->where('attivo',1) @endphp
                    @endif
                    @foreach($campioni_aria_pca_at_rest_attivo as $c)  
                        @php $lg = get_linea_guida_piastra($c) @endphp
                        @php $tipi_di_campioni['_pca_at_rest_attivo'] = 1 @endphp
                        @php $lineeguida_aria[$c->id_tipo_piastra] = $lg @endphp                     
                        @php $punto_camp = get_punto_camp($c) @endphp
                        @php $cfu = get_cfu_micro_piastra($c) @endphp
                        <tbody>
                            <tr style="width:auto">
                                <td>
                                    <input class="form-control" style="width: 100px background-color: rgb(213, 208, 208); background-color: transparent:disabled" type="text" name="id_campione_aria_{{ $c->id }}" value="{{ $c->id }}">
                                </td>
                                <td>
                                    <input class="form-control" style="width: 300px background-color: rgb(213, 208, 208);" type="text" name="codice_cias_aria_{{ $c->id }}" value="{{ $c->codiceCIAS }}">
                                </td>
                                <td>
                                    <input class="form-control" style="width: 300px background-color: rgb(213, 208, 208);" type="text" name="punto_camp_aria_{{ $c->id }}" value="{{ $punto_camp }}">
                                </td>
                                <td>
                                    <input class="form-control" style="width: 100px background-color: rgb(213, 208, 208);" type="text" name="CFU_aria_{{ $c->id }}" value="{{ $cfu != 0 ? $cfu : '< 1' }}">
                                </td>
                                <td>
                                    <input class="form-control" style="width: 100px background-color: rgb(213, 208, 208);" type="text" name="U_aria_{{ $c->id }}" value="{{ getIncertezza($c) }}">
                                </td>
                                @if(isset($rdp_anteprima_descrizione_pca_at_rest_attivo))
                                    <td>
                                        <input class="form-control" style="width: 100px background-color: rgb(213, 208, 208);" type="text" name="valori_riferimento_aria_{{ $c->id }}" value="{{ $rdp_anteprima_descrizione_pca_at_rest_attivo->where('id_campione',$c->id)->first() != null ? $rdp_anteprima_descrizione_pca_at_rest_attivo->where('id_campione',$c->id)->first()->valori_riferimento : '200' }}">
                                    </td>
                                @else
                                    <td>
                                        <input class="form-control" style="width: 100px background-color: rgb(213, 208, 208);" type="text" name="valori_riferimento_aria_{{ $c->id }}" value="200">
                                    </td>
                                @endif
                            </tr>
                        </tbody>
                    @endforeach
                    <tr class="hidden">
                        <td class="hidden">
                            <input class="hidden" name="campioni_aria_pca_at_rest_attivo" value="{{ serialize($campioni_aria_pca_at_rest_attivo->toArray()) }}">
                        </td>
                        <td class="hidden">
                            <input class="hidden" name="lineeGuida_aria" value="{{ serialize($lineeguida_aria) }}">
                        </td>
                    </tr>
                    <tfoot>
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

<!-- ARIA PCA AT_REST PASSIVO  -->
@if(count($campioni_aria_pca_at_rest_passivo) > 0)
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
            <table class="table table-bordered table-striped table-hover campionamenti_table" role="grid" style="width:100%">
                    <thead>
                        <tr>
                            <th class="" colspan="6">
                                <b>Data e ora inizio incubazione:
                                    <!--var --> </b><input type="text" class="form-control" style="width:20%" name="dataOraInizioIncubazioneAria_pca_at_rest_passivo" value="{{ $campioni_aria_pca_at_rest_passivo != null ? Carbon\Carbon::parse($campioni_aria_pca_at_rest_passivo->first()->dataAnalisi)->format('d/m/Y') ." - h. ".Carbon\Carbon::parse($campioni_aria_pca_at_rest_passivo->first()->oraInizioAnalisi)->format('H:i') : null }}"><br>
                                <b>Data e ora fine incubazione:
                                    <!--var --> </b><input type="text" class="form-control" style="width:20%" name="dataOraFineIncubazioneAria_pca_at_rest_passivo" value="{{ $campioni_aria_pca_at_rest_passivo != null ? Carbon\Carbon::parse($campioni_aria_pca_at_rest_passivo->first()->dataFineAnalisi)->format('d/m/Y') ." - h. ".Carbon\Carbon::parse($campioni_aria_pca_at_rest_passivo->first()->oraFineAnalisi)->format('H:i') : null }}">
                            </th>
                        </tr>
                        <tr>
                            <th class="" colspan="6">
                                <b>Metodo:</b> <input type="text" class="form-control" style="width:50%" name="metodo_aria_pca_at_rest_passivo" value="{{ getMetodo($campioni_aria_pca_at_rest_passivo) }}"><br>
                                <b>Denominazione della prova:</b> <input type="text" class="form-control" style="width:50%" name="descrizione_metodo_aria_pca_at_rest_passivo" value="{{ getDescrizioneMetodo($campioni_aria_pca_at_rest_passivo) }}"><br>
                                <b>Tecnico incaricato dell'analisi:</b><input type="text" style="width: 50%" class="form-control" name="tecnico_aria_pca_at_rest_passivo" value="{{ get_tecnico_analisi_campione($campioni_aria_pca_at_rest_passivo) }}">
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
                                {{-- <select class="form-control show-tick" id="pca_at_rest_passivo_u_misura" name="pca_at_rest_passivo_u_misura">
                                    <option value="">-- Seleziona un opzione --</option>
                                    <option value="CFU/4h">CFU/4H</option>
                                    <option value="CFU/piastra">CFU/piastra</option></select>
                                </select> --}}
                                <b>CFU/m &#179;</b>
                            </th>
                            <th>
                                <b>U(¹)</b>
                            </th>
                            <th>
                                <b>Valori di riferimento CFU/m &#179;</b>
                            </th>
                        </tr>
                    </thead>
                    @if(isset($rdp_anteprima_descrizione) && $anteprima == 1)
                        @php $rdp_anteprima_descrizione_pca_at_rest_passivo = $rdp_anteprima_descrizione->where('pca',1)->where('at_rest',1)->where('passivo',1) @endphp
                    @endif
                    @foreach($campioni_aria_pca_at_rest_passivo as $c)  
                        @php $lg = get_linea_guida_piastra($c) @endphp
                        @php $tipi_di_campioni['_pca_at_rest_passivo'] = 1 @endphp
                        @php $lineeguida_aria[$c->id_tipo_piastra] = $lg @endphp                     
                        @php $punto_camp = get_punto_camp($c) @endphp
                        @php $cfu = get_cfu_micro_piastra($c) @endphp
                        <tbody>
                            <tr style="width:auto">
                                <td>
                                    <input class="form-control" style="width: 100px" type="text" name="id_campione_aria_{{ $c->id }}" value="{{ $c->id }}">
                                </td>
                                <td>
                                    <input class="form-control" style="width: 300px" type="text" name="codice_cias_aria_{{ $c->id }}" value="{{ $c->codiceCIAS }}">
                                </td>
                                <td>
                                    <input class="form-control" style="width: 300px" type="text" name="punto_camp_aria_{{ $c->id }}" value="{{ $punto_camp }}">
                                </td>
                                <td>
                                    <input class="form-control" style="width: 100px" type="text" name="CFU_aria_{{ $c->id }}" value="{{ $cfu != 0 ? $cfu : '< 1' }}">
                                </td>
                                <td>
                                    <input class="form-control" style="width: 100px" type="text" name="U_aria_{{ $c->id }}" value="{{ getIncertezza($c) }}">
                                </td>
                                @if(isset($rdp_anteprima_descrizione_pca_at_rest_passivo))
                                    <td>
                                        <input class="form-control" style="width: 100px" type="text" name="valori_riferimento_aria_{{ $c->id }}" value="{{ $rdp_anteprima_descrizione_pca_at_rest_passivo->where('id_campione',$c->id)->first() != null  ? $rdp_anteprima_descrizione_pca_at_rest_passivo->where('id_campione',$c->id)->first()->valori_riferimento : '200' }}">
                                    </td>
                                @else
                                    <td>
                                        <input class="form-control" style="width: 100px" type="text" name="valori_riferimento_aria_{{ $c->id }}" value="200">
                                    </td>
                                @endif
                            </tr>
                        </tbody>
                    @endforeach
                    <tr class="hidden">
                        <td class="hidden">
                            <input class="hidden" name="campioni_aria_pca_at_rest_passivo" value="{{ serialize($campioni_aria_pca_at_rest_passivo->toArray()) }}">
                        </td>
                        <td class="hidden">
                            <input class="hidden" name="lineeGuida_aria" value="{{ serialize($lineeguida_aria) }}">
                        </td>
                    </tr>
                    <tfoot>
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

<!-- ARIA PCA OPERAT ATTIVO  -->
@if(count($pca_attivo_stanze) > 0)
    @foreach ($pca_attivo_stanze as $stanze => $camp)
        @if(count($camp) > 0)
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                    <table class="table table-bordered table-striped table-hover campionamenti_table" role="grid" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="" colspan="6">
                                        <b>Data e ora inizio incubazione:
                                            <!--var --> </b><input type="text" class="form-control" style="width:20%" name="dataOraInizioIncubazioneAria_pca_operat_attivo" value="{{ Carbon\Carbon::parse($camp[0]['dataAnalisi'])->format('d/m/Y') ." - h. ".Carbon\Carbon::parse($camp[0]['oraInizioAnalisi'])->format('H:i')  }}"><br>
                                        <b>Data e ora fine incubazione:
                                            <!--var --> </b><input type="text" class="form-control" style="width:20%" name="dataOraFineIncubazioneAria_pca_operat_attivo" value="{{ Carbon\Carbon::parse($camp[0]['dataFineAnalisi'])->format('d/m/Y') ." - h. ".Carbon\Carbon::parse($camp[0]['oraFineAnalisi'])->format('H:i') }}">
                                    </th>
                                </tr>
                                <tr>
                                    <th class="" colspan="6">
                                        <b>Metodo:</b> <input type="text" class="form-control" style="width:50%" name="metodo_aria_pca_operat_attivo" value="{{ getMetodo($camp) }}"><br>
                                        <b>Denominazione della prova:</b> <input type="text" class="form-control" style="width:50%" name="descrizione_metodo_aria_pca_operat_attivo" value="{{ getDescrizioneMetodo($camp) }}"><br>
                                        <b>Tecnico incaricato dell'analisi:</b><input type="text" style="width: 50%" class="form-control" name="tecnico_aria_pca_operat_attivo" value="{{ get_tecnico_analisi_campione($camp) }}">
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
                                        <b>CFU/m &#179;</b>
                                    </th>
                                    <th>
                                        <b>U(¹)</b>
                                    </th>
                                    <th>
                                        <b>Valori di riferimento CFU/m &#179;</b>
                                    </th>
                                </tr>
                            </thead>
                            @if(isset($rdp_anteprima_descrizione) && $anteprima == 1)
                                @php $rdp_anteprima_descrizione_pca_attivo_stanze = $rdp_anteprima_descrizione->where('pca',1)->where('operat',1)->where('attivo',1)->where('stanza',$stanze) @endphp
                            @endif
                            @foreach($camp as $c)  
                                @php $lg = get_linea_guida_piastra($c) @endphp
                                @php $tipi_di_campioni['_pca_operat_attivo'] = 1 @endphp
                                @php $lineeguida_aria[$c['id_tipo_piastra']] = $lg @endphp                     
                                @php $punto_camp = get_punto_camp($c) @endphp
                                @php $cfu = get_cfu_micro_piastra($c) @endphp
                                <tbody>
                                    <tr style="width:auto">
                                        <td>
                                            <input class="form-control" style="width: 100px" type="text" name="id_campione_aria_{{ $c['id'] }}" value="{{ $c['id'] }}">
                                        </td>
                                        <td>
                                            <input class="form-control" style="width: 300px" type="text" name="codice_cias_aria_{{ $c['id'] }}" value="{{ $c['codiceCIAS'] }}">
                                        </td>
                                        <td>
                                            <input class="form-control" style="width: 300px" type="text" name="punto_camp_aria_{{ $c['id'] }}" value="{{ $punto_camp }}">
                                        </td>
                                        <td>
                                            <input class="form-control" style="width: 100px" type="text" name="CFU_aria_{{ $c['id'] }}" value="{{ $cfu != 0 ? $cfu : '< 1' }}">
                                        </td>
                                        <td>
                                            <input class="form-control" style="width: 100px" type="text" name="U_aria_{{ $c['id'] }}" value="{{ getIncertezza($c) }}">
                                        </td>
                                        @if(isset($rdp_anteprima_descrizione_pca_attivo_stanze))
                                            <td>
                                                <input class="form-control" style="width: 100px" type="text" name="valori_riferimento_aria_{{ $c['id'] }}" value="{{ $rdp_anteprima_descrizione_pca_attivo_stanze->where('id_campione',$c['id'])->first() != null ? $rdp_anteprima_descrizione_pca_attivo_stanze->where('id_campione',$c['id'])->first()->valori_riferimento : '200'  }}">
                                            </td>
                                        @else
                                            <td>
                                                <input class="form-control" style="width: 100px" type="text" name="valori_riferimento_aria_{{ $c['id']}}" value="200">
                                            </td>
                                        @endif
                                    </tr>
                                </tbody>
                            @endforeach
                            <tr class="hidden">
                                <td class="hidden">
                                    <input class="hidden" name="pca_attivo_stanze" value="{{ serialize($pca_attivo_stanze) }}">
                                </td>
                                <td class="hidden">
                                    <input class="hidden" name="lineeGuida_aria" value="{{ serialize($lineeguida_aria) }}">
                                </td>
                            </tr>
                            <tfoot>
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
@endif

<!-- ARIA PCA OPERAT PASSIVO  -->
@if(count($pca_passivo_stanze) > 0)
    @foreach ($pca_passivo_stanze as $stanze => $camp)
        @if(count($camp) > 0)
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                    <table class="table table-bordered table-striped table-hover campionamenti_table" role="grid" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="" colspan="6">
                                        <b>Data e ora inizio incubazione:
                                            <!--var --> </b><input type="text" class="form-control"  style="width:20%" name="dataOraInizioIncubazioneAria_pca_operat_passivo" value="{{ Carbon\Carbon::parse($camp[0]['dataAnalisi'])->format('d/m/Y') ." - h. ".Carbon\Carbon::parse($camp[0]['oraInizioAnalisi'])->format('H:i')  }}"><br>
                                        <b>Data e ora fine incubazione:
                                            <!--var --> </b><input type="text" class="form-control" style="width:20%" name="dataOraFineIncubazioneAria_pca_operat_passivo" value="{{ Carbon\Carbon::parse($camp[0]['dataFineAnalisi'])->format('d/m/Y') ." - h. ".Carbon\Carbon::parse($camp[0]['oraFineAnalisi'])->format('H:i') }}">
                                    </th>
                                </tr>
                                <tr>
                                    <th class="" colspan="6">
                                        <b>Metodo:</b> <input type="text" class="form-control"  style="width:50%" name="metodo_aria_pca_operat_passivo" value="{{ getMetodo($camp) }}"><br>
                                        <b>Denominazione della prova:</b> <input class="form-control" type="text" style="width:50%" name="descrizione_metodo_aria_pca_operat_passivo" value="{{ getDescrizioneMetodo($camp) }}"><br>
                                        <b>Tecnico incaricato dell'analisi:</b><input class="form-control" style="width: 50%" type="text" name="tecnico_aria_pca_operat_passivo" value="{{ get_tecnico_analisi_campione($camp) }}">
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
                                        <b>CFU/4h</b>
                                    </th>
                                    <th>
                                        <b>U(¹)</b>
                                    </th>
                                    <th>
                                        <b>Valori di riferimento CFU/4h</b>
                                    </th>
                                </tr>
                            </thead>
                            @if(isset($rdp_anteprima_descrizione) && $anteprima == 1)
                                @php $rdp_anteprima_descrizione_pca_passivo_stanze = $rdp_anteprima_descrizione->where('pca',1)->where('operat',1)->where('passivo',1)->where('stanza',$stanze) @endphp
                            @endif
                            @foreach($camp as $c)  
                                @php $lg = get_linea_guida_piastra($c) @endphp
                                @php $tipi_di_campioni['_pca_operat_passivo'] = 1 @endphp
                                @php $lineeguida_aria[$c['id_tipo_piastra']] = $lg @endphp                     
                                @php $punto_camp = get_punto_camp($c) @endphp
                                @php $cfu = get_cfu_micro_piastra($c) @endphp
                                <tbody>
                                    <tr style="width:auto">
                                        <td>
                                            <input class="form-control" style="width: 100px" type="text" name="id_campione_aria_{{ $c['id'] }}" value="{{ $c['id'] }}">
                                        </td>
                                        <td>
                                            <input class="form-control" style="width: 300px" type="text" name="codice_cias_aria_{{ $c['id'] }}" value="{{ $c['codiceCIAS'] }}">
                                        </td>
                                        <td>
                                            <input class="form-control" style="width: 300px" type="text" name="punto_camp_aria_{{ $c['id'] }}" value="{{ $punto_camp }}">
                                        </td>
                                        <td>
                                            <input class="form-control" style="width: 100px" type="text" name="CFU_aria_{{ $c['id'] }}" value="{{ $cfu != 0 ? $cfu : '< 1' }}">
                                        </td>
                                        <td>
                                            <input class="form-control" style="width: 100px" type="text" name="U_aria_{{ $c['id'] }}" value="{{ getIncertezza($c) }}">
                                        </td>
                                        @if(isset($rdp_anteprima_descrizione_pca_passivo_stanze))
                                            <td>
                                                <input class="form-control" style="width: 100px" type="text" name="valori_riferimento_aria_{{ $c['id'] }}" value="{{ $rdp_anteprima_descrizione_pca_passivo_stanze->where('id_campione',$c->id)->first() != null ? $rdp_anteprima_descrizione_pca_passivo_stanze->where('id_campione',$c->id)->first()->valori_riferimento : '200'  }}">
                                            </td>
                                        @else
                                            <td>
                                                <input class="form-control" style="width: 100px" type="text" name="valori_riferimento_aria_{{ $c->id }}" value="200">
                                            </td>
                                        @endif
                                    </tr>
                                </tbody>
                            @endforeach
                            <tr class="hidden">
                                <td class="hidden">
                                    <input class="hidden" name="pca_passivo_stanze" value="{{ serialize($pca_passivo_stanze) }}">
                                </td>
                                <td class="hidden">
                                    <input class="hidden" name="lineeGuida_aria" value="{{ serialize($lineeguida_aria) }}">
                                </td>
                            </tr>
                            <tfoot>
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
@endif

<!-- ARIA DG18 AT_REST ATTIVO  -->
@if(count($campioni_aria_dg18_at_rest_attivo) > 0)
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
            <table class="table table-bordered table-striped table-hover campionamenti_table" role="grid" style="width:100%">
                    <thead>
                        <tr>
                            <th class="" colspan="6">
                                <b>Data e ora inizio incubazione:
                                    <!--var --> </b><input type="text" class="form-control" style="width:20%" name="dataOraInizioIncubazioneAria_dg18_at_rest_attivo" value="{{ Carbon\Carbon::parse($campioni_aria_dg18_at_rest_attivo->first()->dataAnalisi)->format('d/m/Y') ." - h. ".Carbon\Carbon::parse($campioni_aria_dg18_at_rest_attivo->first()->oraInizioAnalisi)->format('H:i')  }}"><br>
                                <b>Data e ora fine incubazione:
                                    <!--var --> </b><input type="text" class="form-control" style="width:20%" name="dataOraFineIncubazioneAria_dg18_at_rest_attivo" value="{{ Carbon\Carbon::parse($campioni_aria_dg18_at_rest_attivo->first()->dataFineAnalisi)->format('d/m/Y') ." - h. ".Carbon\Carbon::parse($campioni_aria_dg18_at_rest_attivo->first()->oraFineAnalisi)->format('H:i') }}">
                            </th>
                        </tr>
                        <tr>
                            <th class="" colspan="6">
                                <b>Metodo:</b> <input type="text" class="form-control" style="width:50%" name="metodo_aria_dg18_at_rest_attivo" value="{{ getMetodo($campioni_aria_dg18_at_rest_attivo) }}"><br>
                                <b>Denominazione della prova:</b> <input type="text" class="form-control" style="width:50%" name="descrizione_metodo_aria_dg18_at_rest_attivo" value="{{ getDescrizioneMetodo($campioni_aria_dg18_at_rest_attivo) }}"><br>
                                <b>Tecnico incaricato dell'analisi:</b><input type="text" style="width: 50%" class="form-control" name="tecnico_aria_dg18_at_rest_attivo" value="{{ get_tecnico_analisi_campione($campioni_aria_dg18_at_rest_attivo) }}">
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
                                <b>CFU/m &#179;;</b>
                            </th>
                            <th>
                                <b>U(¹)</b>
                            </th>
                            <th>
                                <b>Valori di riferimento CFU/m &#179;</b>
                            </th>
                        </tr>
                    </thead>
                    @if(isset($rdp_anteprima_descrizione) && $anteprima == 1)
                        @php $rdp_anteprima_descrizione_dg18_at_rest_attivo = $rdp_anteprima_descrizione->where('dg18',1)->where('at_rest',1)->where('attivo',1) @endphp
                    @endif
                    @foreach($campioni_aria_dg18_at_rest_attivo as $c)  
                        @php $lg = get_linea_guida_piastra($c) @endphp
                        @php $tipi_di_campioni['_dg18_at_rest_attivo'] = 1 @endphp
                        @php $lineeguida_aria[$c->id_tipo_piastra] = $lg @endphp                     
                        @php $punto_camp = get_punto_camp($c) @endphp
                        @php $cfu = get_cfu_micro_piastra($c) @endphp
                        <tbody>
                            <tr style="width:auto">
                                <td>
                                    <input class="form-control" style="width: 100px" type="text" name="id_campione_aria_{{ $c->id }}" value="{{ $c->id }}">
                                </td>
                                <td>
                                    <input class="form-control" style="width: 300px" type="text" name="codice_cias_aria_{{ $c->id }}" value="{{ $c->codiceCIAS }}">
                                </td>
                                <td>
                                    <input class="form-control" style="width: 300px" type="text" name="punto_camp_aria_{{ $c->id }}" value="{{ $punto_camp }}">
                                </td>
                                <td>
                                    <input class="form-control" style="width: 100px" type="text" name="CFU_aria_{{ $c->id }}" value="{{ $cfu != 0 ? $cfu : '< 1' }}">
                                </td>
                                <td>
                                    <input class="form-control" style="width: 100px" type="text" name="U_aria_{{ $c->id }}" value="{{ getIncertezza($c) }}">
                                </td>
                                @if(isset($rdp_anteprima_descrizione_dg18_at_rest_attivo))
                                    <td>
                                        <input class="form-control" style="width: 100px" type="text" name="valori_riferimento_aria_{{ $c['id'] }}" value="{{ $rdp_anteprima_descrizione_dg18_at_rest_attivo->where('id_campione',$c->id)->first() != null ? $rdp_anteprima_descrizione_dg18_at_rest_attivo->where('id_campione',$c->id)->first()->valori_riferimento : '200'  }}">
                                    </td>
                                @else
                                    <td>
                                        <input class="form-control" style="width: 100px" type="text" name="valori_riferimento_aria_{{ $c->id }}" value="200">
                                    </td>
                                @endif
                            </tr>
                        </tbody>
                    @endforeach
                    <tr class="hidden">
                        <td class="hidden">
                            <input class="hidden" name="campioni_aria_dg18_at_rest_attivo" value="{{ serialize($campioni_aria_dg18_at_rest_attivo->toArray()) }}">
                        </td>
                        <td class="hidden">
                            <input class="hidden" name="lineeGuida_aria" value="{{ serialize($lineeguida_aria) }}">
                        </td>
                    </tr>
                    <tfoot>
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

<!-- ARIA DG18 AT_REST PASSIVO  -->
@if(count($campioni_aria_dg18_at_rest_passivo) > 0)
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
            <table class="table table-bordered table-striped table-hover campionamenti_table" role="grid" style="width:100%">
                    <thead>
                        <tr>
                            <th class="" colspan="6">
                                <b>Data e ora inizio incubazione:
                                    <!--var --> </b><input type="text" class="form-control" style="width:20%" name="dataOraInizioIncubazioneAria_dg18_at_rest_passivo" value="{{ Carbon\Carbon::parse($campioni_aria_dg18_at_rest_passivo->first()->dataAnalisi)->format('d/m/Y') ." - h. ".Carbon\Carbon::parse($campioni_aria_dg18_at_rest_passivo->first()->oraInizioAnalisi)->format('H:i')  }}"><br>
                                <b>Data e ora fine incubazione:
                                    <!--var --> </b><input type="text" class="form-control" style="width:20%" name="dataOraFineIncubazioneAria_dg18_at_rest_passivo" value="{{ Carbon\Carbon::parse($campioni_aria_dg18_at_rest_passivo->first()->dataFineAnalisi)->format('d/m/Y') ." - h. ".Carbon\Carbon::parse($campioni_aria_dg18_at_rest_passivo->first()->oraFineAnalisi)->format('H:i') }}">
                            </th>
                        </tr>
                        <tr>
                            <th class="" colspan="6">
                                <b>Metodo:</b> <input class="form-control" type="text" style="width:50%" name="metodo_aria_dg18_at_rest_passivo" value="{{ getMetodo($campioni_aria_dg18_at_rest_passivo) }}"><br>
                                <b>Denominazione della prova:</b> <input class="form-control" type="text" style="width:50%" name="descrizione_metodo_aria_dg18_at_rest_passivo" value="{{ getDescrizioneMetodo($campioni_aria_dg18_at_rest_passivo) }}"><br>
                                <b>Tecnico incaricato dell'analisi:</b><input class="form-control" style="width: 50%" type="text" name="tecnico_aria_dg18_at_rest_passivo" value="{{ get_tecnico_analisi_campione($campioni_aria_dg18_at_rest_passivo) }}">
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
                                <b>CFU/4h</b>
                            </th>
                            <th>
                                <b>U(¹)</b>
                            </th>
                            <th>
                                <b>Valori di riferimento CFU/4h</b>
                            </th>
                        </tr>
                    </thead>
                    @if(isset($rdp_anteprima_descrizione) && $anteprima == 1)
                        @php $rdp_anteprima_descrizione_dg18_at_rest_passivo = $rdp_anteprima_descrizione->where('dg18',1)->where('at_rest',1)->where('passivo',1) @endphp
                    @endif
                    @foreach($campioni_aria_dg18_at_rest_passivo as $c)  
                        @php $lg = get_linea_guida_piastra($c) @endphp
                        @php $tipi_di_campioni['_dg18_at_rest_passivo'] = 1 @endphp
                        @php $lineeguida_aria[$c->id_tipo_piastra] = $lg @endphp                     
                        @php $punto_camp = get_punto_camp($c) @endphp
                        @php $cfu = get_cfu_micro_piastra($c) @endphp
                        <tbody>
                            <tr style="width:auto">
                                <td>
                                    <input class="form-control" style="width: 100px" type="text" name="id_campione_aria_{{ $c->id }}" value="{{ $c->id }}">
                                </td>
                                <td>
                                    <input class="form-control" style="width: 300px" type="text" name="codice_cias_aria_{{ $c->id }}" value="{{ $c->codiceCIAS }}">
                                </td>
                                <td>
                                    <input class="form-control" style="width: 300px" type="text" name="punto_camp_aria_{{ $c->id }}" value="{{ $punto_camp }}">
                                </td>
                                <td>
                                    <input class="form-control" style="width: 100px" type="text" name="CFU_aria_{{ $c->id }}" value="{{ $cfu != 0 ? $cfu : '< 1' }}">
                                </td>
                                <td>
                                    <input class="form-control" style="width: 100px" type="text" name="U_aria_{{ $c->id }}" value="{{ getIncertezza($c) }}">
                                </td>
                                @if(isset($rdp_anteprima_descrizione_dg18_at_rest_passivo))
                                    <td>
                                        <input class="form-control" style="width: 100px" type="text" name="valori_riferimento_aria_{{ $c['id'] }}" value="{{ $rdp_anteprima_descrizione_dg18_at_rest_passivo->where('id_campione',$c->id)->first() != null ? $rdp_anteprima_descrizione_dg18_at_rest_passivo->where('id_campione',$c->id)->first()->valori_riferimento : '200' }}">
                                    </td>
                                @else
                                    <td>
                                        <input class="form-control" style="width: 100px" type="text" name="valori_riferimento_aria_{{ $c->id }}" value="200">
                                    </td>
                                @endif
                            </tr>
                        </tbody>
                    @endforeach
                    <tr class="hidden">
                        <td class="hidden">
                            <input class="hidden" name="campioni_aria_dg18_at_rest_passivo" value="{{ serialize($campioni_aria_dg18_at_rest_passivo->toArray()) }}">
                        </td>
                        <td class="hidden">
                            <input class="hidden" name="lineeGuida_aria" value="{{ serialize($lineeguida_aria) }}">
                        </td>
                    </tr>
                    <tfoot>
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

<div>
    <input class="hidden" name="tipi_di_campioni" value="{{ serialize($tipi_di_campioni) }}">
</div>