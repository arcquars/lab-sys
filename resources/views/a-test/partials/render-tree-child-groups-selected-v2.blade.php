@foreach($childs as $child)
<div
    class="lab-subgroup-block"
    id="labSubgroup-{{ $child->id }}"
    data-group-id="{{ $child->id }}"
>
    {{-- Header del sub-grupo --}}
    <div class="lab-subgroup-header" onclick="labToggleSubgroup({{ $child->id }});">

        {{-- Checkbox del sub-grupo (si tiene precio) --}}
        @if($child->price)
        <input
            class="lab-group-check test-price"
            type="checkbox"
            value="{{ $child->id }}"
            name="aGroup[]"
            data-price="{{ $child->price }}"
            onclick="event.stopPropagation(); reloadGroupChilds(this);"
            @if(isset($aTestGroupIds) && in_array($child->id, $aTestGroupIds)) checked @endif
        >
        @endif

        <span class="lab-subgroup-name">
            @for($i = 0; $i < $level; $i++)
                <span style="opacity:.35;">›</span>
            @endfor
            {{ $child->name }}
        </span>

        @if($child->price)
        <span class="lab-subgroup-price-badge">{{ $child->price }} Bs.</span>
        @endif

        <i class="fas fa-chevron-down lab-subgroup-arrow"></i>
    </div>

    {{-- Cuerpo del sub-grupo --}}
    <div class="lab-subgroup-body">
        @if($child->analysisTests->count())
        <div class="lab-tests-grid" style="margin-top:6px;">
            @foreach($child->analysisTests as $test)
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

        {{-- Recursión para nietos --}}
        @if(count($child->children))
            @include('a-test.partials.render-tree-child-groups-selected-v2', [
                'level'         => $level + 1,
                'childs'        => $child->children,
                'group_id'      => isset($group_id) ? $group_id : null,
                'aTestGroupIds' => isset($aTestGroupIds) ? $aTestGroupIds : [],
                'aTestIds'      => isset($aTestIds) ? $aTestIds : [],
            ])
        @endif
    </div>
</div>
@endforeach
