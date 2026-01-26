<h3 class="labci-h3">DATOS GENERALES:</h3>
<table class="labci-table">
    <tbody>
        <tr>
            <td>
                <p class="labci-table-p"><b>NOMBRE PACIENTE:</b> {{$analisis->person->apellidos.' '.$analisis->person->apellido_materno.', '.$analisis->person->nombres}}</p>
                <p class="labci-table-p"><b>FECHA DE NACIMIENTO:</b> <span>{{$analisis->person->f_nacimiento}}</span></p>
                <p class="labci-table-p"><b>CI/PASAPORTE:</b> <span>{{$analisis->person->ci}}</span></p>
                <p class="labci-table-p"><b>GENERO:</b> <span>{{(strcmp($analisis->person->sexo, 'hombre') == 0)? 'MASCULINO' : 'FEMENINO'}}</span></p>
                <p class="labci-table-p"><b>EDAD:</b> <span>{{$analisis->person->year_now}}</span></p>
                
            </td>
            <td>
                <p class="labci-table-p"><b>COD LAB:</b> <span>{{$analisis->codigo}}</span></p>
                <p class="labci-table-p"><b>FECHA DE SOLICITUD:</b> <span>{{$analisis->fecha->format('Y-m-d')}}</span></p>
                <p class="labci-table-p"><b>FECHA DE IMPRESIÒN:</b> <span>{{ \Carbon\Carbon::now()->format('d-m-Y, H:i:s') }}</span></p>
                <p class="labci-table-p"><b>RECEPCIONADO POR:</b> <span>{{$analisis->user->name}}</span></p>
                <p class="labci-table-p"><b>SOLICITANTE:</b> <span>{{$analisis->doctor}}</span></p>
            </td>
        </tr>
    </tbody>
</table>