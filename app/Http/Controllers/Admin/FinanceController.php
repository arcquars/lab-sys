<?php

namespace App\Http\Controllers\Admin;

use App\CashMovement;
use App\Http\Controllers\Controller;
use App\Concept;
use App\Exports\CashMovementExport;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Excel;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        // Filtros de fecha (Por defecto mes actual)
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Consulta base
        $query = CashMovement::with(['concept', 'user'])
            ->where('user_id', Auth::id())
            ->whereBetween('movement_date', [$startDate, $endDate])
            ->orderBy('movement_date', 'desc')
            ->orderBy('created_at', 'desc');

        $movements = $query->get();

        // Calculo de Totales
        $totalIncome = $movements->where('type', CashMovement::TYPE_INCOME)->sum('amount');
        $totalExpense = $movements->where('type', CashMovement::TYPE_EXPENSE)->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('finance.index', [
            'movements' => $movements,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    public function create()
    {
        $concepts = Concept::where('active', true)->get();
        return view('finance.create', compact('concepts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'concept_id' => 'required|exists:concepts,id',
            'movement_date' => 'required|date',
            'payment_method' => 'required|string',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $concept = Concept::find($request->concept_id);

            $movement = new CashMovement();
            $movement->amount = $request->amount;
            $movement->type = $concept->type; // El tipo lo define el concepto seleccionado
            $movement->concept_id = $concept->id;
            $movement->movement_date = $request->movement_date;
            $movement->payment_method = $request->payment_method;
            $movement->description = $request->description;
            $movement->user_id = Auth::id();
            
            $movement->save();

            DB::commit();

            return redirect('admin/finance')->with('success', 'Movimiento registrado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->with('error', 'Error al guardar el movimiento: ' . $e->getMessage())->withInput();
        }
    }
    
    // Método para eliminar (soft delete recomendado, pero aquí hacemos hard delete como en tu CustomerController)
    public function destroy($id)
    {
        try {
            $cashMovement = CashMovement::find($id);
            if (!$cashMovement) {
                return redirect('admin/finance')->with('error', 'Movimiento no encontrado.');
            }
            if (Carbon::parse($cashMovement->movement_date)->isToday()) {
                $cashMovement->delete();
                return redirect('admin/finance')->with('success', 'Movimiento eliminado.');
            } 

            // 3. Si no es de hoy, devolvemos el error
            return redirect('admin/finance')->with('error', 'Solo puede eliminar movimientos realizados el día de hoy.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo eliminar.');
        }
    }

    public function exportExcel($fechaIni, $fechaFin, $userId){
        if(!Auth::user()->hasRole(Role::ADMIN) || Auth::id() != $userId){
            return redirect('admin/finance')->with('error', 'Sin acceso al reporte.');
        }
        return Excel::download(
            new CashMovementExport($fechaIni, $fechaFin, $userId), 
            'reporte-financila'.date('Ymd').'.xlsx');
    }
}
