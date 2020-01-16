@can('manage-users')
    @if(!$entregado)
<a href="#" onclick="openModalFechaEntrega(this); return false;" data-id="{{$id}}" class="btn btn-link float-right btn-clinica" title="Fecha Entrega">
    <i class="far fa-calendar-times "></i>
</a>
    @endif
    @if(!isset($fechaCierre))
<a href="#" onclick="openModalCerrarAnalisis(this); return false;" data-id="{{$id}}" class="btn btn-link float-right btn-clinica" title="Cerrar Analisis">
    <i class="fas fa-hourglass-end "></i>
</a>
    @endif
@endcan
@if (!$isHasResult)
{{--    @can('manage-users')--}}
    <a href="{{ route('analisis.analisisextendido', $id) }}" class="btn btn-link float-right btn-clinica" title="Detallar Resultados">
        <i class="fas fa-tasks"></i>
    </a>
{{--    @endcan--}}
@else
    <a href="{{route($routeView, ['analisisId' => $id])}}" class="btn btn-link float-right btn-clinica" title="Ver Resultados">
        <i class="far fa-eye"></i>
    </a>
@endif
@if($precio != ($acuenta + $pago_efectuado))
    @can('manage-users')
    <a href="#" onclick="openModalPago(this); return false;" data-id="{{$id}}" class="btn btn-link float-right btn-clinica" title="Realizar pago">
        <i class="fas fa-money-bill-wave"></i>
    </a>
    @endcan
@endif