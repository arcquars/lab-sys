## Why

En el listado de análisis (`AnalisisController@getDatatablesData`, usado por `resources/views/analisis/home.blade.php`), la caja de búsqueda global de DataTables (`$searchG`) solo compara contra la columna `codigo`. Si un usuario escribe el nombre o apellido de un paciente en esa caja, no encuentra resultados, aunque las columnas "Cliente"/"Ap" sí tengan búsqueda individual por columna. El usuario espera que la búsqueda global también encuentre por nombre/apellido del paciente.

## What Changes

- En `getDatatablesData`, la condición actual `->where('codigo', 'like', '%'.$searchG.'%')` se reemplaza por un grupo `(codigo LIKE %searchG% OR nombres LIKE %searchG% OR apellidos LIKE %searchG%)`, manteniendo el resto de filtros (scoping por doctor, `supervisar`, búsquedas por columna de `nombres`/`apellidos`) como condiciones AND separadas, sin alterarlas.
- Se aplica el mismo cambio a las dos ramas del método (`if($user->person)` y el `else`), que hoy tienen el mismo patrón duplicado.
- Corrección de diseño respecto al precedente existente en `getDatatablesTecnico` (mismo archivo, líneas 945-962): ese método usa `->orWhere('codigo', ...)` encadenado al nivel superior, lo cual rompe el AND con los filtros anteriores (bug de precedencia ya existente, fuera de alcance de este change). En este change el nuevo OR se escribe agrupado (`->where(function(){...})`) para que no se repita ese problema — esto es crítico en la rama con persona vinculada, que tiene un filtro de seguridad (doctor solo ve sus propios análisis o los que supervisa) que no debe poder saltarse por una coincidencia de texto en la búsqueda global.

## Capabilities

### New Capabilities
- `analisis-listado`: comportamiento de búsqueda/filtrado del listado de análisis (`getDatatablesData`), incluyendo cómo interactúan la búsqueda global de DataTables y las búsquedas por columna.

### Modified Capabilities
No aplica (capability nueva, no existe spec previo para el listado de análisis).

## Impact

- Archivo afectado: `app/Http/Controllers/AnalisisController.php`, método `getDatatablesData` (ambas ramas, líneas ~424-437 y ~440-446).
- Alcance: backend (consulta Eloquent/Laratables), sin cambios de rutas, vistas, ni migraciones. Compatible con PHP 7.4 / Laravel 6.x (no se requieren features nuevas del lenguaje ni del framework).
- No afecta el método `getDatatablesTecnico` (su bug de precedencia queda fuera de alcance de este change).
