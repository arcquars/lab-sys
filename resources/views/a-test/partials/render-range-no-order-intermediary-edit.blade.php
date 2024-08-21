@php
use \App\AnalysisTestRangeNoOrderOptionIntermediary;
/** @var integer $tempId */
/** @var integer $count */
/** @var  $analysisTestRangeOptionsIntermediate AnalysisTestRangeNoOrderOptionIntermediary */
@endphp
<fieldset class="border border-gray rounded p-2 m-1">
    <input type="hidden" name="range[option][{{$tempId}}][intermediary][{{$count}}][id]" value="{{$analysisTestRangeOptionsIntermediate->id}}">
    <div class="row">
        <div class="col-md-4 form-group">
            <label for="mtestrange_option_{{$tempId}}_intermediary_{{$count}}_text">
                <a href="#" class="text-danger" onclick="removeRangeIntermediary(this); return false;"><i class="far fa-trash-alt"></i></a>
                Texto
            </label>
            <input type="text" id="mtestrange_option_{{$tempId}}_intermediary_{{$count}}_text" name="range[option][{{$tempId}}][intermediary][{{$count}}][text]"
                   class="form-control form-control-sm" aria-describedby="validationIntermediaryText{{$tempId.$count}}"
                   value="{{$analysisTestRangeOptionsIntermediate->range_name}}"
            >
            <div id="validationIntermediaryText{{$tempId.$count}}" class="invalid-feedback">
            </div>
        </div>
        <div class="col-md-2 form-group">
            <label for="mtestrange_option_{{$tempId}}_intermediary_{{$count}}_range_initial">
                Rango inicial
            </label>
            <input type="number" id="mtestrange_option_{{$tempId}}_intermediary_{{$count}}_range_initial" name="range[option][{{$tempId}}][intermediary][{{$count}}][initial_range]"
                   step="0.01" class="form-control form-control-sm" aria-describedby="validationIntermediaryRangeInitial{{$tempId.$count}}"
                   value="{{$analysisTestRangeOptionsIntermediate->initial_range}}"
            >
            <div id="validationIntermediaryRangeInitial{{$tempId.$count}}" class="invalid-feedback">
            </div>
        </div>
        <div class="col-md-2 form-group">
            <label for="mtestrange_option_{{$tempId}}_intermediary_{{$count}}_range_end">
                Rango final
            </label>
            <input type="number" id="mtestrange_option_{{$tempId}}_intermediary_{{$count}}_range_end" name="range[option][{{$tempId}}][intermediary][{{$count}}][end_range]"
                   step="0.01" class="form-control form-control-sm" aria-describedby="validationIntermediaryRangeEnd{{$tempId.$count}}"
                   value="{{$analysisTestRangeOptionsIntermediate->end_range}}"
            >
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
                <option value="1" @if($analysisTestRangeOptionsIntermediate->bookmark) selected @endif>ROJO</option>
            </select>
            <div id="validationIntermediaryColor{{$tempId.$count}}" class="invalid-feedback">
            </div>
        </div>
    </div>

</fieldset>
