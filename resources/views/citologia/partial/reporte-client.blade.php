<table style="width: 100%">
    <tr>
        <td width="20%"><p class="p-datos-12"><b>Nombre y Apellido:</b></p></td>
        <td width="40%"><p class="p-datos-12" style="font-weight: 700; font-size: 18px;">{{$analisis->person->apellidos.' '.$analisis->person->apellido_materno.', '.$analisis->person->nombres}}</p></td>
        <td width="20%" style="text-align: right;"><p class="p-datos-12"><b>Edad:</b></p></td>
        <td width="20%"><p class="p-datos-12">{{$analisis->person->edad}}</p></td>
    </tr>
    <tr>
        <td><p class="p-datos-12"><b>Procedencia:</b></p></td>
        <td><p class="p-datos-12">{{$analisis->institucion->nombre}}</p></td>
        <td style="text-align: right;"><p class="p-datos-12"><b>Sexo:</b></p></td>
        <td><p class="p-datos-12">{{(strcmp($analisis->person->sexo, 'hombre') == 0)? 'MASCULINO' : 'FEMENINO'}}</p></td>
    </tr>
    <tr>
        <td><p class="p-datos-12"><b>Enviado por Doctor(a): </b></p></td>
        <td><p class="p-datos-12">{{$analisis->doctor}}</p></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: right;">
            <div style="border: 2px double #f6993f; width: 100%; text-align: right; margin-top: 2px;">
                <p class="p-datos-12"><b>&nbsp;&nbsp;Codigo: {{$analisis->codigo}}&nbsp;&nbsp;</b></p>
            </div>
        </td>
    </tr>
</table>