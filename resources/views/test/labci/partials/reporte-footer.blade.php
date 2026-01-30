<h5 style="color: #00436b; font-size: 15px;">VALIDADO POR:</h5>
<?php
/** @var \App\Analisis $analisis */
/** @var  $chunkSupervisores */
$chunkSupervisores = $analisis->getSupervisoresVerificado()->chunk(3);
?>
@if(!$sin)
<div style="width: 100%; text-align: center;">
    @if($analisis->supervisar)
        @if(count($analisis->getSupervisoresVerificado()) == 0)
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
            </tr>
        </table>
        @else
        <table style="width: 95%">
            @foreach($chunkSupervisores as $cs)
            <tr>
                @foreach($cs as $index => $asupervisor)
                    @if($index == 0)
                        <td style="width: 25%; text-align: center;">
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
                    @endif
                <td style="width: 25%; text-align: center;">
                    @if (strcmp($asupervisor->doctorSupervisor->signing, '') == 0)
                        <br>
                        <br>
                        <br>
                        <br>
                        <p style="margin: 0; font-size: 11px; font-weight: 700;">Dr. {{$asupervisor->doctorSupervisor->nombres}} {{$asupervisor->doctorSupervisor->apellidos}}</p>
                        <p style="margin: 1px; font-size: 8px">{{$asupervisor->doctorSupervisor->especialidad}}</p>
                        <p style="margin: 1px; font-size: 8px">{{$asupervisor->doctorSupervisor->matricula}}</p>
                    @else
                        <img width="180" src="{{public_path('uploads/signings/'.$asupervisor->doctorSupervisor->signing)}}" alt="">
                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
        </table>
        @endif
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
@endif
<htmlpagefooter name="page-footer">
    <div style="width: 100%; text-align: center; border-top: 2px solid #0b6d9a;">
        <table style="width: 100%; margin: 0; padding: 0;">
            <tbody>
                <tr>
                    <td style="width: 75%">
                        <p style="font-size: 10px; margin: 0; padding: 0;">Av. Oquendo #270 entre Bolivar y Sucre acera oeste.</p>
                    </td>
                    <td style="width: 25%; text-align: right;">
                        <p style="font-size: 10px; margin: 0; padding: 0;">72218337 - 4507861</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p style="font-size: 10px; color: #0b6d9a; margin: 0; padding: 0;">Página {PAGENO} de {nbpg}</p>
    </div>
</htmlpagefooter>