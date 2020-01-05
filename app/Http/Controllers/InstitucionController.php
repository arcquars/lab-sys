<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstitucionPost;
use App\Http\Requests\StorePersonPost;
use App\Institucion;
use App\Person;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class InstitucionController extends Controller
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
    public function index(Request $request)
    {

        return view('institucion.home');
    }

    /**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getDatatablesData()
    {
        return Laratables::recordsOf(Institucion::class);
    }

    /**
     * Display a listing of the ajaxCreateInstitucion.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxCreateInstitucion(StoreInstitucionPost $request){
        $institucionId = $request->get('id');
        $valid = true;
        if(isset($institucionId)){
            $institucion = Institucion::find($institucionId);
            $institucion->nombre = $request->get('nombre');
            $institucion->update();
        } else {
            $institucion = new Institucion();
            $institucion->nombre = $request->get('nombre');
            $valid = $institucion->save();
        }
        if($valid) {
            return response()->json(['success'=>true]);
        } else {
            return response()->json(['success'=> false, 'errors' => 'Existe un error por favor contactese con el administrador.']);
        }
    }

    public function ajaxGetInstitucion(Request $request){
        return response()
            ->json(['success'=> true, 'institucion' => Institucion::find($request->get('institucionId'))]);
    }
}
