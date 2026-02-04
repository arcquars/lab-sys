<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Method extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'active', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
