<?php

namespace Tests\Unit;

use App\Analisis;
use App\Http\Requests\StoreAnalisisPost;
use App\Http\Requests\UpdateAnalisisPost;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class IndustrialSampleValidationTest extends TestCase
{
    private function payload(array $overrides = [])
    {
        return array_merge([
            'tipo_analisis' => Analisis::PRUEBA, 'doctor' => 'Doctor Solicitante',
            'procedencia' => 1, 'doctor_asignado' => 5, 'fecha' => date('Y-m-d'),
            'precio' => 100, 'aTests' => [1], 'is_industrial' => '1',
            'product_name' => 'Agua de proceso', 'rehearsal_date' => '2026-11-10',
        ], $overrides);
    }

    private function validator(array $data, $updating = false, $type = Analisis::PRUEBA, $industrial = false)
    {
        config(['clinica.convenios_id' => '99']);
        if ($updating) {
            $request = new class extends UpdateAnalisisPost {
                public $analysis;

                protected function analisisForIndustrialValidation()
                {
                    return $this->analysis;
                }
            };
            $request->analysis = new Analisis(['tipo_analisis' => $type]);
            $request->analysis->is_industrial = $industrial;
        } else {
            $request = new StoreAnalisisPost();
        }
        $request->merge($data);

        return Validator::make($request->all(), $request->rules(), [], $request->attributes());
    }

    public function testMinimumIndustrialDataAndNullableFieldsAreValidInBothRequests()
    {
        foreach ([false, true] as $updating) {
            $this->assertTrue($this->validator($this->payload([
                'lot_number' => null, 'manufacture_date' => null, 'expiration_date' => null,
                'edad' => 'IGNORADA',
            ]), $updating)->passes());
        }
    }

    public function testRequiredIndustrialFieldsAreNotLostForConvenios()
    {
        foreach ([1, 99] as $procedencia) {
            foreach ([false, true] as $updating) {
                $validator = $this->validator($this->payload([
                    'procedencia' => $procedencia, 'region' => 'Muestra', 'bancaMatricula' => 'ABC',
                    'product_name' => '   ', 'rehearsal_date' => null,
                ]), $updating);
                $this->assertTrue($validator->fails());
                $this->assertTrue($validator->errors()->has('product_name'));
                $this->assertTrue($validator->errors()->has('rehearsal_date'));
            }
        }
    }

    public function testTextLimitsAndDatesAreValidated()
    {
        foreach ([false, true] as $updating) {
            $this->assertTrue($this->validator($this->payload([
                'product_name' => str_repeat('á', 250), 'lot_number' => str_repeat('0', 250),
            ]), $updating)->passes());
            $validator = $this->validator($this->payload([
                'product_name' => str_repeat('a', 251), 'lot_number' => str_repeat('0', 251),
                'rehearsal_date' => '2026-02-30', 'manufacture_date' => 'ayer', 'expiration_date' => 'no',
            ]), $updating);
            foreach (['product_name', 'lot_number', 'rehearsal_date', 'manufacture_date', 'expiration_date'] as $field) {
                $this->assertTrue($validator->errors()->has($field), $field);
            }
        }
    }

    public function testClinicalRequestsIgnoreResidualIndustrialDataButValidateAge()
    {
        foreach ([false, true] as $updating) {
            $data = $this->payload([
                'is_industrial' => '0', 'product_name' => [], 'rehearsal_date' => 'invalida', 'edad' => 20,
            ]);
            $this->assertTrue($this->validator($data, $updating)->passes());
            $data['edad'] = 200;
            $this->assertTrue($this->validator($data, $updating)->errors()->has('edad'));
        }
    }

    public function testUnsupportedTypesAndInvalidBooleanAreRejected()
    {
        $data = $this->payload(['tipo_analisis' => Analisis::BIOPSIA]);
        $this->assertTrue($this->validator($data)->errors()->has('is_industrial'));
        $this->assertTrue($this->validator($data, true, Analisis::BIOPSIA)->errors()->has('is_industrial'));
        foreach (['on', 'false', null, []] as $value) {
            $this->assertTrue($this->validator($this->payload(['is_industrial' => $value]))->errors()->has('is_industrial'));
        }
    }

    public function testOmittedControlPreservesExistingIndustrialModeWithoutRequiringDetail()
    {
        $data = $this->payload(['edad' => 'IGNORADA']);
        unset($data['is_industrial'], $data['product_name'], $data['rehearsal_date']);
        $this->assertTrue($this->validator($data, true, Analisis::PRUEBA, true)->passes());
        $data['tipo_analisis'] = Analisis::BIOPSIA;
        $this->assertTrue($this->validator($data, true, Analisis::PRUEBA, true)->errors()->has('tipo_analisis'));
    }
}
