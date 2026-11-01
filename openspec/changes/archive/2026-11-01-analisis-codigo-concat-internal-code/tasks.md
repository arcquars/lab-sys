## 1. Implementación en `resources/views/analisis/home.blade.php`

- [x] 1.1 Remover `<th>Cód. Interno</th>` del `<thead>` (agregado en un change anterior), dejando 16 `<th>` nuevamente. Verificar visualmente que el `<thead>` ya no tiene esa celda.
- [x] 1.2 Cambiar `{name: 'internal_code'}` a `{name: 'internal_code', visible: false}` en el array `columns`, sin mover su posición (índice 16) ni tocar las columnas ocultas siguientes (`fecha_cierre`, `send_sms`, `imprimir_firma`, `supervisar`, `imprimir_firma_supervisor`). Verificar con `php -l` no aplica (es JS embebido en Blade); verificar que el archivo sigue siendo válido revisando que no se rompió ninguna llave/paréntesis del array `columns`.
- [x] 1.3 Agregar un `render` a la columna `{name: 'codigo'}` que devuelva `data + ' (' + row[16] + ')'` cuando `row[16]` (internal_code) sea verdadero, y `data` sin modificar en caso contrario.

## 2. Verificación manual end-to-end (Asignada a: usuario — Claude no verifica en navegador)

- [x] 2.1 Abrir el listado de análisis (`analisis.home`) y confirmar que ya no aparece una columna "Cód. Interno" visible.
- [x] 2.2 Confirmar que un análisis con `internal_code` registrado muestra en la columna de código algo como `L-26-0023 (495)`.
- [x] 2.3 Confirmar que un análisis sin `internal_code` sigue mostrando solo su `codigo`, sin paréntesis vacíos ni espacios extra.
- [x] 2.4 Confirmar que el checkbox de "Interconsultados" (columna `supervisar`) sigue funcionando igual que antes (sin regresión de índices).
