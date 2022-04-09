@include('citologia.partial.reporte-style')
@include('citologia.partial.reporte-head')
<style>
    .table-clinica thead tr th{
        font-size: 8px;
    }
    .table-clinica tbody tr td, .table-clinica tfoot tr td {
        font-size: 8px;
    }
    .table-clinica tbody tr{
        border-bottom: solid 1px #000;
    }

    .table-clinica {
        border-collapse: collapse;
    }

    .table-clinica, .table-clinica thead tr th, .table-clinica tbody tr td, .table-clinica tfoot tr td {
        border: 1px solid black;
    }
</style>
<h3 class="h2-cito">Reporte Semanal</h3>
<br>
<h4>Analisis Pagos a Cuenta</h4>
<table class="table table-bordered table-clinica">
    <thead class="thead-dark">
    <tr>
        <th>N.</th>
        <th scope="col">Fecha</th>
        <th scope="col">Codigo</th>
        <th scope="col">Paciente</th>
        <th scope="col">Region</th>
        <th scope="col">Tipo Estudio</th>
        <th scope="col">Precio</th>
        <th scope="col">A cuenta</th>
        <th scope="col">Debe</th>
        <th scope="col">Empresa</th>
    </tr>
    </thead>
    <tbody>
    @php
        $i = 1;
    @endphp
    @foreach($analisis as $analisi)
        <tr>
            <td>{{$i++}}</td>
            <td>{{$analisi->fecha}}</td>
            <td>{{$analisi->codigo}}</td>
            <td>{{$analisi->person->nombres}} {{$analisi->person->apellidos}} {{$analisi->person->apellido_materno}}</td>
            <td>{{$analisi->region}}</td>
            <td>{{( strcmp($analisi->tipo_analisis, \App\Analisis::HISTOPATOLOGICO) != 0)? $analisi->tipo_analisis: \App\Analisis::BIOPSIA_DE_RINON}}</td>
            <td>{{$analisi->precio}}</td>
            <td>{{$analisi->acuenta}}</td>
            <td>{{$analisi->precio - $analisi->acuenta}}</td>
            <td>{{ $analisi->institucion->nombre }}</td>
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
        <td>TOTALES</td>
        <td>{{$totalPrecio}}</td>
        <td>{{$totalAcuenta}}</td>
        <td>{{$totalDebe}}</td>
        <td></td>
    </tr>
    </tfoot>
</table>
<br>
<h4>Analisis Pagos Efectuados</h4>
<table class="table table-bordered table-clinica">
    <thead class="thead-dark">
    <tr>
        <th>N.</th>
        <th scope="col">Fecha Pago</th>
        <th scope="col">Codigo</th>
        <th scope="col">Paciente</th>
        <th scope="col">Doctor que Pidio</th>
        <th scope="col">Region</th>
        <th scope="col">Tipo Estudio</th>
        <th scope="col">Precio</th>
        <th scope="col">A cuenta</th>
        <th scope="col">Debe</th>
        <th scope="col">Empresa</th>
    </tr>
    </thead>
    <tbody>
    @php
        $i = 1;
    @endphp
    @foreach($analisisPagos as $analisi)
        <tr>
            <td>{{$i++}}</td>
            <td>{{$analisi->fecha_pago_efectuado}}</td>
            <td>{{$analisi->codigo}}</td>
            <td>{{$analisi->person->nombres}} {{$analisi->person->apellidos}} {{$analisi->person->apellido_materno}}</td>
            <td>{{$analisi->doctor}}</td>
            <td>{{$analisi->region}}</td>
            <td>{{( strcmp($analisi->tipo_analisis, \App\Analisis::HISTOPATOLOGICO) != 0)? $analisi->tipo_analisis: \App\Analisis::BIOPSIA_DE_RINON}}</td>
            <td>{{$analisi->precio}}</td>
            <td>{{$analisi->acuenta}}</td>
            <td>{{$analisi->precio - $analisi->acuenta}}</td>
            <td>{{ $analisi->institucion->nombre }}</td>
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
        <td>TOTALES</td>
        <td>{{$totalPrecioPago}}</td>
        <td>{{$totalAcuentaPago}}</td>
        <td>{{$totalDebePago}}</td>
        <td></td>
    </tr>
    </tfoot>
</table>
<br>
<h4>Gastos</h4>
<table class="table table-bordered table-clinica">
    <thead class="thead-dark">
    <tr>
        <th>N.</th>
        <th scope="col">Fecha</th>
        <th scope="col">Detalle</th>
        <th scope="col">Usuario</th>
        <th scope="col">Monto</th>
    </tr>
    </thead>
    <tbody>
    @php
        $i = 1;
    @endphp
    @foreach($gastos as $gasto)
        <tr>
            <td>{{$i++}}</td>
            <td>{{$gasto->fecha}}</td>
            <td>{{$gasto->detalle}}</td>
            <td>{{$gasto->user->name}}</td>
            <td>{{$gasto->gasto}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>TOTALES</td>
        <td>{{$totalGastos}}</td>
    </tr>
    </tfoot>
</table>
<br>
<h4>Totales</h4>
<table class="table table-bordered table-clinica">
    <thead class="thead-dark">
    <tr>
        <th>Resumen</th>
        <th>$</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Total Pagos a Cuenta</td>
        <td>{{$totalAcuenta}}</td>
    </tr>
    <tr>
        <td>Total Pagos Efectuados</td>
        <td>{{$totalDebePago}}</td>
    </tr>
    <tr>
        <td>Total Egresos</td>
        <td>{{$totalGastos}}</td>
    </tr>
    <tr>
        <td>TOTAL</td>
        <td>{{$totalAcuenta + $totalDebePago - $totalGastos}}</td>
    </tr>
    </tbody>
</table>
