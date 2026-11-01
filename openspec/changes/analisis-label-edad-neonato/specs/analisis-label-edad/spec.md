## Purpose

Define cómo se calcula y presenta el texto legible de la edad de un análisis (`label_edad`), a partir del campo decimal `edad`, para mostrarlo en los reportes de citología y de pruebas.

## ADDED Requirements

### Requirement: Edad menor a un mes se muestra como "neonato"
El sistema SHALL mostrar el texto `"neonato"` como `label_edad` cuando el campo `edad` del análisis sea un valor real y positivo menor a `0.08` (es decir, `0 < edad < 0.08`, equivalente a menos de un mes de vida).

#### Scenario: Edad de pocos días
- **WHEN** un análisis tiene `edad = 0.03`
- **THEN** `label_edad` es `"neonato"`

#### Scenario: Edad justo por debajo del umbral de un mes
- **WHEN** un análisis tiene `edad = 0.07`
- **THEN** `label_edad` es `"neonato"`

#### Scenario: Edad de exactamente un mes no es neonato
- **WHEN** un análisis tiene `edad = 0.08`
- **THEN** `label_edad` es `"1 mes"`, no `"neonato"`

### Requirement: Edad sin registrar sigue mostrando "0 meses"
El sistema SHALL mantener el comportamiento existente para `edad` vacío, `0` o negativo: `label_edad` es `"0 meses"`, sin tratarlo como `"neonato"`.

#### Scenario: Edad no registrada
- **WHEN** un análisis tiene `edad` vacío (null)
- **THEN** `label_edad` es `"0 meses"`

#### Scenario: Edad igual a cero
- **WHEN** un análisis tiene `edad = 0`
- **THEN** `label_edad` es `"0 meses"`
