<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisTest extends Model
{
    const ANALYSIS_TEST_TYPES = ['Rango', 'Rango Sin orden', 'Limite'];
    const ANALYSIS_TEST_TYPE_RANGO = 'Rango';
    const ANALYSIS_TEST_TYPE_RANGO_SIN_ORDEN = 'Rango Sin orden';
    const ANALYSIS_TEST_TYPE_LIMITE = 'Limite';


    protected $table = 'a_tests';

    protected $fillable = [
        'name',
        'price',
        'type',
        'deleted',
        'user_id',
        'a_test_group_id'
    ];

    public function analysisGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\AnalysisTestGroup', 'a_test_group_id', 'id');
    }

    public function analysisTestType(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        $this->refresh();
        switch ($this->type){
            case AnalysisTest::ANALYSIS_TEST_TYPE_LIMITE:
                return $this->hasOne('App\AnalysisTestLimit', 'a_test_id', 'id');
            case AnalysisTest::ANALYSIS_TEST_TYPE_RANGO_SIN_ORDEN:
                return $this->hasOne('App\AnalysisTestRangeNoOrder', 'a_test_id', 'id');
            default:
                return $this->hasOne('App\AnalysisTestRange', 'a_test_id', 'id');
        }
    }

//    public function analysisTestResult(): \Illuminate\Database\Eloquent\Relations\HasOne{
//        return $this->hasOne('App\AnalysisTestResult', 'a_test_id', 'id');
//    }

//    public function analysisTestRange(): \Illuminate\Database\Eloquent\Relations\HasOne
//    {
//        return $this->hasOne('App\AnalysisTestRange', 'a_test_id', 'id');
//    }
}
