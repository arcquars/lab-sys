<a href="#" onclick="editPersonAjax({{$id}}); return false;" class="btn btn-link float-right" title="Editar Persona">
{{--    Edit {{$id}}--}}
    <i class="far fa-edit fa-lg"></i> Editar
</a>
{{--<a href="{{route('analisis.crearanalisis', $id)}}" class="btn btn-link float-right" title="Crear Analisis">--}}
{{--    <i class="fas fa-notes-medical fa-lg"></i>--}}
{{--</a>--}}
<a href="{{route('analisis.crear.analisis.hemo', $id)}}" class="btn btn-link float-right" title="Crear Analisis Hemo">
    <i class="fas fa-notes-medical fa-lg"></i> Crear analisis
</a>
<a href="{{route('analisis.listByPerson', $id)}}" class="btn btn-link float-right" title="Kadex">
    <i class="fas fa-database fa-lg"></i> Kardex
</a>
