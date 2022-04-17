@include('citologia.partial.reporte-style')
@include('citologia.partial.reporte-head')
<h3 class="h4-cito" style='text-align: center;'>INFORME {{ __('clinica_msg.'.\App\Analisis::BIOLOGIA_MOLECULAR)}}</h3>
@include('citologia.partial.reporte-client', compact('analisis'))
<br>
<h4 class="h4-cito" style="text-transform: uppercase;">Interpretación</h4>
<hr style="margin: 2px 4px;">
<div class="div-campo">
    {!! $biologia->interpretacion !!}
</div>
<table style="width: 100%;">
    <tr>
        <td style="width: 25%;">
            @if (isset($biologia->imagen1))
                <img src="{{$biologia->imagen1}}" width="100%">
            @endif

        </td>
        <td style="width: 25%;">
            @if (isset($biologia->imagen2))
                <img src="{{$biologia->imagen2}}" width="100%">
            @endif
        </td>
        <td style="width: 25%;">
            @if (isset($biologia->imagen3))
                <img src="{{$biologia->imagen3}}" width="100%">
            @endif
        </td>
        <td style="width: 25%;">
            @if (isset($biologia->imagen4))
                <img src="{{$biologia->imagen4}}" width="100%">
            @endif
        </td>
    </tr>
</table>
<table style="width: 100%;">
    <tr>
        <td style="width: 25%; text-align: center;">
            @if (isset($biologia->titulo_1))
                <h5>{{$biologia->titulo_1}}</h5>
            @endif
        </td>
        <td style="width: 25%; text-align: center;">
            @if (isset($biologia->titulo_2))
                <h5>{{$biologia->titulo_2}}</h5>
            @endif
        </td>
        <td style="width: 25%; text-align: center;">
            @if (isset($biologia->titulo_3))
                <h5>{{$biologia->titulo_3}}</h5>
            @endif
        </td>
        <td style="width: 25%; text-align: center;">
            @if (isset($biologia->titulo_4))
                <h5>{{$biologia->titulo_4}}</h5>
            @endif
        </td>

    </tr>
</table>
<h4 class="h4-cito" style="text-transform: uppercase;">Técnica</h4>
<hr style="margin: 2px 4px;">
<div class="div-campo">
    @if($biologia->tecnica)
        {!! $biologia->tecnica !!}
    @else
        <p>{!! config('clinica.tecnica') !!}</p>
    @endif
</div>
@if(count($biologia->marcadores) > 0)
<h4 class="h4-cito">MARCADORES UTILIZADOS (clones entre paréntesis) Y RESULTADOS OBTENIDOS:</h4>
<hr style="margin: 2px 4px;">
<div class="div-campo">
    <table>
        @foreach($biologia->marcadores as $marcador)
            <tr>
                <td style="width: 40%;">
                    <p style="font-size: 10px; font-weight: 700;">{{$marcador->nombre}}:</p>
                </td>
                <td style="width: 60%;">
                    <p style="font-size: 9px;">{{$marcador->resultado}}</p>
                </td>
            </tr>
        @endforeach
    </table>
</div>
@endif
<h4 class="h4-cito" style="text-transform: uppercase;">Bibliografía</h4>
<hr style="margin: 2px 4px;">
<div class="div-campo">
    {!! $biologia->bibliografia !!}
</div>
@include('citologia.partial.reporte-footer', compact('analisis'))
