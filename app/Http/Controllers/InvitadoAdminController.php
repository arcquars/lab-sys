<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\Institucion;
use App\InvitadoAnalisis;
use App\InvitadoAsignaciones;
use App\Role;
use App\User;
use Carbon\Carbon;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InvitadoAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $procedencias = Institucion::where('is_convenio', '=', 1)->get();

        $rol = Role::where('name', Role::INVITADO)->first();
        $users = User::join('role_user', 'users.id', '=', 'role_user.user_id')
            ->where('role_user.role_id', $rol->id)->select('users.id', 'users.name', 'users.email')->get();
//        return view('invitado.home', compact('procedencias', 'tipoAnalisis', 'doctores', 'dateNow', 'date7'));
        return view('invitado-admin.home', compact('users', 'procedencias'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function analisisAsignado($user_id)
    {
//        $user_id = 100;
        $user = User::find($user_id);
        InvitadoAnalisis::refreshAnalisisDoctor($user_id);
        return view('invitado-admin.invitado', compact( 'user_id', 'user'));
    }

    /**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getDatatablesData(Request $request)
    {
        $userId = $columns = $request->post('user_id');

        return Laratables::recordsOf(InvitadoAnalisis::class, function($query) use ($userId){
            return $query->where('invitados_analisis.user_id', $userId)
                ->where("analisis.tipo_analisis", 'not like', Analisis::INMUNOHISTOQUIMICA);
        });
    }

    /**
     * Display a listing of the ajaxCreateDoctor.
     *
     */
    public function ajaxSearcDr(Request $request){
        $userId = $request->get('user_id');
        $search = $request->get('search');

        $invitadoAsignaciones = InvitadoAsignaciones::where('user_id', $userId)->where('tipo', InvitadoAsignaciones::TIPO_PERSONA)->get();
        $doctoresAsig = [];
        foreach ($invitadoAsignaciones as $ia){
            $doctoresAsig[] = $ia->valor;
        }

        $analisis = Analisis::where('doctor', 'like', '%'.$search.'%')->whereNotIn('doctor', $doctoresAsig)->groupBy('doctor')->select('doctor')->get();
        return response()->json(['success'=>true, 'analisis' => $analisis]);
    }

    public function ajaxAsignarAnalisis(Request $request){
        $userId = $request->get('user_id');
        $doctores = $request->get('doctores')? $request->get('doctores') : [];

        $fechaI = Carbon::parse('Now -30 days');
        $fechaF = Carbon::now();

        $procedencia = Institucion::where('nombre', 'PERSONA PARTICULAR')->first();
        $particularId = $procedencia->id;

        if(count($doctores) > 0){
            foreach ($doctores as $doctor){
                $doctorExist = InvitadoAsignaciones::where('user_id',$userId)->where('valor', $doctor)->first();
                if(!$doctorExist){
                    $invitadoAsignaciones = new InvitadoAsignaciones();
                    $invitadoAsignaciones->fill(
                        [
                            'user_id' => $userId,
                            'tipo' => InvitadoAsignaciones::TIPO_PERSONA,
                            'valor' => $doctor

                        ]
                    );
                    $invitadoAsignaciones->save();
                }

                $analisis = Analisis::where('doctor', 'like', $doctor)
                    ->where('doctor', 'like', $doctor)
                    ->where('procedencia', '=', $particularId)
                    ->whereBetween('analisis.fecha', [$fechaI, $fechaF])
                    ->get();
                foreach ($analisis as $ana){
                    DB::table('invitados_analisis')->insert(
                        ['user_id' => $userId, 'analisis_id' => $ana->id]
                    );
                }
            }
        }
//        die();
        return response()->json(['success'=>true]);
    }

    public function ajaxRetirarAnalisis(Request $request){
        $userId = $request->post('user_id');
        $analisisId = $request->post('analisis_id');

        $resultado = DB::table('invitados_analisis')
            ->where('analisis_id', '=', $analisisId)
            ->where('user_id', '=', $userId)->delete();

        return response()->json(['success'=>$resultado]);
    }

    public function ajaxGetDrByDoctor(Request $request){
        $userId = $request->post('user_id');

        $invitadosAsignadosPersona = InvitadoAsignaciones::where('user_id', '=', $userId)
            ->where('tipo', '=', InvitadoAsignaciones::TIPO_PERSONA)->get();
        $invitadosAsignadosInstitucion = InvitadoAsignaciones::where('user_id', '=', $userId)
            ->where('tipo', '=', InvitadoAsignaciones::TIPO_INSTITUCION)->get();


        $asignados = [];
        foreach ($invitadosAsignadosPersona as $asigPersona){
            array_push($asignados, ['invitado_asignacion_id' => $asigPersona->id, 'nombre' => $asigPersona->tipo.' - '.$asigPersona->valor]);
        }

        foreach ($invitadosAsignadosInstitucion as $iaInstitucion){
            $institucion = Institucion::where('id', '=', $iaInstitucion->valor)->first();
            array_push($asignados, ['invitado_asignacion_id' => $iaInstitucion->id, 'nombre' => $iaInstitucion->tipo.' - '.$institucion->nombre]);
        }


        $doctoresAsignado = DB::table('invitados_analisis')
            ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
            ->where('invitados_analisis.user_id', '=', $userId)
            ->distinct()->select('analisis.doctor')->orderBy('analisis.doctor')->get();

        return response()->json(['success'=>true, 'doctores' => $doctoresAsignado, 'asignados' => $asignados]);
    }

    public function ajaxRemoveByDoctor(Request $request){
        $userId = $request->post('user_id');
        $asignado = $request->post('asignado');

        $invitadoAsignado = InvitadoAsignaciones::where('id', $asignado)->first();
        $invitadoAnalisis = null;
        if(strcmp($invitadoAsignado->tipo, InvitadoAsignaciones::TIPO_PERSONA) == 0){
            $procedencia = Institucion::where('nombre', 'PERSONA PARTICULAR')->first();
            $invitadoAnalisis = DB::table('invitados_analisis')
                ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
                ->where('invitados_analisis.user_id', '=', $userId)
                ->where('analisis.doctor', '=', $invitadoAsignado->valor)
                ->where('analisis.procedencia', '=', $procedencia->id)
                ->select('invitados_analisis.id')->get();
        } else {
            $invitadoAnalisis = DB::table('invitados_analisis')
                ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
                ->where('invitados_analisis.user_id', '=', $userId)
                ->where('analisis.procedencia', '=', $invitadoAsignado->valor)
                ->select('invitados_analisis.id')->get();
        }

        $ids = [];
        foreach ($invitadoAnalisis as $ia){
            array_push($ids, $ia->id);
        }

        InvitadoAnalisis::whereIn('id', $ids)->delete();
        InvitadoAsignaciones::where('id', $asignado)->delete();

        return response()->json(['success'=>true]);
    }

    public function ajaxObtenerAnalisisAsignado(Request $request){
        $userId = $request->post('userId');
        $procedencia = $request->post('procedencia');

//        $fechaI = Carbon::parse('Now -30 days');
//        $fechaF = Carbon::now();

        $analisisAsignado = DB::table('invitados_analisis')
            ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
            ->where("analisis.tipo_analisis", 'not like', Analisis::INMUNOHISTOQUIMICA)
            ->where('invitados_analisis.user_id', '=', $userId)->count();

        $analisisAsignadoAProcedencia = DB::table('invitados_analisis')
            ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
            ->where('invitados_analisis.user_id', '=', $userId)
            ->where('analisis.procedencia', '=', $procedencia)->count();

        $analisisPorProcedencia = Analisis::where('procedencia', '=', $procedencia)
//            ->whereBetween('fecha', [$fechaI, $fechaF])
            ->where("tipo_analisis", 'not like', Analisis::INMUNOHISTOQUIMICA)->count();

        return response()->json(['success'=>true,
            'result' => [
                'totalAnalisisAsignados' => $analisisAsignado,
                'totalAnalisisAsignadoAProcedencia' => $analisisAsignadoAProcedencia,
                'totalAnalisisPorProcedencia' => $analisisPorProcedencia
            ]]);
    }

    public function ajaxAsignarAnalisisProcedencia(Request $request){
        $userId = $request->get('user_id');
        $procedencia = $request->post('procedencia');

        $fechaI = Carbon::parse('Now -30 days');
        $fechaF = Carbon::now();


        $exist = InvitadoAsignaciones::where('valor', '=', $procedencia)->first();

        $analisisAsignado = 0;
        if(!$exist){
            $invitadoAsignaciones = new InvitadoAsignaciones();
            $invitadoAsignaciones->fill(
                [
                    'user_id' => $userId,
                    'tipo' => InvitadoAsignaciones::TIPO_INSTITUCION,
                    'valor' => $procedencia
                ]
            );
            $invitadoAsignaciones->save();

            $analisisAsignadoAProcedencia = DB::table('invitados_analisis')
                ->select('analisis.id as analisis_id')
                ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
                ->where('invitados_analisis.user_id', '=', $userId)
                ->where('analisis.procedencia', '=', $procedencia)->get();

            $ids = [];
            foreach ($analisisAsignadoAProcedencia as $aaap){
                array_push($ids, $aaap->analisis_id);
            }

//        $analisis = Analisis::whereNotIn('id', $ids)->get();
            $analisis = Analisis::whereNotIn('id', $ids)->where('procedencia', '=', $procedencia)
                ->where("tipo_analisis", 'not like', Analisis::INMUNOHISTOQUIMICA)
                ->whereBetween('analisis.fecha', [$fechaI, $fechaF])
                ->get();


            foreach ($analisis as $ana) {
                DB::table('invitados_analisis')->insert(
                    ['user_id' => $userId, 'analisis_id' => $ana->id]
                );
                $analisisAsignado++;
            }
        }

        return response()->json(['success'=>true, 'result' => [
            'totalAnalisisAsignados' => $analisisAsignado
        ]]);
    }
}
