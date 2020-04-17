<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    const OMS = 'OMS';
    const RICHART = 'RICHART';
    const BETHESDA = 'BETHESDA';
    const EXTENDIDO_COMPATIBLE = 'EXTENDIDO COMPATIBLE CON LOS DIAGNOSTICOS';
    const REACCION_INFLAMATORIA = 'REACCION INFLAMATORIA';
    const ESTUDIO_MICROBIOLOGICO = 'ESTUDIO MICROBIOLOGICO';
    const ESTUDIO_CITO_HORMONAL = 'ESTUDIO CITO HORMONAL';
    const CITOLOGIA_POSMENOPAUSIA = 'CITOLOGIA POSMENOPAUSIA';
    const DESVIACION = 'DESVIACION';


    protected $table = 'secciones';

    protected $fillable = [
        'seccion',
        'key',
        'value',
    ];

    public static function saveSeccionValue($seccionArray, $tipoSeccion, $resultadoId){
        if(isset($seccionArray))
            foreach ($seccionArray as $key => $value){
//                if(isset($value) && !empty($value)){
                    $seccion = new Seccion();
                    $seccion->seccion = $tipoSeccion;
                    $seccion->key = $key;
                    $seccion->value = $value;
                    if($value == null)
                        $seccion->value = '';
                    $seccion->resultado_id = $resultadoId;
                    $seccion->save();
//                }
            }
    }

    public static function saveSeccionKey($seccionArray, $tipoSeccion, $resultadoId){
        if(isset($seccionArray))
            foreach ($seccionArray as $key => $value){
                if(isset($value) && !empty($value)){
                    $seccion = new Seccion();
                    $seccion->seccion = $tipoSeccion;
                    $seccion->key = $value;
                    $seccion->value = true;
                    $seccion->resultado_id = $resultadoId;
                    $seccion->save();
                }
            }
    }

    public static function getArraySeccionesByOMS($secciones){
        $seccOMG = array();
        foreach ($secciones as $seccion){
            if(strcmp($seccion->seccion, Seccion::OMS) == 0)
                array_push($seccOMG, $seccion);
        }
        return $seccOMG;
    }

    public static function getArraySeccionesByRichart($secciones){
        $seccs = array();
        foreach ($secciones as $seccion){
            if(strcmp($seccion->seccion, Seccion::RICHART) == 0)
                array_push($seccs, $seccion);
        }
        return $seccs;
    }

    public static function getArraySeccionesByBethesda($secciones){
        $seccs = array();
        foreach ($secciones as $seccion){
            if(strcmp($seccion->seccion, Seccion::BETHESDA) == 0)
                array_push($seccs, $seccion);
        }
        return $seccs;
    }

    public static function getArraySeccionesByReacInflamatorio($secciones){
        $seccs = array();
        foreach ($secciones as $seccion){
            if(strcmp($seccion->seccion, Seccion::REACCION_INFLAMATORIA) == 0)
                array_push($seccs, $seccion);
        }
        return $seccs;
    }

    public static function getArraySeccionesByReacInflamatorioByName($secciones, $name){

        $resultado = '';
        foreach ($secciones as $seccion){
            if(strcmp($seccion->seccion, Seccion::REACCION_INFLAMATORIA) == 0 && strcmp($seccion->key, $name) == 0)
                $resultado = '('.$seccion->value.') '.$seccion->key;
        }

        if(strcmp($resultado, '') == 0){
            return '(NO) '.$name;
        }
        return $resultado;
    }


    public static function getArraySeccionesByExtendidoCompatible($secciones){
        $seccs = array();
        foreach ($secciones as $seccion){
            if(strcmp($seccion->seccion, Seccion::EXTENDIDO_COMPATIBLE) == 0)
                array_push($seccs, $seccion);
        }
        return $seccs;
    }

    public static function getArraySeccionesByEstudioMicro($secciones){
        $seccs = array();
        foreach ($secciones as $seccion){
            if(strcmp($seccion->seccion, Seccion::ESTUDIO_MICROBIOLOGICO) == 0)
                array_push($seccs, $seccion);
        }
        return $seccs;
    }

    public static function getArraySeccionesByCitoHormonal($secciones){
        $seccs = array();
        foreach ($secciones as $seccion){
            if(strcmp($seccion->seccion, Seccion::ESTUDIO_CITO_HORMONAL) == 0)
                array_push($seccs, $seccion);
        }
        return $seccs;
    }

    public static function getArraySeccionesByCitoPosmenopausia($secciones){
        $seccs = array();
        foreach ($secciones as $seccion){
            if(strcmp($seccion->seccion, Seccion::CITOLOGIA_POSMENOPAUSIA) == 0)
                array_push($seccs, $seccion);
        }
        return $seccs;
    }

    public static function getArraySeccionesByDesviaciones($secciones){
        $seccs = array();
        foreach ($secciones as $seccion){
            if(strcmp($seccion->seccion, Seccion::DESVIACION) == 0)
                array_push($seccs, $seccion);
        }
        return $seccs;
    }
}
