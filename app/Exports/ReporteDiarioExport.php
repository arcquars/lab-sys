<?php


namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReporteDiarioExport implements FromView
{

    protected $analisis;
    protected $gastos;
    protected $totalPrecio;
    protected $totalAcuenta;
    protected $totalDebe;
    protected $totalGastos;

    /**
     * ReporteDiarioExport constructor.
     */
    public function __construct($analisis, $gastos, $totalPrecio,
                                $totalAcuenta, $totalDebe, $totalGastos
    )
    {
        $this->analisis = $analisis;
        $this->gastos = $gastos;
        $this->totalPrecio = $totalPrecio;
        $this->totalAcuenta = $totalAcuenta;
        $this->totalDebe = $totalDebe;
        $this->totalGastos = $totalGastos;
    }

    public function view(): View
    {
        return view('export-excel.reporteDiario', [
            'analisis' => $this->analisis,
            'gastos' => $this->gastos, 'totalPrecio' => $this->totalPrecio,
            'totalAcuenta' => $this->totalAcuenta, 'totalDebe' => $this->totalDebe,
            'totalGastos' => $this->totalGastos
        ]);
    }
}