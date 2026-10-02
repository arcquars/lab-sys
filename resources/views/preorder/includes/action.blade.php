{{-- <a href="#" onclick="editPreOrderAjax({{ $id }}); return false;" class="btn btn-link float-right" title="Editar Pre-orden">
    <i class="far fa-edit fa-lg"></i> Editar
</a> --}}
@if($state === \App\PreOrder::STATE_NUEVO)
<a href="#" class="btn btn-link float-right btn-crear-analisis-preorder" title="Crear Análisis"
   data-id="{{ $id }}"
   data-ci="{{ $patient_ci }}"
   data-name="{{ $patient_full_name }}"
   data-birth="{{ isset($patient_birth_date) && $patient_birth_date ? $patient_birth_date->format('Y-m-d') : '' }}"
   data-gender="{{ $patient_gender }}">
    <i class="fas fa-notes-medical fa-lg"></i>
</a>
@endif
@if($state === \App\PreOrder::STATE_CREADO && $analisis_id)
<a href="{{ route('test.viewResultado', $analisis_id) }}"
   class="btn btn-link float-right" title="Ir al análisis">
    <i class="fas fa-arrow-right fa-lg"></i>
</a>
@endif
<a href="#" onclick="openDeletePreOrderAjax({{ $id }}); return false;" class="btn btn-link p-1 text-danger float-right" title="Eliminar Pre-orden">
    <i class="fas fa-trash"></i>
</a>
