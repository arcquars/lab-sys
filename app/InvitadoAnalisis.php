<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvitadoAnalisis extends Model
{
    protected $table = 'invitados_analisis';

    protected $fillable = [
        'user_id',
        'analisis_id'
    ];

    /**
     * Join roles to base users table.
     * Assumes roles -> users is a one-to-many relationship
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function laratablesQueryConditions($query)
    {
        return $query->
        join('analisis', 'analisis.id', 'invitados_analisis.analisis_id')->
        join('persons', 'analisis.person_id', '=', 'persons.id')->
        select('analisis.id', 'analisis.codigo', 'analisis.tipo_analisis', 'analisis.fecha', 'persons.nombres', 'persons.apellidos', 'persons.apellido_materno');
    }

    /**
     * first_name column should be used for sorting when name column is selected in Datatables.
     *
     * @return string
     */
    public static function laratablesOrderFecha()
    {
        return 'fecha';
    }

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\InvitadoAnalisis $invitadoAnalisis
     * @return string
     */
    public static function laratablesCustomAction($invitadoAnalisis)
    {
        return view('invitado.includes.action')->with(array(
            'invitadoAnalisis' => $invitadoAnalisis
        ))->render();
    }
}
