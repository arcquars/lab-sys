<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analisis extends Model
{
    protected $table = 'analisis';

    protected $fillable = [
        'doctor',
        'tipo_analisis',
        'fecha',
        'region',
        'precio',
        'acuenta',
        'observaciones',
        'procedencia',
        'person_id'
    ];

    public function person(){
        return $this->belongsTo('App\Person');
    }


    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Analisis
     * @return string
     */
    public static function laratablesCustomAction($analisis)
    {
        return view('analisis.includes.action')->with(array('id' => $analisis->id))->render();
    }
}
