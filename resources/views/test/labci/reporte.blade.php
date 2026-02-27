<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @include('test.labci.partials.reporte-style')
    <style>
        @page {
            @if(isset($watermark))
                background: url("{{ $watermark['path'] }}") no-repeat center;
                background-image-resize: 1;
                background-image-opacity: {{ $watermark['alpha'] }};
            @endif
        }
    </style>
</head>
<body>
    
<?php
if(!isset($sin)){
    $sin = null;
}
?>

@include('test.labci.partials.reporte-head')

<style>

    .text-danger{
        color: red;
    }

    .analysisTestTable {
        border-collapse: collapse;
        display: inline-table;
    }
    .analysisTestTable tbody tr, .analysisTestTable tbody td{
        border-bottom: 1px solid #A1A2A3;
    }

    .analysisTestTable thead tr th{
        font-size: 13px;
        color: #172554;
        border-bottom: 1px solid #000;
    }

    .adjunto-container {
        text-align: center;
        margin-top: 20px;
        width: 100%;
    }

    .adjunto-img {
        max-width: 95%;
        max-height: 350px;
        border: 1px solid #A1A2A3;
        padding: 5px;
    }
</style>

<h3 style="color: #1e3a8a; font-size: 18px; text-align: center;">INFORME RESULTADO DE LABORATORIO</h3> 

@include('test.labci.partials.reporte-client', compact('analisis', 'pathQr'))
<div style="height: 10px;"></div>
@if($analisis->region && strcmp($analisis->region, "--") != 0)
<div>
    <h3 class="labci-h3">MUESTRA: {{ $analisis->region }}</h3>
</div>
@endif
@php
$index = 0;
@endphp
<!-- <br> -->
<table style="width: 99.99%" class="analysisTestTable">
    <thead>
    <tr>
        <th>ANÁLISIS</th>
        <th>RESULTADOS</th>
        <th>REFERENCIA</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orderGroupTest as $key => $testResults)
        @php
            $show = false;
            foreach($testResults as $testResult){
                if(isset($testResult['testResult']->result)){
                    $show = true;
                    $index++;
                    break;
                }
            }
        @endphp
        @if($show)
{{--            @if($index >= 34 && $index <= 35)--}}
            @if($sin)
                <tr style="border: none">
                    @if($index >= 34 && $index <= 35)
                        <td colspan="3" style="height: 70px">
                        </td>
                    @endif
                </tr>
            @else
                <tr style="border: none">
                    @if($index >= 34 && $index <= 35)
                        <td colspan="3" style="height: 15px">
                        </td>
                    @endif
                </tr>
            @endif
            <tr style="border: none; padding-bottom: 2px; padding-top: 2px; background-color: #E8EFFD; opacity: 0.4;">
                <td colspan="3" style="font-size: 13px; text-align: center;">
                    <h5 style="color: #1e3a8a;">{{$key}}</h5>
                </td>
            </tr>
            @foreach($testResults as $testResult)
                @if(isset($testResult['testResult']->result))
                    @php $index++; @endphp
                    <tr>
                        <td style="width: 33.33%; font-size: 12px;"><b>{{ $testResult['testResult']->aTest->name }}</b></td>
                        <td style=" width: 33.33%; font-size: 12px; text-align: center;">{!! $testResult['testResult']->aTest->analysisTestType? $testResult['testResult']->aTest->analysisTestType->getHtmlResult($testResult['testResult']->id, $testResult['testResult']->result) : "xxx" !!}</td>
                        <td style=" width: 33.33%; font-size: 10px; text-align: center;">
                            {!! $testResult['testResult']->aTest->analysisTestType? $testResult['testResult']->aTest->analysisTestType->getHtmlDescriptionResult($testResult['testResult']->id) : "yyy" !!}
                            
                        </td>
                    </tr>
                    @if(isset($testResult['testResult']->metodo))
                    <tr>
                        <td colspan="3" style="padding-left: 10px;">
                                <p style="font-size: 9px;"><b>METODO:</b> {{$testResult['testResult']->metodo}}</p>
                        </td>
                    </tr>
                    @endif
                @endif
            @endforeach
        @endif
    @endforeach
    </tbody>
</table>
@if($analisis->observaciones)
    <div style="page-break-inside: avoid;">
        <dl>
            <dt style="font-size: 14px; color: #1e3a8a;"><b>OBS:</b></dt>
            <dd style="font-size: 12px;">{{$analisis->observaciones}}</dd>
        </dl>
    </div>
@endif
<br>

@if($analisis->adjunto)
    <div class="adjunto-container">
        <p style="font-size: 14px; color: #1e3a8a;">IMAGEN ADJUNTA / REFERENCIA:</p>
        <img src="{{ public_path('uploads/test/' . $analisis->adjunto) }}" class="adjunto-img">
    </div>
@endif

@include('test.labci.partials.reporte-footer', compact('analisis', 'sin'))
@if($analisis->imprimir_firma && isset($pathQr))
    <br />
    <table style="width: 100%">
        <tbody>
            <tr>
                <td style="width: 60%">
                    <p style="font-size: 10px;">Liberado y disponible desde: {{ $analisis->fecha_cierre }}</p>
                    <p style="font-size: 10px;">Los resultados deben ser consultados con su médico para un mejor diagnostico.</p>
                </td>
                <td style="width: 40%; border: 1px solid #1e3a8a;">
                    <p style="font-size: 10px; margin: 4px; color: #000;"><b>LABORATORIO CLINICO Y DE INVESTIGACIÒN LABCI S.R.L</b></p>
                    <div style="height: 2px;"></div>
                    <p style="font-size: 9px; font-weight: 900;">Realiza control de calidad externo con: INLASA y CENETROP.</p>
                    <p style="font-size: 9px; font-weight: 900;">Habilitado por Servicio Departamental de Salud SEDES - R. ADM-424</p>
                </td>
            </tr>
        </tbody>
    </table>
@endif
</body>
</html>