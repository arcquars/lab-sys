@include('citologia.partial.reporte-style')
@include('citologia.partial.reporte-head')
<h3 class="h2-cito">INFORME CITOLOGICO - SISTEMA BETHESDA</h3>
@include('citologia.partial.reporte-client', compact('analisis'))
<br>
<h4 class="h4-cito">CELULAS OBSERVADAS</h4>
<div style="height: 6px;"></div>
<table style="width: 100%;">
    <tr>
        <td style="width: 33%;">
            @if ($bethesda->escamosas == 1)
                <p class="p-datos">(Si) Escamosas</p>
            @else
                <p class="p-datos">(No) Escamosas</p>
            @endif
        </td>
        <td style="width: 33%;">
            @if ($bethesda->glandulares == 1)
                <p class="p-datos">(Si) Glandulares</p>
            @else
                <p class="p-datos">(No) Glandulares</p>
            @endif
        </td>
        <td style="width: 34%;">
            @if ($bethesda->metaplasia == 1)
                <p class="p-datos">(Si) Metaplasia</p>
            @else
                <p class="p-datos">(No) Metaplasia</p>
            @endif
        </td>
    </tr>
</table>
<div style="height: 6px;"></div>
@if ($bethesda->calidad_muestra)
<h4 class="h4-cito">CALIDAD DE LA MUESTRA</h4>
<div class="div-campo">
    <p class="p-datos">{!! $bethesda->calidad_muestra !!}</p>
</div>
@endif
<br>
@if ($bethesda->clasificacion_general)
    <h4 class="h4-cito">CLASIFICACION GENERAL</h4>
    <div class="div-campo">
        <p  class="p-datos">{!! $bethesda->clasificacion_general !!}</p>
    </div>
@endif
<br>
@if ($bethesda->interpretacion)
    <h4 class="h4-cito">INTERPRETACION / RESULTADOS</h4>
    <div class="div-campo">
        @foreach($interpretaciones as $key => $value)
            <p class="p-datos">{{$value}}</p>
        @endforeach
    </div>
@endif
<br>
@if ($bethesda->celulas_observadas)
    <h4 class="h4-cito">FLORA:</h4>
    <div class="div-campo">
        <table style="width: 100%">
            @foreach($celulasObservadas as $key => $value)
                <tr>
                    @foreach($value as $key1 => $value1)
                        <td style="width: 33%"><p class="p-datos">(SI) {{$value1}}</p></td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>
@endif
<br>
@if ($bethesda->observaciones)
    <h4 class="h4-cito">OBSERVACIONES</h4>
    <div class="div-campo">
        <p class="p-datos">{!! $bethesda->observaciones !!}</p>
    </div>
@endif
@include('citologia.partial.reporte-footer', compact('analisis'))