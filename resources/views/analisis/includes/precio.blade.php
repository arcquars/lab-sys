@if($precio == ($acuenta + $pago_efectuado))
    Cancelado
@else
    <p class="p-estado-red">Debe {{ $precio - ($acuenta + $pago_efectuado)  }}</p>
@endif
