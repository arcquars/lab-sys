## 1. CSS — contenedor del carrito de pre-orden

- [x] 1.1 En el bloque CSS de `#labCartPreOrder` (`resources/views/analisis/crear-hemo-v2.blade.php`), agregar `display:flex; flex-direction:column; overflow:hidden;` y un `max-height` base, siguiendo el mismo patrón que `#labCart`. Verificar inspeccionando el elemento en devtools: debe tener `overflow: hidden` aplicado.
- [x] 1.2 Agregar `overflow-y:auto; flex:1;` a `#labCartPreOrderItems`. Verificar que, con contenido largo forzado (ej. agregando temporalmente varios `.lab-cart-item` de prueba en devtools), aparece scrollbar interno en vez de desbordar la página.

## 2. JS — ajuste dinámico de altura

- [x] 2.1 Modificar `placePreOrderCart()` para, además de fijar `top`, calcular y fijar `max-height` en función del espacio restante de la ventana (`window.innerHeight - bottom - margen`). Verificar en consola del navegador que `$('#labCartPreOrder').css('max-height')` refleja un valor coherente con el alto de ventana tras cargar una pre-orden.
- [x] 2.2 Confirmar que `placePreOrderCart()` se re-ejecuta en los mismos triggers actuales (`labCartRefresh`, `resize`, carga inicial) sin necesitar triggers nuevos.

## 3. Verificación manual end-to-end (Asignada a: usuario — Claude no verifica en navegador)

- [x] 3.1 Abrir `crear-hemo-v2` con `?preOrden=<id>` de una pre-orden que tenga varias categorías y/o pruebas personalizadas (suficientes para exceder el alto visible — ej. preOrden=9: 5 pruebas + 2 personalizadas en 2 categorías). Confirmar que todo el listado de `#labCartPreOrderItems` es accesible mediante scroll interno y no queda cortado por el final de la página.
- [x] 3.2 Repetir la verificación con una pre-orden de pocas pruebas (caso sin overflow) y confirmar que el bloque se ve igual que antes (sin scrollbar, sin recortes, sin huecos extra).
- [x] 3.3 Confirmar que en viewport ≤ 992px no hay regresión (el bloque sigue oculto por la media query existente `#labCartPreOrder { display:none !important; }`).

Nota: este change es puramente frontend (CSS + jQuery) en una sola vista Blade; no afecta lógica PHP, por lo que no aplica una verificación con `./vendor/bin/phpunit`.
