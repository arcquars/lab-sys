<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index(Request $request)
    {
        $metodo = Setting::get('metodo_analisis', '1');
        return view('admin.config.home', compact('metodo'));
    }

    public function save(Request $request)
    {
        // Guardamos el valor usando el método set definido anteriormente
        Setting::set('metodo_analisis', $request->input('metodo'));

        return back()->with('success', 'Configuración actualizada correctamente');
    }
}
