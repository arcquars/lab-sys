<?php
?>
@include('citologia.partial.reporte-style')
@include('citologia.partial.reporte-head')
<h3 class="h2-cito">COMPROBANTE</h3>
<div>
    <p class="p-dato" style="padding: 2px; margin: 3px;"><b>&nbsp;&nbsp;Codigo: {{$analisis->codigo}}&nbsp;&nbsp;</b></p>
</div>
<table>
    <tr>
        <td><img src="{{public_path($pathQr)}}" alt="Smiley face" height="70" width="70"></td>
        <td>
            <table style="width: 100%">
                <tr>
                    <td width="20%"><p class="p-dato"><b>Nombre y Apellido:</b></p></td>
                    <td width="40%"><p class="p-dato">{{$analisis->person->apellidos.', '.$analisis->person->nombres}}</p></td>
                    <td width="20%"><p class="p-dato"><b>Edad:</b></p></td>
                    <td width="20%"><p class="p-dato">{{$analisis->person->edad}}</p></td>
                </tr>
                <tr>
                    <td><p class="p-dato"><b>Tipo de analisis: </b></p></td>
                    <td><p class="p-dato">{{$analisis->tipo_analisis}}</p></td>
                    <td><p class="p-dato"><b>Region:</b></p></td>
                    <td><p class="p-dato">{{$analisis->region}}</p></td>
                </tr>
                <tr>
                    <td><p class="p-dato"><b>Procedencia:</b></p></td>
                    <td><p class="p-dato">{{$analisis->institucion->nombre}}</p></td>
                    <td><p class="p-dato"><b>Sexo:</b></p></td>
                    <td><p class="p-dato">{{$analisis->person->sexo}}</p></td>
                </tr>
                <tr>
                    <td><p class="p-dato"><b>Enviado por Doctor(a): </b></p></td>
                    <td><p class="p-dato">{{$analisis->doctor}}</p></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
