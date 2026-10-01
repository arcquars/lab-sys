<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePreOrderRequest;
use App\PreOrder;
use Illuminate\Support\Facades\DB;

class PreOrderController extends Controller
{
    /**
     * POST /pre-orders
     *
     * Crea un pre-orden a partir del payload validado por StorePreOrderRequest.
     * Devuelve 201 con order_number + issued_at, o 422 si la validación falla.
     */
    public function store(StorePreOrderRequest $request)
    {
        $data   = $request->validated();
        $userId = $request->user()->id;
        $year   = (int) date('Y');
        $yy     = substr((string) $year, -2);

        $preOrder = DB::transaction(function () use ($data, $userId, $year, $yy) {
            $seq = $this->nextCounterSeq('pre_order', $year);

            $preOrder = PreOrder::create([
                'order_number'        => sprintf('ORD-%s-%04d', $yy, $seq),
                'branch_id'           => $data['branch_id'],
                'is_stat'             => $data['is_stat'],

                'patient_full_name'   => $data['patient']['full_name'],
                'patient_age'         => $data['patient']['age'] ?? null,
                'patient_gender'      => $data['patient']['gender'],
                'patient_ci'          => $data['patient']['ci'],
                'patient_birth_date'  => $data['patient']['birth_date'] ?? null,
                'patient_diagnosis'   => $data['patient']['diagnosis'] ?? null,
                'patient_physician'   => $data['patient']['physician'] ?? null,

                'tests_snapshot'      => $data['tests'],
                'state'               => PreOrder::STATE_NUEVO,
                'created_by'          => $userId,
            ]);

            $preOrder->statesLog()->create([
                'previous_state' => null,
                'new_state'      => PreOrder::STATE_NUEVO,
                'user_id'        => $userId,
            ]);

            return $preOrder;
        });

        return response()->json([
            'order_number' => $preOrder->order_number,
            'issued_at'    => $preOrder->created_at->format('c'),
        ], 201);
    }

    /**
     * Incrementa atómicamente el counter (name, year) y devuelve el valor nuevo.
     *
     * MySQL: usa INSERT ... ON DUPLICATE KEY UPDATE dentro de la transacción
     * (atomicidad garantizada con rollback si la transacción global falla).
     */
    private function nextCounterSeq($name, $year)
    {
        DB::statement(
            "INSERT INTO counters (name, year, value, created_at, updated_at)
             VALUES (?, ?, 1, NOW(), NOW())
             ON DUPLICATE KEY UPDATE value = value + 1",
            [$name, $year]
        );

        $row = DB::table('counters')
            ->where('name', $name)
            ->where('year', $year)
            ->first();

        return (int) $row->value;
    }
}
