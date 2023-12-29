<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarkerPost extends FormRequest
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
        $roleName = 'required|min:5|max:200|unique:markers,name';
        if(isset($id)){
            $roleName = 'required|min:5|max:200|unique:markers,name,'.$id.',id';
        }
        return [
            'name' => $roleName,
            'description' => 'nullable|min:5',
        ];
    }
}
