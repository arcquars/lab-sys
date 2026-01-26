<?php
if(!isset($sin)){
    $sin = null;
}
?>
@include('test.labci.partials.reporte-style')
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
        font-size: 12px;
        border-bottom: 1px solid #000;
    }

</style>
<table style="width: 100%;">
    <tr>
        <td style="width: 57%;"></td>
        <td style="width: 43%;">
            <div style="">
                <p style="font-size: 10px; margin: 4px;"><b>LABORATORIO CLINICO Y DE INVESTIGACIÒN LABCI S.R.L</b></p>
                <div style="height: 2px;"></div>
                <p style="font-size: 9px;">Realiza control de calidad externo con: INLASA y </p>
            </div>
        </td>
    </tr>
</table>
{{--<h3 class="h4-cito-1" style='text-align: center;'>INFORME PRUEBA</h3>--}}
@include('test.labci.partials.reporte-client', compact('analisis', 'pathQr'))
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
            <tr style="border: none;">
                <td colspan="3" style="padding-top: 15px; font-size: 14px">
                    <h5 style="color: #00436b; font-size: 15px;">{{$key}}</h5>
                </td>
            </tr>
            @foreach($testResults as $testResult)
                @if(isset($testResult['testResult']->result))
                    @php $index++; @endphp
                    <tr>
                        <td style="width: 33.33%; font-size: 13px;">{{ $testResult['testResult']->aTest->name }}</td>
                        <td style=" width: 33.33%; font-size: 13px; text-align: center;">{!! $testResult['testResult']->aTest->analysisTestType? $testResult['testResult']->aTest->analysisTestType->getHtmlResult($testResult['testResult']->id, $testResult['testResult']->result) : "xxx" !!}</td>
                        <td style=" width: 33.33%; font-size: 12px; text-align: center;">
                            {!! $testResult['testResult']->aTest->analysisTestType? $testResult['testResult']->aTest->analysisTestType->getHtmlDescriptionResult($testResult['testResult']->id) : "yyy" !!}
                            
                        </td>
                    </tr>
                    @if(isset($testResult['testResult']->metodo))
                    <tr>
                        <td colspan="3" style="padding-left: 8px;">
                            
                                <p style="font-size: 10px;">METODO: {{$testResult['testResult']->metodo}}</p>
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
    <dl>
        <dt style="font-size: 14px; color: #00436b;"><b>Observaciones</b></dt>
        <dd style="font-size: 12px;">{{$analisis->observaciones}}</dd>
    </dl>
@endif
<br>
{{--<div class="chapter2">Text of Chapter 2</div>--}}

@include('test.labci.partials.reporte-footer', compact('analisis', 'sin'))
