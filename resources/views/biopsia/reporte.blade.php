<style>
    .h1-cito{
        text-align: center;
        color: #012035;
        font-size: 16px;
        margin: 0;
        padding: 0;
    }
    .h2-cito{
        text-align: center;
        color: #012035;
        font-size: 12px;
        margin: 0;
        padding: 0;
    }

    .h4-cito{
        color: #053D62;
        font-size: 10px;
        margin: 0;
        padding: 0;
    }
    .td-p-datos{
        font-size: 10px;
        color: #053D62;
    }

    .p-dato {
        font-size: 11px;
        color: #012035;
    }

    .t-extcompatible tr td{
        text-align: center;
        border: 1px solid;
    }

    .t-column-title{
        color: #012035;
        font-size: 10px;
        font-weight: bold;

    }

    .div-campo{
        padding: 2px;
        text-align: justify;
        text-justify: inter-word;
    }

    .div-campo h2 {
        font-size: 16px;
    }

    .div-campo h3 {
        font-size: 14px;
    }

    .div-campo h4 {
        font-size: 12px;
    }

    .div-campo p{
        font-size: 11px;
    }

    .div-campo ul li{
        font-size: 11px;
    }

    .div-campo ol li{
        font-size: 11px;
    }
</style>
@include('citologia.partial.reporte-head')
<h3 class="h2-cito">INFORME HISTOPATOLOGICO</h3>
@include('citologia.partial.reporte-client', compact('analisis'))
<h3 class="h2-cito">RESULTADO</h3>
<br>
<h4 class="h4-cito">Organo o Tejido</h4>
<div class="div-campo">
    {!! $biopsia->organo_tejido !!}
</div>
<h4 class="h4-cito">Macroscopia</h4>
<div class="div-campo">
    {!! $biopsia->macroscopia !!}
</div>
<h4 class="h4-cito">Microscopia</h4>
<div class="div-campo">
    {!! $biopsia->microscopia !!}
</div>
<h4 class="h4-cito">Diagnostico</h4>
<div class="div-campo">
    {!! $biopsia->diagnostico !!}
</div>
<div style="height: 20px;"></div>
@include('citologia.partial.reporte-fecha', compact('analisis'))