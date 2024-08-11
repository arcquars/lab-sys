<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisTestGroup extends Model
{
    protected $table = 'a_test_groups';

    protected $fillable = [
        'name',
        'sorted',
        'deleted',
        'user_id'
        ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function analysisTests(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\AnalysisTest', 'a_test_group_id', 'id')
            ->where('deleted', false);
    }
}
