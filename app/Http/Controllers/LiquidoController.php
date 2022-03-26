<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\EditarControl;
use App\ImpresionControl;
use App\Liquido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Milon\Barcode\DNS2D;
use PDF;

class LiquidoController extends Controller
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
        $liquido = Liquido::where('analisis_id', $analisisId)->first();
        return view('liquidos.crear', compact('analisis', 'liquido'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        EditarControl::grabarEditar(Auth::user()->id, $request->input('analisis_id'));
        if (empty($request->post('liquido_id'))){
            $liquido = new Liquido();
            $liquido->analisis_id = $request->post('analisis_id');
            $liquido->organo_tejido = $request->post('organo_tejido');
            $liquido->macroscopia = $request->post('macroscopia');
            $liquido->microscopia = $request->post('microscopia');
            $liquido->diagnostico = $request->post('diagnostico');
            $liquido->user_id = auth()->id();

            $analisis = Analisis::find($request->post('analisis_id'));
            $analisis->region = $request->post('organo_tejido');
            $analisis->update();

            if($liquido->save()){
                if(Auth::user()->hasRole('tecnico')){
                    return redirect('/analisis/lista/tecnico');
                } else{
                    if($request->has('grabar-imprimir')){
                        return redirect('/liquidos/reporte/'.$liquido->analisis_id);
                    }
                    return redirect('/liquidos/view/'.$liquido->analisis_id);
                }
            } else {
                dd('Algo Salio mal al crear el liquidos, contactese con el administrador');
            }
        } else {
            $liquido = $this->updateLiquido($request);
            if($liquido->update()){
                if(Auth::user()->hasRole('tecnico')){
                    return redirect('/analisis/lista/tecnico');
                } else{
                    if($request->has('grabar-imprimir')){
                        return redirect('/liquidos/reporte/'.$liquido->analisis_id);
                    }
                    return redirect('/liquidos/view/'.$liquido->analisis_id);
                }
            } else {
                dd('Algo Salio mal al actualizar liquido, contactese con el administrador');
            }
        }
    }

    private function updateLiquido($request){
        $liquido = Liquido::find($request->post('liquido_id'));
        $liquido->analisis_id = $request->post('analisis_id');
        $liquido->organo_tejido = $request->post('organo_tejido');
        $liquido->macroscopia = $request->post('macroscopia');
        $liquido->microscopia = $request->post('microscopia');
        $liquido->diagnostico = $request->post('diagnostico');
        $liquido->user_id = auth()->id();

        $analisis = Analisis::find($request->post('analisis_id'));
        $analisis->region = $request->post('organo_tejido');
        $analisis->update();
        return $liquido;
    }

    public function viewResultado($analisisId){
        $analisis = Analisis::find($analisisId);
        $liquido = Liquido::where('analisis_id', $analisisId)->first();

        return view('liquidos.view', compact(
            'analisis', 'liquido'));
    }

    function reporte($analisisId) {
        $d = new DNS2D();
        $d->setStorPath(public_path()."/generateqr/");
        $pathQr = $d->getBarcodePNGPath(route('analisis.reporte.pdf.public', ['analisisId' => base64_encode($analisisId)]), "QRCODE");
        ImpresionControl::grabarImpresion(Auth::user()->id, $analisisId);

        $analisis = Analisis::find($analisisId);
//        Analisis::saveFechaEntrega($analisis, Auth::user()->name);
        $liquido = Liquido::where('analisis_id', $analisisId)->first();

        $pdf = PDF::loadView('liquidos.reporte', compact(
            'analisis', 'liquido', 'pathQr'));

        $stylesheet = asset('css/reporte-pdf.css'); // external css
        $pdf->mpdf->WriteHTML($stylesheet,1);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }
}
