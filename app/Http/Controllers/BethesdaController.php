<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\Bethesda;
use App\Http\Requests\StoreBiopsiaPost;
use Illuminate\Support\Facades\Config;
use PDF;

class BethesdaController extends Controller
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
    public function create($analisisId)
    {
        $analisis = Analisis::find($analisisId);
        $bethesda = Bethesda::where('analisis_id', $analisisId)->first();

//        dd($bethesda->getCalidadMuestraId());

        $bethesda_calidad_muestras = Config::get('clinica.bethesda_calidad_muestra');
        $bethesda_clasificacion_generales = Config::get('clinica.bethesda_clasificacion_general');
        $bethesda_interpretaciones = Config::get('clinica.bethesda_interpretacion');
        $bethesta_checks = Config::get('clinica.bethesta_checks');
        return view('bethesda.crear', compact(
            'analisis', 'bethesda',
            'bethesda_calidad_muestras', 'bethesda_clasificacion_generales',
            'bethesda_interpretaciones', 'bethesta_checks'
            ));
    }

    public function store(StoreBiopsiaPost $request){
        if (empty($request->post('bethesda'))){
            $bethesda = new Bethesda();
        } else {
            $bethesda = Bethesda::find($request->post('bethesda'));
        }
        $this->settingBethesda($bethesda, $request);
        if($bethesda->save()){
            if($request->has('grabar-imprimir')){
                return redirect('/bethesda/reporte/'.$bethesda->analisis_id);
            }
            return redirect('/bethesda/view/'.$bethesda->analisis_id);
        } else {
            dd('Algo Salio mal al crear Bethesda, contactese con el administrador');
        }
    }

    private function settingBethesda($bethesda, $request){
        $bethesda->analisis_id = $request->post('analisis_id');
        if(array_key_exists($request->post('calidad_muestra'), Config::get('clinica.bethesda_calidad_muestra')))
            $bethesda->calidad_muestra = Config::get('clinica.bethesda_calidad_muestra')[$request->post('calidad_muestra')];
        else
            $bethesda->calidad_muestra = null;
        if(array_key_exists($request->post('clasificacion_general'), Config::get('clinica.bethesda_clasificacion_general')))
            $bethesda->clasificacion_general = Config::get('clinica.bethesda_clasificacion_general')[$request->post('clasificacion_general', '')];
        else
            $bethesda->clasificacion_general = null;

        $bethesda->escamosas = $request->post('escamosas', 0);
        $bethesda->glandulares = $request->post('glandulares', 0);
        $bethesda->metaplasia = $request->post('metaplasia', 0);

        $bethesda->interpretacion = Bethesda::getStringFromArrayInterpretaciones($request->post('interpretaciones', array()));
        $bethesda->celulas_observadas = Bethesda::getStringFromArrayCelulasObservadas($request->post('celulas_observadas', array()));
        $bethesda->observaciones = $request->post('observaciones');
        $bethesda->user_id = auth()->id();
    }

    public function viewResultado($analisisId){
        $analisis = Analisis::find($analisisId);
        $bethesda = Bethesda::where('analisis_id', $analisisId)->first();

        $celulasObservadas = json_decode($bethesda->celulas_observadas);
        $interpretaciones = json_decode($bethesda->interpretacion);
        return view('bethesda.view', compact(
            'analisis', 'bethesda', 'celulasObservadas',
            'interpretaciones'));
    }

    function reporte($analisisId) {
        $analisis = Analisis::find($analisisId);
        $bethesda = Bethesda::where('analisis_id', $analisisId)->first();

        $arr = json_decode($bethesda->celulas_observadas, true);
        $celulasObservadas = array_chunk($arr, 4);

        $interpretaciones = json_decode($bethesda->interpretacion, true);

        $pdf = PDF::loadView('bethesda.reporte', compact(
            'analisis', 'bethesda', 'celulasObservadas', 'interpretaciones'));

        $stylesheet = asset('css/reporte-pdf.css'); // external css
        $pdf->mpdf->WriteHTML($stylesheet,1);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }
}
