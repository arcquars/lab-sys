@include('citologia.partial.reporte-style')
@include('citologia.partial.reporte-head')
<h3 class="h4-cito-1" style='text-align: center;'>INFORME HISTOPATOLOGICO</h3>
@include('citologia.partial.reporte-client', compact('analisis', 'pathQr'))

<h4 class="h4-cito">ÓRGANO Y TEJIDO</h4>
<hr style="padding: 0; margin: 1px;">
<div class="div-campo" style="padding-left: 15px;">
    @if($analisis->id == 102695)
        {!! $biopsia->organo_tejido !!}
    @else
        {!! ($biopsia->is_histopatologico == 1)? 'BIOPSIAS DE RIÑON' : $biopsia->organo_tejido !!}
    @endif
</div>
<br>
<table class="t_images_4" style="width: 100%; border-collapse:collapse;">
    <tr>
        <td style="max-width: 25%;">
            @if (isset($biopsia->titulo_1))
                <p class="t_images_4_p">{{$biopsia->titulo_1}}</p>
            @endif
            @if (isset($biopsia->imagen1))
                <p><img src="{{$biopsia->imagen1}}" style="max-width: 25%;"></p>
            @endif

        </td>
        <td style="max-width: 25%;">
            @if (isset($biopsia->titulo_2))
                <p class="t_images_4_p">{{$biopsia->titulo_2}}</p>
            @endif
            @if (isset($biopsia->imagen2))
                <p><img src="{{$biopsia->imagen2}}" style="max-width: 25%;"></p>
            @endif
        </td>
        <td style="max-width: 25%;">
            @if (isset($biopsia->titulo_3))
                <p class="t_images_4_p">{{$biopsia->titulo_3}}</p>
            @endif
            @if (isset($biopsia->imagen3))
                <p><img src="{{$biopsia->imagen3}}" style="max-width: 25%;"></p>
            @endif
        </td>
        <td style="max-width: 25%;">
            @if (isset($biopsia->titulo_4))
                <p class="t_images_4_p">{{$biopsia->titulo_4}}</p>
            @endif
            @if (isset($biopsia->imagen4))
                <p><img src="{{$biopsia->imagen4}}" style="max-width: 25%;"></p>
            @endif
        </td>
    </tr>
</table>
@if ($biopsia->is_histopatologico)
<h4 class="h4-cito">IMAGENES HISTOPATOLOGICOS</h4>
<hr style="padding: 0; margin: 1px;">
<table style="width: 100%;">
    <tr>
        <td style="width: 14%; text-align: center; padding: 4px">
            @if (isset($biopsia->histopatologico_nombre1))
                <p class="t_images_4_p">{{$biopsia->histopatologico_nombre1}}</p>
            @endif
            @if (isset($biopsia->histopatologico_imagenes1))
                <p><img src="{{$biopsia->histopatologico_imagenes1}}" style="max-width: 14%;"></p>
            @endif
        </td>
        <td style="min-width: 14%; width: 20%; text-align: center; padding: 4px">
            @if (isset($biopsia->histopatologico_nombre2))
                <p class="t_images_4_p">{{$biopsia->histopatologico_nombre2}}</p>
            @endif
            @if (isset($biopsia->histopatologico_imagenes2))
                <p><img src="{{$biopsia->histopatologico_imagenes2}}" style="max-width: 14%;"></p>
            @endif
        </td>
        <td style="width: 14%; text-align: center; padding: 4px">
            @if (isset($biopsia->histopatologico_nombre3))
                <p class="t_images_4_p">{{$biopsia->histopatologico_nombre3}}</p>
            @endif
            @if (isset($biopsia->histopatologico_imagenes3))
                <p><img src="{{$biopsia->histopatologico_imagenes3}}" style="max-width: 14%;"></p>
            @endif
        </td>
        <td style="width: 14%; text-align: center; padding: 4px">
            @if (isset($biopsia->histopatologico_nombre4))
                <p class="t_images_4_p">{{$biopsia->histopatologico_nombre4}}</p>
            @endif
            @if (isset($biopsia->histopatologico_imagenes4))
                <p><img src="{{$biopsia->histopatologico_imagenes4}}" style="max-width: 14%;"></p>
            @endif

        </td>
        <td style="width: 14%; text-align: center; padding: 4px">
            @if (isset($biopsia->histopatologico_nombre5))
                <p class="t_images_4_p">{{$biopsia->histopatologico_nombre5}}</p>
            @endif
            @if (isset($biopsia->histopatologico_imagenes5))
                <p><img src="{{$biopsia->histopatologico_imagenes5}}" style="max-width: 14%;"></p>
            @endif

        </td>
        <td style="width: 15%; text-align: center; padding: 4px">
            @if (isset($biopsia->histopatologico_nombre6))
                <p class="t_images_4_p">{{$biopsia->histopatologico_nombre6}}</p>
            @endif
            @if (isset($biopsia->histopatologico_imagenes6))
                <p><img src="{{$biopsia->histopatologico_imagenes6}}" style="max-width: 14%;"></p>
            @endif

        </td>
        <td style="width: 15%; text-align: center; padding: 4px">
            @if (isset($biopsia->histopatologico_nombre7))
                <p class="t_images_4_p">{{$biopsia->histopatologico_nombre7}}</p>
            @endif
            @if (isset($biopsia->histopatologico_imagenes7))
                <p><img src="{{$biopsia->histopatologico_imagenes7}}" style="max-width: 14%;"></p>
            @endif

        </td>
    </tr>
</table>
@endif
<br>
@if ($biopsia->macroscopia)
    <hr style="padding: 0; margin: 1px;">
<h4 class="h4-cito" style="text-transform: uppercase;">Macroscopia</h4>
<div class="div-campo">
    {!! $biopsia->macroscopia !!}
</div>
@endif
@if ($biopsia->microscopia)
    <hr style="padding: 0; margin: 1px;">
    <h4 class="h4-cito" style="text-transform: uppercase;">Microscopia</h4>
<div class="div-campo">
    {!! $biopsia->microscopia !!}
</div>
@endif
@if ($biopsia->diagnostico)
    <hr style="padding: 0; margin: 1px;">
    <h4 class="h4-cito" style="text-transform: uppercase;">Diagnostico</h4>
    <div class="div-campo">
        {!! $biopsia->diagnostico !!}
    </div>
@endif

@include('citologia.partial.reporte-footer', compact('analisis'))
