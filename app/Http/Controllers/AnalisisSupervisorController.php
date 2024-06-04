<?php

namespace App\Http\Controllers;

use App\Analisis;
use Illuminate\Http\Request;

class AnalisisSupervisorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('cerrarAnalisisForId', '');
    }

    public function ajaxChange(Request $request){
        $analisisId = $request->get('analisis_id');
        $analisis = Analisis::find($analisisId);
        $analisis->doctor_supervisor = $request->post('doctor_supervisor');
        $analisis->comentario_supervisor = $request->post('comentario_supervisor');
        $analisis->user_asig_supervisor = auth()->id();
        $analisis->update();
        return response()->json(['success' => true, 'message' => 'Se grabo correctamente el SUPERVISOR asignado, para este análisis']);
    }

    public function ajaxData(Request $request){
        $analisisId = $request->get('analisis_id');
        $analisis = Analisis::find($analisisId);
        $data = [];
        if(isset($analisis->doctor_supervisor)){
            $data['doctor_supervisor'] = $analisis->doctor_supervisor;
        }
        if(isset($analisis->comentario_supervisor)){
            $data['comentario_supervisor'] = $analisis->comentario_supervisor;
        }
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function ajaxSetImprimirFirmaSupervisor(Request $request){
        $analisisId = $request->post('analisis_id');
        $ifirma = $request->post('imprimir_firma_supervisor');
        $analisis = Analisis::find($analisisId);
        $analisis->imprimir_firma_supervisor = $ifirma;
        $analisis->update();

        return response()->json(['success' => true, 'message' => 'Se actualizó correctamente la firma del supervisor.']);
    }
}
