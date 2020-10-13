<div style="width: 100%; text-align: center;">
    @if ($analisis->imprimir_firma)
        @if (strcmp($analisis->doctorasig->signing, '') == 0)
            <br>
            <br>
            <br>
            <br>
            <p style="margin: 0; font-size: 11px; font-weight: 700;">Dr. {{$analisis->doctorasig->nombres}} {{$analisis->doctorasig->apellidos}}</p>
            <p style="margin: 1px; font-size: 8px">{{$analisis->doctorasig->especialidad}}</p>
            <p style="margin: 1px; font-size: 8px">{{$analisis->doctorasig->matricula}}</p>
        @else
            <img width="180" src="{{public_path('uploads/signings/'.$analisis->doctorasig->signing)}}" alt="">
        @endif
    @endif
</div>
<htmlpagefooter name="page-footer">
    <div style="width: 100%; text-align: center">
        <p style="font-size: 10px;">- {PAGENO} de {nbpg} -</p>
    </div>

</htmlpagefooter>