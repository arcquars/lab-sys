@include('citologia.partial.reporte-style')
@include('citologia.partial.reporte-head')
<h3 class="h4-cito" style='text-align: center;'>INFORME INMUNOHISTOQUIMICA</h3>
@include('citologia.partial.reporte-client', compact('analisis'))
<br>
<h4 class="h4-cito">Interpretacion</h4>
<div class="div-campo">
    {!! $histo->interpretacion !!}
</div>
<table style="width: 100%;">
    <tr>
        <td style="width: 25%;">
            @if (isset($histo->imagen1))
                <img src="{{$histo->imagen1}}" width="100%">
            @endif

        </td>
        <td style="width: 25%;">
            @if (isset($histo->imagen2))
                <img src="{{$histo->imagen2}}" width="100%">
            @endif
        </td>
        <td style="width: 25%;">
            @if (isset($histo->imagen3))
                <img src="{{$histo->imagen3}}" width="100%">
            @endif
        </td>
        <td style="width: 25%;">
            @if (isset($histo->imagen4))
                <img src="{{$histo->imagen4}}" width="100%">
            @endif
        </td>
    </tr>
</table>
<table style="width: 100%;">
    <tr>
        <td style="width: 25%; text-align: center;">
            @if (isset($histo->titulo_1))
                <h5>{{$histo->titulo_1}}</h5>
            @endif
        </td>
        <td style="width: 25%; text-align: center;">
            @if (isset($histo->titulo_2))
                <h5>{{$histo->titulo_2}}</h5>
            @endif
        </td>
        <td style="width: 25%; text-align: center;">
            @if (isset($histo->titulo_3))
                <h5>{{$histo->titulo_3}}</h5>
            @endif
        </td>
        <td style="width: 25%; text-align: center;">
            @if (isset($histo->titulo_4))
                <h5>{{$histo->titulo_4}}</h5>
            @endif
        </td>

    </tr>
</table>
<h4 class="h4-cito">Tecnica</h4>
<hr style="margin: 2px 4px;">
<div class="div-campo">
    {!! $histo->tecnica !!}
</div>
<h4 class="h4-cito">Bibliografia</h4>
<div class="div-campo">
    {!! $histo->bibliografia !!}
</div>
@include('citologia.partial.reporte-footer', compact('analisis'))