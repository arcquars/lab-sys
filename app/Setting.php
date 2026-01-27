<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
        'description'
    ];

    /**
     * Obtiene el valor de una configuración por su clave.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Crea o actualiza una configuración.
     *
     * @param string $key
     * @param mixed $value
     * @param string|null $description
     * @return \App\Setting
     */
    public static function set($key, $value, $description = null)
    {
        $data = ['value' => $value];
        if ($description) {
            $data['description'] = $description;
        }

        return self::updateOrCreate(['key' => $key], $data);
    }
}