<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStateLog extends Model
{
    protected $table = 'order_states_log';

    public const UPDATED_AT = null;

    protected $fillable = [
        'pre_order_id', 'previous_state', 'new_state', 'user_id', 'note',
    ];

    public function preOrder()
    {
        return $this->belongsTo(PreOrder::class, 'pre_order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
