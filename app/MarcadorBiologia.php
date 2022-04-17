<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarcadorBiologia extends Model
{
    protected $table = 'marcador_biologias';

    protected $fillable = [
        'nombre',
        'resultado',
        'biologiam_id'
    ];


    public static function saveMarcadorsByBiologiaId($biologiaId, $marcadores){
        MarcadorBiologia::where('biologiam_id', $biologiaId)->delete();
        if(is_array($marcadores))
            foreach ($marcadores as $marcador){
                $marcadorModel = new MarcadorBiologia();
                $marcadorModel->nombre = $marcador['nombre'];
                $marcadorModel->resultado = $marcador['resultado'];
                $marcadorModel->biologiam_id = $biologiaId;
                $marcadorModel->save();
            }
    }

}
