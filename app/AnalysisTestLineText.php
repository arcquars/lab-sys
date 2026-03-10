<?php

namespace App;

use Illuminate\Support\Str;

class AnalysisTestLineText extends TestInputAbstract
{
    protected $table = 'a_test_line_texts';

    protected $fillable = [
        'user_id',
        'a_test_id'
    ];

    public function analysisTest(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\AnalysisTest', 'a_test_id', 'id');
    }

    public function getHtmlInput($aTestResultId): string
    {

        $value = '';
        $aTestResult = AnalysisTestResult::find($aTestResultId);
        if(isset($aTestResult) && isset($aTestResult->result)){
            $value = $aTestResult->result;
        }
        return "<input type='text'" 
            . " title='Inicie con 2 asterizcos para que el texto sea de color AZUL y 3 asterizcos para que el texto sea de color ROJO. Ej: **Resultado normal' "
            . " name='testResultValue[".$this->a_test_id."]' value='". $value ."' class='form-control'>";
    }

    public function getHtmlDescription(): string
    {
//        return AnalysisTest::ANALYSIS_TEST_TYPE_TEXTO;
        return "";
    }

    public function getHtmlResult($aTestResultId, $result): string
    {
        if($result != null){
            if (Str::startsWith($result, "***")) {
                return "<p style='color: red;'>" . str_replace('*', '', $result) . "</p>";
            } else if (Str::startsWith($result, "**")) {
                return "<p style='color: blue;'>" . str_replace('*', '', $result) . "</p>";
            } else {
                return $result;
            }
            
        }
        return '--';
    }

    public function getHtmlDescriptionResult($aTestResultId): string
    {
//        return AnalysisTest::ANALYSIS_TEST_TYPE_TEXTO;
        return '';
    }
}
