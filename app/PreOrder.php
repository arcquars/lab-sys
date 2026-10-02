<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreOrder extends Model
{
    use SoftDeletes;

    public const STATE_NUEVO     = 'nuevo';
    public const STATE_RECHASADO = 'rechasado';
    public const STATE_CREADO    = 'creado';

    protected $table = 'pre_orders';

    protected $fillable = [
        'order_number', 'branch_id', 'is_stat',
        'patient_full_name', 'patient_age', 'patient_gender',
        'patient_ci', 'patient_birth_date',
        'patient_diagnosis', 'patient_physician',
        'tests_snapshot', 'state', 'analisis_id',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'is_stat'            => 'boolean',
        'patient_birth_date' => 'date',
        'tests_snapshot'     => 'array',
    ];

    public function getAllowedTransitions()
    {
        return config('clinica.pre_order_state_transitions.' . $this->state, []);
    }

    public function statesLog()
    {
        return $this->hasMany(OrderStateLog::class, 'pre_order_id');
    }

    /**
     * Pinta la columna "action" en la DataTable server-side (Laratables).
     * Llama al partial preorder/includes/action con los datos de la fila.
     * state/patient_ci/patient_full_name alimentan el botón "Crear análisis"
     * (visible solo cuando state = nuevo).
     */
    public static function laratablesCustomAction($preorder)
    {
        return view('preorder.includes.action')->with([
            'id'                 => $preorder->id,
            'state'              => $preorder->state,
            'patient_ci'         => $preorder->patient_ci,
            'patient_full_name'  => $preorder->patient_full_name,
            'patient_birth_date' => $preorder->patient_birth_date,
            'patient_gender'     => $preorder->patient_gender,
            'analisis_id'        => $preorder->analisis_id,
        ])->render();
    }

    /**
     * Pinta la columna "state" como badge Bootstrap 4 coloreado.
     * Colors: nuevo=warning, creado=success, rechasado=danger.
     *
     * NOTA: Laratables excluye columnas custom del SELECT SQL (los datos no
     * llegan hidratados al servidor). laratablesAdditionalColumns() los
     * vuelve a incluir en el SELECT específicamente para que CustomState
     * pueda acceder a $preorder->state.
     */
    public static function laratablesCustomState($preorder)
    {
        $colors = [
            self::STATE_NUEVO     => 'warning',
            self::STATE_CREADO    => 'success',
            self::STATE_RECHASADO => 'danger',
        ];
        $color = $colors[$preorder->state] ?? 'secondary';
        return '<span class="badge badge-' . $color . '">' . $preorder->state . '</span>';
    }

    /**
     * Traduce el genero almacenado (F/M/O) a texto legible para la tabla.
     */
    public static function laratablesCustomPatientGender($preorder)
    {
        $map = ['F' => 'FEMENINO', 'M' => 'MASCULINO', 'O' => 'OTRO'];
        return $map[$preorder->patient_gender] ?? '--';
    }

    /**
     * Renderiza is_stat como badge: rojo para URGENTE, plomo para NORMAL.
     */
    public static function laratablesCustomIsStat($preorder)
    {
        if ($preorder->is_stat) {
            return '<span class="badge badge-danger">URGENTE</span>';
        }
        return '<span class="badge badge-secondary">NORMAL</span>';
    }

    /**
     * Declara columnas adicionales al SELECT del query de Laratables.
     * Necesario para columnas custom (state, patient_gender, is_stat) porque
     * isCustomColumn() las excluye del SELECT automatico. analisis_id se
     * añade para que laratablesCustomAction() pueda condicionar el botón
     * "Ir al análisis" cuando la pre-orden ya tiene un analisis creado.
     */
    public static function laratablesAdditionalColumns()
    {
        return ['state', 'patient_gender', 'is_stat', 'analisis_id'];
    }

    public function canTransitionTo($newState)
    {
        return in_array($newState, $this->getAllowedTransitions(), true);
    }

    /**
     * Cambia el estado del pre_order respetando la state machine
     * definida en config/clinica.php. Registra la transición en
     * order_states_log dentro de la misma transacción.
     *
     * @param  string  $newState
     * @param  int|null  $userId
     * @param  string|null  $note
     * @return $this
     *
     * @throws \DomainException si la transición no está permitida.
     */
    public function changeState($newState, $userId, $note = null)
    {
        if (! $this->canTransitionTo($newState)) {
            throw new \DomainException(sprintf(
                'Transición inválida: %s → %s',
                $this->state,
                $newState
            ));
        }

        \DB::transaction(function () use ($newState, $userId, $note) {
            $previous = $this->state;

            $this->forceFill([
                'state'      => $newState,
                'updated_by' => $userId,
            ])->save();

            $this->statesLog()->create([
                'previous_state' => $previous,
                'new_state'      => $newState,
                'user_id'        => $userId,
                'note'           => $note,
            ]);
        });

        return $this;
    }
}
