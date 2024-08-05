<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class AnalysisTestLimit extends TestInputAbstract
{
    protected $table = 'a_test_limits';

    protected $fillable = [
        'measure',
        'bookmark',
        'user_id',
        'a_test_id'
    ];

    public function analysisTest(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\AnalysisTest', 'a_test_id', 'id');
    }

    public function analysisTestLimitOptions(){
        return $this->hasMany('App\AnalysisTestLimitOption', 'a_test_limit_id', 'id');
    }

    public function getHtmlInput($aTestResultId): string
    {
        $value = '';
//        if(isset($this->analysisTest->analysisTestResult) && isset($this->analysisTest->analysisTestResult->result)){
//            Log::info('www: ' . $this->analysisTest->analysisTestResult->id);
//            $value = $this->analysisTest->analysisTestResult->result;
//        }
        return "<input type='number' name='testResultValue[".$this->a_test_id."]' value='". $value ."' class='form-control'>";
    }

    public function getHtmlDescription(): string
    {
        $html = "";
        foreach ($this->analysisTestLimitOptions as $analysisTestLimitOption)
        {
            $html .= $analysisTestLimitOption->gender;
            if(isset($analysisTestLimitOption->age_initial) && isset($analysisTestLimitOption->age_end)){
                $html .= " <small>(".$analysisTestLimitOption->age_initial . " - " . $analysisTestLimitOption->age_end . " años)</small> ";
            }
            $html .= ': Hasta '. $analysisTestLimitOption->to . " " . $this->measure ."<br>";
        }
        return $html;
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
        return "";
    }
}
