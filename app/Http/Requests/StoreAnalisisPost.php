<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Config;

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
        $procedencia = $this->input('procedencia');

        $convenios = explode(',', Config::get('clinica.convenios_id'));
        if(count($convenios) == 0){
            $convenios = [Config::get('clinica.convenios_id')];
        }

        $rulesR = [
            'doctor' => 'required|min:5|max:200|countWordRule',
            'procedencia' => 'required',
            'tipo_analisis' => 'required',
            'fecha' => 'required',
            'doctor_asignado' => 'required',
            'telefono_referencia' => 'numeric',
            'region' => 'required|max:200',
            'precio' => 'required|numeric|min:0|max:10000',
            'acuenta' => 'lte:precio|nullable',
            'nit' => 'numeric',
        ];

        for ($i=0; $i<count($convenios); $i++){
            if($procedencia == $convenios[$i]){
                $rulesR = [
                    'doctor' => 'required|min:5|max:200',
                    'procedencia' => 'required',
                    'tipo_analisis' => 'required',
                    'doctor_asignado' => 'required',
                    'fecha' => 'required',
                    'region' => 'required|max:200',
                    'precio' => 'required|numeric|min:1',
                    'acuenta' => 'lt:precio|nullable',
                    'bancaMatricula' => 'required',
                ];
                break;
            }
        }
        return $rulesR;
    }
}
