{{--
    render-tree-groups.blade.php
    Renderiza los grupos raíz del directorio de análisis.
    Diseño: acordeón tipo directorio con grid de 3 columnas por análisis.
--}}
@foreach($groups as $key => $group)
<div class="test-group-section">

    {{-- Header de sección principal (ej: ALERGIAS) --}}
    <div class="test-section-header"
         data-toggle="collapse"
         data-target="#sectionBody{{ $group->id }}"
         aria-expanded="{{ $key === 0 ? 'true' : 'false' }}">

        <i class="fas fa-chevron-down toggle-icon {{ $key === 0 ? '' : 'collapsed' }}"></i>
        <h6>{{ strtoupper($group->name) }}</h6>

        {{-- Acciones del grupo (visibles al hover) --}}
        <div class="group-header-actions">
            <button class="btn-action edit"
                    onclick="event.stopPropagation(); openModalEditGroupTest({{ $group->id }});"
                    title="Editar grupo">
                <i class="far fa-edit"></i>
            </button>
            <button class="btn-action delete"
                    onclick="event.stopPropagation(); openModalAnalysisTestGroupDelete({{ $group->id }});"
                    title="Eliminar grupo">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    </div>

    {{-- Cuerpo de la sección --}}
    <div id="sectionBody{{ $group->id }}"
         class="test-section-body collapse {{ $key === 0 ? 'show' : '' }}">

        {{-- Si tiene análisis directos, renderizarlos en grid --}}
        @if($group->analysisTests->count() > 0)
        <div class="test-cards-grid">
            @foreach($group->analysisTests as $test)
            <div class="test-card-item">
                {{-- Handle de reordenamiento --}}
                <span class="test-card-drag-handle" title="Reordenar">&#x2225;</span>

                <div class="test-card-content">
                    <p class="test-card-name" title="{{ $test->name }}">{{ $test->name }}</p>
                    <div class="test-card-meta">
                        <span class="test-card-price">${{ $test->price }} Bs.</span>
                        <span class="test-card-type">{{ strtoupper($test->type) }}</span>
                    </div>
                </div>

                {{-- Acciones (visibles al hover) --}}
                <div class="test-card-actions">
                    <button class="btn-action edit"
                            onclick="openModalAnalysisTest({{ $test->id }});"
                            title="Editar análisis">
                        <i class="far fa-edit"></i>
                    </button>
                    <button class="btn-action delete"
                            onclick="openModalAnalysisTestDelete({{ $test->id }});"
                            title="Eliminar análisis">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Sub-grupos hijos (ej: HEMOGRAMA dentro de AREA DE HEMATOLOGIA) --}}
        @if($group->children->count() > 0)
            @include('a-test.partials.render-tree-child-groups', [
                'level'    => 1,
                'childs'   => $group->children,
                'group_id' => isset($group_id) ? $group_id : null
            ])
        @endif

    </div>
</div>
@endforeach

{{-- Script para sincronizar el ícono de toggle con el estado del collapse --}}
<script>
    $(document).on('show.bs.collapse', '.test-section-body, .test-subsection-body', function () {
        $(this).prev().find('.toggle-icon').removeClass('collapsed');
    });
    $(document).on('hide.bs.collapse', '.test-section-body, .test-subsection-body', function () {
        $(this).prev().find('.toggle-icon').addClass('collapsed');
    });
</script>
