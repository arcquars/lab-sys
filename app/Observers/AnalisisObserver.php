<?php

namespace App\Observers;

use App\Analisis;
use App\AnalisisLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AnalisisObserver
{
    // =============================================
    // Evento: creación de un nuevo análisis
    // =============================================
    public function created(Analisis $analisis)
    {
        $this->writeLog($analisis, AnalisisLog::EVENT_CREATED, [], $analisis->getAttributes());
    }

    // =============================================
    // Evento: actualización de un análisis existente
    // =============================================
    public function updated(Analisis $analisis)
    {
        // getDirty() devuelve solo los campos que cambiaron
        $dirty = $analisis->getDirty();

        // Filtramos columnas que no queremos auditar (timestamps, etc.)
        $dirty = array_diff_key($dirty, array_flip(AnalisisLog::$ignoredAttributes));

        // Si no hubo cambios relevantes, no registramos nada
        if (empty($dirty)) {
            return;
        }

        // Construimos los snapshots de antes/después solo para los campos modificados
        $oldValues = [];
        $newValues = [];

        foreach ($dirty as $column => $newValue) {
            // getOriginal() tiene el valor antes del save()
            $oldValues[$column] = $analisis->getOriginal($column);
            $newValues[$column] = $newValue;
        }

        $this->writeLog($analisis, AnalisisLog::EVENT_UPDATED, $oldValues, $newValues);
    }

    // =============================================
    // Evento: eliminación (física o lógica)
    // =============================================
    public function deleted(Analisis $analisis)
    {
        // Guardamos snapshot completo del registro antes de desaparecer
        $this->writeLog($analisis, AnalisisLog::EVENT_DELETED, $analisis->getAttributes(), []);
    }

    // =============================================
    // Método privado: escribe el registro en la tabla
    // =============================================
    private function writeLog(Analisis $analisis, string $event, array $oldValues, array $newValues)
    {
        $user = Auth::user();

        AnalisisLog::create([
            'analisis_id' => $analisis->id,
            'user_id'     => $user ? $user->id   : null,
            'user_name'   => $user ? $user->name : 'Sistema',
            'event'       => $event,
            'old_values'  => !empty($oldValues) ? json_encode($oldValues) : null,
            'new_values'  => !empty($newValues) ? json_encode($newValues) : null,
            'ip_address'  => Request::ip(),
            'user_agent'  => Request::header('User-Agent'),
        ]);
    }
}