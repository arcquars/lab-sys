<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvitadoAnalisis extends Model
{
    protected $table = 'invitados_analisis';

    protected $fillable = [
        'user_id',
        'analisis_id'
    ];
}
