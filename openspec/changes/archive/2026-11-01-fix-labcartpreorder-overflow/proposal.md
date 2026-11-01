## Why

En `resources/views/analisis/crear-hemo-v2.blade.php`, el bloque `#labCartPreOrder` (carrito flotante de pruebas de pre-orden) usa `position: fixed` sin `max-height` ni `overflow-y`, y su contenido `#labCartPreOrderItems` tampoco scrollea. Cuando la pre-orden tiene varias categorías o pruebas personalizadas, el bloque crece más allá del viewport y, al ser `fixed`, no hay manera de hacer scroll para ver el resto: el contenido final queda cortado. El carrito principal (`#labCart`) ya resuelve esto mismo con `max-height` + `overflow-y:auto`, pero el carrito de pre-orden no replica ese patrón.

## What Changes

- Agregar `display:flex; flex-direction:column; overflow:hidden;` y un `max-height` base al CSS de `#labCartPreOrder`.
- Agregar `overflow-y:auto; flex:1;` a `#labCartPreOrderItems` para que el listado scrollee internamente en vez de desbordar la página.
- Actualizar la función JS `placePreOrderCart()` para que, además del `top` dinámico que ya calcula, fije también un `max-height` dinámico en función del espacio restante de la ventana (`window.innerHeight - top - margen`), ya que el `top` varía según la altura de `#labCart`.
- Sin cambios de backend, rutas, controladores, modelos ni migraciones.

## Capabilities

### New Capabilities
No aplica.

### Modified Capabilities
No aplica — es una corrección visual/CSS de un bug de overflow; no cambia ningún requisito de negocio ni contrato de datos. Este change se marca `skip_specs: true`.

## Impact

- Archivo afectado: `resources/views/analisis/crear-hemo-v2.blade.php` (bloque CSS de `#labCartPreOrder`/`#labCartPreOrderItems` y función JS `placePreOrderCart()`).
- Alcance: solo frontend (CSS + jQuery), vista `analisis/crear-hemo-v2`. No requiere migraciones ni cambios en PHP 7.4/Laravel 6.x del lado servidor.
