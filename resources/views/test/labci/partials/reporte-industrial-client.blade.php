@php
    $detail = $analisis->industrialExhibition;
    $codigoLab = $analisis->codigo;
    if ($showCodeIntPdf && !empty($analisis->internal_code)) {
        $codigoLab .= ' - ' . $analisis->internal_code;
    }

    $generalRows = [
        ['CLIENTE', $analisis->person->apellidos.' '.$analisis->person->apellido_materno.' '.$analisis->person->nombres, 'COD LAB', $codigoLab],
        ['CI/PASAPORTE', $analisis->person->ci, 'FECHA DE SOLICITUD', $analisis->fecha->format('Y-m-d')],
        ['SOLICITANTE', $analisis->doctor, 'INSTITUCIÓN', $analisis->institucion->nombre],
        ['RECEPCIONADO POR', $analisis->user->name, 'FECHA DE IMPRESIÓN', \Carbon\Carbon::now()->format('Y-m-d, H:i:s')],
    ];

    if($detail){
        // $generalRows = [
        //     ['CLIENTE', $analisis->person->apellidos.' '.$analisis->person->apellido_materno.' '.$analisis->person->nombres, 'COD LAB', $codigoLab],
        //     ['FECHA DE SOLICITUD', $analisis->fecha->format('Y-m-d'), 'FECHA DE IMPRESIÓN', \Carbon\Carbon::now()->format('Y-m-d, H:i:s')],
        //     ['SOLICITANTE', $analisis->doctor, 'RECEPCIONADO POR', $analisis->user->name],
        // ];
        $generalRows = [
            ['SOLICITANTE', $analisis->doctor, 'FECHA DE SOLICITUD', $analisis->fecha->format('Y-m-d')],
            ['RECEPCIONADO POR', $analisis->user->name, 'COD LAB', $codigoLab],
            ['FECHA DE RECEPCIÓN', optional(optional($detail)->rehearsal_date)->format('Y-m-d'), 'FECHA DE FABRICACIÓN', optional(optional($detail)->manufacture_date)->format('m/y')],
            ['NRO. DE LOTE', optional($detail)->lot_number, 'FECHA DE VENCIMIENTO', optional(optional($detail)->expiration_date)->format('m/y')],
        ];
    }

    
    $industrialRows = [
        ['PRODUCTO', optional($detail)->product_name],
    ];
@endphp
@foreach(['DATOS GENERALES' => $generalRows, 'Muestra industrial' => $industrialRows] as $title => $rows)
    @if(strcmp($title, 'Muestra industrial') != 0)
        <h3 class="labci-h3">{{ $title }}:</h3>
    @else
        <p class="labci-table-p-b" style="margin: 0, 4px;"><b>{{ mb_strtoupper($title) }}</b></p>
    @endif
    
    <table class="labci-table-4" style="table-layout: fixed; width: 100%;">
        <tbody>
            @foreach($rows as $row)
                <tr>
                    @if(count($row) == 4)
                        @foreach([0, 2] as $offset)
                            <td style="width: 20%; vertical-align: top;">
                                <p class="labci-table-p-b"><b>{{ $row[$offset] ? $row[$offset] . ':' : '' }}</b></p>
                            </td>
                            <td style="width: 30%; vertical-align: top; word-wrap: break-word;">
                                <p class="labci-table-p">{{ $row[$offset] ? ($row[$offset + 1] ?? '--') : '' }}</p>
                            </td>
                        @endforeach
                    @else
                        <td style="width: 20%; vertical-align: top;">
                            <p class="labci-table-p-b"><b>{{ $row[0] ? $row[0] . ':' : '' }}</b></p>
                        </td>
                        <td style="width: 80%; vertical-align: top; word-wrap: break-word;">
                            <p class="labci-table-p">{{ $row[0] ? ($row[1] ?? '--') : '' }}</p>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach
