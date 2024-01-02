@include('citologia.partial.reporte-style')
@include('citologia.partial.reporte-head')
<h3 class="h4-cito" style='text-align: center;'>INFORME INMUNOHISTOQUIMICA</h3>
@include('citologia.partial.reporte-client', compact('analisis'))
<br>
<h4 class="h4-cito">{!! $analisis->region !!}</h4>
<div style="height: 6px;"></div>
<h4 class="h4-cito" style="text-transform: uppercase;">Interpretación</h4>
<hr style="margin: 2px 4px;">
<div class="aa">
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
<h4 class="h4-cito" style="text-transform: uppercase;">Técnica</h4>
<hr style="margin: 2px 4px;">
<div class="div-campo">
    @if($histo->tecnica)
        {!! $histo->tecnica !!}
    @else
        <p>{!! config('clinica.tecnica') !!}</p>
    @endif
</div>
@if(count($histo->marcadores) > 0)
<h4 class="h4-cito">MARCADORES UTILIZADOS (clones entre paréntesis) Y RESULTADOS OBTENIDOS:</h4>
<hr style="margin: 2px 4px;">
<div class="div-campo">
    <table class="histo_table">
        <thead>
        <tr>
            <th>Marcador</th>
            <th>Resultado</th>
        </tr>
        </thead>
        <tbody>
        @foreach($histo->marcadores as $marcador)
            <tr>
                <td style="width: 50%;">
                    <p style="font-size: {{ $histo->size_texto_marcadores? $histo->size_texto_marcadores : 10 }}px; font-weight: 700;">{{$marcador->nombre}}:</p>
                </td>
                <td style="width: 50%;">
                    <p style="font-size: {{ $histo->size_texto_marcadores? $histo->size_texto_marcadores : 10 }}px;">{{$marcador->resultado}}</p>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
</div>
<br>
<br>
@endif
<h4 class="h4-cito" style="text-transform: uppercase;">Bibliografía</h4>
<hr style="margin: 2px 4px;">
<div class="div-campo">
    {!! $histo->bibliografia !!}
</div>
@include('citologia.partial.reporte-footer', compact('analisis'))
