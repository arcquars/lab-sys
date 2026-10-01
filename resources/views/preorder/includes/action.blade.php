{{-- <a href="#" onclick="editPreOrderAjax({{ $id }}); return false;" class="btn btn-link float-right" title="Editar Pre-orden">
    <i class="far fa-edit fa-lg"></i> Editar
</a> --}}
@if($state === \App\PreOrder::STATE_NUEVO)
<a href="#" class="btn btn-link float-right btn-crear-analisis-preorder" title="Crear Análisis"
   data-id="{{ $id }}" data-ci="{{ $patient_ci }}" data-name="{{ $patient_full_name }}">
    <i class="fas fa-notes-medical fa-lg"></i>
</a>
@endif
<a href="#" onclick="openDeletePreOrderAjax({{ $id }}); return false;" class="text-danger float-right" title="Eliminar Pre-orden">
    <i class="fas fa-trash"></i>
</a>
