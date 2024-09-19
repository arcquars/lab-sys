<div class="accordion accordion-tree" id="accordionTestGroup">
@foreach($childs as $child)
    <div class="card">
        <div class="card-header" id="heading{{ $child->id }}">



            @if($child->price)
                <h2 class="mb-0">
                    <div class="form-check">
                            <label class="form-check-label">
                            <input class="form-check-input test-price" type="checkbox" value="{{ $child->id }}" onchange="reloadGroupChilds(this);"
                                   name="aGroup[]" data-price="{{$child->price }}"
                            >
                            <span class="form-check-sign"></span>
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $child->id }}" aria-expanded="true" aria-controls="collapse{{ $child->id }}">
                                @for($i=0; $i<$level; $i++)
                                    -
                                @endfor
                                {{ $child->name }}
                            </button>
                        </label>
                    </div>
                </h2>
            @else
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $child->id }}" aria-expanded="true" aria-controls="collapse{{ $child->id }}">
                        @for($i=0; $i<$level; $i++)
                            -
                        @endfor
                        {{ $child->name }}
                    </button>
                </h2>
            @endif




        </div>
        <div id="collapse{{ $child->id }}" class="collapse" aria-labelledby="heading{{ $child->id }}" data-parent="#accordionTestGroup">
            <div class="card-body">
                @foreach($child->analysisTests as $analysisTests)
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input test-price" type="checkbox" value="{{ $analysisTests->id }}" onchange="updateTotalPriceTest();"
                                   name="aTests[]" data-price="{{$analysisTests->price }}"
                                   @if(isset($aTestIds) && in_array($analysisTests->id, $aTestIds)) checked @endif
                            >
                            <span class="form-check-sign"></span>
                            {{$analysisTests->name}} <small>({{$analysisTests->price }} Bs. - {{$analysisTests->type}})</small>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if(count($child->children))
        @include('a-test.partials.render-tree-child-groups-selected',['level' => $level + 1, 'childs' => $child->children, 'group_id' => (isset($group_id))? $group_id: null])
    @endif
@endforeach
</div>
