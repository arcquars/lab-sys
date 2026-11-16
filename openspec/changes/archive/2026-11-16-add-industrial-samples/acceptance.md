# Aceptación de muestras industriales

## Estado de la verificación del agente

- Migraciones nuevas creadas y revisadas como archivos; no se ejecutaron migraciones ni escrituras en la BD del entorno.
- PHPUnit: 19 pruebas industriales, 165 aserciones, y 6 pruebas de regresión de edad, 6 aserciones, aprobadas.
- Las pruebas de persistencia ejecutan los controladores reales con un doble de Query Builder y conexión en memoria que no abre PDO, exige transacción para escribir y simula fallos y rollback. Comprueban creación, edición, desactivación, reactivación, autoría, preorden, resultados retenidos y control omitido. No sustituyen la comprobación de restricciones o aislamiento con un motor de BD real.
- Los dos formularios Blade se renderizaron con modelos en memoria. Las pruebas de jQuery/jsdom sobre ese HTML verificaron alternancia de campos, serialización, valores conservados y validación previa a los manejadores de guardado clásico y avanzado, incluidos los botones de escritorio y móvil.
- Los encabezados clínico e industrial LABCI se procesaron con mPDF en formato Letter. Ambos produjeron un PDF válido de una página, incluyendo un producto largo y valores opcionales vacíos. Es una comprobación del encabezado, no del paginado de un informe completo con resultados.
- La inspección visual de escritorio/móvil queda pendiente: no hay navegador disponible en el contenedor. Se descargó un Chromium temporal para intentar esa verificación, pero faltan sus bibliotecas de sistema (`libnspr4`, `libnss3` y otras dependencias gráficas). No se instalaron paquetes del sistema. Las comprobaciones DOM y mPDF no prueban visualmente distribución, solapamientos o legibilidad del PDF.

## Despliegue y aceptación con una BD independiente

Esta sección es un procedimiento para el operador de un entorno de prueba independiente. Las operaciones de creación, modificación y eliminación se realizan solo allí. Usar una copia o fixtures propios, sin registros del entorno del agente.

### Preparación

1. Tener un cliente de prueba con fecha de nacimiento, sexo y CI registrados, un usuario de recepción, un segundo usuario autorizado, un doctor asignable, una institución sin convenio y al menos dos pruebas LABCI con precio válido.
2. Usar la fecha de ingreso actual para respetar la ventana de validación existente. Configurar el reporte de ese entorno como LABCI y disponer de una preorden nueva para el caso de integración.
3. Revisar y aplicar en ese entorno, en orden, las dos migraciones nuevas:

   ```bash
   php artisan migrate --path=database/migrations/2026_11_15_230503_add_is_industrial_to_analisis_table.php
   php artisan migrate --path=database/migrations/2026_11_15_230514_create_industrial_exhibition_table.php
   ```

   Los comandos del proyecto se ejecutan directamente dentro de php74.

4. Confirmar con consultas SELECT o inspección de esquema que existe `analisis.is_industrial` con default falso, la tabla `industrial_exhibition`, el índice único de `analisis_id` y sus FKs a `analisis` y `users`.

### Casos y resultados esperados

| Caso | Acción en el entorno de prueba | Resultado esperado |
|---|---|---|
| Creación clínica | Crear desde cada interfaz con checkbox desmarcado | Flujo habitual, edad clínica conservada, `is_industrial = 0`, sin detalle industrial |
| Creación industrial mínima | En cada interfaz activar y guardar Producto «Agua de proceso», Fecha de ensayo válida, opcionales vacíos, pruebas y cobro válidos | Un análisis industrial y un único detalle; opcionales null; edad cero; `user_id` del usuario autenticado |
| Campos requeridos | Enviar industrial sin Producto o Fecha de ensayo; repetir con una procedencia de convenio completando sus demás datos | Guardado rechazado, errores correctos, checkbox y valores anteriores recuperados, sin creación parcial |
| Límites y fechas | Probar 250 y 251 caracteres en producto/lote, lote «001-A», fecha imposible y opcionales vacíos | 250 aceptado y 251 rechazado; ceros/letras conservados; fecha imposible rechazada; opcionales vacíos aceptados |
| Edición entre interfaces | Crear desde clásico y abrir Editar análisis | Se usa v2 y se recuperan checkbox y todos los campos industriales |
| Autoría y unicidad | Editar varias veces con el segundo usuario | Mismo detalle y autor original; un registro por análisis |
| Resultados retenidos | Registrar resultado y método de una prueba; editar producto manteniendo esa prueba seleccionada | Resultado y método anteriores intactos |
| Alternancia sin guardar | Desmarcar y volver a marcar, luego abandonar edición | Solo cambia la interfaz; el detalle persistido no se elimina |
| Desactivación inválida | Desmarcar y enviar con otro campo obligatorio inválido | Se muestran errores y vuelve desmarcado; en BD persisten indicador industrial y detalle anteriores |
| Desactivación válida | Desmarcar y guardar un formulario válido con edad clínica | Indicador falso y detalle eliminado en la misma operación; se restaura la presentación clínica |
| Reactivación | Abrir nuevamente y activar tras una desactivación guardada | No reaparecen los datos eliminados; se exigen producto y ensayo; el nuevo detalle registra a su nuevo autor |
| Control omitido | Mediante un harness de integración invocar una actualización válida sin `is_industrial` ni campos industriales | No se elimina ni modifica el detalle ni se desactiva el indicador |
| Tipo no compatible | Enviar activación industrial para un análisis que no sea LABCI | Error de validación y ausencia de cambios industriales |
| Preorden | Crear desde una preorden nueva con modalidad industrial | Se asocian análisis y preorden, cambia su estado y se registra su historial conservando el detalle industrial |
| Unicidad/FK | En un test transaccional independiente intentar un segundo detalle para el mismo análisis y un detalle con análisis/usuario inexistentes | El motor rechaza duplicado y referencias inválidas; finalizar el test con rollback |
| Fallo de creación | En el harness independiente inyectar una excepción al crear el detalle industrial | No quedan análisis, pruebas o auditoría parcialmente guardados; no se informa éxito |
| Fallo de desactivación | Inyectar fallo al eliminar detalle o insertar una nueva prueba durante la desactivación | Se restauran indicador, detalle, pruebas y registros previos al intento |
| Eliminación de análisis | Eliminar por el flujo habitual un análisis industrial de prueba | La FK no bloquea la operación y el detalle se elimina por cascada |

Consultas de comprobación, sustituyendo `:id` por el análisis de prueba:

```sql
SELECT id, person_id, is_industrial, edad FROM analisis WHERE id = :id;
SELECT * FROM industrial_exhibition WHERE analisis_id = :id;
SELECT analisis_id, COUNT(*) AS total FROM industrial_exhibition GROUP BY analisis_id HAVING COUNT(*) > 1;
SELECT * FROM a_test_results WHERE analysis_id = :id;
```

### Revisión visual pendiente

- Abrir ambas interfaces a 1440 px y 375 px de ancho y probar modalidad clínica/industrial. Revisar etiqueta Cliente, ocultación de datos demográficos, grilla de cinco campos y acceso a botones del carrito en móvil.
- Repetir después de errores de validación y al editar un registro existente.
- Abrir ficha y PDF LABCI con Producto de 250 caracteres, incluidos caracteres especiales, y con todos los opcionales completos y vacíos. Revisar ausencia de edad, sexo/género y nacimiento, escape del texto, fechas `Y-m-d`, valores `--` y legibilidad sin desbordamientos.
- Revisar un PDF clínico de referencia y un informe industrial completo con muchas pruebas para comprobar que el nuevo encabezado no introduce solapamientos con resultados, cabeceras o pie de página.

## Reproducción de las pruebas sin escribir BD

```bash
./vendor/bin/phpunit --filter=IndustrialSample
./vendor/bin/phpunit tests/Unit/AnalisisLabelEdadTest.php
```

Para la prueba JavaScript, instalar dependencias temporales fuera del proyecto y exportar fixtures del renderizado real de Blade. Usar un directorio temporal existente y escribible:

```bash
npm install --prefix /tmp/opencode --cache /tmp/opencode/npm-cache --no-save --no-package-lock jsdom@24 jquery@3.7.1
INDUSTRIAL_SAMPLE_ARTIFACT_DIR=/tmp/opencode ./vendor/bin/phpunit tests/Unit/IndustrialSampleViewTest.php
INDUSTRIAL_SAMPLE_ARTIFACT_DIR=/tmp/opencode NODE_PATH=/tmp/opencode/node_modules node tests/Frontend/industrial-sample.test.js
```

Los HTML/PDF generados quedan en el directorio temporal indicado. No ejecutar la suite Feature completa como sustituto: contiene pruebas existentes que migran y escriben BD.

## Reversión operativa

Si se revierte el código, conservar inicialmente las migraciones aditivas y los detalles para no perder información. La versión anterior no presenta muestras industriales. Eliminar posteriormente tabla e indicador requiere una decisión de despliegue porque borra sus datos; el orden de reversión de esquema es primero detalle y después indicador.
