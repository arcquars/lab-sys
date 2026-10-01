<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePreOrderRequest extends FormRequest
{
    public function authorize()
    {
        return \Auth::check();
    }

    public function rules()
    {
        return [
            'branch_id'                  => 'required|string|max:80',
            'is_stat'                    => 'required|boolean',

            'patient.full_name'          => 'required|string|max:255',
            'patient.age'                => 'nullable|string|max:50',
            'patient.gender'             => 'required|string|in:F,M,O',
            'patient.ci'                 => 'required|string|max:30',
            'patient.birth_date'         => 'nullable|date_format:Y-m-d',
            'patient.diagnosis'          => 'nullable|string|max:500',
            'patient.physician'          => 'nullable|string|max:200',

            'tests'                      => 'required|array|min:1|max:50',
            'tests.*.id'                 => 'required|string|max:40',
            'tests.*.test_name'          => 'required|string|max:200',
            'tests.*.category_name'      => 'required|string|max:120',
        ];
    }

    public function messages()
    {
        return [
            'branch_id.required'            => 'El campo branch_id es obligatorio.',
            'branch_id.max'                 => 'branch_id no debe exceder 80 caracteres.',

            'is_stat.required'              => 'El campo is_stat es obligatorio.',
            'is_stat.boolean'               => 'is_stat debe ser verdadero o falso.',

            'patient.full_name.required'    => 'El nombre del paciente es obligatorio.',
            'patient.gender.required'       => 'El género del paciente es obligatorio.',
            'patient.gender.in'             => 'El género debe ser F, M u O.',
            'patient.ci.required'           => 'El CI del paciente es obligatorio.',
            'patient.birth_date.date_format'=> 'La fecha de nacimiento debe tener formato YYYY-MM-DD.',

            'tests.required'                => 'Debe incluir al menos un test.',
            'tests.min'                     => 'Debe incluir al menos un test.',
            'tests.*.id.required'           => 'Cada test debe incluir un id.',
            'tests.*.test_name.required'    => 'Cada test debe incluir un nombre.',
            'tests.*.category_name.required'=> 'Cada test debe incluir un nombre de categoría.',
        ];
    }
}
