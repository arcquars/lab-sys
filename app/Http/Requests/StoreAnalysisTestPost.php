<?php

namespace App\Http\Requests;

use App\AnalysisTest;
use Illuminate\Foundation\Http\FormRequest;

class StoreAnalysisTestPost extends FormRequest
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
        $rules = [
            'name' => 'required',
            'price' => 'required|numeric|min:0|max:1000',
            'group' => 'required',
            'type' => 'required',
        ];

        switch ($this->input('type')){
            case AnalysisTest::ANALYSIS_TEST_TYPE_RANGO:
                $this->valRange($rules);
                break;
            case AnalysisTest::ANALYSIS_TEST_TYPE_RANGO_SIN_ORDEN:
                $this->valRangeNoOrder($rules);
                break;

        }
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'name.required' => 'El nombre es obligatorio',
            'price.required'=> 'El precio es obligatorio',
            'price.numeric'=> 'El precio tiene que ser un numero',
            'price.min'=> 'El valor minimo tiene que ser 0',
            'price.max'=> 'El valor maximo tiene que ser 1000',
            'group.required' => 'El campo grupo es obligatorio',
            'type.required' => 'El campo tipo es obligatorio'
        ];
        switch ($this->input('type')){
            case AnalysisTest::ANALYSIS_TEST_TYPE_RANGO:
                $this->messageRange($messages);
                break;
            case AnalysisTest::ANALYSIS_TEST_TYPE_RANGO_SIN_ORDEN:
                $this->messageRangeNoOrder($messages);
                break;
        }
        return $messages;
    }

    public function valRange(&$rules){
        $rules['range.measure'] = "required";
        $rules['range.option'] = "present|array";
        if(is_array($this->input('range.option'))){
            foreach($this->input('range.option') as $key=>$value){
                $rules['range.option.'.$key.'.gender'] = 'required';

                $rules['range.option.'.$key.'.initial'] = 'required_with:'. 'range.option.'.$key.'.end' .'|numeric';
                $rules['range.option.'.$key.'.end'] = 'required_with:'.'range.option.'.$key.'.initial'.'|numeric|gt:'.'range.option.'.$key.'.initial';

                $rules['range.option.'.$key.'.age_initial'] = 'nullable|numeric';
                $rules['range.option.'.$key.'.age_end'] = 'required_with:'.'range.option.'.$key.'.age_initial'.'|gte:'.'range.option.'.$key.'.age_initial';
            }
        }
    }

    public function valRangeNoOrder(&$rules){
        $rules['range.measure'] = "required";
        $rules['range.option'] = "present|array";
        if(is_array($this->input('range.option'))){
            foreach($this->input('range.option') as $key=>$value){
                $rules['range.option.'.$key.'.gender'] = 'required';
                $rules['range.option.'.$key.'.age_initial'] = 'nullable|numeric';
                $rules['range.option.'.$key.'.age_end'] = 'required_with:'.'range.option.'.$key.'.age_initial'.'|gte:'.'range.option.'.$key.'.age_initial';

                $rules['range.option.'.$key.'.initial_text'] = 'string|min:3|max:150|nullable';
                $rules['range.option.'.$key.'.initial_value'] = 'required_with:'. 'range.option.'.$key.'.initial_text' .'|numeric|nullable';
//                $rules['range.option.'.$key.'.initial_color'] = 'required_with:'. 'range.option.'.$key.'.initial_text';

                $rules['range.option.'.$key.'.end_text'] = 'string|min:3|max:150|nullable';
                $rules['range.option.'.$key.'.end_value'] = 'required_with:'. 'range.option.'.$key.'.end_text' .'|numeric|nullable';
//                $rules['range.option.'.$key.'.end_color'] = 'required_with:'. 'range.option.'.$key.'.end_text';

                if(isset($value['intermediary']) && is_array($value['intermediary'])){
                    foreach($value['intermediary'] as $key1 =>$value1){
                        $rules['range.option.'.$key.'.intermediary.'.$key1.'.text'] = 'required';
                        $rules['range.option.'.$key.'.intermediary.'.$key1.'.range_initial'] = 'required|numeric|min:0|max:99999999';
                        $rules['range.option.'.$key.'.intermediary.'.$key1.'.range_end'] = 'required|numeric|min:0|max:99999999';
                    }
                }
            }
        }
    }

    public function messageRange(&$message)
    {
        $message['range.measure.required'] = "El campo unidad es requerido";
        $message['range.option.present'] = "El tipo Rango tiene que tener por lo menoss 1 opcion";
        $message['range.option.array'] = "El tipo Rango tiene que tener por lo menoss 1 opcion";
        if(is_array($this->input('range.option'))){
            foreach($this->input('range.option') as $key=>$value){
                $message['range.option.'.$key.'.gender.required'] = 'El campo Sexo es obligatorio.';

                $message['range.option.'.$key.'.initial.required_with'] = 'El campo Inicial es obligatorio cuando Final está presente.';
                $message['range.option.'.$key.'.initial.numeric'] = 'El campo Inicial debe ser un numero';

                $message['range.option.'.$key.'.end.required_with'] = 'El campo Final es obligatorio cuando Inicial está presente.';
                $message['range.option.'.$key.'.end.numeric'] = 'Final debe tener un numerico';
                $message['range.option.'.$key.'.end.gt'] = 'El campo Final debe ser mayor a Inicial';

                $message['range.option.'.$key.'.age_initial.nullable'] = 'El campo Edad Inicial puede ser nulo';
                $message['range.option.'.$key.'.age_initial.numeric'] = 'El campo Edad Inicial tiene que tener un valor numerico';

                $message['range.option.'.$key.'.age_end.required_with'] = 'El campo Edad Final es obligatorio cuando Edad Inicial está presente.';
                $message['range.option.'.$key.'.age_end.gte'] = 'El campo Edad Final debe ser mayor o igual a Edad inicial.';


            }
        }
    }

    public function messageRangeNoOrder(&$message)
    {
        $message['range.measure.required'] = "El campo unidad es requerido";
        $message['range.option.present'] = "El tipo Rango tiene que tener por lo menos 1 opcion";
        $message['range.option.array'] = "El tipo Rango tiene que tener por lo menos 1 opcion";
        if(is_array($this->input('range.option'))){
            foreach($this->input('range.option') as $key=>$value){
                $message['range.option.'.$key.'.gender.required'] = 'El campo Sexo es obligatorio.';

                $message['range.option.'.$key.'.age_initial.nullable'] = 'El campo Edad Inicial puede ser nulo';
                $message['range.option.'.$key.'.age_initial.numeric'] = 'El campo Edad Inicial tiene que tener un valor numerico';

                $message['range.option.'.$key.'.age_end.required_with'] = 'El campo Edad Final es obligatorio cuando Edad Inicial está presente.';
                $message['range.option.'.$key.'.age_end.gte'] = 'El campo Edad Final debe ser mayor o igual a Edad inicial.';

                $message['range.option.'.$key.'.initial_text.string'] = 'El campo tiene que ser una cadena de text';
                $message['range.option.'.$key.'.initial_text.min'] = 'El campo tiene que tener minimo 3 caracteres';
                $message['range.option.'.$key.'.initial_text.max'] = 'El campo tiene que tener maximo 150 caracteres';

                $message['range.option.'.$key.'.initial_value.required_with'] = 'El campo es obligatorio si el campo Texto tiene valor';
                $message['range.option.'.$key.'.initial_value.numeric'] = 'El campo tiene que tener un valor numerico';

//                $message['range.option.'.$key.'.initial_bookmark.required_with'] = 'El campo es obligatorio si el campo Texto tiene valor';

                $message['range.option.'.$key.'.end_text.string'] = 'El campo tiene que ser una cadena de text';
                $message['range.option.'.$key.'.end_text.min'] = 'El campo tiene que tener minimo 3 caracteres';
                $message['range.option.'.$key.'.end_text.max'] = 'El campo tiene que tener maximo 150 caracteres';

                $message['range.option.'.$key.'.end_value.required_with'] = 'El campo es obligatorio si el campo Texto tiene valor';
                $message['range.option.'.$key.'.end_value.numeric'] = 'El campo tiene que tener un valor numerico';

//                $message['range.option.'.$key.'.end_bookmark.required_with'] = 'El campo es obligatorio si el campo Texto tiene valor';

                if(isset($value['intermediary']) && is_array($value['intermediary'])){
                    foreach($value['intermediary'] as $key1 =>$value1){
                        $message['range.option.'.$key.'.intermediary.'.$key1.'.text.required'] = 'El campo es requerido';
                        $message['range.option.'.$key.'.intermediary.'.$key1.'.range_initial.required'] = 'El valor del campo es requerido';
                        $message['range.option.'.$key.'.intermediary.'.$key1.'.range_initial.numeric'] = 'El valor del campo tiene que ser un valor numerico';
                        $message['range.option.'.$key.'.intermediary.'.$key1.'.range_initial.min'] = 'El campo tiene que tener un valor minimo de cero';
                        $message['range.option.'.$key.'.intermediary.'.$key1.'.range_initial.max'] = 'El campo tiene que tener un valor maximo de 99999999';

                        $message['range.option.'.$key.'.intermediary.'.$key1.'.range_end.required'] = 'El valor del campo es requerido';
                        $message['range.option.'.$key.'.intermediary.'.$key1.'.range_end.numeric'] = 'El valor del campo tiene que ser un valor numerico';
                        $message['range.option.'.$key.'.intermediary.'.$key1.'.range_end.min'] = 'El campo tiene que tener un valor minimo de cero';
                        $message['range.option.'.$key.'.intermediary.'.$key1.'.range_end.max'] = 'El campo tiene que tener un valor maximo de 99999999';
                    }
                }

            }
        }
    }
}
