<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\ClinicaClass\Reporte2;
use App\Http\Requests\StoreReporte2Post;
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
        $fecha = date('Y-m-d');
        $procedenciaId = 0;

        $procedencias = Institucion::all();
        $analisis = Analisis::where('fecha', $fecha)->get();
        $total = 0;
        foreach ($analisis as $ana){
            $total += $ana->precio;
        }

        return view('reportes.reporte-diario', compact(
            'procedencias',
            'analisis',
            'total',
            'fecha',
            'procedenciaId'
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

    public function reporteDiarioPost(Request $request)
    {
        $fecha = $request->post('fecha');
        $procedenciaId = $request->post('procedencia');

        $procedencias = Institucion::all();

        if($procedenciaId == 0){
            $analisis = Analisis::where('fecha', $fecha)->get();
        } else {
            $analisis = Analisis::where('fecha', $fecha)->where('procedencia', $procedenciaId)->get();
        }
        $total = 0;
        foreach ($analisis as $ana){
            $total += $ana->precio;
        }
        return view('reportes.reporte-diario', compact(
            'procedencias',
            'analisis',
            'total',
            'fecha',
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

        $dias =  intval(date_diff($dIni, $dFin)->format('%d'));
        $reporte_2 = $this->getResultReporte2($dIni, $dias, $procedenciaId);

        return view('reportes.reporte2', compact(
            'procedencias',
            'fechaIni', 'fechaFin',
            'procedenciaId', 'reporte_2'
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

            array_push($rows, $reporte2);
        }
        return $rows;
    }
}
