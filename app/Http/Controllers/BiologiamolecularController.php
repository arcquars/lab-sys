<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\BiologiaMolecular;
use App\EditarControl;
use App\Histoquimica;
use App\Http\Requests\StoreHistoPost;
use App\ImpresionControl;
use App\Marcador;
use App\MarcadorBiologia;
use Illuminate\Support\Facades\Auth;
use Milon\Barcode\DNS2D;
use PDF;

class BiologiamolecularController extends Controller
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
        if (strcmp($analisis->tipo_analisis, Analisis::BIOLOGIA_MOLECULAR) != 0) {
            return redirect()->action('AnalisisController@index');
        }
        $biologia = BiologiaMolecular::where('analisis_id', $analisisId)->first();

//        dd($biologia->marcadores);
        return view('biologia-molecular.crear', compact('analisis', 'biologia'));
    }

    public function store(StoreHistoPost $request){
        EditarControl::grabarEditar(Auth::user()->id, $request->post('analisis_id'));
        if (empty($request->post('biologiam_id'))){
            $biologiam = new BiologiaMolecular();
            $biologiam->analisis_id = $request->post('analisis_id');
            $biologiam->interpretacion = $request->post('interpretacion');
            $biologiam->tecnica = $request->post('tecnica');
            $biologiam->bibliografia = $request->post('bibliografia');
            $biologiam->user_id = auth()->id();

            if ($files = $request->file('imagen1')) {
                $profilefile = 'imagen1'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
//                $histo->imagen1 = public_path('uploads').'/'.$profilefile;
                $biologiam->imagen1 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen2')) {
                $profilefile = 'imagen2'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biologiam->imagen2 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen3')) {
                $profilefile = 'imagen3'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biologiam->imagen3 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen4')) {
                $profilefile = 'imagen4'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biologiam->imagen4 = 'uploads/'.$profilefile;
            }
            $biologiam->titulo_1 = $request->post('titulo_1');
            $biologiam->titulo_2 = $request->post('titulo_2');
            $biologiam->titulo_3 = $request->post('titulo_3');
            $biologiam->titulo_4 = $request->post('titulo_4');

            if($biologiam->save()){
                MarcadorBiologia::saveMarcadorsByBiologiaId($biologiam->id, $request->post('marcadores'));
                if($request->has('grabar-imprimir')){
                    return redirect('/biologia-molecular/reporte/'.$biologiam->analisis_id);
                }
                return redirect('/biologia-molecular/view/'.$biologiam->analisis_id);
//                return redirect('/analisis');
            } else {
                dd('Algo Salio mal al crear la Biologia molecular, contactese con el administrador');
            }
        } else {
            $biologiam = BiologiaMolecular::find($request->post('biologiam_id'));
            $biologiam->interpretacion = $request->post('interpretacion');
            $biologiam->tecnica = $request->post('tecnica');
            $biologiam->bibliografia = $request->post('bibliografia');
            $biologiam->user_id = auth()->id();

            if ($files = $request->file('imagen1')) {
                $profilefile = 'imagen1'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
//                $histo->imagen1 = public_path('uploads').'/'.$profilefile;
                $biologiam->imagen1 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen2')) {
                $profilefile = 'imagen2'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biologiam->imagen2 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen3')) {
                $profilefile = 'imagen3'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biologiam->imagen3 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen4')) {
                $profilefile = 'imagen4'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biologiam->imagen4 = 'uploads/'.$profilefile;
            }
            $biologiam->titulo_1 = $request->post('titulo_1');
            $biologiam->titulo_2 = $request->post('titulo_2');
            $biologiam->titulo_3 = $request->post('titulo_3');
            $biologiam->titulo_4 = $request->post('titulo_4');

            if($biologiam->update()){
                MarcadorBiologia::saveMarcadorsByBiologiaId($biologiam->id, $request->post('marcadores'));
                if($request->has('grabar-imprimir')){
                    return redirect('/biologia-molecular/reporte/'.$biologiam->analisis_id);
                }
                return redirect('/biologia-molecular/view/'.$biologiam->analisis_id);
//                return redirect('/analisis');
            } else {
                dd('Algo Salio mal al actualizar la Biologia molecular, contactese con el administrador');
            }

        }
        return redirect('/analisis');
    }

    public function viewResultado($analisisId){
        $analisis = Analisis::find($analisisId);
        $biologia = BiologiaMolecular::where('analisis_id', $analisisId)->first();

//        dd($histo->id);
        return view('biologia-molecular.view', compact(
            'analisis', 'biologia'));
    }

    function reporte($analisisId) {
        $d = new DNS2D();
        $d->setStorPath(public_path()."/generateqr/");
        $pathQr = $d->getBarcodePNGPath(route('analisis.reporte.pdf.public', ['analisisId' => base64_encode($analisisId)]), "QRCODE");
        ImpresionControl::grabarImpresion(Auth::user()->id, $analisisId);
        $analisis = Analisis::find($analisisId);
//        Analisis::saveFechaEntrega($analisis, Auth::user()->name);
        $biologia = BiologiaMolecular::where('analisis_id', $analisisId)->first();
        $pdf = PDF::loadView('biologia-molecular.reporte', compact(
            'analisis', 'biologia', 'pathQr'), [], ['marginTop' => 800]);
        $fileNombre = $analisis->codigo.date('ymd').'.pdf';
        return $pdf->stream($fileNombre);
    }
}
