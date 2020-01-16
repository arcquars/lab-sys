<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Http\Requests\StoreDoctorPost;
use App\Http\Requests\StorePersonPost;
use App\Institucion;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class DoctorController extends Controller
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
        return view('doctor.home');
    }

    /**
     * Display a listing of the ajaxCreateDoctor.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxCreateDoctor(StoreDoctorPost $request){
        $doctorId = $request->get('id');
        $valid = true;
        if(isset($doctorId)){
            $valid = $this->updateDoctor($request);
        } else {
            $valid = $this->createDoctor($request);
        }
        if($valid) {
            return response()->json(['success'=>true]);
        } else {
            return response()->json(['success'=> false, 'errors' => 'Existe un error por favor contactese con el administrador.']);
        }
    }

    private function createDoctor($request){
        $person = new Doctor();
        $person->nombres = $request->get('nombres');
        $person->apellidos = $request->get('apellidos');
        if($person->save()) {
            return $person->id;
        }
        return false;
    }

    private function updateDoctor($request){
        $person = Doctor::find($request->get('id'));
        $person->nombres = $request->get('nombres');
        $person->apellidos = $request->get('apellidos');

        if($person->update()) {
            return true;
        }
        return false;
    }

    /**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getDatatablesDoctor()
    {
        return Laratables::recordsOf(Doctor::class);
    }

    public function ajaxGetDoctor(Request $request){
        return response()
            ->json(['success'=> true, 'doctor' => Doctor::find($request->get('doctorId'))]);
    }
}
