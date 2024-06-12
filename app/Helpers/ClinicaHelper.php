<?php
namespace App\Helpers;

use App\Doctor;

class ClinicaHelper {

    public static function getAllDoctorTitulares($doctorId){
//        $doctores = Doctor::where('deleted', 0)->where('supervisado', 0)->get();
        $doctores = Doctor::where('deleted', 0)->where('id', '<>', $doctorId)->orderBy('nombres')->get();
        return $doctores;
    }
}

