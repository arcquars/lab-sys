<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisTestGroup extends Model
{
    protected $table = 'a_test_groups';

    protected $fillable = [
        'name',
        'price',
        'subtitle',
        'sorted',
        'deleted',
        'parent_id',
        'user_id'
        ];

    public function children()
    {
        return $this->hasMany(AnalysisTestGroup::class, 'parent_id')->with('parent')->where('deleted', '=', 0);
    }

    public function parent()
    {
        return $this->hasOne(AnalysisTestGroup::class, 'id', 'parent_id');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function analysisTests(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\AnalysisTest', 'a_test_group_id', 'id')
            ->where('deleted', false)->orderBy('sorted', 'asc')->orderBy('name', 'asc');
    }
}
