<?php

namespace App\Http\Controllers;

use App\AnalisisSupervisor;
use App\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public $layout = 'layouts.dash';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index2');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $dateF = Carbon::now();
//        $dateI = Carbon::now()->subDays(30);
        $dateI = Carbon::now()->firstOfMonth();
        if($dateF->diff($dateI)->days == 0){
            $dateF = $dateF->addDays(1);
        }
        $analisisSupervisados = 0;
        if(Auth::user()->hasRole(Role::MEDICO) && Auth::user()->person){
            $analisisSupervisados = AnalisisSupervisor::where('doctor_id', Auth::user()->person)
            ->where('estado', 'like', AnalisisSupervisor::ESTADO_SIN_VERIFICAR)->count();
        }

        return view('home', compact('dateI', 'dateF', 'analisisSupervisados'));
    }

    public function index2(){
        return view('index');
    }
}
