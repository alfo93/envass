<!--pagina 2 -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-striped table-hover dataTable js-exportable campionamenti_table" role="grid" aria-describedby="DataTables_Table_1_info"cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th colspan="2">PIANO DI CAMPIONAMENTO ARIA</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Dispositivo di campionamento</b></td>
                    <td class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text"  name="dispositivo_di_campionamento_1" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" class="form-control" value="{{ (isset($rdp_anteprima->dispositivo_di_campionamento_1) && $anteprima == 1) ? $rdp_anteprima->dispositivo_di_campionamento_1 : 'Campionatore Attivo monostadio ad impatto ortogonale Surface Air System (SAS) super ISO 180/super DUO 360' }}">
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Tipo di campionamento</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="tipo_di_campionamento" class="form-control" value="{{ isset($rdp_anteprima->tipo_di_campionamento) && $anteprima == 1 ? $rdp_anteprima->tipo_di_campionamento : 'statico' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Portata</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text"  style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="portata" class="form-control" value="{{ isset($rdp_anteprima->portata) && $anteprima == 1 ? $rdp_anteprima->portata : ' m³' }} ">
                                </div>
                            </div> 
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Volume campionato</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="volume_campionato" class="form-control" value="{{ isset($rdp_anteprima->volume_campionato) && $anteprima == 1 ? $rdp_anteprima->volume_campionato : ' m³' }} ">
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-striped table-hover dataTable js-exportable campionamenti_table" role="grid" aria-describedby="DataTables_Table_1_info" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="">Monitoraggio di</th>
                    <th class="">Microrganismi totali a 30°C</th>
                    <th class="">Lieviti e muffe</th>
                </tr>
            </thead>
            @php $tipo_di_substrato = tipo_di_substrato($campioni); @endphp
            @php $condizione_e_durata = format_condizioni_durata_incubazione($tipo_di_substrato,$campioni); @endphp
            <tbody>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Tipo di substrato per la crescita</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="tipo_di_substrato_pca_1" class="form-control" value="{{ (isset($rdp_anteprima->tipo_di_substrato_pca_1) && $anteprima == 1) ? $rdp_anteprima->tipo_di_substrato_pca_1 : (($tipo_di_substrato == 1 || $tipo_di_substrato == 3) ? 'PCA' : '/') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </td>
                    
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="tipo_di_substrato_dg18_1" class="form-control" value="{{ (isset($rdp_anteprima->tipo_di_substrato_dg18_1) && $anteprima == 1) ? $rdp_anteprima->tipo_di_substrato_dg18_1 : (($tipo_di_substrato == 2 || $tipo_di_substrato == 3) ? 'DG18' : '/') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Condizioni e durata dell'incubazione</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="condizioni_durata_pca_1" class="form-control" value="{{ (isset($rdp_anteprima->condizioni_durata_pca_1) && $anteprima == 1) ? $rdp_anteprima->condizioni_durata_pca_1 : (($tipo_di_substrato == 1 || $tipo_di_substrato == 3) ? $condizione_e_durata['pca'] : '/' )}}" readonly>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="condizioni_durata_dg18_1" class="form-control" value="{{ (isset($rdp_anteprima->condizioni_durata_dg18_1) && $anteprima == 1) ? $rdp_anteprima->condizioni_durata_dg18_1 : (($tipo_di_substrato == 2 || $tipo_di_substrato == 3) ? $condizione_e_durata['dg18'] : '/') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Descrizione e punto di campionamento</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="descrizione_punto_pca_1" class="form-control" value="{{ (isset($rdp_anteprima->descrizione_punto_pca_1) && $anteprima == 1) ? $rdp_anteprima->descrizione_punto_pca_1 : (($tipo_di_substrato == 1 || $tipo_di_substrato == 3) ? 'condizioni di at rest al centro della stanza a 1,5 metri da terra' : '/') }}" {{ ($tipo_di_substrato != 1 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="descrizione_punto_dg18_1" class="form-control" value="{{ (isset($rdp_anteprima->descrizione_punto_dg18_1) && $anteprima == 1) ? $rdp_anteprima->descrizione_punto_dg18_1 :  (($tipo_di_substrato == 2 || $tipo_di_substrato == 3) ? 'condizioni di at rest al centro della stanza a 1,5 metri da terra' : '/') }}" {{ ($tipo_di_substrato != 2 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Numero prelievi per punto</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="n_prelievi_pca_1" class="form-control" value="{{ (isset($rdp_anteprima->n_prelievi_pca_1) && $anteprima == 1) ? $rdp_anteprima->n_prelievi_pca_1 : (($tipo_di_substrato == 1 || $tipo_di_substrato == 3) ? '' : '/') }}" {{ ($tipo_di_substrato != 1 && $tipo_di_substrato != 3) ? 'readonly' : ''  }} {{ ($tipo_di_substrato != 1 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="n_prelievi_dg18_1" class="form-control" value="{{ (isset($rdp_anteprima->n_prelievi_dg18_1) && $anteprima == 1) ? $rdp_anteprima->n_prelievi_dg18_1 : (($tipo_di_substrato == 2 || $tipo_di_substrato == 3) ? '' : '/') }}" {{ ($tipo_di_substrato != 2 && $tipo_di_substrato != 3) ? 'readonly' : ''  }} {{ ($tipo_di_substrato != 2 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Descrizione e punto di campionamento</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="descrizione_punto_pca_2" class="form-control" value="{{ (isset($rdp_anteprima->descrizione_punto_pca_2) && $anteprima == 1) ? $rdp_anteprima->descrizione_punto_pca_2 : (($tipo_di_substrato == 1 || $tipo_di_substrato == 3) ? 'condizioni di at rest al centro della stanza a 1,5 metri da terra' : '/') }}" {{ ($tipo_di_substrato != 1 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="descrizione_punto_dg18_2" class="form-control" value="{{ (isset($rdp_anteprima->descrizione_punto_dg18_2) && $anteprima == 1) ? $rdp_anteprima->descrizione_punto_dg18_2 : (($tipo_di_substrato == 2 || $tipo_di_substrato == 3) ? 'condizioni di at rest al centro della stanza a 1,5 metri da terra' : '/') }}" {{ ($tipo_di_substrato != 2 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Numero prelievi per punto</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="n_prelievi_pca_2" class="form-control" value="{{ (isset($rdp_anteprima->n_prelievi_pca_2) && $anteprima == 1) ? $rdp_anteprima->n_prelievi_pca_2 : (($tipo_di_substrato == 1 || $tipo_di_substrato == 3) ? '' : '/') }}" {{ ($tipo_di_substrato != 1 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="n_prelievi_dg18_2" class="form-control" value="{{ (isset($rdp_anteprima->n_prelievi_dg18_2) && $anteprima == 1) ? $rdp_anteprima->n_prelievi_dg18_2 : (($tipo_di_substrato == 2 || $tipo_di_substrato == 3) ? '' : '/') }}" {{ ($tipo_di_substrato != 2 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Note</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="note_pagina2_1" class="form-control" value="{{ (isset($rdp_anteprima->note_pagina2_1) && $anteprima == 1) ? $rdp_anteprima->note_pagina2_1 : (($tipo_di_substrato == 1 || $tipo_di_substrato == 3) ? '' : '/') }}" {{ ($tipo_di_substrato != 1 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="note_pagina2_2" class="form-control" value="{{ (isset($rdp_anteprima->note_pagina2_2) && $anteprima == 1) ? $rdp_anteprima->note_pagina2_2 : (($tipo_di_substrato == 2 || $tipo_di_substrato == 3) ? '' : '/') }}" {{ ($tipo_di_substrato != 2 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <caption>
        </caption> 
        <table class="table table-bordered table-striped table-hover dataTable js-exportable campionamenti_table" role="grid" aria-describedby="DataTables_Table_1_info"cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th colspan="2"> PIANO DI CAMPIONAMENTO SUPERFICI</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Dispositivo di campionamento</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="dispositivo_di_campionamento_2" class="form-control" value="{{ (isset($rdp_anteprima->dispositivo_di_campionamento_2) && $anteprima == 1) ? $rdp_anteprima->dispositivo_di_campionamento_2 : ($campioni->where('tipoCamp','S')->first() != null ? ($campioni->where('tipoCamp','S')->first()->tipoCampione == 'piastra' ? 'Piastre a contatto (RODAC plate 55mm di diametro)' : 'Tampone') : '/') }}" readonly>                                    
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Area di campionamento</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="area_di_campionamento" class="form-control" value="{{ (isset($rdp_anteprima->area_di_campionamento) && $anteprima == 1) ? $rdp_anteprima->area_di_campionamento : ($campioni->where('tipoCamp','S')->first() != null ? ($campioni->where('tipoCamp','S')->first()->tipoCampione == 'piastra' ? '24 cm²' : '100 cm²') : '/')  }}" readonly>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-striped table-hover dataTable js-exportable campionamenti_table" id="rapporto_di_prova1" role="grid" aria-describedby="DataTables_Table_1_info"cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="">Monitoraggio di</th>
                    <th class="">Microrganismi totali a 30°C</th>
                    <th class="">Lieviti e muffe</th>
                </tr>
            </thead>
            @php $tipo_di_substrato = tipo_di_substrato($campioni); @endphp
            @php $condizione_e_durata = format_condizioni_durata_incubazione($tipo_di_substrato,$campioni); @endphp
            <tbody>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Tipo di substrato per la crescita</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="tipo_di_substrato_pca_2" class="form-control"   value="{{ (isset($rdp_anteprima->tipo_di_substrato_pca_2) && $anteprima == 1) ? $rdp_anteprima->tipo_di_substrato_pca_2 : (($tipo_di_substrato == 1 || $tipo_di_substrato == 3) ? 'PCA' : '/') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </td>
                    
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="tipo_di_substrato_dg18_2" class="form-control" value="{{ (isset($rdp_anteprima->tipo_di_substrato_dg18_2) && $anteprima == 1) ? $rdp_anteprima->tipo_di_substrato_dg18_2 : (($tipo_di_substrato == 2 || $tipo_di_substrato == 3) ? 'DG18' : '/') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Condizioni e durata dell'incubazione</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="condizioni_durata_pca_2" class="form-control" value="{{ (isset($rdp_anteprima->condizioni_durata_pca_2) && $anteprima == 1) ? $rdp_anteprima->condizioni_durata_pca_2 : (($tipo_di_substrato == 1 || $tipo_di_substrato == 3) ? $condizione_e_durata['pca'] : '/') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px;" name="condizioni_durata_dg18_2" class="form-control" value="{{ (isset($rdp_anteprima->condizioni_durata_dg18_2) && $anteprima == 1) ? $rdp_anteprima->condizioni_durata_dg18_2 : (($tipo_di_substrato == 2 || $tipo_di_substrato == 3) ? $condizione_e_durata['dg18'] : '/') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>                
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Descrizione e punto di campionamento</b></td>
                    @php $punti_camp_pca_1 = get_punti_campionamento_superficie($campioni,'PCA',1) @endphp
                    @php $punti_camp_dg18_1 = get_punti_campionamento_superficie($campioni,'DG18',1) @endphp
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="descrizione_punto_pca_3" class="form-control" value="{{ (isset($rdp_anteprima->descrizione_punto_pca_3) && $anteprima == 1) ? $rdp_anteprima->descrizione_punto_pca_3 : (($tipo_di_substrato == 1 || $tipo_di_substrato == 3) ? $punti_camp_pca_1 : '/') }}" {{ ($tipo_di_substrato != 1 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="descrizione_punto_dg18_3" class="form-control" value="{{ (isset($rdp_anteprima->descrizione_punto_dg18_3) && $anteprima == 1) ? $rdp_anteprima->descrizione_punto_dg18_3 : (($tipo_di_substrato == 2 || $tipo_di_substrato == 3) ? $punti_camp_dg18_1 : '/') }}" {{ ($tipo_di_substrato != 2 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Numero prelievi per punto</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="n_prelievi_pca_3" class="form-control" value="{{ (isset($rdp_anteprima->n_prelievi_pca_3) && $anteprima == 1) ? $rdp_anteprima->n_prelievi_pca_3 : (($tipo_di_substrato == 1 || $tipo_di_substrato == 3) ? '' : '/') }}" {{ ($tipo_di_substrato != 1 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;"  name="n_prelievi_dg18_3" class="form-control" value="{{ (isset($rdp_anteprima->n_prelievi_dg18_3) && $anteprima == 1) ? $rdp_anteprima->n_prelievi_dg18_3 : (($tipo_di_substrato == 2 || $tipo_di_substrato == 3) ? '' : '/') }}" {{ ($tipo_di_substrato != 2 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @php $punti_camp_pca_2 = get_punti_campionamento_superficie($campioni,'PCA',2) @endphp
                @php $punti_camp_dg18_2 = get_punti_campionamento_superficie($campioni,'DG18',2) @endphp
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Descrizione e punto di campionamento</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="descrizione_punto_pca_4" class="form-control" value="{{ (isset($rdp_anteprima->descrizione_punto_pca_4) && $anteprima == 1) ? $rdp_anteprima->descrizione_punto_pca_4 : (($tipo_di_substrato == 1 || $tipo_di_substrato == 3) ? $punti_camp_pca_2 : '/') }}" {{ ($tipo_di_substrato != 1 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="descrizione_punto_dg18_4" class="form-control" value="{{ (isset($rdp_anteprima->descrizione_punto_dg18_4) && $anteprima == 1) ? $rdp_anteprima->descrizione_punto_dg18_4 : (($tipo_di_substrato == 2 || $tipo_di_substrato == 3) ? $punti_camp_dg18_2 : '/') }}" {{ ($tipo_di_substrato != 2 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Numero prelievi per punto</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="n_prelievi_pca_4" class="form-control" value="{{ (isset($rdp_anteprima->n_prelievi_pca_4) && $anteprima == 1) ? $rdp_anteprima->n_prelievi_pca_4 : (($tipo_di_substrato == 1 || $tipo_di_substrato == 3) ? '' : '/') }}" {{ ($tipo_di_substrato != 1 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="n_prelievi_dg18_4" class="form-control" value="{{ (isset($rdp_anteprima->n_prelievi_dg18_4) && $anteprima == 1) ? $rdp_anteprima->n_prelievi_dg18_4 : (($tipo_di_substrato == 2 || $tipo_di_substrato == 3) ? '' : '/') }}" {{ ($tipo_di_substrato != 2 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><b>Note</b></td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="note_pagina2_3" class="form-control" value="{{ (isset($rdp_anteprima->note_pagina2_3) && $anteprima == 1) ? $rdp_anteprima->note_pagina2_3 : (($tipo_di_substrato == 1 || $tipo_di_substrato == 3) ? '' : '/') }}" {{ ($tipo_di_substrato != 1 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="text" style="padding-left: 5px; 20px; border-radius: 4px; background-image: none; border: 1px solid #ccc; line-height: 1.42857143;" name="note_pagina2_4" class="form-control" value="{{ (isset($rdp_anteprima->note_pagina2_4) && $anteprima == 1) ? $rdp_anteprima->note_pagina2_4 : (($tipo_di_substrato == 2 || $tipo_di_substrato == 3) ? '' : '/') }}" {{ ($tipo_di_substrato != 2 && $tipo_di_substrato != 3) ? 'readonly' : ''  }}>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>