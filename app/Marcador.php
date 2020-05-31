<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marcador extends Model
{
    protected $table = 'marcadors';

    protected $fillable = [
        'nombre',
        'resultado',
        'histoquimica_id'
    ];


    public static function saveMarcadorsByHistoquimicaId($histoquimicaId, $marcadores){
        Marcador::where('histoquimica_id', $histoquimicaId)->delete();
        if(is_array($marcadores))
            foreach ($marcadores as $marcador){
                $marcadorModel = new Marcador();
                $marcadorModel->nombre = $marcador['nombre'];
                $marcadorModel->resultado = $marcador['resultado'];
                $marcadorModel->histoquimica_id = $histoquimicaId;
                $marcadorModel->save();
            }
    }

}
