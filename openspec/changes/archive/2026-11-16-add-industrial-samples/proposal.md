## Why

Los formularios de análisis LABCI solo representan muestras clínicas y no permiten registrar los datos de un producto industrial. Se necesita identificar estas muestras y presentar sus datos sin atribuirles edad, sexo ni fecha de nacimiento, conservando a la persona asociada como cliente.

## What Changes

- Agregar el checkbox «Muestra industrial» a los formularios clásico y avanzado de creación; recuperar y editar su estado en el formulario avanzado utilizado para editar LABCI.
- Al activarlo, ocultar e inhabilitar Edad y mostrar Producto y Fecha de ensayo obligatorios, junto con Nro. de lote, Fecha de fabricación y Fecha de vencimiento opcionales.
- Persistir el indicador `analisis.is_industrial`, con valor predeterminado `false`, y un detalle por análisis en la nueva tabla `industrial_exhibition`.
- Crear migraciones nuevas para el indicador y la tabla relacionada, sin modificar migraciones históricas.
- Al guardar con el checkbox desmarcado, eliminar el detalle industrial asociado y volver al funcionamiento clínico habitual. Alternar el checkbox sin guardar no elimina datos persistidos.
- Conservar `person_id` y presentar a la persona como Cliente en modo industrial, con un bloque separado para el producto. Ocultar edad, sexo/género y fecha de nacimiento en los dos formularios y los encabezados solicitados.
- Guardar de forma atómica el análisis, sus pruebas seleccionadas y el detalle industrial, incluyendo las transiciones entre modalidades.
- Mantener la presentación y validaciones clínicas existentes para análisis no industriales.

## Capabilities

### New Capabilities

- `industrial-samples`: Creación, edición, validación, persistencia y presentación de muestras industriales en análisis LABCI, incluida la eliminación del detalle al desactivar la modalidad y guardar.

### Modified Capabilities

Ninguna. El formato de `label_edad` y el comportamiento del listado de análisis mantienen sus requisitos; la nueva modalidad decide cuándo no presentar datos clínicos.

## Impact

- Persistencia: nuevas migraciones para `analisis.is_industrial` y `industrial_exhibition`; nuevo modelo `app/IndustrialExhibition.php` y relación en `app/Analisis.php`.
- Backend: `app/Http/Controllers/AnalisisController.php`, `app/Http/Requests/StoreAnalisisPost.php` y `app/Http/Requests/UpdateAnalisisPost.php`; carga del detalle para la ficha y el reporte en `app/Http/Controllers/TestController.php`.
- Formularios: `resources/views/analisis/crear-hemo.blade.php` y `resources/views/analisis/crear-hemo-v2.blade.php`, con interacción jQuery y estilos Bootstrap 4.
- Presentación: `resources/views/citologia/partial/cliente-head.blade.php` y `resources/views/test/labci/partials/reporte-client.blade.php`. El encabezado de ficha es compartido con otros módulos, por lo que su rama clínica debe conservarse.
- Verificación: pruebas de validación, persistencia y presentación, además de regresión del formato de edad y de la edición de pruebas seleccionadas.
- Compatible con PHP 7.4 y Laravel 6.x; sin nuevas rutas, paquetes ni cambios al contrato de preórdenes. El reporte industrial de este cambio corresponde a la plantilla LABCI.
