<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $table = 'instituciones';

    protected $fillable = [
        'nombre',
        'telefono',
        'is_convenio'
    ];

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Institucion
     * @return string
     */
    public static function laratablesCustomAction($institucion)
    {
        return view('institucion.includes.action')->with(array('id' => $institucion->id))->render();
    }
}
