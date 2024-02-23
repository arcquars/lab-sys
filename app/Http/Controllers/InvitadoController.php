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
        $userId = auth()->id();
        InvitadoAnalisis::refreshAnalisisDoctor($userId);
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

        $searchNombres = isset($columns[2]['search']['value'])? $columns[2]['search']['value'] : '';
        $searchApellido = isset($columns[3]['search']['value'])? $columns[3]['search']['value'] : '';

        $fecha_ini = date('Y-m-d', strtotime('-30 days'));
        $fecha_fin = date('Y-m-d');
        $userId = auth()->id();

        return Laratables::recordsOf(InvitadoAnalisis::class, function($query) use ($fecha_ini, $fecha_fin, $userId, $searchNombres, $searchApellido){
            return $query->where('invitados_analisis.user_id', $userId)
                ->whereBetween('fecha', [$fecha_ini, $fecha_fin])
                ->where('analisis.imprimir_firma', '=',1)
//                ->where("analisis.tipo_analisis", 'not like', Analisis::INMUNOHISTOQUIMICA)
                ->whereHas('analisis', function($q) use ($searchNombres, $searchApellido)
                {
                    $q->whereHas('person', function($q1) use ($searchNombres, $searchApellido)
                    {
                        $q1->where('nombres', 'like', '%'.$searchNombres.'%')
                            ->where('apellidos', 'like', '%'.$searchApellido.'%');
//                        $q1->orWhere('apellidos', 'like', '%'.$searchApellido.'%');
                    });
                });
        });
    }
}
