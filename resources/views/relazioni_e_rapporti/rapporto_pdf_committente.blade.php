<!DOCTYPE html>
<html>
<head>
    
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta content="charset=iso-8859-1">
	<title style="text-transform: capitalize">Rapporto di prova</title>
	<!-- Favicon-->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <style>
        /** Define the margins of your page **/
        
        /* not overlapping header and footer with content of page*/
        @page {
            margin: 1.25cm 2cm 0.77cm 2cm;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
        .riferimenti {
            page-break-after: always;
        }
        .break {
            page-break-before: always;
            margin-top: 3.5cm;
        }

        /* Nella prima pagine non effettuo il break */
        .break:first-of-type {
            page-break-before: avoid;
        }

        table { overflow: visible !important; }
        thead { display: table-header-group }
        tfoot { display: table-row-group }
        tr { page-break-inside: avoid  }

        body {
            padding-top: 1em;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 11px;
        }

        table {
            page-break-inside: avoid !important;
        }

        table tr {
            page-break-inside: avoid;
        }
        table tr td {
            page-break-inside: avoid;
        }

        header {
            position: fixed;
            top: 0;
            left: 0px;
            right: 0px;
            margin-bottom: 2.5cm;
        }
        footer {
            position: fixed; 
            bottom: 0; 
            height: 172px;
            margin-top: auto;
        }

    
        h2 {
            font-weight: normal;
        }

        .firmaDirettore {
            margin-left: 12cm;
            margin-top: 0px;
            margin-bottom: 5px;
            width: 5cm;
            height: 1cm;
        }

        .firmaResponsabile {
            margin-left: 12cm;
            margin-top: 0px;
            margin-bottom: 5px;
            width: 5cm;
            height: 1cm;
        }

        /*----------*/
        span {
            word-spacing: normal;
        }

        .font14 {
            font-size: 14px;
        }

        .title{
            text-align: center;
            font-size: 20px;
        }
        

        /*Pagina 2*/

        .col1 {
            width: 200px;
        }

        .tabellaGridPage2{
            border:solid 1px; 
            border-collapse: collapse;
            font: 11px;
        }

        /*Pagina 3-4*/
        .col1_page3 {
            width: 130px;
        }  

        .coln_page3 {
            width: 70px;
            text-align: center;
        }

        .tabellaGridPage3-4{
            border:solid 1px; 
            border-collapse: collapse;
            font: 11px;
        }

        /***/
+
        /*Pagina 6*/
        .col1_page6 {
            /* width: 100px; */
            text-align: left;
        }

        .coln_page6 {
            /* width: 170px; */
            text-align: center;
        }

        .tabellaGridPage6{
            border:solid 1px; 
            border-collapse: collapse;
            font: 11px;
        }

        /*Pagina 7*/
        .coln_page7 {
            /* width: 170px; */
            text-align: center;
        }

        .tabellaGridPage7{
            border:solid 1px; 
            border-collapse: collapse;
            font: 11px;
        }

        .tfooterborder {
            border: hidden;
        }

        td {
            vertical-align:top;
        }
        tr {
            margin-bottom: 3cm;
        }

        .caption {
            display: block;
            text-align: left;
            width: 167px;
            margin-left: 140px;
        }

        table tfoot {
            border: 1px #ffffff;
        }

        #page1{
            font-size: 14px;
        }

        #page15{
            font-size: 14px;
        }


    </style>
</head>
<body>
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_text(507, 775, "Pag. {PAGE_NUM} di {PAGE_COUNT}", 'calibri', 6, array(0, 0, 0));
        }
    </script>
    <header id="header">
        <table style="width: 100%; margin-bottom:1cm;" >
            <thead>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: left;">
                        <img src="{{ public_path('/images/rapporto_di_prova/cias_unife.jpg') }}" width="158px" height="101">
                    </td>
                    <td class="item" style="text-align: right;">
                        <figure class="item">
                            <img src="{{ public_path('/images/rapporto_di_prova/accredia_o.jpg') }}" width="167px" height="48px">
                            <figcaption class="caption"> <span class="caption" style="font-size: 5px">LAB N° 1767 L<br>

                                Membro degli Accordi di Mutuo Riconoscimento<br>
                                EA, IAF e ILAC<br>
        
                                Signatory of EA, IAF and ILAC<br>
                                Mutual Recognition Agreements<br></span></figcaption>

                        </figure>
                        
                    </td>
                </tr>
            </tbody>
        </table>
    </header>

    <footer>
        <br>
        <div>
            {{-- <hr style="border 1px solid black"> --}}
           
            <span style="font-size:8px">
                Il laboratorio si assume la responsabilità di tutte le informazioni presenti nel Rapporto di Prova ad eccezione di quelle fornite dal committente. I risultati riportati nel seguente RDP si riferiscono al campione così come ricevuto. <br>
                Il presente Rapporto è generato elettronicamente solo dopo la validazione dei risultati da parte del Laboratorio. Gli originali firmati sono conservati presso il laboratorio. Ogni prelievo è completo di foto delle piastre consultabili su richiesta del committente. I Risultati contenuti nel presente rapporto si riferiscono esclusivamente al/i campione/i provato/i. Il presente rapporto non può essere riprodotto parzialmente, salvo approvazione scritta del laboratorio.<br>
                (1) L'incertezza di misura è calcolata in accordo alla norma ISO 19036 moltiplicando lo scarto tipo di riproducibilità intralaboratorio per un fattore di copertura k = 2, che dà un livello di fiducia del 95%.<br>
                NA = Non Applicato, NR/R = Non rilevato/Rilevato
            </span>
        </div>
        <br>
        <table style="width: 100%; margin-left: 0cm;">
            <thead>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: left; font-size: 9px;">
                        MOD 02 PR_G_03 RDP Rev. 0_30-06-2022
                    </td>
                    <td  style="text-align: right; font-size: 9px">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RDP n.{{ $num_rdp . "_".Carbon\Carbon::now()->format('d-m-Y') . " "}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
            </tbody>
        </table>
        <p style="font-size: 8px">
            <b>Laboratorio Interdipartimentale dell'Università degli Studi di Ferrara</b><br>
            Dipartimento di Architettura | via Ghiara 36 | 44121 Ferrara | 0532.293605 | mzs@unife.it<br>
            Dipartimento di scienze chimiche e farmaceutiche | via Luigi Borsari 46 | 44121 Ferrara<br>
            Laboratorio Tecnopolo | Via Saragat 13 | 44122 Ferrara | 0532.293658 | cias@unife.it | www.cias-ferrara.it<br>
        </p>
    </footer>

    <main>
        <!-- Pagina 1 -->
        <div class="page break" id="page1">
            @if($rev_precedente != 0 && $rapprel_da_correggere != "" && $rapprel_da_correggere != null)
            <div style="text-align:center;">
                <p>
                    Il presente Rapporto di Prova annulla e sostituisce il Rapporto di Prova n. {{ explode('-',explode('_',$num_rdp)[0])[0] . "_".Carbon\Carbon::parse($rapprel_da_correggere->data_generazione)->format('d-m-Y')  }}
                </p>
            </div>
            @endif
            <div style="text-align:center;">
                    <h2>RAPPORTO DI PROVA</h2>
                    <h4 style="margin-bottom: 0cm; padding-bottom: 0cm;">n. {{ $num_rdp . "_".Carbon\Carbon::now()->format('d-m-Y')  }}</h4>
            </div>
            
            <table style="margin-top: 0cm; padding-top: 0cm; border-collapse: separate; border-spacing:0.5cm;">
                <thead>
                    <tr>
                        <th class="hidden"></th>
                        <th class="hidden"></th>  
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><i>Nome e indirizzo del Laboratorio</i></td>
                        <td>
                                <span style="text-transform: uppercase"><b>cias</b></span><br>
                                <b>Centro ricerche inquinamento fisico chimico microbiologico Ambienti alta Sterilità.</b><br>
                                <u>Sede legale:</u> Univeristà degli studi di Ferrara, Via Ariosto 35, 44121 Ferrara.<br>
                                Tel: +39 0532.293111 e-mail: <u>ateneo@pec.unife.it</u><br>
                                <u>Sede amministrativa:</u> Via Saragat 13, 44122 Ferrara<br>
                                Tel: +39 0532.293658 e-mail: <u>cias@unife.it</u> web: wwww.cias-ferrara.it        
                        </td>
                    </tr>
                    <tr>
                        <td><i>Committente</i></td>
                        <td><i>{{ $nome_cliente }}</i><br>
                            {{ $indirizzo_cliente }}</td>
                            <br><br>
                    </tr>
                    <tr>
                        <td><i>Luogo di campionamento</i></td>
                        <td><i>{{ $struttura_partizione }}</b>
                            {{$indirizzo_struttura}}</td>
                        <br><br>
                    </tr>
                    <tr>
                        <td><i>Modulo di accettazione di riferimento</i></td>
                        <td>
                            {{ $modulo_di_accettazione }}
                        </td>
                        <br><br>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagina 2 --> 
        <div class="page break" id="page2">           
            <table class="tabellaGridPage2" style="width: 100%;">
                <thead>
                    <tr>
                        <th colspan="2" class="tabellaGridPage2" style="text-align: left; background-color: grey;">Campionamento a carico del committente</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="tabellaGridPage2 col1">
                        <td class="tabellaGridPage2"><b>Incaricati del campionamento</b></td>
                        <td class="tabellaGridPage2">
                            {{ $incaricati_del_campionamento }}
                        </td>
                    </tr>
                    <tr class="tabellaGridPage2">
                        <td class="tabellaGridPage2 col1"><b>Data campionamento</b></td>
                        <td class="tabellaGridPage2">
                            da  {{  $data_campionamento_inizio }} a {{ $data_campionamento_fine }}
                        </td>
                    </tr>
                    <tr class="tabellaGridPage2">
                        <td class="tabellaGridPage2 col1"><b>Inizio campionamento</b></td>
                        <td class="tabellaGridPage2">
                            {{ $ora_inizio }} del {{ $data_inizio }}
                        </td>
                    </tr>
                    <tr class="tabellaGridPage2">
                        <td class="tabellaGridPage2 col1"><b>Fine campionamento</b></td>
                        <td class="tabellaGridPage2">
                            {{ $ora_fine }} del {{ $data_fine }}
                        </td>
                    </tr>
                    <tr class="tabellaGridPage2">
                        <td class="tabellaGridPage2 col1"><b>Elenco dei campioni</b></td>
                        <td class="tabellaGridPage2">
                            <table class="tabellaGridPage2" style="border: none; width: 100%;">
                                <thead class="tabellaGridPage2">
                                    <tr class="tabellaGridPage2">
                                        <th class="tabellaGridPage2" style="text-align: center;">Codice campione</th>
                                        <th class="tabellaGridPage2" style="text-align: center;">Terreno/fornitore</th>
                                        <th class="tabellaGridPage2" style="text-align: center;">Lotto</th>
                                        <th class="tabellaGridPage2" style="text-align: center;">Scadenza</th>
                                    </tr>
                                </thead>
                                <tbody class="tabellaGridPage2">
                                    @php $numero_campione = 1; @endphp
                                    @foreach($elenco_campioni as $c)
                                    <tr class="tabellaGridPage2">
                                        <td class="tabellaGridPage2">{{ $numero_campione < 10 ? "0".$numero_campione : $numero_campione }}</td>
                                        <td class="tabellaGridPage2">{{ $c['terreno_fornitore'] }}</td>
                                        <td class="tabellaGridPage2">{{ $c['lotto'] }}</td>
                                        <td class="tabellaGridPage2">{{ $c['scadenza'] }}</td>
                                    </tr>
                                    @php $numero_campione++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>  
            </table>
            <br>   
            <table class="tabellaGridPage3-4" style="width: 100%; margin-top: 3cm;">
                <thead>
                    <tr class="tabellaGridPage3-4">
                        <th class="tabellaGridPage3-4" colspan="6" style="background-color: rgb(189, 183, 183); text-align:left;">NOTE DI CAMPIONAMENTO A CARICO DEL COMMITTENTE<br>
                            Descrizione del luogo di campionamento incluse le eventuali attività generanti aerosol
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Tipo di ambiente</b></td>
                        @php $counter = 1; @endphp
                        @foreach($tipo_di_ambiente as $t)
                            @if($counter <= 5)
                                <td class="tabellaGridPage3-4 coln_page3">
                                    {{ $t ?? '/' }}
                                </td>
                                @php $counter++ @endphp
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Numero e codifica locali</b></td>
                        @php $counter = 1; @endphp
                        @foreach($numero_e_codifica_locali as $ncl)
                            @if($counter <= 5)
                                <td class="tabellaGridPage3-4 coln_page3">
                                    {{ $ncl ?? '/' }}
                                    {{ $codice_partizione_stanza[$ncl] ?? '' }}
                                </td>
                                @php $counter++ @endphp
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Classe ISO di Riferimento</b></td>
                        @php $counter = 1; @endphp
                        @foreach($class_iso_di_riferimento as $cir)
                            @if($counter <= 5)
                                <td class="tabellaGridPage3-4 coln_page3">
                                    {{ $cir ?? '/' }}
                                </td>
                                @php $counter++ @endphp
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Tipo di flusso</b></td>
                        @php $counter = 1; @endphp
                        @foreach($tipo_di_flusso as $tf)
                            @if($counter <= 5)
                                <td class="tabellaGridPage3-4 coln_page3">
                                    {{ $tf ?? '/' }}
                                </td>
                                @php $counter++ @endphp
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Note</b></td>
                        @php $counter = 1; @endphp
                        @foreach($note_pagina3 as $n)
                            @if($counter <= 5)
                                <td class="tabellaGridPage3-4 coln_page3">
                                    {{ $n ?? '/' }}
                                </td>
                                @php $counter++ @endphp
                            @endif
                        @endforeach
                    </tr>
                </tbody>
                <!-- at rest -->
                <thead>
                    <tr>
                        <th colspan="6" style="background-color: rgb(189, 183, 183); text-align:left;">Campionamento aria
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Stato di occupazione</b></td>
                        @php $counter = 1; @endphp
                        @foreach($stato_di_occupazione_aria_at_rest as $s)
                        @if($counter <= 5)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $s ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>N. Persone presenti</b></td>
                        @php $counter = 1; @endphp
                        @foreach($n_persone_presenti_aria_at_rest as $np)
                        @if($counter <= 5)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $np ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Stato porte</b></td>
                        @php $counter = 1; @endphp
                        @foreach($stato_porte_aria_at_rest as $sp)
                        @if($counter <= 5)
                            <td class="tabellaGridPage3-4 coln_page3">
                            {{ $sp ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Campionamento effettuato da</b></td>
                        @php $counter = 1; @endphp
                        @foreach($campionamento_effettuato_da_aria_at_rest as $ced)
                        @if($counter <= 5)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $ced ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Note</b></td>
                        @php $counter = 1; @endphp
                        @foreach($note_pagina3_aria_at_rest as $n)
                        @if($counter <= 5)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $n ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        @for($i=0; $i<4; $i++)
                        <td style="height: 20px;"></td>
                        @endfor
                    </tr>
                    <!-- operational -->
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Stato di occupazione</b></td>
                        @php $counter = 1; @endphp
                        @foreach($stato_di_occupazione_aria_operat as $s)
                        @if($counter <= 5)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $s ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>N. Persone presenti</b></td>
                        @php $counter = 1; @endphp
                        @foreach($n_persone_presenti_aria_operat as $np)
                        @if($counter <= 5)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $np ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Stato porte</b></td>
                        @php $counter = 1; @endphp
                        @foreach($stato_porte_aria_operat as $s)
                        @if($counter <= 5)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $s ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Campionamento effettuato da</b></td>
                        @php $counter = 1; @endphp
                        @foreach($campionamento_effettuato_da_aria_operat as $ce)
                        @if($counter <= 5)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $ce ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Note</b></td>
                        @php $counter = 1; @endphp
                        @foreach($note_pagina3_aria_operat as $n)
                        @if($counter <= 5)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $n ?? '/'  }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <table class="tabellaGridPage3-4" style="width: 100%;">
                <!-- Superifici -->
                <thead>
                    <tr> 
                        <th colspan="6" style="background-color: rgb(189, 183, 183); text-align:left;">Campionamento superfici
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Stato di occupazione</b></td>
                        @php $counter = 1; @endphp
                        @foreach($stato_di_occupazione_superfici as $s)
                        @if($counter <= 5)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $s ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>N. Persone presenti</b></td>
                        @php $counter = 1; @endphp
                        @foreach($n_persone_presenti_superfici as $np)
                        @if($counter <= 5)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $np ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Stato porte</b></td>
                        @php $counter = 1; @endphp
                        @foreach($stato_porte_superfici as $sps)
                        @if($counter <= 5)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $sps ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Campionamento effettuato da</b></td>
                        @php $counter = 1; @endphp
                        @foreach($campionamento_effettuato_da_superfici as $ces)
                        @if($counter <= 5)
                            <td class="tabellaGridPage3-4 coln_page3">
                            {{ $ces ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Note</b></td>
                        @php $counter = 1; @endphp
                        @foreach($note_pagina3_superfici as $n)
                        @if($counter <= 5)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $n ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        @if($numero_colonne > 5)
        <div class="page break" id="page2">            
            <table class="tabellaGridPage3-4" style="width: 100%;">
                <thead>
                    <tr class="tabellaGridPage3-4">
                        <th class="tabellaGridPage3-4" colspan="6" style="background-color: rgb(189, 183, 183); text-align:left;">NOTE DI CAMPIONAMENTO A CARICO DEL COMMITTENTE<br>
                            Descrizione del luogo di campionamento incluse le eventuali attività generanti aerosol
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Tipo di ambiente</b></td>
                        @php $counter = 6; @endphp
                        @foreach($tipo_di_ambiente as $t)
                            @if($counter <= $numero_colonne)
                                <td class="tabellaGridPage3-4 coln_page3">
                                    {{ $t ?? '/' }}
                                </td>
                                @php $counter++ @endphp
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Numero e codifica locali</b></td>
                        @php $counter = 6; @endphp
                        @foreach($numero_e_codifica_locali as $ncl)
                            @if($counter <= $numero_colonne)
                                <td class="tabellaGridPage3-4 coln_page3">
                                    {{ $ncl ?? '/' }}
                                    {{ $codice_partizione_stanza[$ncl] ?? '' }}
                                </td>
                                @php $counter++ @endphp
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Classe ISO di Riferimento</b></td>
                        @php $counter = 6; @endphp
                        @foreach($class_iso_di_riferimento as $cir)
                            @if($counter <= $numero_colonne)
                                <td class="tabellaGridPage3-4 coln_page3">
                                    {{ $cir ?? '/' }}
                                </td>
                                @php $counter++ @endphp
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Tipo di flusso</b></td>
                        @php $counter = 6; @endphp
                        @foreach($tipo_di_flusso as $tf)
                            @if($counter <= $numero_colonne)
                                <td class="tabellaGridPage3-4 coln_page3">
                                    {{ $tf ?? '/' }}
                                </td>
                                @php $counter++ @endphp
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Note</b></td>
                        @php $counter = 6; @endphp
                        @foreach($note_pagina3 as $n)
                            @if($counter <= $numero_colonne)
                                <td class="tabellaGridPage3-4 coln_page3">
                                    {{ $n ?? '/' }}
                                </td>
                                @php $counter++ @endphp
                            @endif
                        @endforeach
                    </tr>
                </tbody>
                <!-- at rest -->
                <thead>
                    <tr>
                        <th colspan="6" style="background-color: rgb(189, 183, 183); text-align:left;">Campionamento aria
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Stato di occupazione</b></td>
                        @php $counter = 6; @endphp
                        @foreach($stato_di_occupazione_aria_at_rest as $s)
                        @if($counter <= $numero_colonne)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $s ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>N. Persone presenti</b></td>
                        @php $counter = 6; @endphp
                        @foreach($n_persone_presenti_aria_at_rest as $np)
                        @if($counter <= $numero_colonne)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $np ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Stato porte</b></td>
                        @php $counter = 6; @endphp
                        @foreach($stato_porte_aria_at_rest as $sp)
                        @if($counter <= $numero_colonne)
                            <td class="tabellaGridPage3-4 coln_page3">
                            {{ $sp ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Campionamento effettuato da</b></td>
                        @php $counter = 6; @endphp
                        @foreach($campionamento_effettuato_da_aria_at_rest as $ced)
                        @if($counter <= $numero_colonne)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $ced ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Note</b></td>
                        @php $counter = 6; @endphp
                        @foreach($note_pagina3_aria_at_rest as $n)
                        @if($counter <= $numero_colonne)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $n ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        @for($i=0; $i<4; $i++)
                        <td style="height: 20px;"></td>
                        @endfor
                    </tr>
                    <!-- operational -->
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Stato di occupazione</b></td>
                        @php $counter = 6; @endphp
                        @foreach($stato_di_occupazione_aria_operat as $s)
                        @if($counter <= $numero_colonne)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $s ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>N. Persone presenti</b></td>
                        @php $counter = 6; @endphp
                        @foreach($n_persone_presenti_aria_operat as $np)
                        @if($counter <= $numero_colonne)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $np ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Stato porte</b></td>
                        @php $counter = 6; @endphp
                        @foreach($stato_porte_aria_operat as $s)
                        @if($counter <= $numero_colonne)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $s ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Campionamento effettuato da</b></td>
                        @php $counter = 6; @endphp
                        @foreach($campionamento_effettuato_da_aria_operat as $ce)
                        @if($counter <= $numero_colonne)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $ce ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Note</b></td>
                        @php $counter = 6; @endphp
                        @foreach($note_pagina3_aria_operat as $n)
                        @if($counter <= $numero_colonne)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $n ?? '/'  }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <table class="tabellaGridPage3-4" style="width: 100%; margin-top: 3cm;">
                <!-- Superifici -->
                <thead>
                    <tr>
                        <th colspan="6" style="background-color: rgb(189, 183, 183); text-align:left;">Campionamento superfici
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Stato di occupazione</b></td>
                        @php $counter = 6; @endphp
                        @foreach($stato_di_occupazione_superfici as $s)
                        @if($counter <= $numero_colonne)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $s ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>N. Persone presenti</b></td>
                        @php $counter = 6; @endphp
                        @foreach($n_persone_presenti_superfici as $np)
                        @if($counter <= $numero_colonne)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $np ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Stato porte</b></td>
                        @php $counter = 6; @endphp
                        @foreach($stato_porte_superfici as $sps)
                        @if($counter <= $numero_colonne)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $sps ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Campionamento effettuato da</b></td>
                        @php $counter = 6; @endphp
                        @foreach($campionamento_effettuato_da_superfici as $ces)
                        @if($counter <= $numero_colonne)
                            <td class="tabellaGridPage3-4 coln_page3">
                            {{ $ces ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td class="tabellaGridPage3-4 col1_page3"><b>Note</b></td>
                        @php $counter = 6; @endphp
                        @foreach($note_pagina3_superfici as $n)
                        @if($counter <= $numero_colonne)
                            <td class="tabellaGridPage3-4 coln_page3">
                                {{ $n ?? '/' }}
                            </td>
                            @php $counter++ @endphp
                        @endif
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
        @endif


        <!-- planimetria -->
        @php $counter_pagina5 = 0; @endphp
        @if(count($planimetria) != 0 || $planimetria != null)
            @php Log::info($planimetria) @endphp
            @php Log::info($caption) @endphp
            @php $last_image = 0; @endphp
            @php $counter = 0; @endphp
            @foreach($planimetria as $value)
                @php $last_image++; @endphp 
                @if($last_image != (count($planimetria)))    
                    <div class="page break" id="page5_{{ $counter_pagina5++ }}">    
                        <table style="width: 100%;">
                            <thead>
                                <th class="hidden"></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="{{ $value }}" width="100%">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @if(count($caption) != 0 || $caption != null)
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <p>
                                    <b>{{ $caption[$counter+1] }}</b>
                                    @php $counter++ @endphp
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                @else
                <div class="page break" id="page5_{{ $counter_pagina5++ }}">  
                    <table style="width: 100%;">
                        <thead>
                            <th class="hidden"></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img src="{{ $planimetria[$counter] }}" width="100%">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @if(count($caption) != 0 || $caption != null)
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <p>
                                <b>{{ $caption[$counter+1] }}</b>
                            </p>
                        </div>
                    </div>
                    @endif
                    <table class="tabellaGridPage3-4" style="width: 100%;">
                        <!-- Superifici -->
                        <thead>
                            <tr>
                                <th colspan="2" style="background-color: rgb(189, 183, 183); text-align:left;">VALUTAZIONE DEI CAMPIONI DA PARTE DEL LABORATORIO IN FASE DI ACCETTAZIONE
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="tabellaGridPage3-4 col1_page3"><b>Temperatura</b></td>
                                <td class="tabellaGridPage3-4 coln_page3">
                                    {{ "°C $temperatura" ?? '/' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="tabellaGridPage3-4 col1_page3"><b>Stato materiale</b></td>
                                <td class="tabellaGridPage3-4 coln_page3">
                                    {{ $stato_materiale  ?? '/' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="tabellaGridPage3-4 col1_page3"><b>Data Accettazione</b></td>
                                <td class="tabellaGridPage3-4 coln_page3">
                                    {{ $data_accettazione ?? '/' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="tabellaGridPage3-4 col1_page3"><b>Note</b></td>
                                <td class="tabellaGridPage3-4 coln_page3">
                                    {{ $note_pagina5 ?? '/' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif
            @endforeach
        @endif

        <!-- Pagina 7 -->
        @php $check = 0; @endphp
        @foreach($tipi_di_campioni as $t)
            @if($t != 0)
                @php $check = 1; @endphp
            @endif
        @endforeach
        @if($check == 1)
        <div class="page break" id="page7">
            <div style="text-align:center;">
                <div >
                    <h3>Schede di rilevazione e registrazione</h3><br>
                </div>
            </div>
            
            <table class="tabellaGridPage6" style="width: 100%;">
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

            @php $inseriti = 0; @endphp
            @foreach($tipi_di_campioni as $tipo => $inserito)
                @if($inserito == 1)
                    @if($tipo == '_pca_at_rest_attivo')
                        @if($inseriti == 0)
                        <table class="tabellaGridPage6" style="margin-top: 0.5cm; width: 100%;">
                        @else
                        <table class="tabellaGridPage6" style="margin-top: 3cm; width: 100%;">
                        @endif
                            <thead>
                                <tr>
                                    <th style="text-align: left;" class="tabellaGridPage6" colspan="6">
                                        <b>Data e ora inizio incubazione:</b>{{ $dataOraInizioIncubazioneAria["dataOraInizioIncubazione$tipo"] }}<br>
                                        <b>Data e ora fine incubazione: </b>{{ $dataOraFineIncubazioneAria["dataOraFineIncubazione$tipo"] }}
                                    </th>
                                </tr>
                                <tr>
                                    <th style="text-align: left;" class="tabellaGridPage6" colspan="6">
                                        <b>Metodo:</b>{{ $metodoAria["metodo$tipo"] }} <br>
                                        <b>Denominazione della prova:</b> {{ $descrizioneMetodoAria["descrizione_metodo$tipo"] }} <br>
                                        <b>Tecnico incaricato dell'analisi:</b> {{ $tecnicoAria["tecnico$tipo"] }}
                                    </th>
                                </tr>
                                <tr>
                                    <th class="tabellaGridPage6" style="width: 80px;">
                                        <b>Campione N.</b>
                                    </th>
                                    <th class="tabellaGridPage6">
                                        <b>Codice campione</b>
                                    </th>
                                    <th class="tabellaGridPage6">
                                        <b>Punto di campionamento</b>
                                    </th>
                                    <th class="tabellaGridPage6" style="width: 40px;">
                                        {{-- <b>CFU/m &#179;</b> --}}
                                        <b>CFU/m&#179;</b>
                                    </th>
                                    <th class="tabellaGridPage6" style="width: 40px">
                                        <b>U(¹)</b>
                                    </th>
                                    <th class="tabellaGridPage6">
                                        <b>Valori di riferimento</b><span style="font-size: 9px"> (§)</span> <b> CFU/m&#179;</b>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($campioni_analizzati_con_piastra_aria as $tipo_campione => $value)
                                    @if($tipo_campione == $tipo)
                                        @foreach ($value as $item)
                                            <tr class="tabellaGridPage7">
                                                <td class="coln_page7 tabellaGridPage7">
                                                    {{ $item['id_campione'] }}
                                                </td>
                                                <td class="coln_page7 tabellaGridPage7">
                                                    {{ $item['codice_cias'] }}
                                                </td>
                                                <td class="coln_page7 tabellaGridPage7">
                                                    {{ $item['punto_camp'] }}
                                                </td>
                                                <td class="coln_page7 tabellaGridPage7">
                                                    {{ $item['CFU'] }}
                                                </td>
                                                <td class="coln_page7 tabellaGridPage7">
                                                    {{ $item['U'] }}
                                                </td>
                                                <td class="coln_page7 tabellaGridPage7 let">
                                                   {{-- <span style="font-family: DejaVu Sans;">&le;</span>{{ $item['valori_riferimento']}} --}}
                                                   {{ $item['valori_riferimento'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                            <!-- tfoot without border -->
                            <tfoot>
                                <tr>
                                    <td colspan="6" style="margin-left: 0; text-align:left; font-size: 9px;">
                                        (§) I valori di riferimento sono tratti dalle Linee Guida {{ $lineeGuidaAria[26] ?? ''}}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        @php $inseriti++; @endphp
                    @elseif($tipo == '_pca_at_rest_passivo')
                        <table class="tabellaGridPage6" style="margin-top: 3cm; width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align: left;" class="tabellaGridPage6" colspan="6">
                                        <b>Data e ora inizio incubazione:</b>{{ $dataOraInizioIncubazioneAria["dataOraInizioIncubazione$tipo"] }}<br>
                                        <b>Data e ora fine incubazione: </b>{{ $dataOraFineIncubazioneAria["dataOraFineIncubazione$tipo"] }}
                                    </th>
                                </tr>
                                <tr>
                                    <th style="text-align: left;" class="tabellaGridPage6" colspan="6">
                                        <b>Metodo:</b>{{ $metodoAria["metodo$tipo"] }} <br>
                                        <b>Denominazione della prova:</b> {{ $descrizioneMetodoAria["descrizione_metodo$tipo"] }} <br>
                                        <b>Tecnico incaricato dell'analisi:</b> {{ $tecnicoAria["tecnico$tipo"] }}
                                    </th>
                                </tr>
                                <tr>
                                    <th class="tabellaGridPage6" style="width: 80px;">
                                        <b>Campione N.</b>
                                    </th>
                                    <th class="tabellaGridPage6">
                                        <b>Codice campione</b>
                                    </th>
                                    <th class="tabellaGridPage6">
                                        <b>Punto di campionamento</b>
                                    </th>
                                    <th class="tabellaGridPage6" style="width: 40px;">
                                        {{-- <b>CFU/m &#179;</b> --}}
                                        <b>CFU/4h</b>
                                    </th>
                                    <th class="tabellaGridPage6" style="width: 40px;">
                                        <b>U(¹)</b>
                                    </th>
                                    <th class="tabellaGridPage6">
                                        <b>Valori di riferimento</b><span style="font-size: 6px;"> (§)</span> <b> CFU/m&#179;</b>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($campioni_analizzati_con_piastra_aria as $tipo_campione => $value)
                                    @if($tipo_campione == $tipo)
                                        @foreach ($value as $item)
                                            <tr class="tabellaGridPage7">
                                                <td class="coln_page7 tabellaGridPage7">
                                                    {{ $item['id_campione'] }}
                                                </td>
                                                <td class="coln_page7 tabellaGridPage7">
                                                    {{ $item['codice_cias'] }}
                                                </td>
                                                <td class="coln_page7 tabellaGridPage7">
                                                    {{ $item['punto_camp'] }}
                                                </td>
                                                <td class="coln_page7 tabellaGridPage7">
                                                    {{ $item['CFU'] }}
                                                </td>
                                                <td class="coln_page7 tabellaGridPage7">
                                                    {{ $item['U'] }}
                                                </td>
                                                <td class="coln_page7 tabellaGridPage7 let">
                                                    {{-- <span style="font-family: DejaVu Sans;">&le;</span> --}}
                                                    {{ $item['valori_riferimento'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" style="margin-left: 0; text-align:left; font-size: 9px;">
                                        (§) I valori di riferimento sono tratti dalle Linee Guida {{ $lineeGuidaAria[26] ?? ''}}
                                    </td>
                                </tr>
                            </tfoot>
                            {{-- <p style="font-size:10px; margin-left:2.3cm; margin-top:0cm">(§) I valori di riferimento sono tratti dalle Linee Guida {{ $lg ?? ''}}</p> --}}
                        </table>
                        @php $inseriti++; @endphp
                    @elseif($tipo == '_pca_operat_attivo')
                    @foreach($campioni_stanze_pca_attivo as $stanza => $lista_campioni_stanza)
                    <table class="tabellaGridPage6" style="margin-top: 3cm; width: 100%;">
                        <thead>
                            <tr>
                                <th style="text-align: left;" class="tabellaGridPage6" colspan="6">
                                    <b>Data e ora inizio incubazione:</b>{{ $dataOraInizioIncubazioneAria["dataOraInizioIncubazione$tipo"] }}<br>
                                    <b>Data e ora fine incubazione: </b>{{ $dataOraFineIncubazioneAria["dataOraFineIncubazione$tipo"] }}
                                </th>
                            </tr>
                            <tr>
                                <th style="text-align: left;" class="tabellaGridPage6" colspan="6">
                                    <b>Metodo:</b>{{ $metodoAria["metodo$tipo"] }} <br>
                                    <b>Denominazione della prova:</b> {{ $descrizioneMetodoAria["descrizione_metodo$tipo"] }} <br>
                                    <b>Tecnico incaricato dell'analisi:</b> {{ $tecnicoAria["tecnico$tipo"] }}
                                </th>
                            </tr>
                            <tr>
                                <th class="tabellaGridPage6" style="width: 80px;">
                                    <b>Campione N.</b>
                                </th>
                                <th class="tabellaGridPage6">
                                    <b>Codice campione</b>
                                </th>
                                <th class="tabellaGridPage6">
                                    <b>Punto di campionamento</b>
                                </th>
                                <th class="tabellaGridPage6" style="width: 40px;">
                                    {{-- <b>CFU/m &#179;</b> --}}
                                    <b>CFU/m&#179;</b>
                                </th>
                                <th class="tabellaGridPage6" style="width: 40px;">
                                    <b>U(¹)</b>
                                </th>
                                <th class="tabellaGridPage6">
                                    <b>Valori di riferimento</b><span style="font-size: 9px"> (§)</span> <b> CFU/m&#179;</b>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $media = 0; @endphp
                            @foreach($lista_campioni_stanza as $value)
                                <tr class="tabellaGridPage7">
                                    <td class="coln_page7 tabellaGridPage7">
                                        {{ $value['id_campione'] }}
                                    </td>
                                    <td class="coln_page7 tabellaGridPage7">
                                        {{ $value['codice_cias'] }}
                                    </td>
                                    <td class="coln_page7 tabellaGridPage7">
                                        {{ $value['punto_camp'] }}
                                    </td>
                                    <td class="coln_page7 tabellaGridPage7">
                                        {{ $value['CFU'] }}
                                    </td>
                                    <td class="coln_page7 tabellaGridPage7">
                                        {{ $value['U'] }}
                                    </td>
                                    <td class="coln_page7 tabellaGridPage7 let">
                                        {{-- <span style="font-family: DejaVu Sans;">&le;</span> --}}
                                        {{ $value['valori_riferimento'] }}
                                    </td>
                                </tr>
                                @php $num = $value['CFU'] == '< 1' ? 0 : $value['CFU'] @endphp
                                @php $media += $num; @endphp
                            @endforeach
                            @if(count($lista_campioni_stanza) > 1)
                            <tr class="tabellaGridPage7">
                                <td class="coln_page7 tabellaGridPage7" colspan="3" style="text-align: right;">
                                    <b>VALORE MEDIO</b> 
                                </td>
                                <td class="coln_page7 tabellaGridPage7" style="text-align: center;">
                                    @php Log::info($media); @endphp
                                    {{ round($media/count($lista_campioni_stanza)) }}
                                </td>
                                <td class="coln_page7 tabellaGridPage7" style="text-align: center;">
                                    <b>NA</b> 
                                </td>
                                <td class="coln_page7 tabellaGridPage7" style="text-align: center;">
                                    <b>{{$lista_campioni_stanza[0]['valori_riferimento']}}</b> 
                                </td>
                            </tr>                      
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" style="margin-left: 0; text-align:left; font-size: 9px;">
                                    (§) I valori di riferimento sono tratti dalle Linee Guida {{ $lineeGuidaAria[26] ?? ''}}
                                </td>
                            </tr>
                        </tfoot>
                        {{-- <p style="font-size:10px; margin-left:2.3cm; margin-top:0cm">(§) I valori di riferimento sono tratti dalle Linee Guida {{ $lg ?? ''}}</p> --}}
                    </table>
                    @php $inseriti++; @endphp
                    @endforeach
                    
                    @elseif($tipo == '_pca_operat_passivo')
                    @foreach($campioni_stanze_pca_passivo as $stanza => $lista_campioni_stanza)
                        <table class="tabellaGridPage6" style="margin-top: 3cm; width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align: left;" class="tabellaGridPage6" colspan="6">
                                        <b>Data e ora inizio incubazione:</b>{{ $dataOraInizioIncubazioneAria["dataOraInizioIncubazione$tipo"] }}<br>
                                        <b>Data e ora fine incubazione: </b>{{ $dataOraFineIncubazioneAria["dataOraFineIncubazione$tipo"] }}
                                    </th>
                                </tr>
                                <tr>
                                    <th style="text-align: left;" class="tabellaGridPage6" colspan="6">
                                        <b>Metodo:</b>{{ $metodoAria["metodo$tipo"] }} <br>
                                        <b>Denominazione della prova:</b> {{ $descrizioneMetodoAria["descrizione_metodo$tipo"] }} <br>
                                        <b>Tecnico incaricato dell'analisi:</b> {{ $tecnicoAria["tecnico$tipo"] }}
                                    </th>
                                </tr>
                                <tr>
                                    <th class="tabellaGridPage6" style="width: 80px;">
                                        <b>Campione N.</b>
                                    </th>
                                    <th class="tabellaGridPage6">
                                        <b>Codice campione</b>
                                    </th>
                                    <th class="tabellaGridPage6">
                                        <b>Punto di campionamento</b>
                                    </th>
                                    <th class="tabellaGridPage6" style="width: 40px;">
                                        {{-- <b>CFU/m &#179;</b> --}}
                                        <b>CFU/&#179;</b>
                                    </th>
                                    <th class="tabellaGridPage6" style="width: 40px;">
                                        <b>U(¹)</b>
                                    </th>
                                    <th class="tabellaGridPage6">
                                        <b>Valori di riferimento</b><span style="font-size: 9px"> (§)</span> <b> CFU/m&#179;</b>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $media = 0; @endphp
                                @foreach($lista_campioni_stanza as $value)
                                    <tr class="tabellaGridPage7">
                                        <td class="coln_page7 tabellaGridPage7">
                                            {{ $value['id_campione'] }}
                                        </td>
                                        <td class="coln_page7 tabellaGridPage7">
                                            {{ $value['codice_cias'] }}
                                        </td>
                                        <td class="coln_page7 tabellaGridPage7">
                                            {{ $value['punto_camp'] }}
                                        </td>
                                        <td class="coln_page7 tabellaGridPage7">
                                            {{ $value['CFU'] }}
                                        </td>
                                        <td class="coln_page7 tabellaGridPage7">
                                            {{ $value['U'] }}
                                        </td>
                                        <td class="coln_page7 tabellaGridPage7 let">
                                            {{-- <span style="font-family: DejaVu Sans;">&le;</span> --}}
                                            {{ $value['valori_riferimento'] }}
                                        </td>
                                    </tr> 
                                    @php $media += $value['CFU']; @endphp     
                                @endforeach
                                @if(count($lista_campioni_stanza) > 1)
                                <tr class="tabellaGridPage7">
                                    <td class="coln_page7 tabellaGridPage7" colspan="3" style="text-align: right;">
                                        <b>VALORE MEDIO</b> 
                                    </td>
                                    <td class="coln_page7 tabellaGridPage7" style="text-align: center;">
                                        {{ round($media/count($lista_campioni_stanza)) }}
                                    </td>
                                    <td class="coln_page7 tabellaGridPage7" style="text-align: center;">
                                        <b>NA</b> 
                                    </td>
                                    <td class="coln_page7 tabellaGridPage7" style="text-align: center;">
                                        <b>{{$lista_campioni_stanza[0]['valori_riferimento']}}</b> 
                                    </td>
                                </tr>                      
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" style="margin-left: 0; text-align:left; font-size: 9px;">
                                        (§) I valori di riferimento sono tratti dalle Linee Guida {{ $lineeGuidaAria[26] ?? ''}}
                                    </td>
                                </tr>
                            </tfoot>
                            {{-- <p style="font-size:10px; margin-left:2.3cm; margin-top:0cm">(§) I valori di riferimento sono tratti dalle Linee Guida {{ $lg ?? ''}}</p> --}}
                        </table>
                        @php $inseriti++; @endphp
                    @endforeach
                    @elseif($tipo == '_dg18_at_rest_attivo')
                    <table class="tabellaGridPage6" style="margin-top: 3cm; width: 100%;">
                        <thead>
                            <tr>
                                <th style="text-align: left;" class="tabellaGridPage6" colspan="6">
                                    <b>Data e ora inizio incubazione:</b>{{ $dataOraInizioIncubazioneAria["dataOraInizioIncubazione$tipo"] }}<br>
                                    <b>Data e ora fine incubazione: </b>{{ $dataOraFineIncubazioneAria["dataOraFineIncubazione$tipo"] }}
                                </th>
                            </tr>
                            <tr>
                                <th style="text-align: left;" class="tabellaGridPage6" colspan="6">
                                    <b>Metodo:</b>{{ $metodoAria["metodo$tipo"] }} <br>
                                    <b>Denominazione della prova:</b> {{ $descrizioneMetodoAria["descrizione_metodo$tipo"] }} <br>
                                    <b>Tecnico incaricato dell'analisi:</b> {{ $tecnicoAria["tecnico$tipo"] }}
                                </th>
                            </tr>
                            <tr>
                                <th class="tabellaGridPage6" style="width: 80px;">
                                    <b>Campione N.</b>
                                </th>
                                <th class="tabellaGridPage6">
                                    <b>Codice campione</b>
                                </th>
                                <th class="tabellaGridPage6">
                                    <b>Punto di campionamento</b>
                                </th>
                                <th class="tabellaGridPage6" style="width: 40px;">
                                    {{-- <b>CFU/m &#179;</b> --}}
                                    <b>CFU/m&#179;</b>
                                </th>
                                <th class="tabellaGridPage6" style="width: 40px;">
                                    <b>U(¹)</b>
                                </th>
                                <th class="tabellaGridPage6">
                                    <b>Valori di riferimento</b><span style="font-size: 9px"> (§)</span> <b>CFU/m&#179;</b>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($campioni_analizzati_con_piastra_aria as $tipo_campione => $value)
                                @foreach ($value as $item)
                                    @if($tipo_campione == $tipo)
                                        <tr class="tabellaGridPage7">
                                            <td class="coln_page7 tabellaGridPage7">
                                                {{ $item['id_campione'] }}
                                            </td>
                                            <td class="coln_page7 tabellaGridPage7">
                                                {{ $item['codice_cias'] }}
                                            </td>
                                            <td class="coln_page7 tabellaGridPage7">
                                                {{ $item['punto_camp'] }}
                                            </td>
                                            <td class="coln_page7 tabellaGridPage7">
                                                {{ $item['CFU'] }}
                                            </td>
                                            <td class="coln_page7 tabellaGridPage7">
                                                {{ $item['U'] }}
                                            </td>
                                            <td class="coln_page7 tabellaGridPage7 let">
                                                {{-- <span style="font-family: DejaVu Sans;">&le;</span> --}}
                                                {{ $item['valori_riferimento'] }}
                                            </td>
                                        </tr>
                                        @endif
                                @endforeach
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" style="margin-left: 0; text-align:left; font-size: 9px;">
                                    (§) I valori di riferimento sono tratti dalle Linee Guida {{ $lineeGuidaAria[26] ?? ''}}
                                </td>
                            </tr>
                        </tfoot>
                        {{-- <p style="font-size:10px; margin-left:2.3cm; margin-top:0cm">(§) I valori di riferimento sono tratti dalle Linee Guida {{ $lg ?? ''}}</p> --}}
                    </table>
                    @php $inseriti++; @endphp
                    @else
                    <table class="tabellaGridPage6" style="margin-top: 3cm; width: 100%;">
                        <thead>
                            <tr>
                                <th style="text-align: left;" class="tabellaGridPage6" colspan="6">
                                    <b>Data e ora inizio incubazione:</b>{{ $dataOraInizioIncubazioneAria["dataOraInizioIncubazione$tipo"] }}<br>
                                    <b>Data e ora fine incubazione: </b>{{ $dataOraFineIncubazioneAria["dataOraFineIncubazione$tipo"] }}
                                </th>
                            </tr>
                            <tr>
                                <th style="text-align: left;" class="tabellaGridPage6" colspan="6">
                                    <b>Metodo:</b>{{ $metodoAria["metodo$tipo"] }} <br>
                                    <b>Denominazione della prova:</b> {{ $descrizioneMetodoAria["descrizione_metodo$tipo"] }} <br>
                                    <b>Tecnico incaricato dell'analisi:</b> {{ $tecnicoAria["tecnico$tipo"] }}
                                </th>
                            </tr>
                            <tr>
                                <th class="tabellaGridPage6" style="width: 80px;">
                                    <b>Campione N.</b>
                                </th>
                                <th class="tabellaGridPage6">
                                    <b>Codice campione</b>
                                </th>
                                <th class="tabellaGridPage6">
                                    <b>Punto di campionamento</b>
                                </th>
                                <th class="tabellaGridPage6" style="width: 40px;">
                                    {{-- <b>CFU/m &#179;</b> --}}
                                    <b>CFU/4h</b>
                                </th>
                                <th class="tabellaGridPage6" style="width: 40px;">
                                    <b>U(¹)</b>
                                </th>
                                <th class="tabellaGridPage6">
                                    <b>Valori di riferimento</b><span style="font-size: 9px"> (§)</span> <b> CFU/4h</b>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($campioni_analizzati_con_piastra_aria as $tipo_campione => $value)
                                @foreach ($value as $item)
                                    @if($tipo_campione == $tipo)
                                        <tr class="tabellaGridPage7">
                                            <td class="coln_page7 tabellaGridPage7">
                                                {{ $item['id_campione'] }}
                                            </td>
                                            <td class="coln_page7 tabellaGridPage7">
                                                {{ $item['codice_cias'] }}
                                            </td>
                                            <td class="coln_page7 tabellaGridPage7">
                                                {{ $item['punto_camp'] }}
                                            </td>
                                            <td class="coln_page7 tabellaGridPage7">
                                                {{ $item['CFU'] }}
                                            </td>
                                            <td class="coln_page7 tabellaGridPage7">
                                                {{ $item['U'] }}
                                            </td>
                                            <td class="coln_page7 tabellaGridPage7 let">
                                                {{-- <span style="font-family: DejaVu Sans;">&le;</span> --}}
                                                {{ $item['valori_riferimento'] }}
                                            </td>
                                        </tr>
                                        @endif
                                @endforeach
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" style="margin-left: 0; text-align:left; font-size: 9px;">
                                    (§) I valori di riferimento sono tratti dalle Linee Guida {{ $lineeGuidaAria[26] ?? ''}}
                                </td>
                            </tr>
                        </tfoot>
                        {{-- <p style="font-size:10px; margin-left:2.3cm; margin-top:0cm">(§) I valori di riferimento sono tratti dalle Linee Guida {{ $lg ?? ''}}</p> --}}
                    </table>
                    @php $inseriti++; @endphp
                    @endif
                @endif
            @endforeach
        </div>
        @endif

        <!-- Pagina 8 - 9 -->
        @if(count($tipi_piastre_superficie) > 0)
        <div class="page break" style="margin-top: 4cm;" id="page8">
            <table class="tabellaGridPage6" style="width: 100%;">
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
            <br>
            @php $tab_inserite = 0; @endphp
            @foreach($tipi_piastre_superficie as $key => $piastra)
                @php $tab_inserite++; @endphp
                @php $lg = $lineeGuidaSuperficie[$key]; @endphp
                @if($tab_inserite == 1)
                <table class="tabellaGridPage6" style="width: 100%;">
                @else
                <table class="tabellaGridPage6" style="margin-top:3cm; width: 100%;">
                @endif
                    <thead>
                        <tr>
                            <th style="text-align: left;" class="tabellaGridPage6" colspan="6">
                                <b>Data e ora inizio incubazione:</b>{{ $dataOraInizioIncubazioneSuperficie["dataOraInizioIncubazione_$piastra"] }}<br>
                                <b>Data e ora fine incubazione: </b>{{ $dataOraFineIncubazioneSuperficie["dataOraFineIncubazione_$piastra"] }}
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: left;" class="tabellaGridPage6" colspan="6">
                                <b>Metodo:</b>{{ $metodoSuperficie["metodo_$piastra"] }} <br>
                                <b>Denominazione della prova:</b> {{ $descrizioneMetodoSuperficie["descrizione_metodo_$piastra"] }}<br>
                                <b>Tecnico incaricato dell'analisi:</b> {{ $tecnicoSuperficie["tecnico_$piastra"] }}
                            </th>
                        </tr>
                        <tr>
                            <th class="tabellaGridPage6" style="width: 80px;">
                                <b>Campione N.</b>
                            </th>
                            <th class="tabellaGridPage6">
                                <b>Codice campione</b>
                            </th>
                            <th class="tabellaGridPage6">
                                <b>Punto di campionamento</b>
                            </th>
                            <th class="tabellaGridPage6" style="width: 40px;">
                                {{-- <b>CFU/Piastra o CFU/m &#178;</b> --}}
                                <b>CFU/Piastra</b>
                            </th>
                            <th class="tabellaGridPage6" style="width: 40px;">
                                <b>U(¹)</b>
                            </th>
                            <th class="tabellaGridPage6">
                                <b>Valori di riferimento</b><span style="font-size: 9px"> (§)</span> <b> CFU/Piastra</b>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campioni_analizzati_con_piastra_superficie as $key => $value)
                            @if($piastra == $key)
                                @foreach ($value as $item)
                                    <tr class="tabellaGridPage7">
                                        <td class="coln_page7 tabellaGridPage7">
                                            {{ $item['id_campione'] }}
                                        </td>
                                        <td class="coln_page7 tabellaGridPage7">
                                            {{ $item['codice_cias'] }}
                                        </td>
                                        <td class="coln_page7 tabellaGridPage7">
                                            {{ $item['punto_camp'] }}
                                        </td>
                                        <td class="coln_page7 tabellaGridPage7">
                                            {{ $item['CFU'] }}
                                        </td>
                                        <td class="coln_page7 tabellaGridPage7">
                                            {{ $item['U'] }}
                                        </td>
                                        <td class="coln_page7 tabellaGridPage7 let">
                                             <span> {{ htmlspecialchars($item['valori_riferimento']) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" style="margin-left: 0; text-align:left; font-size: 9px;">
                                (§) I valori di riferimento sono tratti dalle Linee Guida {{ $lg ?? ''}}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            @endforeach  
        </div>
        @endif

        <!-- Pagina 10 -->
        @if(count($campioni_speciazione_pca_aria) > 0 || count($campioni_speciazione_pca_superficie) > 0 || count($campioni_speciazione_dg18_aria) > 0 || count($campioni_speciazione_dg18_superficie) > 0)
        <div class="page break" id="page10">
        @php $speciazioni_inserite = 0; @endphp
        @if(count($campioni_speciazione_pca_aria) > 0)
            @php $speciazioni_inserite++; @endphp
            @if($speciazioni_inserite == 1)
            <table class="tabellaGridPage6">
            @else
            <table class="tabellaGridPage6" style="margin-top: 3cm">
            @endif  
                <thead class="tabellaGridPage6">
                    <tr class="tabellaGridPage6">
                        <th colspan="5" class="tabellaGridPage6" style="background-color: rgb(189, 183, 183); text-align:left;">
                            Identificazione specie patogene
                        </th>
                    </tr>
                </thead>
                <tbody class="tabellaGridPage6">
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Tipo terreno</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            PCA
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Matrice</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            Aria
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Data inizio - fine prova</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            {{ Carbon\Carbon::parse($campioni_speciazione_pca_aria->first()->dataFineProva)->format('d/m/Y')  }} - {{ Carbon\Carbon::parse($dataFineProva_pca_aria)->format('d/m/Y') }}
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Tecnico incaricato dell'analisi</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            {{ get_tecnico_analisi_campione($campioni_speciazione_pca_aria) }}
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Microrganismi ricercati</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            
                            {{ get_microrganismi_ricercati_campione($campioni_speciazione_pca_aria) }}
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>n. campione</b>
                        </td>
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>Codice campione</b>
                        </td>
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>Punto di campionamento</b>
                        </td>
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>Risultato</b>
                        </td>
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>Microrganismo identificato</b>
                        </td>
                    </tr>
                    @php $spec_camp = getAllResults($campioni_speciazione_pca_aria); @endphp
                    @foreach($spec_camp['NR'] as $cs)
                    <tr>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['id_campione'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['codice_campione']}}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['punto_campionamento'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['risultato'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ "/" }}
                        </td>
                    </tr>
                    @endforeach
                    @foreach($spec_camp['R'] as $cs)
                    <tr>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['id_campione'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['codice_campione']}}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['punto_campionamento'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['risultato'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['microrganismo_ricercato'] }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @if(count($campioni_speciazione_pca_superficie) > 0)
            @php $speciazioni_inserite++; @endphp
            @if($speciazioni_inserite == 1)
            <table class="tabellaGridPage6">
            @else
            <table class="tabellaGridPage6" style="margin-top: 3cm">
            @endif  
                <thead class="tabellaGridPage6">
                    <tr class="tabellaGridPage6">
                        <th colspan="5" class="tabellaGridPage6" style="background-color: rgb(189, 183, 183); text-align:left;">
                            Identificazione specie patogene
                        </th>
                    </tr>
                </thead>
                <tbody class="tabellaGridPage6">
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Tipo terreno</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            PCA
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Matrice</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            Superficie
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Data inizio - fine prova</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            {{ Carbon\Carbon::parse($campioni_speciazione_pca_superficie->first()->dataFineProva)->format('d/m/Y')  }} - {{ Carbon\Carbon::parse($dataFineProva_pca_superficie)->format('d/m/Y') }}
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Tecnico incaricato dell'analisi</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            {{ get_tecnico_analisi_campione($campioni_speciazione_pca_superficie) }}
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Microrganismi ricercati</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            
                            {{ get_microrganismi_ricercati_campione($campioni_speciazione_pca_superficie) }}
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>n. campione</b>
                        </td>
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>Codice campione</b>
                        </td>
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>Punto di campionamento</b>
                        </td>
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>Risultato</b>
                        </td>
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>Microrganismo identificato</b>
                        </td>
                    </tr>
                    @php $spec_camp = getAllResults($campioni_speciazione_pca_superficie); @endphp
                    @foreach($spec_camp['NR'] as $cs)
                    <tr>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['id_campione'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['codice_campione']}}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['punto_campionamento'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['risultato'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ "/" }}
                        </td>
                    </tr>
                    @endforeach
                    @foreach($spec_camp['R'] as $cs)
                    <tr>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['id_campione'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['codice_campione']}}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['punto_campionamento'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['risultato'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['microrganismo_ricercato'] }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @if(count($campioni_speciazione_dg18_aria) > 0)
            @php $speciazioni_inserite++; @endphp
            @if($speciazioni_inserite == 1)
            <table class="tabellaGridPage6">
            @else
            <table class="tabellaGridPage6" style="margin-top: 3cm">
            @endif  
            <thead class="tabellaGridPage6">
                    <tr class="tabellaGridPage6">
                        <th colspan="5" class="tabellaGridPage6" style="background-color: rgb(189, 183, 183); text-align:left;">
                            Identificazione specie patogene
                        </th>
                    </tr>
                </thead>
                <tbody class="tabellaGridPage6">
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Tipo terreno</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            DG18
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Matrice</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            Aria
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Data inizio - fine prova</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            {{ Carbon\Carbon::parse($campioni_speciazione_dg18_aria->first()->dataFineProva)->format('d/m/Y')  }} - {{ Carbon\Carbon::parse($dataFineProva_dg18_aria)->format('d/m/Y') }}
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Tecnico incaricato dell'analisi</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            {{ get_tecnico_analisi_campione($campioni_speciazione_dg18_aria) }}
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Microrganismi ricercati</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            
                            {{ get_microrganismi_ricercati_campione($campioni_speciazione_dg18_aria) }}
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>n. campione</b>
                        </td>
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>Codice campione</b>
                        </td>
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>Punto di campionamento</b>
                        </td>
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>Risultato</b>
                        </td>
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>Microrganismo identificato</b>
                        </td>
                    </tr>
                    @php $spec_camp = getAllResults($campioni_speciazione_dg18_aria); @endphp
                    @foreach($spec_camp['NR'] as $cs)
                    <tr>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['id_campione'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['codice_campione']}}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['punto_campionamento'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['risultato'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ "/" }}
                        </td>
                    </tr>
                    @endforeach
                    @foreach($spec_camp['R'] as $cs)
                    <tr>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['id_campione'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['codice_campione']}}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['punto_campionamento'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['risultato'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['microrganismo_ricercato'] }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        @if(count($campioni_speciazione_dg18_superficie) > 0)
            @php $speciazioni_inserite++; @endphp
            @if($speciazioni_inserite == 1)
            <table class="tabellaGridPage6">
            @else
            <table class="tabellaGridPage6"  style="margin-top: 3cm">
            @endif  
                <thead class="tabellaGridPage6">
                    <tr class="tabellaGridPage6">
                        <th colspan="5" class="tabellaGridPage6" style="background-color: rgb(189, 183, 183); text-align:left;">
                            Identificazione specie patogene
                        </th>
                    </tr>
                </thead>
                <tbody class="tabellaGridPage6">
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Tipo terreno</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            DG18
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Matrice</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            Superficie
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Data inizio - fine prova</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            {{ Carbon\Carbon::parse($campioni_speciazione_dg18_superficie->first()->dataFineProva)->format('d/m/Y')  }} - {{ Carbon\Carbon::parse($dataFineProva_dg18_superficie)->format('d/m/Y') }}
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Tecnico incaricato dell'analisi</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            {{ get_tecnico_analisi_campione($campioni_speciazione_dg18_superficie) }}
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td colspan="2" class="tabellaGridPage6" style="text-align: left;">
                            <b>Microrganismi ricercati</b>
                        </td>
                        <td colspan="3" class="tabellaGridPage6" style="text-align: left;">
                            
                            {{ get_microrganismi_ricercati_campione($campioni_speciazione_dg18_superficie) }}
                        </td>
                    </tr>
                    <tr class="tabellaGridPage6">
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>n. campione</b>
                        </td>
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>Codice campione</b>
                        </td>
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>Punto di campionamento</b>
                        </td>
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>Risultato</b>
                        </td>
                        <td class="tabellaGridPage6" style="text-align: center;">
                            <b>Microrganismo identificato</b>
                        </td>
                    </tr>
                    @php $spec_camp = getAllResults($campioni_speciazione_dg18_superficie); @endphp
                    @foreach($spec_camp['NR'] as $cs)
                    <tr>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['id_campione'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['codice_campione']}}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['punto_campionamento'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['risultato'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ "/" }}
                        </td>
                    </tr>
                    @endforeach
                    @foreach($spec_camp['R'] as $cs)
                    <tr>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['id_campione'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['codice_campione']}}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['punto_campionamento'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['risultato'] }}
                        </td>
                        <td class="tabellaGridPage6"  style="text-align: center;">
                            {{ $cs['microrganismo_ricercato'] }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        </div>
        @endif
        <!-- Pagina 11 -->
        <div class="page break" id="page11">          
            <div style="margin-top: 2cm;">
                <ul>
                    <li style="font-size: 14px; margin-bottom:0.2cm;">
                        <b>Dichiarazione di conformità</b>
                    </li>
                    <li style="font-size: 14px; list-style-type: none; margin-bottom: 0.5cm; ">
                        <p style="line-height: 1.4;"> Alla data di produzione del presente documento, in relazione ai soli campioni riportati, i valori di CMT 
                        {{ $superano }} i limiti indicati dalle Linee Guida {{ $lineeguida1 }}. <br>
                        La ricerca dei patogeni indicati nelle Linee Guida {{ $lineeguida2 }} ha dato esito {{ $esito == 'negativo' ? $esito : $esito . " per il seguente campione: $campione_esito"  }}. <br>
                        La dichiarazione di conformità si basa sul confronto del risultato con i limiti di riferimento, {{ $no_incertezza }} </p>
                    </li>
                    <li style="font-size: 14px; margin-bottom:0.2cm;">
                        <b>Obiettivi della prova</b>
                    </li>
                    <li style="font-size: 14px; list-style-type: none; ">
                        <p style="line-height: 1.4;"> Determinazione della carica microbiologica ambientale per la valutazione della qualità dell'aria e dell'efficacia delle sanitizzazioni in ambienti ad elevata sterilità. <br>
                        Nello specifico si sono svolti i controlli per verificare il corretto funzionamento dell'impianto di VCCC (ventilazione e 
                        condizionamento a contaminazione controllata) e la valutazione dell'attività di manutenzione, con particolare riguardo
                        alla filtrazione dell'aria.</p>
                    </li>
                </ul>
            </div>
        </div>

        <!-- appendice -->
        @if($count_riferimenti > 0)
        @php $num_riferimenti_inseriti = 0; @endphp
        @php $primo_rif = 0; @endphp
        @php $riferimento_inserito = 0; @endphp
            <div class="page break">
            @foreach($riferimenti as $key => $riferimento)
                @foreach($riferimento as $numero => $inserito)
                    @if($inserito == 1)
                        @php $riferimento_inserito++ @endphp
                    @else
                        @break
                    @endif
                    @if($riferimento_inserito == 1)
                        <div style="font-size: 14px;">
                            <h3>Appendice</h3>
                                <p>
                                    Per comodità di lettura del presente elaborato, si riportano qui di seguito i limiti ed i criteri raccomandati in merito alla contaminazione di aree pulite durante le attività.
                                </p>
                        </div>
                    @endif
        
                    @if($numero == 1 && $inserito == 1)
                    @php $primo_rif = 1; @endphp
                    <div style="font-size: 14px;">
                        <h4>Riferimento {{ $riferimento_inserito }}</h4>
                        GMP Annex 1 del 2008, limiti raccomandati per il monitoraggio microbiologico di aree pulite durante il funzionamento.
                        <table class="tabellaGridPage7">
                            <thead class="tabellaGridPage7">
                                <tr class="tabellaGridPage7">
                                    <th colspan="5">
                                        Limiti raccomandati per la contaminazione microbica
                                    </th>
                                </tr>
                                <tr class="tabellaGridPage7">
                                    <th class="tabellaGridPage7">
                                        Grado
                                    </th>
                                    <th class="tabellaGridPage7">
                                        Campione d’aria CFU/m &#179;
                                    </th>
                                    <th class="tabellaGridPage7">
                                        Microrganismi per deposizione su piastra (diam. 90mm) CFU/4 ore(*)
                                    </th>
                                    <th class="tabellaGridPage7">
                                        Piastre per contatto (diam. 55 mm) CFU/Piastra
                                    </th>
                                    <th class="tabellaGridPage7">
                                        Impronta delle 5 dita del guanto CFU/guanto
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="tabellaGridPage7">
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        A
                                    </td>
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        < 1
                                    </td>
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        < 1
                                    </td>
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        < 1
                                    </td>
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        < 1
                                    </td>
                                </tr>
                                <tr class="tabellaGridPage7">
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        B
                                    </td>
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        10
                                    </td>
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        5
                                    </td>
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        5
                                    </td>
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        5
                                    </td>
                                </tr>
                                <tr class="tabellaGridPage7">
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        C
                                    </td>
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        100
                                    </td>
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        50
                                    </td>
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        25
                                    </td>
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        -
                                    </td>
                                </tr>
                                <tr class="tabellaGridPage7">
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        D
                                    </td>
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        200
                                    </td>
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        100
                                    </td>
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        50
                                    </td>
                                    <td class="tabellaGridPage7" style="text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="tabellaGridPage7">
                                    <td colspan="5">
                                        Note: (*) Le singole piastre di sedimentazione possono essere esposte per meno di 4 ore.
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @php $num_riferimenti_inseriti++; @endphp
                    @elseif($numero == 2 && $inserito == 1)
                        @if(($primo_rif == 1 && $num_riferimenti_inseriti == 3) || ($num_riferimenti_inseriti != 0 && $num_riferimenti_inseriti % 3 == 0))
                            <div style="page-break-before: always; padding-top: 3cm; font-size: 14px">
                            @php $num_riferimenti_inseriti = 0; @endphp
                        @else
                            <div style="font-size: 14px;">
                        @endif
                                <p>
                                    <h4>Riferimento {{ $riferimento_inserito }}</h4>
                                    Contaminazione microbiologica dell’aria in condizioni At-Rest (capitolo 3.3.1 – ISPESL 2009):
                                    la contaminazione biologica nell’aria ambiente, in prossimità del tavolo operatorio,
                                    per sala operatoria convenzionale in condizioni di riposo, con impianto VCCC a flusso turbolento,
                                    non deve superare o essere uguale al valore di 35 UFC/m&#179;
                                </p>
                            </div>
                        
                    @php $num_riferimenti_inseriti++; @endphp
                    @elseif($numero == 3 && $inserito == 1)
                        @if(($primo_rif == 1 && $num_riferimenti_inseriti == 3) || ($num_riferimenti_inseriti != 0 && $num_riferimenti_inseriti % 3 == 0))
                            <div style="page-break-before: always; padding-top: 3cm; font-size: 14px">
                            @php $num_riferimenti_inseriti = 0; @endphp
                        @else
                            <div style="font-size: 14px;">
                        @endif                      
                        <p>
                        <h4>Riferimento {{ $riferimento_inserito }}</h4>
                        Contaminazione microbiologica dell’aria in condizioni At-Rest (capitolo 3.3.1 – ISPESL 2009):
                        la contaminazione microbiologica dell’aria in condizioni At-Rest è accettabile solo in assenza di germi patogeni (S. Aureus, A. Niger, A. fumigatus e bacilli gram-).
                        </p>
                    </div>
                    @php $num_riferimenti_inseriti++; @endphp
                    @elseif($numero == 4 && $inserito == 1)
                        @if(($primo_rif == 1 && $num_riferimenti_inseriti == 3) || ($num_riferimenti_inseriti != 0 && $num_riferimenti_inseriti % 3 == 0))
                            <div style="page-break-before: always; padding-top: 3cm; font-size: 14px;">
                            @php $num_riferimenti_inseriti = 0; @endphp
                        @else
                            <div style="font-size: 14px;">
                        @endif                      
                        <p>
                        <h4>Riferimento {{ $riferimento_inserito }}</h4>
                        Contaminazione microbiologica dell’aria in condizioni Operational (capitolo 3.3.2 – ISPESL 2009):
                        la contaminazione biologica nell’aria ambiente, in prossimità del tavolo operatorio, per sala operatoria convenzionale in attività non deve superare o essere uguale al valore di 180 UFC/m&#179; con impianto VCCC a flusso turbolento.
                        </p>
                    </div>
                    @php $num_riferimenti_inseriti++; @endphp
                    @elseif($numero == 5 && $inserito == 1)
                        @if(($primo_rif == 1 && $num_riferimenti_inseriti == 3) || ($num_riferimenti_inseriti != 0 && $num_riferimenti_inseriti % 3 == 0))
                            <div style="page-break-before: always; padding-top: 3cm; font-size: 14px;">
                            @php $num_riferimenti_inseriti = 0; @endphp
                        @else
                            <div style="font-size: 14px;">
                        @endif
                        <p>
                        <h4>Riferimento {{ $riferimento_inserito }}</h4>
                        Contaminazione microbiologica dell’aria in condizioni Operational (capitolo 3.3.2 – ISPESL 2009):
                        la contaminazione biologica nell’aria ambiente, in prossimità del tavolo operatorio, per sala operatoria convenzionale in attività, non deve superare o essere uguale al valore di 20 UFC/&#179; con impianto VCCC a flusso unidirezionale.
                        </p>
                    </div>
                    @php $num_riferimenti_inseriti++; @endphp
                    @elseif($numero == 6 && $inserito == 1)
                        @if(($primo_rif == 1 && $num_riferimenti_inseriti == 3) || ($num_riferimenti_inseriti != 0 && $num_riferimenti_inseriti % 3 == 0))
                            <div style="page-break-before: always; padding-top: 3cm; font-size: 14px;">
                            @php $num_riferimenti_inseriti = 0; @endphp
                        @else
                            <div style="font-size: 14px;">
                        @endif
                        <p>
                        <h4>Riferimento {{ $riferimento_inserito }}</h4>
                        Contaminazione microbiologica dell’aria immessa dall’impianto di VCCC in condizioni at rest in prossimità della bocchetta di mandata (ISPESL 2003): la contaminazione biologica nell’aria ambiente per sala operatoria deve risultare < 1 UFC/m&#179;.
                        Per ciò che attiene alla contaminazione delle superfici, di seguito è riportata per la tabella di riferimento ricavata dalle Linee Guida ISPESL 2009.
                        </p>
                    </div>
                    @php $num_riferimenti_inseriti++; @endphp
                    @elseif($numero == 7 && $inserito == 1)
                        @if(($num_riferimenti_inseriti != 0 && $num_riferimenti_inseriti % 2 == 0) || ($num_riferimenti_inseriti != 0 && $num_riferimenti_inseriti % 3 == 0))
                            <div style="page-break-before: always; padding-top: 3cm; font-size: 14px">
                            @php $num_riferimenti_inseriti = 0; @endphp
                        @else
                            <div style="font-size: 14px;">
                        @endif
                        <p>
                        <h4>Riferimento {{ $riferimento_inserito }}</h4>
                        @php $tab1 = 0; @endphp
                        @foreach($riferimenti7_accessori as $tipo_7 => $riferimento_7)
                            @foreach($riferimento_7 as $tipo => $inserito_tipo)
                                @if($tipo == '7_table1' && $inserito_tipo == 1)
                                    @php $tab1 = 1; @endphp
                                    <p>
                                        Contaminazione microbiologica sulle superfici in condizioni At Rest (Tabella 4 - ISPESL 2009)
                                    </p>
                                    <table class="tabellaGridPage7">
                                        <thead class="tabellaGridPage7">
                                            <tr class="tabellaGridPage7">
                                                <th class="tabellaGridPage7" style="text-align: center;">
                                                    Locali
                                                </th>
                                                <th class="tabellaGridPage7" style="text-align: center;">
                                                    Obiettivi
                                                </th>
                                                <th class="tabellaGridPage7" style="text-align: center;">
                                                    Tecniche
                                                </th>
                                                <th class="tabellaGridPage7" style="text-align: center;">
                                                    Risultati attesi (UFC/piastra)
                                                </th>
                                                <th class="tabellaGridPage7" style="text-align: center;">
                                                    Provvedimenti se risultati non conformi (X=risultato ottenuto)
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="tabellaGridPage7">
                                            <tr class="tabellaGridPage7">
                                                <td class="tabellaGridPage7" style="text-align: center;">
                                                    Sale operatorie
                                                </td>
                                                <td class="tabellaGridPage7" style="text-align: center;">
                                                    Conformità della disinfezione e del trattamento dell’aria
                                                </td>
                                                <td class="tabellaGridPage7" style="text-align: center;">
                                                    Contatto
                                                </td>
                                                <td class="tabellaGridPage7" style="text-align: center;">
                                                    <span style="font-family: DejaVu Sans;">&le;</span> 5
                                                </td>
                                                <td style="border: 1px solid;">
                                                    <ul class="dashed">
                                                        <li>
                                                            Se 5 < X <span style="font-family: DejaVu Sans;">&le;</span> 15 accettabile
                                                        </li>
                                                        <li>
                                                            Se X <span style="font-family: DejaVu Sans;">&ge;</span> 15 in:
                                                            <ul class="dashed">
                                                                <li>
                                                                    1 punto accettabile
                                                                </li>
                                                                <li>
                                                                    2-4 punti segnalazione - rivedere il protocollo di pulizia e la sua attuazione
                                                                </li>
                                                                <li>
                                                                    5 inaccettabile
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            Se presenti S. aureus, Enterobatteri, Aspergillus spp., Pseudomonas spp., rivedere interamente il protocollo di pulizia e programmare nuovi controlli
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                
                                @if($tipo == '7_table2' && $inserito_tipo == 1)
                                    @if($tab1 == 1)
                                        <table class="tabellaGridPage7" style="page-break-before: always; padding-top: 3cm;">
                                    @else 
                                        <table class="tabellaGridPage7">
                                    @endif
                                    <p>
                                        Contaminazione microbiologica sulle superfici in condizioni At Rest (Tabella 4 - ISPESL 2009)
                                    </p>
                                        <thead class="tabellaGridPage7">
                                            <tr class="tabellaGridPage7">
                                                <th class="tabellaGridPage7" style="text-align: center;">
                                                    Locali
                                                </th>
                                                <th class="tabellaGridPage7" style="text-align: center;">
                                                    Obiettivi
                                                </th>
                                                <th class="tabellaGridPage7" style="text-align: center;">
                                                    Tecniche
                                                </th>
                                                <th class="tabellaGridPage7" style="text-align: center;">
                                                    Risultati attesi (UFC/piastra)
                                                </th>
                                                <th class="tabellaGridPage7" style="text-align: center;">
                                                    Provvedimenti se risultati non conformi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="tabellaGridPage7">
                                            <tr class="tabellaGridPage7">
                                                <td class="tabellaGridPage7" style="text-align: center;">
                                                    Degenza prepost intervento Rianimazioni Neonatologia
                                                </td>
                                                <td class="tabellaGridPage7" style="text-align: center;">
                                                    Controllo del protocollo di disinfezione e conformità della pulizia
                                                </td>
                                                <td class="tabellaGridPage7" style="text-align: center;">
                                                    Contatto
                                                </td>
                                                <td class="tabellaGridPage7" style="text-align: center;">
                                                    <span style="font-family: DejaVu Sans;">&le;</span> 50UFC/piastra <br>Senza agenti patogeni: S. aureus, enterobatteri, Aspergillus spp, Pseudomonas spp
                                                </td>
                                                <td class="tabellaGridPage7" style="text-align: center;">
                                                    - Se > 50: rivedere il protocollo.
                                                </td>
                                            </tr>   
                                        </tbody>
                                    </table>
                                @endif
                            @endforeach
                        @endforeach
                    </p>
                    </div>
                    @php $num_riferimenti_inseriti++; @endphp

                    @elseif($numero == 8 && $inserito == 1)
                    <div style="page-break-before: always; padding-top: 3cm; font-size: 14px;">
                        <p>
                            <b>Esecuzione della prova</b><br>
                            La quantificazione della CMT è stata effettuata nelle modalità e siti d’indagine descritti dal piano di campionamento.
                            {{-- <ul>
                                <li>
                                    aria ambiente in prossimità del campo operatorio (centro stanza)  a sala operatoria “at-rest”, ad un’altezza di circa 1,5 m dal pavimento.
                                </li>
                                <li>
                                    Sulle superfici ambientali dopo la sanificazione e in condizioni "at-rest".
                                </li>
                                <li>
                                    aria ambiente in prossimità del campo operatorio in condizioni di operational, ad un’altezza di 1,5 m dal pavimento e nel raggio di circa 1 m dal taglio chirurgico.
                                </li>
                            </ul> --}}
                        </p>
                        <ul>
                        @foreach($riferimenti8_accessori as $tipo_8 => $riferimento_8)
                            @foreach($riferimento_8 as $tipo => $inserito_tipo)
                                @if($tipo == '8_indicazione1' && $inserito_tipo == 1)
                                    <li>
                                        La determinazione dei microrganismi aerodispersi è stata eseguita secondo le indicazioni della norma ISO 14698-1.
                                        Per la valutazione microbica dell’aria, il campionamento passivo è uno fra i metodi più tradizionali: <br>
                                        piastre con terreno generico o selettivo vengono esposte nell’ambiente in esame, <br>
                                        ad intervalli di tempo adeguati, per permettere la crescita di <br>
                                        microrganismi sospesi nell’aria che si depositano in piastra per sedimentazione.
                                    </li><br>
                                @endif
                                @if($tipo == '8_indicazione2' && $inserito_tipo == 1)
                                    <li>
                                        La determinazione dei microrganismi aerodispersi è stata eseguita secondo le indicazioni della norma ISO 14698-1.
                                        Per il campionamento del bioaerosol, il metodo attivo risulta essere maggiormente affidabile <br> 
                                        in termini di efficienza di campionamento e di percentuale di rilevazione di microrganismi.<br>
                                        Per la prova si è utilizzato il campionatore SAS (Surface Air System), che prevede l’impiego di piastre Rodac di 55 mm di diametro,
                                        contenenti terreno di coltura idoneo a favorire la crescita dei microrganismi. <br>
                                        Il SAS è stato impostato per un volume d’aspirazione di {{ $riferimento8_portata }} l/piastra.
                                    </li>
                                @endif

                                @if($tipo == '8_indicazione3' && $inserito_tipo == 1)
                                    @php $riferimenti8_indicazione3 = 1 @endphp
                                @else
                                    @php $riferimenti8_indicazione3 = 1 @endphp
                                @endif
                                @if($tipo == '8_indicazione4' && $inserito_tipo == 1)
                                    @php $riferimenti8_indicazione4 = 1 @endphp
                                @else
                                    @php $riferimenti8_indicazione4 = 0 @endphp
                                @endif

                            @endforeach
                        @endforeach
                        </ul>
                        <p>
                            @if($riferimenti8_indicazione3 == 1 && $riferimenti8_indicazione4 == 1)
                                Per promuovere la crescita mesofila, vengono utilizzate piastre PCA (Plate Count Agar) per essere incubate a 30°C per 72±3 ore; per promuovere la crescita micotica, vengono utilizzate  DG18 (Dichloran Glycerol Agar) per essere incubate a 25°C per 120-172 ore.
                                Per ogni data di campionamento è stata eseguita la prova di sterilità, incubando in parallelo, alle temperature e per i tempi previsti, una piastra vergine per ogni lotto di piastra utilizzata.
                            @elseif($riferimenti8_indicazione3 == 1 && $riferimenti8_indicazione4 == 0)
                                Per promuovere la crescita mesofila, vengono utilizzate piastre PCA (Plate Count Agar) per essere incubate a 30°C per 72±3 ore;
                                Per ogni data di campionamento è stata eseguita la prova di sterilità, incubando in parallelo, alle temperature e per i tempi previsti, una piastra vergine per ogni lotto di piastra utilizzata.
                            @elseif($riferimenti8_indicazione3 == 0 && $riferimenti8_indicazione4 == 1)
                                Per promuovere la crescita micotica, vengono utilizzate  DG18 (Dichloran Glycerol Agar) per essere incubate a 25°C per 120-172 ore.
                                Per ogni data di campionamento è stata eseguita la prova di sterilità, incubando in parallelo, alle temperature e per i tempi previsti, una piastra vergine per ogni lotto di piastra utilizzata.
                            @endif
                        </p>
                    </div>
                    @php $num_riferimenti_inseriti++; @endphp
                    @endif
                @endforeach
            @endforeach
            </div>
        @endif
          
        <!-- Pagina 11 -->
        <div class="page break" id="page15">  
            <div style="margin-top: 1cm;">
                <p><b>Opinioni ed Interpretazioni non oggetto di accreditamento ACCREDIA:</b></p><br>
                {{ $opinioni ?? '/'}}
            </div>

            <div style="margin-top: 2cm; border:1px solid black;; border-color: black">
                <p style="margin-left: 0.2cm; margin-bottom: 0cm;"><u>NOTE DI REVISIONE:</u></p><br>
                <p style="margin-left: 0.2cm; margin-top: 0.1cm">{{ $note_di_revisione ?? '/' }}</p>
            </div>

            <table style="border-collapse: separate; border-spacing:0.5cm; width: 100%; margin-top: 0.5cm; margin-left: 1cm; margin-right: 1cm;">
                <thead>
                    <tr>
                        <th style="text-align: center">Direttore del Laboratorio</th>
                        <th style="text-align: center">Il Responsabile di Laboratorio</th>

                    </tr>  
                    <tr>
                        <th style="text-align: center">Prof. Sante Mazzacane</th>
                        <th style="text-align: center">Prof. Elisabetta Caselli</th>
                    </tr>                
                </thead>
            </table>
        </div>
    </main>
</body>
</html>
