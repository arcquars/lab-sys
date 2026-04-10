<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalisisLog extends Model
{
    // Solo usamos created_at, no necesitamos updated_at en un log
    const UPDATED_AT = null;

    // Tipos de eventos posibles
    const EVENT_CREATED = 'created';
    const EVENT_UPDATED = 'updated';
    const EVENT_DELETED = 'deleted';

    protected $table = 'analisis_logs';

    protected $fillable = [
        'analisis_id',
        'user_id',
        'user_name',
        'event',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    // Campos que NO deben registrarse en el log de cambios (ruido innecesario)
    public static $ignoredAttributes = [
        'updated_at',
        'created_at',
    ];

    // =============================================
    // Relaciones
    // =============================================

    /**
     * Usuario que realizó la acción (puede ser null si fue eliminado).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Análisis al que pertenece este log.
     */
    public function analisis()
    {
        return $this->belongsTo(Analisis::class);
    }

    // =============================================
    // Accessors: decodifican JSON automáticamente
    // =============================================

    public function getOldValuesAttribute($value)
    {
        return $value ? json_decode($value, true) : null;
    }

    public function getNewValuesAttribute($value)
    {
        return $value ? json_decode($value, true) : null;
    }

    // =============================================
    // Scopes para filtros comunes
    // =============================================

    public function scopeForAnalisis($query, $analisisId)
    {
        return $query->where('analisis_id', $analisisId);
    }

    public function scopeOfEvent($query, $event)
    {
        return $query->where('event', $event);
    }
}