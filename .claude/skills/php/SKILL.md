---
name: php
description: Reglas de compatibilidad PHP 7.4 para Hemolab. Usar siempre que se escriba o modifique codigo PHP (controladores, modelos, exports, helpers) para evitar sintaxis de PHP 8+.
---

# PHP 7.4

El proyecto corre en PHP 7.4. Todo el codigo debe ser compatible.

## Nunca usar (PHP 8+)

- `match()` → usar `switch` o arrays asociativos
- `enum`
- `readonly`
- Attributes `#[...]`
- Union types (`int|string`)
- Named arguments (`foo(bar: 1)`)
- Constructor property promotion
- Operador nullsafe `?->`
- `str_contains`, `str_starts_with`, `str_ends_with` (usar `strpos` / `substr`)

## Permitido y recomendado

- Funciones flecha cortas: `fn($x) => $x * 2`
- Operador de asignacion de coalescencia nula: `??=`
- Typed properties, pero inicializarlas si se leen antes de asignarles valor.

## Verificacion

```bash
php -l ruta/al/archivo.php
```
