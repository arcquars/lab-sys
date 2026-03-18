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
        $doctor = new Doctor();
        $doctor->nombres = $request->get('nombres');
        $doctor->apellidos = $request->get('apellidos');
        $doctor->especialidad = $request->get('especialidad');
        $doctor->matricula = $request->get('matricula');
        $doctor->supervisado = $request->get('supervisado', 0);

        if(isset($request->file)){
            $doctor->signing = $this->uploadSignig($request->file);
        }

        if($doctor->save()) {
            return $doctor->id;
        }
        return false;
    }

    private function updateDoctor($request){
        $doctor = Doctor::find($request->get('id'));
        $doctor->nombres = $request->get('nombres');
        $doctor->apellidos = $request->get('apellidos');
        $doctor->especialidad = $request->get('especialidad');
        $doctor->matricula = $request->get('matricula');
        $doctor->supervisado = $request->get('supervisado', 0);

        if(isset($request->file)){
            $doctor->signing = $this->uploadSignig($request->file);
        }

        if($doctor->update()) {
            return true;
        }
        return false;
    }

    private function uploadSignig($file){
        $fileName = time().'.'.$file->extension();
        $file->move(public_path('uploads/signings/'), $fileName);

        return $fileName;
    }

    /**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getDatatablesDoctor()
    {
        return Laratables::recordsOf(Doctor::class, function($query){
            return $query->where('deleted', false);
        });
    }

    public function ajaxGetDoctor(Request $request){
        return response()
            ->json(['success'=> true, 'doctor' => Doctor::find($request->get('doctorId'))]);
    }

    public function ajaxDeleteSigning(Request $request){
        $doctorId = $request->post('doctorId');
        $doctor = Doctor::find($doctorId);
        $doctor->signing = '';
        $doctor->save();
        return response()
            ->json(['success'=> true]);
    }
}
