<table>
    <tr>
        <td colspan="8" style="text-align: center;"><h4>{{Config::get('clinica.nombre')}}</h4></td>
    </tr>
    <tr>
        <td>Desde</td>
        <td>{{ \Carbon\Carbon::parse($desde)->format('Y-m-d') }}</td>
        <td>Hasta</td>
        <td>{{ \Carbon\Carbon::parse($hasta)->format('Y-m-d') }}</td>
    </tr>
</table>
<table>
    <thead>
    <tr>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">N.</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Fecha</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 9px; font-weight: 500;">Fecha entrega</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 16px;">Codigo</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 20px;">Paciente</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 14px;">Region</th>
        <th scope="col">Dr. asignado</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 14px;">Tipo analisis</th>
        <th style="background-color: #FFF6ED; color: #0B0D33; font-size: 10px; font-weight: 500; width: 14px;">Firmado</th>
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
            <td style="color: #0B0D33; font-size: 10px;">{{ isset($analisi->fecha_entrega)? \Carbon\Carbon::parse($analisi->fecha_entrega)->format('Y-m-d') : '--' }}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->codigo}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->person->nombres}} {{$analisi->person->apellidos}} {{$analisi->person->apellido_materno}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->region}}</td>
            <td>{{$analisi->doctorasig->nombres}} {{$analisi->doctorasig->apellidos}}</td>
            <td style="color: #0B0D33; font-size: 10px;">{{$analisi->tipo_analisis}}</td>
            <td style="color: #0B0D33; font-size: 10px;"><p style="font-size: 16px; margin-bottom: 2px;">{!! ($analisi->imprimir_firma == 1)? 'SI' : 'NO' !!}</p></td>
        </tr>
    @endforeach
    </tbody>
</table>
