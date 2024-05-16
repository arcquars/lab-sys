<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\Bethesda;
use App\Biopsia;
use App\ClinicaClass\Reporte2;
use App\Convenio;
use App\Exports\ReporteAdminDesechoExport;
use App\Exports\ReporteAdminDiaConvenioExport;
use App\Exports\ReporteAdminDiaExport;
use App\Exports\ReporteAdminExport;
use App\Exports\ReporteDiarioExport;
use App\Exports\ReporteFacturacionExport;
use App\Gasto;
use App\Histoquimica;
use App\Http\Requests\StoreReporte2Post;
use App\Http\Requests\StoreReporteDiarioPost;
use App\Institucion;
use App\Liquido;
use App\Resultado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Excel;
use PDF;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte1()
    {
        $fecha = date('Y-m-d');
        $procedenciaId = 0;

        $procedencias = Institucion::all();
        $analisis = Analisis::where('tipo_pago_acuenta', '=', Analisis::TIPO_PAGO_ACUENTA[0])->where('fecha', $fecha)->where('acuenta', '>', 0 )->get();
        $analisisEfec = Analisis::where('tipo_pago_efectuado', '=', Analisis::TIPO_PAGO_EFECTUADO[0])->where('fecha_pago_efectuado', $fecha)->get();
        $totalAcuenta = 0;
        $totalEfec = 0;
        foreach ($analisis as $ana){
            $totalAcuenta += $ana->acuenta;
        }
        foreach ($analisisEfec as $ana){
            $totalEfec += $ana->pago_efectuado;
        }
//        $analisis = Analisis::where('fecha', date('Y-m-d'))->get();
        return view('reportes.reporte1', compact(
            'procedencias',
            'analisis',
            'analisisEfec',
            'totalAcuenta',
            'totalEfec',
            'fecha',
            'procedenciaId'
            ));
    }

    public function reporteDiario()
    {
        $fecha_ini = date('Y-m-d', strtotime('-1 month'));
        $fecha_fin = date('Y-m-d');
        $procedenciaId = 0;
        $tipoId = 0;

        $procedencias = Institucion::all();

        $tipoAnalisis = Config::get('clinica.tipo_analisis_1');

        $analisis = Analisis::where('tipo_pago_acuenta', '=', Analisis::TIPO_PAGO_ACUENTA[0])->whereBetween('fecha', [$fecha_ini, $fecha_fin])->where('acuenta', '>', 0)->get();
        $analisisPagos = Analisis::where('tipo_pago_efectuado', '=', Analisis::TIPO_PAGO_EFECTUADO[0])->whereBetween('fecha_pago_efectuado', [$fecha_ini, $fecha_fin])->whereNotNull('fecha_pago_efectuado')->get();
        $gastos = Gasto::whereBetween('fecha', [$fecha_ini, $fecha_fin])->get();
        $totalPrecio = 0;
        $totalAcuenta = 0;
        $totalDebe = 0;
        foreach ($analisis as $ana){
            $totalPrecio += $ana->precio;
            $totalAcuenta += $ana->acuenta;
            $totalDebe += ($ana->precio - $ana->acuenta);
        }

        $totalPrecioPago = 0;
        $totalAcuentaPago = 0;
        $totalDebePago = 0;
        foreach ($analisisPagos as $ana){
            $totalPrecioPago += $ana->precio;
            $totalAcuentaPago += $ana->acuenta;
//            $totalDebePago += ($ana->precio - $ana->acuenta);
            $totalDebePago += $ana->pago_efectuado;
        }

        $totalGastos = 0;
        foreach ($gastos as $gasto){
            $totalGastos += $gasto->gasto;
        }

        return view('reportes.reporte-diario', compact(
            'procedencias',
            'analisis', 'totalDebe', 'tipoId',
            'totalPrecio', 'totalAcuenta',
            'fecha_ini', 'fecha_fin', 'gastos',
            'procedenciaId', 'totalGastos', 'tipoAnalisis',
            'analisisPagos', 'totalPrecioPago', 'totalAcuentaPago', 'totalDebePago'
        ));
    }

    public function reporte2()
    {
//        $fechaIni = date_create(date('Y-m-d', strtotime('-1 month')));
        $fechaIni = date('Y-m-d', strtotime('-1 month'));
        $fechaFin = date('Y-m-d');
        $procedenciaId = 0;
        $procedencias = Institucion::all();
        $reporte_2 = array();
        return view('reportes.reporte2', compact(
            'procedencias',
            'fechaIni', 'fechaFin',
            'procedenciaId', 'reporte_2'
        ));
    }

    public function reporteAdminDiario()
    {
        $date = new \DateTime();
        $year = intval($date->format('Y'));
        $mes = $date->format('m');
        $day_last = $date->format('t');
        $procedenciaId = 0;
        $sTipoAnalisis = '';

        $tipoAnalisis = Config::get('clinica.tipo_analisis_1');

        $fecha_ini = $year.'-'.$mes.'-01';
        $fecha_fin = $year.'-'.$mes.'-'.$day_last;

        $year_old = intval(date_create(DB::table('analisis')->min('fecha'))->format('Y'));

        $procedencias = Institucion::all();
        $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->get();


        return view('reportes.reporte-admin-diario', compact(
            'procedencias', 'fecha_ini', 'fecha_fin',
            'analisis', 'year', 'year_old',
            'procedenciaId', 'tipoAnalisis', 'sTipoAnalisis', 'day_last'
        ));
    }

    public function reporteAdminDesechos()
    {
        $rango = 10;
        $tipo_analisis = [];
//        $fecha_ini = Carbon::now()->subDays(7+$rango);
        $fecha_ini = Carbon::now()->subDays($rango);
        $fecha_fin = Carbon::now();

        $analisis = Analisis::whereBetween('fecha_entrega', [$fecha_ini->format('Y-m-d'), $fecha_fin->format('Y-m-d')])
            ->where('imprimir_firma','=','1')
//            ->where('tipo_analisis','like','%'.$tipo_analisis.'%')
            ->get();


        return view('reportes.reporte-admin-desechar', compact(
            'fecha_ini', 'fecha_fin',
            'analisis', 'rango', 'tipo_analisis'
        ));
    }

    public function reporteAdminDesechosPost(Request $request)
    {
        $validatedDesechos = $request->validate([
            'tipo_analisis' => 'required',
        ]);

        $rango = $request->post('rango', 10);
        $tipo_analisis = $request->post('tipo_analisis', []);
//        var_dump($tipo_analisis);
//        die();
        $fecha_ini = Carbon::now()->subDays($rango);
        $fecha_fin = Carbon::now();

        $analisis = Analisis::whereBetween('fecha_entrega', [$fecha_ini->format('Y-m-d'), $fecha_fin->format('Y-m-d')])
            ->where('imprimir_firma','=','1')
            ->whereIn('tipo_analisis',$tipo_analisis)
            ->get();


        return view('reportes.reporte-admin-desechar', compact(
            'fecha_ini', 'fecha_fin',
            'analisis', 'rango', 'tipo_analisis'
        ));
    }

    public function reporteAdminSinterminar()
    {
        $rango = 10;
        $tipo_analisis = '';
        $fecha_ini = Carbon::now()->subDays($rango);
        $fecha_fin = Carbon::now();

        $analisis = Analisis::whereBetween('fecha', [$fecha_ini->format('Y-m-d'), $fecha_fin->format('Y-m-d')])
            ->whereNull('fecha_entrega')
            ->where('imprimir_firma', '=', '0')
            ->where('tipo_analisis', 'like', '%'.$tipo_analisis.'%')
            ->get();

        return view('reportes.reporte-admin-sinfirmar', compact(
            'fecha_ini', 'fecha_fin',
            'analisis', 'rango', 'tipo_analisis'
        ));
    }

    public function reporteAdminSinterminarPost(Request $request)
    {
        $rango = $request->post('rango', 10);
        $tipo_analisis = $request->post('tipo_analisis','');
        $fecha_ini = Carbon::now()->subDays($rango);
        $fecha_fin = Carbon::now();

        $analisis = Analisis::whereBetween('fecha', [$fecha_ini->format('Y-m-d'), $fecha_fin->format('Y-m-d')])
            ->whereNull('fecha_entrega')
            ->where('imprimir_firma', '=', '0')
            ->where('tipo_analisis', 'like', '%'.$tipo_analisis.'%')
            ->get();

        return view('reportes.reporte-admin-sinfirmar', compact(
            'fecha_ini', 'fecha_fin',
            'analisis', 'rango', 'tipo_analisis'
        ));
    }

    public function reportePost(Request $request)
    {
        $fecha = $request->post('fecha');
        $procedenciaId = $request->post('procedencia');

        $procedencias = Institucion::all();

        if($procedenciaId == 0){
            $analisis = Analisis::where('tipo_pago_acuenta', '=', Analisis::TIPO_PAGO_ACUENTA[0])->where('fecha', $fecha)->where('acuenta', '>', 0 )->get();
            $analisisEfec = Analisis::where('tipo_pago_efectuado', '=', Analisis::TIPO_PAGO_EFECTUADO[0])->where('fecha_pago_efectuado', $fecha)->get();
        } else {
            $analisis = Analisis::where('tipo_pago_acuenta', '=', Analisis::TIPO_PAGO_ACUENTA[0])->where('fecha', $fecha)->where('procedencia', $procedenciaId)->where('acuenta', '>', 0 )->get();
            $analisisEfec = Analisis::where('tipo_pago_efectuado', '=', Analisis::TIPO_PAGO_EFECTUADO[0])->where('fecha_pago_efectuado', $fecha)->where('procedencia', $procedenciaId)->get();
        }
        $totalAcuenta = 0;
        $totalEfec = 0;
        foreach ($analisis as $ana){
            $totalAcuenta += $ana->acuenta;
        }
        foreach ($analisisEfec as $ana){
            $totalEfec += $ana->pago_efectuado;
        }
        return view('reportes.reporte1', compact(
            'procedencias',
            'analisis',
            'analisisEfec',
            'totalAcuenta',
            'totalEfec',
            'fecha',
            'procedenciaId'
        ));
    }

    public function reporteDiarioPost(StoreReporteDiarioPost $request)
    {
        $fecha_ini = $request->post('fecha_ini');
        $fecha_fin = $request->post('fecha_fin');
        $procedenciaId = $request->post('procedencia');
        $tipoId = $request->post('tipo_analisis');
        $doctor = $request->post('doctor_refiere', '');

        $procedencias = Institucion::all();
        $tipoAnalisis = Config::get('clinica.tipo_analisis_1');


        $analisis = Analisis::where('tipo_pago_acuenta', '=', Analisis::TIPO_PAGO_ACUENTA[0])->whereBetween('fecha', [$fecha_ini, $fecha_fin])->where('acuenta', '>', 0);
        $analisisPagos = Analisis::where('tipo_pago_efectuado', '=', Analisis::TIPO_PAGO_EFECTUADO[0])->whereBetween('fecha_pago_efectuado', [$fecha_ini, $fecha_fin]);
        if($procedenciaId != 0){
            $analisis = $analisis->where('procedencia', $procedenciaId);
            $analisisPagos = $analisisPagos->where('procedencia', $procedenciaId);
        }
        if(strcmp($tipoId, '0') != 0) {
            $analisis = $analisis->where('tipo_analisis', $tipoId);
            $analisisPagos = $analisisPagos->where('tipo_analisis', $tipoId);
        }
        if(!empty($doctor)){
            $analisis = $analisis->where('doctor', $doctor);
            $analisisPagos = $analisisPagos->where('doctor', $doctor);
        }

        $analisis = $analisis->get();
        $analisisPagos = $analisisPagos->get();

        $gastos = Gasto::whereBetween('fecha', [$fecha_ini, $fecha_fin])->orderBy('fecha')->get();


        $totalPrecio = 0;
        $totalAcuenta = 0;
        $totalDebe = 0;
        foreach ($analisis as $ana){
            $totalPrecio += $ana->precio;
            $totalAcuenta += $ana->acuenta;
            $totalDebe += ($ana->precio - $ana->acuenta);
        }

        $totalPrecioPago = 0;
        $totalAcuentaPago = 0;
        $totalDebePago = 0;
        foreach ($analisisPagos as $ana){
            $totalPrecioPago += $ana->precio;
            $totalAcuentaPago += $ana->acuenta;
            $totalDebePago += ($ana->precio - $ana->acuenta);
        }

        $totalGastos = 0;
        foreach ($gastos as $gasto){
            $totalGastos += $gasto->gasto;
        }

        return view('reportes.reporte-diario', compact(
            'procedencias', 'tipoId',
            'analisis', 'totalDebe', 'doctor',
            'totalPrecio', 'totalAcuenta',
            'fecha_ini', 'fecha_fin', 'tipoAnalisis',
            'procedenciaId', 'gastos', 'totalGastos',
            'analisisPagos', 'totalPrecioPago', 'totalAcuentaPago', 'totalDebePago'
        ));
    }

    public function reportePost2(StoreReporte2Post $request){
        $fechaIni = $request->post('fechaIni');
        $fechaFin = $request->post('fechaFin');

        $dIni = date_create($fechaIni);
        $dFin = date_create($fechaFin);

        $procedenciaId = $request->post('procedencia');
        $procedencias = Institucion::all();

        $dias =  intval(date_diff($dIni, $dFin)->format('%R%a'));

        $reporte_2 = $this->getResultReporte2($dIni, $dias, $procedenciaId);

        return view('reportes.reporte2', compact(
            'procedencias',
            'fechaIni', 'fechaFin',
            'procedenciaId', 'reporte_2'
        ));
    }

    public function reporteAdminDiarioPost(Request $request)
    {
        $fecha_ini = $request->post('fecha_ini');
        $fecha_fin = $request->post('fecha_fin');
        $procedenciaId = $request->post('procedencia', '');
        $doctor = $request->post('doctor_refiere', '');
        $sTipoAnalisis = $request->post('tipo_analisis', '');

        $tipoAnalisis = Config::get('clinica.tipo_analisis_1');

        $procedencias = Institucion::all();

        $analisisW = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin]);
        if($procedenciaId != 0){
            $analisisW = $analisisW->where('procedencia', $procedenciaId);
        }
        if(!empty($doctor)){
            $analisisW = $analisisW->where('doctor', $doctor);
        }
//            dd($sTipoAnalisis);
        if(!empty($sTipoAnalisis)){
            $analisisW = $analisisW->where('tipo_analisis', $sTipoAnalisis);
        }

        $analisis = $analisisW->get();

        return view('reportes.reporte-admin-diario', compact(
            'procedencias', 'fecha_ini', 'fecha_fin',
            'analisis', 'tipoAnalisis', 'sTipoAnalisis',
            'procedenciaId', 'doctor'
        ));
    }

    private function getResultReporte2($fecha, $dias, $procedenciaId){
        $rows = array();
        for ($i=0; $i <= $dias; $i++){
            $fechaIngrementado = new \DateTime($fecha->format('Y-m-d'));
            $fechaIngrementado->modify('+'.$i.' day');

//            echo "ee: ".$fechaIngrementado->format('Y-m-d');
            if($procedenciaId == 0) {
                $resultados = DB::table('analisis')
                    ->select(
                        'tipo_analisis',
                        DB::raw('count(*) as contador'),
                        DB::raw('sum(precio) as t_precio'),
                        DB::raw('sum(acuenta) as t_acuenta'),
                        DB::raw('sum(pago_efectuado) as t_pago_efectuado'))
                    ->groupBy('tipo_analisis')
                    ->where('fecha', $fechaIngrementado)
                    ->get();
            } else {
                $resultados = DB::table('analisis')
                    ->select(
                        'tipo_analisis',
                        DB::raw('count(*) as contador'),
                        DB::raw('sum(precio) as t_precio'),
                        DB::raw('sum(acuenta) as t_acuenta'),
                        DB::raw('sum(pago_efectuado) as t_pago_efectuado'))
                    ->groupBy('tipo_analisis')
                    ->where('fecha', $fechaIngrementado)
                    ->where('procedencia', $procedenciaId)
                    ->get();
            }
            $t_precio = 0;
            $t_acuenta = 0;
            $t_pago_efectuado = 0;
            $reporte2 = new Reporte2();
            foreach ($resultados as $resultado){
                switch ($resultado->tipo_analisis){
                    case Analisis::BIOPSIA:
                        $reporte2->setBiopsiaTotal($resultado->contador);
                        break;
                    case Analisis::CITOLOGIA:
                        $reporte2->setCitologiaTotal($resultado->contador);
                        break;
                    case Analisis::INMUNOHISTOQUIMICA:
                        $reporte2->setInmunoTotal($resultado->contador);
                        break;
                    case Analisis::BETHESDA:
                        $reporte2->setBethesdaTotal($resultado->contador);
                        break;
                    case Analisis::HISTOPATOLOGICO:
                        $reporte2->setHistopatologiaTotal($resultado->contador);
                        break;
                }
                $t_precio += $resultado->t_precio;
                $t_acuenta += $resultado->t_acuenta;
                $t_pago_efectuado += $resultado->t_pago_efectuado;
            }
            $reporte2->setIngreso($t_precio);
            $reporte2->setAcuenta($t_acuenta);
            $reporte2->setPagoEfectuado($t_pago_efectuado);
            $reporte2->setFecha($fechaIngrementado);

            if($reporte2->getBiopsiaTotal() > 0 ||
                $reporte2->getCitologiaTotal() > 0 ||
                $reporte2->getInmunoTotal() > 0 ||
                $reporte2->getBethesdaTotal() > 0 ||
                $reporte2->getHistoTotal() > 0
            )
                array_push($rows, $reporte2);
        }
        return $rows;
    }

    function excelDiario($fechaIni, $fechaFin, $procedenciaId, $tipo, $doctor=''){
        $analisis = Analisis::where('tipo_pago_acuenta', '=', Analisis::TIPO_PAGO_ACUENTA[0])->whereBetween('fecha', [$fechaIni, $fechaFin])->where('acuenta', '>', 0);
        $analisisPagos = Analisis::where('tipo_pago_efectuado', '=', Analisis::TIPO_PAGO_EFECTUADO[0])->whereBetween('fecha_pago_efectuado', [$fechaIni, $fechaFin]);
        if($procedenciaId != 0){
            $analisis = $analisis->where('procedencia', $procedenciaId);
            $analisisPagos = $analisisPagos->where('procedencia', $procedenciaId);
        }
        if(strcmp($tipo, '0') != 0) {
            $analisis = $analisis->where('tipo_analisis', $tipo);
            $analisisPagos = $analisisPagos->where('tipo_analisis', $tipo);
        }
        if(!empty($doctor)){
            $analisis = $analisis->where('doctor', $doctor);
            $analisisPagos = $analisisPagos->where('doctor', $doctor);
        }

        $analisis = $analisis->get();
        $analisisPagos = $analisisPagos->get();

        $gastos = Gasto::whereBetween('fecha', [$fechaIni, $fechaFin])->orderBy('fecha')->get();


        $totalPrecio = 0;
        $totalAcuenta = 0;
        $totalDebe = 0;
        foreach ($analisis as $ana){
            $totalPrecio += $ana->precio;
            $totalAcuenta += $ana->acuenta;
            $totalDebe += ($ana->precio - $ana->acuenta);
        }

        $totalPrecioPago = 0;
        $totalAcuentaPago = 0;
        $totalDebePago = 0;
        foreach ($analisisPagos as $ana){
            $totalPrecioPago += $ana->precio;
            $totalAcuentaPago += $ana->acuenta;
            $totalDebePago += ($ana->precio - $ana->acuenta);
        }

        $totalGastos = 0;
        foreach ($gastos as $gasto){
            $totalGastos += $gasto->gasto;
        }
        return Excel::download(
            new ReporteDiarioExport(
                $analisis, $gastos, $totalPrecio, $totalAcuenta, $totalDebe,
                $totalGastos, $analisisPagos, $totalPrecioPago, $totalAcuentaPago, $totalDebePago), 'reportediario'.date('Ymd').'.xlsx');
    }

    function excelAdminDiario($fechaIni, $fechaFin, $procedenciaId){
        $dIni = date_create($fechaIni);
        $dFin = date_create($fechaFin);

        $dias =  intval(date_diff($dIni, $dFin)->format('%R%a'));

        $reporte_2 = $this->getResultReporte2($dIni, $dias, $procedenciaId);
//        $reporte_2 = array();

        $procedencia = "Todos";
        if($procedenciaId != 0){
            $procedenciaModel = Institucion::find($procedenciaId);
            $procedencia = $procedenciaModel->nombre;
        }

        return Excel::download(
            new ReporteAdminExport(
                $reporte_2, $procedencia), 'reporteadmin'.date('Ymd').'.xlsx');
    }

    function excelFacturacion($fechaIni, $fechaFin, $procedencia, $doctor='', $tipoAnalisis='', Request $request){
        $f_pago = $request->get('f_pago', 'fecha');
        $procedencias = Institucion::all();

        $analisisW = Analisis::where(
            function($query){
                $query->where ('tipo_pago_acuenta', 'like', Analisis::TIPO_PAGO_ACUENTA[1]);
                $query->orWhere ('tipo_pago_efectuado', 'like', Analisis::TIPO_PAGO_EFECTUADO[1]);
            }
        )
            ->whereBetween($f_pago, [$fechaIni, $fechaFin]);
//        dd($analisisW->get());
        if($procedencia != 0){
            $analisisW = $analisisW->where('procedencia', $procedencia);

        }

        $analisis = $analisisW->get();
        $procedenciaName = "Todos";
        if($procedencia != 0){
            $procedenciaName = Institucion::find($procedencia)->nombre;
        }

        return Excel::download(
            new ReporteFacturacionExport(
                $analisis, $fechaIni, $fechaFin, $procedenciaName), 'reporte-facturacion-'.date('Ymd').'.xlsx');
    }

    function excelAdmin($fechaIni, $fechaFin, $procedencia, $doctor='', $tipoAnalisis='', Request $request){
        $f_pago = $request->get('f_pago', 'fecha');
        $procedencias = Institucion::all();

        $analisisW = Analisis::whereBetween($f_pago, [$fechaIni, $fechaFin]);
//        dd($analisisW->get());
        if($procedencia != 0){
            $analisisW = $analisisW->where('procedencia', $procedencia);

        }
        if(!empty($doctor) && strcmp($doctor, 'ALL') != 0){
            $analisisW = $analisisW->where('doctor', $doctor);
        }
        if(!empty($tipoAnalisis)){
            $analisisW = $analisisW->where('tipo_analisis', $tipoAnalisis);
        }

        $analisis = $analisisW->get();
        $procedenciaName = "Todos";
        if($procedencia != 0){
            $procedenciaName = Institucion::find($procedencia)->nombre;
        }

        return Excel::download(
            new ReporteAdminDiaExport(
                $analisis, $fechaIni, $fechaFin, $procedenciaName), 'reporteadmindia'.date('Ymd').'.xlsx');
    }

    public function reporteCerrados()
    {
        $date = new \DateTime();
        $year = intval($date->format('Y'));
        $mes = $date->format('m');
        $day_last = $date->format('t');
        $procedenciaId = 0;

        $fecha_ini = $year.'-'.$mes.'-01';
        $fecha_fin = $year.'-'.$mes.'-'.$day_last;

        $year_old = intval(date_create(DB::table('analisis')->min('fecha'))->format('Y'));

        $procedencias = Institucion::all();
        $analisis = Analisis::whereBetween('fecha_entrega', [$fecha_ini, $fecha_fin])->get();


        return view('reportes.reporte-cerrados', compact(
            'procedencias', 'fecha_ini', 'fecha_fin',
            'analisis', 'procedenciaId'
        ));
    }

    public function reporteCerradosPost(Request $request)
    {
        $fecha_ini = $request->post('fecha_ini');
        $fecha_fin = $request->post('fecha_fin');
        $procedenciaId = $request->post('procedencia');
//        $entregado = $request->post('entregados');
//        $cerrados = $request->post('cerrados');
        $procedencias = Institucion::all();

//        $addQuery = "";
//        if(isset($entregado)){
//            $addQuery = "AND fecha_entrega is not null ";
//        }
//        $addCerrados = '';
//        if(isset($cerrados)){
//            $addCerrados = 'AND fecha_cierre is not null ';
//        }
        $addQuery = '';
        if($procedenciaId != 0){
            $addQuery = 'AND procedencia = '.$procedenciaId.' ';
        }

        $analisis = Analisis::query()->whereRaw('fecha_entrega between ? and ? '.$addQuery, [$fecha_ini, $fecha_fin])->get();

        return view('reportes.reporte-cerrados', compact(
            'procedencias', 'fecha_ini', 'fecha_fin',
            'analisis', 'procedenciaId'
        ));
    }

    function excelAdminDesechos($rango, $tipo_analisis=''){
        $fecha_ini = Carbon::now()->subDays($rango);
        $fecha_fin = Carbon::now();


        if(strcmp($tipo_analisis, '') == 0){
            $analisis = Analisis::whereBetween('fecha_entrega', [$fecha_ini->format('Y-m-d'), $fecha_fin->format('Y-m-d')])
                ->where('imprimir_firma','=','1')
                ->get();
        } else {
            $analisis = Analisis::whereBetween('fecha_entrega', [$fecha_ini->format('Y-m-d'), $fecha_fin->format('Y-m-d')])
                ->where('imprimir_firma','=','1')
                //->where('tipo_analisis','like','%'.$tipo_analisis.'%')
                ->whereIn('tipo_analisis',explode("|", $tipo_analisis))
                ->get();
        }


        return Excel::download(
            new ReporteAdminDesechoExport(
                $analisis, $rango, $fecha_ini, $fecha_fin), 'reporteadmindesecho'.date('Ymd').'.xlsx');
    }

    function excelAdminSinterminar($rango, $tipo_analisis=''){
        $fecha_ini = Carbon::now()->subDays($rango);
        $fecha_fin = Carbon::now();

        $analisis = Analisis::whereBetween('fecha', [$fecha_ini->format('Y-m-d'), $fecha_fin->format('Y-m-d')])
            ->whereNull('fecha_entrega')
            ->where('imprimir_firma', '=', '0')
            ->where('tipo_analisis', 'like', '%'.$tipo_analisis.'%')
            ->get();

        return Excel::download(
            new ReporteAdminDesechoExport(
                $analisis, $rango, $fecha_ini, $fecha_fin), 'reporteadminsinterminar'.date('Ymd').'.xlsx');
    }

    public function reporteFacturacion()
    {
        $date = new \DateTime();
        $year = intval($date->format('Y'));
        $mes = $date->format('m');
        $day_last = $date->format('t');
        $procedenciaId = 0;

        $fecha_ini = $year.'-'.$mes.'-01';
        $fecha_fin = $year.'-'.$mes.'-'.$day_last;

//        dd($fecha_ini . ' || ' . $fecha_fin);
        $procedencias = Institucion::all();
        $analisis = Analisis::where (function($query){
            $query->where ('tipo_pago_acuenta', 'like', Analisis::TIPO_PAGO_ACUENTA[1]);
            $query->orWhere ('tipo_pago_efectuado', 'like', Analisis::TIPO_PAGO_EFECTUADO[1]); })
            ->whereBetween('fecha', [$fecha_ini, $fecha_fin])->orderBy('fecha', 'desc')
            ->get();


        return view('reportes.reporte-facturacion', compact(
            'procedencias', 'fecha_ini', 'fecha_fin',
            'analisis', 'procedenciaId'
        ));
    }

    public function reporteFacturacionPost(Request $request)
    {
        $fecha_ini = $request->post('fecha_ini');
        $fecha_fin = $request->post('fecha_fin');
        $procedenciaId = $request->post('procedencia');
        $fecha_pago = $request->post('f_pago', 'fecha');

        $facturados = $request->post('facturados', 0);

        $procedencias = Institucion::all();

        $query = Analisis::query();
        if($procedenciaId == 0){
//            $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->where('facturado', $facturados)->orderBy('fecha', 'desc')->get();
            $query = $query
                ->where(
                    function($query){
                        $query->where ('tipo_pago_acuenta', 'like', Analisis::TIPO_PAGO_ACUENTA[1]);
                        $query->orWhere ('tipo_pago_efectuado', 'like', Analisis::TIPO_PAGO_EFECTUADO[1]);
                    }
                )->whereBetween($fecha_pago, [$fecha_ini, $fecha_fin])->where('facturado', $facturados);
            $analisis = $query->orderBy($fecha_pago, 'desc')->get();
        } else {
            $analisis = Analisis::where(
                function($query){
                    $query->where ('tipo_pago_acuenta', 'like', Analisis::TIPO_PAGO_ACUENTA[1]);
                    $query->orWhere ('tipo_pago_efectuado', 'like', Analisis::TIPO_PAGO_EFECTUADO[1]);
                }
            )
                ->whereBetween($fecha_pago, [$fecha_ini, $fecha_fin])
                ->where('facturado', $facturados)->where('procedencia', $procedenciaId)
                ->orderBy($fecha_pago, 'desc')->get();
        }


        return view('reportes.reporte-facturacion', compact(
            'procedencias', 'fecha_ini', 'fecha_fin',
            'analisis', 'facturados',
            'procedenciaId', 'fecha_pago'
        ));
    }

    public function reporteDiagnostico()
    {
        $date = new \DateTime();
        $year = intval($date->format('Y'));
        $mes = $date->format('m');
        $day_last = $date->format('t');

        $fecha_ini = $year.'-'.$mes.'-01';
        $fecha_fin = $year.'-'.$mes.'-'.$day_last;

        $biopsias = Biopsia::whereHas('analisis', function($q) use($fecha_ini, $fecha_fin){
            $q->whereBetween('fecha', [$fecha_ini, $fecha_fin]);
            $q->orderBy('analisis.fecha', 'desc');
        })->orderBy('id', 'desc')->get();

        $histoquimicas = Histoquimica::whereHas('analisis', function($q) use($fecha_ini, $fecha_fin){
            $q->whereBetween('fecha', [$fecha_ini, $fecha_fin]);
            $q->orderBy('analisis.fecha', 'desc');
        })->orderBy('id', 'desc')->get();

        $liquidos = Liquido::whereHas('analisis', function($q) use($fecha_ini, $fecha_fin){
            $q->whereBetween('fecha', [$fecha_ini, $fecha_fin]);
            $q->orderBy('analisis.fecha', 'desc');
        })->orderBy('id', 'desc')->get();

        $bethesdas = Bethesda::whereHas('analisis', function($q) use($fecha_ini, $fecha_fin){
            $q->whereBetween('fecha', [$fecha_ini, $fecha_fin]);
            $q->orderBy('analisis.fecha', 'desc');
        })->orderBy('id', 'desc')->get();

        $citologias = Resultado::whereHas('analisis', function($q) use($fecha_ini, $fecha_fin){
            $q->whereBetween('fecha', [$fecha_ini, $fecha_fin]);
            $q->orderBy('analisis.fecha', 'desc');
        })->orderBy('id', 'desc')->get();

        $diagnostico = '';
        return view('reportes.reporte-diagnostico', compact(
            'fecha_ini', 'fecha_fin',
            'biopsias', 'diagnostico', 'histoquimicas', 'liquidos',
            'bethesdas', 'citologias'
        ));
    }

    public function reporteDiagnosticoPost(Request $request)
    {
        $validateFecha = $request->validate([
            'fecha_ini' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_ini',
        ]);
        $diagnostico = $request->post('diagnostico');
        $fecha_ini = $request->post('fecha_ini');
        $fecha_fin = $request->post('fecha_fin');

        $biopsias = Biopsia::whereHas('analisis', function($q) use($fecha_ini, $fecha_fin){
            $q->whereBetween('fecha', [$fecha_ini, $fecha_fin]);
            $q->orderBy('analisis.fecha', 'desc');
        })->where('diagnostico', 'like', "%".$diagnostico."%")->orderBy('id', 'desc')->get();

        $histoquimicas = Histoquimica::whereHas('analisis', function($q) use($fecha_ini, $fecha_fin){
            $q->whereBetween('fecha', [$fecha_ini, $fecha_fin]);
            $q->orderBy('analisis.fecha', 'desc');
        })->where('interpretacion', 'like', "%".$diagnostico."%")->orderBy('id', 'desc')->get();

        $liquidos = Liquido::whereHas('analisis', function($q) use($fecha_ini, $fecha_fin){
            $q->whereBetween('fecha', [$fecha_ini, $fecha_fin]);
            $q->orderBy('analisis.fecha', 'desc');
        })->where('diagnostico', 'like', "%".$diagnostico."%")->orderBy('id', 'desc')->get();

        $bethesdas = Bethesda::whereHas('analisis', function($q) use($fecha_ini, $fecha_fin){
            $q->whereBetween('fecha', [$fecha_ini, $fecha_fin]);
            $q->orderBy('analisis.fecha', 'desc');
        })->where('interpretacion', 'like', "%".$diagnostico."%")->orderBy('id', 'desc')->get();

        $citologias = Resultado::whereHas('analisis', function($q) use($fecha_ini, $fecha_fin){
            $q->whereBetween('fecha', [$fecha_ini, $fecha_fin]);
            $q->orderBy('analisis.fecha', 'desc');
        })->whereHas('secciones', function($q) use($diagnostico){
            $q->where('seccion', 'like', 'EXTENDIDO COMPATIBLE CON LOS DIAGNOSTICOS')
                ->where('key', 'like', '%'.$diagnostico."%");
            $q->groupBy('id');
        })->orderBy('id', 'desc')->get();

        return view('reportes.reporte-diagnostico', compact(
            'fecha_ini', 'fecha_fin',
            'biopsias', 'diagnostico', 'histoquimicas', 'liquidos',
            'bethesdas', 'citologias'
        ));
    }

    function pdfDiario($fechaIni, $fechaFin, $procedenciaId, $tipo, $doctor=''){
        $analisis = Analisis::where('tipo_pago_acuenta', '=', Analisis::TIPO_PAGO_ACUENTA[0])->whereBetween('fecha', [$fechaIni, $fechaFin])->where('acuenta', '>', 0);
        $analisisPagos = Analisis::where('tipo_pago_efectuado', '=', Analisis::TIPO_PAGO_EFECTUADO[0])->whereBetween('fecha_pago_efectuado', [$fechaIni, $fechaFin]);
        if($procedenciaId != 0){
            $analisis = $analisis->where('procedencia', $procedenciaId);
            $analisisPagos = $analisisPagos->where('procedencia', $procedenciaId);
        }
        if(strcmp($tipo, '0') != 0) {
            $analisis = $analisis->where('tipo_analisis', $tipo);
            $analisisPagos = $analisisPagos->where('tipo_analisis', $tipo);
        }
        if(!empty($doctor)){
            $analisis = $analisis->where('doctor', $doctor);
            $analisisPagos = $analisisPagos->where('doctor', $doctor);
        }

        $analisis = $analisis->get();
        $analisisPagos = $analisisPagos->get();

        $gastos = Gasto::whereBetween('fecha', [$fechaIni, $fechaFin])->orderBy('fecha')->get();


        $totalPrecio = 0;
        $totalAcuenta = 0;
        $totalDebe = 0;
        foreach ($analisis as $ana){
            $totalPrecio += $ana->precio;
            $totalAcuenta += $ana->acuenta;
            $totalDebe += ($ana->precio - $ana->acuenta);
        }

        $totalPrecioPago = 0;
        $totalAcuentaPago = 0;
        $totalDebePago = 0;
        foreach ($analisisPagos as $ana){
            $totalPrecioPago += $ana->precio;
            $totalAcuentaPago += $ana->acuenta;
            $totalDebePago += ($ana->precio - $ana->acuenta);
        }

        $totalGastos = 0;
        foreach ($gastos as $gasto){
            $totalGastos += $gasto->gasto;
        }
//        return Excel::download(
//            new ReporteDiarioExport(
//                $analisis, $gastos, $totalPrecio, $totalAcuenta, $totalDebe,
//                $totalGastos, $analisisPago, $totalPrecioPago, $totalAcuentaPago, $totalDebePago), 'reportediario'.date('Ymd').'.xlsx');

        $pdf = PDF::loadView('export-excel.reporte-diario-excel', compact(
            'analisis', 'totalPrecio', 'totalDebe', 'totalAcuenta', 'analisisPagos',
            'totalPrecioPago', 'totalAcuentaPago', 'totalDebePago', 'gastos', 'totalGastos'));

        $fileNombre = 'reporte-diario'.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }

    public function reporteAdminDiarioConvenio()
    {
        $date = new \DateTime();
        $year = intval($date->format('Y'));
        $mes = $date->format('m');
        $day_last = $date->format('t');

        $fecha_ini = $year.'-'.$mes.'-01';
        $fecha_fin = $year.'-'.$mes.'-'.$day_last;

        $year_old = intval(date_create(DB::table('analisis')->min('fecha'))->format('Y'));

        $convenios = Convenio::with(['analisis', 'analisis.institucion'])->whereHas('analisis', function($query) use ($fecha_ini, $fecha_fin){
            $query->whereBetween('fecha', [$fecha_ini, $fecha_fin]);
        })->get();

        return view('reportes.reporte-admin-diario-convenio', compact(
            'fecha_ini', 'fecha_fin',
            'convenios', 'year', 'year_old',
            'day_last'
        ));
    }

    public function reporteAdminDiarioConvenioPost(Request $request)
    {
        $fecha_ini = $request->post('fecha_ini');
        $fecha_fin = $request->post('fecha_fin');

        $convenios = Convenio::with(['analisis', 'analisis.institucion'])->whereHas('analisis', function($query) use ($fecha_ini, $fecha_fin){
            $query->whereBetween('fecha', [$fecha_ini, $fecha_fin]);
        })->get();

        return view('reportes.reporte-admin-diario-convenio', compact(
            'fecha_ini', 'fecha_fin',
            'convenios'
        ));
    }

    function excelAdminConvenio($fechaIni, $fechaFin){

        $convenios = Convenio::with(['analisis', 'analisis.institucion'])->whereHas('analisis', function($query) use ($fechaIni, $fechaFin){
            $query->whereBetween('fecha', [$fechaIni, $fechaFin]);
        })->get();

        return Excel::download(
            new ReporteAdminDiaConvenioExport(
                $convenios, $fechaIni, $fechaFin), 'reporteadminconveniodia'.date('Ymd').'.xlsx');
    }
}
