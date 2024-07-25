@foreach($groups as $group)
    <div class="col-md-3">
        <div class="card">
            <div class="card-header card-header-clinica card-header-azure badge-azure">
                <h5 class="mb-0">{{ $group->name }}</h5>
            </div>
            <div class="card-body">
                @foreach($group->analysisTests as $analysisTests)
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input test-price" type="checkbox" value="{{ $analysisTests    ->id }}" onchange="updateTotalPriceTest();"
                                   name="aTests[]" data-price="{{$analysisTests->price }}">
                            <span class="form-check-sign"></span>
                            {{$analysisTests->name}} <small>({{$analysisTests->price }} Bs. - {{$analysisTests->type}})</small>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endforeach
