<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\AnalysisTestGroup;
use App\AnalysisTestResult;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($analysisId)
    {
        $analysis = Analisis::find($analysisId);
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

        return view('test.crear', compact('analysis', 'orderGroupTest'));
    }
}
