<div class="accordion accordion-tree" id="accordionTestGroup">
@foreach($groups as $key => $group)
    <div class="card">
        <div class="card-header" id="heading{{ $group->id }}">
            @if($group->price)
            <h2 class="mb-0">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input test-price" type="checkbox" value="{{ $group->id }}" onchange="reloadGroupChilds(this);"
                               name="aGroup[]" data-price="{{$group->price }}"
                        >
                        <span class="form-check-sign icheck-black"></span>
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $group->id }}" aria-expanded="true" aria-controls="collapse{{ $group->id }}">
                            {{ $group->name }} - {{$group->price}} Bs.
                        </button>
                    </label>
                </div>
            </h2>
            @else
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $group->id }}" aria-expanded="true" aria-controls="collapse{{ $group->id }}">
                    {{ $group->name }}
                </button>
            </h2>
            @endif
        </div>
        <div id="collapse{{ $group->id }}" class="collapse @if($key == 0) show @endif" aria-labelledby="heading{{ $group->id }}" data-parent="#accordionTestGroup">
            <div class="card-body">
                @foreach($group->analysisTests as $analysisTests)
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input test-price" type="checkbox" value="{{ $analysisTests->id }}" onchange="updateTotalPriceTest();"
                                   name="aTests[]" data-price="{{$analysisTests->price }}"
                                   @if(isset($aTestIds) && in_array($analysisTests->id, $aTestIds)) checked @endif
                            >
                            <span class="form-check-sign icheck-black"></span>
                            <span class="text-dark h5">{{$analysisTests->name}} <small>({{$analysisTests->price }} Bs. - {{$analysisTests->type}})</small></span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if(count($group->children))
        @include('a-test.partials.render-tree-child-groups-selected',['level' => 1, 'childs' => $group->children, 'group_id' => (isset($group_id))? $group_id: null])
    @endif
@endforeach
</div>
