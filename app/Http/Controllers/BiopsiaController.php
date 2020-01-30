<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\Biopsia;
use App\Http\Requests\StoreBiopsiaPost;
use Illuminate\Support\Facades\Auth;
use PDF;

class BiopsiaController extends Controller
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
        $biopsia = Biopsia::where('analisis_id', $analisisId)->first();
        return view('biopsia.crear', compact('analisis', 'biopsia'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBiopsiaPost $request){
        if (empty($request->post('biopsia_id'))){
            $biopsia = new Biopsia();
            $biopsia->analisis_id = $request->post('analisis_id');
            $biopsia->organo_tejido = $request->post('organo_tejido');
            $biopsia->macroscopia = $request->post('macroscopia');
            $biopsia->microscopia = $request->post('microscopia');
            $biopsia->diagnostico = $request->post('diagnostico');
            $biopsia->user_id = auth()->id();

            $analisis = Analisis::find($request->post('analisis_id'));
            $analisis->region = $request->post('organo_tejido');
            $analisis->update();
            if($biopsia->save()){
                if(Auth::user()->hasRole('tecnico')){
                    return redirect('/analisis/lista/tecnico');
                } else{
                    return redirect('/analisis');
                }
            } else {
                dd('Algo Salio mal al crear la biopsia, contactese con el administrador');
            }
        } else {
            $biopsia = Biopsia::find($request->post('biopsia_id'));
            $biopsia->analisis_id = $request->post('analisis_id');
            $biopsia->organo_tejido = $request->post('organo_tejido');
            $biopsia->macroscopia = $request->post('macroscopia');
            $biopsia->microscopia = $request->post('microscopia');
            $biopsia->diagnostico = $request->post('diagnostico');
            $biopsia->user_id = auth()->id();

            $analisis = Analisis::find($request->post('analisis_id'));
            $analisis->region = $request->post('organo_tejido');
            $analisis->update();

            if($biopsia->update()){
                if(Auth::user()->hasRole('tecnico')){
                    return redirect('/analisis/lista/tecnico');
                } else{
                    return redirect('/analisis');
                }
            } else {
                dd('Algo Salio mal al actualizar la biopsia, contactese con el administrador');
            }
        }
    }

    public function viewResultado($analisisId){
        $analisis = Analisis::find($analisisId);
        $biopsia = Biopsia::where('analisis_id', $analisisId)->first();

        return view('biopsia.view', compact(
            'analisis', 'biopsia'));
    }

    function reporte($analisisId) {
        $analisis = Analisis::find($analisisId);
        $biopsia = Biopsia::where('analisis_id', $analisisId)->first();

        $pdf = PDF::loadView('biopsia.reporte', compact(
            'analisis', 'biopsia'));

        $stylesheet = asset('css/reporte-pdf.css'); // external css
        $pdf->mpdf->WriteHTML($stylesheet,1);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }
}
