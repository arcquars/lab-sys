<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\ClinicaClass\Reporte2;
use App\Gasto;
use App\Http\Requests\StoreReporte2Post;
use App\Http\Requests\StoreReporteDiarioPost;
use App\Institucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

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

        $procedencias = Institucion::all();

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
            'analisis', 'totalDebe',
            'totalPrecio', 'totalAcuenta',
            'fecha_ini', 'fecha_fin', 'gastos',
            'procedenciaId', 'totalGastos'
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
        $year_select = intval($date->format('Y'));
        $mes = $date->format('m');
        $day_last = $date->format('t');
        $meses = Config::get('clinica.meses-id');
        $procedenciaId = 0;

        $fecha_ini = $year.'-'.$mes.'-01';
        $fecha_fin = $year.'-'.$mes.'-'.$day_last;

//        $dFin = date_create($fechaFin);
        $year_old = intval(date_create(DB::table('analisis')->min('fecha'))->format('Y'));

        $procedencias = Institucion::all();
        $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->get();


        return view('reportes.reporte-admin-diario', compact(
            'procedencias', 'fecha_ini', 'fecha_fin',
            'analisis', 'meses', 'year', 'year_old',
            'procedenciaId', 'day_last', 'mes', 'year_select'
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

        $procedencias = Institucion::all();

        if($procedenciaId == 0){
            $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->get();
        } else {
            $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->where('procedencia', $procedenciaId)->get();
        }

        $totalPrecio = 0;
        $totalAcuenta = 0;
        $totalDebe = 0;
        foreach ($analisis as $ana){
            $totalPrecio += $ana->precio;
            $totalAcuenta += $ana->acuenta;
            $totalDebe += ($ana->precio - $ana->acuenta);
        }

        return view('reportes.reporte-diario', compact(
            'procedencias',
            'analisis', 'totalDebe',
            'totalPrecio', 'totalAcuenta',
            'fecha_ini', 'fecha_fin',
            'procedenciaId'
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
        $year_select = intval($request->post('year'));

        $date = new \DateTime();
        $year = intval($date->format('Y'));

        $mes = $request->post('mes');

        $date_last = \DateTime::createFromFormat('Y-m-d', $year.'-'.$mes.'-01');
        $day_last = $date_last->format('t');

        $meses = Config::get('clinica.meses-id');
        $procedenciaId = $request->post('procedencia');

        $fecha_ini = $year_select.'-'.$mes.'-01';
        $fecha_fin = $year_select.'-'.$mes.'-'.$day_last;

        $year_old = intval(date_create(DB::table('analisis')->min('fecha'))->format('Y'));

        $procedencias = Institucion::all();

        if($procedenciaId == 0){
            $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->get();
        } else {
            $analisis = Analisis::whereBetween('fecha', [$fecha_ini, $fecha_fin])->where('procedencia', $procedenciaId)->get();
        }


        return view('reportes.reporte-admin-diario', compact(
            'procedencias', 'fecha_ini', 'fecha_fin',
            'analisis', 'meses', 'year', 'year_old',
            'procedenciaId', 'day_last', 'mes', 'year_select'
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
                }
                $t_precio += $resultado->t_precio;
                $t_acuenta += $resultado->t_acuenta;
                $t_pago_efectuado += $resultado->t_pago_efectuado;
            }
            $reporte2->setIngreso($t_precio);
            $reporte2->setAcuenta($t_acuenta);
            $reporte2->setPagoEfectuado($t_pago_efectuado);
            $reporte2->setFecha($fechaIngrementado);

            if($reporte2->getBiopsiaTotal() > 0 || $reporte2->getCitologiaTotal() > 0 || $reporte2->getInmunoTotal() > 0)
                array_push($rows, $reporte2);
        }
        return $rows;
    }
}
