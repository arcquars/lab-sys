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
        $receiptPrint = Setting::get('receipt_print', '0');
        $showCodeIntPdf = Setting::get('code_internal_print', '0');
        $createAnalisisUi = Setting::get('create_analisis_ui', 'Clasico');
        return view(
            'admin.config.home', 
            compact('metodo', 'receiptPrint', 'showCodeIntPdf', 'createAnalisisUi')
        );
    }

    public function save(Request $request)
    {
        // Guardamos el valor usando el método set definido anteriormente
        Setting::set('metodo_analisis', $request->input('metodo'));
        Setting::set('receipt_print', $request->input('receipt_print'));
        Setting::set('code_internal_print', $request->input('code_internal_print'));
        Setting::set('create_analisis_ui', $request->input('create_analisis_ui'));

        return back()->with('success', 'Configuración actualizada correctamente');
    }
}
