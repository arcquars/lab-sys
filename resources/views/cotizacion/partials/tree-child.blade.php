@foreach($childs as $child)
    @php
        $childTests = $child->analysisTests;
        $allZero = $childTests->count() > 0 && $childTests->every(function ($t) { return (float) $t->price == 0.0; });
    @endphp
    <div class="cotiz-subgroup-block" data-group-id="{{ $child->id }}" data-group-name="{{ strtolower($child->name) }}"
         data-all-zero="{{ $allZero ? 1 : 0 }}" data-group-price="{{ $child->price ?? 0 }}">
        <div class="cotiz-subgroup-header" onclick="cotizToggleGroup(this);">
            @if($child->price)
                <input class="cotiz-check cotiz-group-check" type="checkbox" name="aGroup[]" value="{{ $child->id }}"
                       data-price="{{ $child->price }}" onclick="event.stopPropagation(); cotizToggleGroupChilds(this);"
                       @if(in_array($child->id, old('aGroup', []))) checked @endif>
            @endif
            <span class="cotiz-subgroup-name">
                @for($i = 0; $i < $level; $i++)<span class="cotiz-indent">&rsaquo;</span>@endfor
                {{ $child->name }}
            </span>
            @if($child->price)
                <span class="cotiz-price-badge">{{ $child->price }} Bs.</span>
            @endif
            <i class="fas fa-chevron-down cotiz-arrow"></i>
        </div>
        <div class="cotiz-group-body">
            @if($childTests->count())
                <div class="cotiz-tests-grid">
                    @foreach($childTests as $test)
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

            @if(count($child->children) > 0)
                @include('cotizacion.partials.tree-child', ['level' => $level + 1, 'childs' => $child->children])
            @endif
        </div>
    </div>
@endforeach
