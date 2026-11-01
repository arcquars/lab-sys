## 1. Implementación en `getDatatablesData`

- [ ] 1.1 En la rama `if($user->person)` (código actual ~líneas 424-437 de `app/Http/Controllers/AnalisisController.php`), reemplazar `->where('codigo', 'like', '%'.$searchG.'%')` por un grupo `->where(function($query) use ($searchG) { $query->where('codigo', 'like', '%'.$searchG.'%')->orWhereHas('person', function($q) use ($searchG) { $q->where('nombres', 'like', '%'.$searchG.'%')->orWhere('apellidos', 'like', '%'.$searchG.'%'); }); })`, sin tocar el `whereHas('person', ...)` existente de búsqueda por columna. Verificar con `php -l app/Http/Controllers/AnalisisController.php` (sin errores de sintaxis).
- [ ] 1.2 Aplicar el mismo patrón a la rama `else` (~líneas 440-446), reemplazando su `->where('codigo', 'like', '%'.$searchG.'%')` equivalente. Verificar con `php -l app/Http/Controllers/AnalisisController.php`.

## 2. Verificación de solo lectura (sin escribir en la BD)

- [ ] 2.1 Con `php artisan tinker`, ejecutar directamente la consulta Eloquent resultante (sin guardar nada) contra datos reales existentes y confirmar que buscar un nombre o apellido de un paciente con análisis registrados devuelve esos análisis, aunque el texto no coincida con ningún `codigo`.
- [ ] 2.2 Con `php artisan tinker`, confirmar (solo lectura) que para un usuario con rol médico vinculado a un doctor, buscar un texto que coincide con el `codigo`/`nombre`/`apellido` de un análisis asignado a **otro** doctor no lo incluye en el resultado (el scoping de seguridad sigue intacto).

## 3. Verificación manual end-to-end (Asignada a: usuario — Claude no verifica en navegador)

- [ ] 3.1 Abrir el listado de análisis (`analisis.home`), escribir en la caja de búsqueda global el nombre o apellido de un paciente con análisis registrados, y confirmar que aparecen resultados.
- [ ] 3.2 Confirmar que las búsquedas por columna ("Cliente" / "Ap") siguen funcionando igual que antes, de forma independiente de la búsqueda global.
- [ ] 3.3 Si el usuario que prueba tiene rol médico, confirmar que la búsqueda global no muestra análisis de otros doctores fuera de su alcance.
