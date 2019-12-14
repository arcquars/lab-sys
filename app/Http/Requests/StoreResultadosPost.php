<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResultadosPost extends FormRequest
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
            'papanicolaou_clase1' => 'required',
            'papanicolaou_clase2' => 'required'
        ];
    }

    public function messages(){
        return [
            'papanicolaou_clase1.required' => 'Este campo es obligatorio.',
            'papanicolaou_clase2.required' => 'Este campo es obligatorio.'
        ];
    }
}
