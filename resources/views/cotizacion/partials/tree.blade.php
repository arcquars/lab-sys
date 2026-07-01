@foreach($groups as $group)
    @php
        $groupTests = $group->analysisTests;
        $allZero = $groupTests->count() > 0 && $groupTests->every(function ($t) { return (float) $t->price == 0.0; });
    @endphp
    <div class="cotiz-group-block" data-group-id="{{ $group->id }}" data-group-name="{{ strtolower($group->name) }}"
         data-all-zero="{{ $allZero ? 1 : 0 }}" data-group-price="{{ $group->price ?? 0 }}">
        <div class="cotiz-group-header" onclick="cotizToggleGroup(this);">
            @if($group->price)
                <input class="cotiz-check cotiz-group-check" type="checkbox" name="aGroup[]" value="{{ $group->id }}"
                       data-price="{{ $group->price }}" onclick="event.stopPropagation(); cotizToggleGroupChilds(this);"
                       @if(in_array($group->id, old('aGroup', []))) checked @endif>
            @endif
            <span class="cotiz-group-name">{{ $group->name }}</span>
            @if($group->price)
                <span class="cotiz-price-badge">{{ $group->price }} Bs.</span>
            @endif
            <span class="cotiz-count-badge">{{ $groupTests->count() }} análisis</span>
            <i class="fas fa-chevron-down cotiz-arrow"></i>
        </div>
        <div class="cotiz-group-body">
            @if($groupTests->count())
                <div class="cotiz-tests-grid">
                    @foreach($groupTests as $test)
                        <label class="cotiz-test-card" data-test-name="{{ strtolower($test->name) }}">
                            <input class="cotiz-check cotiz-test-check" type="checkbox" name="aTests[]" value="{{ $test->id }}"
                                   data-price="{{ $test->price }}" onchange="cotizOnTestToggle(this);"
                                   @if(in_array($test->id, old('aTests', []))) checked @endif>
                            <div class="cotiz-test-info">
                                <div class="cotiz-test-name">{{ $test->name }}</div>
                                <div class="cotiz-test-meta">
                                    @if($test->price)
                                        <span class="cotiz-test-price">{{ $test->price }} Bs.</span>
                                    @else
                                        <span class="cotiz-test-price cotiz-muted">A consultar</span>
                                    @endif
                                    <span class="cotiz-test-type">{{ $test->type }}</span>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            @endif

            @if(count($group->children) > 0)
                @include('cotizacion.partials.tree-child', ['level' => 1, 'childs' => $group->children])
            @endif
        </div>
    </div>
@endforeach
