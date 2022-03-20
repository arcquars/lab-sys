<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\Role;
use App\User;
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
        $users = User::join('role_user', 'users.id', '=', 'role_user.user_id')
            ->where('role_user.role_id', 5)->select('users.id', 'users.name', 'users.email')->get();
//        return view('invitado.home', compact('procedencias', 'tipoAnalisis', 'doctores', 'dateNow', 'date7'));
        return view('invitado-admin.home', compact('users'));
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
        $analisis = DB::table('invitados_analisis')
            ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
            ->join('persons', 'analisis.person_id', '=', 'persons.id')
            ->where('invitados_analisis.user_id', $user_id)
        ->select('analisis.id', 'analisis.codigo', 'analisis.tipo_analisis', 'analisis.fecha', 'persons.nombres', 'persons.apellidos', 'persons.apellido_materno')->get();

        return view('invitado-admin.invitado', compact('analisis', 'user_id', 'user'));
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
        $analisis = Analisis::where('doctor', 'like', '%'.$search.'%')->whereNotIn('id', $aa)->get();
        return response()->json(['success'=>true, 'analisis' => $analisis]);
    }

    public function ajaxAsignarAnalisis(Request $request){
        $userId = $request->get('user_id');
        $analisis = $request->get('analisis')? $request->get('analisis') : [];

        if(count($analisis) > 0){
            foreach ($analisis as $a){
                DB::table('invitados_analisis')->insert(
                    ['user_id' => $userId, 'analisis_id' => $a]
                );
            }
        }
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
}
