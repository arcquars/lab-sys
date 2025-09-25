<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisTest extends Model
{
    const ANALYSIS_TEST_TYPES = ['Generico', 'Limite', 'Rango', 'Rango Sin orden', 'Positivo o Negativo', 'Texto', 'Linea de texto'];
    const ANALYSIS_TEST_TYPE_RANGO = 'Rango';
    const ANALYSIS_TEST_TYPE_RANGO_SIN_ORDEN = 'Rango Sin orden';
    const ANALYSIS_TEST_TYPE_LIMITE = 'Limite';
    const ANALYSIS_TEST_TYPE_GENERICO = 'Generico';
    const ANALYSIS_TEST_TYPE_POSITIVO_NEGATIVO = 'Positivo o Negativo';
    const ANALYSIS_TEST_TYPE_TEXTO = 'Texto';
    const ANALYSIS_TEST_TYPE_LINEA_TEXTO = 'Linea de texto';


    protected $table = 'a_tests';

    protected $fillable = [
        'name',
        'price',
        'type',
        'metodo',
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
            case AnalysisTest::ANALYSIS_TEST_TYPE_POSITIVO_NEGATIVO:
                return $this->hasOne('App\AnalysisTestPositive', 'a_test_id', 'id');
            case AnalysisTest::ANALYSIS_TEST_TYPE_TEXTO:
                return $this->hasOne('App\AnalysisTestText', 'a_test_id', 'id');
            case AnalysisTest::ANALYSIS_TEST_TYPE_LINEA_TEXTO:
                return $this->hasOne('App\AnalysisTestLineText', 'a_test_id', 'id');
            case AnalysisTest::ANALYSIS_TEST_TYPE_GENERICO:
                return $this->hasOne('App\AnalysisTestGeneric', 'a_test_id', 'id');
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
