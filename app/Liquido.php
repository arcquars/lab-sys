<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquido extends Model
{
    protected $table = 'liquidos';

    protected $fillable = [
        'organo_tejido',
        'macroscopia',
        'microscopia',
        'diagnostico',
    ];

    public function analisis(){
        return $this->belongsTo('App\Analisis', 'analisis_id', 'id');
    }
}
