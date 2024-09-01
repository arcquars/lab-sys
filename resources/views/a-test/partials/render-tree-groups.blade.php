<div class="accordion accordion-tree" id="accordionTestGroup">
@foreach($groups as $key => $group)
    <div class="card">
        <div class="card-header" id="heading{{ $group->id }}">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $group->id }}" aria-expanded="true" aria-controls="collapse{{ $group->id }}">
                    {{ $group->name }}
                    <button class="btn btn-link text-danger p-1 float-right " onclick="openModalAnalysisTestGroupDelete({{$group->id}});"><i class="fas fa-trash-alt"></i></button>
                    <button class="btn btn-link text-primary p-1 float-right" onclick="openModalEditGroupTest({{$group->id}})"><i class="far fa-edit"></i></button>
                </button>
            </h2>
        </div>
        <div id="collapse{{ $group->id }}" class="collapse @if($key == 0) show @endif" aria-labelledby="heading{{ $group->id }}" data-parent="#accordionTestGroup">
            <div class="card-body">
                @foreach($group->analysisTests as $analysisTests)
                    <p class="mb-0">
                        <button class="btn btn-link text-primary p-1" onclick="openModalAnalysisTest({{$analysisTests->id}});"><i class="far fa-edit"></i></button>
                        <button class="btn btn-link text-danger p-1" onclick="openModalAnalysisTestDelete({{$analysisTests->id}});"><i class="fas fa-trash-alt"></i></button>
                        {{$analysisTests->name}} <small>({{$analysisTests->price }} Bs. - {{$analysisTests->type}})</small>
                    </p>
                @endforeach
            </div>
        </div>
    </div>

    @if(count($group->children))
        @include('a-test.partials.render-tree-child-groups',['level' => 1, 'childs' => $group->children, 'group_id' => (isset($group_id))? $group_id: null])
    @endif
@endforeach
</div>
