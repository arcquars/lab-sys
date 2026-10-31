---
name: docker
description: Como ejecutar comandos (artisan, composer, phpunit, npm) en Hemolab. Usar antes de correr cualquier comando del proyecto.
---

# Entorno Docker

El agente ya corre DENTRO del contenedor `php74`, que monta `/var/www/html`.
Ejecutar los comandos directamente, SIN prefijo `docker exec` ni `docker compose exec`.

```bash
php artisan migrate
composer install
./vendor/bin/phpunit
./vendor/bin/phpunit --filter=NombreTest
npm run dev
```
