<a href="#" onclick="editAnalisisAjax({{$id}}); return false;" class="btn btn-link float-right btn-clinica" title="Editar Analisis">
    <i class="far fa-edit fa-lg"></i>
</a>
@if (!$isHasResult)
    <a href="{{ route('analisis.analisisextendido', $id) }}" class="btn btn-link float-right btn-clinica" title="Detallar Resultados">
        <i class="fas fa-tasks"></i>
    </a>
@else
    <a href="{{route($routeView, ['analisisId' => $id])}}" class="btn btn-link float-right btn-clinica" title="Ver Resultados">
        <i class="far fa-eye"></i>
    </a>
@endif
@if($precio != ($acuenta + $pago_efectuado))
    <a href="#" onclick="openModalPago(this); return false;" data-id="{{$id}}" class="btn btn-link float-right btn-clinica" title="Realizar pago">
        <i class="fas fa-money-bill-wave"></i>
    </a>
@endif