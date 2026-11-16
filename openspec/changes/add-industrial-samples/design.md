## Context

Ver `proposal.md` para la motivación y `specs/industrial-samples/spec.md` para el contrato de comportamiento.

- `crearAnalisisHemoForPersonaV2()` elige entre `crear-hemo` y `crear-hemo-v2` según `create_analisis_ui`. Ambos formularios envían `tipo_analisis = LABCI` a `store()`.
- `edit()` deriva los análisis LABCI a `editarAnalisisHemoForPersonaV2()`, que reutiliza la vista avanzada y recupera las pruebas ya seleccionadas.
- `store()` asigna campos explícitamente; `update()` usa `fill($request->all())` y después sincroniza pruebas preservando resultados y métodos de las que continúan seleccionadas. Actualmente el conjunto no está envuelto en una transacción.
- `StoreAnalisisPost` reemplaza las reglas cuando la procedencia corresponde a un convenio. Las reglas nuevas deben agregarse después de resolver esa rama. `UpdateAnalisisPost` se comparte con formularios ajenos a esta modalidad.
- `edad` es `DECIMAL(8,2) NOT NULL DEFAULT 0.00`. Las vistas solicitadas calculan edad desde la persona cuando este campo es cero: ocultar el input o guardar cero no evita por sí solo esa presentación.
- `person_id` es obligatorio. `Analisis::user()` y las migraciones referencian `users`, que es también la tabla usada por el modelo `User`.
- `citologia/partial/cliente-head` se comparte entre LABCI y otros módulos. `TestController::reporte()` selecciona una plantilla según `REPORT_ENTERPRICE`; este cambio cubre la plantilla `test.labci`.
- La eliminación actual borra físicamente el análisis después de sus resultados; la nueva relación debe permitir ese flujo.

El diseño corresponde por cambio de datos y por afectar validación, persistencia, formularios y reportes.

## Goals / Non-Goals

**Goals:**

- Establecer una sola fuente de estado para la modalidad y una relación de detalle uno a uno, sin duplicados en ediciones sucesivas.
- Mantener consistencia transaccional entre el análisis, sus pruebas, el registro de edición y su detalle industrial.
- Diferenciar en el servidor una desactivación explícita de una actualización desde un formulario que no administra el indicador.
- Separar los datos del cliente de los del producto sin modificar la entidad `Person` ni su identidad.

**Non-Goals:**

- Reemplazar `Person` por una entidad de empresas o permitir análisis sin cliente asociado.
- Cambiar los catálogos de pruebas, resultados, métodos o referencias por tratarse de una muestra industrial.
- Añadir modalidades industriales a otros tipos de análisis, nuevas rutas o un contrato nuevo para preórdenes.
- Adaptar recibos, exportaciones, listados, nombres de archivos o plantillas de reporte distintas de LABCI.
- Cambiar el accessor `label_edad` o añadir restricciones temporales de negocio no solicitadas entre las fechas industriales.

## Decisions

### 1. Indicador explícito y detalle uno a uno

Usar `analisis.is_industrial` boolean no nullable con default `false`, y `industrial_exhibition` con `analisis_id` único. El modelo será `App\IndustrialExhibition`, con nombre de tabla explícito por conservar el singular solicitado, relaciones `belongsTo` a análisis y usuario, y fechas convertidas a objetos de fecha. `Analisis` expondrá una relación `industrialExhibition` y convertirá el indicador a boolean.

Los nombres técnicos normalizados son valores de diseño para los nombres ambiguos del pedido: `is_industrial`, `manufacture_date` y `expiration_date`. Se conserva `rehearsal_date` como se solicitó, y no se crea una segunda columna llamada «is_industrial exhibition».

| Columna del detalle | Definición |
|---|---|
| `id` | bigint unsigned autoincremental, PK |
| `product_name` | varchar(250), no nullable |
| `rehearsal_date` | date, no nullable |
| `manufacture_date` | date, nullable |
| `expiration_date` | date, nullable |
| `lot_number` | varchar(250), nullable |
| `analisis_id` | bigint unsigned, unique, FK a `analisis.id`, eliminación en cascada |
| `user_id` | bigint unsigned, FK a `users.id`, sin cascada destructiva del detalle |
| `created_at`, `updated_at` | timestamps |

Usar dos migraciones nuevas: agregar el indicador y crear el detalle. Los tipos de FK deben coincidir con las PK existentes. La autoría es la del usuario autenticado al crear el detalle y no cambia al editarlo; si se elimina y luego se crea otro detalle por reactivación, se registra al nuevo creador.

**Alternativas:** agregar todos los campos a `analisis` no cumple la separación solicitada; un detalle sin indicador dificulta expresar el estado del formulario; una relación uno a muchos no representa el único producto/lote solicitado por análisis. La restricción única refuerza la relación ante duplicados accidentales.

### 2. Validación condicional y control explícito del estado

Ambos formularios enviarán un hidden `is_industrial = 0` y un checkbox del mismo nombre con valor `1`. Se validará el valor como boolean antes de normalizarlo. En creación, omitirlo equivale a `false`, conservando compatibilidad con otros formularios. En actualización, omitir el campo conserva el indicador existente; el hidden permite distinguir esa omisión de la desactivación explícita.

En actualización el tipo efectivo y el estado persistido se resuelven desde el análisis existente, sin confiar solo en el tipo oculto enviado por el cliente. Se rechaza activar la modalidad fuera de LABCI. Cuando el estado efectivo sea industrial, validar el detalle completo que administra el formulario LABCI; una actualización ajena a la modalidad que no envíe sus controles conserva el detalle guardado en lugar de exigirle esos campos o eliminarlos.

Agregar las reglas industriales al final de la construcción de reglas, después de resolver convenios y selección de pruebas. Para modalidad activa: Producto requerido, texto no vacío, máximo 250; Fecha de ensayo requerida y fecha válida; Nro. de lote nullable, texto máximo 250; fabricación y vencimiento nullable y fechas válidas. Se usarán valores `Y-m-d` en los controles date y se normalizarán opcionales vacíos a null. No se imponen límites relativos a hoy ni orden entre fechas industriales. La fecha de ingreso conserva su validación actual.

En solicitudes que gestionan la modalidad, ignorar los valores industriales cuando esté desactivada, e ignorar la edad enviada cuando esté activada. Guardar edad cero para modo industrial sin alterar los datos demográficos de `Person`. Al desactivar, utilizar la edad clínica del formulario; si el registro conserva cero y no hay entrada previa del usuario, la interfaz puede usar la misma edad calculada desde nacimiento que se usa en creación. No se garantiza recuperar una edad manual anterior a la conversión industrial, porque no se solicita mantener ese historial.

Excluir `is_industrial` y los campos de detalle del llenado genérico de `update()` y resolverlos explícitamente con los valores validados. No tomar `user_id` del request para crear el detalle. Las reglas actuales de doctor, procedencia, cobros y selección de pruebas siguen aplicando.

**Alternativas:** tratar toda ausencia como `false` en actualización borraría datos desde formularios existentes; usar solo el checkbox sin hidden impide diferenciar ausencia y desactivación; validar únicamente en HTML no protege los botones jQuery ni solicitudes directas.

### 3. Guardado atómico y transiciones

Usar una transacción en los flujos existentes `store()` y `update()`. Incluir los cambios del análisis, su detalle, la sincronización de pruebas, los cambios de convenio pertinentes y el registro de edición. Conservar la integración de preorden y su manejo actual de transiciones inválidas; evitar mover su actualización fuera de la unidad de persistencia. Emitir mensajes de éxito y flashes de impresión solo después del guardado confirmado.

En edición, cargar el análisis dentro de la transacción con bloqueo de fila para serializar cambios concurrentes sobre el mismo indicador y detalle. Crear o actualizar a través de la relación uno a uno y conservar el autor en actualizaciones. No reemplazar el algoritmo de sincronización de pruebas ni borrar resultados que permanecen seleccionados.

| Estado guardado | Estado enviado explícitamente | Acción sobre el detalle |
|---|---|---|
| Clínico | Clínico | No crear detalle; eliminar cualquier detalle residual |
| Clínico | Industrial | Crear detalle validado y registrar autor |
| Industrial | Industrial | Actualizar el detalle existente |
| Industrial | Clínico | Eliminar detalle y desactivar indicador en la misma transacción |
| Cualquiera | Campo omitido en actualización | Conservar modalidad y detalle |

No hay endpoint AJAX de eliminación al alternar el checkbox. Cancelar o fallar una validación no cambia lo persistido. Si falla un guardado de cualquier parte, lanzar el fallo para revertir la unidad, sin confirmar una operación parcial ni mostrar éxito. La cascada elimina el detalle cuando el análisis se borra físicamente.

**Alternativas:** guardar primero el indicador y después el detalle sin transacción permite estados incoherentes; eliminar por AJAX al desmarcar haría destructiva una edición que el usuario podría cancelar.

### 4. Formularios equivalentes y recuperación de valores

Aplicar la misma lógica en `crear-hemo` y `crear-hemo-v2`. Se puede compartir un parcial acotado de campos y comportamiento para evitar diferencias entre ambas interfaces; cualquier archivo auxiliar debe limitarse a esta funcionalidad.

Resolver el estado inicial con prioridad de datos anteriores de validación, luego del análisis en edición y finalmente `false`. Resolver los cinco valores con la misma prioridad. Al cambiar la modalidad, alternar visibilidad de Edad, fecha de nacimiento y sexo; cambiar la etiqueta de la persona a Cliente en industrial y restaurarla al volver a clínico. Alternar `disabled` de Edad y del bloque industrial y `required` de Producto y Fecha de ensayo.

Alternar en el navegador conserva temporalmente lo ingresado para que marcar y desmarcar antes de guardar no provoque pérdidas innecesarias. Esto no restaura un detalle ya eliminado mediante un guardado anterior. Los botones de carrito de escritorio y móvil deben respetar la validación del formulario antes de deshabilitar botones o iniciar el envío; mantener además toda la validación en el servidor.

**Alternativas:** duplicar solo marcado HTML sin comportamiento común puede hacer divergir formularios; borrar campos al ocultarlos perjudica la edición; confiar en `required` sin revisar el envío programático no garantiza la experiencia de validación.

### 5. Rama industrial en ficha y reporte LABCI

Mantener la rama clínica del encabezado compartido y del reporte, e introducir una rama industrial basada exclusivamente en `is_industrial`, no en la edad ni en la existencia aislada del detalle. En la rama industrial, presentar Cliente y el bloque de muestra, omitir edad y su fallback, sexo/género y nacimiento. Conservar los demás datos generales existentes: códigos, institución, solicitante, recepción y fechas del análisis, según corresponda a cada vista.

Cargar `industrialExhibition` con el análisis en las acciones LABCI de edición, ficha y reporte de `AnalisisController`/`TestController`. Presentar fechas industriales como `Y-m-d`, opcionales vacíos con `--` y texto escapado para producto y lote. Tolerar una relación ausente mostrando `--` en vez de provocar una excepción o volver a los datos clínicos; ese fallback es defensivo y no sustituye la consistencia transaccional.

La ficha usa la grilla existente y el reporte conserva tablas compatibles con mPDF. No se requiere alterar el cálculo de edad ni el cuerpo de resultados. Los nombres actuales de archivos de reporte y recibos continúan basados en el cliente asociado.

**Alternativas:** reutilizar el nombre del paciente como producto mezclaría identidad y muestra; añadir solo filas industriales dejaría una edad o género incorrectos; adaptar el accessor global de edad afectaría vistas fuera del alcance.

## Risks / Trade-offs

- [Reglas de convenio reemplazan el arreglo inicial] -> Incorporar y probar la validación industrial después de resolver esa rama.
- [Un campo omitido se interpreta como desactivación] -> Hidden explícito en los formularios industriales y preservación del estado cuando el control no existe en el request.
- [Error parcial o dos ediciones simultáneas] -> Transacción, bloqueo del análisis en edición y unicidad de `analisis_id` en el detalle.
- [Los botones del carrito omiten validación nativa] -> Verificar escritorio y móvil y validar en servidor independientemente del mecanismo de envío.
- [Reaparición de edad por fallback demográfico] -> Rama industrial explícita en los dos encabezados, con casos de prueba donde la persona tiene nacimiento registrado.
- [Texto largo o fechas opcionales afectan maquetación] -> Revisar producto de 250 caracteres, campos vacíos y distribución de filas en la plantilla LABCI.
- [La desactivación guardada pierde el detalle] -> Es el comportamiento acordado; la eliminación ocurre solo al confirmar un guardado válido. La reactivación requiere nueva captura.
- [Regresiones en preórdenes o sincronización de pruebas al agregar transacciones] -> Preservar las ramas existentes y verificar fallos y resultados de pruebas retenidas.
- [La configuración selecciona otro reporte] -> La aceptación visual del reporte se verifica usando LABCI; otras plantillas no reciben este formato industrial.

## Migration Plan

1. Preparar y revisar dos migraciones nuevas, sin modificar el esquema desde esta fase de planificación.
2. En el despliegue operativo, aplicar las migraciones antes de habilitar el código que consulta el indicador y la relación. El default `false` mantiene clínicos los análisis existentes y no requiere crear detalles históricos.
3. Desplegar backend, formularios y encabezados coordinadamente, y verificar creación, edición y desactivación desde ambas interfaces de origen.
4. Ante un rollback de aplicación, conservar inicialmente el esquema aditivo y sus datos. El rollback a código anterior no preserva la presentación industrial, aunque la información permanezca en la tabla.
5. Los métodos `down()` deben poder eliminar primero la tabla de detalle y después el indicador. Su ejecución es una operación destructiva de despliegue y no forma parte de la verificación del agente ni de esta planificación.
