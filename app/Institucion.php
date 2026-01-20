<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institucion extends Model
{
    use SoftDeletes;
    protected $table = 'instituciones';

    protected $fillable = [
        'nombre',
        'telefono',
        'is_convenio'
    ];

    protected $dates = ['deleted_at'];


    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Institucion
     * @return string
     */
    public static function laratablesCustomAction($institucion)
    {
        return view('institucion.includes.action')->with(array('id' => $institucion->id))->render();
    }
}

/*
En tu `StoreRequest` o validación del Controlador:**

```php
use Illuminate\Validation\Rule;

// ...

$request->validate([
    'nombre' => [
        'required',
        'string',
        'max:255',
        // Regla: Único en la tabla 'instituciones', columna 'nombre'
        // PERO solo donde deleted_at sea NULL (registros activos)
        Rule::unique('instituciones')->whereNull('deleted_at'),
    ],
    // ... otros campos
]);
```

**Para la Edición (Update):**
Cuando edites, debes ignorar el ID actual para que no marque error consigo mismo.

```php
$request->validate([
    'nombre' => [
        'required',
        Rule::unique('instituciones')
            ->ignore($id) // Ignorar el registro actual
            ->whereNull('deleted_at') // Solo validar contra activos
    ],
]);
*/