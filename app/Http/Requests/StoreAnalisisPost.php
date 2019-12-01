<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnalisisPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'doctor' => 'required|min:5|max:200',
            'procedencia' => 'required',
            'tipo_analisis' => 'required',
            'fecha' => 'required',
            'region' => 'required|max:200',
            'precio' => 'required|numeric|min:1',
            'acuenta' => 'lt:precio|nullable',
        ];
    }
}
