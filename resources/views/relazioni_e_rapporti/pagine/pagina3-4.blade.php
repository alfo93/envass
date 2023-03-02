<!--pagina 3 - 4 -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        @php $columns = get_number_of_column($campioni) @endphp
        @php $schede = note_di_campionamento($campioni, $columns) @endphp
        @php $schede_aria_at_rest = campionamento_sez_3($campioni,'A','R', $columns) @endphp
        @php $schede_aria_operat = campionamento_sez_3($campioni,'A','O', $columns) @endphp
        @php $schede_sup_at_rest = campionamento_sez_3($campioni,'S','R', $columns) @endphp
        @php $note_anteprima = App\NotaCampionamentoRdpAnteprima::where('id_rdp', $id_rapprel)->get() @endphp
        <table class="table table-bordered table-striped table-hover dataTable js-exportable campionamenti_table" role="grid" aria-describedby="DataTables_Table_1_info"cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th colspan="{{ $columns + 1 }}" style="background-color: rgb(189, 183, 183);">NOTE DI CAMPIONAMENTO<br>
                        Descrizione del luogo di campionamento incluse le eventuali attività generanti aerosol
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>Tipo di ambiente</b></td>
                    @foreach($schede as $s)
                        <td>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input type="text" style="padding-left: 5px;" name="tipo_di_ambiente_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->tipo_di_ambiente) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->tipo_di_ambiente : $s['tipo_di_ambiente'] }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Numero e codifica locali</b></td>
                    @foreach($schede as $s)
                    <td>
                        <table style="border: none;">
                            <tr style="border: none;">
                                <td style="border: none;">
                                    <div class="row clearfix w-a">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" style="padding-left: 5px;" name="numero_e_codifica_locali_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->numero_e_codifica_locali) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->numero_e_codifica_locali : $s['numero_e_codifica_locali']}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border: none;">
                                <td style="border: none;">
                                    <div class="row clearfix w-a">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" style="padding-left: 5px;" name="codice_partizione_stanza_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->codice_partizione_stanza) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->codice_partizione_stanza : $s['codice_partizione_stanza'] }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Classe ISO di Riferimento</b></td>
                    @foreach($schede as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="class_iso_di_riferimento_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->classe_iso_di_riferimento) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->classe_iso_di_riferimento : $s['classe_iso_di_riferimento'] }}" readonly>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Tipo di flusso</b></td>
                    @foreach($schede as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="tipo_di_flusso_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->tipo_di_flusso) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->tipo_di_flusso : (($s['scheda'] == 'si' && $s['tipo_di_flusso'] == 'L') ? 'Laminare/Unidirezionale' : ($s['scheda'] == 'si' && $s['tipo_di_flusso'] == 'T' ? 'Turbolento' : '/')) }}" readonly>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Note</b></td>
                    @foreach($schede as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="note_pagina3_{{ $s['i'] }}" rows="3" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->note_pagina3) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->note_pagina3 : ($s['scheda'] == 'si' ? '' : '/') }}" style="min-height: 50px;" {{ $s['scheda'] == 'si' ? '' : 'readonly' }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
            </tbody>
            <!-- at rest -->
            <thead>
                <tr>
                    <th colspan="{{ $columns + 1 }}" style="background-color: rgb(189, 183, 183);">Campionamento aria
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>Stato di occupazione</b></td>
                    @foreach($schede_aria_at_rest as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="stato_di_occupazione_aria_at_rest_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->stato_di_occupazione) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->stato_di_occupazione : (($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'R') ? 'At rest' : '/') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Data di campionamento ora inizio e fine</b></td>
                    @foreach($schede_aria_at_rest as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group" >
                                    @if($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'R')
                                        <input type="date" style="background-color: rgb(213, 208, 208);" name="data_di_campionamento_ora_inizio_e_fine_aria_at_rest_data_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_aria_at_rest_data) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_aria_at_rest_data : Carbon\Carbon::parse($s['dataInizio'])->format('Y-m-d') }}">
                                        <input type="time" style="background-color: rgb(213, 208, 208);" name="data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraI_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraI) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraI : $s['oraInizio'] }}">
                                        <input type="time" style="background-color: rgb(213, 208, 208);" name="data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraF_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraF) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraF : $s['oraFine'] }}">
                                    @else
                                        <input type="text" style="padding-left: 5px;" name="data_di_campionamento_ora_inizio_e_fine_aria_at_rest_data_{{ $s['i'] }}" class="form-control" value="/" readonly>
                                        <input type="text" style="padding-left: 5px;" name="data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraI_{{ $s['i'] }}" class="form-control hidden" value="/" readonly>
                                        <input type="text" style="padding-left: 5px;" name="data_di_campionamento_ora_inizio_e_fine_aria_at_rest_oraF_{{ $s['i'] }}" class="form-control hidden" value="/" readonly>    
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>STRUM. n°</b></td>
                    @foreach($schede_aria_at_rest as $s)
                        @if($s['scheda'] == 'si' && ($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'R'))
                            <td>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <select class="form-control show-tick" multiple="" name="strum_n_aria_at_rest_{{ $s['i'] }}[]">
                                                <option value="/">-- Seleziona un'opzione --</option>
                                                <option value="STRUM 26" {{ is_selected_option((count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->strum_n_aria_at_rest1) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->strum_n_aria_at_rest1 : '', 'STRUM 26')}}> STRUM 26</option>
                                                <option value="STRUM 27" {{ is_selected_option((count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->strum_n_aria_at_rest2) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->strum_n_aria_at_rest2 : '', 'STRUM 27')}}> STRUM 27</option>
                                                <option value="STRUM 42" {{ is_selected_option((count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->strum_n_aria_at_rest3) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->strum_n_aria_at_rest3 : '', 'STRUM 42')}}> STRUM 42</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @else
                            <td>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" style="padding-left: 5px;" name="strum_n_aria_at_rest_{{ $s['i'] }}" class="form-control" value="/" readonly>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td><b>N. Persone presenti</b></td>
                    @foreach($schede_aria_at_rest as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="n_persone_presenti_aria_at_rest_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->n_persone_presenti_aria_at_rest) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->n_persone_presenti_aria_at_rest : (($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'R') ? $s['n_persone_presenti'] : '/')}}" {{ $s['scheda'] == 'no' ? 'readonly' : '' }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Stato porte</b></td>
                    @foreach($schede_aria_at_rest as $s)
                    <td>
                        @if($s['scheda'] == 'si' && ($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'R'))
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <select class="form-control show-tick" name="stato_porte_aria_at_rest_{{ $s['i'] }}">
                                            <option selected value="/">-- Seleziona un'opzione --</option>
                                            <option value="Aperte" {{ is_selected_option((count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->stato_porte_aria_at_rest) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->stato_porte_aria_at_rest : '','Aperte')}}> Aperte</option>
                                            <option value="Chiuse" {{ is_selected_option((count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->stato_porte_aria_at_rest) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->stato_porte_aria_at_rest : '','Chiuse')}}> Chiuse</option>
                                        </select>
                                    
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input type="text" style="padding-left: 5px;" name="stato_porte_aria_at_rest_{{ $s['i'] }}" class="form-control" value="/" readonly>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Campionamento effettuato da</b></td>
                    @foreach($schede_aria_at_rest as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="campionamento_effettuato_da_aria_at_rest_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->campionamento_effettuato_da_aria_at_rest) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->campionamento_effettuato_da_aria_at_rest : (($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'R') ? $s['tecnico']: '/')}}" {{ $s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'R' ? '' : 'readonly' }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Note</b></td>
                    @foreach($schede_aria_at_rest as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="note_pagina3_aria_at_rest_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->note_pagina3_aria_at_rest) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->note_pagina3_aria_at_rest : (($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'R') ? '' : '/') }}" {{ ($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'R') ? '' : 'readonly' }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="hidden">
                        <input type="text" style="padding-left: 5px;" name="numero_colonne" class="form-control" value="{{ $columns }}">
                    </td>
                </tr>
                <!-- operational -->
                <tr>
                    <td><b>Stato di occupazione</b></td>
                    @foreach($schede_aria_operat as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="stato_di_occupazione_aria_operat_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->stato_di_occupazione_aria_operat) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->stato_di_occupazione_aria_operat : (($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'O') ? 'Operational' : '/') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Data di campionamento ora inizio e fine</b></td>
                    @foreach($schede_aria_operat as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    @if(($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'O'))
                                        <input type="date" style="background-color: rgb(213, 208, 208);" name="data_di_campionamento_ora_inizio_e_fine_aria_operat_data_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_aria_operat_data) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_aria_operat_data : Carbon\Carbon::parse($s['dataInizio'])->format('Y-m-d') }}">
                                        <input type="time" style="background-color: rgb(213, 208, 208);" name="data_di_campionamento_ora_inizio_e_fine_aria_operat_oraI_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_aria_operat_oraI) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_aria_operat_oraI : $s['oraInizio'] }}">
                                        <input type="time" style="background-color: rgb(213, 208, 208);" name="data_di_campionamento_ora_inizio_e_fine_aria_operat_oraF_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_aria_operat_oraF) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_aria_operat_oraF : $s['oraFine'] }}">
                                    @else
                                        <input type="text" style="padding-left: 5px;" name="data_di_campionamento_ora_inizio_e_fine_aria_operat_data_{{ $s['i'] }}" class="form-control" value="/" readonly>
                                        <input type="text" style="padding-left: 5px;" name="data_di_campionamento_ora_inizio_e_fine_aria_operat_oraI_{{ $s['i'] }}" class="form-control hidden" value="/" readonly>
                                        <input type="text" style="padding-left: 5px;" name="data_di_campionamento_ora_inizio_e_fine_aria_operat_oraF_{{ $s['i'] }}" class="form-control hidden" value="/" readonly>    
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>STRUM. n°</b></td>
                    @foreach($schede_aria_operat as $s)
                        @if($s['scheda'] == 'si' && ($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'O'))
                            <td>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <select class="form-control show-tick" multiple="" name="strum_n_aria_operat_{{ $s['i'] }}[]">
                                                <option value="/">-- Seleziona un'opzione --</option>
                                                <option value="STRUM 26" {{ is_selected_option((count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->strum_n_aria_operat1) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->strum_n_aria_operat1 : '', 'STRUM 26')}}> STRUM 26</option>
                                                <option value="STRUM 27" {{ is_selected_option((count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->strum_n_aria_operat2) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->strum_n_aria_operat2 : '', 'STRUM 27')}}> STRUM 27</option>
                                                <option value="STRUM 42" {{ is_selected_option((count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->strum_n_aria_operat3) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->strum_n_aria_operat3 : '', 'STRUM 42')}}> STRUM 42</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @else
                            <td>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" style="padding-left: 5px;" name="strum_n_aria_operat_{{ $s['i'] }}" class="form-control" value="/" readonly>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td><b>N. Persone presenti</b></td>
                    @foreach($schede_aria_operat as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="n_persone_presenti_aria_operat_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->n_persone_presenti_aria_operat) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->n_persone_presenti_aria_operat : (($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'O') ? $s['n_persone_presenti'] : '/')}}" {{ $s['scheda'] == 'no' ? 'readonly' : '' }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Stato porte</b></td>
                    @foreach($schede_aria_operat as $s)
                    <td>
                        @if($s['scheda'] == 'si' && ($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'O'))
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <select class="form-control show-tick" name="stato_porte_aria_operat_{{ $s['i'] }}">
                                            <option selected value="/">-- Seleziona un'opzione --</option>
                                            <option value="Aperte" {{ is_selected_option((count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->stato_porte_aria_operat) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->stato_porte_aria_operat : '', 'Aperte') }}> Aperte</option>
                                            <option value="Chiuse" {{ is_selected_option((count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->stato_porte_aria_operat) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->stato_porte_aria_operat : '', 'Chiuse') }}> Chiuse</option>
                                        </select>
                                    
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input type="text" style="padding-left: 5px;" name="stato_porte_aria_operat_{{ $s['i'] }}" class="form-control" value="/" readonly>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Tipo di operazione</b></td>
                    @foreach($schede_aria_operat as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="tipo_di_operazione_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->tipo_di_operazione) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->tipo_di_operazione : (($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'O') ? 'simulazione' : '/')}}" {{ $s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'O' ? '' : 'readonly' }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Campionamento effettuato da</b></td>
                    @foreach($schede_aria_operat as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="campionamento_effettuato_da_aria_operat_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->campionamento_effettuato_da_aria_operat) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->campionamento_effettuato_da_aria_operat : (($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'O') ? $s['tecnico'] : '/')}}" {{ $s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'O' ? '' : 'readonly' }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Note</b></td>
                    @foreach($schede_aria_operat as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="note_pagina3_aria_operat_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->note_pagina3_aria_operat) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->note_pagina3_aria_operat : (($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'O') ? '' : '/') }}" {{ $s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'O' ? '' : 'readonly' }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
            </tbody>
            <!-- Superifici -->
            <thead>
                <tr>
                    <th colspan="{{ $columns + 1 }}" style="background-color: rgb(189, 183, 183);">Campionamento superfici
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>Stato di occupazione</b></td>
                    @foreach($schede_sup_at_rest as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="stato_di_occupazione_superfici_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->stato_di_occupazione_superfici) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->stato_di_occupazione_superfici : ($s['tipoCamp'] == 'S' ? 'At rest' : '/')}}" readonly>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Data di campionamento ora inizio e fine</b></td>
                    @foreach($schede_sup_at_rest as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    @if($s['scheda'] == 'si' && $s['tipoCamp'] == 'S')
                                        <input type="date" style="background-color: rgb(213, 208, 208);" name="data_di_campionamento_ora_inizio_e_fine_superfici_data_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_superfici_data) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_superfici_data : Carbon\Carbon::parse($s['dataInizio'])->format('Y-m-d') }}">
                                        <input type="time" style="background-color: rgb(213, 208, 208);" name="data_di_campionamento_ora_inizio_e_fine_superfici_oraI_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_superfici_oraI) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_superfici_oraI : $s['oraInizio'] }}">
                                        <input type="time" style="background-color: rgb(213, 208, 208);" name="data_di_campionamento_ora_inizio_e_fine_superfici_oraF_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_superfici_oraF) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->data_di_campionamento_ora_inizio_e_fine_superfici_oraF : $s['oraFine'] }}">    
                                    @else
                                        <input type="text" style="padding-left: 5px;" name="data_di_campionamento_ora_inizio_e_fine_superfici_data_{{ $s['i'] }}" class="form-control" value="/" readonly>
                                        <input type="text" style="padding-left: 5px;" name="data_di_campionamento_ora_inizio_e_fine_superfici_oraI_{{ $s['i'] }}" class="form-control hidden" value="/" readonly>
                                        <input type="text" style="padding-left: 5px;" name="data_di_campionamento_ora_inizio_e_fine_superfici_oraF_{{ $s['i'] }}" class="form-control hidden" value="/" readonly>                                        
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>N. Persone presenti</b></td>
                    @foreach($schede_sup_at_rest as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="n_persone_presenti_superfici_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->n_persone_presenti_superfici) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->n_persone_presenti_superfici : ($s['tipoCamp'] == 'S' ? $s['n_persone_presenti'] : '/') }}" {{ $s['scheda'] == 'no' ? 'readonly' : '' }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Stato porte</b></td>
                    @foreach($schede_sup_at_rest as $s)
                    <td>
                        @if($s['scheda'] == 'si' && $s['tipoCamp'] == 'S')
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <select class="form-control show-tick" name="stato_porte_superfici_{{ $s['i'] }}">
                                            <option selected value="/">-- Seleziona un'opzione --</option>
                                            <option value="Aperte" {{ is_selected_option((count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->stato_porte_superfici) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->stato_porte_superfici : '','Aperte')}}> Aperte</option>
                                            <option value="Chiuse" {{ is_selected_option((count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->stato_porte_superfici) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->stato_porte_superfici : '','Chiuse')}}> Chiuse</option>
                                        </select>
                                    
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <input type="text" style="padding-left: 5px;" name="stato_porte_superfici_{{ $s['i'] }}" class="form-control" value="/" readonly>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Campionamento effettuato da</b></td>
                    @foreach($schede_sup_at_rest as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="campionamento_effettuato_da_superfici_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->campionamento_effettuato_da_superfici) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->campionamento_effettuato_da_superfici : ($s['tipoCamp'] == 'S' ? $s['tecnico'] : '/')}}" {{ ($s['tipoCamp'] == 'S' && $s['scheda'] == 'si') ? '' : 'readonly' }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>Note</b></td>
                    @foreach($schede_sup_at_rest as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="note_pagina3_superfici_{{ $s['i'] }}" class="form-control" value="{{ (count($note_anteprima) > 0 && $note_anteprima->skip($s['i']-1)->take(1)->first() != null && isset($note_anteprima->skip($s['i']-1)->take(1)->first()->note_pagina3_superfici) && $anteprima == 1) ? $note_anteprima->skip($s['i']-1)->take(1)->first()->note_pagina3_superfici : ($s['tipoCamp'] == 'S' ? '' : '/')}}" {{ ($s['tipoCamp'] == 'S' && $s['scheda'] == 'si') ? '' : 'readonly' }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
</div>