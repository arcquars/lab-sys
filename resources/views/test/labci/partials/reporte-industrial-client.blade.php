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
    $industrialRows = [
        ['PRODUCTO', optional($detail)->product_name, 'FECHA DE ENSAYO', optional(optional($detail)->rehearsal_date)->format('Y-m-d')],
        ['NRO. DE LOTE', optional($detail)->lot_number, 'FECHA DE FABRICACIÓN', optional(optional($detail)->manufacture_date)->format('Y-m-d')],
        ['FECHA DE VENCIMIENTO', optional(optional($detail)->expiration_date)->format('Y-m-d'), null, null],
    ];
@endphp
@foreach(['DATOS GENERALES' => $generalRows, 'Muestra industrial' => $industrialRows] as $title => $rows)
    <h3 class="labci-h3">{{ $title }}:</h3>
    <table class="labci-table-4" style="table-layout: fixed; width: 100%;">
        <tbody>
            @foreach($rows as $row)
                <tr>
                    @foreach([0, 2] as $offset)
                        <td style="width: 20%; vertical-align: top;">
                            <p class="labci-table-p-b"><b>{{ $row[$offset] ? $row[$offset] . ':' : '' }}</b></p>
                        </td>
                        <td style="width: 30%; vertical-align: top; word-wrap: break-word;">
                            <p class="labci-table-p">{{ $row[$offset] ? ($row[$offset + 1] ?? '--') : '' }}</p>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach
