@include('citologia.partial.reporte-style')
@include('citologia.partial.reporte-head')
<h3 class="h2-cito">INFORME INMUNOHISTOQUIMICA</h3>
@include('citologia.partial.reporte-client', compact('analisis'))
<br>
<h4 class="h4-cito">Interpretacion</h4>
<div class="div-campo">
    {!! $histo->interpretacion !!}
</div>
<h4 class="h4-cito">Tecnica</h4>
<div class="div-campo">
    {!! $histo->tecnica !!}
</div>
<h4 class="h4-cito">Bibliografia</h4>
<div class="div-campo">
    {!! $histo->bibliografia !!}
</div>
<div style="height: 25px;"></div>
@include('citologia.partial.reporte-footer', compact('analisis'))