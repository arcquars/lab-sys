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
        <td colspan="20" style="text-align: center;"><h4>{{Config::get('clinica.nombre')}}</h4></td>
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
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Paciente nombre</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Paciente apellido paterno</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Paciente apellido materno</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Edad</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 14px;">Matricula</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">PreAfiliacion</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Act. Asegurado</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Act. Ext. 19-25</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Act. Resto Benef.</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Pas. Resto Benef.</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Pas. Ext. 19-25</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Pas. Resto Benef.</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Sec. Vol. Resto Benef.</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Sec. Vol. Ext. 19-25</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Sec. Vol. Resto Benef.</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Institucion Manda</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Doctor que Pidio</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Especialidad</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Ambulatorio</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Hospitalizado</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 14px;">Region</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 16px;">Codigo</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 14px;">Tipo Estudio</th>

    </tr>
    </thead>
    <tbody>
    @php
        $i = 1;
    @endphp
    @foreach($resultados as $convenio)
        <tr>
            <td style="color: #0B0D33; font-size: 10px;">{{$i++}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{\Carbon\Carbon::parse($convenio->analisis->fecha)->format('Y-m-d')}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->person->nombres}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->person->apellidos}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->person->apellido_materno}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->person->edad}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->bancaMatricula}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->bancaPreAfiliacion}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{($convenio->bancaActivoAsegurado)? 'SI' : ''}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{($convenio->bancaActivoExt)? 'SI' : ''}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{($convenio->bancaActivoResto)? 'SI' : ''}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{($convenio->bancaPasivoAsegurado)? 'SI' : ''}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{($convenio->bancaPasivoExt)? 'SI' : ''}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{($convenio->bancaPasivoResto)? 'SI' : ''}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{($convenio->bancaSecAsegurado)? 'SI' : ''}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{($convenio->bancaSecExt)? 'SI' : ''}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{($convenio->bancaSecResto)? 'SI' : ''}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->bancaInstitucion}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->doctor}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->bancaEspecialidad}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->bancaAmbulatorio}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->bancaHospitalizado}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->region}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->codigo}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$convenio->analisis->tipo_analisis}}</td>
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
