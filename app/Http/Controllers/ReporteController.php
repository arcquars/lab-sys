<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\Institucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

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
}
