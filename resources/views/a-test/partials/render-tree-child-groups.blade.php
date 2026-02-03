<div class="accordion accordion-tree" id="accordionTestGroup">
@foreach($childs as $child)
    <div class="card">
        <div class="card-header" id="heading{{ $child->id }}">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $child->id }}" aria-expanded="true" aria-controls="collapse{{ $child->id }}">
                    @for($i=0; $i<$level; $i++)
                        &nbsp;&nbsp;<b>-</b>&nbsp;
                    @endfor
                        {{ $child->name }}
                        <button class="btn btn-link text-danger p-1 float-right " onclick="openModalAnalysisTestGroupDelete({{$child->id}});"><i class="fas fa-trash-alt"></i></button>
                        <button class="btn btn-link text-primary p-1 float-right" onclick="openModalEditGroupTest({{$child->id}})"><i class="far fa-edit"></i></button>
                </button>
            </h2>
        </div>
        <div id="collapse{{ $child->id }}" class="collapse" aria-labelledby="heading{{ $child->id }}" data-parent="#accordionTestGroup">
            <div class="card-body">
                @foreach($child->analysisTests as $analysisTests)
                    <p class="mb-0">
                        <button class="btn btn-link text-primary p-1" onclick="openModalAnalysisTest({{$analysisTests->id}});"><i class="far fa-edit"></i></button>
                        <button class="btn btn-link text-danger p-1" onclick="openModalAnalysisTestDelete({{$analysisTests->id}});"><i class="fas fa-trash-alt"></i></button>
                        {{$analysisTests->name}} <small>({{$analysisTests->price }} Bs. - {{$analysisTests->type}})</small>
                    </p>
                @endforeach
            </div>
        </div>
    </div>
    @if(count($child->children))
        @include('a-test.partials.render-tree-child-groups',['level' => $level + 1, 'childs' => $child->children, 'group_id' => (isset($group_id))? $group_id: null])
    @endif
@endforeach
</div>
