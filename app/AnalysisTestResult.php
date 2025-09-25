<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisTestResult extends Model
{
    protected $table = 'a_test_results';

    protected $fillable = [
        'result',
        'test_text',
        'a_test_id',
        'deleted',
        'user_id',
        'analysis_id',
        'metodo'
    ];

    public function analysis(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Analisis', 'analysis_id', 'id');
    }

    public function aTest(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\AnalysisTest', 'a_test_id', 'id');
    }
}
