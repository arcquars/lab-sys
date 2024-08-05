<h5>
    <button type="button" class="btn btn-sm btn-outline-info" onclick="addTestTypeRangeNoOrder();" title="Añadir opcion">
        <i class="fas fa-plus-square"></i>
    </button> Rango sin orden
</h5>
<div class="form-group">
    <input type="hidden" id="mtestrange_option" class="form-control" />
    <div class="invalid-feedback">
    </div>
</div>

<div class="row">
    <div class="col-md-4 form-group">
        <label for="mtestrange.measure">Unidad</label>
        <input type="text" id="mtestrange_measure" name="range[measure]" class="form-control form-control-sm"
               value="{{$analysisTestRange->measure}}" aria-describedby="validationMeasure">
        <div id="validationMeasure" class="invalid-feedback">
        </div>
    </div>
</div>
<div id="rangeNoOrderListOptions">
    @foreach($analysisTestRange->analysisTestRangeOptions as $analysisTestRangeOption)
        @php
            $tempId = rand(1, 500)
        @endphp
        <div class="border ui-corner-all p-1 mb-1">
            <input type="hidden" name="range[option][{{$tempId}}][id]" value="{{$analysisTestRangeOption->id}}">
            <div class="row">
                <div class="col-md-8">
                    <label><button class="btn btn-link text-danger" onclick="removeTestTypeRange(this);" title="Quitar opcion"><i class="far fa-trash-alt"></i></button> Sexo</label>
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
                <div class="col-md-2 form-group">
                    <label for="mtestrange_option_{{$tempId}}_age_initial">Edad inicial</label>
                    <input type="number" id="mtestrange_option_{{$tempId}}_age_initial" name="range[option][{{$tempId}}][age_initial]"
                           value="{{ $analysisTestRangeOption->age_initial }}" class="form-control form-control-sm" aria-describedby="validationAgeInitial{{$tempId}}">
                    <div id="validationAgeInitial{{$tempId}}" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-md-2 form-group">
                    <label for="mtestrange_option_{{$tempId}}_age_end">Edad Final</label>
                    <input type="number" id="mtestrange_option_{{$tempId}}_age_end" name="range[option][{{$tempId}}][age_end]"
                           value="{{ $analysisTestRangeOption->age_end }}" class="form-control form-control-sm" aria-describedby="validationAgeEnd{{$tempId}}">
                    <div id="validationAgeEnd{{$tempId}}" class="invalid-feedback">
                    </div>
                </div>
            </div>
            <div class="row mx-0">
                <div class="col-md-3 px-1 form-group">
                    <label for="mtestrange_option_{{$tempId}}_initial_text">Texto</label>
                    <input type="text" id="mtestrange_option_{{$tempId}}_initial_text" name="range[option][{{$tempId}}][initial_text]"
                           placeholder="Texto" class="form-control form-control-sm" aria-describedby="validationInitialText{{$tempId}}"
                           value="{{ $analysisTestRangeOption->initial_text }}"
                    >
                    <div id="validationInitialText{{$tempId}}" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-md-3 px-1 form-group">
                    <label for="mtestrange_option_{{$tempId}}_initial_value">Valor</label>
                    <input type="number" id="mtestrange_option_{{$tempId}}_initial_value" placeholder="Rango inicial"
                           step="0.1" name="range[option][{{$tempId}}][initial_value]" class="form-control form-control-sm"
                           aria-describedby="validationInitialValue{{$tempId}}" value="{{ $analysisTestRangeOption->initial_value }}">
                    <div id="validationInitialValue{{$tempId}}" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-md-3 px-1 form-group">
                    <label for="mtestrange_option_{{$tempId}}_initial_bookmark">Color</label>
                    <select id="mtestrange_option_{{$tempId}}_initial_bookmark" name="range[option][{{$tempId}}][initial_bookmark]"
                            class="form-control form-control-sm" aria-describedby="validationInitialColor{{$tempId}}"
                    >
                        <option value="">Ninguno</option>
                        <option value="1" @if($analysisTestRangeOption->initial_bookmark) selected @endif>ROJO</option>
                    </select>
                    <div id="validationInitialColor{{$tempId}}" class="invalid-feedback">
                    </div>
                </div>
            </div>
            <div>
                @foreach($analysisTestRangeOption->analysisTestRangeOptionsIntermediates as $index => $analysisTestRangeOptionsIntermediate)
                    @include('a-test.partials.render-range-no-order-intermediary-edit', [
    'analysisTestRangeOptionsIntermediate' => $analysisTestRangeOptionsIntermediate,
    'tempId' => $tempId,
    //'count' => count($analysisTestRangeOption->analysisTestRangeOptionsIntermediates)
    'count' => $index
    ])
                @endforeach
            </div>
            <a href="#" class="btn btn-link text-primary" onclick="addRangeIntermediary(this, {{$tempId}});">Agregar rango intermedio</a>
            <div class="row mx-0">
                <div class="col-md-3 px-1 form-group">
                    <label for="mtestrange_option_{{$tempId}}_end_text">Texto</label>
                    <input type="text" id="mtestrange_option_{{$tempId}}_end_text" name="range[option][{{$tempId}}][end_text]"
                           placeholder="Texto" class="form-control form-control-sm" aria-describedby="validationEndText{{$tempId}}"
                           value="{{ $analysisTestRangeOption->end_text }}"
                    >
                    <div id="validationEndText{{$tempId}}" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-md-3 px-1 form-group">
                    <label for="mtestrange_option_{{$tempId}}_end_value">Valor</label>
                    <input type="number" id="mtestrange_option_{{$tempId}}_end_value" placeholder="Rango final" name="range[option][{{$tempId}}][end_value]"
                           step="0.1" class="form-control form-control-sm" aria-describedby="validationEndValue{{$tempId}}"
                           value="{{ $analysisTestRangeOption->end_value }}"
                    >
                    <div id="validationEndValue{{$tempId}}" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-md-3 px-1 form-group">
                    <label for="mtestrange_option_{{$tempId}}_end_bookmark">Color</label>
                    <select id="mtestrange_option_{{$tempId}}_end_bookmark" name="range[option][{{$tempId}}][end_bookmark]" class="form-control form-control-sm"
                            aria-describedby="validationEndColor{{$tempId}}">
                        <option value="">Ninguno</option>
                        <option value="1" @if($analysisTestRangeOption->end_bookmark) selected @endif>ROJO</option>
                    </select>
                    <div id="validationEndColor{{$tempId}}" class="invalid-feedback">
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
<script>
</script>
