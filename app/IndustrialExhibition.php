<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndustrialExhibition extends Model
{
    protected $table = 'industrial_exhibition';

    const DATA_FIELDS = [
        'product_name', 'rehearsal_date', 'lot_number', 'manufacture_date', 'expiration_date',
    ];

    protected $fillable = self::DATA_FIELDS;

    protected $casts = [
        'rehearsal_date' => 'date:Y-m-d',
        'manufacture_date' => 'date:Y-m-d',
        'expiration_date' => 'date:Y-m-d',
    ];

    public function analisis()
    {
        return $this->belongsTo(Analisis::class, 'analisis_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
