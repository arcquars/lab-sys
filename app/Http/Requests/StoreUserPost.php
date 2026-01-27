<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Importamos la clase Rule

class StoreUserPost extends FormRequest
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
        $id = $this->route('user');
        
        $emailUniqueRule = Rule::unique('users', 'email')->whereNull('deleted_at');

        $pass = 'required|min:6|nullable|confirmed';
        $pass_c = 'required|min:6|nullable';

        if (isset($id)) {
            $emailUniqueRule->ignore($id);
            
            $pass = 'min:6|nullable|confirmed';
            $pass_c = 'min:6|nullable';
        }

        return [
            'name' => 'required|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                $emailUniqueRule // Aplicamos la regla compleja aquí
            ],
            'roles' => 'required',
            'password' => $pass,
            'password_confirmation' => $pass_c
        ];
    }
}