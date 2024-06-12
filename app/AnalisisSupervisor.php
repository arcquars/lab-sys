<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalisisSupervisor extends Model
{
    const ESTADO_SIN_VERIFICAR = "SIN VERIFICAR";
    const ESTADO_VERIFICADO = "VERIFICADO";

    protected $table = 'a_supervisores';

    protected $fillable = [
        'estado',
        'comentario',
        'deleted',
        'user_id',
        'analisis_id',
        'doctor_id'
    ];

    public function analisis(){
        return $this->belongsTo('App\Analisis', 'analisis_id', 'id');
    }

    public function doctorSupervisor(){
        return $this->belongsTo('App\Doctor', 'doctor_id', 'id');
    }
}
