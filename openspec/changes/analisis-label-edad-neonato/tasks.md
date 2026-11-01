## 1. Implementación en `app/Analisis.php`

- [ ] 1.1 En `getLabelEdadAttribute()`, agregar una condición para `edad` real y positiva menor a `0.08` (`$this->edad > 0 && $this->edad < 0.08`) que retorne `"neonato"`, evaluada después del chequeo existente de `empty($this->edad) || $this->edad <= 0` (que no cambia). Verificar con `php -l app/Analisis.php` (sin errores de sintaxis).

## 2. Pruebas automatizadas (no requieren base de datos)

- [ ] 2.1 Crear `tests/Unit/AnalisisLabelEdadTest.php` que instancie `new Analisis(['edad' => <valor>])` (sin guardar, sin tocar la BD) y verifique con `./vendor/bin/phpunit --filter=AnalisisLabelEdadTest`:
  - `edad = 0.03` → `"neonato"`
  - `edad = 0.07` → `"neonato"`
  - `edad = 0.08` → `"1 mes"` (no `"neonato"`, confirma el límite exacto)
  - `edad = null` → `"0 meses"` (sin cambio de comportamiento)
  - `edad = 0` → `"0 meses"` (sin cambio de comportamiento)
  - `edad = 1.5` → `"1 año y 6 meses"` (regresión del caso existente de años+meses)

## 3. Verificación manual (Asignada a: usuario — Claude no verifica en navegador)

- [ ] 3.1 Abrir el reporte de citología o de prueba (labci) de un análisis con `edad` entre `0` y `0.08` y confirmar que el campo de edad muestra "neonato" en el reporte renderizado.
