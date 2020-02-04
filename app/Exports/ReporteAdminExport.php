<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReporteAdminExport implements FromView
{
    protected $resultados;
    protected $institucion;

    /**
     * ReporteAdminExport constructor.
     */
    public function __construct($resultados, $institucion)
    {
        $this->resultados = $resultados;
        $this->institucion = $institucion;
    }

    public function view(): View
    {
        return view('export-excel.reporteAdmin', [
            'resultados' => $this->resultados,
            'institucion' => $this->institucion
        ]);
    }
}