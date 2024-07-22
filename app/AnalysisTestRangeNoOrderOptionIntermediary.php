<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasOne;

class AnalysisTestRangeNoOrderOptionIntermediary extends Model
{
    protected $table = 'a_test_rno_option_intermediaries';

    protected $fillable = [
        'range_name',
        'initial_range',
        'end_range',
        'bookmark',
        'order_option_id',
    ];

    public function analysisTestRangeNoOrderOption(): HasOne
    {
        return $this->belongsTo('App\AnalysisTestRangeNoOrderOption', 'order_option_id', 'id');
    }
}
