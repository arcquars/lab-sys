<?php
if(!isset($sin)){
    $sin = null;
}
?>
@include('citologia.partial.reporte-style')
@include('citologia.partial.reporte-head')
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
        font-size: 12px;
        border-bottom: 1px solid #000;
    }

</style>
{{--<h3 class="h4-cito-1" style='text-align: center;'>INFORME PRUEBA</h3>--}}
@include('citologia.partial.reporte-client', compact('analisis'))
@php
$index = 0;
@endphp
<br>
<table style="width: 99.99%" class="analysisTestTable">
    <thead>
    <tr>
        <th>ANÁLISIS</th>
        <th>RESULTADOS</th>
        <th>VALORES DE REFERENCIA</th>
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
            <tr style="border: none;">
                <td colspan="3  " style="padding-top: 15px; font-size: 14px">
                    <h5>{{$key}}</h5>
                </td>
            </tr>
            @foreach($testResults as $testResult)
                @if(isset($testResult['testResult']->result))
                    @php $index++; @endphp
                    <tr>
                        <td style="width: 33.33%; font-size: 13px;">{{ $testResult['testResult']->aTest->name }}</td>
                        <td style=" width: 33.33%; font-size: 13px; text-align: center;">{!! $testResult['testResult']->aTest->analysisTestType? $testResult['testResult']->aTest->analysisTestType->getHtmlResult($testResult['testResult']->id, $testResult['testResult']->result) : "xxx" !!}</td>
                        <td style=" width: 33.33%; font-size: 12px;">{!! $testResult['testResult']->aTest->analysisTestType? $testResult['testResult']->aTest->analysisTestType->getHtmlDescriptionResult($testResult['testResult']->id) : "yyy" !!}</td>
                    </tr>
                @endif
            @endforeach
        @endif
    @endforeach
    </tbody>
</table>
@if($analisis->observaciones)
    <dl>
        <dt style="font-size: 14px; font-weight: 900;">Observaciones</dt>
        <dd style="font-size: 12px;">{{$analisis->observaciones}}</dd>
    </dl>
@endif
<br>
{{--<div class="chapter2">Text of Chapter 2</div>--}}

@include('citologia.partial.reporte-footer', compact('analisis', 'sin'))
