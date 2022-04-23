<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\Bethesda;
use App\Biopsia;
use App\Convenio;
use App\Doctor;
use App\EditarControl;
use App\Histoquimica;
use App\Http\Requests\GraficReportPost;
use App\Http\Requests\StoreAnalisisPost;
use App\Http\Requests\StoreResultadosPost;
use App\Http\Requests\UpdateAnalisisPost;
use App\ImpresionControl;
use App\Institucion;
use App\Liquido;
use App\Person;
use App\Resultado;
use App\Rules\Saldo;
use App\Seccion;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Milon\Barcode\DNS2D;
use Octopush\Client;
use Octopush\Constant\TypeEnum;
use Octopush\Request\SmsCampaign\SendSmsCampaignRequest;
use PDF;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Integer;

class AnalisisController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('cerrarAnalisisForId', '');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dateNow = date('Y-m-d');
        $date7 = date('Y-m-d', strtotime('-7 days'));
        $procedencias = Institucion::all();
        $doctores = Doctor::where(Doctor::DELETED, '=', 0)->get();
        $tipoAnalisis = Config::get('clinica.tipo_analisis');
        return view('analisis.home', compact('procedencias', 'tipoAnalisis', 'doctores', 'dateNow', 'date7'));
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
        $analisis->edad = ($request->get('edad'))? $request->get('edad') : 0;
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
                    $convenio->bancaInstitucion = $request->get('bancaInstitucion');
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
     * @param  integer  $analisis
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $procedencias = Institucion::all();
        $analisis = Analisis::find($id);
        $doctores = Doctor::all();
        $convenio = Convenio::where('analisis_id', $id)->first();
        return view('analisis.edit',compact('analisis', 'procedencias', 'doctores', 'convenio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnalisisPost $request, $id)
    {
        $analisis = Analisis::find($id);

        $convenios = explode(",",config('clinica.convenios_id'));

        $valid1 = false;
        foreach ($convenios as $con){
            if($con == $analisis->procedencia){
                $valid1 = true;
            }
        }
        $valid2 = false;
        foreach ($convenios as $con){
            if($con == $request->post('procedencia')){
                $valid2 = true;
            }
        }
        if($valid1){
            if(!$valid2){
                // borrar registeo de la tabla convenios
                Convenio::where('analisis_id', $id)->delete();
            }
        }

        $analisis->fill($request->all());
        if($analisis->update()){
            $convenios = explode(',', Config::get('clinica.convenios_id'));
            if(count($convenios) == 0){
                $convenios = array([Config::get('clinica.convenios_id')]);
            }
            for ($i=0; $i<count($convenios); $i++){
                if($convenios[$i] == $analisis->procedencia){
                    $convenio = Convenio::where('analisis_id', $id)->first();
                    if($convenio == null){
                        $convenio = new Convenio();
                        $convenio->analisis_id = $analisis->id;
                    }
                    $convenio->bancaInstitucion = $request->get('bancaInstitucion');
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


                    $convenio->save();
                }
            }
        }
        return redirect()->action(
            'AnalisisController@index');
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
     * @return View
     */
    public function crearAnalisisForPersona($personId){
        $persona = Person::find($personId);
        $edad = '';
        if($persona->f_nacimiento){
            $edad = Carbon::parse($persona->f_nacimiento)->age;
        }
        $procedencias = Institucion::all();
        $doctores = Doctor::all();
        $tipoAnalisis = Config::get('clinica.tipo_analisis');
        $convenio = null;
        return view('analisis.crear', compact(
            'procedencias',
            'doctores',
            'edad',
            'tipoAnalisis',
            'persona',
        'convenio'));
    }

    /**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getDatatablesData(Request $request)
    {
        $columns = $request->get('columns');
        $searchNombres = isset($columns[2]['search']['value'])? $columns[2]['search']['value'] : '';
        $searchApellidos = isset($columns[3]['search']['value'])? $columns[3]['search']['value'] : '';
        $searchDoctorId = isset($columns[8]['search']['value'])? $columns[8]['search']['value'] : '';

        return Laratables::recordsOf(Analisis::class, function($query) use ($searchNombres, $searchApellidos, $searchDoctorId){
            return $query->where('doctor_asignado', 'like', '%'.$searchDoctorId.'%')->whereHas('person', function($q) use ($searchNombres, $searchApellidos)
            {
                $q->where('nombres', 'like', '%'.$searchNombres.'%')
                    ->where('apellidos', 'like', '%'.$searchApellidos.'%');
            });
        });
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
            case Analisis::BIOLOGIA_MOLECULAR:
                return redirect()->action(
                    'BiologiamolecularController@create',
                    ['analisisId' => $analisisId]);
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
            case Analisis::LIQUIDOS:
                return redirect()->action(
                    'LiquidoController@create',
                    ['analisisId' => $analisisId]);
            case Analisis::HISTOPATOLOGICO:
                return redirect()->action(
                    'BiopsiaController@create',
                    ['analisisId' => $analisisId, 'is_histopatologico' => true]);
            default:
                return redirect()->action(
                    'BiopsiaController@create',
                    ['analisisId' => $analisisId, 'is_histopatologico' => 0]);
        }
    }

    public function ajaxGetCode(Request $request){
        $tipoAnalisis = $request->get('tipo-analisis');
        $codigo = '';
//        $numeroFecha = '-'.date('y').date('m').date('d');
        $numeroFecha = '-'.date('y');
//        $analisisIdNext = Analisis::max('id');
        switch ($tipoAnalisis){
            case Analisis::CITOLOGIA:
                $num = Analisis::where('tipo_analisis', Analisis::BETHESDA)->count() +
                    Analisis::where('tipo_analisis', Analisis::LIQUIDOS)->count() +
                    Analisis::where('tipo_analisis', Analisis::CITOLOGIA)->count() + config('clinica.contadores_analisis.CITOLOGIA');
                $codigo = 'C'.$numeroFecha.'-'.$this->formatoCodigo4Dig($num);
                break;
            case Analisis::BIOPSIA:
                $num = Analisis::where('tipo_analisis', Analisis::BIOPSIA)->count() + config('clinica.contadores_analisis.BIOPSIA');
                $codigo = 'B'.$numeroFecha.'-'.$this->formatoCodigo4Dig($num);
                break;
            case Analisis::INMUNOHISTOQUIMICA:
                $num = Analisis::where('tipo_analisis', Analisis::INMUNOHISTOQUIMICA)->count() + config('clinica.contadores_analisis.INMUNOHISTOQUIMICA');
                $codigo = 'IHQ'.$numeroFecha.'-'.$this->formatoCodigo4Dig($num);
                break;
            case Analisis::BETHESDA:
                $num = Analisis::where('tipo_analisis', Analisis::BETHESDA)->count() + config('clinica.contadores_analisis.BETHESDA');
                $codigo = 'BTD'.$numeroFecha.'-'.$this->formatoCodigo4Dig($num);
                break;
            case Analisis::HISTOPATOLOGICO:
                $num = Analisis::where('tipo_analisis', Analisis::HISTOPATOLOGICO)->count() + config('clinica.contadores_analisis.HISTOPATOLOGICO'); // 300
                $codigo = 'BR'.$numeroFecha.'-'.$this->formatoCodigo4Dig($num);
                break;
            case Analisis::BIOLOGIA_MOLECULAR:
                $num = Analisis::where('tipo_analisis', Analisis::BIOLOGIA_MOLECULAR)->count() + config('clinica.contadores_analisis.BIOLOGIA_MOLECULAR'); // 300
                $codigo = 'BM'.$numeroFecha.'-'.$this->formatoCodigo4Dig($num);
                break;
        }
        return response()->json(['success' => $codigo]);
    }

    public function ajaxRealizarPago(Request $request){
        $analisisId = $request->get('analisis_id');
        $nit = $request->get('nit', '');
        $razon_social = $request->get('razon_social', '');
        $pagoFecha = $request->get('fecha_pago_efectuado', '');
        $analisis = Analisis::find($analisisId);
        $pago = $analisis->pago_efectuado;
        $analisis->pago_efectuado = $analisis->precio - ($analisis->acuenta + $pago);
        $analisis->acuenta = $analisis->acuenta + $pago;
        $analisis->fecha_pago_efectuado = $pagoFecha;
        $analisis->pago_efectuado_user = auth()->id();
        $analisis->nit = $nit;
        $analisis->razon_social = $razon_social;

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
            'pago' => $analisis->pago_efectuado,
            'acuenta' => $analisis->acuenta,
            'nit' => $analisis->nit,
            'razon_social' => $analisis->razon_social,
        );

        return response()->json(['success' => $resultado, 'bandera' => 1]);
        //$view = view('view.name', $arr)->render();
        //return response()->json(['status' => 200, 'view' => $view]);
    }

    public function ajaxGetAnalisisById(Request $request){
        $analisisId = $request->get('analisis_id');
        return response()->json(['success' => true, 'analisis' => Analisis::find($analisisId), 'bandera' => 1]);
    }

    public function ajaxGetAnalisisPacienteById(Request $request){
        $analisisId = $request->get('analisis_id');
        $analisis = Analisis::find($analisisId);
        $texto_pre = config('clinica.sms_enviar_texto') . route('analisis.open.esultado.simple.pdf', ['analisisId' =>base64_encode($analisisId)]);
        return response()->json(['success' => true, 'analisis' => $analisis, 'paciente' => $analisis->person,  'bandera' => 1, 'texto_pre' => $texto_pre]);
    }

    public function ajaxSearchPaciente(Request $request){
        $search = $request->post('search');
        if($search == ''){
            $clientes = Person::orderby('nombres')->select('id', 'nombres', 'apellidos', 'apellido_materno', 'edad')->limit(10)->get();
        } else {
            $clientes = Person::orderby('nombres', 'asc')->select('id', 'nombres', 'apellidos', 'apellido_materno', 'edad')->where('apellidos', 'like', '%'.$search.'%')->get();
        }
        $response = array();
        foreach($clientes as $cliente){
            $response[] = array(
                "id"=>$cliente->id,
                "text"=>$cliente->nombres.' '.$cliente->apellidos.' '.$cliente->apellido_materno.' ('.$cliente->edad.')'
            );
        }
        return response()->json($response);
    }

    public function ajaxChangePaciente(Request $request){
        $paciente_id = $request->post('paciente_id');
        $analisis_id = $request->post('analisis_id');

        $analisis = Analisis::find($analisis_id);
        $analisis->person_id = $paciente_id;
        $analisis->save();
        $response = array('analisis' => $analisis);
        session()->flash('success', 'Se cambio el paciente con exito!');
        return response()->json($response);
    }

    public function ajaxSearchDoctor(Request $request){
        $search = $request->get('search');
        $anaDoctores = Analisis::where('doctor', 'like', '%'.$search.'%')->orderby('doctor')->distinct()->get('doctor');
        $response = array();
        foreach($anaDoctores as $doctor){
            $response[] = array(
                "id"=>$doctor->doctor,
                "text"=>$doctor->doctor
            );
        }
        return response()->json($response);
    }

    public function ajaxRegistrarFechaEntrega(Request $request){
        $validatedFechaEntrega = $request->validate([
            'analisis_id' => 'required',
            'persona_entrega' => 'required|min:10|max:180',
            'fecha_entrega' => 'required',
//            'hora_entrega' => 'required',
        ]);

        $analisis_id = $request->post('analisis_id');
        $persona_entrega = $request->post('persona_entrega');
        $fecha_entrega = $request->post('fecha_entrega');
//        $hora_entrega = $request->post('hora_entrega');
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
        return response()->json(['success' => '0']);
    }

    public function ajaxEnviarSmsPaciente(Request $request){
        $validatedSenSms = $request->validate([
            'analisis_id' => 'required',
            's_celular' => 'required|min:40000000|max:99999999|integer',
            's_texto' => 'string|min:3|max:200|required',
        ]);

        $analisis_id = $request->post('analisis_id');
        $celular = $request->post('s_celular');
        $texto = $request->post('s_texto');
        if($validatedSenSms){
            $analisis = Analisis::find($analisis_id);
            $analisis->telefono_referencia = $celular;
            $analisis->send_sms = 1;
            $analisis->update();

            $octopushEmail = env('OCTOPUSH_EMAIL');
            $octopushKey = env('OCTOPUSH_KEY');
            $client = new Client($octopushEmail, $octopushKey);
            $request = new SendSmsCampaignRequest();
            $request->setRecipients([
                [
                'phone_number' => '+591'.$celular,
                ]
            ]);
            $request->setSender('+59179346585');
            $request->setText($texto);
            $request->setType(TypeEnum::SMS_PREMIUM);
            $content = $client->send($request);

//            $content = 'xxx';
            return response()->json(['success' => '1', 'smsresult' => $content]);
        }
        return response()->json(['success' => '0', 'message' => 'Ocurrio un error por favor contactese con el administrador.']);
    }

    public function ajaxEnviarWappPaciente(Request $request){
        $validatedSenSms = $request->validate([
            'analisis_id' => 'required',
            's_celular' => 'required|min:40000000|max:99999999|integer',
            's_texto' => 'string|min:3|max:200|required',
        ]);

        $analisis_id = $request->post('analisis_id');
        $celular = $request->post('s_celular');
        $texto = $request->post('s_texto');
        if($validatedSenSms){
            $analisis = Analisis::find($analisis_id);
            $analisis->telefono_referencia = $celular;
            $analisis->send_sms = 1;
            $analisis->update();
//
//            $octopushEmail = env('OCTOPUSH_EMAIL');
//            $octopushKey = env('OCTOPUSH_KEY');
//            $client = new Client($octopushEmail, $octopushKey);
//            $request = new SendSmsCampaignRequest();
//            $request->setRecipients([
//                [
//                    'phone_number' => '+591'.$celular,
//                ]
//            ]);
//            $request->setSender('+59179346585');
//            $request->setText($texto);
//            $request->setType(TypeEnum::SMS_PREMIUM);
//            $content = $client->send($request);

            $content = 'https://api.whatsapp.com/send?phone='.'+591'.$celular.'&text='.$texto;
            return response()->json(['success' => '1', 'wappresult' => $content]);
        }
        return response()->json(['success' => '0', 'message' => 'Ocurrio un error por favor contactese con el administrador.']);
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
            return $query->where('tipo_analisis', Analisis::BIOPSIA)->OrWhere('tipo_analisis', Analisis::HISTOPATOLOGICO)->orderBy('fecha', 'desc');
        });
    }

    public function ajaxGetPrecio(Request $request){
        $analisisId = $request->post('analisis_id');
        $analisis = Analisis::find($analisisId);

        return response()->json([
            'success' => '1',
            'precio' => $analisis->precio,
            'acuenta' => $analisis->acuenta,
            'pago_efectuado' => $analisis->pago_efectuado,
            'fecha_pago_efectuado' => $analisis->fecha_pago_efectuado]);
    }

    public function ajaxSetImprimirFirma(Request $request){
        $analisisId = $request->post('analisis_id');
        $ifirma = $request->post('imprimir_firma');
        $analisis = Analisis::find($analisisId);
        $analisis->imprimir_firma = $ifirma;
        $analisis->update();

        return response()->json(['success' => '1']);
    }

    public function ajaxChageToCitologia(Request $request){
        $analisisId = $request->post('analisis_id');
        $analisis = Analisis::find($analisisId);
        $analisis->tipo_analisis = Analisis::CITOLOGIA;
        $analisis->update();

        return response()->json(['success' => '1', 'res' => Analisis::CITOLOGIA]);
    }

    public function ajaxGraficReport(GraficReportPost $request){
        $fechaInicio = $request->post('f_inicio');
        $fechaFin = $request->post('f_fin');

        $analisisType = Analisis::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->groupBy('tipo_analisis')->selectRaw('tipo_analisis, count(*) as count')->get();

        $analisisDoctores = Analisis::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->join('doctores', 'doctores.id', '=', 'analisis.doctor_asignado')
            ->groupBy('doctor_asignado')->selectRaw('concat(doctores.nombres, \' \', apellidos) as nombres, count(*) as count')->get();

        $analisisCreadores = Analisis::whereBetween('analisis.created_at', [$fechaInicio, $fechaFin])
            ->join('users', 'users.id', '=', 'analisis.user_id')
            ->groupBy('user_id')->selectRaw('users.name, count(*) as count')->get();



        return response()->json([
            "analisisTipo" => $analisisType,
            'analisisDoctores' => $analisisDoctores,
            "analisisCreadores" => $analisisCreadores,
            'usuarioWorks' => Analisis::reporteUserWork($fechaInicio, $fechaFin)]);
    }

    public function ajaxSetPrecio(Request $request){
        $analisisId = $request->post('analisis_id');
        $precio = $request->post('precio');
        $acuenta = $request->post('acuenta');
        $pago_efectuado = $request->post('pago_efectuado');
        $fecha_pago_efectuado = $request->post('fecha_pago_efectuado');

//        dd($fecha_pago_efectuado);
        $request->validate([
            'precio' => 'required|numeric|between:0,20000',
            'acuenta' => 'required|numeric|between:0,'.$precio,
            'pago_efectuado' => ['nullable', 'numeric', new Saldo($precio, $acuenta)],
            'fecha_pago_efectuado' => 'required_with:pago_efectuado'
        ]);

        $analisis = Analisis::find($analisisId);

        $analisis->precio = $precio;
        $analisis->acuenta = $acuenta;
//        $analisis->acuenta = $analisis->acuenta + $analisis->pago_efectuado;
        $analisis->pago_efectuado = isset($pago_efectuado)? $pago_efectuado : 0;
        $analisis->fecha_pago_efectuado = isset($pago_efectuado)? $fecha_pago_efectuado : null;

        return response()->json(['success' => $analisis->save()]);
    }

    public function listaImpresion($analisisId){
        /** @var ImpresionControl $impresionesControl */
        $impresionesControl = ImpresionControl::where('analisis_id',$analisisId)->orderBy('created_at', 'desc')->get();

        return view('analisis.lista_impresiones', compact(
            'impresionesControl'));
    }

    public function listaEdicion($analisisId){
        /** @var EditarControl $editarControl */
        $editarControl = EditarControl::where('analisis_id',$analisisId)->orderBy('created_at', 'desc')->get();

        return view('analisis.lista_cambios', compact(
            'editarControl'));
    }

    public function formatoCodigo4Dig($num){
        $lenght = strlen($num);
        $codigoDig = '';
        switch ($lenght){
            case 1:
                $codigoDig = '000'.$num;
                break;
            case 2:
                $codigoDig = '00'.$num;
                break;
            case 3:
                $codigoDig = '0'.$num;
                break;
            default:
                $codigoDig = ''.$num;
                break;
        }
        return $codigoDig;
    }

    /**
     * Vista que actualiza la fecha de cierre
     *
     * @param  integer analisisId
     * @return View
     */
    public function cerrarAnalisisForId($analisisId){
        if (!Auth::check())
        {
            dd('No esta con session!!');
        }

        $analisis = Analisis::find($analisisId);
        if($analisis->fecha_cierre == null){
            Session::flash('flash_message', '<b>Acualizo!</b> se cerro el analisis.');
            Session::flash('flash_type', 'success');
            $analisis->fecha_cierre = Carbon::now();
            $analisis->update();
        } else {
            Session::flash('flash_message', '<b>El analisis</b> ya se cerro en fecha: '. $analisis->fecha_cierre->format('d-m-Y'));
            Session::flash('flash_type', 'info');
        }

//        dd('eee');
        return redirect()->route('analisis.home');
//        return view('analisis.cerrar_analisis');
    }
}
