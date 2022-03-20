<?php

namespace App\Http\Controllers;

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
//        return view('invitado.home', compact('procedencias', 'tipoAnalisis', 'doctores', 'dateNow', 'date7'));
        $userId = auth()->id();
        $analisis = DB::table('invitados_analisis')
            ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
            ->join('persons', 'analisis.person_id', '=', 'persons.id')
            ->where('invitados_analisis.user_id', $userId)
            ->select('analisis.id', 'analisis.codigo', 'analisis.tipo_analisis', 'analisis.fecha', 'persons.nombres', 'persons.apellidos', 'persons.apellido_materno')->get();
        return view('invitado.home', compact('analisis'));
    }
}
