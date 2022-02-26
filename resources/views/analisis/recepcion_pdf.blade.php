<h3 class="h4-cito-1" style="text-align: center;">RECEPCION</h3>
<div style="height: 4px;"></div>
<table style="width: 95%;">
    <tr>
        <td style="width: 80%;">
            <dl>
                <dt>
                    <p><b>Paciente</b></p>
                </dt>
                <dd>
                    <p>&nbsp;&nbsp;&nbsp;{{ $analisis->person->nombres }} {{ $analisis->person->apellidos }} {{ $analisis->person->apellido_materno }}</p>
                </dd>
                <dt>
                    <p><b>Analisis</b></p>
                </dt>
                <dd>
                    <p>&nbsp;&nbsp;&nbsp;{{ $analisis->tipo_analisis }}</p>
                </dd>
                <dt>
                    <p><b>Codigo</b></p>
                </dt>
                <dd>
                    <p>&nbsp;&nbsp;&nbsp;{{ $analisis->codigo  }}</p>
                </dd>
                <dt>
                    <p><b>Fecha</b></p>
                </dt>
                <dd>
                    <p>&nbsp;&nbsp;&nbsp;{{ $analisis->fecha->format('Y-m-d') }}</p>
                </dd>
            </dl>

        </td>
        <td style="width: 20%;">
            <img src="{{$pathQr}}" width="110">
        </td>
    </tr>
</table>
<p>Usted puede escanear el codigo QR para ver el resultado de su analisis despues de 3 dias de la fecha de ingreso</p>
<br>
