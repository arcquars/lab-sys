<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
//        dd($id);
        $email = 'required|email|unique:users,email|max:255';
        $pass = 'required|min:6|nullable|confirmed';
        $pass_c = 'required|min:6|nullable';
        if(isset($id)){
            $email = 'required|email|unique:users,email,'.$id.'|max:255';
            $pass = 'min:6|nullable|confirmed';
            $pass_c = 'min:6|nullable';
        }

        return [
            'name' => 'required|max:255',
            'email' => $email,
            'roles' => 'required',
            'password' => $pass,
            'password_confirmation' => $pass_c
        ];
    }
}
