<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\AnalisisSupervisor;
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

    public function ajaxGetSupervisores(Request $request){
        $analisisId = $request->get('analisis_id');
        $analisis = Analisis::find($analisisId);
        $data = [];
        $data['analisis'] = $analisis;
        if($analisis->supervisar){
            $data['analisis_supervisores'] = AnalisisSupervisor::where('analisis_id', '=', $analisisId)->get()->load('doctorSupervisor');
        }
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function ajaxSaveSupervisores(Request $request){
        $analisisId = $request->post('analisis_id');
        $doctores = $request->post('doctores', []);
        $analisis = Analisis::find($analisisId);

        if(count($doctores) == 0){
            $analisis->supervisar = 0;
            $analisis->comentario_supervisor =  '';
        } else {
            $analisis->supervisar = 1;
            $analisis->comentario_supervisor =  $request->post('comentario_supervisor', '');
            $analisisSupervisores = AnalisisSupervisor::where('analisis_id', $analisisId)->get();
            if(count($analisisSupervisores) > 0){
                foreach ($analisisSupervisores as $as){
                    $isDelete = true;
                    foreach ($doctores as $doctor){
                        if($as->doctor_id == $doctor){
                            $isDelete = false;
                        }
                    }
                    if($isDelete){
                        $as->delete();
                    }
                }

                foreach ($doctores as $doctor){
                    $auxAS = AnalisisSupervisor::where('analisis_id', $analisisId)->where('doctor_id', $doctor)->get();
                    if(count($auxAS) == 0){
                        $mDoctor = new AnalisisSupervisor();
                        $mDoctor->estado = AnalisisSupervisor::ESTADO_SIN_VERIFICAR;
                        $mDoctor->comentario = '';
                        $mDoctor->user_id = auth()->id();
                        $mDoctor->analisis_id = $analisisId;
                        $mDoctor->doctor_id = $doctor;
                        $mDoctor->save();
                    }
                }

            } else {
                foreach ($doctores as $doctor){
                    $mDoctor = new AnalisisSupervisor();
                    $mDoctor->estado = AnalisisSupervisor::ESTADO_SIN_VERIFICAR;
                    $mDoctor->comentario = '';
                    $mDoctor->user_id = auth()->id();
                    $mDoctor->analisis_id = $analisisId;
                    $mDoctor->doctor_id = $doctor;
                    $mDoctor->save();
                }
            }

        }
        $analisis->save();
        return response()->json(['success' => true, 'message' => 'Se actualizó correctamente la firma del supervisor.']);
    }

    public function ajaxSaveEstado(Request $request){
        $analisisSupervisadoId = $request->post('analisis_supervisor_id');
        $estado = $request->post('estado');
        $analisisSupervisor = AnalisisSupervisor::find($analisisSupervisadoId);
        if($estado){
            $analisisSupervisor->estado = AnalisisSupervisor::ESTADO_VERIFICADO;
        } else {
            $analisisSupervisor->estado = AnalisisSupervisor::ESTADO_SIN_VERIFICAR;
        }
        $analisisSupervisor->save();

        return response()->json(['success' => true, 'message' => 'Se actualizó correctamente el estado la firma del supervisor.']);
    }

}
