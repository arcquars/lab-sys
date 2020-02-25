<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analisis extends Model
{
    const CITOLOGIA = 'CITOLOGIA';
    const BIOPSIA = 'BIOPSIA';
    const INMUNOHISTOQUIMICA = 'INMUNOHISTOQUIMICA';
    const BETHESDA = 'BETHESDA';
    const HISTOPATOLOGICO = 'HISTOPATOLOGICO';

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
        'movimiento',
        'persona_entrega',
        'fecha_cierre'
    ];

    public function person(){
        return $this->belongsTo('App\Person');
    }

    public function institucion(){
        return $this->belongsTo('App\Institucion', 'procedencia', 'id');
    }

    public function doctorasig(){
        return $this->belongsTo('App\Doctor', 'doctor_asignado', 'id');
    }

    public function hasHistory(){
        $count = Analisis::where('person_id', $this->person_id)->count();
        if($count > 1)
            return true;
        return false;
    }

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Analisis
     * @return string
     */
    public static function laratablesCustomAction($analisis)
    {
        // Verificando que se entrego el analisis al cliente
        $entregado = false;
        if(isset($analisis->persona_entrega)){
            $entregado = true;
        }
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
            case Analisis::HISTOPATOLOGICO:
                if(Biopsia::where('analisis_id', $analisis->id)->count() > 0){
                    $routeView = 'biopsia.viewResultado';
                    $isHasResult = true;
                }
                break;
            case Analisis::BETHESDA:
                if(Bethesda::where('analisis_id', $analisis->id)->count() > 0){
                    $routeView = 'bethesda.viewResultado';
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
            'pago_efectuado' => $analisis->pago_efectuado,
//            'entregado' => $analisis->persona_entrega
            'entregado' => $entregado,
            'fechaCierre' => $analisis->fecha_cierre
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

    /**
     * Returns the name column value for datatables.
     *
     * @param \App\Analisis
     * @return string
     */
    public static function laratablesPersonNombres($analisis)
    {
        return $analisis->person->nombres . ' ' . $analisis->person->apellidos.' '.$analisis->person->apellido_materno;
    }

    /**
     * Returns the name column value for datatables.
     *
     * @param \App\Analisis
     * @return string
     */
    public static function laratablesDoctorasigNombres($analisis)
    {
        return $analisis->doctorasig->nombres . ' ' . $analisis->doctorasig->apellidos.' '.$analisis->doctorasig->apellido_materno;
    }

    public static function updatePersonaFechaEntrega($analisisId, $personaEntrega, $fechaEntrega){
        $analisis = Analisis::find($analisisId);
        $analisis->persona_entrega = $personaEntrega;
        $analisis->fecha_entrega = $fechaEntrega;
        if($analisis->update()){
            return true;
        }
        return false;
    }

    public static function updateFechaCierre($analisisId, $fechaCierre){
        $analisis = Analisis::find($analisisId);
        $analisis->fecha_cierre = $fechaCierre;
        if($analisis->update()){
            return true;
        }
        return false;
    }

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Analisis
     * @return string
     */
    public static function laratablesCustomActionTec($analisis)
    {
        $isHasResult = false;
        $routeView = '';
        if(Biopsia::where('analisis_id', $analisis->id)->count() > 0){
            $routeView = 'biopsia.viewResultado';
            $isHasResult = true;
        }
        return view('analisis.includes.actiontec')->with(array(
            "id" => $analisis->id,
            "isHasResult" => $isHasResult,
            "routeView" => $routeView
            ))->render();
    }
}
