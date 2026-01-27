<?php

namespace App\Exports;

use App\CashMovement;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class CashMovementExport implements FromView
{
    use Exportable;

    private $startDate;
    private $endDate;
    private $userId;

    public function __construct($startDate, $endDate, $userId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->userId = $userId;
    }
    
    public function view(): View
    {
        $query = CashMovement::query()->whereBetween('movement_date', [$this->startDate, $this->endDate]);
        if($this->userId){
            $query->where('user_id', $this->userId);
        }
        return view('export-excel.cash-movement-report', [
            'cashMovements' => $query->orderBy('movement_date', 'desc')->get()
        ]);
    }
}
