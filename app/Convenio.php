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
        'analisis_id'
    ];

    public function analisis(){
        return $this->belongsTo('App\Analisis');
    }
}
