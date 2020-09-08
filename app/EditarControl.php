<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditarControl extends Model
{
    protected $table = 'editar_controles';

    protected $fillable = [
        'user_id',
        'analisis_id',
        'created_at'
    ];

    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public static function grabarEditar($userId, $analisisId){
        EditarControl::create(['user_id' => $userId, 'analisis_id' => $analisisId]);
        return true;
    }
}
