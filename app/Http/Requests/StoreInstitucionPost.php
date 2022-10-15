<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstitucionPost extends FormRequest
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
        $roleNombre = 'unique:instituciones,nombre|required';
        if(isset($id)){
            $roleNombre = 'required|unique:instituciones,nombre,'.$id.',id';
        }

        return [
            'nombre' => $roleNombre,
            'telefono' => 'required|digits:8'
        ];
    }
}
