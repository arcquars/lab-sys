<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReporteAdminDiaConvenioExport implements FromView
{
    protected $resultados;
    protected $desde;
    protected $hasta;

    /**
     * ReporteAdminDiaExport constructor.
     */
    public function __construct($resultados, $desde, $hasta)
    {
        $this->resultados = $resultados;
        $this->desde = $desde;
        $this->hasta = $hasta;
    }

    public function view(): View
    {
        return view('export-excel.reporteAdminConvenioDia', [
            'resultados' => $this->resultados,
            'desde' => $this->desde,
            'hasta' => $this->hasta
        ]);
    }
}