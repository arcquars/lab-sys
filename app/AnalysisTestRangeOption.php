<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisTestRangeOption extends Model
{
    protected $table = 'a_test_range_options';

    protected $fillable = [
        'initial',
        'end',
        'subtitle',
        'age_initial',
        'age_end',
        'gender',
        'bookmark',
        'deleted',
        'user_id',
        'a_test_range_id',
    ];

    public function analysisTestRange(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->belongsTo('App\AnalysisTestRange', 'a_test_range_id', 'id');
    }
}
