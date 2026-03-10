<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisTestText extends TestInputAbstract
{
    protected $table = 'a_test_texts';

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
        return "<textarea name='testResultValue[".$this->a_test_id."]' class='form-control'>". $value ."</textarea>";
    }

    public function getHtmlDescription(): string
    {
//        return AnalysisTest::ANALYSIS_TEST_TYPE_TEXTO;
        return "";
    }

    public function getHtmlResult($aTestResultId, $result): string
    {
        //dd("<div style='width: 100%; text-justify: inter-word; text-align: justify; background-color: red;'><p style='text-align: justify;' >" . nl2br(e($result)) . "</p></div>");
        if($result != null){
            return "<div style='width: 100%; text-justify: inter-word; text-align: justify;'><p style='text-align: justify;' >" . nl2br(e($result)) . "</p></div>";
        }
        return '--';
    }

    public function getHtmlDescriptionResult($aTestResultId): string
    {
//        return AnalysisTest::ANALYSIS_TEST_TYPE_TEXTO;
        return '';
    }
}
