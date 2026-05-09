<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\AnalysisTest;
use App\AnalysisTestGroup;
use App\AnalysisTestResult;
use App\EditarControl;
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
        $request->validate([
            'adjunto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // max:5120 significa 5MB en Kilobytes
        ]);
        $testResultValues = $request->input('testResultValue');
        $testMetodos =$request->input('metodos');
        $analisisId = $request->input('analisis_id');
        foreach ($testResultValues as $id => $value){
            $analysisTestResult = AnalysisTestResult::where('a_test_id', $id)->where('analysis_id', $analisisId)->first();
            if(isset($value)){
                $analysisTestResult->result = $value;
            } else {
                $analysisTestResult->result = null;
            }
            $analysisTestResult->save();
        }
        foreach ($testMetodos as $id => $value){
            $analysisTestResult = AnalysisTestResult::where('a_test_id', $id)->where('analysis_id', $analisisId)->first();
            if(isset($value) && !empty($value)){
                $analysisTestResult->metodo = $value;
            } else {
                $analysisTestResult->metodo = null;
            }
            $analysisTestResult->save();
        }
        $analysisTestResults = AnalysisTestResult::where('analysis_id', $analisisId)->select('id', 'a_test_id', 'result', 'metodo', 'test_text')->get();
        EditarControl::grabarEditar(Auth::user()->id, $request->post('analisis_id'), json_encode($analysisTestResults));

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

        if(Auth::user()){
            ImpresionControl::grabarImpresion(Auth::user()->id, $analisisId);
        }

        $analisis = Analisis::find($analisisId);

        $orderGroupTest = ClinicaHelper::getTestGroupResultsSorted($analisisId);

        $treeGroups = ClinicaHelper::getTestGroupParentResults($analisisId);

        $showCodeIntPdf = Setting::get('code_internal_print', '0');

        $reportEnterprice = strtolower(env('REPORT_ENTERPRICE', 'DEFAULT'));
        $view = "test.reporte";
        if(!empty($reportEnterprice)){
            $view = "test.".$reportEnterprice.".reporte";
        }

        $watermark = [
            'path'   => public_path(env('PDF_WATERMARCK')),
            'alpha'  => env('PDF_WATERMARCK_ALFA', 0.1),
        ];

        $pdf = PDF::loadView(
            $view, 
            compact(
            'analisis', 
            'pathQr', 
            'orderGroupTest', 
            'sin', 
            'watermark', 
            'treeGroups', 
            'reportEnterprice',
            'showCodeIntPdf'));
            
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
