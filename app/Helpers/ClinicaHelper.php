<?php
namespace App\Helpers;

use App\AnalysisTestGroup;
use App\AnalysisTestResult;
use App\Doctor;
use Illuminate\Support\Facades\Log;

class ClinicaHelper {

    public static function getAllDoctorTitulares($doctorId){
//        $doctores = Doctor::where('deleted', 0)->where('supervisado', 0)->get();
        $doctores = Doctor::where('deleted', 0)->where('id', '<>', $doctorId)->orderBy('nombres')->get();
        return $doctores;
    }

    public static function getTestGroupResults($analysisId){
        // $testResults = AnalysisTestResult::where('analysis_id', $analysisId)->get();
        $testResults = AnalysisTestResult::query()
            ->select('a_test_results.*') // Evita colisión de IDs
            ->join('a_tests', 'a_test_results.a_test_id', '=', 'a_tests.id')
            ->where('a_test_results.analysis_id', $analysisId)
            ->orderBy('a_tests.sorted', 'asc')
            ->orderBy('a_tests.name', 'asc')
            ->get();
        $groupsIds = [];
        foreach ($testResults as $testResult){
            if (!in_array($testResult->aTest->a_test_group_id, $groupsIds)) {
                $groupsIds[] = $testResult->aTest->a_test_group_id;
            }
        }
        $groups = AnalysisTestGroup::whereIn('id', $groupsIds)->orderBy('sortable', 'desc')->orderBy('name')->get();

        $orderGroupTest = [];
        foreach ($groups as $group){
            $test = [];
            foreach ($testResults as $testResult){
                if($testResult->aTest->a_test_group_id == $group->id){
                    $test[] = $testResult;
                }
            }

            if(count($test) > 0){
                if($group->parent){
                    $orderGroupTest[$group->parent->name . ' - ' . $group->name] = $test;
                } else {
                    $orderGroupTest[$group->name] = $test;
                }
            }
        }

        return $orderGroupTest;
    }

    public static function getTestGroupParentResults($analysisId){
        $testResults = AnalysisTestResult::where('analysis_id', $analysisId)->get();
        $groupsIds = [];
        foreach ($testResults as $testResult){
            if (!in_array($testResult->aTest->a_test_group_id, $groupsIds)) {
                $groupsIds[] = $testResult->aTest->a_test_group_id;
            }
        }

        $groups =  AnalysisTestGroup::select('id', 'parent_id', 'name', 'subtitle')
            ->whereIn('id', $groupsIds)
            ->where('deleted', 0)
            ->orderBy('sortable', 'desc')->orderBy('name')
            ->get()->toArray();

        $parentArray = [];
        foreach($groups as $g){
            $parentArray[] = $g['parent_id'];
            $parentArray[] = $g['id'];
        }

        $groupsNivel2 =  AnalysisTestGroup::select('id', 'parent_id', 'name')
            ->whereIn('id', $parentArray)
            ->where('deleted', 0)
            ->get()->toArray();

        foreach($groupsNivel2 as $gNi){
            $parentArray[] = $gNi['parent_id'];
            $parentArray[] = $gNi['id'];
        }
        $parentArray = array_unique($parentArray);
        
        $groupsP =  AnalysisTestGroup::select('id', 'parent_id', 'name', 'subtitle')
            ->whereIn('id', $parentArray)
            ->where('deleted', 0)
            ->get()->toArray();

        
        $allGroups = collect($groups)
            ->merge($groupsP)
            ->unique('id')
            ->values()
            ->toArray();

        $idsBuscados = [0]; 
        $arbolFinal = [];
        ClinicaHelper::obtenerRamasRecursivas($idsBuscados, $arbolFinal, $allGroups);

        // dd($arbolFinal);
        return $arbolFinal;
        
    }

    public static function obtenerRamasRecursivas(array $ids, array &$resultado, $datosBase) {
        foreach ($datosBase as $item) {
            Log::info("eeee 2: ". json_encode($item));
            // Verificamos si el padre del item actual está en la lista de IDs buscados
            if (in_array($item['parent_id'], $ids)) {
                Log::info("eeee 3: Entro al IF");
                // Estructura del nodo actual
                $nodo = $item;
                $nodo['hijos'] = []; // Inicializamos el contenedor de hijos
                
                // Llamada recursiva: buscamos los hijos del ID actual
                // El primer parámetro ahora es el ID del nodo que acabamos de encontrar
                ClinicaHelper::obtenerRamasRecursivas([$item['id']], $nodo['hijos'], $datosBase);
                
                // Agregamos el nodo procesado al arreglo de resultados
                $resultado[] = $nodo;
            }
        }
    }

    public static function getTestGroupResultsSorted($analysisId, $order="asc"){
        $testResults = AnalysisTestResult::where('analysis_id', $analysisId)->get();
        $groupsIds = [];
        foreach ($testResults as $testResult){
            if (!in_array($testResult->aTest->a_test_group_id, $groupsIds)) {
                $groupsIds[] = $testResult->aTest->a_test_group_id;
            }
        }
        $groups = AnalysisTestGroup::whereIn('id', $groupsIds)->orderBy('sortable', 'desc')->orderBy('name', 'desc')->get();

        $orderGroupTest = [];
        foreach ($groups as $group){
            $test = [];
            foreach ($testResults as $testResult){
                if($testResult->aTest->a_test_group_id == $group->id){
                    $test[] = ["sorted" => $testResult->aTest->sorted, "testResult" => $testResult];
                }
            }

            if(count($test) > 0){
                if(strcmp($order, "asc") == 0){
                    usort($test, function($a, $b) {
                        return $a['sorted'] - $b['sorted'];
                    });
                } else {
                    usort($test, function($a, $b) {
                        return $b['sorted'] - $a['sorted'];
                    });
                }


                if($group->parent){
                    $orderGroupTest[$group->parent->name . ' - ' . $group->name] = $test;
                } else {
                    $orderGroupTest[$group->name] = $test;
                }
            }
        }

//        foreach ($orderGroupTest as $key => $test){
//            if(count($test) > 0){
//                usort($test, function($a, $b) {
//                    return $a['sorted'] - $b['sorted'];
//                });
//            }
//        }

        return $orderGroupTest;
    }

    public static function getTestByGroupResultsSorted($analysisId, $groupId, $order="asc"){
        $testResults = AnalysisTestResult::where('analysis_id', $analysisId)
            ->whereNotNull('result')
            ->whereHas('aTest', function($query) use ($groupId) {
                $query->where('a_test_group_id', $groupId);
            })
            ->with('aTest')
            ->get();
        // Determinamos el método de ordenamiento según el parámetro $order
        if (strtolower($order) === 'desc') {
            return $testResults->sortByDesc(function($item) {
                return $item->aTest->sorted;
            });
        }

        return $testResults->sortBy(function($item) {
            return $item->aTest->sorted;
        });
    }
}

