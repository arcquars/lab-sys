## Purpose

Define cómo se filtra y busca el listado de análisis (vista `analisis.home`), incluyendo la interacción entre la caja de búsqueda global de la tabla y las búsquedas individuales por columna, y el scoping de visibilidad por doctor.

## Requirements

### Requirement: Búsqueda global encuentra análisis por nombre o apellido del paciente
El sistema SHALL permitir que el texto ingresado en la caja de búsqueda global del listado de análisis encuentre resultados cuyo `codigo` de análisis, o el `nombre` o `apellido` del paciente asociado, contengan ese texto (coincidencia parcial, sin distinguir mayúsculas/minúsculas según el collation de la base de datos). Adicionalmente, el sistema SHALL incluir resultados cuyo `internal_code` sea **exactamente igual** al texto buscado (coincidencia exacta, no parcial).

#### Scenario: Coincidencia por nombre del paciente
- **WHEN** un usuario escribe en la búsqueda global un texto que coincide parcialmente con el nombre de un paciente
- **THEN** el listado incluye los análisis de ese paciente, aunque el texto no coincida con ningún `codigo` de análisis

#### Scenario: Coincidencia por apellido del paciente
- **WHEN** un usuario escribe en la búsqueda global un texto que coincide parcialmente con el apellido de un paciente
- **THEN** el listado incluye los análisis de ese paciente

#### Scenario: Coincidencia por código de análisis
- **WHEN** un usuario escribe en la búsqueda global un texto que coincide parcialmente con el `codigo` de un análisis
- **THEN** el listado incluye ese análisis, igual que antes de este cambio

#### Scenario: Coincidencia exacta por código interno
- **WHEN** un usuario escribe en la búsqueda global un texto que coincide **exactamente** con el `internal_code` de un análisis
- **THEN** el listado incluye ese análisis

#### Scenario: Coincidencia parcial de código interno no cuenta
- **WHEN** un usuario escribe en la búsqueda global un texto que es solo una parte (no el valor completo) del `internal_code` de un análisis, y no coincide con `codigo`, `nombre` ni `apellido`
- **THEN** ese análisis no aparece en el listado por esa coincidencia parcial de `internal_code`

#### Scenario: Sin coincidencias
- **WHEN** el texto de la búsqueda global no coincide con ningún `codigo`, `nombre` ni `apellido`
- **THEN** el listado no muestra resultados para ese texto

### Requirement: La búsqueda global no debe omitir el scoping de visibilidad por doctor
Para usuarios cuyo rol está vinculado a un doctor (`medico`), el sistema SHALL seguir restringiendo el listado a los análisis asignados a ese doctor o a los análisis donde actúa como supervisor, sin importar si el texto de la búsqueda global coincide con el `codigo`, `nombre` o `apellido` de un análisis fuera de ese alcance.

#### Scenario: Coincidencia de texto en un análisis fuera del alcance del doctor
- **WHEN** un usuario con rol médico busca un texto que coincide con el `codigo`, `nombre` o `apellido` de un análisis asignado a otro doctor (y no supervisado por el usuario actual)
- **THEN** ese análisis no aparece en el listado

### Requirement: Las búsquedas por columna de nombre y apellido siguen funcionando de forma independiente
El sistema SHALL mantener las búsquedas individuales por columna ("Cliente" = nombres, "Ap" = apellidos) como filtros independientes de la búsqueda global, combinándose con ella mediante AND.

#### Scenario: Búsqueda por columna y búsqueda global combinadas
- **WHEN** un usuario filtra la columna "Cliente" por un nombre y además escribe un texto distinto en la búsqueda global
- **THEN** el listado solo incluye análisis que cumplen ambos filtros simultáneamente

### Requirement: El código interno se muestra concatenado junto al código del análisis
El sistema SHALL mostrar el `internal_code` de un análisis, cuando exista, concatenado junto a su `codigo` en la misma columna del listado, con el formato `"{codigo} ({internal_code})"`. Cuando el análisis no tenga `internal_code`, el sistema SHALL mostrar únicamente `{codigo}`, igual que antes de este cambio. El `internal_code` SHALL NOT mostrarse como una columna independiente visible en el listado.

#### Scenario: Análisis con código interno
- **WHEN** un análisis tiene un `internal_code` registrado
- **THEN** la columna de código del listado muestra el `codigo` seguido del `internal_code` entre paréntesis

#### Scenario: Análisis sin código interno
- **WHEN** un análisis no tiene `internal_code` (vacío o nulo)
- **THEN** la columna de código del listado muestra únicamente el `codigo`, sin paréntesis ni espacio extra

#### Scenario: La columna internal_code no es visible de forma independiente
- **WHEN** se carga el listado de análisis
- **THEN** no aparece ninguna columna visible con el encabezado o los valores de `internal_code` por separado
