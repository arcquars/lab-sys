<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\ClinicaClass\Reporte2;
use App\Exports\ReporteAdminDiaExport;
use App\Exports\ReporteAdminExport;
use App\Exports\ReporteDiarioExport;
use App\Gasto;
use App\Http\Requests\StoreReporte2Post;
use App\Http\Requests\StoreReporteDiarioPost;
use App\Institucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Excel;

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
        $analisis = Analisis::where('fecha', $fecha)->get();
        $analisisEfec = Analisis::where('fecha_pago_efectuado', $fecha)->get();
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

        $tipoAnalisis = Config::get('clinica.tipo_analisis');

        $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->get();
        $gastos = Gasto::whereBetween('fecha', [$fecha_ini, $fecha_fin])->get();
        $totalPrecio = 0;
        $totalAcuenta = 0;
        $totalDebe = 0;
        foreach ($analisis as $ana){
            $totalPrecio += $ana->precio;
            $totalAcuenta += $ana->acuenta;
            $totalDebe += ($ana->precio - $ana->acuenta);
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
            'procedenciaId', 'totalGastos', 'tipoAnalisis'
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
            'analisis',
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

        $fecha_ini = $year.'-'.$mes.'-01';
        $fecha_fin = $year.'-'.$mes.'-'.$day_last;

        $year_old = intval(date_create(DB::table('analisis')->min('fecha'))->format('Y'));

        $procedencias = Institucion::all();
        $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->get();


        return view('reportes.reporte-admin-diario', compact(
            'procedencias', 'fecha_ini', 'fecha_fin',
            'analisis', 'meses', 'year', 'year_old',
            'procedenciaId', 'day_last'
        ));
    }

    public function reportePost(Request $request)
    {
        $fecha = $request->post('fecha');
        $procedenciaId = $request->post('procedencia');

        $procedencias = Institucion::all();

        if($procedenciaId == 0){
            $analisis = Analisis::where('fecha', $fecha)->get();
            $analisisEfec = Analisis::where('fecha_pago_efectuado', $fecha)->get();
        } else {
            $analisis = Analisis::where('fecha', $fecha)->where('procedencia', $procedenciaId)->get();
            $analisisEfec = Analisis::where('fecha_pago_efectuado', $fecha)->where('procedencia', $procedenciaId)->get();
        }
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

    public function reporteDiarioPost(StoreReporteDiarioPost $request)
    {
        $fecha_ini = $request->post('fecha_ini');
        $fecha_fin = $request->post('fecha_fin');
        $procedenciaId = $request->post('procedencia');
        $tipoId = $request->post('tipo_analisis');

        $procedencias = Institucion::all();
        $tipoAnalisis = Config::get('clinica.tipo_analisis');

        if($procedenciaId == 0){
            if(strcmp($tipoId, '0') == 0)
                $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->get();
            else{
                $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->where('tipo_analisis', $tipoId)->get();
            }
        } else {
            if(strcmp($tipoId, '0') == 0)
                $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->where('procedencia', $procedenciaId)->get();
            else
                $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->where('procedencia', $procedenciaId)->where('tipo_analisis', $tipoId)->get();
        }
        $gastos = Gasto::whereBetween('fecha', [$fecha_ini, $fecha_fin])->orderBy('fecha')->get();


        $totalPrecio = 0;
        $totalAcuenta = 0;
        $totalDebe = 0;
        foreach ($analisis as $ana){
            $totalPrecio += $ana->precio;
            $totalAcuenta += $ana->acuenta;
            $totalDebe += ($ana->precio - $ana->acuenta);
        }

        $totalGastos = 0;
        foreach ($gastos as $gasto){
            $totalGastos += $gasto->gasto;
        }

        return view('reportes.reporte-diario', compact(
            'procedencias', 'tipoId',
            'analisis', 'totalDebe',
            'totalPrecio', 'totalAcuenta',
            'fecha_ini', 'fecha_fin', 'tipoAnalisis',
            'procedenciaId', 'gastos', 'totalGastos'
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
        $procedenciaId = $request->post('procedencia');

        $procedencias = Institucion::all();

        if($procedenciaId == 0){
            $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->get();
        } else {
            $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->where('procedencia', $procedenciaId)->get();
        }


        return view('reportes.reporte-admin-diario', compact(
            'procedencias', 'fecha_ini', 'fecha_fin',
            'analisis', 'meses', 'year',
            'procedenciaId'
        ));
    }

    private function getResultReporte2($fecha, $dias, $procedenciaId){
        $rows = array();
        for ($i=0; $i < $dias; $i++){
            $fechaIngrementado = new \DateTime($fecha->format('Y-m-d'));
            $fechaIngrementado->modify('+'.$i.' day');

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
                $reporte2->getBethesdaTotal() > 0
            )
                array_push($rows, $reporte2);
        }
        return $rows;
    }

    function excelDiario($fechaIni, $fechaFin, $procedenciaId, $tipo){
        if($procedenciaId == 0){
            if(strcmp($tipo, '0') == 0)
                $analisis = Analisis::whereBetween('fecha', [$fechaIni, $fechaFin])->get();
            else{
                $analisis = Analisis::whereBetween('fecha', [$fechaIni, $fechaFin])->where('tipo_analisis', $tipo)->get();
            }
        } else {
            if(strcmp($tipo, '0') == 0)
                $analisis = Analisis::whereBetween('fecha', [$fechaIni, $fechaFin])->where('procedencia', $procedenciaId)->get();
            else
                $analisis = Analisis::whereBetween('fecha', [$fechaIni, $fechaFin])->where('procedencia', $procedenciaId)->where('tipo_analisis', $tipo)->get();
        }
        $gastos = Gasto::whereBetween('fecha', [$fechaIni, $fechaFin])->orderBy('fecha')->get();


        $totalPrecio = 0;
        $totalAcuenta = 0;
        $totalDebe = 0;
        foreach ($analisis as $ana){
            $totalPrecio += $ana->precio;
            $totalAcuenta += $ana->acuenta;
            $totalDebe += ($ana->precio - $ana->acuenta);
        }

        $totalGastos = 0;
        foreach ($gastos as $gasto){
            $totalGastos += $gasto->gasto;
        }
        return Excel::download(
            new ReporteDiarioExport(
                $analisis, $gastos, $totalPrecio, $totalAcuenta, $totalDebe, $totalGastos), 'reportediario'.date('Ymd').'.xlsx');
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

    function excelAdmin($fechaIni, $fechaFin, $procedencia){

        $procedencias = Institucion::all();

        if($procedencia == 0){
            $analisis = Analisis::whereBetween('fecha', [$fechaIni, $fechaFin])->get();
        } else {
            $analisis = Analisis::whereBetween('fecha', [$fechaIni, $fechaFin])->where('procedencia', $procedencia)->get();
        }

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
        $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->get();


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
        $entregado = $request->post('entregados');
        $cerrados = $request->post('cerrados');
        $procedencias = Institucion::all();

        $addQuery = "";
        if(isset($entregado)){
            $addQuery = "AND fecha_entrega is not null ";
        }
        $addCerrados = '';
        if(isset($cerrados)){
            $addCerrados = 'AND fecha_cierre is not null ';
        }
        $addProcedencia = '';
        if($procedenciaId != 0){
//            $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->where('fecha_entrega', $entregado)->get();
            $addProcedencia = 'AND procedencia = '.$procedenciaId.' ';
        }

        $analisis = Analisis::query()->whereRaw('fecha between ? and ? '.$addQuery.$addCerrados.$addProcedencia, [$fecha_ini, $fecha_fin])->get();

        return view('reportes.reporte-cerrados', compact(
            'procedencias', 'fecha_ini', 'fecha_fin',
            'analisis', 'procedenciaId', 'entregado', 'cerrados'
        ));
    }
}
