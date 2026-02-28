@foreach($testResults as $testResult)
    @if(isset($testResult->result))
        <tr>
            <td style="width: 33.33%; font-size: 12px;"><b>{{ $testResult->aTest->name }}</b></td>
            <td style=" width: 33.33%; font-size: 12px; text-align: center;">
                {!! $testResult->aTest->analysisTestType? $testResult->aTest->analysisTestType->getHtmlResult($testResult->id, $testResult->result) : "xxx" !!}</td>
            <td style=" width: 33.33%; font-size: 10px; text-align: center;">
                {!! $testResult->aTest->analysisTestType? $testResult->aTest->analysisTestType->getHtmlDescriptionResult($testResult->id) : "yyy" !!}
                
            </td>
        </tr>
        @if(isset($testResult->metodo))
        <tr>
            <td colspan="3" style="padding-left: 10px;">
                    <p style="font-size: 9px;"><b>METODO:</b> {{$testResult->metodo}}</p>
            </td>
        </tr>
        @endif
    @endif
@endforeach