<?php


namespace App\Http\Controllers;


use App\Analisis;
use App\AnalysisTest;
use App\AnalysisTestResult;
use App\Bethesda;
use App\BiologiaMolecular;
use App\Biopsia;
use App\Helpers\ClinicaHelper;
use App\Histoquimica;
use App\ImpresionControl;
use App\Liquido;
use App\Resultado;
use App\Seccion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Milon\Barcode\DNS2D;

use Octopush\Client;
use Octopush\Request\SmsCampaign\SendSmsCampaignRequest;
use Octopush\Constant\TypeEnum;

use PDF;

class QrController
{

    public function __construct()
    {
//        $this->middleware('auth')->except('cerrarAnalisisForId', '');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index($analisisId)
    {
        if (!Auth::check())
        {
            return redirect('https://google.com');
        }
        $id = base64_decode($analisisId);
        $analisis = Analisis::find($id);
        if($analisis->fecha_cierre == null){
            Session::flash('flash_message', '<b>Actualizacíon!</b> se cerro el analisis y se actualizo la fecha de entrega.');
            Session::flash('flash_type', 'success');
            $analisis->fecha_cierre = Carbon::now();
            $analisis->fecha_entrega = Carbon::now();
            $analisis->persona_entrega = 'Registrado por QR';
            $analisis->update();
        } else {
            Session::flash('flash_message', '<b>El analisis</b> ya se cerro en fecha: '. $analisis->fecha_cierre->format('d-m-Y'));
            Session::flash('flash_type', 'info');
        }
        return view('analisis.cerrar_analisis', compact('analisis'));
    }

    public function openResultadoPdf($analisisId){
        $id = base64_decode($analisisId);
        $analisis = Analisis::find($id);

        if(!$analisis){
            return redirect('/');
        }
        switch ($analisis->tipo_analisis){
            case Analisis::CITOLOGIA:
                if(Resultado::where('analisis_id', $analisis->id)->count() > 0){
                    return $this->reporteCitologia($id);
                }
                return 'Analisis no terminado';
                break;
            case Analisis::BETHESDA:
                if(Bethesda::where('analisis_id', $analisis->id)->count() > 0){
                    return $this->reporteBethesta($id);
                }
                return 'Analisis no terminado';
                break;
            case Analisis::LIQUIDOS:
                if(Liquido::where('analisis_id', $analisis->id)->count() > 0){
                    return $this->reporteLiquidos($id);
                }
                return 'Analisis no terminado';
                break;
            case Analisis::INMUNOHISTOQUIMICA:
                if(Histoquimica::where('analisis_id', $analisis->id)->count() > 0){
                    return $this->reporteInmu($id);
                }
                return 'Analisis no terminado';
                break;
            case Analisis::BIOLOGIA_MOLECULAR:
                if(BiologiaMolecular::where('analisis_id', $analisis->id)->count() > 0){
                    return $this->reporteBmolecular($id);
                }
                return 'Analisis no terminado';
            case Analisis::PRUEBA:
                if(AnalysisTestResult::where('analysis_id', $analisis->id)->count() > 0){
                    return $this->reporteTest($id);
                }
                return 'Analisis no terminado';
            default:
                return $this->reporteBiopsia($id);
                break;
        }

    }

    function reporteBiopsia($analisisId) {
        $d = new DNS2D();
        $d->setStorPath(public_path()."/generateqr/");
        $pathQr = $d->getBarcodePNGPath(route('analisis.reporte.pdf.public', ['analisisId' => base64_encode($analisisId)]), "QRCODE");

        $analisis = Analisis::find($analisisId);
        $biopsia = Biopsia::where('analisis_id', $analisisId)->first();

        $pdf = PDF::loadView('biopsia.reporte', compact(
            'analisis', 'biopsia', 'pathQr'));

        $stylesheet = asset('css/reporte-pdf.css'); // external css
        $pdf->mpdf->WriteHTML($stylesheet,1);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }

    function reporteBmolecular($analisisId) {
        $d = new DNS2D();
        $d->setStorPath(public_path()."/generateqr/");
        $pathQr = $d->getBarcodePNGPath(route('analisis.reporte.pdf.public', ['analisisId' => base64_encode($analisisId)]), "QRCODE");
//        ImpresionControl::grabarImpresion(Auth::user()->id, $analisisId);
        $analisis = Analisis::find($analisisId);
        $biologia = BiologiaMolecular::where('analisis_id', $analisisId)->first();
        $pdf = PDF::loadView('biologia-molecular.reporte', compact(
            'analisis', 'biologia', 'pathQr'), [], ['marginTop' => 800]);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }

    function reporteCitologia($analisisId) {
        $d = new DNS2D();
        $d->setStorPath(public_path()."/generateqr/");
        $pathQr = $d->getBarcodePNGPath(route('analisis.reporte.pdf.public', ['analisisId' => base64_encode($analisisId)]), "QRCODE");

        $analisis = Analisis::find($analisisId);
        $resultados = Resultado::where('analisis_id', $analisisId)->first();
        $seccionOMG = Seccion::getArraySeccionesByOMS($resultados->secciones);
        $seccionRichart = Seccion::getArraySeccionesByRichart($resultados->secciones);
        $seccionBeth = Seccion::getArraySeccionesByBethesda($resultados->secciones);
        $seccionExtendidoCompatible = Seccion::getArraySeccionesByExtendidoCompatible($resultados->secciones);
        $seccionReacInflamatoria = Seccion::getArraySeccionesByReacInflamatorio($resultados->secciones);
        $seccionEstudioMicro = Seccion::getArraySeccionesByEstudioMicro($resultados->secciones);
        $seccionEstudioCitoHormonal = Seccion::getArraySeccionesByCitoHormonal($resultados->secciones);
        $seccionEstudioCitoPosmenopausia = Seccion::getArraySeccionesByCitoPosmenopausia($resultados->secciones);
        $seccionDesviaciones = Seccion::getArraySeccionesByDesviaciones($resultados->secciones);

        $reacInflaAusente = Seccion::getArraySeccionesByReacInflamatorioByName($resultados->secciones, 'AUSENTE');
        $reacInflaLeve = Seccion::getArraySeccionesByReacInflamatorioByName($resultados->secciones, 'LEVE');
        $reacInflaVagina = Seccion::getArraySeccionesByReacInflamatorioByName($resultados->secciones, 'VAGINA');
        $reacInflaEndocervix = Seccion::getArraySeccionesByReacInflamatorioByName($resultados->secciones, 'ENDOCERVIX');
        $reacInflaModerada = Seccion::getArraySeccionesByReacInflamatorioByName($resultados->secciones, 'MODERADA');
        $reacInflaCervix = Seccion::getArraySeccionesByReacInflamatorioByName($resultados->secciones, 'CERVIX');
        $reacInflaOtros = Seccion::getArraySeccionesByReacInflamatorioByName($resultados->secciones, 'OTROS');
        $reacInflaAcentuada = Seccion::getArraySeccionesByReacInflamatorioByName($resultados->secciones, 'ACENTUADA');

        $pdf = PDF::loadView('citologia.reporte', compact(
            'analisis', 'resultados', 'seccionOMG',
            'seccionBeth', 'seccionRichart', 'seccionReacInflamatoria',
            'seccionEstudioMicro', 'seccionEstudioCitoHormonal', 'seccionEstudioCitoPosmenopausia',
            'seccionDesviaciones', 'reacInflaAusente', 'reacInflaLeve', 'reacInflaVagina',
            'reacInflaEndocervix', 'reacInflaModerada', 'reacInflaCervix', 'reacInflaOtros',
            'reacInflaAcentuada',
            'seccionExtendidoCompatible', 'pathQr'));

        $stylesheet = asset('css/reporte-pdf.css'); // external css
        $pdf->mpdf->WriteHTML($stylesheet,1);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }

    function reporteBethesta($analisisId) {
        $d = new DNS2D();
        $d->setStorPath(public_path()."/generateqr/");
        $pathQr = $d->getBarcodePNGPath(route('analisis.reporte.pdf.public', ['analisisId' => base64_encode($analisisId)]), "QRCODE");
        $analisis = Analisis::find($analisisId);
        $bethesda = Bethesda::where('analisis_id', $analisisId)->first();

        $arr = json_decode($bethesda->celulas_observadas, true);
        $celulasObservadas = array_chunk($arr, 4);

        $interpretaciones = json_decode($bethesda->interpretacion, true);

        $pdf = PDF::loadView('bethesda.reporte', compact(
            'analisis', 'bethesda', 'celulasObservadas', 'interpretaciones', 'pathQr'));

        $stylesheet = asset('css/reporte-pdf.css'); // external css
        $pdf->mpdf->WriteHTML($stylesheet,1);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }

    function reporteLiquidos($analisisId) {
        $d = new DNS2D();
        $d->setStorPath(public_path()."/generateqr/");
        $pathQr = $d->getBarcodePNGPath(route('analisis.reporte.pdf.public', ['analisisId' => base64_encode($analisisId)]), "QRCODE");

        $analisis = Analisis::find($analisisId);
        $liquido = Liquido::where('analisis_id', $analisisId)->first();

        $pdf = PDF::loadView('liquidos.reporte', compact(
            'analisis', 'liquido', 'pathQr'));

        $stylesheet = asset('css/reporte-pdf.css'); // external css
        $pdf->mpdf->WriteHTML($stylesheet,1);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }

    function reporteTest($analisisId) {
        $d = new DNS2D();
        $d->setStorPath(public_path()."/generateqr/");
        $pathQr = $d->getBarcodePNGPath(route('analisis.reporte.pdf.public', ['analisisId' => base64_encode($analisisId)]), "QRCODE");

//        dd(public_path($pathQr));

        $analisis = Analisis::find($analisisId);

        $orderGroupTest = ClinicaHelper::getTestGroupResults($analisisId);

        $pdf = PDF::loadView('test.reporte', compact(
            'analisis', 'pathQr', 'orderGroupTest'));

        $stylesheet = asset('css/reporte-pdf.css'); // external css
        $pdf->mpdf->SetWatermarkImage(public_path('img/test-lab.png'));
        $pdf->mpdf->showWatermarkImage = true;
        $pdf->mpdf->WriteHTML($stylesheet,1);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }

    function reporteInmu($analisisId) {
        $d = new DNS2D();
        $d->setStorPath(public_path()."/generateqr/");
        $pathQr = $d->getBarcodePNGPath(route('analisis.reporte.pdf.public', ['analisisId' => base64_encode($analisisId)]), "QRCODE");
        $analisis = Analisis::find($analisisId);
        $histo = Histoquimica::where('analisis_id', $analisisId)->first();
        $pdf = PDF::loadView('histo.reporte', compact(
            'analisis', 'histo', 'pathQr'), [], ['marginTop' => 800]);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }

    public function openRecepcionPdf($analisisId){
        $analisis = Analisis::find($analisisId);

        if(!$analisis){
            return redirect('/');
        }
        $d = new DNS2D();
        $d->setStorPath(public_path()."/generateqr/");
        $pathQr = $d->getBarcodePNGPath(route('analisis.reporte.pdf.public', ['analisisId' => base64_encode($analisisId)]), "QRCODE");

        $analisis = Analisis::find($analisisId);
        $pdf = PDF::loadView('analisis.recepcion_pdf', compact(
            'analisis', 'pathQr'));

        $stylesheet = asset('css/reporte-pdf.css'); // external css
        $pdf->mpdf->WriteHTML($stylesheet,1);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);

    }
}
