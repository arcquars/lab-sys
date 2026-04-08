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
use App\Helpers\ClinicaHelper;
if(!isset($sin)){
    $sin = null;
}
?>

@include('test.labci.partials.reporte-head')

<style>
    .text-danger {
        color: red;
    }

    .analysisTestTable {
        width: 100%;
        /* border-collapse: collapse; */
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 10px;
    }

    /* Padding aplicado a las cabeceras */
    .analysisTestTable thead tr th {
        font-size: 11px;
        color: #172554;
        border-bottom: 1px solid #000;
        padding: 4px 2px; /* Padding vertical y horizontal */
        text-align: center;
    }

    /* Padding aplicado a las celdas de datos para separar las filas */
    .analysisTestTable tbody td {
        border-bottom: 1px solid #A1A2A3;
        padding-top: 4px;    /* Espacio superior */
        padding-bottom: 4px; /* Espacio inferior */
        padding-left: 2px;
        padding-right: 2px;
        vertical-align: middle;
    }

    /* Estilo para las filas de encabezado de grupo */
    .group-header-row td {
        background-color: #E8EFFD;
        padding: 5px !important;
        text-align: center;
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

    .labci-h5-group {
        font-size: 12px; 
        color: #1e3a8a; 
        margin: 0;
        padding: 4px 0;
    }
</style>

<h3 style="color: #1e3a8a; font-size: 18px; text-align: center; margin-bottom: 2px; margin-top: 4px;;">INFORME RESULTADO DE LABORATORIO</h3> 

@include('test.labci.partials.reporte-client', compact('analisis', 'pathQr'))
@if($analisis->region && strcmp($analisis->region, "--") != 0)
<div>
    <h3 class="labci-h4-back">MUESTRA: {{ $analisis->region }}</h3>
</div>
@endif
@php
$index = 0;
@endphp

<table class="analysisTestTable">
    <thead>
    <tr>
        <th style="width: 40%">ANÁLISIS</th>
        <th style="width: 35%">RESULTADOS</th>
        <th style="width: 25%;">REFERENCIA</th>
    </tr>
    </thead>
    <tbody>
        {{-- Iniciamos la recursión con el array de grupos raíz --}}
        
        @include('test.partials.tree-node', [
            'items' => $treeGroups, 
            'analisisId' => $analisis->id
        ])
        
    </tbody>
</table>

<!-- <br> -->
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
                <td style="width: 40%;">
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