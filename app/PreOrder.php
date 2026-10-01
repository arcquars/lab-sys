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
