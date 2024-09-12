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
        $analisisId = $request->input('analisis_id');
        foreach ($testResultValues as $id => $value){
            if(isset($value)){
                $analysisTestResult = AnalysisTestResult::where('a_test_id', $id)->where('analysis_id', $analisisId)->first();
                $analysisTestResult->result = $value;
                $analysisTestResult->save();
            }
        }
        return redirect('/test/view/'.$request->input('analisis_id'));
    }

    public function viewResultado($analisisId){
        $analisis = Analisis::find($analisisId);
        $orderGroupTest = ClinicaHelper::getTestGroupResults($analisisId);

        return view('test.view', compact(
            'analisis', 'orderGroupTest'));
    }

    function reporte($analisisId, $sin=0) {
        $d = new DNS2D();
        $d->setStorPath(public_path()."/generateqr/");
        $pathQr = $d->getBarcodePNGPath(route('analisis.reporte.pdf.public', ['analisisId' => base64_encode($analisisId)]), "QRCODE");
        ImpresionControl::grabarImpresion(Auth::user()->id, $analisisId);

        $analisis = Analisis::find($analisisId);

        $orderGroupTest = ClinicaHelper::getTestGroupResults($analisisId);

        $pdf = PDF::loadView('test.reporte', compact(
            'analisis', 'pathQr', 'orderGroupTest', 'sin'));

        $stylesheet = asset('css/reporte-pdf.css'); // external css
//        $pdf->mpdf->SetWatermarkImage(public_path('img/test-lab.png'));
//        $pdf->mpdf->showWatermarkImage = true;
        $pdf->mpdf->WriteHTML($stylesheet,1);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }
}
