<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Analisis;

class UpdateAnalisisPost extends FormRequest
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
        $rulesR = [
            'edad' => 'nullable|numeric|min:0|max:110',
            'doctor' => 'required',
            'procedencia' => 'required',
            'telefono_referencia' => 'nullable|max:14|min:5',
            'doctor_asignado' => 'required',
            'fecha' => 'nullable|date',
            'precio' => 'nullable|numeric|min:0|max:10000',
            'acuenta' => 'nullable|lte:precio',
        ];

        // El formulario tipo carrito (v2) siempre envia el campo oculto
        // "tipo_analisis" (PRUEBA), incluso si el usuario desmarco todos los
        // checkboxes (en cuyo caso "aTests"/"aGroup" ni siquiera llegan en el
        // request, ya que los checkboxes sin marcar no se envian). Por eso
        // validamos igual que StoreAnalisisPost: en base al "tipo_analisis" que
        // llega en el request, no en base a si la clave "aTests" esta presente.
        // El formulario clasico no incluye "tipo_analisis", por lo que esta
        // regla nunca se activa para el.
        $tipoAnalisis = $this->input('tipo_analisis');
        if($tipoAnalisis && strcmp($tipoAnalisis, Analisis::PRUEBA) == 0
            && $this->input('aTests') == null && $this->input('aGroup') == null){
            $rulesR['aTests'] = 'required';
        }

        return $rulesR;
    }
}
