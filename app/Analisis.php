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
        'person_id',
        'pago_efectuado',
        'doctor',
        'movimiento'
    ];

    public function person(){
        return $this->belongsTo('App\Person');
    }

    public function institucion(){
        return $this->belongsTo('App\Institucion', 'procedencia', 'id');
    }

    public function movimiento(){
        return 'ccc:: ';
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
                $routeView = 'histo.viewResultado';
                if(Histoquimica::where('analisis_id', $analisis->id)->count() > 0){
                    $isHasResult = true;
                }
                break;
            case Analisis::BIOPSIA:
                if(Biopsia::where('analisis_id', $analisis->id)->count() > 0){
                    $routeView = 'biopsia.viewResultado';
                    $isHasResult = true;
                }
                break;
        }
        return view('analisis.includes.action')->with(array(
            'id' => $analisis->id,
            'isHasResult' => $isHasResult,
            'routeView' => $routeView,
            'acuenta' => $analisis->acuenta,
            'precio' => $analisis->precio,
            'pago_efectuado' => $analisis->pago_efectuado
            ))->render();
    }

    public static function laratablesCustomPrecio1($analisis)
    {
        return view('analisis.includes.precio')->with(array(
            'acuenta' => $analisis->acuenta,
            'precio' => $analisis->precio,
            'pago_efectuado' => $analisis->pago_efectuado
            ))->render();
    }

    /**
     * doctor column should be used for sorting when name column is selected in Datatables.
     *
     * @return string
     */
    public static function laratablesOrderFecha(){
        return 'fecha';
    }
}
