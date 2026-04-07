<style>
/* ============================================================
   LAB-PDM · Selector de Análisis v2
   Bootstrap 4.6 + jQuery compatible
   ============================================================ */
:root {
    --lab-primary:    #2563eb;
    --lab-primary-lt: #dbeafe;
    --lab-success:    #16a34a;
    --lab-success-lt: #dcfce7;
    --lab-border:     #e2e8f0;
    --lab-muted:      #64748b;
    --lab-bg:         #f8fafc;
    --lab-white:      #ffffff;
    --lab-text:       #1e293b;
    --lab-price:      #0369a1;
    --lab-badge-bg:   #0ea5e9;
    --lab-hover:      #f1f5f9;
    --lab-checked-bg: #eff6ff;
    --lab-checked-border: #93c5fd;
    --lab-radius:     10px;
    --lab-radius-sm:  6px;
    --lab-shadow:     0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.04);
    --lab-shadow-md:  0 4px 6px rgba(0,0,0,.07), 0 2px 4px rgba(0,0,0,.05);
}

/* ---------- Buscador principal ---------- */
.lab-search-wrap {
    position: relative;
    margin-bottom: 14px;
}
.lab-search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--lab-muted);
    font-size: 14px;
    pointer-events: none;
}
.lab-search-input {
    width: 100%;
    padding: 10px 38px 10px 36px;
    border: 1.5px solid var(--lab-border);
    border-radius: var(--lab-radius);
    font-size: 14px;
    color: var(--lab-text);
    background: var(--lab-white);
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    box-shadow: var(--lab-shadow);
}
.lab-search-input:focus {
    border-color: var(--lab-primary);
    box-shadow: 0 0 0 3px rgba(37,99,235,.12);
}
.lab-search-clear {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: var(--lab-muted);
    font-size: 13px;
    display: none;
    background: none;
    border: none;
    padding: 2px 5px;
    border-radius: 4px;
    line-height: 1;
}
.lab-search-clear:hover { background: var(--lab-border); }
.lab-search-hint {
    font-size: 11px;
    color: var(--lab-muted);
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
}

/* ---------- Frecuentes ---------- */
.lab-frequent-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .6px;
    color: var(--lab-muted);
    margin-right: 6px;
}
.lab-frequent-wrap {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 6px;
    margin-bottom: 14px;
}
.lab-frequent-btn {
    padding: 3px 10px;
    border-radius: 20px;
    border: 1.5px solid var(--lab-border);
    background: var(--lab-white);
    font-size: 12px;
    color: var(--lab-text);
    cursor: pointer;
    transition: border-color .15s, background .15s, color .15s;
    white-space: nowrap;
}
.lab-frequent-btn:hover {
    border-color: var(--lab-primary);
    background: var(--lab-primary-lt);
    color: var(--lab-primary);
}

/* ---------- Tab categorías ---------- */
.lab-tabs-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    margin-bottom: 16px;
    border-bottom: 2px solid var(--lab-border);
    padding-bottom: 0;
}
.lab-tab-btn {
    padding: 6px 14px;
    border: none;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    background: transparent;
    font-size: 13px;
    font-weight: 500;
    color: var(--lab-muted);
    cursor: pointer;
    transition: color .15s, border-color .15s;
    display: flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
}
.lab-tab-btn .lab-tab-icon { font-size: 14px; }
.lab-tab-btn .lab-tab-count {
    font-size: 11px;
    background: var(--lab-border);
    color: var(--lab-muted);
    border-radius: 10px;
    padding: 1px 6px;
    font-weight: 600;
}
.lab-tab-btn:hover { color: var(--lab-primary); }
.lab-tab-btn.active {
    color: var(--lab-primary);
    border-bottom-color: var(--lab-primary);
}
.lab-tab-btn.active .lab-tab-count {
    background: var(--lab-primary-lt);
    color: var(--lab-primary);
}

/* ---------- Panel de grupos ---------- */
.lab-groups-panel { }
.lab-group-block {
    background: var(--lab-white);
    border: 1.5px solid var(--lab-border);
    border-radius: var(--lab-radius);
    margin-bottom: 10px;
    box-shadow: var(--lab-shadow);
    overflow: hidden;
    transition: box-shadow .15s;
}
.lab-group-block:hover { box-shadow: var(--lab-shadow-md); }

/* Header del grupo */
.lab-group-header {
    display: flex;
    align-items: center;
    padding: 10px 14px;
    cursor: pointer;
    user-select: none;
    gap: 10px;
    background: var(--lab-bg);
    border-bottom: 1px solid transparent;
    transition: background .15s;
}
.lab-group-header:hover { background: #f0f4ff; }
.lab-group-block.open > .lab-group-header {
    border-bottom-color: var(--lab-border);
    background: var(--lab-primary-lt);
}

/* Checkbox del grupo */
.lab-group-check {
    flex-shrink: 0;
    width: 18px; height: 18px;
    accent-color: var(--lab-primary);
    cursor: pointer;
}

/* Nombre + precio del grupo */
.lab-group-name {
    flex: 1;
    font-size: 13px;
    font-weight: 700;
    color: var(--lab-text);
    text-transform: uppercase;
    letter-spacing: .4px;
}
.lab-group-price-badge {
    font-size: 11px;
    background: var(--lab-badge-bg);
    color: #fff;
    border-radius: 12px;
    padding: 2px 9px;
    font-weight: 600;
    white-space: nowrap;
}

/* Cantidad de tests */
.lab-group-tests-count {
    font-size: 11px;
    color: var(--lab-muted);
    white-space: nowrap;
}

/* Flecha toggle */
.lab-group-arrow {
    font-size: 11px;
    color: var(--lab-muted);
    transition: transform .2s;
    margin-left: 4px;
}
.lab-group-block.open > .lab-group-header .lab-group-arrow {
    transform: rotate(180deg);
}

/* Cuerpo del grupo */
.lab-group-body {
    display: none;
    padding: 12px 14px;
}
.lab-group-block.open > .lab-group-body {
    display: block;
}

/* Hint seleccionar todo */
.lab-group-hint {
    font-size: 11px;
    color: var(--lab-muted);
    margin-bottom: 8px;
}

/* Grid de tests */
.lab-tests-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
    gap: 8px;
}

/* Tarjeta de test individual */
.lab-test-card {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    padding: 9px 11px;
    border: 1.5px solid var(--lab-border);
    border-radius: var(--lab-radius-sm);
    cursor: pointer;
    background: var(--lab-white);
    transition: border-color .15s, background .15s;
}
.lab-test-card:hover {
    border-color: var(--lab-primary);
    background: var(--lab-hover);
}
.lab-test-card.checked {
    border-color: var(--lab-checked-border);
    background: var(--lab-checked-bg);
}
.lab-test-card.disabled {
    opacity: .45;
    pointer-events: none;
}

.lab-test-check {
    flex-shrink: 0;
    width: 16px; height: 16px;
    margin-top: 2px;
    accent-color: var(--lab-primary);
    cursor: pointer;
}
.lab-test-info { flex: 1; min-width: 0; }
.lab-test-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--lab-text);
    line-height: 1.3;
    white-space: normal;
    word-break: break-word;
}
.lab-test-meta {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 3px;
    flex-wrap: wrap;
}
.lab-test-price {
    font-size: 11px;
    font-weight: 700;
    color: var(--lab-price);
}
.lab-test-type {
    font-size: 10px;
    background: #f1f5f9;
    color: var(--lab-muted);
    border-radius: 4px;
    padding: 1px 6px;
}
.lab-test-type.tipo-linea { background: #fef3c7; color: #92400e; }
.lab-test-type.tipo-rango { background: #dcfce7; color: #166534; }
.lab-test-type.tipo-limite { background: #fce7f3; color: #9d174d; }

/* ---------- Sub-grupos (hijos) ---------- */
.lab-subgroup-block {
    margin-top: 10px;
    border-left: 3px solid var(--lab-primary-lt);
    padding-left: 10px;
}
.lab-subgroup-header {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 7px 10px;
    background: #f8fafc;
    border-radius: var(--lab-radius-sm);
    cursor: pointer;
    margin-bottom: 6px;
    border: 1px solid var(--lab-border);
}
.lab-subgroup-name {
    flex: 1;
    font-size: 12px;
    font-weight: 700;
    color: var(--lab-text);
    text-transform: uppercase;
    letter-spacing: .3px;
}
.lab-subgroup-price-badge {
    font-size: 10px;
    background: #7c3aed;
    color: #fff;
    border-radius: 10px;
    padding: 1px 7px;
}
.lab-subgroup-arrow {
    font-size: 10px;
    color: var(--lab-muted);
    transition: transform .2s;
}
.lab-subgroup-block.open > .lab-subgroup-header .lab-subgroup-arrow {
    transform: rotate(180deg);
}
.lab-subgroup-body { display: none; }
.lab-subgroup-block.open > .lab-subgroup-body { display: block; }

/* ---------- Estado vacío ---------- */
.lab-empty-state {
    text-align: center;
    padding: 40px 20px;
    color: var(--lab-muted);
}
.lab-empty-state i { font-size: 36px; margin-bottom: 10px; }
.lab-empty-state p { font-size: 14px; }

/* ---------- No-results de búsqueda ---------- */
.lab-no-results {
    display: none;
    text-align: center;
    padding: 30px;
    color: var(--lab-muted);
    font-size: 14px;
}

/* ---------- Highlight de búsqueda ---------- */
mark.lab-hl {
    background: #fef08a;
    color: inherit;
    border-radius: 2px;
    padding: 0 1px;
}

/* ---------- Resumen flotante (ya existe en la vista padre, pero lo reforzamos) ---------- */
</style>

{{-- =====================================================================
     BÚSQUEDA GLOBAL
     ===================================================================== --}}
<div class="lab-search-wrap">
    <i class="fas fa-search lab-search-icon"></i>
    <input
        type="text"
        id="labSearchInput"
        class="lab-search-input"
        placeholder="Ej: VDRL, RPR, TSH, hemograma, glucosa..."
        autocomplete="off"
    >
    <button class="lab-search-clear" id="labSearchClear" title="Limpiar búsqueda">
        <i class="fas fa-times"></i>
    </button>
    <span class="lab-search-hint d-none d-md-block">Ctrl+F</span>
</div>

{{-- =====================================================================
     ANÁLISIS FRECUENTES
     ===================================================================== --}}
@php
    /* Listamos los primeros 10 tests con precio mayor a 0 como "frecuentes" */
    $frecuentes = collect();
    foreach($groups as $g) {
        foreach($g->analysisTests as $t) {
            if($t->price > 0 && $frecuentes->count() < 10) {
                $frecuentes->push($t);
            }
        }
        if($frecuentes->count() >= 10) break;
    }
@endphp
@if($frecuentes->count())
<div class="lab-frequent-wrap">
    <span class="lab-frequent-label">Frecuentes:</span>
    @foreach($frecuentes as $ft)
        <button
            type="button"
            class="lab-frequent-btn"
            data-test-name="{{ $ft->name }}"
            onclick="labQuickFilter('{{ addslashes($ft->name) }}');"
        >{{ $ft->name }}</button>
    @endforeach
</div>
@endif

{{-- =====================================================================
     TABS POR CATEGORÍA (cada grupo raíz es una pestaña)
     ===================================================================== --}}
<div class="lab-tabs-wrap" id="labTabsWrap">
    <button type="button" class="lab-tab-btn active" data-target="all">
        <span class="lab-tab-icon">🔬</span> Todos
        <span class="lab-tab-count" id="labCountAll">
            {{ $groups->sum(fn($g) => $g->analysisTests->count()) }}
        </span>
    </button>
    @foreach($groups as $group)
        @php
            $testCount = $group->analysisTests->count();
            $groupIcon = '🧪';
            $nameLower = strtolower($group->name);
            if(str_contains($nameLower,'hemato') || str_contains($nameLower,'hemo') || str_contains($nameLower,'sangre')) $groupIcon = '🩸';
            elseif(str_contains($nameLower,'micro') || str_contains($nameLower,'bacteria') || str_contains($nameLower,'cultivo')) $groupIcon = '🦠';
            elseif(str_contains($nameLower,'hormon') || str_contains($nameLower,'tsh') || str_contains($nameLower,'tiro')) $groupIcon = '⚗️';
            elseif(str_contains($nameLower,'inmuno') || str_contains($nameLower,'serolog')) $groupIcon = '🛡️';
            elseif(str_contains($nameLower,'quim') || str_contains($nameLower,'glucos') || str_contains($nameLower,'lipid')) $groupIcon = '🔭';
            elseif(str_contains($nameLower,'parasi') || str_contains($nameLower,'copro')) $groupIcon = '🔬';
            elseif(str_contains($nameLower,'perfil')) $groupIcon = '📊';
        @endphp
        <button
            type="button"
            class="lab-tab-btn"
            data-target="group-{{ $group->id }}"
        >
            <span class="lab-tab-icon">{{ $groupIcon }}</span>
            {{ $group->name }}
            <span class="lab-tab-count">{{ $testCount }}</span>
        </button>
    @endforeach
</div>

{{-- =====================================================================
     PANEL PRINCIPAL DE GRUPOS
     ===================================================================== --}}
<div id="labGroupsPanel" class="lab-groups-panel">
    @forelse($groups as $group)
    <div
        class="lab-group-block"
        id="labGroup-{{ $group->id }}"
        data-group-id="{{ $group->id }}"
        data-tab="group-{{ $group->id }}"
    >
        {{-- Header del grupo --}}
        <div class="lab-group-header" onclick="labToggleGroup({{ $group->id }});">
            {{-- Checkbox del grupo (precio completo) --}}
            @if($group->price)
            <input
                class="lab-group-check test-price"
                type="checkbox"
                value="{{ $group->id }}"
                name="aGroup[]"
                data-price="{{ $group->price }}"
                onclick="event.stopPropagation(); reloadGroupChilds(this);"
                @if(isset($aTestGroupIds) && in_array($group->id, $aTestGroupIds)) checked @endif
            >
            @endif

            <span class="lab-group-name">{{ $group->name }}</span>

            @if($group->price)
            <span class="lab-group-price-badge">{{ $group->price }} Bs.</span>
            @endif

            @php $totalTests = $group->analysisTests->count(); @endphp
            @if($totalTests > 0)
            <span class="lab-group-tests-count">{{ $totalTests }} análisis</span>
            @endif

            <i class="fas fa-chevron-down lab-group-arrow"></i>
        </div>

        {{-- Cuerpo del grupo --}}
        <div class="lab-group-body">
            @if($group->price)
            <p class="lab-group-hint">
                <i class="fas fa-info-circle"></i>
                Haz clic en el checkbox del título para seleccionar o quitar todo el grupo
            </p>
            @endif

            @if($group->analysisTests->count())
            <div class="lab-tests-grid">
                @foreach($group->analysisTests as $test)
                    @php
                        $typeClass = '';
                        $typeLower = strtolower($test->type);
                        if(str_contains($typeLower,'linea') || str_contains($typeLower,'texto')) $typeClass = 'tipo-linea';
                        elseif(str_contains($typeLower,'rango')) $typeClass = 'tipo-rango';
                        elseif(str_contains($typeLower,'limite') || str_contains($typeLower,'límite')) $typeClass = 'tipo-limite';
                        $isChecked = isset($aTestIds) && in_array($test->id, $aTestIds);
                    @endphp
                    <label
                        class="lab-test-card {{ $isChecked ? 'checked' : '' }}"
                        for="labTest-{{ $test->id }}"
                        onclick="labCardClick(this);"
                        data-test-name="{{ strtolower($test->name) }}"
                    >
                        <input
                            class="lab-test-check test-price"
                            type="checkbox"
                            id="labTest-{{ $test->id }}"
                            value="{{ $test->id }}"
                            name="aTests[]"
                            data-price="{{ $test->price }}"
                            onchange="syncCheckboxes(this);"
                            @if($isChecked) checked @endif
                        >
                        <div class="lab-test-info">
                            <div class="lab-test-name lab-test-name-text">{{ $test->name }}</div>
                            <div class="lab-test-meta">
                                @if($test->price)
                                <span class="lab-test-price">{{ $test->price }} Bs.</span>
                                @else
                                <span class="lab-test-price" style="color:var(--lab-muted);">—</span>
                                @endif
                                <span class="lab-test-type {{ $typeClass }}">{{ $test->type }}</span>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
            @endif

            {{-- Sub-grupos hijo --}}
            @if(count($group->children) > 0)
                @include('a-test.partials.render-tree-child-groups-selected-v2', [
                    'level'          => 1,
                    'childs'         => $group->children,
                    'group_id'       => $group->id ?? null,
                    'aTestGroupIds'  => $aTestGroupIds ?? [],
                    'aTestIds'       => $aTestIds ?? [],
                ])
            @endif
        </div>
    </div>
    @empty
    <div class="lab-empty-state">
        <i class="fas fa-flask"></i>
        <p>No hay grupos de análisis disponibles.</p>
    </div>
    @endforelse

    <div class="lab-no-results" id="labNoResults">
        <i class="fas fa-search" style="font-size:28px;margin-bottom:8px;"></i>
        <p>No se encontraron análisis para "<span id="labNoResultsQuery"></span>"</p>
    </div>
</div>

<script>
/* ================================================================
   LAB-PDM — Lógica UX del selector de análisis v2
   Compatible con Bootstrap 4.6 + jQuery (la lógica de
   syncCheckboxes, reloadGroupChilds, updateTotalPriceTest, etc.
   ya existe en crear-hemo.blade.php y se mantiene intacta).
   ================================================================ */
(function () {

    /* ---------- Toggle de grupo ---------- */
    window.labToggleGroup = function (groupId) {
        var $block = $('#labGroup-' + groupId);
        if ($block.hasClass('open')) {
            $block.removeClass('open');
        } else {
            $block.addClass('open');
        }
    };

    /* ---------- Clic en tarjeta (evitar doble disparo) ---------- */
    window.labCardClick = function (label) {
        var $card = $(label);
        var $check = $card.find('.lab-test-check');
        if ($check.prop('disabled')) return;
        // El click en el label ya activa el checkbox; solo actualizamos la clase visual
        // usando un pequeño timeout para leer el estado post-toggle
        setTimeout(function () {
            if ($check.is(':checked')) {
                $card.addClass('checked');
            } else {
                $card.removeClass('checked');
            }
        }, 10);
    };

    /* ---------- Búsqueda en tiempo real ---------- */
    var searchTimer;
    $('#labSearchInput').on('input', function () {
        clearTimeout(searchTimer);
        var val = $(this).val().trim();
        if (val.length > 0) {
            $('#labSearchClear').show();
            $('.lab-search-hint').hide();
        } else {
            $('#labSearchClear').hide();
            $('.lab-search-hint').show();
        }
        searchTimer = setTimeout(function () {
            labFilterTests(val);
        }, 180);
    });

    $('#labSearchClear').on('click', function () {
        $('#labSearchInput').val('').trigger('input').focus();
    });

    /* Atajo Ctrl+F */
    $(document).on('keydown', function (e) {
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            $('#labSearchInput').focus().select();
        }
    });

    function labFilterTests(query) {
        var q = query.toLowerCase().trim();
        var totalVisible = 0;

        /* Restaurar si vacío */
        if (!q) {
            $('.lab-group-block').show();
            $('.lab-test-card').show().find('.lab-test-name-text').each(function () {
                $(this).html($(this).text());
            });
            $('#labNoResults').hide();
            /* Respetar el tab activo */
            applyActiveTab();
            return;
        }

        /* Filtrar por cada grupo */
        $('.lab-group-block').each(function () {
            var $block = $(this);
            var visibleInGroup = 0;
            $block.find('.lab-test-card').each(function () {
                var $card = $(this);
                var name = $card.data('test-name') || '';
                if (name.indexOf(q) !== -1) {
                    $card.show();
                    /* Highlight */
                    var rawName = $card.find('.lab-test-name-text').text();
                    var re = new RegExp('(' + escapeRe(query) + ')', 'gi');
                    $card.find('.lab-test-name-text').html(rawName.replace(re, '<mark class="lab-hl">$1</mark>'));
                    visibleInGroup++;
                } else {
                    $card.hide();
                    $card.find('.lab-test-name-text').html($card.find('.lab-test-name-text').text());
                }
            });

            if (visibleInGroup > 0) {
                $block.show().addClass('open');
                totalVisible += visibleInGroup;
            } else {
                $block.hide();
            }
        });

        if (totalVisible === 0) {
            $('#labNoResults').show();
            $('#labNoResultsQuery').text(query);
        } else {
            $('#labNoResults').hide();
        }
    }

    function escapeRe(s) {
        return s.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    /* ---------- Filtro rápido (frecuentes) ---------- */
    window.labQuickFilter = function (name) {
        $('#labSearchInput').val(name).trigger('input');
    };

    /* ---------- Tabs por categoría ---------- */
    $('#labTabsWrap').on('click', '.lab-tab-btn', function () {
        $('#labTabsWrap .lab-tab-btn').removeClass('active');
        $(this).addClass('active');
        /* Limpiar búsqueda si la hay */
        $('#labSearchInput').val('').trigger('input');
        applyActiveTab();
    });

    function applyActiveTab() {
        var target = $('#labTabsWrap .lab-tab-btn.active').data('target');
        if (target === 'all') {
            $('.lab-group-block').show();
        } else {
            $('.lab-group-block').each(function () {
                if ($(this).data('tab') === target) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    }

    /* ---------- Abrir primer grupo por defecto ---------- */
    $(function () {
        var $first = $('.lab-group-block').first();
        if ($first.length) {
            $first.addClass('open');
        }

        /* Si vienen ítems pre-seleccionados, abrir sus grupos */
        @if(isset($aTestIds) && count($aTestIds))
        $('.lab-test-check:checked').each(function () {
            $(this).closest('.lab-group-block').addClass('open');
            $(this).closest('.lab-subgroup-block').addClass('open');
        });
        @endif

        /* Refrescar visual de tarjetas pre-checkeadas */
        $('.lab-test-check:checked').closest('.lab-test-card').addClass('checked');

        /* Sincronizar grupos pre-checkeados */
        $('.lab-group-check:checked').each(function () {
            reloadGroupChilds(this);
        });
    });

    /* ---------- Toggle sub-grupo ---------- */
    window.labToggleSubgroup = function (id) {
        var $b = $('#labSubgroup-' + id);
        $b.toggleClass('open');
    };

})();
</script>
