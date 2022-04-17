<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BiologiaMolecular extends Model
{
    protected $table = 'biologia_molecular';

    protected $fillable = [
        'interpretacion',
        'tecnica',
        'bibliografia'
    ];

    public function marcadores(){
        return $this->hasMany('App\MarcadorBiologia', 'biologiam_id','id');
    }
}
