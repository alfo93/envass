<!--pagina 6 -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-striped table-hover dataTable js-exportable campionamenti_table" role="grid" aria-describedby="DataTables_Table_1_info"cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th colspan="2" style="background-color: rgb(189, 183, 183);">ANAGRAFICA CAMPIONAMENTO<br>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>Incaricati del campionamento</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 10px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143; "  name="incaricati_del_campionamento" class="form-control" value="{{ $anteprima == 1 && isset($rdp_anteprima->incaricati_del_campionamento) ? $rdp_anteprima->incaricati_del_campionamento : 'a cura del personale tecnico del laboratorio' }}">
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><b>Data campionamento</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    @php $dataCampionamento = "da ". $campioni->first()->dataCampagna->format('d/m/Y') . " a " . $campioni->last()->data->format('d/m/Y'); @endphp
                                    <input type="text" style="padding-left: 10px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143; " name="data_campionamento" class="form-control" value="{{ $dataCampionamento }}">
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><b>Inizio campionamento</b></td>
                    <td>
                        <table style="border-collapse: separate; border: 0cm">
                            <tbody>
                                <tr style="border-collapse: separate; border: 0cm">
                                    <td style="text-align: left; border-collapse: separate; border: 0cm;">
                                        Partenza dal laboratorio/accensione data logger (STRUM_
                                    </td>
                                    <td style="text-align: left; border-collapse: separate; border: 0cm; width:80px">
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0 mb-0">
                                                <div class="form-group mb-0">
                                                    <select class="form-control show-tick" name="inizio_campionamento_strum" size="10">
                                                        <option value="13" {{ is_selected_option($anteprima == 1 && isset($rdp_anteprima->inizio_campionamento_strum) ? $rdp_anteprima->inizio_campionamento_strum : '', '13')}}>13</option>
                                                        <option value="15" {{ is_selected_option($anteprima == 1 && isset($rdp_anteprima->inizio_campionamento_strum) ? $rdp_anteprima->inizio_campionamento_strum : '', '15')}}>15</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="pl-0" style="text-align: left; border-collapse: separate; border: 0cm;">
                                        ) / (15&#xf7;25)°C: 
                                    </td>
                                    <td>
                                        @php $dataOraPartenza1 = Carbon\Carbon::parse($campioni->first()->oraPartenza)->format('H:i') . " a " . Carbon\Carbon::parse($campioni->first()->dataPartenza)->format('d/m/Y'); @endphp
                                        <input type="text" style="20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143; " name="dataOraPartenza" value="{{ $anteprima == 1 && isset($rdp_anteprima->dataOraPartenza) ? $rdp_anteprima->dataOraPartenza : $dataOraPartenza1  }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><b>Inizio attività in loco</b></td>
                    <td>
                        <table style="border-collapse: separate; border: 0cm">
                            <tbody>
                                <tr style="border-collapse: separate; border: 0cm">
                                    <td style="text-align: left; border-collapse: separate; border: 0cm;">
                                        Inizio campionamento in loco/spegnimento data logger (STRUM_
                                    </td>
                                    <td style="text-align: left; border-collapse: separate; border: 0cm; width:80px">
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0 mb-0">
                                                <div class="form-group mb-0">
                                                    <select class="form-control show-tick" name="inizio_attivita_in_loco_strum" size="10">
                                                        <option value="14" {{ is_selected_option($anteprima == 1 && isset($rdp_anteprima->inizio_attivita_in_loco_strum) ? $rdp_anteprima->inizio_attivita_in_loco_strum : '','14')}}>14</option>
                                                        <option value="16" {{ is_selected_option($anteprima == 1 && isset($rdp_anteprima->inizio_attivita_in_loco_strum) ? $rdp_anteprima->inizio_attivita_in_loco_strum : '','16')}}>16</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="pl-0" style="text-align: left; border-collapse: separate; border: 0cm;">
                                        ) / (2&#xf7;8)°C: 
                                    </td>
                                    <td>
                                        @php $dataOraInizio1 = Carbon\Carbon::parse($campioni->first()->oraInizio)->format('H:i').' del '.Carbon\Carbon::parse($campioni->first()->dataInizio)->format('d/m/Y'); @endphp
                                        <input type="text" style="20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143; " name="dataOraInizio" value="{{ $anteprima == 1 && isset($rdp_anteprima->dataOraInizio) ? $rdp_anteprima->dataOraInizio : $dataOraInizio1 }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>                                
                    </td>
                </tr>
                <tr>
                    <td><b>Fine attività in loco</b></td>
                    <td>
                        <table style="border-collapse: separate; border: 0cm">
                            <tbody>
                                <tr style="border-collapse: separate; border: 0cm">
                                    <td style="text-align: left; border-collapse: separate; border: 0cm;">
                                        Fine campionamento in loco/spegnimento data logger (STRUM_
                                    </td>
                                    <td style="text-align: left; border-collapse: separate; border: 0cm; width:80px">
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0 mb-0">
                                                <div class="form-group mb-0">
                                                    <select class="form-control show-tick" size="10" name="fine_attivita_in_loco_strum">
                                                        <option value="13" {{ is_selected_option($anteprima == 1 && isset($rdp_anteprima->incaricati_del_campionamento) ? $rdp_anteprima->incaricati_del_campionamento : '', '13') }}>13</option>
                                                        <option value="15" {{ is_selected_option($anteprima == 1 && isset($rdp_anteprima->incaricati_del_campionamento) ? $rdp_anteprima->incaricati_del_campionamento : '', '15') }}>15</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="pl-0" style="text-align: left; border-collapse: separate; border: 0cm;">
                                        ) / (15&#xf7;25)°C: 
                                    </td>
                                    <td>
                                        @php $dataOraFine1 = Carbon\Carbon::parse($campioni->first()->oraFine)->format('H:i').' del '.Carbon\Carbon::parse($campioni->first()->dataFine)->format('d/m/Y'); @endphp
                                        <input type="text" style="20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143; " name="dataOraFine" value="{{ $anteprima == 1 && isset($rdp_anteprima->dataOraFine) ? $rdp_anteprima->dataOraFine : $dataOraFine1 }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><b>Fine campionamento</b></td>
                    <td>
                        <table style="border-collapse: separate; border: 0cm">
                            <tbody>
                                <tr style="border-collapse: separate; border: 0cm">
                                    <td style="text-align: left; border-collapse: separate; border: 0cm;">
                                        Arrivo al laboratorio/spegnimento data logger (STRUM_
                                    </td>
                                    <td style="text-align: left; border-collapse: separate; border: 0cm; width:80px">
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0 mb-0">
                                                <div class="form-group mb-0">
                                                    <select class="form-control show-tick" name="fine_campionamento_strum" size="10">
                                                        <option value="14" {{ $anteprima == 1 && isset($rdp_anteprima->fine_campionamento_strum) ? $rdp_anteprima->fine_campionamento_strum : '', '14'}}>14</option>
                                                        <option value="16" {{ $anteprima == 1 && isset($rdp_anteprima->fine_campionamento_strum) ? $rdp_anteprima->fine_campionamento_strum : '', '16'}}>16</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="pl-0" style="text-align: left; border-collapse: separate; border: 0cm;">
                                        ) / (2&#xf7;8)°C: 
                                    </td>
                                    <td>
                                        @php $dataOraArrivo1 = Carbon\Carbon::parse($campioni->first()->oraArrivo)->format('H:i').' del '.Carbon\Carbon::parse($campioni->first()->dataArrivo)->format('d/m/Y'); @endphp
                                        <input type="text" style="20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143; " name="dataOraArrivo" value="{{ $anteprima == 1 && isset($rdp_anteprima->dataOraArrivo) ? $rdp_anteprima->dataOraArrivo : $dataOraArrivo1 }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>                                
                    </td>
                </tr>
                <tr>
                    <td><b>Data accettazione</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group mb-0">
                                    <input type="date" name="data_accettazione" class="form-control" value="{{ (isset($campioni) && $campioni->first()->data_accettazione != null ? $campioni->first()->data_accettazione->format('Y-m-d') : '') }}" {{ isset($campioni) && $campioni->first()->data_accettazione != null ? 'readonly' : ''}} >
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>