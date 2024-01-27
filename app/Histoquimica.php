<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Histoquimica extends Model
{
    protected $table = 'histoquimicas';

    protected $fillable = [
        'interpretacion',
        'tecnica',
        'bibliografia',
        'size_texto_marcadores'
    ];

    public function marcadores(){
        return $this->hasMany('App\Marcador')->orderBy('sort', 'desc');
    }
}
