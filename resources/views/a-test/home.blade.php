@extends('layouts.dash', ['activePage' => 'atest_index', 'navName' => 'Analisis', 'activeButton' => ''])

@section('content')

<style>
    /* =============================================
       Directorio de Análisis — Bootstrap 4.6
       Compatible con Light Bootstrap Dashboard
       ============================================= */

    /*
     * FIX CRÍTICO PARA MÓVIL:
     * Light Bootstrap Dashboard aplica padding: 30px 15px al .main-panel>.content
     * En pantallas pequeñas ese padding consume demasiado espacio útil.
     */
    @media (max-width: 767px) {
        .main-panel > .content {
            padding: 15px 8px !important;
        }
    }

    @media (max-width: 400px) {
        .main-panel > .content {
            padding: 10px 4px !important;
        }
    }

    /* ─── Breadcrumb ────────────────────────────── */
    .breadcrumb {
        padding: 6px 0;
        background: transparent;
        margin-bottom: 8px;
        font-size: 0.82rem;
    }

    /* ─── Card contenedor principal ─────────────── */
    .directory-card {
        border-radius: 8px;
        border: 1px solid #e9ecef;
        background: #fff;
        overflow: hidden;
        width: 100%;
        box-sizing: border-box;
    }

    /* ─── Toolbar ──────────────────────────────── */
    .toolbar-wrapper {
        padding: 12px 16px;
        border-bottom: 1px solid #e9ecef;
    }

    .toolbar-top-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .toolbar-buttons {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }

    .toolbar-buttons .btn {
        font-size: 0.8rem;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        white-space: nowrap;
    }

    /* Buscador crece para ocupar espacio restante */
    .directory-search {
        flex: 1;
        min-width: 0; /* FIX: sin esto el input flex desborda */
    }

    .directory-search .input-group-text {
        background: #f8f9fa;
        border-color: #dee2e6;
        color: #adb5bd;
        font-size: 0.85rem;
    }

    .directory-search .form-control {
        border-color: #dee2e6;
        font-size: 0.85rem;
        min-width: 0;  /* FIX: evita desborde del input dentro del flex */
    }

    .directory-search .form-control:focus {
        border-color: #74c0fc;
        box-shadow: 0 0 0 0.15rem rgba(116, 192, 252, 0.25);
    }

    /* ─── Wrapper del árbol ─────────────────────── */
    .test-directory-wrapper {
        background: #fff;
        overflow: hidden;
        width: 100%;
    }

    /* ─── Header del directorio ─────────────────── */
    .directory-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 13px 16px;
        background: #fff;
        border-bottom: 1px solid #e9ecef;
    }

    .directory-header h5 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #2d3748;
        margin: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .directory-category-badge {
        font-size: 0.72rem;
        font-weight: 600;
        color: #6c757d;
        border: 1px solid #dee2e6;
        border-radius: 20px;
        padding: 3px 10px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        white-space: nowrap;
        margin-left: 8px;
        flex-shrink: 0;
    }

    /* ─── Sección principal (ALERGIAS, etc.) ─────── */
    .test-section-header {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        cursor: pointer;
        user-select: none;
        min-height: 46px;
        width: 100%;
        box-sizing: border-box;
    }

    .test-section-header:first-of-type {
        border-top: none;
    }

    .test-section-header .toggle-icon {
        color: #6c757d;
        font-size: 0.78rem;
        transition: transform 0.2s ease;
        width: 14px;
        flex-shrink: 0;
        margin-right: 8px;
    }

    .test-section-header .toggle-icon.collapsed {
        transform: rotate(-90deg);
    }

    .test-section-header h6 {
        margin: 0;
        font-size: 0.78rem;
        font-weight: 700;
        color: #495057;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        flex: 1;
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* ─── Sub-sección (HEMOGRAMA, etc.) ─────────── */
    .test-subsection-header {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        background: #fff;
        border-top: 1px solid #f1f3f5;
        cursor: pointer;
        user-select: none;
        min-height: 44px;
        width: 100%;
        box-sizing: border-box;
    }

    .test-subsection-header .toggle-icon {
        color: #adb5bd;
        font-size: 0.75rem;
        transition: transform 0.2s ease;
        width: 12px;
        flex-shrink: 0;
        margin-right: 8px;
    }

    .test-subsection-header .toggle-icon.collapsed {
        transform: rotate(-90deg);
    }

    .test-subsection-header h6 {
        margin: 0;
        font-size: 0.75rem;
        font-weight: 600;
        color: #6c757d;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        flex: 1;
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* ─── Grid de tarjetas ───────────────────────── */
    .test-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        padding: 4px 12px 10px;
        background: #fff;
        width: 100%;
        box-sizing: border-box;
        overflow: hidden;
    }

    .test-cards-grid.subsection-grid {
        padding-left: 28px;
    }

    /* ─── Tarjeta individual ─────────────────────── */
    .test-card-item {
        display: flex;
        align-items: flex-start;
        padding: 9px 8px;
        border-radius: 6px;
        transition: background 0.15s ease;
        position: relative;
        min-height: 44px;
        overflow: hidden;
        min-width: 0; /* FIX: flex child no desborda */
    }

    .test-card-item:hover {
        background: #f8f9fa;
    }

    .test-card-drag-handle {
        color: #ced4da;
        font-size: 0.75rem;
        cursor: grab;
        margin-right: 6px;
        margin-top: 2px;
        letter-spacing: -2px;
        line-height: 1;
        flex-shrink: 0;
    }

    .test-card-content {
        flex: 1;
        min-width: 0; /* FIX: crítico para que el texto no desborde en grid */
    }

    .test-card-name {
        font-size: 0.835rem;
        font-weight: 500;
        color: #2d3748;
        margin: 0 0 3px 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.35;
        word-break: break-word; /* FIX: palabras largas no rompen el layout */
    }

    .test-card-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 4px;
    }

    .test-card-price {
        font-size: 0.73rem;
        font-weight: 600;
        color: #20c997;
        white-space: nowrap;
    }

    .test-card-type {
        font-size: 0.67rem;
        font-weight: 500;
        color: #adb5bd;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }

    /* ─── Acciones tarjeta ───────────────────────── */
    .test-card-actions {
        display: none;
        flex-shrink: 0;
        margin-left: 4px;
    }

    @media (hover: hover) and (pointer: fine) {
        .test-card-item:hover .test-card-actions { display: flex; }
    }

    @media (hover: none) {
        .test-card-actions { display: flex; }
    }

    .test-card-actions .btn-action {
        background: none;
        border: none;
        padding: 4px 5px;
        font-size: 0.78rem;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.15s;
        min-width: 30px;
        min-height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .test-card-actions .btn-action.edit   { color: #4dabf7; }
    .test-card-actions .btn-action.edit:hover  { background: #e7f5ff; }
    .test-card-actions .btn-action.delete { color: #ff8787; }
    .test-card-actions .btn-action.delete:hover { background: #fff5f5; }

    /* ─── Acciones de grupo (header) ─────────────── */
    .group-header-actions {
        display: none;
        flex-shrink: 0;
        margin-left: auto;
        padding-left: 6px;
    }

    @media (hover: hover) and (pointer: fine) {
        .test-section-header:hover .group-header-actions,
        .test-subsection-header:hover .group-header-actions { display: flex; }
    }

    @media (hover: none) {
        .group-header-actions { display: flex; }
    }

    .group-header-actions .btn-action {
        background: none;
        border: none;
        padding: 4px 6px;
        font-size: 0.78rem;
        border-radius: 4px;
        cursor: pointer;
        min-width: 30px;
        min-height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .group-header-actions .btn-action.edit   { color: #74c0fc; }
    .group-header-actions .btn-action.edit:hover  { background: #e7f5ff; }
    .group-header-actions .btn-action.delete { color: #ffa8a8; }
    .group-header-actions .btn-action.delete:hover { background: #fff5f5; }

    /* ─── Highlight búsqueda ─────────────────────── */
    .search-highlight .test-card-name {
        background: #fff3bf;
        border-radius: 3px;
        padding: 0 2px;
    }

    /* ─── Loading ────────────────────────────────── */
    .tree-loading {
        text-align: center;
        padding: 40px;
        color: #adb5bd;
    }

    /* =============================================
       RESPONSIVE
       ============================================= */

    /* Tablet ≤ 991px : 2 columnas */
    @media (max-width: 991px) {
        .test-cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Móvil ≤ 767px : 1 columna */
    @media (max-width: 767px) {

        .toolbar-wrapper {
            padding: 10px 12px;
        }

        /* Toolbar en columna: botones arriba, buscador abajo */
        .toolbar-top-row {
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
        }

        .toolbar-buttons {
            width: 100%;
        }

        .toolbar-buttons .btn {
            flex: 1;
            justify-content: center;
        }

        .directory-search {
            width: 100%;
            flex: none;
        }

        /* Grid: 1 columna */
        .test-cards-grid {
            grid-template-columns: 1fr;
            padding: 4px 10px 8px;
        }

        .test-cards-grid.subsection-grid {
            padding-left: 14px;
        }

        .test-section-header  { padding: 11px 12px; }
        .test-subsection-header { padding: 10px 14px; }

        /* Ocultar drag handle en touch */
        .test-card-drag-handle { display: none; }

        /* Área táctil más grande */
        .test-card-item {
            padding: 10px 6px;
            min-height: 48px;
        }

        .test-card-name {
            -webkit-line-clamp: 3;
            font-size: 0.85rem;
        }

        .directory-header { padding: 11px 12px; }
        .directory-header h5 { font-size: 0.88rem; }

        .test-card-actions .btn-action,
        .group-header-actions .btn-action {
            min-width: 36px;
            min-height: 36px;
            font-size: 0.85rem;
        }
    }

    /* Móvil pequeño ≤ 400px */
    @media (max-width: 400px) {

        .toolbar-wrapper { padding: 8px 10px; }

        .btn-label-full  { display: none; }
        .btn-label-short { display: inline; }

        .test-section-header h6,
        .test-subsection-header h6 {
            font-size: 0.72rem;
            letter-spacing: 0.4px;
        }

        .test-cards-grid { padding: 4px 6px 6px; }
        .test-cards-grid.subsection-grid { padding-left: 10px; }

        .test-card-name  { font-size: 0.82rem; }
        .directory-header h5 { font-size: 0.82rem; }
    }

    @media (min-width: 401px) {
        .btn-label-short { display: none; }
    }
</style>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Directorio de Análisis</li>
    </ol>
</nav>

<div class="directory-card">

    {{-- ─── Toolbar ─────────────────────────────────── --}}
    <div class="toolbar-wrapper">
        <div class="toolbar-top-row">

            <div class="toolbar-buttons">
                <button type="button"
                        class="btn btn-secondary"
                        onclick="openModalCreateGroupTest();">
                    <i class="fas fa-vials"></i>
                    <span class="btn-label-full ml-1">Crear grupo</span>
                    <span class="btn-label-short ml-1">Grupo</span>
                </button>
                <button type="button"
                        class="btn btn-secondary"
                        onclick="openModalCreateTest();">
                    <i class="fas fa-vial"></i>
                    <span class="btn-label-full ml-1">Crear Prueba</span>
                    <span class="btn-label-short ml-1">Prueba</span>
                </button>
            </div>

            <div class="directory-search">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                    <input type="text"
                           class="form-control"
                           id="searchAtestInput"
                           placeholder="Buscar análisis..."
                           autocomplete="off"
                           oninput="searchAtest(this);">
                    <div class="input-group-append" id="searchClearBtn" style="display:none;">
                        <button class="btn btn-outline-secondary" type="button"
                                onclick="clearSearch();" title="Limpiar">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ─── Directorio ──────────────────────────────── --}}
    <div class="test-directory-wrapper">

        <div class="directory-header border-bottom">
            <h5 class="mb-0">Directorio de Análisis</h5>
            <span class="directory-category-badge" id="categoryCount">— Categorías</span>
        </div>

        <div id="tree_group_container">
            <div class="tree-loading">
                <i class="fas fa-cog fa-spin fa-2x mb-2 d-block"></i>
                <div class="small text-muted">Cargando directorio...</div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('pageModals')
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

    function loadTreeTestGroup() {
        $("#tree_group_container").html(renderLoading());
        $.ajax({
            url: "{{ route('analysis-test-group.render.tree') }}",
            success: function (data) {
                $("#tree_group_container").empty().append(data);
                updateCategoryCount();
            }
        });
    }

    function updateCategoryCount() {
        var count = $(".test-section-header").length;
        $("#categoryCount").text(count + (count === 1 ? " Categoría" : " Categorías"));
    }

    function renderLoading() {
        return '<div class="tree-loading">'
             + '<i class="fas fa-cog fa-spin fa-2x mb-2 d-block"></i>'
             + '<div class="small text-muted">Cargando directorio...</div>'
             + '</div>';
    }

    function addTestTypeRange() {
        $.ajax({ url: "{{ route('analysis-test.render-range-option') }}",
            success: function (data) { $("#rangeListOptions").append(data); }
        });
    }

    function addTestTypeRangeNoOrder() {
        $.ajax({ url: "{{ route('analysis-test.render-range-no-order-option') }}",
            success: function (data) { $("#rangeNoOrderListOptions").append(data); }
        });
    }

    function addTestTypeLimit() {
        $.ajax({ url: "{{ route('analysis-test.render-limit-option') }}",
            success: function (data) { $("#rangeListOptions").append(data); }
        });
    }

    function addTestTypeGeneric() {
        $.ajax({ url: "{{ route('analysis-test.render-generic-option') }}",
            success: function (data) { $("#genericListOptions").append(data); }
        });
    }

    function removeTestTypeRange(button)    { $(button).parent().parent().parent().parent().remove(); }
    function removeTestTypeLimit(button)    { $(button).parent().parent().parent().remove(); }
    function removeTestTypeGeneric(button)  { $(button).parent().parent().parent().remove(); }

    function addRangeIntermediary(link, tempId) {
        var intermediary = $(link).prev();
        $.ajax({
            url: "{{ route('analysis-test.render-range-option-intermediary') }}",
            data: { tempId: tempId, count: $(intermediary).children().length },
            success: function (data) { $(intermediary).append(data); }
        });
    }

    function removeRangeIntermediary(link) { $(link).parents().eq(3).remove(); }

    function clearSearch() {
        $("#searchAtestInput").val('');
        $("#searchClearBtn").hide();
        $(".test-card-item").removeClass("search-highlight");
        $(".test-section-body, .test-subsection-body").show();
        $(".test-section-header .toggle-icon, .test-subsection-header .toggle-icon")
            .removeClass("collapsed");
    }

    function searchAtest(input) {
        var strSearch = $(input).val().toLowerCase().trim();

        $("#searchClearBtn").toggle(strSearch.length > 0);
        $(".test-card-item").removeClass("search-highlight");

        if (strSearch.length < 2) {
            $(".test-section-body, .test-subsection-body").show();
            $(".test-section-header .toggle-icon, .test-subsection-header .toggle-icon")
                .removeClass("collapsed");
            return;
        }

        $(".test-section-body").hide();
        $(".test-subsection-body").hide();

        $(".test-card-item").each(function () {
            var name = $(this).find(".test-card-name").text().toLowerCase().trim();
            if (name.indexOf(strSearch) !== -1) {
                $(this).addClass("search-highlight");
                var sectionBody    = $(this).closest(".test-section-body");
                var subsectionBody = $(this).closest(".test-subsection-body");
                sectionBody.show();
                subsectionBody.show();
                sectionBody.prev(".test-section-header").find(".toggle-icon").removeClass("collapsed");
                subsectionBody.prev(".test-subsection-header").find(".toggle-icon").removeClass("collapsed");
            }
        });
    }
</script>
@endpush