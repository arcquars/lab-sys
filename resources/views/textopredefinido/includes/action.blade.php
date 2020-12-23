<a href="{{route('texto-predefinido.edit', array('texto_predefinido' => $id))}}" title="Editar Texto predefinido">
    <i class="far fa-edit fa-lg"></i>
</a>
<a href="#" onclick="deleteTexto({{$id}});" class="text-danger" title="Eliminar Texto predefinido">
    <i class="far fa-trash-alt fa-lg"></i>
</a>