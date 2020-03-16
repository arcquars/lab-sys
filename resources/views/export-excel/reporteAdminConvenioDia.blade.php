<?php
$total = 0;
/** @var  $resultados [] */
/** @var \App\Analisis $analisis */
foreach ($resultados as $convenio){
    $total += $convenio->precio;
}
?>
<table>
    <tr>
        <td colspan="12" style="text-align: center;"><h4>{{Config::get('clinica.nombre')}}</h4></td>
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
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 14px;">Tipo Estudio</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 14px;">Institucion</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 14px;">Matricula</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 14px;">PreAfiliacion</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Precio</th>
    </tr>
    </thead>
    <tbody>
    @php
        $i = 1;
    @endphp
    @foreach($resultados as $convenio)
        <tr>
            <td style="color: #0B0D33; font-size: 10px;">{{$i++}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->fecha}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->codigo}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->person->nombres}} {{$convenio->analisis->person->apellidos}} {{$convenio->analisis->person->apellido_materno}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->person->edad}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->doctor}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->region}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->tipo_analisis}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->institucion->nombre}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->bancaMatricula}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->bancaPreAfiliacion}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->precio}}</td>
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