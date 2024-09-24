<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class AnalysisTestRange extends TestInputAbstract
{
    protected $table = 'a_test_ranges';

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

    public function analysisTestRangeOptions(){
        return $this->hasMany('App\AnalysisTestRangeOption', 'a_test_range_id', 'id');
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
        $html = "";
        foreach ($this->analysisTestRangeOptions as $analysisTestRangeOption)
        {
            $html .= $analysisTestRangeOption->gender;
            if(isset($analysisTestRangeOption->age_initial) && isset($analysisTestRangeOption->age_end)){
                $html .= " (".$analysisTestRangeOption->age_initial . " - " . $analysisTestRangeOption->age_end . " años) ";
            }
            $html .= ': '. $analysisTestRangeOption->initial . " - " . $analysisTestRangeOption->end . " " . $this->measure ."<br>";
        }
        return $html;
    }

    public function getHtmlResult($aTestResultId, $result): string
    {
        if($result == null){
            return '--';
        }
        $aTestResult = AnalysisTestResult::find($aTestResultId);
        $resultHtml = false;
        $clientGender = $aTestResult->analysis->person->sexo;
        $resultNumeric = doubleval($result);

//        dd("ddd::: ".$resultNumeric);
        $clientAge = $aTestResult->analysis->person->year_now;

        foreach ($this->analysisTestRangeOptions as $analysisTestRangeOption)
        {
            if(strcmp("hombre y mujer", $analysisTestRangeOption->gender) == 0){
                if(isset($analysisTestRangeOption->age_initial) && isset($analysisTestRangeOption->age_end)){
                    if($resultNumeric <= $analysisTestRangeOption->initial ||
                        $resultNumeric >= $analysisTestRangeOption->end){
                        $resultHtml = true;
                    }
                } else {
                    if($resultNumeric <= $analysisTestRangeOption->initial ||
                        $resultNumeric >= $analysisTestRangeOption->end){
//                        dd("dddss");
                        $resultHtml = true;
                    }
                }
            } else {
                if(strcmp($analysisTestRangeOption->gender, $clientGender) == 0){
                    if(isset($analysisTestRangeOption->age_initial) && isset($analysisTestRangeOption->age_end)){
                        if($clientAge >= $analysisTestRangeOption->age_initial && $clientAge <= $analysisTestRangeOption->age_end){
                            if($resultNumeric <= $analysisTestRangeOption->initial ||
                                $resultNumeric >= $analysisTestRangeOption->end){
                                $resultHtml = true;
                            }
                        }
                    } else {
                        if($resultNumeric <= $analysisTestRangeOption->initial ||
                            $resultNumeric >= $analysisTestRangeOption->end){
                            $resultHtml = true;
                        }
                    }
                }
            }
        }

        return $resultHtml? "<span class='text-danger'>".$result."</span>" : $result;
    }

//    public function getHtmlDescriptionResult($aTestResultId): string
//    {
//        $html = "";
//        $aTestResult = AnalysisTestResult::find($aTestResultId);
//        $resultNumeric = doubleval($aTestResult->result);
//        $clientGender = $aTestResult->analysis->person->sexo;
//        $clientAge = $aTestResult->analysis->person->year_now;
//
//        foreach ($this->analysisTestRangeOptions as $analysisTestRangeOption)
//        {
//            $html .= $analysisTestRangeOption->initial . " - " . $analysisTestRangeOption->end . " " . $this->measure ."<br>";
//        }
//        return $html;
//    }

    public function getHtmlDescriptionResult($aTestResultId): string
    {
        $html = "";
        $aTestResult = AnalysisTestResult::find($aTestResultId);
        $resultNumeric = doubleval($aTestResult->result);
        $clientGender = $aTestResult->analysis->person->sexo;
        $clientAge = $aTestResult->analysis->person->year_now;

        foreach ($this->analysisTestRangeOptions as $analysisTestRangeOption)
        {
            $html1 = "";
//            $html1 = $analysisTestRangeOption->gender;
//            if(isset($analysisTestRangeOption->age_initial) && isset($analysisTestRangeOption->age_end)){
//                $html1 .= " (".$analysisTestRangeOption->age_initial . " - " . $analysisTestRangeOption->age_end . " años) ";
//            }
//            $html1 .= ": ";

            if(strcmp("hombre y mujer", $analysisTestRangeOption->gender) == 0){
                if(isset($analysisTestRangeOption->age_initial) && isset($analysisTestRangeOption->age_end)){
                    if($clientAge >= $analysisTestRangeOption->age_initial && $clientAge <= $analysisTestRangeOption->age_end){
                        $html .= $html1 .$analysisTestRangeOption->initial . " - " . $analysisTestRangeOption->end . " " . $this->measure ."<br>";
                    }
                } else {
                    $html .= $html1 . $analysisTestRangeOption->initial . " - " . $analysisTestRangeOption->end . " " . $this->measure ."<br>";
                }
            } else {
                if(strcmp($analysisTestRangeOption->gender, $clientGender) == 0){
                    if($clientAge >= $analysisTestRangeOption->age_initial && $clientAge <= $analysisTestRangeOption->age_end){
                        $html .= $html1 .$analysisTestRangeOption->initial . " - " . $analysisTestRangeOption->end . " " . $this->measure ."<br>";
                    }
                }
            }
        }
        return $html;
    }
}
