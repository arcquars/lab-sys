<div style="width: 100%; text-align: center;">
    @if($analisis->imprimir_firma_supervisor)
        <table style="width: 95%">
            <tr>
                <td style="width: 50%; text-align: center;">
                @if (strcmp($analisis->doctorasig->signing, '') == 0)
                    <br>
                    <br>
                    <br>
                    <br>
                    <p style="margin: 0; font-size: 11px; font-weight: 700;">Dr. {{$analisis->doctorasig->nombres}} {{$analisis->doctorasig->apellidos}}</p>
                    <p style="margin: 1px; font-size: 8px">{{$analisis->doctorasig->especialidad}}</p>
                    <p style="margin: 1px; font-size: 8px">{{$analisis->doctorasig->matricula}}</p>
                @else
                    @if ($analisis->imprimir_firma)
                        <img width="180" src="{{public_path('uploads/signings/'.$analisis->doctorasig->signing)}}" alt="">
                    @endif
                @endif
                </td>
                <td style="width: 50%; text-align: center;">
                    @if ($analisis->doctor_supervisor != 0 && $analisis->imprimir_firma)
                        @if (strcmp($analisis->supervisor->signing, '') == 0)
                        <br>
                        <br>
                        <br>
                        <br>
                        <p style="margin: 0; font-size: 11px; font-weight: 700;">Dr. {{$analisis->supervisor->nombres}} {{$analisis->supervisor->apellidos}}</p>
                        <p style="margin: 1px; font-size: 8px">{{$analisis->supervisor->especialidad}}</p>
                        <p style="margin: 1px; font-size: 8px">{{$analisis->supervisor->matricula}}</p>
                        @else
                        <img width="180" src="{{public_path('uploads/signings/'.$analisis->supervisor->signing)}}" alt="">
                        @endif
                    @endif
                </td>
            </tr>
        </table>
    @else
        @if (strcmp($analisis->doctorasig->signing, '') == 0)
            <br>
            <br>
            <br>
            <br>
            <p style="margin: 0; font-size: 11px; font-weight: 700;">Dr. {{$analisis->doctorasig->nombres}} {{$analisis->doctorasig->apellidos}}</p>
            <p style="margin: 1px; font-size: 8px">{{$analisis->doctorasig->especialidad}}</p>
            <p style="margin: 1px; font-size: 8px">{{$analisis->doctorasig->matricula}}</p>
        @else
            @if ($analisis->imprimir_firma)
                <img width="180" src="{{public_path('uploads/signings/'.$analisis->doctorasig->signing)}}" alt="">
            @endif
        @endif
    @endif

</div>
<htmlpagefooter name="page-footer">
    <div style="width: 100%; text-align: center">
        <p style="font-size: 10px;">- {PAGENO} de {nbpg} -</p>
    </div>
</htmlpagefooter>
