<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisTestGeneric extends TestInputAbstract
{
    protected $table = 'a_test_generics';

    protected $fillable = [
        'user_id',
        'a_test_id'
    ];

    public function analysisTest(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\AnalysisTest', 'a_test_id', 'id');
    }

    public function analysisTestGenericOptions(){
        return $this->hasMany('App\AnalysisTestGenericOption', 'a_test_generic_id', 'id');
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
        foreach ($this->analysisTestGenericOptions as $analysisTestGenericOption)
        {
            $html .= $analysisTestGenericOption->gender;
            if(isset($analysisTestGenericOption->age_initial) && isset($analysisTestGenericOption->age_end)){
                $html .= " <small>(".$analysisTestGenericOption->age_initial . " - " . $analysisTestGenericOption->age_end . " años)</small> ";
            }
            $html .= ': '. $analysisTestGenericOption->reference . "<br>";
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

//    public function getHtmlDescriptionResult($aTestResultId): string
//    {
//        $html = "";
//        $aTestResult = AnalysisTestResult::find($aTestResultId);
//        $resultNumeric = doubleval($aTestResult->result);
//        $clientGender = $aTestResult->analysis->person->sexo;
//        $clientAge = $aTestResult->analysis->person->year_now;
//
//        foreach ($this->analysisTestGenericOptions as $analysisTestGenericOption)
//        {
//            $html1 = $analysisTestGenericOption->gender;
//            if(isset($analysisTestGenericOption->age_initial) && isset($analysisTestGenericOption->age_end)){
//                $html1 .= " (".$analysisTestGenericOption->age_initial . " - " . $analysisTestGenericOption->age_end . " años) ";
//            }
//            $html1 .= ": ";
//
//            if(strcmp("hombre y mujer", $analysisTestGenericOption->gender) == 0){
//                if(isset($analysisTestGenericOption->age_initial) && isset($analysisTestGenericOption->age_end)){
//                    if($clientAge >= $analysisTestGenericOption->age_initial && $clientAge <= $analysisTestGenericOption->age_end){
//                        $html .= $html1 .$analysisTestGenericOption->reference ."<br>";
//                    }
//                } else {
//                    $html .= $html1 . $analysisTestGenericOption->reference ."<br>";
//                }
//            } else {
//                if(strcmp($analysisTestGenericOption->gender, $clientGender) == 0){
//                    if($analysisTestGenericOption->age_initial && $analysisTestGenericOption->age_end){
//                        if($clientAge >= $analysisTestGenericOption->age_initial && $clientAge <= $analysisTestGenericOption->age_end){
//                            $html .= $html1 .$analysisTestGenericOption->reference ."<br>";
//                        }
//                    } else {
//                        $html .= $html1 .$analysisTestGenericOption->reference ."<br>";
//                    }
//                }
//            }
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

        foreach ($this->analysisTestGenericOptions as $analysisTestGenericOption)
        {
            $html .= $analysisTestGenericOption->reference ."<br>";
        }
        return $html;
    }
}
