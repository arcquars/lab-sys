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
        // $roleNombre = 'unique:instituciones,nombre|required';
        $roleNombre = [
            'required',
            'string',
            'max:255',
            // Regla: Único en la tabla 'instituciones', columna 'nombre'
            // PERO solo donde deleted_at sea NULL (registros activos)
            Rule::unique('instituciones')->whereNull('deleted_at'),
        ]
        
        if(isset($id)){
            $roleNombre = [
                'required',
                Rule::unique('instituciones')
                    ->ignore($id) // Ignorar el registro actual
                    ->whereNull('deleted_at') // Solo validar contra activos
            ];
        }

        return [
            'nombre' => $roleNombre,
            'telefono' => 'required|digits:8'
        ];
    }
}
