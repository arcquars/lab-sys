<div class="border ui-corner-all p-1 mb-1">
    <div class="row">
        <div class="col-md-12">
            <label>Sexo</label>
            <button class="btn btn-link text-danger float-right" onclick="removeTestTypeLimit(this);" title="Quitar opcion"><i class="far fa-trash-alt"></i></button>
            <div></div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="range[option][{{$tempId}}][gender]" id="inlineGenderMujer{{$tempId}}" value="mujer"
                       aria-describedby="validationGender{{$tempId}}">
                <label class="form-check-label" for="inlineGenderMujer{{$tempId}}">Mujer</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="range[option][{{$tempId}}][gender]" id="inlineGenderVaron{{$tempId}}" value="hombre"
                       aria-describedby="validationGender{{$tempId}}">
                <label class="form-check-label" for="inlineGenderVaron{{$tempId}}">Varon</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="range[option][{{$tempId}}][gender]" id="inlineGenderVaronMujer{{$tempId}}" value="hombre y mujer"
                       aria-describedby="validationGender{{$tempId}}">
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
            <input type="number" id="mtestrange_option_{{$tempId}}_age_initial" name="range[option][{{$tempId}}][age_initial]" class="form-control form-control-sm" aria-describedby="validationAgeInitial{{$tempId}}">
            <div id="validationAgeInitial{{$tempId}}" class="invalid-feedback">
            </div>
        </div>
        <div class="col-md-3 form-group">
            <label for="mtestrange_option_{{$tempId}}_age_end">Edad Final</label>
            <input type="number" id="mtestrange_option_{{$tempId}}_age_end" name="range[option][{{$tempId}}][age_end]" class="form-control form-control-sm" aria-describedby="validationAgeEnd{{$tempId}}">
            <div id="validationAgeEnd{{$tempId}}" class="invalid-feedback">
            </div>
        </div>
        <div class="col-md-3 form-group">
            <label for="mtestrange_option_{{$tempId}}_to">Hasta</label>
            <input type="number" id="mtestrange_option_{{$tempId}}_to" name="range[option][{{$tempId}}][to]" class="form-control form-control-sm"
                   aria-describedby="validationTo{{$tempId}}" step="0.01">
            <div id="validationTo{{$tempId}}" class="invalid-feedback">
            </div>
        </div>
        <div class="col-md-3 form-group">
            <label for="mtestrange_option_{{$tempId}}_bookmark">Color</label>
            <select id="mtestrange_option_{{$tempId}}_bookmark" name="range[option][{{$tempId}}][bookmark]" class="form-control form-control-sm"
                    aria-describedby="validationBookmarkColor{{$tempId}}">
                <option value="">Ninguno</option>
                <option value="ROJO">ROJO</option>
            </select>
            <div id="validationBookmarkColor{{$tempId}}" class="invalid-feedback">
            </div>
        </div>
    </div>
</div>
