@if($precio == ($acuenta + $pago_efectuado))
    Cancelado
@else
    @php
    $saldo = $precio - ($acuenta + $pago_efectuado);
    @endphp
    <p class="p-estado-red">Debe {{$saldo}}</p>
@endif
