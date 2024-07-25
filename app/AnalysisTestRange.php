<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisTestRange extends TestInputAbstract
{
    protected $table = 'a_test_ranges';

    protected $fillable = [
        'measure',
        'bookmark',
        'user_id',
        'a_test_id'
    ];

    public function analysisTest(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->belongsTo('App\AnalysisTest', 'a_test_id', 'id');
    }

    public function analysisTestRangeOptions(){
        return $this->hasMany('App\AnalysisTestRangeOption', 'a_test_range_id', 'id');
    }

    public function getHtmlInput(): string
    {
        return "<input type='number' name='testResultValue-".$this->id."' class='form-control'>";
    }

    public function getHtmlDescription(): string
    {
        $html = "";
        foreach ($this->analysisTestRangeOptions as $analysisTestRangeOption)
        {
            $html .= $analysisTestRangeOption->initial . " - " . $analysisTestRangeOption->end . " " . $this->measure ."<br>";
        }
        return $html;
    }
}
