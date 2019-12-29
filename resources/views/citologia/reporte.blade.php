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
</style>
@include('citologia.partial.reporte-head')
<h3 class="h2-cito">INFORME CITOLOGICO</h3>
@include('citologia.partial.reporte-client', compact('analisis'))
<h3 class="h2-cito">RESULTADO</h3>
<p class="p-dato"><b>Clasificacion del Papanicolaou Clase: </b> {{'( '.$resultados->papanicolaou_clase1.' ) '.$resultados->papanicolaou_clase2}}</p>
<h3 class="h2-cito" style="text-transform: uppercase;">Extendido Compatible con los Diagnosticos</h3>
@php
    $secciones = array_chunk(Config::get('clinica.extendido_compatible'), 3);
@endphp
<table width="100%">
    @foreach($secciones as $secc)
        <tr>
                @foreach($secc as $key => $value12)
                    @php
                        $item = '( _ ) ';
                    @endphp
                    @foreach($seccionExtendidoCompatible as $seccExtComp)
                        @if (strcmp($seccExtComp->key, $value12) == 0)
                            @php
                                $item = '(SI) ';
                            @endphp
                        @endif
                    @endforeach
                    <td width="33%"><p class="p-dato">{{ $item }} {{ $value12}}</p></td>
                @endforeach

        </tr>
    @endforeach
</table>
<table class="t-extcompatible" width="100%">
    <tr>
        <td width="33%"><p class="t-column-title">OMS</p></td>
        <td width="34%"><p class="t-column-title">RICHART</p></td>
        <td width="33%"><p class="t-column-title">BETHESDA</p></td>
    </tr>
    <tr>
        <td style="text-align: left; padding: 1px; vertical-align: top">
            <table width="100%">
                @foreach ($seccionOMG as $seccOmg)
                    <tr>
                        <td width="65%" style="text-align: left">
                            <p class="p-dato">{{str_replace('-', ' ', $seccOmg->key)}}</p>
                        </td>
                        <td width="35%">
                            <p class="p-dato">{{$seccOmg->value}}</p>
                        </td>
                    </tr>
                @endforeach
            </table>
        </td>
        <td style="text-align: left; padding: 1px; vertical-align: top">
            <table width="100%">
                @foreach ($seccionRichart as $seccR)
                    <tr>
                        <td width="65%" style="text-align: left">
                            <p class="p-dato">{{str_replace('-', ' ', $seccR->key)}}</p>
                        </td>
                        <td width="35%">
                            <p class="p-dato">{{$seccR->value}}</p>
                        </td>
                    </tr>
                @endforeach
            </table>
        </td>
        <td style="text-align: left; padding: 1px; vertical-align: top">
            <table width="100%">
                @foreach ($seccionBeth as $seccB)
                    <tr>
                        <td width="65%" style="text-align: left">
                            <p class="p-dato">{{str_replace('-', ' ', $seccB->key)}}</p>
                        </td>
                        <td width="35%">
                            <p class="p-dato">{{$seccB->value}}</p>
                        </td>
                    </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>
<br>
<h3 class="h2-cito" style="text-transform: uppercase;">Reaccion Inflamatoria</h3>
@php
    $reaccInflamatorias = array_chunk(Config::get('clinica.reac_inflamatoria'), 3);
@endphp
<table width="100%">
    @foreach($reaccInflamatorias as $secc)
        <tr>
            @foreach($secc as $key => $value12)
                @php
                    $item = '( _ ) ';
                @endphp
                @foreach($seccionReacInflamatoria as $seccReacInfla)
                    @if (strcmp($seccReacInfla->key, $value12) == 0)
                        @php
                            $item = '(SI) ';
                        @endphp
                    @endif
                @endforeach
                <td width="33%"><p class="p-dato">{{ $item }} {{ $value12}}</p></td>
            @endforeach

        </tr>
    @endforeach
</table>
<br>
<h3 class="h2-cito" style="text-transform: uppercase;">Estudio Microbiologico</h3>
@php
    $reaccEstMicro = array_chunk(Config::get('clinica.estudio_microbiologico'), 3);
@endphp
<table width="100%">
    @foreach($reaccEstMicro as $secc)
        <tr>
            @foreach($secc as $key => $value12)
                @php
                    $item = '( _ ) ';
                @endphp
                @foreach($seccionEstudioMicro as $seccEstMicro)
                    @if (strcmp($seccEstMicro->key, $value12) == 0)
                        @php
                            $item = '(SI) ';
                        @endphp
                    @endif
                @endforeach
                <td width="33%"><p class="p-dato">{{ $item }} {{ $value12}}</p></td>
            @endforeach

        </tr>
    @endforeach
</table>
<div style="height: 10px;"></div>
@include('citologia.partial.reporte-fecha', compact('analisis'))