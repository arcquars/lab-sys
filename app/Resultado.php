<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    const SUBTITULO = "TÉCNICA: BASE LÍQUIDA";
    protected $table = 'resultados';

    protected $fillable = [
        'papanicolau_clase1',
        'papanicolau_clase2',
        'observaciones1',
        'observaciones2',
    ];

    public function analisis(){
        return $this->belongsTo('App\Analisis');
    }

    public function secciones(){
        return $this->hasMany('App\Seccion');
    }

    public function showSeccionByType($seccion){
        $secciones = $this->secciones()->where('seccion', 'like', $seccion)->get();
        $results = array();
        foreach ($secciones as $seccion){
            $results[] = $seccion->key;
        }

        return implode(", ", $results);
    }
}
