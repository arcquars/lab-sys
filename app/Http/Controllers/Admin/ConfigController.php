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
        $colorOutRange = Setting::get('color_out_range', '#dc3545');
        return view(
            'admin.config.home', 
            compact(
                'metodo', 
                'receiptPrint', 
                'showCodeIntPdf', 'createAnalisisUi',
                'colorOutRange'
            )
        );
    }

    public function save(Request $request)
    {
        // Guardamos el valor usando el método set definido anteriormente
        Setting::set('metodo_analisis', $request->input('metodo'));
        Setting::set('receipt_print', $request->input('receipt_print'));
        Setting::set('code_internal_print', $request->input('code_internal_print'));
        Setting::set('create_analisis_ui', $request->input('create_analisis_ui'));
        Setting::set('color_out_range', $request->has('color_out_range')? $request->input('color_out_range') : '#dc3545');

        return back()->with('success', 'Configuración actualizada correctamente');
    }
}
