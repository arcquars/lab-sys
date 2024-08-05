<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisTestLimitOption extends Model
{
    protected $table = 'a_test_limit_options';

    protected $fillable = [
        'to',
        'age_initial',
        'age_end',
        'gender',
        'bookmark',
        'deleted',
        'user_id',
        'a_test_range_id',
    ];

    public function analysisTestLimit(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->belongsTo('App\AnalysisTestLimit', 'a_test_limit_id', 'id');
    }
}
