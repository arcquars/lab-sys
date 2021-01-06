<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBiopsiaPost extends FormRequest
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
            'organo_tejido' => 'nullable|string|max:30000',
            'macroscopia' => 'nullable|string|max:30000',
            'microscopia' => 'nullable|string|max:30000',
            'diagnostico' => 'nullable|string|max:30000',
//            '' => '',
//            '' => '',
//            '' => '',

        ];
    }
}
