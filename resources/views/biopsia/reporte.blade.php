@include('citologia.partial.reporte-style')
@include('citologia.partial.reporte-head')
<h3 class="h2-cito">INFORME HISTOPATOLOGICO</h3>
@include('citologia.partial.reporte-client', compact('analisis'))
<br>
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