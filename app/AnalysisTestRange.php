<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisTestRange extends Model
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
}
