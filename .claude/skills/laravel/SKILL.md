---
name: laravel
description: Convenciones Laravel 6.x de Hemolab. Usar al crear o modificar rutas, controladores, modelos Eloquent, FormRequests, policies, exports Excel o PDFs.
---

# Laravel 6.x

Asumir siempre Laravel 6.x. Respetar la estructura existente.

## No usar

- `Route::controller()`
- Features de Laravel 8+ (factories basadas en clases, job batching, etc.)
- Sintaxis PHP 8 (ver skill `php`)

## Usar

- Resource Controllers, FormRequest, Policies, Gates
- Eloquent ORM para consultas; Query Builder cuando Eloquent no alcance
- Modelos en `app/` (NO `app/Models/`)
- CRUD via AJAX con metodos `ajax*` en controladores
- Datatables server-side con `yajra/laravel-datatables-oracle` (metodo `getDatatablesData`)

## Paquetes

- PDF: `niklasravnsborg/laravel-pdf` (mPDF). Config en `config/pdf.php`.
- Excel: `maatwebsite/excel` 3.1. Exports en `app/Exports/`; usar `FromQuery` (no `FromCollection`) para datasets grandes.
- Catalogos de negocio: `config/clinica.php` es la fuente de verdad.
