@foreach($testResults as $testResult)
    @if(isset($testResult->result))
        <tr>
            <td style="width: 40%; font-size: 8px; padding: 2px 5px;">
                <p style="font-weight: bold">{{ $testResult->aTest->name }}</p>
            </td>
            <td style="width: 35%; font-size: 10px; 
                @if(!$testResult->aTest->analysisTestType instanceof App\AnalysisTestText) text-align: center; @endif
                padding: 2px 5px;
                ">
                {!! $testResult->aTest->analysisTestType ? $testResult->aTest->analysisTestType->getHtmlResult($testResult->id, $testResult->result) : "---" !!}
            </td>
            <td style="width: 25%; font-size: 10px; text-align: left; padding: 2px 5px; color: #444;">
                {!! $testResult->aTest->analysisTestType ? $testResult->aTest->analysisTestType->getHtmlDescriptionResult($testResult->id) : "" !!}
            </td>
        </tr>
        
        {{-- Si tiene método, lo mostramos en una fila subordinada con estilo sutil --}}
        @if(isset($testResult->metodo) && !empty($testResult->metodo))
        <tr>
            <td colspan="3" style="padding: 0 0 2px 5px; border-bottom: 1px solid #eee;">
                <p style="font-size: 10px; color: #666; margin: 0;">
                    <i style="color: #999;">MÉTODO:</i> {{ $testResult->metodo }}
                </p>
            </td>
        </tr>
        @endif
    @endif
@endforeach