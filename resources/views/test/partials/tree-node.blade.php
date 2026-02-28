<?php
use App\Helpers\ClinicaHelper;
?>
{{-- Componente para renderizar el árbol de forma recursiva --}}
@foreach($items as $i => $item)
    @php
        // Obtenemos resultados directos de este grupo
        $testResults = ClinicaHelper::getTestByGroupResultsSorted($analisisId, $item['id']);
        
        // Verificamos si este grupo o sus descendientes tienen resultados para decidir si mostrar el título
        // Nota: En una estructura muy profunda, podrías necesitar una función helper para 'hasResultsRecursive'
        $hasDirectResults = $testResults->count() > 0;
        $hasHijos = !empty($item['hijos']);
    @endphp

    {{-- 1. Si el grupo tiene resultados directos, mostramos su encabezado y sus pruebas --}}
    @if($hasDirectResults)
        @if(!isset($item['parent_id']))
        <tr style="background-color: rgba(232, 239, 253, 0.5);">
            <td colspan="3" style="text-align: center; padding: 4px 8px;">
                <p style="font-size: 12px; color: #1e3a8a; margin: 0; padding-top: 5px;">
                    <b>{{ mb_strtoupper($item['name']) }}</b>
                </p>    
            </td>
        </tr>
        @else
        <tr style="background-color: rgba(232, 239, 253, 0.5);">
            <td colspan="3" style="text-align: left; padding: 4px 8px;">
                <p style="font-size: 11px; color: #1e3a8a; margin: 0; padding-top: 5px;">
                    <b>{{ mb_strtoupper($item['name']) }}</b>
                </p>
            </td>
        </tr>
        @endif
        
        {{-- Incluimos los resultados de este nivel --}}
        @include('test.partials.tree-node-results', ['testResults' => $testResults])

    @else
        @if($i == 0)
        <tr style="background-color: rgba(232, 239, 253, 0.5);">
            <td colspan="3" style="text-align: center; padding: 4px 8px;">
                <p style="font-size: 12px; color: #1e3a8a; margin: 0; padding-top: 5px;">
                    <b>{{ mb_strtoupper($item['name']) }}</b>
                </p>
            </td>
        </tr>
        @endif
        
    @endif

    {{-- 2. Llamada RECURSIVA: Si tiene hijos, procesamos el siguiente nivel --}}
    @if($hasHijos)
        @include('test.partials.tree-node', [
            'items' => $item['hijos'], 
            'analisisId' => $analisisId
        ])
    @endif
@endforeach