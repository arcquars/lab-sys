<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InvitadoAnalisis extends Model
{
    protected $table = 'invitados_analisis';

    protected $fillable = [
        'user_id',
        'analisis_id'
    ];

    public function analisis(){
        return $this->belongsTo('App\Analisis');
    }

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
        join('instituciones', 'analisis.procedencia', '=', 'instituciones.id')->
        join('persons', 'analisis.person_id', '=', 'persons.id')
            ->select(\DB::raw('analisis.id, analisis.codigo, analisis.tipo_analisis, analisis.fecha, persons.nombres, persons.apellidos, persons.apellido_materno, analisis.imprimir_firma, instituciones.nombre, analisis.doctor, (select DATE_FORMAT(MAX(ec.created_at), \'%Y-%m-%d\') from editar_controles ec where ec.analisis_id=analisis.id) as fecha_conclucion'));
//        select(
//            'analisis.id', 'analisis.codigo', 'analisis.tipo_analisis',
//            'analisis.fecha', 'persons.nombres', 'persons.apellidos',
//            'persons.apellido_materno', 'analisis.imprimir_firma',
//            'instituciones.nombre', 'analisis.doctor',
//            '(select MAX(ec.created_at) from editar_controles ec where ec.analisis_id=analisis.id) as fecha_conclucion');
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

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\InvitadoAnalisis $invitadoAnalisis
     * @return string
     */
    public static function laratablesCustomActionAdmin($invitadoAnalisis)
    {
        return view('invitado-admin.includes.action_admin')->with(array(
            'invitadoAnalisis' => $invitadoAnalisis
        ))->render();
    }

    public static function refreshAnalisisDoctor($userId){
        $fechaActual = Carbon::now();

        $invitadoAsignados = InvitadoAsignaciones::where('user_id', '=', $userId)->get();
        foreach ($invitadoAsignados as $ia) {
            $invitadoAnalisis = null;
            $analisisMaxFecha = null;
            $analisis = null;

            $anaId = [];
            if(strcmp($ia->tipo, InvitadoAsignaciones::TIPO_PERSONA) == 0){
                $procedencia = Institucion::where('nombre', 'PERSONA PARTICULAR')->first();
                $invitadoAnalisis = DB::table('invitados_analisis')
                    ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
                    ->where('invitados_analisis.user_id', '=', $userId)
                    ->where('analisis.procedencia', '=', $procedencia->id)
                    ->where('analisis.doctor', '=', $ia->valor)
                    ->select('analisis.id')->get();

                $analisisMaxFecha = DB::table('invitados_analisis')
                    ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
                    ->where('invitados_analisis.user_id', '=', $userId)
                    ->where('analisis.procedencia', '=', $procedencia->id)
                    ->where('analisis.doctor', '=', $ia->valor)
                    ->max('analisis.fecha');

                foreach ($invitadoAnalisis as $as){
                    $anaId[] = $as->id;
                }

                $analisis = Analisis::where('doctor', 'like', $ia->valor)
                    ->where('procedencia', '=', $procedencia->id)
                    ->whereBetween('analisis.fecha', [$analisisMaxFecha, $fechaActual])
                    ->whereNotIn('id', $anaId)
                    ->get();

            } else {
                $invitadoAnalisis = DB::table('invitados_analisis')
                    ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
                    ->where('invitados_analisis.user_id', '=', $userId)
                    ->where('analisis.procedencia', '=', $ia->valor)
                    ->select('analisis.id')->get();

                $analisisMaxFecha = DB::table('invitados_analisis')
                    ->join('analisis', 'invitados_analisis.analisis_id', '=', 'analisis.id')
                    ->where('invitados_analisis.user_id', '=', $userId)
                    ->where('analisis.procedencia', '=', $ia->valor)
                    ->max('analisis.fecha');

                foreach ($invitadoAnalisis as $as){
                    $anaId[] = $as->id;
                }

//                dd($anaId);
                $analisis = Analisis::where('procedencia', '=', $ia->valor)
                    ->whereBetween('analisis.fecha', [$analisisMaxFecha, $fechaActual])
                    ->whereNotIn('id', $anaId)
                    ->get();
            }
            foreach ($analisis as $a){
                DB::table('invitados_analisis')->insert(
                    ['user_id' => $userId, 'analisis_id' => $a->id]
                );
            }
        }
    }
}
