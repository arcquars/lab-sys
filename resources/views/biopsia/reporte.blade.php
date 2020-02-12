@include('citologia.partial.reporte-style')
@include('citologia.partial.reporte-head')
<h3 class="h2-cito">INFORME HISTOPATOLOGICO</h3>
@include('citologia.partial.reporte-client', compact('analisis'))
<br>
<table style="width: 100%;">
    <tr>
        <td style="width: 100%;">
            @if (isset($biopsia->imagen1))
                <img src="{{$biopsia->imagen1}}" width="100%">
            @endif

        </td>
        <td style="width: 100%;">
            @if (isset($biopsia->imagen2))
                <img src="{{$biopsia->imagen2}}" width="100%">
            @endif
        </td>
        <td style="width: 100%;">
            @if (isset($biopsia->imagen3))
                <img src="{{$biopsia->imagen3}}" width="100%">
            @endif
        </td>
    </tr>
</table>
<h4 class="h4-cito">Organo o Tejido</h4>
<div class="div-campo">
    {!! $biopsia->organo_tejido !!}
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