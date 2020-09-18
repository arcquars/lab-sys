<div style="width: 100%; text-align: center;">
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
</div>
@if($analisis->fecha_entrega)
    <p style="text-align: center; font-size: 12px; font-weight: bold; color: #5e5e5e;">Cochabamba {{ $analisis->fecha_entrega->format('d') }} de {{ strtoupper(config('clinica.meses')[$analisis->fecha_entrega->format('n') -1]) }} de {{ $analisis->fecha_entrega->format('Y') }}</p>
@else
    <p style="text-align: center; font-size: 12px; font-weight: bold; color: #5e5e5e;">Cochabamba {{date('d')}} de {{ strtoupper(config('clinica.meses')[date('n')-1]) }} de {{date('Y')}}</p>
@endif
<htmlpagefooter name="page-footer">
    <div style="width: 100%; text-align: center">
        <p style="font-size: 10px;">-{PAGENO}-</p>
    </div>

</htmlpagefooter>