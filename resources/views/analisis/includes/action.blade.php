<a href="#" onclick="editAnalisisAjax({{$id}}); return false;" class="btn btn-link float-right" title="Editar Analisis">
    <i class="far fa-edit fa-lg"></i>
</a>
@if (!$isHasResult)
    <a href="{{ route('analisis.analisisextendido', $id) }}" class="btn btn-link float-right" title="Detallar Resultados">
        <i class="fas fa-tasks"></i>
    </a>
@else
    <a href="{{route($routeView, ['analisisId' => $id])}}" class="btn btn-link float-right" title="Detallar Resultados">
        <i class="far fa-eye"></i>
    </a>
@endif

