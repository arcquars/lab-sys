<?php
namespace App\Helpers;

use App\AnalysisTestGroup;
use App\AnalysisTestResult;
use App\Doctor;

class ClinicaHelper {

    public static function getAllDoctorTitulares($doctorId){
//        $doctores = Doctor::where('deleted', 0)->where('supervisado', 0)->get();
        $doctores = Doctor::where('deleted', 0)->where('id', '<>', $doctorId)->orderBy('nombres')->get();
        return $doctores;
    }

    public static function getTestGroupResults($analysisId){
        $testResults = AnalysisTestResult::where('analysis_id', $analysisId)->get();
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

    public static function getTestGroupResultsSorted($analysisId, $order="asc"){
        $testResults = AnalysisTestResult::where('analysis_id', $analysisId)->get();
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
}

