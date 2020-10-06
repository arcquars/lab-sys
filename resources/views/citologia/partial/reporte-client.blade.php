<table style="width: 100%">
    <tr>
        <td width="20%"><p class="p-datos-12"><b>Nombre y Apellido:</b></p></td>
        <td width="40%"><p class="p-datos-12" style="font-size: 12px;"><b>{{$analisis->person->apellidos.' '.$analisis->person->apellido_materno.', '.$analisis->person->nombres}}</b></p></td>
        <td width="20%" style="text-align: right;"><p class="p-datos-12"><b>Edad:</b></p></td>
        <td width="20%"><p class="p-datos-12">{{$analisis->person->edad}} años</p></td>
    </tr>
    <tr>
        <td><p class="p-datos-12"><b>Procedencia:</b></p></td>
        <td><p class="p-datos-12">{{$analisis->institucion->nombre}}</p></td>
        <td style="text-align: right;"><p class="p-datos-12"><b>Sexo:</b></p></td>
        <td><p class="p-datos-12">{{(strcmp($analisis->person->sexo, 'hombre') == 0)? 'MASCULINO' : 'FEMENINO'}}</p></td>
    </tr>
    <tr>
        <td width="20%"><p class="p-datos-12"><b>Fecha de Registro:</b></p></td>
        <td width="30%"><p class="p-datos-12">{{$analisis->fecha->format('Y-m-d')}}</p></td>
        <td width="20%" style="text-align: right;"><p class="p-datos-12"><b>Fecha Conclusión:</b></p></td>
        <td width="30%"><p class="p-datos-12">{{ $analisis->lastControlEdition()? $analisis->lastControlEdition()->created_at->format('Y-m-d') : '--' }}</p></td>
    </tr>
    <tr>
        <td><p class="p-datos-12"><b>Enviado por Doctor(a): </b></p></td>
        <td><p class="p-datos-12">{{$analisis->doctor}}</p></td>
        <td colspan="2" style="text-align: right; padding-right: 50px;">
            <div style="border: 2px double #f6993f; width: 100%; text-align: right; margin-top: 2px;">
                <p class="p-datos-13"><b>&nbsp;&nbsp;Codigo: {{$analisis->codigo}}&nbsp;&nbsp;</b></p>
            </div>
        </td>
    </tr>
    @if(isset($analisis->convenio))
    <tr>
        <td width="20%"><p class="p-datos-12"><b>Matrícula convenio:</b></p></td>
        <td width="30%"><p class="p-datos-12">{{$analisis->convenio->bancaMatricula}}</p></td>
        <td width="20%" style="text-align: right;"><p class="p-datos-12"><b>Preafiliación convenio:</b></p></td>
        <td width="30%"><p class="p-datos-12">{{ $analisis->convenio->bancaPreAfiliacion }}</p></td>
    </tr>
    @endif
</table>