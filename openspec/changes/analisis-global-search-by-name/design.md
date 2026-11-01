## Context

Ver `proposal.md` - Why. `AnalisisController@getDatatablesData` tiene dos ramas casi idénticas (usuario con doctor vinculado vs. sin él). La rama con doctor vinculado aplica un filtro de scoping de seguridad (`doctor_asignado = user->person OR id en subconsulta de supervisores`) que restringe qué análisis puede ver ese usuario. Laravel/Eloquent encadena `where`/`orWhere` al nivel en que se invocan: un `orWhere` sin agrupar explícitamente con `where(function(){...})` se adjunta al WHERE completo construido hasta ese punto, no solo a la condición inmediatamente anterior.

## Goals / Non-Goals

**Goals:**
- Que la búsqueda global (`$searchG`) amplíe la coincidencia a `codigo` OR `nombres` OR `apellidos`, sin alterar el resultado cuando `$searchG` está vacío.
- Preservar intacto el scoping de seguridad por doctor y las búsquedas por columna existentes (AND).

**Non-Goals:**
- No se corrige el bug de precedencia ya existente en `getDatatablesTecnico` (fuera de alcance; no fue pedido y tiene su propio radio de impacto).
- No se cambia el comportamiento de las búsquedas por columna (`searchNombres`, `searchApellidos`, `searchDoctorId`, `interconsultados`).

## Decisions

**Agrupar el OR con `->where(function($q) use ($searchG) { ... })` en vez de encadenar `orWhere`/`orWhereHas` al nivel superior.**
Alternativa considerada: replicar el patrón de `getDatatablesTecnico` (`...->whereHas(...)->orWhere('codigo', ...)`). Se descarta porque ese patrón adjunta el `orWhere` a todo el WHERE acumulado hasta ese punto — en la rama con scoping por doctor, eso permitiría que una coincidencia de texto en `codigo`/`nombre`/`apellido` de un análisis **de otro doctor** se cuele en el resultado, saltándose el filtro de seguridad. Agrupar con un closure propio mantiene el OR contenido: `(codigo LIKE %searchG% OR EXISTS(persona con nombre/apellido LIKE %searchG%))` se ANDea como una sola condición con todo lo demás.

**Usar `orWhereHas` dentro del grupo para comparar contra `nombres`/`apellidos` de la persona, en vez de un `orWhere` plano sobre columnas de `analisis`.**
`nombres`/`apellidos` viven en la tabla `persons`, no en `analisis`; ya existe la relación `person()` usada por el resto del método. `orWhereHas('person', fn($q) => $q->where(...)->orWhere(...))` es la forma estándar de Eloquent para un OR entre una condición propia y una condición de una relación, y es consistente con el resto del método.

**Aplicar el mismo cambio a ambas ramas del método.**
Decisión del usuario (confirmada en conversación): ambas ramas comparten el mismo patrón duplicado: aplicar la corrección solo a una dejaría inconsistente el comportamiento según si el usuario tiene o no un doctor vinculado.

**`internal_code` se compara con `=` (igualdad exacta), no con `LIKE '%...%'`.**
Decisión explícita del usuario: a diferencia de `codigo`/`nombres`/`apellidos`, el texto de búsqueda global debe coincidir exactamente con `internal_code` para incluir ese análisis. Se agrega como una rama más del mismo grupo OR (`->orWhere('internal_code', '=', $searchG)`), sin afectar su contención dentro del `where(function(){...})` existente (sigue ANDado con el scoping de seguridad por doctor).

## Risks / Trade-offs

- [Riesgo] Si `$searchG` está vacío, `LIKE '%%'` matchea todo — el grupo OR se vuelve un no-op (siempre verdadero), igual que el comportamiento actual de `codigo LIKE '%%'`. No hay cambio de comportamiento en el caso sin búsqueda.
- [Riesgo] Posible impacto de rendimiento menor por el `EXISTS` adicional dentro del grupo OR (ya existe un `whereHas('person', ...)` en el mismo query para los filtros por columna, así que el costo marginal es bajo).
- [Trade-off] Se deja sin corregir el bug de precedencia de `getDatatablesTecnico` para no expandir el alcance de este change; queda documentado en `proposal.md` para una futura corrección si se decide abordarlo.
