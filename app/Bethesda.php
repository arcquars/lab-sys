<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Bethesda extends Model
{
    protected $table = 'bethesda';

    protected $fillable = [
        'celulas_observadas',
        'calidad_muestra',
        'clasificacion_general',
        'interpretacion',
        'observaciones',
    ];

    public function analisis(){
        return $this->belongsTo('App\Analisis', 'analisis_id', 'id');
    }

    public function getCalidadMuestraId(){
        return array_search($this->calidad_muestra, Config::get('clinica.bethesda_calidad_muestra'));
    }

    public function getClasificacionGeneralId(){
        return array_search($this->clasificacion_general, Config::get('clinica.bethesda_clasificacion_general'));
    }

    public function getInterpretacionId(){
        return array_search($this->interpretacion, Config::get('clinica.bethesda_interpretacion'));
    }

    public function getCelulasObservadasArray(){
        return json_decode($this->celulas_observadas);
    }

    public static function getStringFromArrayCelulasObservadas($celulas){
        $result = array();
        foreach (Config::get('clinica.bethesta_checks') as $key => $value){
            foreach ($celulas as $key1 => $value1){
                if($key == $value1){
                    $result[$key] = $value;
                    break;
                }
            }
        }
        return json_encode($result);
    }

    public static function getStringFromArrayInterpretaciones($interpretaciones){
        $result = array();
        foreach (Config::get('clinica.bethesda_interpretacion') as $key => $value){
            foreach ($interpretaciones as $key1 => $value1){
//                echo $key.' || '.$value1;
                if($key == $value1){
                    $result[$key] = $value;
                    break;
                }
            }
        }
        return json_encode($result);
    }

    public function getInterpretacionesArray(){
        $arr = json_decode($this->interpretacion);
        return $arr;
    }

    public function showInterpretaciones(){
        $interpretaciones = json_decode($this->interpretacion);
        $html = "<p>" ;
        foreach ($interpretaciones as $key => $interpretacion){
            $html .= "<b>".$key.":</b> " . $interpretacion . ", ";
        }
        $html .= "</p>";
        return $html;
    }
}
