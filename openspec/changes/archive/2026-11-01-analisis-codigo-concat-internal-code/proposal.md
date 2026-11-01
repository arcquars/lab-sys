## Why

En un change anterior se agregó la columna `internal_code` visible en la tabla del listado de análisis (`resources/views/analisis/home.blade.php`). El usuario decidió que no debe mostrarse como columna independiente; en su lugar, el `internal_code` (cuando existe) debe mostrarse concatenado junto al `codigo` en su misma columna, por ejemplo `L-26-0023 (495)`.

## What Changes

- La columna `internal_code` pasa a `visible: false` en el array `columns` de DataTables, y se remueve el `<th>Cód. Interno</th>` que se había agregado — queda como columna de solo datos, igual que `persona_entrega`, `fecha_cierre`, etc. (sin `<th>` propio).
- La columna `codigo` agrega un `render` que, si el análisis tiene `internal_code`, muestra `"{codigo} ({internal_code})"`; si no tiene, muestra solo `{codigo}` (comportamiento igual al actual).
- Sin cambios de backend: la búsqueda global por `internal_code` (exacta) y el resto de filtros del listado no se tocan.

## Capabilities

### Modified Capabilities
- `analisis-listado`: se agrega un requisito sobre cómo se presenta `internal_code` en el listado (oculto como columna propia, mostrado concatenado junto a `codigo`).

## Impact

- Archivo afectado: `resources/views/analisis/home.blade.php` (bloque `<thead>` y array `columns` de la inicialización de DataTables).
- Alcance: solo frontend (Blade + jQuery/DataTables). Sin migraciones, sin cambios en `AnalisisController.php` ni en PHP del lado servidor.
- No afecta los índices de columnas ocultas posteriores (`fecha_cierre`, `send_sms`, `imprimir_firma`, `supervisar`, `imprimir_firma_supervisor`): `internal_code` permanece en su misma posición del array (índice 16), solo cambia su visibilidad y se quita su `<th>`.
