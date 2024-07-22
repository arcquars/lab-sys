<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisTestRangeNoOrder extends Model
{
    protected $table = 'a_test_range_no_orders';

    protected $fillable = [
        'measure',
        'user_id',
        'a_test_id'
    ];

    public function analysisTest(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->belongsTo('App\AnalysisTest', 'a_test_id', 'id');
    }
}
