## Purpose

Define cómo se filtra y busca el listado de análisis (vista `analisis.home`), incluyendo la interacción entre la caja de búsqueda global de la tabla y las búsquedas individuales por columna, y el scoping de visibilidad por doctor.

## ADDED Requirements

### Requirement: Búsqueda global encuentra análisis por nombre o apellido del paciente
El sistema SHALL permitir que el texto ingresado en la caja de búsqueda global del listado de análisis encuentre resultados cuyo `codigo` de análisis, o el `nombre` o `apellido` del paciente asociado, contengan ese texto (coincidencia parcial, sin distinguir mayúsculas/minúsculas según el collation de la base de datos).

#### Scenario: Coincidencia por nombre del paciente
- **WHEN** un usuario escribe en la búsqueda global un texto que coincide parcialmente con el nombre de un paciente
- **THEN** el listado incluye los análisis de ese paciente, aunque el texto no coincida con ningún `codigo` de análisis

#### Scenario: Coincidencia por apellido del paciente
- **WHEN** un usuario escribe en la búsqueda global un texto que coincide parcialmente con el apellido de un paciente
- **THEN** el listado incluye los análisis de ese paciente

#### Scenario: Coincidencia por código de análisis
- **WHEN** un usuario escribe en la búsqueda global un texto que coincide parcialmente con el `codigo` de un análisis
- **THEN** el listado incluye ese análisis, igual que antes de este cambio

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
