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
        border-bottom: 1px solid #000;
    }

    .analysisTestTable thead tr th{
        font-size: 12px;
    }
</style>
{{--<h3 class="h4-cito-1" style='text-align: center;'>INFORME PRUEBA</h3>--}}
@include('citologia.partial.reporte-client', compact('analisis'))
<br>
<table style="width: 98%" class="analysisTestTable">
    <thead>
    <tr>
        <th></th>
        <th>RESULTADOS</th>
        <th>VALORES DE REFERENCIA</th>
    </tr>
    </thead>
    <tbody>
@foreach($orderGroupTest as $key => $testResults)
    <tr style="border: none;">
        <td colspan="3" style="padding-top: 15px;"><h5>{{$key}}</h5></td>
    </tr>
    @foreach($testResults as $testResult)
        <tr>
            <td style="width: 33.33%; font-size: 12px;">{{ $testResult->aTest->name }}</td>
            <td style="width: 33.33%; font-size: 12px; text-align: center;">{!! $testResult->aTest->analysisTestType->getHtmlResult($testResult->id, $testResult->result) !!}</td>
            <td style="width: 33.33%; font-size: 10px; text-align: center;">{!! $testResult->aTest->analysisTestType->getHtmlDescriptionResult($testResult->id) !!}</td>
        </tr>
    @endforeach
@endforeach
    </tbody>
</table>

{{--<div class="chapter2">Text of Chapter 2</div>--}}

@include('citologia.partial.reporte-footer', compact('analisis', 'sin'))
