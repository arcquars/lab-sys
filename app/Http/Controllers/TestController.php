<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\AnalysisTest;
use App\AnalysisTestGroup;
use App\AnalysisTestResult;
use App\Helpers\ClinicaHelper;
use App\ImpresionControl;
use App\Liquido;
use App\Setting;
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
        $metodo = Setting::get('metodo_analisis', '1');
        $orderGroupTest = ClinicaHelper::getTestGroupResults($analysisId);

        return view('test.crear', compact('analysis', 'orderGroupTest', 'metodo'));
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

        if ($request->hasFile('adjunto')) {
            $file = $request->file('adjunto');

            // 1. Validar el archivo (Opcional pero recomendado)
            // $request->validate(['adjunto' => 'image|mimes:jpeg,png,jpg,gif,pdf|max:2048']);

            // 2. Generar un nombre único para el archivo
            $fileName = 'test_' . $analisisId . '_' . time() . '.' . $file->getClientOriginalExtension();

            // 3. Definir la ruta de destino (public/uploads/test/)
            $destinationPath = public_path('uploads/test/');

            // 4. Mover el archivo al servidor
            $file->move($destinationPath, $fileName);

            // 5. Guardar la referencia en el modelo Analisis
            // Nota: Asegúrate de que la columna 'adjunto' exista en tu tabla 'analisis'
            $analisis->adjunto = $fileName;
        }


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

        $watermark = [
            'path'   => public_path(env('PDF_WATERMARCK')),
            'alpha'  => env('PDF_WATERMARCK_ALFA', 0.1),
        ];

        $pdf = PDF::loadView($view, compact(
            'analisis', 'pathQr', 'orderGroupTest', 'sin', 'watermark'));
            
        $pdf->showWatermarkImage = true;

        // $stylesheet = asset('css/reporte-pdf.css'); // external css
        // $pdf->mpdf->SetFooter('|Página {PAGENO} de {nbpg}|');
        // $pdf->mpdf->WriteHTML($stylesheet,1);

        $fileNombre = $analisis->person->nombres . '-'. $analisis->person->apellidos . '-' . $analisis->codigo . '-' . date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }

    public function deleteAdjunto(Request $request) {
        $analisis = Analisis::find($request->id);
        if($analisis && $analisis->adjunto) {
            // Borrar archivo físico
            $path = public_path('uploads/test/' . $analisis->adjunto);
            if(file_exists($path)) { @unlink($path); }

            // Limpiar campo en BD
            $analisis->adjunto = null;
            $analisis->save();

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'No se encontró el archivo.']);
    }
}
