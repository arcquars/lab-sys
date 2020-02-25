<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\Convenio;
use App\Doctor;
use App\Http\Requests\StoreAnalisisPost;
use App\Http\Requests\StoreResultadosPost;
use App\Institucion;
use App\Person;
use App\Resultado;
use App\Seccion;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use Milon\Barcode\DNS2D;
use PDF;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

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
        $analisis->doctor_asignado = $request->get('doctor_asignado');
        $analisis->tipo_analisis = $request->get('tipo_analisis');
        $analisis->procedencia = $request->get('procedencia');
        $analisis->region = $request->get('region');
        $analisis->telefono_referencia = $request->get('telefono_referencia');
        $analisis->precio = $request->get('precio');
        $analisis->codigo = $request->get('codigo');

        $analisis->razon_social = $request->get('razon_social');
        $analisis->nit = $request->get('nit');

        if($request->get('acuenta')) {
            if($request->get('acuenta') == $request->get('precio')){
                $analisis->pago_efectuado = $request->get('acuenta');
                $analisis->acuenta = 0;
                $analisis->fecha_pago_efectuado = Carbon::now();
                $analisis->pago_efectuado_user = auth()->id();
            } else {
                $analisis->acuenta = $request->get('acuenta');
            }
        }else
            $analisis->acuenta = 0;
        $analisis->observaciones = $request->get('observaciones');
        $analisis->user_id = auth()->id();

        if($analisis->save()) {
            $convenios = explode(',', Config::get('clinica.convenios_id'));
            if(count($convenios) == 0){
                $convenios = array([Config::get('clinica.convenios_id')]);
            }
            for ($i=0; $i<count($convenios); $i++){
                if($convenios[$i] == $analisis->procedencia){
                    $convenio = new Convenio();
                    $convenio->bancaMatricula = $request->get('bancaMatricula');
                    $convenio->bancaPreAfiliacion = $request->get('bancaPreAfiliacion');
                    $convenio->bancaActivoAsegurado = $request->get('bancaActivoAsegurado');
                    $convenio->bancaActivoExt = $request->get('bancaActivoExt');
                    $convenio->bancaActivoResto = $request->get('bancaActivoResto');
                    $convenio->bancaPasivoAsegurado = $request->get('bancaPasivoAsegurado');
                    $convenio->bancaPasivoExt = $request->get('bancaPasivoExt');
                    $convenio->bancaPasivoResto = $request->get('bancaPasivoResto');
                    $convenio->bancaSecAsegurado = $request->get('bancaSecAsegurado');
                    $convenio->bancaSecExt = $request->get('bancaSecExt');
                    $convenio->bancaSecResto = $request->get('bancaSecResto');
                    $convenio->bancaEspecialidad = $request->get('bancaEspecialidad');
                    $convenio->bancaAmbulatorio = $request->get('bancaAmbulatorio');
                    $convenio->bancaHospitalizado = $request->get('bancaHospitalizado');
                    $convenio->analisis_id = $analisis->id;

                    $convenio->save();
                }
            }

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
        $doctores = Doctor::all();
        $tipoAnalisis = Config::get('clinica.tipo_analisis');
        return view('analisis.crear', compact(
            'procedencias',
            'doctores',
            'tipoAnalisis',
            'persona'));
    }

    /**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getDatatablesData()
    {
        return Laratables::recordsOf(   Analisis::class);
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
        $analisis = Analisis::find($analisisId);
        switch ($analisis->tipo_analisis){
            case Analisis::CITOLOGIA:
                return view('analisis.aextendido', compact('analisisId'));
            case Analisis::BIOPSIA:
                dd(Analisis::BIOPSIA);
                break;
            default:
                dd("ssss");
                break;

        }
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

        $hichartArray = $request->input('hichart');
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

    public function crearTipoAnalisis($analisisId){
        $analisis = Analisis::find($analisisId);
        switch ($analisis->tipo_analisis){
            case Analisis::BIOPSIA:
                return redirect()->action(
                    'BiopsiaController@create',
                    ['analisisId' => $analisisId, 'is_histopatologico' => 0]);
            case Analisis::INMUNOHISTOQUIMICA:
                return redirect()->action(
                    'InmunohistoquimicaController@create',
                    ['analisisId' => $analisisId]);
            case Analisis::CITOLOGIA:
                return redirect()->action(
                    'CitologiaController@create',
                    ['analisisId' => $analisisId]);
            case Analisis::BETHESDA:
                return redirect()->action(
                    'BethesdaController@create',
                    ['analisisId' => $analisisId]);
            case Analisis::HISTOPATOLOGICO:
                return redirect()->action(
                    'BiopsiaController@create',
                    ['analisisId' => $analisisId, 'is_histopatologico' => true]);
        }
    }

    public function ajaxGetCode(Request $request){
        $tipoAnalisis = $request->get('tipo-analisis');
        $codigo = '';
        $numeroFecha = '-'.substr(date('Y'), 1).'-'.date('m').date('d');
        $analisisIdNext = Analisis::max('id')+1;
        switch ($tipoAnalisis){
            case Analisis::CITOLOGIA:
                $codigo = 'C'.$numeroFecha.$analisisIdNext;
                break;
            case Analisis::BIOPSIA:
                $codigo = 'B'.$numeroFecha.$analisisIdNext;
                break;
            case Analisis::INMUNOHISTOQUIMICA:
                $codigo = 'I'.$numeroFecha.$analisisIdNext;
                break;
            case Analisis::BETHESDA:
                $codigo = 'BTD'.$numeroFecha.$analisisIdNext;
                break;
            case Analisis::HISTOPATOLOGICO:
                $codigo = 'BH'.$numeroFecha.$analisisIdNext;
                break;
        }
        return response()->json(['success' => $codigo]);
    }

    public function ajaxRealizarPago(Request $request){
        $analisisId = $request->get('analisis_id');
        $analisis = Analisis::find($analisisId);
        $analisis->pago_efectuado = $analisis->precio - $analisis->acuenta;
        $analisis->fecha_pago_efectuado = Carbon::now();
        $analisis->pago_efectuado_user = auth()->id();

        if($analisis->update())
            return response()->json(['success' => '1']);
        return response()->json(['success' => '0']);
    }

    public function ajaxGetAnalisisPago(Request $request){
        $analisisId = $request->get('analisis_id');
        $analisis = Analisis::find($analisisId);
        $resultado = array(
            'cliente' => $analisis->person->nombres.' '.$analisis->person->apellidos,
            'doctor' => $analisis->doctor,
            'precio' => $analisis->precio,
            'acuenta' => $analisis->acuenta
        );
        return response()->json(['success' => $resultado]);
    }

    public function ajaxRegistrarFechaEntrega(Request $request){
        $validatedFechaEntrega = $request->validate([
            'analisis_id' => 'required',
            'persona_entrega' => 'required|min:10|max:180',
            'fecha_entrega' => 'required',
        ]);

        $analisis_id = $request->post('analisis_id');
        $persona_entrega = $request->post('persona_entrega');
        $fecha_entrega = $request->post('fecha_entrega');
        if($validatedFechaEntrega){
            if(Analisis::updatePersonaFechaEntrega($analisis_id, $persona_entrega, $fecha_entrega)){
                return response()->json(['success' => '1']);
            }
            return response()->json(['success' => '0']);
        }
    }

    public function ajaxRegistrarFechaCierre(Request $request){
        $validatedFechaCierre = $request->validate([
            'analisis_id' => 'required',
            'fecha_cierre' => 'required',
        ]);

        $analisis_id = $request->post('analisis_id');
        $fecha_cierre = $request->post('fecha_cierre');
        if($validatedFechaCierre){
            if(Analisis::updateFechaCierre($analisis_id, $fecha_cierre)){
                return response()->json(['success' => '1']);
            }
            return response()->json(['success' => '0']);
        }
    }

    function comprobante($analisisId) {
        $analisis = Analisis::find($analisisId);

        $d = new DNS2D();
        $d->setStorPath(public_path()."/generateqr/");
        $pathQr = $d->getBarcodePNGPath($analisis->codigo, "QRCODE");

        $pdf = PDF::loadView('analisis.comprobante', compact(
            'analisis', 'pathQr'));
        $fileNombre = 'comprobante-'.$analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }

    public function listaTec()
    {
        return view('analisis.listatecnico');
    }

    /**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getDatatablesTecnico()
    {
        return Laratables::recordsOf(Analisis::class, function($query){
            return $query->where('tipo_analisis', Analisis::BIOPSIA)->orderBy('fecha', 'desc');
        });
    }

    public function ajaxGetPrecio(Request $request){
        $analisisId = $request->post('analisis_id');
        $analisis = Analisis::find($analisisId);

        return response()->json(['success' => '1', 'precio' => $analisis->precio]);
    }

    public function ajaxSetPrecio(Request $request){
        $request->validate([
            'precio' => 'required|integer|min:10'
        ]);

        $analisisId = $request->post('analisis_id');
        $precio = $request->post('precio');

        $analisis = Analisis::find($analisisId);

        $analisis->precio = $precio;

        return response()->json(['success' => $analisis->save()]);
    }
}
