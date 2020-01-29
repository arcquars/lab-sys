<?php

namespace App\Http\Controllers;

use App\Gasto;
use App\Http\Requests\StoreGastoPost;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;

class GastoController extends Controller
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
        return view('gasto.home');
    }

    /**
     * Display a listing of the ajaxCreateGasto.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxCreateGasto(StoreGastoPost $request){
        $gastoId = $request->get('id');
        $valid = true;
        if(isset($gastoId)){
//            $valid = $this->updateDoctor($request);
        } else {
            $valid = $this->createGasto($request);
        }
        if($valid) {
            return response()->json(['success'=>true]);
        } else {
            return response()->json(['success'=> false, 'errors' => 'Existe un error por favor contactese con el administrador.']);
        }
    }

    private function createGasto($request){
        $gasto = new Gasto();
        $gasto->detalle = $request->get('detalle');
        $gasto->fecha = $request->get('fecha');
        $gasto->gasto = $request->get('gasto');
        $gasto->user_id = auth()->id();

        if($gasto->save()) {
            return $gasto->id;
        }
        return false;
    }

    /**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getDatatablesGasto()
    {
//        return Laratables::recordsOf(Gasto::class);
        return Laratables::recordsOf(Gasto::class, function($query){
            return $query->where('user_id', auth()->id());
        });
    }
}
