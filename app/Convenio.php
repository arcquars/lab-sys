<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    protected $table = 'convenios';

    protected $fillable = [
        'bancaMatricula',
        'bancaPreAfiliacion',
        'bancaActivoAsegurado',
        'bancaEspecialidad',
        'bancaAmbulatorio',
        'bancaHospitalizado',
    ];

    public function analisis(){
        return $this->belongsTo('App\Analisis');
    }
}
