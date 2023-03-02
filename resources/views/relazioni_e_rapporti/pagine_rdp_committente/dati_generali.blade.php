<!--pagina 1 -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-striped table-hover dataTable js-exportable campionamenti_table" id="rapporto_di_prova1" role="grid" aria-describedby="DataTables_Table_1_info" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="hidden"></th>
                    <th class="hidden"></th>  
                </tr>
            </thead>
            <tbody>
                <tr class="hidden">
                    <td style="text-align: right"><b></b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ml-1">
                                <div class="form-group">
                                    <input type="text" name="id_rdp" class="form-control" value="{{ $id_rapprel }}" style="margin-left: 10px;">
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right"><b>Rapporto di prova n. </b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ml-1">
                                <div class="form-group">
                                    <input type="text" name="num_rdp" class="form-control" value="{{ isset($rdp_anteprima->n_rdp) && $anteprima == 1 ? $rdp_anteprima->n_rdp : '' }}" style="margin-left: 10px;">
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><b>Nome e indirizzo del Laboratorio</b></td>
                    <td>
                        <p>
                            <span style="text-transform: capitalize"><b>cias</b></span><br>
                            Centro ricerche inquinamento fisico chimico microbiologico Ambienti alta Sterilità.<br>
                            <u>Sede legale:</u> Univeristà degli studi di Ferrara, Via Ariosto 35, 44121 Ferrara.<br>
                            Tel: +39 0532.293111 e-mail: <u>ateneo@pec.unife.it</u><br>
                            <u>Sede amministrativa:</u> Via Saragat 13, 44122 Ferrara<br>
                            Tel: +39 0532.293658 e-mail: <u>cias@unife.it</u> web: wwww.cias-ferrara.it        
                        </p>
                    </td>
                </tr>
                <tr>
                    <td><b>Committente</b></td>
                    <td>
                        <div class="form-group">
                            <b><input type="text" name="cliente_nome" class="form-control" value="{{ $societa_documento->nome }}" readonly></b><br>
                             <b><input type="text" name="cliente_indirizzo" class="form-control" value="{{ $societa_documento->indirizzo }}" readonly></b>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><b>Luogo di campionamento</b></td>
                    <td>
                        <div class="form-group">
                             <b><input type="text" name="struttura_partizione" class="form-control" value="{{ $struttura->struttura . " - " . $partizione->partizione }}" readonly></b>
                             {{-- <b><input type="text" name="struttura_sede" class="form-control" value="{{ $struttura->sede . " - " . $struttura->provincia }}" readonly></b> --}}
                             <b><input type="text" name="indirizzo_struttura" class="form-control" value="{{ (isset($rdp_anteprima->indirizzo_struttura) && $anteprima == 1) ? $rdp_anteprima->indirizzo_struttura : '' }}"></b>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><b>Modulo di accettazione di riferimento</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" id="modulo_di_accettazione" name="modulo_di_accettazione" value="{{ (isset($rdp_anteprima->modulo_accettazione) && $anteprima == 1) ? $rdp_anteprima->modulo_accettazione : '' }}" style="padding-left: 10px;" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="hidden">
                    <td class="hidden">
                        <input type="text" name="campioni" class="form-control" value="{{ json_encode($campioni) }}" readonly>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
