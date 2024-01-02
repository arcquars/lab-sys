<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHistoPost extends FormRequest
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
            'interpretacion' => 'nullable|string|max:30000',
            'tecnica' => 'nullable|string|max:30000',
            'bibliografia' => 'nullable|string|max:30000',
            'region' => 'required|max:255   '
        ];
    }
}
