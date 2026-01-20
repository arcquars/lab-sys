<div class="accordion accordion-tree" id="accordionTestGroup">
@foreach($childs as $child)
    <div class="card">
        <div class="card-header" id="heading{{ $child->id }}">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $child->id }}" aria-expanded="true" aria-controls="collapse{{ $child->id }}">
                    @for($i=0; $i<$level; $i++)
                        -
                    @endfor
                        {{ $child->name }}
                        <button class="btn btn-danger btn-sm float-right " onclick="openModalAnalysisTestGroupDelete({{$child->id}});">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                        <button class="btn btn-primary btn-sm float-right mr-1" onclick="openModalEditGroupTest({{$child->id}})">
                            <i class="far fa-edit"></i> Editar
                        </button>
                </button>
            </h2>
        </div>
        <div id="collapse{{ $child->id }}" class="collapse" aria-labelledby="heading{{ $child->id }}" data-parent="#accordionTestGroup">
            <div class="card-body">
                @foreach($child->analysisTests as $analysisTests)
                    <p class="mb-0">
                        <button 
                            class="btn btn-primary btn-sm" 
                            data-toggle="tooltip" data-placement="top" title="Editar Prueba"
                            onclick="openModalAnalysisTest({{$analysisTests->id}});">
                            <i class="far fa-edit"></i>
                        </button>
                        <button 
                            class="btn btn-danger btn-sm" 
                            data-toggle="tooltip" data-placement="top" title="Eliminar Prueba"
                            onclick="openModalAnalysisTestDelete({{$analysisTests->id}});">
                            <i class="fas fa-trash-alt"></i>
                        </button>
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
