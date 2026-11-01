## ADDED Requirements

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
