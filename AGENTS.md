# AGENTS.md — Hemolab (PHP 7.4 / Laravel 6.x)

Sistema de laboratorio de patología clinica. Procesa analisis clinicos (citologias, biopsias, inmunohistoquimica, biologia molecular, asthianas, liquidos).

## Restricciones de versiones (CRITICO)

- **PHP 7.4** — NO usar `match`, `enum`, `readonly`, union types `|`, named arguments, attributes, constructor promotion. Flechas cortas `fn()` y `??=` si estan permitidos.
- **Laravel 6.x** — NO usar `Route::controller()`, jobs/features de Laravel 8+. Usar Resource Controllers, FormRequest, Policies, Gates.
- **Bootstrap 4** — NO usar clases de Bootstrap 5.
- **jQuery** — frontend usa jQuery. `vue` esta en `package.json` como devDependency pero NO se usa en SPA.

## Comandos — SIEMPRE dentro del contenedor Docker

El contenedor se llama `php74` y monta `/var/www/html`.

```bash
# Artisan
docker exec -it php74 php artisan <comando>

# Composer
docker exec -it php74 composer <comando>

# Pruebas (PHPUnit 8)
docker exec -it php74 ./vendor/bin/phpunit
docker exec -it php74 ./vendor/bin/phpunit --filter=NombreTest   # una sola prueba
docker exec -it php74 ./vendor/bin/phpunit tests/Unit            # solo unitarias
docker exec -it php74 ./vendor/bin/phpunit tests/Feature         # solo feature

# Frontend (SCSS/JS via laravel-mix 4)
docker exec -it php74 npm run dev     # desarrollo
docker exec -it php74 npm run prod    # produccion
```

**NOTA sobre route:cache:** Actualmente hay closures en `routes/web.php` (lineas 14, 19, 45) que impiden `php artisan route:cache`. Si se necesita cache de rutas, migrar esas rutas a controladores.

## Arquitectura

### Modelos (en `app/`, NO en `app/Models/` — estilo Laravel 6)

| Entidad | Modelo |
|---|---|
| Pacientes | `Person.php` |
| Usuarios | `User.php` (roles: admin, secretaria, tecnico, medio, invitado/addmore) |
| Analisis | `Analisis.php` — recibe multiples tipos de prueba asociados |
| Doctores / firmantes | `Doctor.php` |
| Instituciones / facturacion | `Contrato.php` |
| Gastos | `Gasto.php` |
| Marcadores | `Marcador.php`, `Marker.php`, `MarcadorBiologia.php` |
| Plantillas de pruebas | `AnalysisTest*.php` (~20 archivos en `app/`) |

### Patron CRUD

- La mayoria de interacciones CRUD se hacen via AJAX (`$.post`) con metodos `ajax*` en los controladores.
- **No hay API REST real** — `/api.php` solo exporta el usuario autenticado.
- Rutas publicas (sin login): rutas de cotizacion y `/analisis/cerrar_analisis/{id}`.

### Configuracion clave

- `config/clinica.php` — **fuente de verdad** para catalogos del negocio (procedencias, tipos de analisis, clasificaciones Bethesda, marcadores, contadores).
- `config/pdf.php` — fuentes mPDF personalizadas (Times New Roman, Aptos, Sansita Swashed); tamaño `Letter`; `$tempDir` = `public/temp/`.
- `config/excel.php` — Maatwebsite Excel config.
- `config/honeypot.php` — anti-spam (activado/desactivado con `HONEYPOT_ENABLED` en `.env`).

### Paquetes clave

- **PDF:** `niklasravnsborg/laravel-pdf` ^4.1 (mpdf)
- **Excel:** `maatwebsite/excel` ^3.1 — usar `FromQuery`, NO `FromCollection` para datasets grandes. Exports en `app/Exports/`.
- **Datatables:** `yajra/laravel-datatables-oracle` ~9.0 (server-side via AJAX). Cada entidad tiene su metodo `getDatatablesData`.
- **Barcode:** `milon/barcode` ^6.0
- **Honeypot:** `spatie/laravel-honeypot` ^2.0 en form de cotizacion (`POST /cotizacion/pdf`)
- **SCSS:** `sass` ^1.20 con laravel-mix 4

### Vistas

- Blade con layouts en `resources/views/layouts/`. Layout principal: Light Bootstrap Dashboard.
- `resources/views/exports/` — templates para Excel/PDF.
- ~33 carpetas de vistas organizadas por modulo (test, citologia, biopsia, etc.).

## Migraciones

Esquema maduro (~100 migraciones). **Siempre crear migraciones nuevas, nunca editar migraciones viejas.**

Tablas principales: `analisis`, `persons`, `usuarios`, `analyses_bassador_groups`, `analysis_test_*`, `biopsias`, `histoquimicas`, `bethesda`, `liquidos`, `biomediamolecular`, `marcadores`.

## Codigos de analisis

Los analisis de cliente generan codigo automatico en formato `[tipo] prueba [n]` (ej: `?+0001++`).

## Skills disponibles

- `.claude/skills/` — 7 archivos: database, docker, frontend, jquery, laravel, php, bootstrap
- `.agent/skills/` — 2 archivos: php7.4-compatibility, laravel6-conventions
- `skills/` — 7 archivos: database-inspection, dependency-guard, implementation-planning, jquery-ajax, legacy-analysis, legacy-guardian, php-coding-standards

## Datos de desarrollo (solo LOCAL)

- Dev server: `http://hemotest.lab-cdcc.com`
- Usuarios: `admin@hemo.bo` / `secretaria@hemo.bo` / `tecnico@hemo.bo` / `medico@hemo.bo` (contraseña: `hemo321`)
- Ver datos sensibles en `datos-importantes.md` (NO en este archivo).