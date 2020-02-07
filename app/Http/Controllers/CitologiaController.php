<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\Http\Requests\StoreResultadosPost;
use App\Resultado;
use App\Seccion;
use Illuminate\Http\Request;
use PDF;

class CitologiaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('ddddddd');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($analisisId)
    {
        $analisis = Analisis::find($analisisId);

        $resultados = Resultado::where('analisis_id', $analisisId)->first();
        $seccOms = null;
        $seccHichart = null;
        $seccBethesda = null;
        $seccECD = null;
        $seccReaccInfl = null;
        $seccEstMicro = null;
        $seccCitoHormonal = null;
        $seccCitoPosm = null;
        $seccDesviacion = null;
        if(isset($resultados)){
            $secciones = $resultados->secciones;
            $seccOms = Seccion::getArraySeccionesByOMS($secciones);
            $seccHichart = Seccion::getArraySeccionesByRichart($secciones);
            $seccBethesda = Seccion::getArraySeccionesByBethesda($secciones);
            $seccECD = Seccion::getArraySeccionesByExtendidoCompatible($secciones);
            $seccReaccInfl = Seccion::getArraySeccionesByReacInflamatorio($secciones);
            $seccEstMicro = Seccion::getArraySeccionesByEstudioMicro($secciones);
            $seccCitoHormonal = Seccion::getArraySeccionesByCitoHormonal($secciones);
            $seccCitoPosm = Seccion::getArraySeccionesByCitoPosmenopausia($secciones);
            $seccDesviacion = Seccion::getArraySeccionesByDesviaciones($secciones);
        }

        return view('citologia.crear', compact(
            'analisisId', 'analisis',
            'resultados', 'seccOms', 'seccBethesda',
            'seccECD', 'seccReaccInfl', 'seccEstMicro',
            'seccCitoHormonal', 'seccCitoPosm', 'seccDesviacion',
            'seccHichart'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Resultado  $resultado
     * @return \Illuminate\Http\Response
     */
    public function show(Resultado $resultado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resultado  $resultado
     * @return \Illuminate\Http\Response
     */
    public function edit(Resultado $resultado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resultado  $resultado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resultado $resultado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resultado  $resultado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resultado $resultado)
    {
        //
    }

    public function resultados(StoreResultadosPost $request)
    {
        $resultado = new Resultado();
        $resultado->papanicolaou_clase1 = $request->input('papanicolaou_clase1');
        $resultado->papanicolaou_clase2 = $request->input('papanicolaou_clase2');
        $resultado->observaciones1 = $request->input('observaciones1');
        $resultado->observaciones2 = $request->input('observaciones2');
        $resultado->analisis_id = $request->input('analisis_id');
        $resultado->user_id = auth()->id();

        $resultado->save();
        $omsArray = $request->input('oms');
        Seccion::saveSeccionValue($omsArray, Seccion::OMS, $resultado->id);

        $richartArray = $request->input('hichart');
        Seccion::saveSeccionValue($richartArray, Seccion::RICHART, $resultado->id);

        $bethesdaArray = $request->input('bethesda');
        Seccion::saveSeccionValue($bethesdaArray, Seccion::BETHESDA, $resultado->id);

        $extCompArray = is_array($request->input('ExtComp'))? $request->input('ExtComp') : array();
        Seccion::saveSeccionKey($extCompArray, Seccion::EXTENDIDO_COMPATIBLE, $resultado->id);

        $reacInflaArray = is_array($request->input('reacInfla'))? $request->input('reacInfla') : array();
        Seccion::saveSeccionValue($reacInflaArray, Seccion::REACCION_INFLAMATORIA, $resultado->id);

        $estudioMicroArray = is_array($request->input('estudioMicro'))? $request->input('estudioMicro') : array();
        Seccion::saveSeccionValue($estudioMicroArray, Seccion::ESTUDIO_MICROBIOLOGICO, $resultado->id);

        $estudioCitohormonalArray = is_array($request->input('estCito'))? $request->input('estCito') : array();
        Seccion::saveSeccionValue($estudioCitohormonalArray, Seccion::ESTUDIO_CITO_HORMONAL, $resultado->id);

        $estudioCitologiaPosArray = is_array($request->input('citoPosmenopausia'))? $request->input('citoPosmenopausia') : array();
        Seccion::saveSeccionValue($estudioCitologiaPosArray, Seccion::CITOLOGIA_POSMENOPAUSIA, $resultado->id);

        $desviacionesArray = is_array($request->input('desviacion'))? $request->input('desviacion') : array();
        Seccion::saveSeccionValue($desviacionesArray, Seccion::DESVIACION, $resultado->id);

        return redirect()->route('citologia.viewResultado', ['analisisId' => $resultado->analisis_id]);
    }

    public function resultadosEdit(StoreResultadosPost $request)
    {
        $resultado = Resultado::where('analisis_id', $request->input('analisis_id'))->first();
//        echo 'dd: '.$request->input('analisis_id');
//        dd($resultado->id);
//        die();
        $resultado->papanicolaou_clase1 = $request->input('papanicolaou_clase1');
        $resultado->papanicolaou_clase2 = $request->input('papanicolaou_clase2');
        $resultado->observaciones1 = $request->input('observaciones1');
        $resultado->observaciones2 = $request->input('observaciones2');
        $resultado->user_id = auth()->id();

        $resultado->update();

        $secciones = Seccion::where('resultado_id', $resultado->id)->delete();
        $omsArray = $request->input('oms');
        Seccion::saveSeccionValue($omsArray, Seccion::OMS, $resultado->id);

        $richartArray = $request->input('hichart');
        Seccion::saveSeccionValue($richartArray, Seccion::RICHART, $resultado->id);

        $bethesdaArray = $request->input('bethesda');
        Seccion::saveSeccionValue($bethesdaArray, Seccion::BETHESDA, $resultado->id);

        $extCompArray = is_array($request->input('ExtComp'))? $request->input('ExtComp') : array();
        Seccion::saveSeccionKey($extCompArray, Seccion::EXTENDIDO_COMPATIBLE, $resultado->id);

        $reacInflaArray = is_array($request->input('reacInfla'))? $request->input('reacInfla') : array();
        Seccion::saveSeccionValue($reacInflaArray, Seccion::REACCION_INFLAMATORIA, $resultado->id);

        $estudioMicroArray = is_array($request->input('estudioMicro'))? $request->input('estudioMicro') : array();

        Seccion::saveSeccionValue($estudioMicroArray, Seccion::ESTUDIO_MICROBIOLOGICO, $resultado->id);

        $estudioCitohormonalArray = is_array($request->input('estCito'))? $request->input('estCito') : array();
        Seccion::saveSeccionValue($estudioCitohormonalArray, Seccion::ESTUDIO_CITO_HORMONAL, $resultado->id);

        $estudioCitologiaPosArray = is_array($request->input('citoPosmenopausia'))? $request->input('citoPosmenopausia') : array();
        Seccion::saveSeccionValue($estudioCitologiaPosArray, Seccion::CITOLOGIA_POSMENOPAUSIA, $resultado->id);

        $desviacionesArray = is_array($request->input('desviacion'))? $request->input('desviacion') : array();
        Seccion::saveSeccionValue($desviacionesArray, Seccion::DESVIACION, $resultado->id);

        return redirect()->route('citologia.viewResultado', ['analisisId' => $resultado->analisis_id]);
    }

    public function viewResultado($analisisId){
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

        return view('citologia.view', compact(
            'analisis', 'seccionExtendidoCompatible',
            'resultados', 'seccionReacInflamatoria',
            'seccionOMG', 'seccionBeth', 'seccionEstudioMicro',
            'seccionEstudioCitoHormonal', 'seccionEstudioCitoPosmenopausia',
            'seccionDesviaciones',
            'seccionRichart'));
    }

    function reporte($analisisId) {
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

        $pdf = PDF::loadView('citologia.reporte', compact(
            'analisis', 'resultados', 'seccionOMG',
            'seccionBeth', 'seccionRichart', 'seccionReacInflamatoria',
            'seccionEstudioMicro', 'seccionEstudioCitoHormonal', 'seccionEstudioCitoPosmenopausia',
            'seccionDesviaciones',
            'seccionExtendidoCompatible'));

        $stylesheet = asset('css/reporte-pdf.css'); // external css
        $pdf->mpdf->WriteHTML($stylesheet,1);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }
}
