<?php

namespace App\Http\Controllers;

use App\AnalysisTestGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalysisTestGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'nullable|numeric|min:10|max:25000',
            'subtitle' => 'nullable|max:255',
        ]);
        $parent = $request->post('group', null);
        $analisisTestGroup = new AnalysisTestGroup();
        $analisisTestGroup->name = $request->post('name');
        $analisisTestGroup->price = $request->post('price');
        $analisisTestGroup->subtitle = $request->post('subtitle');
        $analisisTestGroup->parent_id = $parent;
        $analisisTestGroup->user_id = Auth::user()->id;
        $analisisTestGroup->save();

        return response()->json(['success'=>true, 'message' => "Se creo el grupo correctamente..."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'group' => 'nullable|different:id'
        ]);

        $analisisTestGroup = AnalysisTestGroup::find($request->post('id'));
        $analisisTestGroup->parent_id = $request->post('group', null);
        $analisisTestGroup->name = $request->post('name');
        $analisisTestGroup->price = $request->post('price');
        $analisisTestGroup->sortable = $request->post('sortable');
        $analisisTestGroup->subtitle = $request->post('subtitle');
        $analisisTestGroup->save();

        return response()->json(['success'=>true, 'message' => "Se edito el grupo correctamente..."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function renderListGroups(Request $request){
        if($request->ajax()){
            $groups = AnalysisTestGroup::where('deleted', 0)->orderBy('name')->get();
            return view('a-test.partials.render-list-groups',compact('groups'))->render();
        }
    }

    public function renderTreeGroups(Request $request){
        if($request->ajax()){
            // $groups = AnalysisTestGroup::where('deleted', 0)->orderBy('name')->get();
            $groups = AnalysisTestGroup::whereNull('parent_id')->where('deleted', 0)->orderBy('sortable', 'desc')->orderBy('name')->get();
            return view('a-test.partials.render-tree-groups',compact('groups'))->render();
        }
    }

    public function renderTreeGroupsSelect(Request $request){
        if($request->ajax()){
            $aTestGroupStringIds = $request->get('analisisTestGroupIds', []);
            $aTestStringIds = $request->get('analisisTestIds', []);

            $aTestGroupIds = array_map(function($element) {
                // Comentario: Retorna el elemento convertido a tipo entero.
                return (int) $element;
            }, $aTestGroupStringIds);
            $aTestIds = array_map(function($element) {
                // Comentario: Retorna el elemento convertido a tipo entero.
                return (int) $element;
            }, $aTestStringIds);

            // $groups = AnalysisTestGroup::where('deleted', 0)->orderBy('name')->get();
            $groups = AnalysisTestGroup::whereNull('parent_id')->where('deleted', 0)->orderBy('name')->get();
            return view('a-test.partials.render-tree-groups-selected',compact('groups', 'aTestGroupIds', 'aTestIds'))->render();
        }
    }

    public function renderTreeGroupsSelectV2(Request $request){
        if($request->ajax()){
            $aTestGroupStringIds = $request->get('analisisTestGroupIds', []);
            $aTestStringIds = $request->get('analisisTestIds', []);

            $aTestGroupIds = array_map(function($element) {
                return (int) $element;
            }, $aTestGroupStringIds);
            $aTestIds = array_map(function($element) {
                return (int) $element;
            }, $aTestStringIds);

            $groups = AnalysisTestGroup::whereNull('parent_id')->where('deleted', 0)->orderBy('name')->get();
            return view('a-test.partials.render-tree-groups-selected-v2', compact('groups', 'aTestGroupIds', 'aTestIds'))->render();
        }
    }
    
    public function renderListGroupsTestSelect(Request $request){
        if($request->ajax()){
            $aTestIds = $request->get('aTestIds', []);
//            dd($aTestIds);
            $groups = AnalysisTestGroup::where('deleted', 0)->orderBy('name')->get();
            return view('a-test.partials.render-list-selected',compact('groups', 'aTestIds'))->render();
        }
    }

    public function renderGroupForm(Request $request){
        if($request->ajax()){
            $aTestGroupId = $request->get('a_test_group_id', null);
            $analysisTestGroup = null;
            if($aTestGroupId != null){
                $analysisTestGroup = AnalysisTestGroup::find($aTestGroupId);
            }

//            dd($analysisTestGroup->price);
            $groups = AnalysisTestGroup::whereNull('parent_id')->where('deleted', 0)->with('children')->orderBy('name')->get();
            return view('a-test.partials.render-group-form',compact('groups', 'analysisTestGroup'))->render();
        }
    }

}
