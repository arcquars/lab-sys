<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\Institucion;
use App\InvitadoAnalisis;
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

        $analisisAsignados = DB::table('invitados_analisis')->select('analisis_id')->where('user_id', $userId)->get();
        $aa = [];
        foreach ($analisisAsignados as $aasig){
            array_push($aa, $aasig->analisis_id);
        }
        $analisis = Analisis::where('doctor', 'like', '%'.$search.'%')->whereNotIn('id', $aa)->groupBy('doctor')->select('doctor')->get();
        return response()->json(['success'=>true, 'analisis' => $analisis]);
    }

    public function ajaxAsignarAnalisis(Request $request){
        $userId = $request->get('user_id');
        $doctores= $request->get('doctores')? $request->get('doctores') : [];

        $fechaI = Carbon::parse('Now -30 days');
        $fechaF = Carbon::now();

        if(count($doctores) > 0){
            foreach ($doctores as $doctor){
                $analisis = Analisis::where('doctor', 'like', $doctor)
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

        $doctoresAsignado = DB::table('invitados_analisis')
            ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
            ->where('invitados_analisis.user_id', '=', $userId)
            ->distinct()->select('analisis.doctor')->orderBy('analisis.doctor')->get();
        return response()->json(['success'=>true, 'doctores' => $doctoresAsignado]);
    }

    public function ajaxRemoveByDoctor(Request $request){
        $userId = $request->post('user_id');
        $doctor = $request->post('doctor');

        $invitadoAnalisis = DB::table('invitados_analisis')
            ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
            ->where('invitados_analisis.user_id', '=', $userId)
            ->where('analisis.doctor', '=', $doctor)
            ->select('invitados_analisis.id')->get();

        $ids = [];
        foreach ($invitadoAnalisis as $ia){
            array_push($ids, $ia->id);
        }

        InvitadoAnalisis::whereIn('id', $ids)->delete();

        return response()->json(['success'=>true]);
    }

    public function ajaxObtenerAnalisisAsignado(Request $request){
        $userId = $request->post('userId');
        $procedencia = $request->post('procedencia');

        $analisisAsignado = DB::table('invitados_analisis')
            ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
            ->where("analisis.tipo_analisis", 'not like', Analisis::INMUNOHISTOQUIMICA)
            ->where('invitados_analisis.user_id', '=', $userId)->count();

        $analisisAsignadoAProcedencia = DB::table('invitados_analisis')
            ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
            ->where('invitados_analisis.user_id', '=', $userId)
            ->where('analisis.procedencia', '=', $procedencia)->count();

        $analisisPorProcedencia = Analisis::where('procedencia', '=', $procedencia)
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

        $analisisAsignado = 0;
        foreach ($analisis as $ana) {
            DB::table('invitados_analisis')->insert(
                ['user_id' => $userId, 'analisis_id' => $ana->id]
            );
            $analisisAsignado++;
        }
        return response()->json(['success'=>true, 'result' => [
            'totalAnalisisAsignados' => $analisisAsignado
        ]]);
    }
}
