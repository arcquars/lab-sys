<h5>
    <button type="button" class="btn btn-sm btn-outline-info" onclick="addTestTypeRange();" title="Añadir opcion">
        <i class="fas fa-plus-square"></i>
    </button> Rango
</h5>
<div class="form-group">
    <input type="hidden" id="mtestrange_option" class="form-control" />
    <div class="invalid-feedback">
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="mtestrange.measure">Unidad</label>
        <input type="text" id="mtestrange_measure" name="range[measure]" class="form-control form-control-sm"
               value="{{$analysisTestRange->measure}}" aria-describedby="validationMeasure">
        <div id="validationMeasure" class="invalid-feedback">
        </div>
    </div>
{{--    <div class="col-md-6 form-group">--}}
{{--        <div class="custom-control custom-checkbox">--}}
{{--            <input class="form-check-input" type="checkbox" value="1" id="mtestrange_bookmark" @if($analysisTestRange->bookmark) checked @endif name="range[bookmark]">--}}
{{--            <label class="form-check-label" for="mtestrange_bookmark">--}}
{{--                Resaltar resultado--}}
{{--            </label>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
<div id="rangeListOptions">
    @foreach($analysisTestRange->analysisTestRangeOptions as $analysisTestRangeOption)
        @php
        $tempId = rand(1, 500)
        @endphp
    <div class="border ui-corner-all p-1 mb-1">
        <input type="hidden" name="range[option][{{$tempId}}][id]" value="{{$analysisTestRangeOption->id}}">
        <div class="row">
            <div class="col-md-12">
                <label>Sexo</label>
                <button class="btn btn-link text-danger float-right" onclick="removeTestTypeRange(this);" title="Quitar opcion"><i class="far fa-trash-alt"></i></button>
                <div></div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="range[option][{{$tempId}}][gender]" id="inlineGenderMujer{{$tempId}}" value="mujer"
                           aria-describedby="validationGender{{$tempId}}" @if(strcmp($analysisTestRangeOption->gender, 'mujer') == 0) checked @endif>
                    <label class="form-check-label" for="inlineGenderMujer{{$tempId}}">Mujer</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="range[option][{{$tempId}}][gender]" id="inlineGenderVaron{{$tempId}}" value="hombre"
                           aria-describedby="validationGender{{$tempId}}" @if(strcmp($analysisTestRangeOption->gender, 'hombre') == 0) checked @endif>
                    <label class="form-check-label" for="inlineGenderVaron{{$tempId}}">Varon</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="range[option][{{$tempId}}][gender]" id="inlineGenderVaronMujer{{$tempId}}" value="hombre y mujer"
                           aria-describedby="validationGender{{$tempId}}" @if(strcmp($analysisTestRangeOption->gender, 'hombre y mujer') == 0) checked @endif>
                    <label class="form-check-label" for="inlineGenderVaronMujer{{$tempId}}">Varon / Mujer</label>
                </div>
                <div class="form-group">
                    <input type="hidden" id="mtestrange_option_{{$tempId}}_gender" class="form-control" />
                    <div class="invalid-feedback">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 form-group">
                <label for="mtestrange_option_{{$tempId}}_age_initial">Edad inicial</label>
                <input type="number" id="mtestrange_option_{{$tempId}}_age_initial" name="range[option][{{$tempId}}][age_initial]"
                       class="form-control form-control-sm" aria-describedby="validationAgeInitial{{$tempId}}"
                       value="{{ $analysisTestRangeOption->age_initial }}"
                >
                <div id="validationAgeInitial{{$tempId}}" class="invalid-feedback">
                </div>
            </div>
            <div class="col-md-3 form-group">
                <label for="mtestrange_option_{{$tempId}}_age_end">Edad Final</label>
                <input type="number" id="mtestrange_option_{{$tempId}}_age_end" name="range[option][{{$tempId}}][age_end]"
                       class="form-control form-control-sm" aria-describedby="validationAgeEnd{{$tempId}}"
                       value="{{ $analysisTestRangeOption->age_end }}"
                >
                <div id="validationAgeEnd{{$tempId}}" class="invalid-feedback">
                </div>
            </div>
            <div class="col-md-3 form-group">
                <label for="mtestrange_option_{{$tempId}}_initial">Inicial</label>
                <input type="number" id="mtestrange_option_{{$tempId}}_initial" name="range[option][{{$tempId}}][initial]"
                       class="form-control form-control-sm" aria-describedby="validationInitial{{$tempId}}"
                       value="{{ $analysisTestRangeOption->initial }}"
                >
                <div id="validationInitial{{$tempId}}" class="invalid-feedback">
                </div>
            </div>
            <div class="col-md-3 form-group">
                <label for="mtestrange_option_{{$tempId}}_end">Final</label>
                <input type="number" id="mtestrange_option_{{$tempId}}_end" name="range[option][{{$tempId}}][end]"
                       class="form-control form-control-sm" aria-describedby="validationEnd{{$tempId}}"
                       value="{{ $analysisTestRangeOption->end }}"
                >
                <div id="validationEnd{{$tempId}}" class="invalid-feedback">
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
