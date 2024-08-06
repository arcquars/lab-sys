<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisTestPositive extends TestInputAbstract
{
    protected $table = 'a_test_positives';

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
        $input = '<div class="form-check form-check-inline">';
        $input .= '<input class="form-check-input" type="radio" name="testResultValue['.$this->a_test_id.']" id="inlineRadio'.$this->a_test_id.'1" value="POSITIVO" ';
        $input .= ((strcmp($value, 'POSITIVO') == 0)? 'selected' : '').'>';
        $input .= '<label class="form-check-label" for="inlineRadio'.$this->a_test_id.'1">POSITIVO</label>';
        $input .= '</div>';
        $input .= '<div class="form-check form-check-inline">';
        $input .= '<input class="form-check-input" type="radio" name="testResultValue['.$this->a_test_id.']" id="inlineRadio'.$this->a_test_id.'2" value="NEGATIVO"';
        $input .= ((strcmp($value, 'POSITIVO') != 0)? 'selected' : '').'>';
        $input .= '<label class="form-check-label" for="inlineRadio'.$this->a_test_id.'2">NEGATIVO</label>';
        $input .= '</div>';
        return $input;
    }

    public function getHtmlDescription(): string
    {
        return AnalysisTest::ANALYSIS_TEST_TYPE_POSITIVO_NEGATIVO;
    }

    public function getHtmlResult($aTestResultId, $result): string
    {
        if($result != null){
            return $result;
        }
        return '--';
    }

    public function getHtmlDescriptionResult($aTestResultId): string
    {
        return AnalysisTest::ANALYSIS_TEST_TYPE_POSITIVO_NEGATIVO;
    }
}
