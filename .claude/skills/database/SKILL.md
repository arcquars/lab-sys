---
name: database
description: Reglas para cambios de base de datos en Hemolab. Usar al crear migraciones, modificar tablas, indices o claves foraneas, o al escribir consultas.
---

# Base de datos

- Siempre crear migraciones nuevas: `php artisan make:migration ...`. Nunca editar migraciones existentes.
- No escribir SQL crudo cuando Eloquent sea suficiente; preferir Query Builder sobre SQL crudo.
- Nombrar correctamente indices y claves foraneas.
- Las migraciones deben tener `down()` funcional.
