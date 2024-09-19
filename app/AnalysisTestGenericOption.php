<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisTestGenericOption extends Model
{
    protected $table = 'a_test_generic_options';

    protected $fillable = [
        'reference',
        'age_initial',
        'age_end',
        'gender',
        'bookmark',
        'deleted',
        'user_id',
        'a_test_generic_id',
    ];

    public function analysisTestGeneric(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->belongsTo('App\AnalysisTestGeneric', 'a_test_generic_id', 'id');
    }
}
