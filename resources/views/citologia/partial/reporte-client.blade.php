<table style="width: 100%">
    <tr>
        <td width="50%">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 100%;">
                        <p class="p-datos-12-1"><b>Nombre y Apellido: <span style="font-size: 12px;">{{$analisis->person->apellidos.' '.$analisis->person->apellido_materno.', '.$analisis->person->nombres}}</span></b></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="p-datos-12-1"><b>Procedencia:</b> {{$analisis->institucion->nombre}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="p-datos-12-1"><b>Fecha de Registro:</b> {{$analisis->fecha->format('Y-m-d')}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="p-datos-12-1"><b>Enviado por Doctor(a): </b> {{$analisis->doctor}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        @if(isset($analisis->convenio))
                            <p class="p-datos-12"><b>Matrícula convenio:</b> {{$analisis->convenio->bancaMatricula}}</p>
                        @endif
                    </td>
                </tr>
            </table>


        </td>
        <td width="30%">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 100%;">
                        <p class="p-datos-12-1"><b>Edad:</b> {{$analisis->edad}} años</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="p-datos-12-1"><b>Sexo:</b> {{(strcmp($analisis->person->sexo, 'hombre') == 0)? 'MASCULINO' : 'FEMENINO'}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="p-datos-12-1"><b>Fecha Conclusión:</b> {{ $analisis->lastControlEdition()? $analisis->lastControlEdition()->created_at->format('Y-m-d') : '--' }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="border: 2px double #f6993f; width: 100%; text-align: right; margin-top: 2px;">
                            <p class="p-datos-13"><b>&nbsp;&nbsp;Codigo: {{$analisis->codigo}}&nbsp;&nbsp;</b></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        @if(isset($analisis->convenio))
                            <p class="p-datos-12"><b>Preafiliación convenio:</b> {{ $analisis->convenio->bancaPreAfiliacion }}</p>
                        @endif
                    </td>
                </tr>
            </table>
        </td>
        <td width="15%">
            @if($analisis->imprimir_firma)
            <img src="{{$pathQr}}" width="80">
            @endif
        </td>
    </tr>
</table>
