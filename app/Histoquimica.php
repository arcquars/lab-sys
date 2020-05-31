<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Histoquimica extends Model
{
    protected $table = 'histoquimicas';

    protected $fillable = [
        'interpretacion',
        'tecnica',
        'bibliografia'
    ];

    public function marcadores(){
        return $this->hasMany('App\Marcador');
    }
}
