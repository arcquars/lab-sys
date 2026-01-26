<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\AnalysisTest;
use App\AnalysisTestGroup;
use App\AnalysisTestResult;
use App\Helpers\ClinicaHelper;
use App\ImpresionControl;
use App\Liquido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Milon\Barcode\DNS2D;
use PDF;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($analysisId)
    {
        $analysis = Analisis::find($analysisId);
        $orderGroupTest = ClinicaHelper::getTestGroupResults($analysisId);

        return view('test.crear', compact('analysis', 'orderGroupTest'));
    }

    public function store(Request $request){
        $testResultValues = $request->input('testResultValue');
        $testMetodos =$request->input('metodos');
        $analisisId = $request->input('analisis_id');
        foreach ($testResultValues as $id => $value){
            if(isset($value)){
                $analysisTestResult = AnalysisTestResult::where('a_test_id', $id)->where('analysis_id', $analisisId)->first();
                $analysisTestResult->result = $value;
                $analysisTestResult->save();
            }
        }
        foreach ($testMetodos as $id => $value){
            if(isset($value) && !empty($value)){
                $analysisTestResult = AnalysisTestResult::where('a_test_id', $id)->where('analysis_id', $analisisId)->first();
                $analysisTestResult->metodo = $value;
                $analysisTestResult->save();
            }
        }

        $observaciones = $request->input('observaciones', null);
        $analisis = Analisis::find($analisisId);
        $analisis->observaciones = $observaciones;
        $analisis->save();
        return redirect('/test/view/'.$request->input('analisis_id'));
    }

    public function viewResultado($analisisId){
        $analisis = Analisis::find($analisisId);
        $orderGroupTest = ClinicaHelper::getTestGroupResultsSorted($analisisId);

        return view('test.view', compact(
            'analisis', 'orderGroupTest'));
    }

    function reporte($analisisId, $sin=0) {
        $d = new DNS2D();
        $d->setStorPath(public_path()."/generateqr/");
        $pathQr = $d->getBarcodePNGPath(route('analisis.open.esultado.simple.pdf', ['analisisId' => base64_encode($analisisId)]), "QRCODE");

        ImpresionControl::grabarImpresion(Auth::user()->id, $analisisId);

        $analisis = Analisis::find($analisisId);

        $orderGroupTest = ClinicaHelper::getTestGroupResultsSorted($analisisId);

        $reportEnterprice = env('REPORT_ENTERPRICE', 'DEFAULT');
        $view = "";
        switch($reportEnterprice){
            case 'JUVENTUD':
                $view = "test.juve.reporte";
                break;
            case 'LABCI':
                $view = "test.labci.reporte";
                break;
            default:
                $view = "test.reporte";
                break;
        }

        $pdf = PDF::loadView($view, compact(
            'analisis', 'pathQr', 'orderGroupTest', 'sin'));

        $stylesheet = asset('css/reporte-pdf.css'); // external css
        // --- INICIO CONFIGURACIÓN MARCA DE AGUA ---
        
        // Ruta absoluta a la imagen
        $watermarkPath = public_path('img/labci/labciLa.png'); 

        // Parámetros SetWatermarkImage:
        // 1. Ruta de archivo
        // 2. Opacidad (Alpha): 0.1 a 1 (0.2 es un buen estándar)
        // 3. Tamaño: 'D' (Default), 'F' (Fit/Ajustar a pagina), 'P' (Resize proporcional)
        // 4. Posición: 'P' (Centrado en la página)
        
        $pdf->mpdf->SetWatermarkImage($watermarkPath, 0.07, array(100, 40), 'P');
        $pdf->mpdf->showWatermarkImage = true;

        // --- FIN CONFIGURACIÓN MARCA DE AGUA ---
        $pdf->mpdf->SetFooter('|Página {PAGENO} de {nbpg}|');
//        $pdf->mpdf->SetWatermarkImage(public_path('img/test-lab.png'));
//        $pdf->mpdf->showWatermarkImage = true;
        $pdf->mpdf->WriteHTML($stylesheet,1);
        $fileNombre = $analisis->person->nombres . '-'. $analisis->person->apellidos . '-' . $analisis->codigo . '-' . date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }
}
