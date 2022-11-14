<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvitadoAsignaciones extends Model
{
    const TIPO_PERSONA = 'PERSONA';
    const TIPO_INSTITUCION = 'INSTITUCION';

    protected $table = 'invitado_asignaciones';

    protected $fillable = [
        'tipo',
        'valor',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
