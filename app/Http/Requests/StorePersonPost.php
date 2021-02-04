<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonPost extends FormRequest
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
        $id = $this->input('id');
        $roleCi = 'unique:persons,ci|nullable|numeric';
        $roleNombres = 'required|';

        if(isset($id)){
            $roleCi = 'nullable|numeric|unique:persons,ci,'.$id.',id';
        }
        return [
            'ci' => $roleCi,
            'nombres' => $roleNombres,
            'apellidos' => 'required',
            'f_nacimiento' => 'nullable|date',
            'sexo' => 'required'
        ];
    }
}
