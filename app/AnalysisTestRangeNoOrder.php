<?php

namespace App;

use Illuminate\Support\Facades\Log;

class AnalysisTestRangeNoOrder extends TestInputAbstract
{
    protected $table = 'a_test_range_no_orders';

    protected $fillable = [
        'measure',
        'user_id',
        'a_test_id'
    ];

    public function analysisTest(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\AnalysisTest', 'a_test_id', 'id');
    }

    public function analysisTestRangeOptions(){
        return $this->hasMany('App\AnalysisTestRangeNoOrderOption', 'a_test_range_no_order_id', 'id');
    }

    public function getHtmlInput($aTestResultId): string
    {
        $value = '';
        $aTestResult = AnalysisTestResult::find($aTestResultId);
        if(isset($aTestResult) && isset($aTestResult->result)){
            $value = $aTestResult->result;
        }
        return "<input type='number' step='0.001' name='testResultValue[".$this->a_test_id."]' value='".$value ."' class='form-control'>";
    }

    public function getHtmlDescription(): string
    {
        $html = "";
        if(isset($this->analysisTestRangeOptions)){
            foreach ($this->analysisTestRangeOptions as $analysisTestRangeOption)
            {
                // $html .= $analysisTestRangeOption->gender;
                switch($analysisTestRangeOption->gender){
                    case "hombre y mujer":
                        $html = "Masculino y Femenino";
                        break;
                    case "hombre":
                        $html = "Masculino";
                        break;
                    default:
                        $html = "Femenino";
                        break;
                }
                if(isset($analysisTestRangeOption->age_initial) && $analysisTestRangeOption->age_end){
                    $html .= " (".$analysisTestRangeOption->age_initial . " - " . $analysisTestRangeOption->age_end . " años) ";
                }
                $html .= ":<br>";
                if(isset($analysisTestRangeOption->initial_text) && isset($analysisTestRangeOption->initial_value)){
                    $bookmark = "";
                    if($analysisTestRangeOption->initial_bookmark){
                        $bookmark = "<span class='text-danger'>*</span>&nbsp;";
                    }
                    $html .= "&nbsp; &nbsp; " . $bookmark .$analysisTestRangeOption->initial_text . ": " . $analysisTestRangeOption->initial_value . " " . $this->measure ."<br>";
                }

                foreach ($analysisTestRangeOption->analysisTestRangeOptionsIntermediates as $analysisTestRangeOptionsIntermediate){
                    $bookmarkI = "";
                    if($analysisTestRangeOptionsIntermediate->bookmark){
                        $bookmarkI = "<span class='text-danger'>*</span>&nbsp;";
                    }
                    $html .= "&nbsp; &nbsp; " . $bookmarkI . $analysisTestRangeOptionsIntermediate->range_name . ": " .
                        $analysisTestRangeOptionsIntermediate->initial_range . " - " . $analysisTestRangeOptionsIntermediate->end_range . " " .
                        $this->measure . "<br>";
                }
                $html .= "";
                if(isset($analysisTestRangeOption->end_text) && isset($analysisTestRangeOption->end_value)){
                    $bookmarkE = "";
                    if($analysisTestRangeOption->end_bookmark){
                        $bookmarkE = "<span class='text-danger'>*</span>&nbsp;";
                    }
                    $html .= "&nbsp; &nbsp; ".$bookmarkE.$analysisTestRangeOption->end_text . ": " . $analysisTestRangeOption->end_value . " " . $this->measure ."<br>";
                }
            }
        }

        return $html;
    }

    public function getHtmlResult($aTestResultId, $result): string
    {
        if($result == null){
            return "--";
        }
        $aTestResult = AnalysisTestResult::find($aTestResultId);

        $resultHtml = true;
        $isOption = false;
        $resultNumeric = doubleval($result);
        $clientGender = $aTestResult->analysis->person->sexo;
        $clientAge = $aTestResult->analysis->person->year_now;

        foreach ($this->analysisTestRangeOptions as $analysisTestRangeOption){
            $resultHtml = true;
            if(strcmp("hombre y mujer", $analysisTestRangeOption->gender) == 0){
                if(isset($analysisTestRangeOption->age_initial) && isset($analysisTestRangeOption->age_end)){
                    if($clientAge >= $analysisTestRangeOption->age_initial && $clientAge <= $analysisTestRangeOption->age_end){
                        $resultHtml = $this->searchMarkRangeOption($analysisTestRangeOption, $resultNumeric);
                        $isOption = true;
                    }
                } else {
                    Log::info('pdm 5.2.1 entro al rango de edad::: ' . $resultNumeric);
                    $resultHtml = $this->searchMarkRangeOption($analysisTestRangeOption, $resultNumeric);
                    $isOption = true;
                }
            } else {
                if(strcmp($analysisTestRangeOption->gender, $clientGender) == 0){
                    if(isset($analysisTestRangeOption->age_initial) && isset($analysisTestRangeOption->age_end)){
                        if($clientAge >= $analysisTestRangeOption->age_initial && $clientAge <= $analysisTestRangeOption->age_end){
                            $resultHtml = $this->searchMarkRangeOption($analysisTestRangeOption, $resultNumeric);
                            $isOption = true;
                        }
                    } else {
                        $resultHtml = $this->searchMarkRangeOption($analysisTestRangeOption, $resultNumeric);
                        $isOption = true;
                    }
                }
            }
            if($isOption){
                break;
            }
        }
        Log::info('pdm 7 result finales::: ' . $resultNumeric . " || resultHtml: " . $resultHtml);
        return $resultHtml? "<span class='text-danger'>".$resultNumeric."</span>" : $result;
    }

    public function searchMarkRangeOption($analysisTestRangeOption, $resultNumeric){
        $result = $this->isRangeInitial($analysisTestRangeOption, $resultNumeric);
        if($result)
            return $result;
        else{
            $resultEnd = $this->isRangeEnd($analysisTestRangeOption, $resultNumeric);
            if($resultEnd){
                return $resultEnd;
            } else
                return $this->isRangeOption($analysisTestRangeOption, $resultNumeric);
        }
    }

    public function isRangeOption($analysisTestRangeOption, $resultNumeric){
        foreach ($analysisTestRangeOption->analysisTestRangeOptionsIntermediates as $analysisTestRangeOptionsIntermediate){
            if($analysisTestRangeOptionsIntermediate->bookmark){
                Log::info('pdm 5.2.1 buscando en el rango::: ' . $analysisTestRangeOptionsIntermediate->initial_range . " || " . $analysisTestRangeOptionsIntermediate->end_range);
                if($resultNumeric >= $analysisTestRangeOptionsIntermediate->initial_range &&
                    $resultNumeric <= $analysisTestRangeOptionsIntermediate->end_range
                ){
                    Log::info('pdm 5.2.2 encontrado en el rango::: ' . $analysisTestRangeOptionsIntermediate->initial_range . " || " . $analysisTestRangeOptionsIntermediate->end_range);
                    return true;
                }
            }

        }
        return false;
    }

    public function isRangeInitial($analysisTestRangeOption, $resultNumeric){
        $isRange = $this->isRangeOption($analysisTestRangeOption, $resultNumeric);
        if($analysisTestRangeOption->initial_bookmark){
            if(!$isRange){
                Log::info('pdm 6.0.1 entro al rango de edad::: ' . $resultNumeric);
                if($resultNumeric <= $analysisTestRangeOption->initial_value){
                    return true;
                }
            }
        }
        return false;
    }

    public function isRangeEnd($analysisTestRangeOption, $resultNumeric){
        $isRange = $this->isRangeOption($analysisTestRangeOption, $resultNumeric);
        if($analysisTestRangeOption->end_bookmark){
            if(!$isRange){
                Log::info('pdm 6.0.1 entro al rango de edad::: ' . $resultNumeric);
                if($resultNumeric >= $analysisTestRangeOption->end_value){
                    return true;
                }
            }
        }
        return false;
    }

    public function getHtmlDescriptionResult($aTestResultId): string
    {
        $aTestResult = AnalysisTestResult::find($aTestResultId);
        if($aTestResult->result == null){
            return "--";
        }
        $resultHtml = '';
        $resultNumeric = doubleval($aTestResult->result);
        $clientGender = $aTestResult->analysis->person->sexo;
        $clientAge = $aTestResult->analysis->person->year_now;

        foreach ($this->analysisTestRangeOptions as $analysisTestRangeOption){
            $resultHtml .= $this->searchMarkRangeOptionResult($analysisTestRangeOption, $resultNumeric);
        }

        return $resultHtml;
    }


    public function searchMarkRangeOptionResult($analysisTestRangeOption, $resultNumeric){
        $html = "";
        if($analysisTestRangeOption->initial_value){
            $html .= $analysisTestRangeOption->initial_text . ": " . $analysisTestRangeOption->initial_value . " " .$this->measure ."<br>";
        }
        if($analysisTestRangeOption->end_value){
            $html .= $analysisTestRangeOption->end_text . ": " . $analysisTestRangeOption->end_value . " " .$this->measure ."<br>";
        }
        foreach ($analysisTestRangeOption->analysisTestRangeOptionsIntermediates as $analysisTestRangeOptionsIntermediate){
            $html .= $analysisTestRangeOptionsIntermediate->range_name . ": " .
                $analysisTestRangeOptionsIntermediate->initial_range . " - " . $analysisTestRangeOptionsIntermediate->end_range . " " .
                $this->measure . "<br>";
        }
        return $html;
    }

}
