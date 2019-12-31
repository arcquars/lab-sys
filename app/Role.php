<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ADMIN = 'admin';
    const SECRETARIA = 'secretaria';
    const TECNICO = 'tecnico';
    const MEDICO ='medico';

    public function users(){
        return $this->belongsToMany('App\User');
    }
}
