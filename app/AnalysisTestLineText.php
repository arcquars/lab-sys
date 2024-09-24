<?php

namespace App;

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
        return "<input type='text' name='testResultValue[".$this->a_test_id."]' value='". $value ."' class='form-control'>";
    }

    public function getHtmlDescription(): string
    {
//        return AnalysisTest::ANALYSIS_TEST_TYPE_TEXTO;
        return "";
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
//        return AnalysisTest::ANALYSIS_TEST_TYPE_TEXTO;
        return '';
    }
}
