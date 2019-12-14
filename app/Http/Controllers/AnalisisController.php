<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\Http\Requests\StoreAnalisisPost;
use App\Http\Requests\StoreResultadosPost;
use App\Institucion;
use App\Person;
use App\Resultado;
use App\Seccion;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class AnalisisController extends Controller
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
        $procedencias = Institucion::all();
        $tipoAnalisis = Config::get('clinica.tipo_analisis');
        return view('analisis.home', compact('procedencias', 'tipoAnalisis'));
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
    public function store(StoreAnalisisPost $request)
    {
        $analisis = new Analisis();
        $analisis->person_id = $request->get('person_id');
        $analisis->doctor = $request->get('doctor');
        $analisis->fecha = $request->get('fecha');
        $analisis->tipo_analisis = $request->get('tipo_analisis');
        $analisis->procedencia = $request->get('procedencia');
        $analisis->region = $request->get('region');
        $analisis->precio = $request->get('precio');
        if($request->get('acuenta'))
            $analisis->acuenta = $request->get('acuenta');
        else
            $analisis->acuenta = 0;
        $analisis->observaciones = $request->get('observaciones');
        $analisis->user_id = auth()->id();

        if($analisis->save()) {
            return redirect('/clients');
        } else {
            dd('El analisis tiene errores!!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Analisis  $analisis
     * @return \Illuminate\Http\Response
     */
    public function show(Analisis $analisis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Analisis  $analisis
     * @return \Illuminate\Http\Response
     */
    public function edit(Analisis $analisis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Analisis  $analisis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Analisis $analisis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Analisis  $analisis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Analisis $analisis)
    {
        //
    }

    /**
     * formulario para crear un analisis para una persona.
     *
     * @param  integer personId
     * @return \Illuminate\Http\Response
     */
    public function crearAnalisisForPersona($personId){
        $persona = Person::find($personId);
        $procedencias = Institucion::all();
        $tipoAnalisis = Config::get('clinica.tipo_analisis');
        return view('analisis.crear', compact('procedencias', 'tipoAnalisis', 'persona'));
    }

    /**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getDatatablesData()
    {
        return Laratables::recordsOf(Analisis::class);
    }

    /**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getDatatablesDataByPersonId($personId)
    {
        return Laratables::recordsOf(Analisis::class, function($query) use ($personId){
            return $query->where('person_id', $personId);
        });
    }

    public function listByPerson($personId){
        $person = Person::find($personId);
        return view('analisis.listByPerson', compact('person'));
    }

    public function analisisExtendido($analisisId){
        return view('analisis.aextendido', compact('analisisId'));
    }

    public function resultados(StoreResultadosPost $request)
    {
        die('Exito!!!');
        $resultado = new Resultado();
        $resultado->papanicolaou_clase1 = $request->input('papanicolaou_clase1');
        $resultado->papanicolaou_clase2 = $request->input('papanicolaou_clase2');
        $resultado->observaciones1 = $request->input('observaciones1');
        $resultado->observaciones2 = $request->input('observaciones2');
        $resultado->analisis_id = $request->input('analisis_id');
        $resultado->user_id = auth()->id();

//        $resultado->save();
//        $omsArray = $request->input('oms');
//        foreach ($omsArray as $key => $value){
//            $seccion = new Seccion();
//            $seccion->seccion = 'OMS';
//            $seccion->key = $key;
//            $seccion->value = $value;
//            $seccion->resultado_id = $resultado->id;
//            $seccion->save();
//        }

        $hichartArray = $request->input('hichart');
//        dd($hichartArray);
        foreach($hichartArray as $key => $value){
            dd($key.' || '.$value);
            $seccion = new Seccion();
            $seccion->seccion = 'hichart';
            $seccion->key = $key;
            $seccion->value = $value;
            $seccion->resultado_id = $resultado->id;
            $seccion->save();
        }
        die();

        $bethesdaArray = $request->input('bethesda');

        foreach ($bethesdaArray as $key => $value){
            $seccion = new Seccion();
            $seccion->seccion = 'bethesda';
            $seccion->key = $key;
            $seccion->value = $value;
            $seccion->resultado_id = $resultado->id;
            $seccion->save();
        }

        dd($request->input('ExtComp'));
    }
}
