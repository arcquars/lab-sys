<fieldset class="border border-gray rounded p-2 m-1">
    <div class="row">
        <div class="col-md-4 form-group">
            <label for="mtestrange_option_{{$tempId}}_intermediary_{{$count}}_text">
                <a href="#" class="text-danger" onclick="removeRangeIntermediary(this); return false;"><i class="far fa-trash-alt"></i></a>
                Texto
            </label>
            <input type="text" id="mtestrange_option_{{$tempId}}_intermediary_{{$count}}_text" name="range[option][{{$tempId}}][intermediary][{{$count}}][text]"
                   class="form-control form-control-sm" aria-describedby="validationIntermediaryText{{$tempId.$count}}">
            <div id="validationIntermediaryText{{$tempId.$count}}" class="invalid-feedback">
            </div>
        </div>
        <div class="col-md-2 form-group">
            <label for="mtestrange_option_{{$tempId}}_intermediary_{{$count}}_range_initial">
                Rango inicial
            </label>
            <input type="number" id="mtestrange_option_{{$tempId}}_intermediary_{{$count}}_range_initial" name="range[option][{{$tempId}}][intermediary][{{$count}}][range_initial]"
                   class="form-control form-control-sm" aria-describedby="validationIntermediaryRangeInitial{{$tempId.$count}}">
            <div id="validationIntermediaryRangeInitial{{$tempId.$count}}" class="invalid-feedback">
            </div>
        </div>
        <div class="col-md-2 form-group">
            <label for="mtestrange_option_{{$tempId}}_intermediary_{{$count}}_range_end">
                Rango final
            </label>
            <input type="number" id="mtestrange_option_{{$tempId}}_intermediary_{{$count}}_range_end" name="range[option][{{$tempId}}][intermediary][{{$count}}][range_end]"
                   class="form-control form-control-sm" aria-describedby="validationIntermediaryRangeEnd{{$tempId.$count}}">
            <div id="validationIntermediaryRangeEnd{{$tempId.$count}}" class="invalid-feedback">
            </div>
        </div>
        <div class="col-md-4 form-group">
            <label for="mtestrange_option_{{$tempId}}_intermediary_{{$count}}_bookmark">
                Color
            </label>
            <select id="mtestrange_option_{{$tempId}}_intermediary_{{$count}}_bookmark" name="range[option][{{$tempId}}][intermediary][{{$count}}][bookmark]"
                    class="form-control form-control-sm" aria-describedby="validationIntermediaryColor{{$tempId.$count}}">
                <option value="">Seleccione ...</option>
                <option value="ROJO">ROJO</option>
            </select>
            <div id="validationIntermediaryColor{{$tempId.$count}}" class="invalid-feedback">
            </div>
        </div>
    </div>

</fieldset>
