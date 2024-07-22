<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisTest extends Model
{
    const ANALYSIS_TEST_TYPES = ['Rango', 'Rango Sin orden'];
    const ANALYSIS_TEST_TYPE_RANGO = 'Rango';
    const ANALYSIS_TEST_TYPE_RANGO_SIN_ORDEN = 'Rango Sin orden';


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

//    public function analysisTestTypes(): \Illuminate\Database\Eloquent\Relations\HasMany
//    {
//        $this->refresh();
//        if(true){
//            return $this->hasMany('App\AnalysisTestRange', 'a_test_id', 'id');
//        }
//    }

    public function analysisTestRange(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\AnalysisTestRange', 'a_test_id', 'id');
    }
}
