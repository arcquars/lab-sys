<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marcador extends Model
{
    const PATH_IMAGE = 'uploads/markers';

    protected $table = 'marcadors';

    protected $fillable = [
        'nombre',
        'resultado',
        'intensidad',
        'path_image',
        'histoquimica_id',
        'sort'
    ];

    protected $appends = ['path_url', 'path'];

    /**
     * Determine  path url
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getPathUrlAttribute()
    {
        return asset(Marcador::PATH_IMAGE) . DIRECTORY_SEPARATOR . $this->path_image;
    }

    /**
     * Determine  path
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getPathAttribute()
    {
        return public_path(Marcador::PATH_IMAGE) . DIRECTORY_SEPARATOR . $this->path_image;
    }

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
