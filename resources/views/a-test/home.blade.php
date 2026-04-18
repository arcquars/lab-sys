@extends('layouts.dash', ['activePage' => 'atest_index', 'navName' => 'Analisis', 'activeButton' => ''])

@section('content')

<style>
    /* =============================================
       Estilos del Directorio de Análisis
       ============================================= */

    /* Encabezado principal del directorio */
    .directory-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background: #fff;
        border-bottom: 1px solid #e9ecef;
        border-radius: 8px 8px 0 0;
        margin-bottom: 0;
    }

    .directory-header h5 {
        font-size: 1rem;
        font-weight: 600;
        color: #2d3748;
        margin: 0;
    }

    .directory-category-badge {
        font-size: 0.72rem;
        font-weight: 600;
        color: #6c757d;
        border: 1px solid #dee2e6;
        border-radius: 20px;
        padding: 4px 12px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    /* Contenedor del árbol de grupos */
    .test-directory-wrapper {
        background: #fff;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        overflow: hidden;
    }

    /* Sección de categoría principal (ej: ALERGIAS) */
    .test-section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 20px;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        cursor: pointer;
        user-select: none;
    }

    .test-section-header:first-of-type {
        border-top: none;
    }

    .test-section-header .toggle-icon {
        color: #6c757d;
        font-size: 0.8rem;
        transition: transform 0.2s ease;
        width: 14px;
    }

    .test-section-header .toggle-icon.collapsed {
        transform: rotate(-90deg);
    }

    .test-section-header h6 {
        margin: 0;
        font-size: 0.78rem;
        font-weight: 700;
        color: #495057;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    /* Sub-sección (ej: HEMOGRAMA) */
    .test-subsection-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 28px;
        background: #fff;
        border-top: 1px solid #f1f3f5;
        cursor: pointer;
        user-select: none;
    }

    .test-subsection-header .toggle-icon {
        color: #adb5bd;
        font-size: 0.75rem;
        transition: transform 0.2s ease;
        width: 12px;
    }

    .test-subsection-header .toggle-icon.collapsed {
        transform: rotate(-90deg);
    }

    .test-subsection-header h6 {
        margin: 0;
        font-size: 0.78rem;
        font-weight: 600;
        color: #6c757d;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    /* Grid de tarjetas de análisis */
    .test-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0;
        padding: 0 20px 12px;
        background: #fff;
    }

    .test-cards-grid.subsection-grid {
        padding-left: 36px;
    }

    /* Tarjeta individual de análisis */
    .test-card-item {
        display: flex;
        align-items: flex-start;
        padding: 10px 12px;
        border-radius: 6px;
        transition: background 0.15s ease;
        position: relative;
    }

    .test-card-item:hover {
        background: #f8f9fa;
    }

    /* Handle de drag (los || de la imagen) */
    .test-card-drag-handle {
        color: #ced4da;
        font-size: 0.75rem;
        cursor: grab;
        margin-right: 8px;
        margin-top: 2px;
        letter-spacing: -2px;
        line-height: 1;
    }

    .test-card-content {
        flex: 1;
        min-width: 0;
    }

    .test-card-name {
        font-size: 0.855rem;
        font-weight: 500;
        color: #2d3748;
        margin: 0 0 4px 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .test-card-meta {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .test-card-price {
        font-size: 0.75rem;
        font-weight: 600;
        color: #20c997;
    }

    .test-card-type {
        font-size: 0.68rem;
        font-weight: 500;
        color: #adb5bd;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* Acciones hover por tarjeta */
    .test-card-actions {
        display: none;
        gap: 2px;
        margin-left: 4px;
    }

    .test-card-item:hover .test-card-actions {
        display: flex;
    }

    .test-card-actions .btn-action {
        background: none;
        border: none;
        padding: 2px 5px;
        font-size: 0.75rem;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.15s;
    }

    .test-card-actions .btn-action.edit {
        color: #4dabf7;
    }

    .test-card-actions .btn-action.edit:hover {
        background: #e7f5ff;
    }

    .test-card-actions .btn-action.delete {
        color: #ff8787;
    }

    .test-card-actions .btn-action.delete:hover {
        background: #fff5f5;
    }

    /* Acciones de grupo (editar/eliminar en header) */
    .group-header-actions {
        display: none;
        gap: 4px;
        margin-left: auto;
        padding-right: 4px;
    }

    .test-section-header:hover .group-header-actions,
    .test-subsection-header:hover .group-header-actions {
        display: flex;
    }

    .group-header-actions .btn-action {
        background: none;
        border: none;
        padding: 2px 6px;
        font-size: 0.75rem;
        border-radius: 4px;
        cursor: pointer;
    }

    .group-header-actions .btn-action.edit {
        color: #74c0fc;
    }

    .group-header-actions .btn-action.edit:hover {
        background: #e7f5ff;
    }

    .group-header-actions .btn-action.delete {
        color: #ffa8a8;
    }

    .group-header-actions .btn-action.delete:hover {
        background: #fff5f5;
    }

    /* Highlight en búsqueda */
    .search-highlight .test-card-name {
        background: #fff3bf;
        border-radius: 3px;
        padding: 0 2px;
    }

    /* Barra de búsqueda */
    .directory-search .input-group-text {
        background: #f8f9fa;
        border-color: #dee2e6;
        color: #adb5bd;
    }

    .directory-search .form-control {
        border-color: #dee2e6;
        font-size: 0.875rem;
    }

    .directory-search .form-control:focus {
        border-color: #74c0fc;
        box-shadow: 0 0 0 0.15rem rgba(116, 192, 252, 0.25);
    }

    /* Botones de acción principales */
    .btn-directory-action {
        font-size: 0.8rem;
        padding: 6px 14px;
        border-radius: 6px;
        font-weight: 500;
    }

    /* Loading spinner */
    .tree-loading {
        text-align: center;
        padding: 40px;
        color: #adb5bd;
    }

    /* Responsive: 2 columnas en tablet */
    @media (max-width: 992px) {
        .test-cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Responsive: 1 columna en móvil */
    @media (max-width: 576px) {
        .test-cards-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Directorio de Análisis</li>
    </ol>
</nav>

<div class="card p-0" style="border-radius: 8px; border: 1px solid #e9ecef;">
    <div class="card-body p-0">

        {{-- Toolbar superior --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap p-3 border-bottom gap-2">
            <div class="d-flex gap-2">
                <button type="button"
                        class="btn btn-secondary btn-directory-action mr-2"
                        onclick="openModalCreateGroupTest();">
                    <i class="fas fa-vials mr-1"></i> Crear grupo
                </button>
                <button type="button"
                        class="btn btn-secondary btn-directory-action"
                        onclick="openModalCreateTest();">
                    <i class="fas fa-vial mr-1"></i> Crear Prueba
                </button>
            </div>
            <div class="directory-search" style="min-width: 260px;">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text"
                           class="form-control"
                           id="searchAtestInput"
                           placeholder="Buscar análisis..."
                           oninput="searchAtest(this);">
                </div>
            </div>
        </div>

        {{-- Directorio con header tipo imagen --}}
        <div class="test-directory-wrapper border-0">

            {{-- Header del directorio --}}
            <div class="directory-header border-bottom">
                <h5 class="mb-0">Directorio de Análisis</h5>
                <span class="directory-category-badge" id="categoryCount">— Categorías</span>
            </div>

            {{-- Contenedor del árbol generado vía AJAX --}}
            <div id="tree_group_container">
                <div class="tree-loading">
                    <i class="fas fa-cog fa-spin fa-2x mb-2"></i>
                    <div class="small">Cargando directorio...</div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('a-test.includes.modals.m_create_group', ['rangeTypeList', $rangeTypeList])
@include('a-test.includes.modals.m_create_test')
@include('a-test.includes.modals.m_edit_test')
@include('a-test.includes.modals.m_delete_test')
@include('a-test.includes.modals.m_delete_test_group')
@include('a-test.includes.modals.m_edit_group')

@endsection

@push('js')
<script>
    $(document).ready(function () {
        loadTreeTestGroup();
    });

    // Carga el árbol de grupos vía AJAX
    function loadTreeTestGroup() {
        $("#tree_group_container").html(renderLoading());
        $.ajax({
            url: "{{ route('analysis-test-group.render.tree') }}",
            success: function (data) {
                $("#tree_group_container").empty().append(data);
                updateCategoryCount();
                initToggleBehavior();
            }
        });
    }

    // Cuenta las categorías raíz y actualiza el badge
    function updateCategoryCount() {
        const count = $(".test-section-header").length;
        $("#categoryCount").text(count + (count === 1 ? " Categoría" : " Categorías"));
    }

    // Inicializa los toggles de collapse nativos (sin Bootstrap collapse para control total)
    function initToggleBehavior() {
        // Delegado: ya funciona vía data-toggle de Bootstrap en los partials
    }

    // Render del spinner de carga
    function renderLoading() {
        return '<div class="tree-loading"><i class="fas fa-cog fa-spin fa-2x mb-2 d-block"></i><div class="small text-muted">Cargando directorio...</div></div>';
    }

    // Agregar opción de tipo Rango
    function addTestTypeRange() {
        $.ajax({
            url: "{{ route('analysis-test.render-range-option') }}",
            success: function (data) {
                $("#rangeListOptions").append(data);
            }
        });
    }

    // Agregar opción de tipo Rango Sin Orden
    function addTestTypeRangeNoOrder() {
        $.ajax({
            url: "{{ route('analysis-test.render-range-no-order-option') }}",
            success: function (data) {
                $("#rangeNoOrderListOptions").append(data);
            }
        });
    }

    // Agregar opción de tipo Límite
    function addTestTypeLimit() {
        $.ajax({
            url: "{{ route('analysis-test.render-limit-option') }}",
            success: function (data) {
                $("#rangeListOptions").append(data);
            }
        });
    }

    // Agregar opción de tipo Genérico
    function addTestTypeGeneric() {
        $.ajax({
            url: "{{ route('analysis-test.render-generic-option') }}",
            success: function (data) {
                $("#genericListOptions").append(data);
            }
        });
    }

    function removeTestTypeRange(button) {
        $(button).parent().parent().parent().parent().remove();
    }

    function removeTestTypeLimit(button) {
        $(button).parent().parent().parent().remove();
    }

    function removeTestTypeGeneric(button) {
        $(button).parent().parent().parent().remove();
    }

    // Agrega un intermediario de rango
    function addRangeIntermediary(link, tempId) {
        let intermediary = $(link).prev();
        $.ajax({
            url: "{{ route('analysis-test.render-range-option-intermediary') }}",
            data: { tempId, count: $(intermediary).children().length },
            success: function (data) {
                $(intermediary).append(data);
            }
        });
    }

    function removeRangeIntermediary(link) {
        $(link).parents().eq(3).remove();
    }

    // Búsqueda en tiempo real sobre el árbol renderizado
    function searchAtest(input) {
        const strSearch = $(input).val().toLowerCase().trim();

        // Quitar highlights previos
        $(".test-card-item").removeClass("search-highlight");

        if (strSearch.length < 3) {
            // Restaurar vista completa
            $(".test-section-body, .test-subsection-body").show();
            $(".test-section-header .toggle-icon, .test-subsection-header .toggle-icon")
                .removeClass("collapsed");
            return;
        }

        // Ocultar todo primero
        $(".test-section-body").hide();
        $(".test-subsection-body").hide();

        let found = false;
        $(".test-card-item").each(function () {
            const name = $(this).find(".test-card-name").text().toLowerCase().trim();
            if (name.includes(strSearch)) {
                $(this).addClass("search-highlight");
                // Mostrar contenedor padre
                const sectionBody = $(this).closest(".test-section-body");
                const subsectionBody = $(this).closest(".test-subsection-body");
                sectionBody.show();
                subsectionBody.show();
                // Asegurar que el toggle esté abierto
                sectionBody.prev(".test-section-header").find(".toggle-icon").removeClass("collapsed");
                subsectionBody.prev(".test-subsection-header").find(".toggle-icon").removeClass("collapsed");
                found = true;
            }
        });
    }
</script>
@endpush
