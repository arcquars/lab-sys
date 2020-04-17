@include('citologia.partial.reporte-style')
@include('citologia.partial.reporte-head')
<h3 class="h4-cito-1" style='text-align: center;'>INFORME HISTOPATOLOGICO</h3>
@include('citologia.partial.reporte-client', compact('analisis'))
<br>
<table style="width: 100%;">
    <tr>
        <td style="width: 25%;">
            @if (isset($biopsia->imagen1))
                <img src="{{$biopsia->imagen1}}" width="100%">
            @endif

        </td>
        <td style="width: 25%;">
            @if (isset($biopsia->imagen2))
                <img src="{{$biopsia->imagen2}}" width="100%">
            @endif
        </td>
        <td style="width: 25%;">
            @if (isset($biopsia->imagen3))
                <img src="{{$biopsia->imagen3}}" width="100%">
            @endif
        </td>
        <td style="width: 25%;">
            @if (isset($biopsia->imagen4))
                <img src="{{$biopsia->imagen4}}" width="100%">
            @endif
        </td>
    </tr>
</table>
<table style="width: 100%;">
    <tr>
        <td style="width: 25%; text-align: center;">
            @if (isset($biopsia->titulo_1))
                <h5>{{$biopsia->titulo_1}}</h5>
            @endif
        </td>
        <td style="width: 25%; text-align: center;">
            @if (isset($biopsia->titulo_2))
                <h5>{{$biopsia->titulo_2}}</h5>
            @endif
        </td>
        <td style="width: 25%; text-align: center;">
            @if (isset($biopsia->titulo_3))
                <h5>{{$biopsia->titulo_3}}</h5>
            @endif
        </td>
        <td style="width: 25%; text-align: center;">
            @if (isset($biopsia->titulo_4))
                <h5>{{$biopsia->titulo_4}}</h5>
            @endif
        </td>
    </tr>
</table>
@if ($biopsia->is_histopatologico)
    <hr>
<h4 class="h4-cito">Imagenes Histopatologicos</h4>
    <br>
<table style="width: 100%;">
    <tr>
        <td style="width: 14%; text-align: center; padding: 4px">
            @if (isset($biopsia->histopatologico_imagenes1))
                <img src="{{$biopsia->histopatologico_imagenes1}}" width="100%">
            @endif
                @if (isset($biopsia->histopatologico_nombre1))
                    <h5 style="font-size: 65px;">{{$biopsia->histopatologico_nombre1}}</h5>
                @endif
        </td>
        <td style="min-width: 14%; width: 20%; text-align: center; padding: 4px">
            @if (isset($biopsia->histopatologico_imagenes2))
                <img src="{{$biopsia->histopatologico_imagenes2}}" width="100%">
            @endif
                @if (isset($biopsia->histopatologico_nombre2))
                    <h5 style="font-size: 65px;">{{$biopsia->histopatologico_nombre2}}</h5>
                @endif
        </td>
        <td style="width: 14%; text-align: center; padding: 4px">
            @if (isset($biopsia->histopatologico_imagenes3))
                <img src="{{$biopsia->histopatologico_imagenes3}}" width="100%">
            @endif
                @if (isset($biopsia->histopatologico_nombre3))
                    <h5 style="font-size: 65px;">{{$biopsia->histopatologico_nombre3}}</h5>
                @endif
        </td>
        <td style="width: 14%; text-align: center; padding: 4px">
            @if (isset($biopsia->histopatologico_imagenes4))
                <img src="{{$biopsia->histopatologico_imagenes4}}" width="100%">
            @endif
                @if (isset($biopsia->histopatologico_nombre4))
                    <h5 style="font-size: 65px;">{{$biopsia->histopatologico_nombre4}}</h5>
                @endif
        </td>
        <td style="width: 14%; text-align: center; padding: 4px">
            @if (isset($biopsia->histopatologico_imagenes5))
                <img src="{{$biopsia->histopatologico_imagenes5}}" width="100%">
            @endif
            @if (isset($biopsia->histopatologico_nombre5))
                <h5 style="font-size: 65px;">{{$biopsia->histopatologico_nombre5}}</h5>
            @endif
        </td>
        <td style="width: 15%; text-align: center; padding: 4px">
            @if (isset($biopsia->histopatologico_imagenes6))
                <img src="{{$biopsia->histopatologico_imagenes6}}">
            @endif
            @if (isset($biopsia->histopatologico_nombre6))
                <h5 style="font-size: 65px;">{{$biopsia->histopatologico_nombre6}}</h5>
            @endif
        </td>
        <td style="width: 15%; text-align: center; padding: 4px">
            @if (isset($biopsia->histopatologico_imagenes7))
                <img src="{{$biopsia->histopatologico_imagenes7}}" style="width: 100%;">
            @endif
            @if (isset($biopsia->histopatologico_nombre7))
                <h5 style="font-size: 65px;">{{$biopsia->histopatologico_nombre7}}</h5>
            @endif
        </td>
    </tr>
</table>
@endif
<hr>
<h4 class="h4-cito">Organo o Tejido</h4>
<div class="div-campo">
    {!! ($biopsia->is_histopatologico == 1)? 'BIOPSIAS DE RIÑON' : $biopsia->organo_tejido !!}
</div>
@if ($biopsia->macroscopia)
<h4 class="h4-cito">Macroscopia</h4>
<div class="div-campo">
    {!! $biopsia->macroscopia !!}
</div>
@endif
@if ($biopsia->microscopia)
<h4 class="h4-cito">Microscopia</h4>
<div class="div-campo">
    {!! $biopsia->microscopia !!}
</div>
@endif
@if ($biopsia->diagnostico)
    <h4 class="h4-cito">Diagnostico</h4>
    <div class="div-campo">
        {!! $biopsia->diagnostico !!}
    </div>
@endif

@include('citologia.partial.reporte-footer', compact('analisis'))