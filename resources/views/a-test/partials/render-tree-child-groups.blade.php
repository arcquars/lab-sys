{{--
    render-tree-child-groups.blade.php
    Renderiza sub-grupos anidados del directorio de análisis.
    Se llama recursivamente aumentando $level por cada nivel de profundidad.
--}}
@foreach($childs as $child)
<div class="test-subgroup-section" style="padding-left: {{ ($level - 1) * 12 }}px;">

    {{-- Header de sub-sección (ej: HEMOGRAMA) --}}
    <div class="test-subsection-header"
         data-toggle="collapse"
         data-target="#subsectionBody{{ $child->id }}"
         aria-expanded="false">

        <i class="fas fa-chevron-down toggle-icon collapsed"></i>
        <h6>{{ strtoupper($child->name) }}</h6>

        {{-- Acciones del sub-grupo (visibles al hover) --}}
        <div class="group-header-actions">
            <button class="btn-action edit"
                    onclick="event.stopPropagation(); openModalEditGroupTest({{ $child->id }});"
                    title="Editar grupo">
                <i class="far fa-edit"></i>
            </button>
            <button class="btn-action delete"
                    onclick="event.stopPropagation(); openModalAnalysisTestGroupDelete({{ $child->id }});"
                    title="Eliminar grupo">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    </div>

    {{-- Cuerpo del sub-grupo --}}
    <div id="subsectionBody{{ $child->id }}"
         class="test-subsection-body collapse">

        {{-- Análisis del sub-grupo en grid de 3 columnas --}}
        @if($child->analysisTests->count() > 0)
        <div class="test-cards-grid subsection-grid">
            @foreach($child->analysisTests as $test)
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

        {{-- Recursión: sub-sub-grupos --}}
        @if($child->children->count() > 0)
            @include('a-test.partials.render-tree-child-groups', [
                'level'    => $level + 1,
                'childs'   => $child->children,
                'group_id' => isset($group_id) ? $group_id : null
            ])
        @endif

    </div>
</div>
@endforeach
