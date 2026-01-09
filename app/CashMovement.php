<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashMovement extends Model
{
    protected $table = 'cash_movements';

    protected $fillable = [
        'amount', 
        'type', 
        'payment_method', 
        'description', 
        'movement_date', 
        'user_id', 
        'concept_id',
        'source_id',
        'source_type'
    ];

    // Constantes para evitar strings mágicos
    const TYPE_INCOME = 'INGRESO';
    const TYPE_EXPENSE = 'EGRESO';

    public function concept()
    {
        return $this->belongsTo(Concept::class);
    }

    public function user()
    {
        return $this->belongsTo('App\User'); // Asumiendo que tu modelo User está en App o App\Models
    }
    
    // Relación polimórfica (si viene de una reserva, etc)
    public function source()
    {
        return $this->morphTo();
    }
}
