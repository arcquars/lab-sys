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
        $groups = AnalysisTestGroup::whereIn('id', $groupsIds)->orderBy('name')->get();

        $orderGroupTest = [];
        foreach ($groups as $group){
            $test = [];
            foreach ($testResults as $testResult){
                if($testResult->aTest->a_test_group_id == $group->id){
                    $test[] = $testResult;
                }
            }

            if(count($test) > 0){
                $orderGroupTest[$group->name] = $test;
            }
        }

        return $orderGroupTest;
    }
}

