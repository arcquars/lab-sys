<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctores';

    protected $fillable = [
        'nombres',
        'apellidos',
        'especialidad',
        'matricula',
        'signing',
        'deleted'
        ];

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\User
     * @return string
     */
    public static function laratablesCustomAction($doctor)
    {
        return view('doctor.includes.action')->with(array('id' => $doctor->id))->render();
    }
}
