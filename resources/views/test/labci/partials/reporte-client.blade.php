<h3 class="labci-h3">DATOS GENERALES:</h3>
<table class="labci-table-4">
    <tbody>
        <tr>
            <td>
                <p class="labci-table-p-b"><b>NOMBRE PACIENTE:</b></p>
            </td>
            <td>
                <p class="labci-table-p">{{$analisis->person->apellidos.' '.$analisis->person->apellido_materno.', '.$analisis->person->nombres}}</p>
            </td>
            <td>
                <p class="labci-table-p-b"><b>COD LAB:</b></p>
            </td>
            <td>
                <p class="labci-table-p">{{$analisis->codigo}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="labci-table-p-b"><b>FECHA DE NACIMIENTO:</b></p>
                
            </td>
            <td>
                <p class="labci-table-p">{{$analisis->person->f_nacimiento}}</p>
            </td>
            <td>
                <p class="labci-table-p-b"><b>FECHA DE SOLICITUD:</b></p>
            </td>
            <td>
                <p class="labci-table-p">{{$analisis->fecha->format('Y-m-d')}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="labci-table-p-b"><b>CI/PASAPORTE:</b></p>
                
            </td>
            <td>
                <p class="labci-table-p">{{$analisis->person->ci}}</p>
            </td>
            <td>
                <p class="labci-table-p-b"><b>FECHA DE IMPRESIÒN:</b></p>
            </td>
            <td>
                <p class="labci-table-p">{{ \Carbon\Carbon::now()->format('d-m-Y, H:i:s') }}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="labci-table-p-b"><b>GENERO:</b></p>
            </td>
            <td>
                <p class="labci-table-p">{{(strcmp($analisis->person->sexo, 'hombre') == 0)? 'MASCULINO' : 'FEMENINO'}}</p>
            </td>
            <td>
                <p class="labci-table-p-b"><b>RECEPCIONADO POR:</b></p>
            </td>
            <td>
                <p class="labci-table-p">{{$analisis->user->name}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="labci-table-p-b"><b>EDAD:</b></p>
                
            </td>
            <td>
                <p class="labci-table-p">{{$analisis->person->year_now}}</p>
            </td>
            <td>
                <p class="labci-table-p-b"><b>SOLICITANTE:</b></p>
            </td>
            <td>
                <p class="labci-table-p">{{$analisis->doctor}}</p>
            </td>
        </tr>
    </tbody>
</table>