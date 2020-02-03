
<table>
    <tr>
        <td colspan="11"><h4>Analisis</h4></td>
    </tr>
</table>
<table class="table-clinica">
    <thead class="thead-dark">
    <tr>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">N.</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Fecha</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 16px;">Codigo</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Paciente</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Doctor que Pidio</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 14px;">Region</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 14px;">Tipo Estudio</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Precio</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">A cuenta</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Debe</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Empresa</th>
    </tr>
    </thead>
    <tbody>
    @php
        $i = 1;
    @endphp
    @foreach($analisis as $analisi)
        <tr>
            <td style="color: #0B0D33; font-size: 10px;">{{$i++}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->fecha}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->codigo}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->person->nombres}} {{$analisi->person->apellidos}} {{$analisi->person->apellido_materno}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->doctor}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->region}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->tipo_analisis}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->precio}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->acuenta}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->precio - $analisi->acuenta}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{ $analisi->institucion->nombre }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">TOTALES</td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">{{$totalPrecio}}</td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">{{$totalAcuenta}}</td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">{{$totalDebe}}</td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;"></td>
    </tr>
    </tfoot>
</table>
<table>
    <tr>
        <td colspan="5"><h4>Gastos</h4></td>
    </tr>
</table>
<table class="table table-bordered table-clinica">
    <thead class="thead-dark">
    <tr>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">N.</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Fecha</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Detalle</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Usuario</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Monto</th>
    </tr>
    </thead>
    <tbody>
    @php
        $i = 1;
    @endphp
    @foreach($gastos as $gasto)
        <tr>
            <td style="color: #0B0D33; font-size: 10px;">{{$i++}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$gasto->fecha}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$gasto->detalle}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$gasto->user->name}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$gasto->gasto}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">TOTALES</td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">{{$totalGastos}}</td>
    </tr>
    </tfoot>
</table>
<table>
    <tr>
        <td colspan="2"><h4>Totales</h4></td>
    </tr>
</table>
<table class="table table-bordered table-clinica">
    <thead class="thead-dark">
    <tr>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Resumen</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">$</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="color: #0B0D33; font-size: 10px;">Total Ingresos</td>
        <td style="color: #0B0D33; font-size: 10px;">{{$totalPrecio}}</td>
    </tr>
    <tr>
        <td style="color: #0B0D33; font-size: 10px;">Total Egresos</td>
        <td style="color: #0B0D33; font-size: 10px;">{{$totalGastos}}</td>
    </tr>
    <tr>
        <td style="color: #0B0D33; font-size: 10px;">TOTAL</td>
        <td style="color: #0B0D33; font-size: 10px;">{{$totalPrecio - $totalGastos}}</td>
    </tr>
    </tbody>
</table>