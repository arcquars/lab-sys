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
    public function create($analisisId, $is_histopatologico)
    {
        $analisis = Analisis::find($analisisId);
        $biopsia = Biopsia::where('analisis_id', $analisisId)->first();
        return view('biopsia.crear', compact('analisis', 'biopsia', 'is_histopatologico'));
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
            $biopsia->is_histopatologico = $request->post('is_histopatologico');
            $biopsia->user_id = auth()->id();

            $analisis = Analisis::find($request->post('analisis_id'));
            $analisis->region = $request->post('organo_tejido');
            $analisis->update();

            if ($files = $request->file('imagen1')) {
                $profilefile = 'imagen1'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
//                $histo->imagen1 = public_path('uploads').'/'.$profilefile;
                $biopsia->imagen1 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen2')) {
                $profilefile = 'imagen2'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->imagen2 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen3')) {
                $profilefile = 'imagen3'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->imagen3 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen4')) {
                $profilefile = 'imagen4'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->imagen4 = 'uploads/'.$profilefile;
            }

            if ($files = $request->file('histopatologico_imagenes1')) {
                $profilefile = 'imagen_histopatologico_1'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->histopatologico_imagenes1 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('histopatologico_imagenes2')) {
                $profilefile = 'imagen_histopatologico_2'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->histopatologico_imagenes2 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('histopatologico_imagenes3')) {
                $profilefile = 'imagen_histopatologico_3'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->histopatologico_imagenes3 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('histopatologico_imagenes4')) {
                $profilefile = 'imagen_histopatologico_4'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->histopatologico_imagenes4 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('histopatologico_imagenes5')) {
                $profilefile = 'imagen_histopatologico_5'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->histopatologico_imagenes5 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('histopatologico_imagenes6')) {
                $profilefile = 'imagen_histopatologico_6'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->histopatologico_imagenes6 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('histopatologico_imagenes7')) {
                $profilefile = 'imagen_histopatologico_7'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->histopatologico_imagenes7 = 'uploads/'.$profilefile;
            }
            $biopsia->titulo_1 = $request->post('titulo_1');
            $biopsia->titulo_2 = $request->post('titulo_2');
            $biopsia->titulo_3 = $request->post('titulo_3');
            $biopsia->titulo_4 = $request->post('titulo_4');

            $biopsia->histopatologico_nombre1 = $request->post('histopatologico_nombre1');
            $biopsia->histopatologico_nombre2 = $request->post('histopatologico_nombre2');
            $biopsia->histopatologico_nombre3 = $request->post('histopatologico_nombre3');
            $biopsia->histopatologico_nombre4 = $request->post('histopatologico_nombre4');
            $biopsia->histopatologico_nombre5 = $request->post('histopatologico_nombre5');
            $biopsia->histopatologico_nombre6 = $request->post('histopatologico_nombre6');
            $biopsia->histopatologico_nombre7 = $request->post('histopatologico_nombre7');

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

            if ($files = $request->file('imagen1')) {
                $profilefile = 'imagen1'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->imagen1 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen2')) {
                $profilefile = 'imagen2'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->imagen2 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen3')) {
                $profilefile = 'imagen3'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->imagen3 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('imagen4')) {
                $profilefile = 'imagen4'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->imagen4 = 'uploads/'.$profilefile;
            }

            if ($files = $request->file('histopatologico_imagenes1')) {
                $profilefile = 'imagen_histopatologico_1'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->histopatologico_imagenes1 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('histopatologico_imagenes2')) {
                $profilefile = 'imagen_histopatologico_2'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->histopatologico_imagenes2 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('histopatologico_imagenes3')) {
                $profilefile = 'imagen_histopatologico_3'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->histopatologico_imagenes3 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('histopatologico_imagenes4')) {
                $profilefile = 'imagen_histopatologico_4'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->histopatologico_imagenes4 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('histopatologico_imagenes5')) {
                $profilefile = 'imagen_histopatologico_5'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->histopatologico_imagenes5 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('histopatologico_imagenes6')) {
                $profilefile = 'imagen_histopatologico_6'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->histopatologico_imagenes6 = 'uploads/'.$profilefile;
            }
            if ($files = $request->file('histopatologico_imagenes7')) {
                $profilefile = 'imagen_histopatologico_7'.date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move(public_path('uploads'), $profilefile);
                $biopsia->histopatologico_imagenes7 = 'uploads/'.$profilefile;
            }
            $biopsia->titulo_1 = $request->post('titulo_1');
            $biopsia->titulo_2 = $request->post('titulo_2');
            $biopsia->titulo_3 = $request->post('titulo_3');
            $biopsia->titulo_4 = $request->post('titulo_4');

            $biopsia->histopatologico_nombre1 = $request->post('histopatologico_nombre1');
            $biopsia->histopatologico_nombre2 = $request->post('histopatologico_nombre2');
            $biopsia->histopatologico_nombre3 = $request->post('histopatologico_nombre3');
            $biopsia->histopatologico_nombre4 = $request->post('histopatologico_nombre4');
            $biopsia->histopatologico_nombre5 = $request->post('histopatologico_nombre5');
            $biopsia->histopatologico_nombre6 = $request->post('histopatologico_nombre6');
            $biopsia->histopatologico_nombre7 = $request->post('histopatologico_nombre7');


            if ($files = $request->file('histopatologicos')) {
                $directorio = 'histopatologico-'.$analisis->id;
                if(!is_dir(public_path('uploads').'/'.$directorio))
                    mkdir(public_path('uploads').'/'.$directorio, 0777);
                else{
                    exec('rm -r '.public_path('uploads').'/'.$directorio);
                    mkdir(public_path('uploads').'/'.$directorio, 0777);
                }
                foreach($files as $file){
                    $profilefile = $file->getClientOriginalName() . "." . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads').'/'.$directorio, $profilefile);
                }

                $biopsia->histopatologico_imagenes = 'uploads/'.$directorio;
            }


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
