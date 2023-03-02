<!--pagina 2 -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-striped table-hover dataTable js-exportable campionamenti_table" role="grid" aria-describedby="DataTables_Table_1_info" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: left; background-color: rgb(189, 183, 183);">Campionamento a carico del committente</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>Incaricati del campionamento</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" name="incaricati_campionamento" class="form-control" value="{{ isset($rdp_anteprima) && $anteprima == 1 ? $rdp_anteprima->incaricati_del_campionamento : ''}}">
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><b>Data campionamento</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" style="width: auto">
                                da
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                     <input type="date" name="data_campionamento_inizio" class="form-control" value="{{ isset($rdp_anteprima) && $anteprima == 1 ? $rdp_anteprima->data_campionamento_inizio_committente : ''}}">
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" style="width: auto">
                                a
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <input type="date" name="data_campionamento_fine" class="form-control" value="{{ isset($rdp_anteprima) && $anteprima == 1 ? Carbon\Carbon::parse($rdp_anteprima->data_campionamento_fine_committente)->format('Y-m-d') : ''}}">
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><b>Inizio campionamento</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <input type="time" name="ora_inizio" class="form-control" value="{{ isset($rdp_anteprima) && $anteprima == 1 ? $rdp_anteprima->ora_inizio_committente : ''}}">
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" style="width: auto">
                                del
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <input type="date" name="data_inizio" class="form-control" value="{{ isset($rdp_anteprima) && $anteprima == 1 ? $rdp_anteprima->data_inizio_committente : ''}}">                                
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><b>Fine campionamento</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <input type="time" name="ora_fine" class="form-control" value="{{ isset($rdp_anteprima) && $anteprima == 1 ? $rdp_anteprima->ora_fine_committente : ''}}">
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" style="width: auto">
                                del
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <input type="date" name="data_fine" class="form-control" value="{{ isset($rdp_anteprima) && $anteprima == 1 ? $rdp_anteprima->data_fine_committente : ''}}">                                
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><b>Elenco dei campioni</b></td>
                    <td>
                        <table>
                            <thead>
                                <tr>
                                    <th>Codice campione</th>
                                    <th>Terreno</th>
                                    <th>Lotto</th>
                                    <th>Scadenza</th>
                                </tr>
                            </thead>
                            @php $num_campioni_elenco = 0; @endphp
                            <tbody>
                                @foreach($campioni as $c)
                                    @php $num_campioni_elenco++; @endphp
                                    <tr>
                                        <td><input type="text" name="codiceCIAS_{{$num_campioni_elenco}}" class="form-control" value="{{ $num_campioni_elenco < 10 ? "O".$num_campioni_elenco : $num_campioni_elenco}}" readonly></td>
                                        <td><input type="text" name="terreno_fornitore_{{$num_campioni_elenco}}" class="form-control" value="{{ $c->id_tipo_piastra == 26 ? 'PCA' : 'DG18'}}" readonly></td>
                                        <td><input type="text" name="lotto_{{$num_campioni_elenco}}" class="form-control" value="{{$c->lotto}}" readonly></td>
                                        <td><input type="text" name="scadenza_{{$num_campioni_elenco}}" class="form-control" value="{{$c->scadenza->format('d/m/Y')}}" readonly></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>  
        </table>
    </div>
</div>
<div class="row clearfix hidden">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <input type="text" name="num_campioni_elenco" class="form-control" value="{{$num_campioni_elenco}}" readonly>
        </div>
    </div>
</div>
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
                    <th colspan="{{ $columns + 1 }}" style="background-color: rgb(189, 183, 183);">NOTE DI CAMPIONAMENTO A CARICO DEL COMMITTENTE<br>
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
                        <input type="text" name="numero_colonne" class="form-control" value="{{ $columns }}">
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
                    <td><b>Campionamento effettuato da</b></td>
                    @foreach($schede_aria_operat as $s)
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" name="campionamento_effettuato_da_aria_operat_{{ $s['i'] }}" class="form-control" value="{{ ($s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'O') ? $s['tecnico'] : '/'}}" {{ $s['tipoCamp'] == 'A' && $s['stato_di_occupazione'] == 'O' ? '' : 'readonly' }}>
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