<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreOrderCustomTest extends Model
{
    protected $table = 'preorden_custom_tests';

    protected $fillable = ['pre_order_id', 'description'];
}
