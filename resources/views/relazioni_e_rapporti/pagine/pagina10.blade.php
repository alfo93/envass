<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @if($campioni_speciazione_pca_aria != null && count($campioni_speciazione_pca_aria) > 0)
            <table class="table table-bordered table-striped table-hover dataTable js-exportable campionamenti_table"  id="addRowTable" role="grid" aria-describedby="DataTables_Table_1_info"cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th colspan="5"  style="background-color: rgb(189, 183, 183); text-align:left;">
                            Identificazione specie patogene
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Tipo terreno</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            PCA
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Matrice</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            Aria
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Data inizio - fine prova</b>
                        </td>
                        <td colspan="3">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding-right: 0cm; padding-left: 0cm;">
                                        <input type="date" class="form-control" value="{{ Carbon\Carbon::parse($campioni_speciazione_pca_aria->first()->dataFineProva)->format('Y-m-d') }}">
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 w-a" style="padding-right: 0cm;">
                                        -
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <input type="date" name="dataFineProva_pca_aria" class="form-control" value="{{ Carbon\Carbon::parse($campioni_speciazione_pca_aria->first()->dataFineProva)->addDay()->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div> 
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Tecnico incaricato dell'analisi</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            {{ get_tecnico_analisi_campione($campioni_speciazione_pca_aria) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Microrganismi ricercati</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            
                            {{ get_microrganismi_ricercati_campione($campioni_speciazione_pca_aria) }}
                        </td>
                    </tr>
                    <tr>
                        <td  style="text-align: center;">
                            <b>n. campione</b>
                        </td>
                        <td  style="text-align: center;">
                            <b>Codice campione</b>
                        </td>
                        <td  style="text-align: center;">
                            <b>Punto di campionamento</b>
                        </td>
                        <td  style="text-align: center;">
                            <b>Risultato</b>
                        </td>
                        <td  style="text-align: center;">
                            <b>Microrganismo identificato</b>
                        </td>
                    </tr>
                    @php $spec_camp = getAllResults($campioni_speciazione_pca_aria); @endphp
                    @foreach($spec_camp['NR'] as $cs)
                    <tr>
                        <td  style="text-align: center;">
                            {{ $cs['id_campione'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['codice_campione']}}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['punto_campionamento'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['risultato'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ "/" }}
                        </td>
                    </tr>
                    @endforeach
                    @foreach($spec_camp['R'] as $cs)
                    <tr>
                        <td  style="text-align: center;">
                            {{ $cs['id_campione'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['codice_campione']}}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['punto_campionamento'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['risultato'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['microrganismo_ricercato'] }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            @if($campioni_speciazione_pca_superficie != null && count($campioni_speciazione_pca_superficie) > 0)
            <table class="table table-bordered table-striped table-hover dataTable js-exportable campionamenti_table"  id="addRowTable" role="grid" aria-describedby="DataTables_Table_1_info"cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th colspan="5"  style="background-color: rgb(189, 183, 183); text-align:left;">
                            Identificazione specie patogene
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Tipo terreno</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            PCA
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Matrice</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            Superficie
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Data inizio - fine prova</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding-right: 0cm; padding-left: 0cm;">
                                <input type="date" class="form-control" value="{{ Carbon\Carbon::parse($campioni_speciazione_pca_superficie->first()->dataFineProva)->format('Y-m-d') }}">
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 w-a" style="padding-right: 0cm;">
                                -
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <input type="date" name="dataFineProva_pca_superficie" class="form-control" value="{{ Carbon\Carbon::parse($campioni_speciazione_pca_superficie->first()->dataFineProva)->addDay()->format('Y-m-d') }}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Tecnico incaricato dell'analisi</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            {{ get_tecnico_analisi_campione($campioni_speciazione_pca_superficie) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Microrganismi ricercati</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            
                            {{ get_microrganismi_ricercati_campione($campioni_speciazione_pca_superficie) }}
                        </td>
                    </tr>
                    <tr>
                        <td  style="text-align: center;">
                            <b>n. campione</b>
                        </td>
                        <td  style="text-align: center;">
                            <b>Codice campione</b>
                        </td>
                        <td  style="text-align: center;">
                            <b>Punto di campionamento</b>
                        </td>
                        <td  style="text-align: center;">
                            <b>Risultato</b>
                        </td>
                        <td  style="text-align: center;">
                            <b>Microrganismo identificato</b>
                        </td>
                    </tr>
                    @php $spec_camp = getAllResults($campioni_speciazione_pca_superficie); @endphp
                    @foreach($spec_camp['NR'] as $cs)
                    <tr>
                        <td  style="text-align: center;">
                            {{ $cs['id_campione'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['codice_campione']}}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['punto_campionamento'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['risultato'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ "/" }}
                        </td>
                    </tr>
                    @endforeach
                    @foreach($spec_camp['R'] as $cs)
                    <tr>
                        <td  style="text-align: center;">
                            {{ $cs['id_campione'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['codice_campione']}}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['punto_campionamento'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['risultato'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['microrganismo_ricercato'] }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            @if($campioni_speciazione_dg18_aria != null && count($campioni_speciazione_dg18_aria) > 0)
            <table class="table table-bordered table-striped table-hover dataTable js-exportable campionamenti_table"  id="addRowTable" role="grid" aria-describedby="DataTables_Table_1_info"cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th colspan="5"  style="background-color: rgb(189, 183, 183); text-align:left;">
                            Identificazione specie patogene
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Tipo terreno</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            DG18
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Matrice</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            Aria
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Data inizio - fine prova</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding-right: 0cm; padding-left: 0cm;">
                                <input type="date" class="form-control" value="{{ Carbon\Carbon::parse($campioni_speciazione_dg18_aria->first()->dataFineProva)->format('Y-m-d') }}">
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 w-a" style="padding-right: 0cm;">
                                -
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <input type="date" name="dataFineProva_dg18_aria" class="form-control" value="{{ Carbon\Carbon::parse($campioni_speciazione_dg18_aria->first()->dataFineProva)->addDay()->format('Y-m-d') }}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Tecnico incaricato dell'analisi</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            {{ get_tecnico_analisi_campione($campioni_speciazione_dg18_aria) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Microrganismi ricercati</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            
                            {{ get_microrganismi_ricercati_campione($campioni_speciazione_dg18_aria) }}
                        </td>
                    </tr>
                    <tr>
                        <td  style="text-align: center;">
                            <b>n. campione</b>
                        </td>
                        <td  style="text-align: center;">
                            <b>Codice campione</b>
                        </td>
                        <td  style="text-align: center;">
                            <b>Punto di campionamento</b>
                        </td>
                        <td  style="text-align: center;">
                            <b>Risultato</b>
                        </td>
                        <td  style="text-align: center;">
                            <b>Microrganismo identificato</b>
                        </td>
                    </tr>
                    @php $spec_camp = getAllResults($campioni_speciazione_dg18_aria); @endphp
                    @foreach($spec_camp['NR'] as $cs)
                    <tr>
                        <td  style="text-align: center;">
                            {{ $cs['id_campione'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['codice_campione']}}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['punto_campionamento'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['risultato'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ "/" }}
                        </td>
                    </tr>
                    @endforeach
                    @foreach($spec_camp['R'] as $cs)
                    <tr>
                        <td  style="text-align: center;">
                            {{ $cs['id_campione'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['codice_campione']}}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['punto_campionamento'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['risultato'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['microrganismo_ricercato'] }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            @if($campioni_speciazione_dg18_superficie != null && count($campioni_speciazione_dg18_superficie) > 0)
            <table class="table table-bordered table-striped table-hover dataTable js-exportable campionamenti_table"  id="addRowTable" role="grid" aria-describedby="DataTables_Table_1_info" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th colspan="5"  style="background-color: rgb(189, 183, 183); text-align:left;">
                            Identificazione specie patogene
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Tipo terreno</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            DG18
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Matrice</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            Superficie
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Data inizio - fine prova</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding-right: 0cm; padding-left: 0cm;">
                                <input type="date" class="form-control" value="{{  Carbon\Carbon::parse($campioni_speciazione_dg18_superficie->first()->dataFineProva)->format('Y-m-d')  }}">
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 w-a" style="padding-right: 0cm;">
                                -
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <input type="date" name="dataFineProva_dg18_superficie" class="form-control" value="{{ Carbon\Carbon::parse($campioni_speciazione_dg18_superficie->first()->dataFineProva)->addDay()->format('Y-m-d') }}">
                            </div> 
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Tecnico incaricato dell'analisi</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            {{ get_tecnico_analisi_campione($campioni_speciazione_dg18_superficie) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="text-align: left;">
                            <b>Microrganismi ricercati</b>
                        </td>
                        <td colspan="3"  style="text-align: left;">
                            
                            {{ get_microrganismi_ricercati_campione($campioni_speciazione_dg18_superficie) }}
                        </td>
                    </tr>
                    <tr>
                        <td  style="text-align: center;">
                            <b>n. campione</b>
                        </td>
                        <td  style="text-align: center;">
                            <b>Codice campione</b>
                        </td>
                        <td  style="text-align: center;">
                            <b>Punto di campionamento</b>
                        </td>
                        <td  style="text-align: center;">
                            <b>Risultato</b>
                        </td>
                        <td  style="text-align: center;">
                            <b>Microrganismo identificato</b>
                        </td>
                    </tr>
                    @php $spec_camp = getAllResults($campioni_speciazione_dg18_superficie); @endphp
                    @foreach($spec_camp['NR'] as $cs)
                    <tr>
                        <td  style="text-align: center;">
                            {{ $cs['id_campione'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['codice_campione']}}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['punto_campionamento'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['risultato'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ "/" }}
                        </td>
                    </tr>
                    @endforeach
                    @foreach($spec_camp['R'] as $cs)
                    <tr>
                        <td  style="text-align: center;">
                            {{ $cs['id_campione'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['codice_campione']}}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['punto_campionamento'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['risultato'] }}
                        </td>
                        <td  style="text-align: center;">
                            {{ $cs['microrganismo_ricercato'] }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
    </div>
</div>