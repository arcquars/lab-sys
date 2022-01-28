<?php
$total = 0;
/** @var  [] $resultados */
/** @var \App\Analisis $analisi */
foreach ($resultados as $analisi){
    $total += $analisi->precio;
}
?>
<table>
    <tr>
        <td colspan="8" style="text-align: center;"><h4>{{Config::get('clinica.nombre')}}</h4></td>
    </tr>
    <tr>
        <td colspan="4"><h4>Institucion: {{$institucion}}</h4></td>
    </tr>
    <tr>
        <td>Desde</td>
        <td>{{$desde}}</td>
        <td>Hasta</td>
        <td>{{$hasta}}</td>
    </tr>
</table>
<table>
    <thead>
    <tr>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">N.</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Fecha</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 16px;">Codigo</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Paciente</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Edad</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Doctor que Pidio</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 14px;">Region</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 14px;">Institucion</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 14px;">Tipo Estudio</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Precio</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Estado</th>
    </tr>
    </thead>
    <tbody>
    @php
        $i = 1;
    @endphp
    @foreach($resultados as $analisi)
        <tr>
            <td style="color: #0B0D33; font-size: 10px;">{{$i++}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{ \Carbon\Carbon::parse($analisi->fecha)->format('Y-m-d') }}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->codigo}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->person->nombres}} {{$analisi->person->apellidos}} {{$analisi->person->apellido_materno}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->edad}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->doctor}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->region}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->institucion->nombre}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->tipo_analisis}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->precio}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{ ($analisi->precio == ($analisi->acuenta + $analisi->pago_efectuado))? 'Cancelado' : 'Debe: '.($analisi->precio -($analisi->acuenta + $analisi->pago_efectuado)) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;"></td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;"></td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;"></td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;"></td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;"></td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;"></td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;"></td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">TOTALES</td>
        <td style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">{{$total}}</td>
    </tr>
    </tfoot>
</table>
