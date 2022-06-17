<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReporteAdminDesechoExport implements FromView
{
    protected $resultados;
    protected $rango;
    protected $fecha_ini;
    protected $fecha_fin;

    /**
     * ReporteAdminDiaExport constructor.
     */
    public function __construct($resultados, $rango, $fecha_ini, $fecha_fin)
    {
        $this->resultados = $resultados;
        $this->rango = $rango;
        $this->fecha_ini = $fecha_ini;
        $this->fecha_fin = $fecha_fin;
    }

    public function view(): View
    {
        return view('export-excel.reporteAdminDesecho', [
            'rango' => $this->rango,
            'resultados' => $this->resultados,
            'desde' => $this->fecha_ini,
            'hasta' => $this->fecha_fin,
        ]);
    }
}
