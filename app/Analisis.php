<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Config;
use Illuminate\Support\Facades\Auth;

class Analisis extends Model
{
    const CITOLOGIA = 'CITOLOGIA';
    const BIOPSIA = 'BIOPSIA';
    const INMUNOHISTOQUIMICA = 'INMUNOHISTOQUIMICA';
    const BIOLOGIA_MOLECULAR = 'BIOLOGIA_MOLECULAR'; // BIOLOGIA_MOLECULAR
    const BETHESDA = 'BETHESDA';
    const HISTOPATOLOGICO = 'HISTOPATOLOGICO';
    const LIQUIDOS = 'LIQUIDOS';
    const BIOPSIA_DE_RINON = 'BIOPSIA DE RIÑON';
    // const PRUEBA = 'PRUEBA';
    const PRUEBA = 'LABCI';

//    const TIPO_PAGO_ACUENTA = ['EFECTIVO', 'TRANSFERENCIA'];
//    const TIPO_PAGO_EFECTUADO = ['EFECTIVO', 'TRANSFERENCIA'];
    const TIPO_PAGO_ACUENTA = ['EFECTIVO', 'QR', 'TARJETA'];
    const TIPO_PAGO_EFECTUADO = ['EFECTIVO', 'QR', 'TARJETA'];

    protected $table = 'analisis';

    protected $fillable = [
        'doctor',
        'tipo_analisis',
        'fecha',
        'region',
        'precio',
        'acuenta',
        'observaciones',
        'adjunto',
        'procedencia',
        'person_id',
        'pago_efectuado',
        'telefono_referencia',
        'doctor',
        'movimiento',
        'persona_entrega',
        'fecha_entrega',
        'fecha_cierre',
        'nit',
        'edad',
        'razon_social',
        'doctor_asignado',
        'send_sms',
        'tipo_pago_acuenta',
        'tipo_pago_efectuado',
        'acuenta_numero_tarjeta',
        'acuenta_banco',
        'saldo_numero_tarjeta',
        'saldo_banco',
        'supervisar',
        'doctor_supervisor',
        'imprimir_firma',
        'internal_code',
        'imprimir_firma_supervisor',
        'comentario_supervisor',
        'user_asig_supervisor',
    ];

    protected $dates = [
        'fecha',
        'fecha_cierre',
        'fecha_entrega'
    ];

    protected $casts = [
        'fecha'  => 'date:Y-m-d',
        'fecha_cierre' => 'datetime:Y-m-d H:m',
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

    public function lastControlEdition(){
        return EditarControl::where('analisis_id',$this->id)->orderBy('created_at', 'desc')->get()->first();
    }

    public function convenio(){
        return $this->hasOne('App\Convenio', 'analisis_id', 'id');
    }

    public function supervisor(){
        return $this->hasOne('App\Doctor', 'id', 'doctor_supervisor');
    }

    public function logs(){
        return $this->hasMany(AnalisisLog::class);
    }

    public function getSupervisores(){
        return AnalisisSupervisor::where('analisis_id', $this->id)->get();
    }

    public function getSupervisoresVerificado(){
        return AnalisisSupervisor::where('analisis_id', $this->id)->where('estado', 'like', AnalisisSupervisor::ESTADO_VERIFICADO)->get();
    }

    public function getAgeByDateAnalisisAttribute(){
        return $this->person->getAgeByDate($this->fecha);
    }

    public function getLabelEdadAttribute()
    {
        if($this->edad < 1){
            return ceil($this->edad*12) . " meses";
        }
        return intval($this->edad) . " años";
    }

//    public function isConvenio(){
//        $convenios = explode(',', Config::get('clinica.convenios_id'));
//
//        $valid = false;
//        foreach($convenios as $con){
//            if($this->procedencia == $con){
//                $valid = true;
//            }
//        }
//        return $valid;
//    }

    public function isConvenio(){
        $isConvenio = false;
        if($this->institucion->is_convenio == 1){
            $isConvenio = true;
        }
        return $isConvenio;
    }

    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function hasHistory(){
        $count = Analisis::where('person_id', $this->person_id)->count();
        if($count > 1)
            return true;
        return false;
    }

    public function isChangeCitologia(){
        $valid = false;
        if($this->tipo_analisis == Analisis::BETHESDA || $this->tipo_analisis == Analisis::LIQUIDOS){
            $valid = true;
            if($this->tipo_analisis == Analisis::BETHESDA){
                $bethesda = Bethesda::where('analisis_id', '=', $this->id)->count();
                if($bethesda > 0){
                    $valid = false;
                }
            }
            if($this->tipo_analisis == Analisis::LIQUIDOS){
                $liquidos = Liquido::where('analisis_id', '=', $this->id)->count();
                if($liquidos > 0){
                    $valid = false;
                }
            }
        }
        return $valid;
    }
    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Analisis $analisis
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
        $printAnalisis = 'home';
        switch ($analisis->tipo_analisis){
            case Analisis::CITOLOGIA:
                if(Resultado::where('analisis_id', $analisis->id)->count() > 0){
                    $routeView = 'citologia.viewResultado';
                    $printAnalisis = 'citologia.reporte';
                    $isHasResult = true;
                }
                break;
            case Analisis::INMUNOHISTOQUIMICA:
                if(Histoquimica::where('analisis_id', $analisis->id)->count() > 0){
                    $routeView = 'histo.viewResultado';
                    $printAnalisis = 'histo.reporte';
                    $isHasResult = true;
                }
                break;
            case Analisis::BIOPSIA:
                if(Biopsia::where('analisis_id', $analisis->id)->count() > 0){
                    $routeView = 'biopsia.viewResultado';
                    $printAnalisis = 'biopsia.reporte';
                    $isHasResult = true;
                }
                break;
            case Analisis::HISTOPATOLOGICO:
                if(Biopsia::where('analisis_id', $analisis->id)->count() > 0){
                    $routeView = 'biopsia.viewResultado';
                    $printAnalisis = 'biopsia.reporte';
                    $isHasResult = true;
                }
                break;
            case Analisis::BIOLOGIA_MOLECULAR:
                if(BiologiaMolecular::where('analisis_id', $analisis->id)->count() > 0){
                    $routeView = 'biologiam.viewResultado';
                    $printAnalisis = 'biologiam.reporte';
                    $isHasResult = true;
                }
                break;
            case Analisis::BETHESDA:
                if(Bethesda::where('analisis_id', $analisis->id)->count() > 0){
                    $routeView = 'bethesda.viewResultado';
                    $printAnalisis = 'bethesda.reporte';
                    $isHasResult = true;
                }
                break;
            case Analisis::LIQUIDOS:
                if(Liquido::where('analisis_id', $analisis->id)->count() > 0){
                    $routeView = 'liquidos.viewResultado';
                    $printAnalisis = 'liquidos.reporte';
                    $isHasResult = true;
                }
                break;
            case Analisis::PRUEBA:
                if(AnalysisTestResult::where('analysis_id', $analisis->id)->whereNotNull('result')->count() > 0){
                    $routeView = 'test.viewResultado';
                    $printAnalisis = 'test.reporte';
                    $isHasResult = true;
                }
        }

        $hasAnalisisSupervisado = false;
        $hasAnalisisSupervisadoEstado = false;
        if(Auth::user()->hasRole(Role::MEDICO) && $analisis->supervisar){
            $hasAnalisisSupervisado = true;
            $analisisSupervisado = AnalisisSupervisor::where('doctor_id',Auth::user()->person)
                ->where('estado', AnalisisSupervisor::ESTADO_VERIFICADO)
                ->where('analisis_id', $analisis->id)->first();
            if($analisisSupervisado){
                $hasAnalisisSupervisadoEstado = true;
            }
        }

        return view('analisis.includes.action')->with(array(
            'id' => $analisis->id,
            'isHasResult' => $isHasResult,
            'routeView' => $routeView,
            'printAnalisis' => $printAnalisis,
            'imprimir_firma' => $analisis->imprimir_firma,
            'acuenta' => $analisis->acuenta,
            'precio' => $analisis->precio,
            'pago_efectuado' => $analisis->pago_efectuado,
            'convenio' => $analisis->isConvenio(),
            'entregado' => $entregado,
            'fechaCierre' => $analisis->fecha_cierre,
            'send_sms' => $analisis->send_sms,
            'hasAnalisisSupervisado' => $hasAnalisisSupervisado,
            'hasAnalisisSupervisadoEstado' => $hasAnalisisSupervisadoEstado
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
        if($analisis->person){
            $nombres = $analisis->person->nombres? $analisis->person->nombres : '';
            $apellidos = $analisis->person->apellidos? $analisis->person->apellidos : '';
            $materno = $analisis->person->apellido_materno? $analisis->person->apellido_materno : '';
            return $nombres . " " . $apellidos . " " . $materno;
        }

        return "";
    }

    /**
     * Returns the name column value for datatables.
     *
     * @param \App\Analisis
     * @return string
     */
    public static function laratablesDoctorasigNombres($analisis)
    {
        if($analisis->doctorasig){
            $nombres = $analisis->doctorasig->nombres? $analisis->doctorasig->nombres : '';
            $apellidos = $analisis->doctorasig->apellidos? $analisis->doctorasig->apellidos : '';
            $materno = $analisis->doctorasig->apellido_materno? $analisis->doctorasig->apellido_materno : '';
            return $nombres . " " . $apellidos . " " . $materno;
        }

        return "";
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

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Analisis
     * @return string
     */
    public static function laratablesCustomActionGuest($analysis)
    {
        $isHasResult = false;
        $routeView = '';
        $printAnalisis = '';
        if(AnalysisTestResult::where('analysis_id', $analysis->id)->whereNotNull('result')->count() > 0){
            $routeView = 'test.viewResultado';
            $printAnalisis = 'test.reporte';
            $isHasResult = true;
        }
        return view('analisis.includes.action-guest')->with(array(
            "id" => $analysis->id,
            "isHasResult" => $isHasResult,
            "printAnalisis" => $printAnalisis,
            'imprimir_firma' => $analysis->imprimir_firma,
            "routeView" => $routeView
        ))->render();
    }

    /**
     * Adds the condition for searching the name of the user in the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @param string search term
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function laratablesSearchPersonNombres($query, $searchValue)
    {
        return $query->orWhereHas('person', function ($query) use ($searchValue) {
            $query->where('nombres', 'like', "%". $searchValue ."%");
        });
    }

//    public static function laratablesQueryConditions($query)
//    {
//        return $query->join('persons', 'persons.id', 'analisis.person_id');
//    }

    /**
     * Eager load media items of the role for displaying in the datatables.
     *
     * @return callable
     */
    public static function laratablesAnalisisRelationQuery()
    {
        return function ($query) {
            $query->with('person');
        };
    }

    /**
     * @param Analisis $analisis
     * @param string $username
     */
    public static function saveFechaEntrega($analisis, $username){
        if(!isset($analisis->fecha_entrega)){
            $analisis->fecha_entrega = Carbon::now();
            //$analisis->persona_entrega = $username;
            $analisis->save();
        }
    }

    public static function reporteUserWork($fechaInicio, $fechaFin){
        $userWork = EditarControl::whereBetween('analisis.fecha', [$fechaInicio, $fechaFin])
            ->join('analisis', 'analisis.id', '=', 'editar_controles.analisis_id')
            ->join('users', 'users.id', '=', 'editar_controles.user_id')
            ->selectRaw('editar_controles.user_id, users.name')->groupBy('editar_controles.user_id')->get();
//        $worksUsers = EditarControl::whereBetween('analisis.fecha', [$fechaInicio, $fechaFin])
//            ->join('analisis', 'analisis.id', '=', 'editar_controles.analisis_id')
//            ->join('users', 'users.id', '=', 'editar_controles.user_id')
//            ->selectRaw('users.id, users.name, analisis.tipo_analisis, count(analisis.tipo_analisis) as count')
//            ->groupBy('users.id', 'analisis.tipo_analisis')->get();

        $resultWorks = [];
        array_push($resultWorks, [
            'Usuario',
            Analisis::CITOLOGIA,
            Analisis::BETHESDA,
            Analisis::LIQUIDOS,
            Analisis::BIOPSIA,
            Analisis::INMUNOHISTOQUIMICA,
            Analisis::BIOLOGIA_MOLECULAR,
            Analisis::BIOPSIA_DE_RINON]);

        foreach ($userWork as $us){

            $citologiaCount = EditarControl::whereBetween('analisis.fecha', [$fechaInicio, $fechaFin])
                ->where('analisis.tipo_analisis', '=', Analisis::CITOLOGIA)
                ->where('editar_controles.user_id', '=', $us->user_id)
            ->join('analisis', 'analisis.id', '=', 'editar_controles.analisis_id')
            ->join('users', 'users.id', '=', 'editar_controles.user_id')
            ->selectRaw('count(distinct analisis.id) as count')->first()->count;

            $bethesdaCount = EditarControl::whereBetween('analisis.fecha', [$fechaInicio, $fechaFin])
                ->where('analisis.tipo_analisis', '=', Analisis::BETHESDA)
                ->where('editar_controles.user_id', '=', $us->user_id)
                ->join('analisis', 'analisis.id', '=', 'editar_controles.analisis_id')
                ->join('users', 'users.id', '=', 'editar_controles.user_id')
                ->selectRaw('count(distinct analisis.id) as count')->first()->count;
            $liquidosCount = EditarControl::whereBetween('analisis.fecha', [$fechaInicio, $fechaFin])
                ->where('analisis.tipo_analisis', '=', Analisis::LIQUIDOS)
                ->where('editar_controles.user_id', '=', $us->user_id)
                ->join('analisis', 'analisis.id', '=', 'editar_controles.analisis_id')
                ->join('users', 'users.id', '=', 'editar_controles.user_id')
                ->selectRaw('count(distinct analisis.id) as count')->first()->count;
            $inmunoCount = EditarControl::whereBetween('analisis.fecha', [$fechaInicio, $fechaFin])
                ->where('analisis.tipo_analisis', '=', Analisis::INMUNOHISTOQUIMICA)
                ->where('editar_controles.user_id', '=', $us->user_id)
                ->join('analisis', 'analisis.id', '=', 'editar_controles.analisis_id')
                ->join('users', 'users.id', '=', 'editar_controles.user_id')
                ->selectRaw('count(distinct analisis.id) as count')->first()->count;
            $biologiamCount = EditarControl::whereBetween('analisis.fecha', [$fechaInicio, $fechaFin])
                ->where('analisis.tipo_analisis', '=', Analisis::BIOLOGIA_MOLECULAR)
                ->where('editar_controles.user_id', '=', $us->user_id)
                ->join('analisis', 'analisis.id', '=', 'editar_controles.analisis_id')
                ->join('users', 'users.id', '=', 'editar_controles.user_id')
                ->selectRaw('count(distinct analisis.id) as count')->first()->count;
            $biopsiaCount = EditarControl::whereBetween('analisis.fecha', [$fechaInicio, $fechaFin])
                ->where('analisis.tipo_analisis', '=', Analisis::BIOPSIA)
                ->where('editar_controles.user_id', '=', $us->user_id)
                ->join('analisis', 'analisis.id', '=', 'editar_controles.analisis_id')
                ->join('users', 'users.id', '=', 'editar_controles.user_id')
                ->selectRaw('count(distinct analisis.id) as count')->first()->count;
            $biopsiaRinonCount = EditarControl::whereBetween('analisis.fecha', [$fechaInicio, $fechaFin])
                ->where('analisis.tipo_analisis', '=', Analisis::HISTOPATOLOGICO)
                ->where('editar_controles.user_id', '=', $us->user_id)
                ->join('analisis', 'analisis.id', '=', 'editar_controles.analisis_id')
                ->join('users', 'users.id', '=', 'editar_controles.user_id')
                ->selectRaw('count(distinct analisis.id) as count')->first()->count;
            array_push($resultWorks, [$us->name, $citologiaCount, $bethesdaCount, $liquidosCount, $biopsiaCount, $inmunoCount, $biologiamCount, $biopsiaRinonCount]);
        }
        return $resultWorks;
    }
}
