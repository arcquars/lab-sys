## 1. Esquema y relaciones

- [x] 1.1 Crear una migración nueva para `analisis.is_industrial` boolean no nullable con default `false`; verificar el archivo con `php -l` y revisar que no altera migraciones históricas ni requiere modificar análisis existentes.
- [x] 1.2 Crear una migración nueva para `industrial_exhibition` con las columnas de `design.md`, `analisis_id` único, FKs de tipos compatibles, cascada hacia el análisis y autor en `users`; verificar sintaxis con `php -l` y revisar `up()`/`down()` sin ejecutar migraciones.
- [x] 1.3 Agregar `app/IndustrialExhibition.php`, sus relaciones y conversiones de fechas, y la relación `industrialExhibition` y conversión booleana en `app/Analisis.php`; verificar tabla singular, claves, fechas opcionales y relación uno a uno con pruebas unitarias sin escritura en BD.

## 2. Validación y persistencia

- [x] 2.1 Extender `StoreAnalisisPost` con estado booleano y reglas industriales condicionales después de la rama de convenios; verificar mediante validación en memoria datos mínimos, requeridos ausentes, límites de 250/251 caracteres, fechas inválidas y campos residuales cuando el indicador es falso.
- [x] 2.2 Extender `UpdateAnalisisPost` resolviendo tipo y estado desde el análisis existente y diferenciando control omitido de desactivación explícita; verificar con un análisis simulado validación de edición industrial, preservación por omisión y rechazo de activación fuera de LABCI.
- [x] 2.3 Integrar en `AnalisisController::store()` el indicador, edad cero industrial, autor autenticado y creación del detalle dentro de la transacción del análisis, pruebas y registro de edición; verificar con pruebas simuladas la unidad de guardado y su reversión ante fallo, conservando la integración de preorden y los flashes posteriores al éxito.
- [x] 2.4 Integrar en `AnalisisController::update()` bloqueo del análisis y actualización atómica del indicador, detalle, pruebas y cambios relacionados; excluir los campos industriales del llenado genérico y verificar las cuatro transiciones de la tabla de `design.md`, autoría conservada, ausencia de duplicados y preservación de resultados/métodos retenidos.
- [x] 2.5 Implementar la eliminación del detalle solo al guardar una desactivación explícita y conservarlo si no se administra la modalidad; verificar mediante pruebas simuladas que un fallo revierte también la eliminación y que una reactivación posterior crea un detalle nuevo sin recuperar datos borrados.
- [x] 2.6 Cargar el detalle en la edición LABCI de `AnalisisController` y en creación/consulta de resultados y reporte de `TestController`; verificar que las vistas reciben la relación y que no cambia la selección de plantilla, códigos ni la selección de pruebas.

## 3. Formularios clásico y avanzado

- [x] 3.1 Agregar hidden `is_industrial = 0`, checkbox y los cinco campos con etiquetas, límites, errores y valores anteriores/guardados en ambos formularios; verificar por renderizado sin BD estado clínico inicial, edición industrial y recuperación posterior a errores con prioridad de `old()`.
- [x] 3.2 Agregar el comportamiento jQuery que alterna Edad, datos demográficos, etiqueta Cliente y bloque industrial, junto con `disabled`/`required`; verificar en ambos formularios que alternar sin guardar no realiza solicitudes destructivas ni pierde temporalmente los valores ingresados.
- [x] 3.3 Ajustar los envíos del carrito avanzado para comprobar validez antes de enviar o deshabilitar botones; verificar el botón clásico y los botones avanzados de escritorio/móvil con Producto o Fecha de ensayo ausentes y confirmar que los errores permiten corregir y reenviar.
- [x] 3.4 Resolver el valor clínico de Edad al volver desde modo industrial sin restaurar historial inexistente ni alterar `Person`; verificar que se envía una edad válida o cero según el formulario y que modo industrial siempre guarda cero.

## 4. Ficha y reporte LABCI

- [x] 4.1 Adaptar `resources/views/citologia/partial/cliente-head.blade.php` con rama industrial, Cliente y bloque de muestra, conservando la rama clínica y los controles existentes; verificar por renderizado sin BD que una persona con nacimiento registrado no produce edad ni sexo en modo industrial y que siguen presentes códigos, procedencia y demás datos generales.
- [x] 4.2 Adaptar `resources/views/test/labci/partials/reporte-client.blade.php` con Cliente y datos industriales separados, fechas `Y-m-d`, opcionales `--` y texto escapado; verificar renderizado con detalle completo, opcionales vacíos, relación ausente y texto de 250 caracteres, conservando el formato clínico cuando el indicador es falso.

## 5. Verificación integrada y entrega

- [x] 5.1 Crear pruebas enfocadas de validación y presentación sin escritura en BD para los escenarios de `specs/industrial-samples/spec.md`, usando modelos en memoria y dobles de relaciones/consultas cuando corresponda; verificar que cubren tanto la rama clínica como la industrial, incluyendo convenios y recuperación de errores.
- [x] 5.2 Crear pruebas simuladas del guardado transaccional, desactivación, control omitido y autoría, y ejecutar `./vendor/bin/phpunit --filter=IndustrialSample` junto con `./vendor/bin/phpunit tests/Unit/AnalisisLabelEdadTest.php`; verificar éxito o registrar bloqueos concretos. Ejecutar directamente dentro del contenedor php74, sin prefijo Docker y sin ejecutar suites que migren o escriban la BD del entorno.
- [x] 5.3 Entregar un procedimiento de aceptación de persistencia para un entorno de prueba independiente: creación desde ambas interfaces, edición en v2, unicidad y FK, fallos con rollback, conservación de resultados/métodos, preorden y eliminación del análisis con cascada; verificar que el procedimiento indica datos y resultados esperados y que cualquier ejecución que escriba BD queda a cargo del operador de ese entorno.
- [x] 5.4 Verificar la maquetación industrial y clínica con datos en memoria en ambas interfaces y en el reporte LABCI, incluyendo escritorio, móvil, valores opcionales vacíos y producto largo; registrar resultados visuales o limitaciones si las herramientas disponibles no permiten renderizar esas superficies sin escribir la BD.
- [x] 5.5 Revisar el diff final y la compatibilidad PHP 7.4/Laravel 6.x/Bootstrap 4, comprobar sintaxis de los PHP modificados y ejecutar `openspec validate add-industrial-samples --strict`; verificar que los cambios corresponden al alcance y documentar las migraciones pendientes de despliegue y cualquier verificación que requiera ejecución operativa.
