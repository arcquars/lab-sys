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
        ]);

        $analisisTestGroup = new AnalysisTestGroup();
        $analisisTestGroup->name = $request->post('name');
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
    public function update(Request $request, $id)
    {
        //
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
            $groups = AnalysisTestGroup::where('deleted', 0)->get();
            return view('a-test.partials.render-list-groups',compact('groups'))->render();
        }
    }

    public function renderListGroupsTestSelect(Request $request){
        if($request->ajax()){
            $groups = AnalysisTestGroup::where('deleted', 0)->get();
            return view('a-test.partials.render-list-selected',compact('groups'))->render();
        }
    }
}
