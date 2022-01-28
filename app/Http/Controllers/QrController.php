<?php


namespace App\Http\Controllers;


use App\Analisis;
use App\Bethesda;
use App\Biopsia;
use App\ImpresionControl;
use App\Liquido;
use App\Resultado;
use App\Seccion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Milon\Barcode\DNS2D;
use Nexmo\Laravel\Facade\Nexmo;

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
//        if (!Auth::check())
//        {
//            dd('No esta con session!!');
//        }
        $analisis = Analisis::find($analisisId);
        if($analisis->fecha_cierre == null){
            Session::flash('flash_message', '<b>Acualizo!</b> se cerro el analisis.');
            Session::flash('flash_type', 'success');
            $analisis->fecha_cierre = Carbon::now();
            $analisis->update();
        } else {
            Session::flash('flash_message', '<b>El analisis</b> ya se cerro en fecha: '. $analisis->fecha_cierre->format('d-m-Y'));
            Session::flash('flash_type', 'info');
        }
        return view('analisis.cerrar_analisis', compact('analisis'));
    }

    public function openResultadoPdf($analisisId){
        $analisis = Analisis::find($analisisId);

        switch ($analisis->tipo_analisis){
            case Analisis::CITOLOGIA:
                return $this->reporteCitologia($analisisId);
                break;
            case Analisis::BETHESDA:
                return $this->reporteBethesta($analisisId);
                break;
            case Analisis::LIQUIDOS:
                return $this->reporteLiquidos($analisisId);
                break;
            default:
                return $this->reporteBiopsia($analisisId);
                break;
        }

    }

    function reporteBiopsia($analisisId) {
        $d = new DNS2D();
        $d->setStorPath(public_path()."/generateqr/");
        $pathQr = $d->getBarcodePNGPath(route('analisis.reporte.pdf.public', ['analisisId' => $analisisId]), "QRCODE");

        $analisis = Analisis::find($analisisId);
        $biopsia = Biopsia::where('analisis_id', $analisisId)->first();

        $pdf = PDF::loadView('biopsia.reporte', compact(
            'analisis', 'biopsia', 'pathQr'));

        $stylesheet = asset('css/reporte-pdf.css'); // external css
        $pdf->mpdf->WriteHTML($stylesheet,1);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }

    function reporteCitologia($analisisId) {
        $d = new DNS2D();
        $d->setStorPath(public_path()."/generateqr/");
        $pathQr = $d->getBarcodePNGPath(route('analisis.reporte.pdf.public', ['analisisId' => $analisisId]), "QRCODE");

        ImpresionControl::grabarImpresion(Auth::user()->id, $analisisId);

        $analisis = Analisis::find($analisisId);
        Analisis::saveFechaEntrega($analisis, Auth::user()->name);
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
        $pathQr = $d->getBarcodePNGPath(route('analisis.reporte.pdf.public', ['analisisId' => $analisisId]), "QRCODE");
        ImpresionControl::grabarImpresion(Auth::user()->id, $analisisId);
        $analisis = Analisis::find($analisisId);
        Analisis::saveFechaEntrega($analisis, Auth::user()->name);
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
        $pathQr = $d->getBarcodePNGPath(route('analisis.reporte.pdf.public', ['analisisId' => $analisisId]), "QRCODE");
        ImpresionControl::grabarImpresion(Auth::user()->id, $analisisId);

        $analisis = Analisis::find($analisisId);
        Analisis::saveFechaEntrega($analisis, Auth::user()->name);
        $liquido = Liquido::where('analisis_id', $analisisId)->first();

        $pdf = PDF::loadView('liquidos.reporte', compact(
            'analisis', 'liquido', 'pathQr'));

        $stylesheet = asset('css/reporte-pdf.css'); // external css
        $pdf->mpdf->WriteHTML($stylesheet,1);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }
}
