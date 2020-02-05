<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReporteAdminDiaExport implements FromView
{
    protected $resultados;
    protected $desde;
    protected $hasta;
    protected $institucion;

    /**
     * ReporteAdminDiaExport constructor.
     */
    public function __construct($resultados, $desde, $hasta, $institucion)
    {
        $this->resultados = $resultados;
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->institucion = $institucion;
    }

    public function view(): View
    {
        return view('export-excel.reporteAdminDia', [
            'resultados' => $this->resultados,
            'desde' => $this->desde,
            'hasta' => $this->hasta,
            'institucion' => $this->institucion
        ]);
    }
}