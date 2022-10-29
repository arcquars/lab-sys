<?php

namespace App\Http\Controllers;

use App\Analisis;
use App\InvitadoAnalisis;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InvitadoController extends Controller
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
//        $fecha_ini = date('Y-m-d', strtotime('-300 days'));
//        $fecha_fin = date('Y-m-d');
//        $userId = auth()->id();
//        $analisis = DB::table('invitados_analisis')
//            ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
//            ->join('persons', 'analisis.person_id', '=', 'persons.id')
//            ->where('invitados_analisis.user_id', $userId)
//            ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
//            ->where('analisis.imprimir_firma', '=',1)
////            ->whereNotNull('analisis.persona_entrega')
//            ->where("analisis.tipo_analisis", 'not like', Analisis::INMUNOHISTOQUIMICA)
//            ->take(30)
//            ->orderBy('fecha', 'desc')
//            ->select('analisis.id', 'analisis.codigo', 'analisis.tipo_analisis', 'analisis.fecha', 'persons.nombres', 'persons.apellidos', 'persons.apellido_materno')->get();
        return view('invitado.home');
    }

    /**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getDatatablesData(Request $request)
    {
        $columns = $request->get('columns');
        $searchG = $request->get('search')['value'];

        $fecha_ini = date('Y-m-d', strtotime('-30 days'));
        $fecha_fin = date('Y-m-d');
        $userId = auth()->id();

//        $searchNombres = isset($columns[2]['search']['value'])? $columns[2]['search']['value'] : '';
//        $searchApellidos = isset($columns[3]['search']['value'])? $columns[3]['search']['value'] : '';
//        $searchDoctorId = isset($columns[8]['search']['value'])? $columns[8]['search']['value'] : '';

        return Laratables::recordsOf(InvitadoAnalisis::class, function($query) use ($fecha_ini, $fecha_fin, $userId){
            return $query->where('invitados_analisis.user_id', $userId)
                ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
                ->where('analisis.imprimir_firma', '=',1)
                ->where("analisis.tipo_analisis", 'not like', Analisis::INMUNOHISTOQUIMICA);
        });
    }
}
