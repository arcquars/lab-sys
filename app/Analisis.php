<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analisis extends Model
{
    const CITOLOGIA = 'CITOLOGIA';
    const BIOPSIA = 'BIOPSIA';
    const INMUNOHISTOQUIMICA = 'INMUNOHISTOQUIMICA';

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

    public function institucion(){
        return $this->belongsTo('App\Institucion', 'procedencia', 'id');
    }

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Analisis
     * @return string
     */
    public static function laratablesCustomAction($analisis)
    {
        $isHasResult = false;
        $routeView = '';
        switch ($analisis->tipo_analisis){
            case Analisis::CITOLOGIA:
                $routeView = 'citologia.viewResultado';
                if(Resultado::where('analisis_id', $analisis->id)->count() > 0){
                    $isHasResult = true;
                }
                break;
            case Analisis::INMUNOHISTOQUIMICA:
                break;
            case Analisis::BIOPSIA:
                break;
        }
        return view('analisis.includes.action')->with(array(
            'id' => $analisis->id,
            'isHasResult' => $isHasResult,
            'routeView' => $routeView))->render();
    }
}
