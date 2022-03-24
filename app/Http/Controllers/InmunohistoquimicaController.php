<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\EditarControl;
use App\Histoquimica;
use App\Http\Requests\StoreHistoPost;
use App\ImpresionControl;
use App\Marcador;
use Illuminate\Support\Facades\Auth;
use Milon\Barcode\DNS2D;
use PDF;

class InmunohistoquimicaController extends Controller
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
        if (strcmp($analisis->tipo_analisis, Analisis::INMUNOHISTOQUIMICA) != 0) {
            return redirect()->action('AnalisisController@index');
        }
        $histo = Histoquimica::where('analisis_id', $analisisId)->first();

        return view('histo.crear', compact('analisis', 'histo'));
    }

    public function store(StoreHistoPost $request){
        EditarControl::grabarEditar(Auth::user()->id, $request->post('analisis_id'));
        if (empty($request->post('histo_id'))){
            $histo = new Histoquimica();
            $histo->analisis_id = $request->post('analisis_id');
            $histo->interpretacion = $request->post('interpretacion');
            $histo->tecnica = $request->post('tecnica');
            $histo->bibliografia = $request->post('bibliografia');
            $histo->user_id = auth()->id();

            if ($files = $request->file('imagen1')) {
                $profilefile = 'imagen1'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
//                $histo->imagen1 = public_path('uploads').'/'.$profilefile;
                $histo->imagen1 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen2')) {
                $profilefile = 'imagen2'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $histo->imagen2 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen3')) {
                $profilefile = 'imagen3'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $histo->imagen3 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen4')) {
                $profilefile = 'imagen4'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $histo->imagen4 = 'uploads/'.$profilefile;
            }
            $histo->titulo_1 = $request->post('titulo_1');
            $histo->titulo_2 = $request->post('titulo_2');
            $histo->titulo_3 = $request->post('titulo_3');
            $histo->titulo_4 = $request->post('titulo_4');

            if($histo->save()){
                Marcador::saveMarcadorsByHistoquimicaId($histo->id, $request->post('marcadores'));
                if($request->has('grabar-imprimir')){
                    return redirect('/histo/reporte/'.$histo->analisis_id);
                }
                return redirect('/histo/view/'.$histo->analisis_id);
//                return redirect('/analisis');
            } else {
                dd('Algo Salio mal al crear la Inmunohistoquimica, contactese con el administrador');
            }
        } else {
            $histo = Histoquimica::find($request->post('histo_id'));
            $histo->interpretacion = $request->post('interpretacion');
            $histo->tecnica = $request->post('tecnica');
            $histo->bibliografia = $request->post('bibliografia');
            $histo->user_id = auth()->id();

            if ($files = $request->file('imagen1')) {
                $profilefile = 'imagen1'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
//                $histo->imagen1 = public_path('uploads').'/'.$profilefile;
                $histo->imagen1 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen2')) {
                $profilefile = 'imagen2'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $histo->imagen2 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen3')) {
                $profilefile = 'imagen3'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $histo->imagen3 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen4')) {
                $profilefile = 'imagen4'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $histo->imagen4 = 'uploads/'.$profilefile;
            }
            $histo->titulo_1 = $request->post('titulo_1');
            $histo->titulo_2 = $request->post('titulo_2');
            $histo->titulo_3 = $request->post('titulo_3');
            $histo->titulo_4 = $request->post('titulo_4');

            if($histo->update()){
                Marcador::saveMarcadorsByHistoquimicaId($histo->id, $request->post('marcadores'));
                if($request->has('grabar-imprimir')){
                    return redirect('/histo/reporte/'.$histo->analisis_id);
                }
                return redirect('/histo/view/'.$histo->analisis_id);
//                return redirect('/analisis');
            } else {
                dd('Algo Salio mal al actualizar la Inmunohistoquimica, contactese con el administrador');
            }

        }
        return redirect('/analisis');
    }

    public function viewResultado($analisisId){
        $analisis = Analisis::find($analisisId);
        $histo = Histoquimica::where('analisis_id', $analisisId)->first();

//        dd($histo->id);
        return view('histo.view', compact(
            'analisis', 'histo'));
    }

    function reporte($analisisId) {
        $d = new DNS2D();
        $d->setStorPath(public_path()."/generateqr/");
        $pathQr = $d->getBarcodePNGPath(route('analisis.reporte.pdf.public', ['analisisId' => base64_encode($analisisId)]), "QRCODE");
        ImpresionControl::grabarImpresion(Auth::user()->id, $analisisId);
        $analisis = Analisis::find($analisisId);
//        Analisis::saveFechaEntrega($analisis, Auth::user()->name);
        $histo = Histoquimica::where('analisis_id', $analisisId)->first();
        $pdf = PDF::loadView('histo.reporte', compact(
            'analisis', 'histo', 'pathQr'), [], ['marginTop' => 800]);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }
}
