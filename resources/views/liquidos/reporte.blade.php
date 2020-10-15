@include('citologia.partial.reporte-style')
@include('citologia.partial.reporte-head')
<h3 class="h4-cito-1" style='text-align: center;'>INFORME CITOPATOLÓGICO</h3>
@include('citologia.partial.reporte-client', compact('analisis'))

<h4 class="h4-cito">ÓRGANO Y TEJIDO</h4>
<hr style="padding: 0; margin: 1px;">
<div class="div-campo" style="padding-left: 15px;">
    {!! $liquido->organo_tejido !!}
</div>
<br>
@if ($liquido->macroscopia)
<h4 class="h4-cito" style="text-transform: uppercase;">Macroscopia</h4>
<hr style="padding: 0; margin: 1px;">
<div class="div-campo">
    {!! $liquido->macroscopia !!}
</div>
@endif
@if ($liquido->microscopia)
<h4 class="h4-cito" style="text-transform: uppercase;">Microscopia</h4>
<hr style="padding: 0; margin: 1px;">
<div class="div-campo">
    {!! $liquido->microscopia !!}
</div>
@endif
@if ($liquido->diagnostico)
    <h4 class="h4-cito" style="text-transform: uppercase;">Diagnostico</h4>
    <hr style="padding: 0; margin: 1px;">
    <div class="div-campo">
        {!! $liquido->diagnostico !!}
    </div>
@endif

@include('citologia.partial.reporte-footer', compact('analisis'))