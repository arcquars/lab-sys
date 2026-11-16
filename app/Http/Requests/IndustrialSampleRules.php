<?php

namespace App\Http\Requests;

use App\Analisis;

trait IndustrialSampleRules
{
    public function industrialSelected()
    {
        return in_array($this->input('is_industrial'), [true, 1, '1'], true);
    }

    protected function industrialRules($tipoAnalisis)
    {
        $rules = [
            'is_industrial' => ['sometimes', 'boolean', function ($attribute, $value, $fail) use ($tipoAnalisis) {
                if ($this->industrialSelected() && $tipoAnalisis !== Analisis::PRUEBA) {
                    $fail('Muestra industrial solo está disponible para análisis LABCI.');
                }
            }],
        ];

        if ($this->industrialSelected()) {
            $rules += [
                'product_name' => 'required|string|max:250',
                'rehearsal_date' => 'required|date_format:Y-m-d',
                'lot_number' => 'nullable|string|max:250',
                'manufacture_date' => 'nullable|date_format:Y-m-d',
                'expiration_date' => 'nullable|date_format:Y-m-d',
            ];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'is_industrial' => 'Muestra industrial',
            'product_name' => 'Producto',
            'rehearsal_date' => 'Fecha de ensayo',
            'lot_number' => 'Nro. de lote',
            'manufacture_date' => 'Fecha de fabricación',
            'expiration_date' => 'Fecha de vencimiento',
        ];
    }
}
