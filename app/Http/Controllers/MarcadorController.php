<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Http\Requests\StoreMarkerPost;
use App\Marcador;
use App\Marker;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;

class MarcadorController extends Controller
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
        return view('marcador.home');
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
     * @param  StoreMarkerPost  $request
     * @return \Illuminate\Http\Response
     */
    public function aStore(StoreMarkerPost $request)
    {
        $newMarket = new Marker();
        if($request->get('id')){
            $newMarket = Marker::find($request->get('id'));
        }
        $newMarket->name = $request->get('name');
        $newMarket->description = $request->get('description');
        $newMarket->save();
        return response()->json(['success' => true, 'market' => $newMarket]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Marcador  $marcador
     * @return \Illuminate\Http\Response
     */
    public function show(Marcador $marcador)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Marcador  $marcador
     * @return \Illuminate\Http\Response
     */
    public function edit(Marcador $marcador)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Marcador  $marcador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marcador $marcador)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Marcador  $marcador
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marcador $marcador)
    {
        //
    }

    public function ajaxSave(Request $request){
        dd("dddddddd");
    }

    /**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getDatatablesMarkets()
    {
        return Laratables::recordsOf(Marker::class);
    }

    public function ajaxGetMarker(Request $request){
        return response()
            ->json(['success'=> true, 'marker' => Marker::find($request->get('markerId'))]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreMarkerPost  $request
     * @return \Illuminate\Http\Response
     */
    public function aDelete(Request $request)
    {
        $id = $request->get('id');
        $marker = Marker::destroy($id);
        return response()->json(['success' => $marker]);
    }

    public function ajaxSearchMarker(Request $request){
        $search = $request->get('search');
        $markers = Marker::where('name', 'like', '%'.$search.'%')->orderby('name')->get();
        $response = array();
        foreach($markers as $marker){
            $response[] = array(
                "id"=>$marker->id,
                "text"=>$marker->name
            );
        }
        return response()->json($response);
    }
}
