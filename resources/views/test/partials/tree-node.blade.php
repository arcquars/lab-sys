<?php
use App\Helpers\ClinicaHelper;
?>
{{-- Componente para renderizar el árbol de forma recursiva --}}
@foreach($items as $item)
    @php
    $testResults = ClinicaHelper::getTestByGroupResultsSorted($analisisId, $item['id'])
    @endphp

    @if($testResults->count() > 0)
    <tr style="background-color: rgba(232, 239, 253, 0.5);">
        <td colspan="3" style="text-align: left;">
            <p style="font-size: 11px; color: #1e3a8a; padding-top: 8px !important;"><b>{{$item['name']}}</b></p>
        </td>
    </tr>
    @include(
        'test.partials.tree-node-results', 
        ['testResults' => $testResults]
    )

    @endif
@endforeach