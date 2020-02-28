<table style="width: 100%">
    <tr>
        <td width="30%"><p class="p-dato"><b>Nombre y Apellido:</b></p></td>
        <td width="30%"><p class="p-dato">{{$analisis->person->apellidos.' '.$analisis->person->apellido_materno.', '.$analisis->person->nombres}}</p></td>
        <td width="30%" style="text-align: right;"><p class="p-dato"><b>Edad:</b></p></td>
        <td width="30%"><p class="p-dato">{{$analisis->person->edad}}</p></td>
    </tr>
    <tr>
        <td><p class="p-dato"><b>Procedencia:</b></p></td>
        <td><p class="p-dato">{{$analisis->institucion->nombre}}</p></td>
        <td style="text-align: right;"><p class="p-dato"><b>Sexo:</b></p></td>
        <td><p class="p-dato">{{strtoupper($analisis->person->sexo)}}</p></td>
    </tr>
    <tr>
        <td><p class="p-dato"><b>Enviado por Doctor(a): </b></p></td>
        <td><p class="p-dato">{{$analisis->doctor}}</p></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: right;">
            <div style="border: 2px double #f6993f; width: 100%; text-align: right; margin-top: 10px;">
                <p class="p-dato"><b>&nbsp;&nbsp;Codigo: {{$analisis->codigo}}&nbsp;&nbsp;</b></p>
            </div>
        </td>
    </tr>
</table>