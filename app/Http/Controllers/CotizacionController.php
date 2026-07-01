<?php

namespace App\Http\Controllers;

use App\AnalysisTest;
use App\AnalysisTestGroup;
use Illuminate\Http\Request;
use PDF;

class CotizacionController extends Controller
{
    /**
     * Vista pública "Cotización de análisis". No requiere sesión iniciada.
     */
    public function index()
    {
        $groups = AnalysisTestGroup::whereNull('parent_id')
            ->where('deleted', 0)
            ->orderBy('name')
            ->get();

        return view('cotizacion.index', compact('groups'));
    }

    /**
     * Genera el PDF de la cotización a partir de los grupos/análisis marcados.
     */
    public function pdf(Request $request)
    {
        $request->validate([
            'aGroup' => 'array',
            'aGroup.*' => 'integer|exists:a_test_groups,id',
            'aTests' => 'array',
            'aTests.*' => 'integer|exists:a_tests,id',
        ], [
            'aGroup.*.exists' => 'Uno de los grupos seleccionados no es válido.',
            'aTests.*.exists' => 'Uno de los análisis seleccionados no es válido.',
        ]);

        $groupIds = $request->input('aGroup', []);
        $testIds = $request->input('aTests', []);

        if (empty($groupIds) && empty($testIds)) {
            return back()->withErrors(['aTests' => 'Selecciona al menos un análisis o un grupo antes de generar la cotización.'])->withInput();
        }

        [$items, $total] = $this->buildQuoteItems($groupIds, $testIds);

        $fecha = now();

        $pdf = PDF::loadView('cotizacion.pdf', compact('items', 'total', 'fecha'));

        return $pdf->stream('cotizacion-analisis-' . $fecha->format('Ymd-His') . '.pdf');
    }

    /**
     * Arma el detalle de la cotización.
     *
     * Regla de precio: si un análisis se marca individualmente y TODOS los
     * análisis de su grupo tienen precio 0, se cobra el precio del grupo (una
     * sola vez) en vez de sumar 0 por cada análisis suelto de ese grupo.
     *
     * @return array{0: array, 1: float}
     */
    private function buildQuoteItems(array $groupIds, array $testIds): array
    {
        $items = [];
        $total = 0.0;

        $groups = AnalysisTestGroup::whereIn('id', $groupIds)->where('deleted', 0)->get();
        foreach ($groups as $group) {
            $price = (float) $group->price;
            $items[] = [
                'name' => $group->name,
                'detail' => 'Paquete de análisis',
                'price' => $price,
            ];
            $total += $price;
        }

        $tests = AnalysisTest::whereIn('id', $testIds)
            ->where('deleted', false)
            ->get()
            // Evita duplicar el cobro cuando el grupo completo del análisis ya fue seleccionado
            ->reject(function ($test) use ($groupIds) {
                return in_array($test->a_test_group_id, $groupIds);
            });

        foreach ($tests->groupBy('a_test_group_id') as $groupId => $testsInGroup) {
            $group = AnalysisTestGroup::find($groupId);

            $allGroupTestsAreFree = AnalysisTest::where('a_test_group_id', $groupId)
                ->where('deleted', false)
                ->get()
                ->every(function ($t) {
                    return (float) $t->price == 0.0;
                });

            if ($group && $group->price > 0 && $allGroupTestsAreFree) {
                $items[] = [
                    'name' => $group->name,
                    'detail' => 'Paquete de análisis (' . $testsInGroup->pluck('name')->implode(', ') . ')',
                    'price' => (float) $group->price,
                ];
                $total += (float) $group->price;
                continue;
            }

            foreach ($testsInGroup as $test) {
                $price = (float) $test->price;
                $items[] = [
                    'name' => $test->name,
                    'detail' => $group ? $group->name : $test->type,
                    'price' => $price,
                ];
                $total += $price;
            }
        }

        return [$items, $total];
    }
}
