<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisTestRangeNoOrderOption extends Model
{
    protected $table = 'a_test_range_no_order_options';

    protected $fillable = [
        'gender',
        'age_initial',
        'age_end',

        'initial_text',
        'initial_value',
        'initial_bookmark',
        'end_text',
        'end_value',
        'end_bookmark',
        'deleted',
        'user_id',
        'a_test_range_no_order_id',
    ];

    public function analysisTestRangeNoOrder(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->belongsTo('App\AnalysisTestRangeNoOrder', 'a_test_range_no_order_id', 'id');
    }

    public function analysisTestRangeOptionsIntermediates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\AnalysisTestRangeNoOrderOptionIntermediary', 'order_option_id', 'id');
    }
}
