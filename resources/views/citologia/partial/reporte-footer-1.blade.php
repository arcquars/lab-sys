<div style="width: 100%; text-align: center;">
    @if (strcmp($analisis->doctorasig->signing, '') == 0)
        <br>
        <br>
        <p style="margin: 0; font-size: 11px; font-weight: 700;">
            Dr. {{$analisis->doctorasig->nombres}} {{$analisis->doctorasig->apellidos}}</p>
        <p style="margin: 1px; font-size: 8px">{{$analisis->doctorasig->especialidad}}</p>
        <p style="margin: 1px; font-size: 8px">{{$analisis->doctorasig->matricula}}</p>
    @else
        @if ($analisis->imprimir_firma)
            <img width="180" src="{{public_path('uploads/signings/'.$analisis->doctorasig->signing)}}" alt="">
        @endif
    @endif
</div>
<htmlpagefooter name="page-footer">
    <div style="height: 8px;"></div>
    <table style="width: 100%">
        <tr>
            <td style="width: 50%">
                <small style="font-size: 9px;">Calle Lanza N° 0261, esq. Ecuador, Edificio Alba IV, Planta Baja</small>
            </td>
            <td style="width: 50%; text-align: right;">
                <small style="font-size: 9px;">Telfs: 4-4255172 – 4-4520344 – 67509705 E-Mail:
                    citopatologico@hotmail.com</small>
            </td>
        </tr>
    </table>
    <div style="width: 100%; text-align: center">
        <p style="font-size: 9px;">- {PAGENO} de {nbpg} -</p>
    </div>
</htmlpagefooter>
