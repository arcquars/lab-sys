<?php
namespace App\Helpers;

use App\Doctor;

class ClinicaHelper {

    public static function getAllDoctorTitulares(){
        $doctores = Doctor::where('deleted', 0)->where('supervisado', 0)->get();
        return $doctores;
    }
}

