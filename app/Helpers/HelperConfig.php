<?php


namespace App\Helpers;


class HelperConfig
{

    public static function existEdcKey($seccECD, $extendidoCompatible){
        $exist = false;
        foreach($seccECD as $secc){
            if(strcmp($secc->key, $extendidoCompatible) == 0){
                $exist = true;
            }
        }
        return $exist;
    }

    public static function getValueSeccionByKey($seccECD, $extendidoCompatible){
        $value = '';
        foreach($seccECD as $secc){
            if(strcmp($secc->key, $extendidoCompatible) == 0){
                $value = $secc->value;
            }
        }
        return $value;
    }
}