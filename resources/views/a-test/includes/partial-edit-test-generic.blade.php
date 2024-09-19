<h5>
    <button type="button" class="btn btn-sm btn-outline-info" onclick="addTestTypeGeneric();" title="Añadir opcion">
        <i class="fas fa-plus-square"></i>
    </button> Generico
</h5>
<div class="form-group">
    <input type="hidden" id="mtestrange_option" class="form-control" />
    <div class="invalid-feedback">
    </div>
</div>
<input type="hidden" value="0" name="range[bookmark]">
<div id="genericListOptions">
    @foreach($analysisTestGeneric->analysisTestGenericOptions as $analysisTestGenericOption)
        @php
            $tempId = rand(1, 500)
        @endphp
        <div class="border ui-corner-all p-1 mb-1">
            <input type="hidden" name="range[option][{{$tempId}}][id]" value="{{$analysisTestGenericOption->id}}">
            <div class="row">
                <div class="col-md-12">
                    <label>Sexo</label>
                    <button class="btn btn-link text-danger float-right" onclick="removeTestTypeGeneric(this);" title="Quitar opcion"><i class="far fa-trash-alt"></i></button>
                    <div></div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="range[option][{{$tempId}}][gender]" id="inlineGenderMujer{{$tempId}}" value="mujer"
                               aria-describedby="validationGender{{$tempId}}" @if(strcmp($analysisTestGenericOption->gender, 'mujer') == 0) checked @endif>
                        <label class="form-check-label" for="inlineGenderMujer{{$tempId}}">Mujer</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="range[option][{{$tempId}}][gender]" id="inlineGenderVaron{{$tempId}}" value="hombre"
                               aria-describedby="validationGender{{$tempId}}" @if(strcmp($analysisTestGenericOption->gender, 'hombre') == 0) checked @endif>
                        <label class="form-check-label" for="inlineGenderVaron{{$tempId}}">Varon</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="range[option][{{$tempId}}][gender]" id="inlineGenderVaronMujer{{$tempId}}" value="hombre y mujer"
                               aria-describedby="validationGender{{$tempId}}" @if(strcmp($analysisTestGenericOption->gender, 'hombre y mujer') == 0) checked @endif>
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
                <div class="col-md-2 form-group">
                    <label for="mtestrange_option_{{$tempId}}_age_initial">Edad inicial</label>
                    <input type="number" id="mtestrange_option_{{$tempId}}_age_initial" name="range[option][{{$tempId}}][age_initial]"
                           value="{{ $analysisTestGenericOption->age_initial }}" class="form-control form-control-sm" aria-describedby="validationAgeInitial{{$tempId}}">
                    <div id="validationAgeInitial{{$tempId}}" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-md-2 form-group">
                    <label for="mtestrange_option_{{$tempId}}_age_end">Edad Final</label>
                    <input type="number" id="mtestrange_option_{{$tempId}}_age_end" name="range[option][{{$tempId}}][age_end]"
                           value="{{ $analysisTestGenericOption->age_end }}" class="form-control form-control-sm" aria-describedby="validationAgeEnd{{$tempId}}">
                    <div id="validationAgeEnd{{$tempId}}" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <label for="mtestrange_option_{{$tempId}}_reference">Referencia</label>
                    <input type="text" id="mtestrange_option_{{$tempId}}_reference" name="range[option][{{$tempId}}][reference]" class="form-control form-control-sm"
                           value="{{ $analysisTestGenericOption->reference }}" aria-describedby="validationreference{{$tempId}}">
                    <div id="validationreference{{$tempId}}" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <label for="mtestrange_option_{{$tempId}}_bookmark">Color</label>
                    <select id="mtestrange_option_{{$tempId}}_bookmark" name="range[option][{{$tempId}}][bookmark]" class="form-control form-control-sm"
                            aria-describedby="validationBookmark{{$tempId}}">
                        <option value="">Ninguno</option>
{{--                        <option value="ROJO">ROJO</option>--}}
                        <option value="1" @if($analysisTestGenericOption->bookmark) selected @endif>ROJO</option>
                    </select>
                    <div id="validationBookmark{{$tempId}}" class="invalid-feedback">
                    </div>
                </div>
            </div>
        </div>

    @endforeach
</div>
<script>

</script>
