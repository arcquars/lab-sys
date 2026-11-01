## Why

`Analisis::getLabelEdadAttribute()` (`app/Analisis.php:119-151`) convierte el campo decimal `edad` (años, donde la parte fraccionaria representa meses, ej. `0.08` = 1 mes) en un texto legible ("2 meses", "1 año y 8 meses", etc.), usado en los reportes de citología y de pruebas (labci). El campo `edad` admite valores decimales pequeños escritos a mano (`step="0.01"` en el formulario) para representar bebés con menos de un mes de vida (ej. `0.03`). Hoy esos valores (`0 < edad < 0.08`) caen en la misma rama que `edad` vacío o `0`, mostrando `"0 meses"` — indistinguible de un análisis sin edad registrada. Se necesita un texto específico ("neonato") para esos casos.

## What Changes

- `getLabelEdadAttribute()` agrega una condición para `edad` real y positiva menor a `0.08` (es decir, `edad > 0 && edad < 0.08`): retorna `"neonato"`.
- El caso existente `empty($this->edad) || $this->edad <= 0` (sin dato de edad, o `0`/negativo) **no cambia**: sigue mostrando `"0 meses"` — se interpreta como "edad no registrada", no como un recién nacido.
- Sin cambios en el resto de la lógica de años/meses.

## Capabilities

### New Capabilities
- `analisis-label-edad`: cómo se calcula y presenta el texto de edad de un análisis (`label_edad`), usado en los reportes de citología y de pruebas.

## Impact

- Archivo afectado: `app/Analisis.php`, método `getLabelEdadAttribute()`.
- Alcance: backend (accessor Eloquent). Se refleja automáticamente donde se usa `$analisis->label_edad`: `resources/views/citologia/partial/cliente-head.blade.php` y `resources/views/test/labci/partials/reporte-client.blade.php`. Sin cambios de rutas, controladores ni migraciones. Compatible con PHP 7.4.
