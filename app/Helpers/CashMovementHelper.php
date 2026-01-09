<?php


namespace App\Helpers;

use App\CashMovement;
use App\Concept;


class CashMovementHelper
{

    public static function createMovement($amount, $type, $paymentMethod, $description, $source)
    {
        // Buscar concepto por defecto según el tipo
        $defaultConcept = Concept::where('name', $type == 'INGRESO' ? 'Cobro de Consulta' : 'Gastos Operativos')->first();

        CashMovement::create([
            'amount' => $amount,
            'type' => $type,
            'payment_method' => $paymentMethod,
            'description' => $description,
            'source_type' => get_class($source),
            'source_id' => $source->id,
            'user_id' => Auth::id(),
            'movement_date' => now(),
            'concept_id' => $defaultConcept ? $defaultConcept->id : null
        ]);
    }
}