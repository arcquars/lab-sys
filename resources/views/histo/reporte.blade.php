@include('citologia.partial.reporte-style')
@include('citologia.partial.reporte-head-1')
<h3 class="h4-cito" style='text-align: center;'>INFORME INMUNOHISTOQUIMICA <br> Y PATOLOGIA MOLECULAR</h3>
@include('citologia.partial.reporte-client', compact('analisis'))
<br>
<hr style="margin: 2px 4px;">
<h4 class="h4-cito" >{!! $analisis->region !!}</h4>
<div style="height: 5px;"></div>
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
    <table style="width: 100%">
        <tr>
            <td style="width: 25%; vertical-align: top; ">
                <img src="{{public_path('img/tecnica-image-default.png')}}" width="150">
            </td>
            <td style="width: 85%; text-align: justify; text-justify: inter-word;">
                <p>{!! config('clinica.tecnica') !!}</p>
{{--                @if($histo->tecnica)--}}
{{--                    {!! $histo->tecnica !!}--}}
{{--                @else--}}
{{--                    <p>{!! config('clinica.tecnica') !!}</p>--}}
{{--                @endif--}}
            </td>
        </tr>
    </table>
</div>
@if(count($histo->marcadores) > 0)
<h4 class="h4-cito">MARCADORES UTILIZADOS (clones entre paréntesis) Y RESULTADOS OBTENIDOS:</h4>
<hr style="margin: 2px 4px;">
<div class="div-campo">
    <table class="histo_table">
        <thead>
        <tr>

            @if($hasIntensidad)
                @if($hasImage)
                    <th colspan="2" style="text-align: center">Resultado</th>
                @else
                    <th style="text-align: center">Resultado</th>
                @endif

                <th style="text-align: right">Intensidad</th>
            @else
                <th style="text-align: center">Resultado</th>
{{--                <th style="text-align: right">Intensidad</th>--}}
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($histo->marcadores as $marcador)
            <tr>
                @if($hasIntensidad)
                    @if($hasImage)
                <td style="width: 20%;">
                    @if($marcador->path_image)
                        <img src="{{$marcador->path }}" width="120">
                    @endif
                </td>
                    @endif
                <td style="width: @if($hasImage) 65%; @else 85%; @endif vertical-align: top; text-align: justify; text-justify: inter-word; padding-right: 10px;">
                    <p style="font-size: {{ $histo->size_texto_marcadores? $histo->size_texto_marcadores : 10 }}px; font-weight: 700;"><b>{{$marcador->nombre}}:</b> {{$marcador->resultado}}</p>
                </td>
                <td style="width: 15%; vertical-align: top; text-align: center;  text-justify: inter-word;">
                    <p style="font-size: {{ $histo->size_texto_marcadores? $histo->size_texto_marcadores : 10 }}px;">{{$marcador->intensidad}}</p>
                </td>
                @else
                    @if($hasImage)
                    <td style="width: 20%;">
                        @if($marcador->path_image)
                            <img src="{{$marcador->path }}" width="120">
                        @endif
                    </td>
                    @endif
                    <td style="width: @if($hasImage) 80%; @else 100%; @endif vertical-align: top; text-align: justify; text-justify: inter-word; padding-right: 10px;">
                        <p style="font-size: {{ $histo->size_texto_marcadores? $histo->size_texto_marcadores : 10 }}px; font-weight: 700;"><b>{{$marcador->nombre}}:</b> {{$marcador->resultado}}</p>
                    </td>
                @endif

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
@include('citologia.partial.reporte-footer-1', compact('analisis'))
