@foreach($groups as $group)
    <div class="col-md-3">
        <div class="card">
            <div class="card-header card-header-clinica card-header-azure badge-azure">
                <h5 class="mb-0">
                    {{ $group->name }}
                    <button class="btn btn-link text-danger p-1 float-right " onclick="openModalAnalysisTestGroupDelete({{$group->id}});"><i class="fas fa-trash-alt"></i></button>
                    <button class="btn btn-link text-primary p-1 float-right" onclick="openModalEditGroupTest({{$group->id}})"><i class="far fa-edit"></i></button>
                </h5>
            </div>
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
@endforeach
