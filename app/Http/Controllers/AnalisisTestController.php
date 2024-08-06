<?php

namespace App\Http\Controllers;

use App\AnalysisTest;
use App\AnalysisTestGeneric;
use App\AnalysisTestGenericOption;
use App\AnalysisTestGroup;
use App\AnalysisTestLimit;
use App\AnalysisTestLimitOption;
use App\AnalysisTestPositive;
use App\AnalysisTestRange;
use App\AnalysisTestRangeNoOrder;
use App\AnalysisTestRangeNoOrderOption;
use App\AnalysisTestRangeNoOrderOptionIntermediary;
use App\AnalysisTestRangeOption;
use App\Http\Requests\StoreAnalysisTestPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AnalisisTestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('cerrarAnalisisForId', '');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $rangeTypeList = AnalysisTest::ANALYSIS_TEST_TYPES;
        return view('a-test.home', compact('rangeTypeList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreAnalysisTestPost $request
     * @return JsonResponse
     */
    public function store(StoreAnalysisTestPost $request)
    {
        $analysisTest = new AnalysisTest();
        $analysisTest->name = $request->input('name');
        $analysisTest->price = $request->input('price');
        $analysisTest->a_test_group_id = $request->input('group');
        $analysisTest->type = $request->input('type');
        $analysisTest->user_id = Auth::user()->id;
        $analysisTest->save();

        switch ($analysisTest->type){
            case AnalysisTest::ANALYSIS_TEST_TYPE_RANGO:
                $analysisTestRange = new AnalysisTestRange();
                $analysisTestRange->measure = $request->input('range.measure');
                $analysisTestRange->bookmark = $request->input('range.bookmark', false);
                $analysisTestRange->user_id = Auth::user()->id;
                $analysisTestRange->a_test_id = $analysisTest->id;
                $analysisTestRange->save();

                $options = $request->input('range.option');
                foreach($options as $key => $value){
                    $analysisTestRangeOption = new AnalysisTestRangeOption();
                    $analysisTestRangeOption->initial = $value['initial']? $value['initial'] : '';
                    $analysisTestRangeOption->end = $value['end']? $value['end'] : '';
                    $analysisTestRangeOption->age_initial = $value['age_initial'];
                    $analysisTestRangeOption->age_end = $value['age_end'];
                    $analysisTestRangeOption->gender = $value['gender'];
                    $analysisTestRangeOption->a_test_range_id = $analysisTestRange->id;
                    $analysisTestRangeOption->user_id = Auth::user()->id;
                    $analysisTestRangeOption->save();
                }
                break;
            case AnalysisTest::ANALYSIS_TEST_TYPE_RANGO_SIN_ORDEN:
                $analysisTestRangeNoOrder = new AnalysisTestRangeNoOrder();
                $analysisTestRangeNoOrder->measure = $request->input('range.measure');
                $analysisTestRangeNoOrder->user_id = Auth::user()->id;
                $analysisTestRangeNoOrder->a_test_id = $analysisTest->id;
                $analysisTestRangeNoOrder->save();

                $options = $request->input('range.option');
                foreach($options as $key => $value){
                    $analysisTestRangeNoOrderOption = new AnalysisTestRangeNoOrderOption();
                    $analysisTestRangeNoOrderOption->gender = $value['gender'];
                    $analysisTestRangeNoOrderOption->age_initial = (isset($value['age_initial']))? $value['age_initial'] : null;
                    $analysisTestRangeNoOrderOption->age_end = $value['age_end']?? null;
                    $analysisTestRangeNoOrderOption->initial_text = $value['initial_text'] ?? null;
                    $analysisTestRangeNoOrderOption->initial_value = $value['initial_value'] ?? null;
                    $analysisTestRangeNoOrderOption->initial_bookmark = $value['initial_bookmark'] ?? 0;
                    $analysisTestRangeNoOrderOption->end_text = $value['end_text']?? null;
                    $analysisTestRangeNoOrderOption->end_value = $value['end_value']?? null;
                    $analysisTestRangeNoOrderOption->end_bookmark = $value['end_bookmark']?? 0;
                    $analysisTestRangeNoOrderOption->a_test_range_no_order_id = $analysisTestRangeNoOrder->id;
                    $analysisTestRangeNoOrderOption->user_id = Auth::user()->id;
                    $analysisTestRangeNoOrderOption->save();

                    $intermediaries = $request->input('range.option.'.$key.'.intermediary');
                    if(isset($intermediaries) && is_array($intermediaries)){
                        foreach ($intermediaries as $key1 => $intermediary){
                            $aTestRangeNoOrderOptionIntermediary = new AnalysisTestRangeNoOrderOptionIntermediary();
                            $aTestRangeNoOrderOptionIntermediary->range_name = (isset($intermediary['text']))? $intermediary['text'] : null;
                            $aTestRangeNoOrderOptionIntermediary->initial_range = (isset($intermediary['initial_range']))? $intermediary['initial_range'] : null;
                            $aTestRangeNoOrderOptionIntermediary->end_range = (isset($intermediary['end_range']))? $intermediary['end_range'] : null;
                            $aTestRangeNoOrderOptionIntermediary->bookmark = (isset($intermediary['bookmark']))? $intermediary['bookmark'] : 0;
                            $aTestRangeNoOrderOptionIntermediary->order_option_id = $analysisTestRangeNoOrderOption->id;
                            $aTestRangeNoOrderOptionIntermediary->save();
                        }
                    }
                }
                break;
            case AnalysisTest::ANALYSIS_TEST_TYPE_LIMITE:
                $analysisTestLimit = new AnalysisTestLimit();
                $analysisTestLimit->measure = $request->input('limit.measure');
                $analysisTestLimit->user_id = Auth::user()->id;
                $analysisTestLimit->a_test_id = $analysisTest->id;
                $analysisTestLimit->save();

                $options = $request->input('range.option');
                foreach($options as $key => $value){
                    $analysisTestLimitOption = new AnalysisTestLimitOption();
                    $analysisTestLimitOption->to = $value['to']? $value['to'] : '';
                    $analysisTestLimitOption->age_initial = $value['age_initial'];
                    $analysisTestLimitOption->age_end = $value['age_end'];
                    $analysisTestLimitOption->gender = $value['gender'];
                    $analysisTestLimitOption->a_test_limit_id = $analysisTestLimit->id;
                    $analysisTestLimitOption->user_id = Auth::user()->id;
                    $analysisTestLimitOption->save();
                }
                break;
            case AnalysisTest::ANALYSIS_TEST_TYPE_GENERICO:
                $analysisTestGeneric = new AnalysisTestGeneric();
                $analysisTestGeneric->user_id = Auth::user()->id;
                $analysisTestGeneric->a_test_id = $analysisTest->id;
                $analysisTestGeneric->save();

                $options = $request->input('range.option');
                foreach($options as $key => $value){
                    $analysisTestGenericOption = new AnalysisTestGenericOption();
                    $analysisTestGenericOption->reference = $value['reference']? $value['reference'] : '';
                    $analysisTestGenericOption->age_initial = $value['age_initial'];
                    $analysisTestGenericOption->age_end = $value['age_end'];
                    $analysisTestGenericOption->gender = $value['gender'];
                    $analysisTestGenericOption->a_test_generic_id = $analysisTestGeneric->id;
                    $analysisTestGenericOption->user_id = Auth::user()->id;
                    $analysisTestGenericOption->save();
                }
                break;
            case AnalysisTest::ANALYSIS_TEST_TYPE_POSITIVO_NEGATIVO:
                $analysisTestPositive = new AnalysisTestPositive();
                $analysisTestPositive->user_id = Auth::user()->id;
                $analysisTestPositive->a_test_id = $analysisTest->id;
                $analysisTestPositive->save();
                break;
        }

        return response()->json(['success'=>true, 'message' => "Se creo la PRUEBA correctamente..."]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreAnalysisTestPost $request
     * @return JsonResponse
     */
    public function update(StoreAnalysisTestPost $request)
    {
        $analysisTest = AnalysisTest::find($request->input('id'));
        $analysisTest->name = $request->input('name');
        $analysisTest->price = $request->input('price');
        $analysisTest->a_test_group_id = $request->input('group');
        $analysisTest->type = $request->input('type');
        $analysisTest->user_id = Auth::user()->id;
        $analysisTest->save();

        switch ($analysisTest->type) {
            case AnalysisTest::ANALYSIS_TEST_TYPE_RANGO:
                // Bloque que actualiza los datos de AnalysisTestRange
                $analysisTestRange = AnalysisTestRange::find($analysisTest->analysisTestType->id);
                $analysisTestRange->measure = $request->input('range.measure');
                $analysisTestRange->bookmark = $request->input('range.bookmark');
                $analysisTestRange->save();

                // Bloque para eliminar las opciones
                $deleteRangeOptionIds = [];
                foreach ($analysisTest->analysisTestType->analysisTestRangeOptions as $analysisTestRangeOption){
                    $deleteId = $analysisTestRangeOption->id;
                    foreach ($request->input('range.option') as $key=> $value){
                        if(isset($value['id']) && $analysisTestRangeOption->id == $value['id']){
                            $deleteId = 0;
                        }
                    }
                    if($deleteId != 0){
                        $deleteRangeOptionIds[] = $deleteId;
                    }
                }
                AnalysisTestRangeOption::whereIn('id', $deleteRangeOptionIds)->delete();

                // Bloque para actualizar las opciones que ya tenia el Rango
                foreach ($request->input('range.option') as $key=> $value){
                    if(isset($value['id'])){
                        $analysisTestRangeOption = AnalysisTestRangeOption::find($value['id']);
                        $analysisTestRangeOption->initial = $value['initial']? $value['initial'] : '';
                        $analysisTestRangeOption->end = $value['end']? $value['end'] : '';
                        $analysisTestRangeOption->age_initial = $value['age_initial'];
                        $analysisTestRangeOption->age_end = $value['age_end'];
                        $analysisTestRangeOption->gender = $value['gender'];
                        $analysisTestRangeOption->save();
                    } else {
                        $analysisTestRangeOption = new AnalysisTestRangeOption();
                        $analysisTestRangeOption->initial = $value['initial']? $value['initial'] : '';
                        $analysisTestRangeOption->end = $value['end']? $value['end'] : '';
                        $analysisTestRangeOption->age_initial = $value['age_initial'];
                        $analysisTestRangeOption->age_end = $value['age_end'];
                        $analysisTestRangeOption->gender = $value['gender'];
                        $analysisTestRangeOption->a_test_range_id = $analysisTest->analysisTestType->id;
                        $analysisTestRangeOption->user_id = Auth::user()->id;
                        $analysisTestRangeOption->save();
                    }
                }
                break;
            case AnalysisTest::ANALYSIS_TEST_TYPE_LIMITE:
                // Bloque que actualiza los datos de AnalysisTestLimit
                $analysisTestLimit = AnalysisTestLimit::find($analysisTest->analysisTestType->id);
                $analysisTestLimit->measure = $request->input('limit.measure');
//                $analysisTestRange->bookmark = $request->input('range.bookmark');
                $analysisTestLimit->save();

                // Bloque para eliminar las opciones
                $deleteLimitOptionIds = [];
                foreach ($analysisTest->analysisTestType->analysisTestLimitOptions as $analysisTestLimitOption){
                    $deleteId = $analysisTestLimitOption->id;
                    foreach ($request->input('range.option') as $key=> $value){
                        if(isset($value['id']) && $analysisTestLimitOption->id == $value['id']){
                            $deleteId = 0;
                        }
                    }
                    if($deleteId != 0){
                        $deleteLimitOptionIds[] = $deleteId;
                    }
                }
                AnalysisTestLimitOption::whereIn('id', $deleteLimitOptionIds)->delete();

                // Bloque para actualizar las opciones que ya tenia el Limite
                foreach ($request->input('range.option') as $key=> $value){
                    if(isset($value['id'])){
                        $analysisTestLimitOption = AnalysisTestLimitOption::find($value['id']);
                        $analysisTestLimitOption->to = $value['to']? $value['to'] : '';
                        $analysisTestLimitOption->age_initial = $value['age_initial'];
                        $analysisTestLimitOption->age_end = $value['age_end'];
                        $analysisTestLimitOption->gender = $value['gender'];
                        $analysisTestLimitOption->save();
                    } else {
                        $analysisTestLimitOption = new AnalysisTestLimitOption();
                        $analysisTestLimitOption->to = $value['to']? $value['to'] : '';
                        $analysisTestLimitOption->age_initial = $value['age_initial'];
                        $analysisTestLimitOption->age_end = $value['age_end'];
                        $analysisTestLimitOption->gender = $value['gender'];
                        $analysisTestLimitOption->a_test_limit_id = $analysisTest->analysisTestType->id;
                        $analysisTestLimitOption->user_id = Auth::user()->id;
                        $analysisTestLimitOption->save();
                    }
                }
                break;
            case AnalysisTest::ANALYSIS_TEST_TYPE_GENERICO:
                // Bloque que actualiza los datos de AnalysisTestGeneric
                $analysisTestGeneric = AnalysisTestGeneric::find($analysisTest->analysisTestType->id);

                // Bloque para eliminar las opciones
                $deleteGenericOptionIds = [];
                foreach ($analysisTest->analysisTestType->analysisTestGenericOptions as $analysisTestGenericOption){
                    $deleteId = $analysisTestGenericOption->id;
                    foreach ($request->input('range.option') as $key=> $value){
                        if(isset($value['id']) && $analysisTestGenericOption->id == $value['id']){
                            $deleteId = 0;
                        }
                    }
                    if($deleteId != 0){
                        $deleteGenericOptionIds[] = $deleteId;
                    }
                }
                AnalysisTestGenericOption::whereIn('id', $deleteGenericOptionIds)->delete();

                // Bloque para actualizar las opciones que ya tenia el generico
                foreach ($request->input('range.option') as $key=> $value){
                    $analysisTestGenericOption = new AnalysisTestGenericOption();
                    $analysisTestGenericOption->a_test_generic_id = $analysisTest->analysisTestType->id;
                    if(isset($value['id'])){
                        $analysisTestGenericOption = AnalysisTestGenericOption::find($value['id']);
                    }
                    $analysisTestGenericOption->reference = $value['reference']? $value['reference'] : '';
                    $analysisTestGenericOption->age_initial = $value['age_initial'];
                    $analysisTestGenericOption->age_end = $value['age_end'];
                    $analysisTestGenericOption->gender = $value['gender'];
                    $analysisTestGenericOption->save();
                }
                break;
            case AnalysisTest::ANALYSIS_TEST_TYPE_RANGO_SIN_ORDEN:
                $analysisTestRangeNoOrder = AnalysisTestRangeNoOrder::find($analysisTest->analysisTestType->id);
                $analysisTestRangeNoOrder->measure = $request->input('range.measure');
                $analysisTestRangeNoOrder->user_id = Auth::user()->id;
                $analysisTestRangeNoOrder->save();

                // Bloque para eliminar las opciones de rango sin orden
                $deleteRangeOptionIds = [];
                    foreach ($analysisTest->analysisTestType->analysisTestRangeOptions as $analysisTestRangeOption){
                    $deleteId = $analysisTestRangeOption->id;
                    foreach ($request->input('range.option') as $key=> $value){
                        if(isset($value['id']) && $analysisTestRangeOption->id == $value['id']){
                            $deleteId = 0;
                        }
                    }
                    if($deleteId != 0){
                        $deleteRangeOptionIds[] = $deleteId;
                    }
                }
                AnalysisTestRangeNoOrderOptionIntermediary::whereIn('order_option_id', $deleteRangeOptionIds)->delete();
                AnalysisTestRangeNoOrderOption::whereIn('id', $deleteRangeOptionIds)->delete();

                $options = $request->input('range.option');
                foreach($options as $key => $value){
                    if(isset($value['id'])){
                        $analysisTestRangeNoOrderOption = AnalysisTestRangeNoOrderOption::find($value['id']);
                    } else {
                        $analysisTestRangeNoOrderOption = new AnalysisTestRangeNoOrderOption();
                        $analysisTestRangeNoOrderOption->a_test_range_no_order_id = $analysisTestRangeNoOrder->id;
                        $analysisTestRangeNoOrderOption->user_id = Auth::user()->id;
                    }
                    $analysisTestRangeNoOrderOption->gender = $value['gender'];
                    $analysisTestRangeNoOrderOption->age_initial = (isset($value['age_initial']))? $value['age_initial'] : null;
                    $analysisTestRangeNoOrderOption->age_end = $value['age_end']?? null;
                    $analysisTestRangeNoOrderOption->initial_text = $value['initial_text'] ?? null;
                    $analysisTestRangeNoOrderOption->initial_value = $value['initial_value'] ?? null;
                    $analysisTestRangeNoOrderOption->initial_bookmark = $value['initial_bookmark'] ?? 0;
                    $analysisTestRangeNoOrderOption->end_text = $value['end_text']?? null;
                    $analysisTestRangeNoOrderOption->end_value = $value['end_value']?? null;
                    $analysisTestRangeNoOrderOption->end_bookmark = $value['end_bookmark']?? 0;
                    $analysisTestRangeNoOrderOption->save();

                    $intermediaries = $request->input('range.option.'.$key.'.intermediary');
                    if(isset($intermediaries) && is_array($intermediaries)){
                        // Bloque para eliminar las intermediaries
                        // Ids base de datos
                        $dbIntermediaryIds = [];
                        foreach ($analysisTestRangeNoOrderOption->analysisTestRangeOptionsIntermediates as $analysisTestRangeOptionsIntermediary){
                            $dbIntermediaryIds[] = $analysisTestRangeOptionsIntermediary->id;
                        }
                        // Ids interface
                        $interfaceIntermediaryIds = [];
                        foreach ($intermediaries as $key1 => $intermediary){
                            if(isset($intermediary['id'])){
                                $interfaceIntermediaryIds[] = $intermediary['id'];
                            }
                        }
                        $deleteIds = array_diff($dbIntermediaryIds, $interfaceIntermediaryIds);
                        Log::info("PdM:: db: " . json_encode($dbIntermediaryIds) . " || inter:: " . json_encode($interfaceIntermediaryIds) . " || resultado:: " . json_encode($deleteId));
                        AnalysisTestRangeNoOrderOptionIntermediary::whereIn('id', $deleteIds)->delete();

                        foreach ($intermediaries as $key1 => $intermediary){
                            if(isset($intermediary['id'])){
                                $aTestRangeNoOrderOptionIntermediary = AnalysisTestRangeNoOrderOptionIntermediary::find($intermediary['id']);
                            } else {
                                $aTestRangeNoOrderOptionIntermediary = new AnalysisTestRangeNoOrderOptionIntermediary();
                                $aTestRangeNoOrderOptionIntermediary->order_option_id = $analysisTestRangeNoOrderOption->id;
                            }
                            $aTestRangeNoOrderOptionIntermediary->range_name = (isset($intermediary['text']))? $intermediary['text'] : null;
                            $aTestRangeNoOrderOptionIntermediary->initial_range = (isset($intermediary['initial_range']))? $intermediary['initial_range'] : null;
                            $aTestRangeNoOrderOptionIntermediary->end_range = (isset($intermediary['end_range']))? $intermediary['end_range'] : null;
                            $aTestRangeNoOrderOptionIntermediary->bookmark = (isset($intermediary['bookmark']))? 1 : 0;
                            $aTestRangeNoOrderOptionIntermediary->save();
                        }
                    }


                }
                break;
        }

        return response()->json(['success'=>true, 'message' => "Se actualizo la PRUEBA correctamente..."]);
    }

    public function getGroupAndType(){
        // Setting::where('section', $section)->select('key', 'value')->pluck('value')->toArray();
        $groups = AnalysisTestGroup::where('deleted', 0)->pluck('id','name')->toArray();
        return response()->json(['success'=>true, 'groups' => $groups]);
    }

    public function renderTestType(Request $request){
        if($request->ajax()){
            $testType = $request->input('test_type', 'Rango');
            switch ($testType){
                case AnalysisTest::ANALYSIS_TEST_TYPE_RANGO:
                    return view('a-test.partials.render-test-type-range')->render();
                case AnalysisTest::ANALYSIS_TEST_TYPE_RANGO_SIN_ORDEN:
                    return view('a-test.partials.render-test-type-range-no-order')->render();
                case AnalysisTest::ANALYSIS_TEST_TYPE_LIMITE:
                    return view('a-test.partials.render-test-type-limit')->render();
                case AnalysisTest::ANALYSIS_TEST_TYPE_GENERICO:
                    return view('a-test.partials.render-test-type-generic')->render();
                case AnalysisTest::ANALYSIS_TEST_TYPE_POSITIVO_NEGATIVO:
                    return view('a-test.partials.render-test-type-positive')->render();
            }
        }
    }

    public function renderRangeOption(Request $request){
        if($request->ajax()){
            $tempId = rand(0,500);
            return view('a-test.partials.render-range-option', compact('tempId'))->render();
        }
    }

    public function renderRangeNoOrderOption(Request $request){
        if($request->ajax()){
            $tempId = rand(0,500);
            return view('a-test.partials.render-range-no-order-option', compact('tempId'))->render();
        }
    }

    public function renderLimitOption(Request $request){
        if($request->ajax()){
            $tempId = rand(0,500);
            return view('a-test.partials.render-limit-option', compact('tempId'))->render();
        }
    }

    public function renderGenericOption(Request $request){
        if($request->ajax()){
            $tempId = rand(0,500);
            return view('a-test.partials.render-generic-option', compact('tempId'))->render();
        }
    }

    public function renderTestForm(Request $request){
        if($request->ajax()){
            $aTestId = $request->get('a_test_id');
            $analysisTest = AnalysisTest::find($aTestId);

            $groups = AnalysisTestGroup::where('deleted', 0)->pluck('name', 'id');
            $aTestTypes = AnalysisTest::ANALYSIS_TEST_TYPES;
            return view('a-test.partials.render-test-form',
                compact('analysisTest', 'groups', 'aTestTypes'))
                ->render();
        }
    }

    public function renderRangeOptionIntermediary(Request $request){
        if($request->ajax()){
            $tempId = $request->get('tempId');
            $count = $request->get('count');
            return view('a-test.partials.render-range-no-order-intermediary', compact('count', 'tempId'))->render();
        }
    }
}
