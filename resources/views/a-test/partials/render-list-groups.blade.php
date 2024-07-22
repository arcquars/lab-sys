@foreach($groups as $group)
    <div class="col-md-3">
        <div class="card">
            <div class="card-header card-header-clinica card-header-azure badge-azure">
                <h5 class="mb-0">{{ $group->name }}</h5>
            </div>
            <div class="card-body">
                @foreach($group->analysisTests as $analysisTests)
                    <p class="mb-0">
                        <button class="btn btn-link text-primary" onclick="openModalAnalysisTest({{$analysisTests->id}});"><i class="far fa-edit"></i></button>
                        {{$analysisTests->name}} <small>({{$analysisTests->price }} Bs. - {{$analysisTests->type}})</small>
                    </p>
                @endforeach
            </div>
        </div>
    </div>
@endforeach
