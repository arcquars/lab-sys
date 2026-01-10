<table style="width: 100%">
    <tbody>
        <tr>
            <td style="width: 3%;">
                <img src="{{public_path('img/juve-labels/1.png')}}" width="16" style="margin-bottom: 4px;" />
            </td>
            <td style="width: 28%; text-align: center;">
                <h3 class="juve-client-h3">{{ $analisis->person->nombres . " " . $analisis->person->apellidos.' '.$analisis->person->apellido_materno}}</h3>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%;">
                            <h5 class="juve-client-h5">EDAD</h5>
                        </td>
                        <td style="width: 50%;">
                            <h5 class="juve-client-h5">SEXO</h5>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">
                            <p class="rclient-data">{{$analisis->edad}} años</p>
                        </td>
                        <td style="width: 50%;">
                            <p class="rclient-data">{{(strcmp($analisis->person->sexo, 'hombre') == 0)? 'MASCULINO' : 'FEMENINO'}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h5 class="juve-client-h5">CARNET DE IDENTIDAD</h5>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p class="rclient-data">{{ $analisis->person->ci }}</p>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 3%;">
                <img src="{{public_path('img/juve-labels/2.png')}}" width="16" style="margin-bottom: 4px;" />
            </td>
            <td style="width: 28%; text-align: center; vertical-align: top;">
                <h3 class="juve-client-h3">A QUIEN CORRESPONDA</h3>
                <br />
                <p class="rclient-data">{{$analisis->institucion->nombre}}</p>
            </td>
            <td style="width: 3%;">
                <img src="{{public_path('img/juve-labels/3.png')}}" width="16" style="margin-bottom: 4px;" />
            </td>
            <td style="width: 29%; text-align: center; vertical-align: top;">
                <h3 class="juve-client-h3">{{ $analisis->codigo }}</h3>
                <h5 class="juve-client-h5">FECHA DE TOMA MUESTRA</h5>
                <p class="rclient-data">{{ $analisis->fecha }}</p>
                <h5 class="juve-client-h5">FECHA DE EMISION DE INFORME</h5>
                <p class="rclient-data">{{ \Carbon\Carbon::now()->format('d-m-Y, H:i:s') }}</p>
            </td>
        </tr>
    </tbody>
</table>
