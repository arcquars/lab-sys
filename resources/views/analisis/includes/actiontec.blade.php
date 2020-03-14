@if (!$isHasResult)
    {{--    @can('manage-users')--}}
    <a href="{{ route('analisis.analisisextendido', $id) }}" class="btn btn-link float-right btn-clinica" title="Detallar Resultados">
        <i class="fas fa-tasks"></i>
    </a>
@else
    <a href="{{route($routeView, ['analisisId' => $id])}}" class="btn btn-link float-right btn-clinica" title="Ver Resultados">
        <i class="far fa-eye"></i>
    </a>
@endif