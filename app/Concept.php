<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    protected $fillable = ['name', 'type', 'active'];

    public function movements()
    {
        return $this->hasMany(CashMovement::class);
    }
}
