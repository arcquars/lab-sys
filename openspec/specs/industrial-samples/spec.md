# industrial-samples Specification

## Purpose

Permitir registrar y editar muestras industriales en análisis LABCI, asociando el producto a un cliente y mostrando sus datos propios en la ficha y el reporte sin datos demográficos clínicos.

## Requirements

### Requirement: Selección de modalidad industrial en creación y edición LABCI

El sistema SHALL ofrecer el checkbox «Muestra industrial» en los formularios clásico y avanzado de creación LABCI y en su formulario de edición. En una creación nueva SHALL estar desmarcado inicialmente. Al activarlo SHALL ocultar e inhabilitar Edad, ocultar fecha de nacimiento y sexo del encabezado, presentar a la persona asociada como Cliente y mostrar los cinco campos industriales.

#### Scenario: Creación inicial en cualquiera de los formularios
- **WHEN** el usuario abre el formulario clásico o avanzado para crear un análisis LABCI
- **THEN** el checkbox está desmarcado y el formulario conserva su funcionamiento clínico habitual

#### Scenario: Activación de la modalidad industrial
- **WHEN** el usuario marca «Muestra industrial» en creación o edición LABCI
- **THEN** Edad queda oculta e inhabilitada, se ocultan fecha de nacimiento y sexo del encabezado, la persona aparece como Cliente y se muestran Producto, Fecha de ensayo, Nro. de lote, Fecha de fabricación y Fecha de vencimiento

#### Scenario: Regreso a modalidad clínica antes de guardar
- **WHEN** el usuario desmarca «Muestra industrial» en el formulario
- **THEN** se restaura la presentación clínica y los campos industriales quedan ocultos e inhabilitados sin eliminar todavía datos persistidos

### Requirement: Validación condicional de datos industriales

El sistema SHALL exigir Producto como texto no vacío de hasta 250 caracteres y Fecha de ensayo como fecha válida cuando la modalidad industrial esté activa. SHALL aceptar Nro. de lote como texto opcional de hasta 250 caracteres y fechas válidas opcionales de fabricación y vencimiento. Estas reglas SHALL aplicarse en creación y edición, incluyendo procedencias con convenio y envíos sin validación del navegador. Los campos industriales inactivos SHALL ser ignorados al validar y guardar una solicitud clínica. Las demás validaciones existentes SHALL conservarse.

#### Scenario: Datos mínimos válidos
- **WHEN** se envía una muestra industrial con Producto y Fecha de ensayo válidos, los tres campos opcionales vacíos y los demás datos del análisis válidos
- **THEN** el sistema acepta el formulario y guarda vacíos los valores opcionales

#### Scenario: Datos obligatorios ausentes en creación o edición
- **WHEN** se envía una muestra industrial sin Producto o sin Fecha de ensayo, incluso para una procedencia con convenio o sin validación del navegador
- **THEN** el sistema rechaza el guardado e informa errores de los campos obligatorios ausentes

#### Scenario: Longitudes o fechas inválidas
- **WHEN** Producto o Nro. de lote supera 250 caracteres, o alguna fecha industrial informada es inválida
- **THEN** el sistema rechaza el guardado e identifica los campos inválidos

#### Scenario: Datos industriales residuales en una solicitud clínica
- **WHEN** se envía el formulario con la modalidad industrial desactivada y valores industriales residuales o inválidos
- **THEN** esos valores no bloquean la validación clínica ni se guardan como detalle industrial

### Requirement: Recuperación del formulario y de los datos guardados

El sistema SHALL conservar el estado enviado del checkbox y los valores ingresados después de un error de validación. Al abrir la edición de una muestra industrial SHALL recuperar el indicador y todos sus datos guardados, sin depender de la interfaz con la que se creó el análisis.

#### Scenario: Error de validación con modalidad activa
- **WHEN** falla una validación del formulario industrial
- **THEN** el formulario vuelve con el checkbox marcado, los campos industriales visibles, los valores enviados recuperados y los errores correspondientes

#### Scenario: Error de validación al desactivar la modalidad
- **WHEN** el usuario desmarca la modalidad y el guardado falla por otro campo
- **THEN** el formulario vuelve con el checkbox desmarcado y el detalle industrial previamente guardado sigue existiendo

#### Scenario: Edición de muestra industrial creada en la interfaz clásica
- **WHEN** el usuario edita un análisis industrial creado desde el formulario clásico
- **THEN** el formulario avanzado de edición recupera el checkbox marcado y los cinco datos industriales existentes

### Requirement: Registro único de muestra industrial y autoría

El sistema SHALL mantener como máximo un detalle industrial por análisis y conservar la persona asociada al análisis como cliente. SHALL registrar al usuario autenticado que crea el detalle como su autor, sin aceptar una autoría enviada desde el formulario, y conservar esa autoría durante las ediciones. Un análisis industrial SHALL guardar su edad clínica en cero sin modificar los datos de la persona.

#### Scenario: Creación industrial
- **WHEN** un usuario autenticado guarda un análisis industrial válido
- **THEN** el análisis queda marcado como industrial, mantiene su persona asociada, guarda edad cero y tiene exactamente un detalle con el producto, las fechas, el lote y el usuario autor

#### Scenario: Actualización industrial
- **WHEN** otro usuario autorizado modifica y guarda los datos de una muestra industrial existente
- **THEN** se actualiza el mismo detalle, no se crea un duplicado y se conserva el usuario que lo registró

#### Scenario: Activación desde un análisis clínico existente
- **WHEN** se activa y guarda la modalidad industrial de un análisis LABCI clínico existente
- **THEN** se crea su único detalle industrial con el usuario autenticado como autor y la persona asociada permanece intacta

### Requirement: Eliminación del detalle al desactivar y guardar

El sistema SHALL desactivar el indicador industrial y eliminar el detalle asociado únicamente cuando se guarde correctamente el formulario con la modalidad desmarcada. Cancelar o fallar el guardado SHALL conservar la modalidad y el detalle persistidos. Tras una desactivación guardada, reactivar la modalidad SHALL requerir ingresar nuevamente los datos industriales obligatorios.

#### Scenario: Desactivación guardada
- **WHEN** el usuario desmarca «Muestra industrial» y guarda correctamente un análisis industrial existente
- **THEN** el análisis queda en modalidad clínica y su detalle industrial se elimina

#### Scenario: Cancelación de la edición
- **WHEN** el usuario desmarca el checkbox y abandona la edición sin guardar
- **THEN** el análisis continúa siendo industrial y conserva su detalle guardado

#### Scenario: Reactivación después de eliminar el detalle
- **WHEN** el usuario vuelve a editar y activar un análisis cuya modalidad industrial fue desactivada y guardada
- **THEN** el formulario no recupera el detalle eliminado y exige ingresar Producto y Fecha de ensayo

### Requirement: Consistencia del guardado del análisis

El sistema SHALL guardar o revertir conjuntamente los cambios del análisis, las pruebas seleccionadas y su detalle industrial. Un fallo de persistencia SHALL impedir que quede un análisis industrial sin detalle, un detalle eliminado con el indicador activo o una selección de pruebas parcialmente actualizada. La edición SHALL conservar los resultados y métodos de las pruebas que permanecen seleccionadas.

#### Scenario: Fallo al crear el detalle industrial
- **WHEN** falla la persistencia del detalle durante la creación de un análisis industrial
- **THEN** no quedan guardados el nuevo análisis ni sus pruebas seleccionadas

#### Scenario: Fallo durante la desactivación
- **WHEN** falla la eliminación del detalle o la sincronización de pruebas al guardar una desactivación
- **THEN** se conservan el indicador, el detalle y las pruebas anteriores al intento

#### Scenario: Edición sin cambiar pruebas existentes
- **WHEN** el usuario cambia los datos industriales y mantiene seleccionadas pruebas con resultados y métodos registrados
- **THEN** esos resultados y métodos permanecen intactos

### Requirement: Presentación del cliente y de la muestra industrial

La ficha del análisis y el encabezado del reporte LABCI SHALL presentar a la persona asociada con la etiqueta Cliente y mostrar un bloque separado «Muestra industrial» con Producto, Fecha de ensayo, Nro. de lote, Fecha de fabricación y Fecha de vencimiento cuando la modalidad esté activa. SHALL omitir edad, sexo/género y fecha de nacimiento, sin calcular una edad alternativa desde la persona. SHALL conservar los demás datos generales existentes, formatear las fechas industriales como `Y-m-d`, representar los valores opcionales vacíos mediante `--` y mostrar producto y lote como texto.

#### Scenario: Ficha industrial con cliente que tiene fecha de nacimiento
- **WHEN** se abre la ficha de un análisis industrial cuya persona tiene datos demográficos registrados
- **THEN** se muestran Cliente y el bloque industrial y no se muestran edad, sexo ni fecha de nacimiento de esa persona

#### Scenario: Reporte industrial con datos completos
- **WHEN** se genera el reporte LABCI de una muestra industrial con todos sus datos completos
- **THEN** se muestran el cliente y los cinco datos industriales, las fechas tienen formato `Y-m-d` y no aparecen campos demográficos clínicos

#### Scenario: Valores opcionales vacíos y texto especial
- **WHEN** se muestra una muestra industrial sin fechas opcionales ni lote, o con caracteres de marcado en el producto
- **THEN** los campos opcionales vacíos muestran `--` y el producto se presenta como texto sin interpretar marcado

### Requirement: Compatibilidad clínica y eliminación del análisis

Los análisis existentes y los nuevos sin modalidad industrial SHALL mantener el flujo clínico habitual, la selección de pruebas y el formato actual de edad. Las ediciones realizadas desde formularios que no gestionan esta modalidad SHALL conservar el estado industrial existente. La eliminación de un análisis con detalle industrial SHALL eliminar también ese detalle y no fallar por la nueva relación. La activación de muestras industriales SHALL estar limitada a análisis LABCI.

#### Scenario: Análisis clínico existente o nuevo
- **WHEN** se crea, edita o consulta un análisis sin modalidad industrial activa
- **THEN** se conserva el funcionamiento clínico actual y no se crea detalle industrial

#### Scenario: Actualización sin control de modalidad
- **WHEN** un formulario existente que no gestiona muestras industriales actualiza un análisis sin enviar un estado de modalidad
- **THEN** la actualización no desactiva ni elimina implícitamente un detalle industrial existente

#### Scenario: Eliminación de análisis industrial
- **WHEN** se elimina correctamente un análisis que tiene un detalle industrial
- **THEN** se elimina también el detalle y no queda un registro industrial huérfano

#### Scenario: Solicitud industrial de un tipo no compatible
- **WHEN** se intenta activar la modalidad industrial para un análisis de un tipo distinto de LABCI
- **THEN** el sistema rechaza la solicitud sin crear ni modificar su detalle industrial
