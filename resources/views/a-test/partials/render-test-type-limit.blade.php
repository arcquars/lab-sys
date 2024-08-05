<h5>
    <button type="button" class="btn btn-sm btn-outline-info" onclick="addTestTypeLimit();" title="Añadir opcion">
        <i class="fas fa-plus-square"></i>
    </button> Limite
</h5>
<div class="form-group">
    <input type="hidden" id="mtestrange_option" class="form-control" />
    <div class="invalid-feedback">
    </div>
</div>
<input type="hidden" value="0" name="range[bookmark]">
<div class="row">
    <div class="col-md-6 form-group">
        <label for="mtestlimit.measure">Unidad</label>
        <input type="text" id="mtestlimit_measure" name="limit[measure]" class="form-control form-control-sm" aria-describedby="validationMeasure">
        <div id="validationMeasure" class="invalid-feedback">
        </div>
    </div>
{{--    <div class="col-md-6 form-group">--}}
{{--        <div class="custom-control custom-checkbox">--}}
{{--            <input class="form-check-input" type="checkbox" value="1" id="mtestrange_bookmark" name="range[bookmark]">--}}
{{--            <label class="form-check-label" for="mtestrange_bookmark">--}}
{{--                Resaltar resultado--}}
{{--            </label>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
<div id="rangeListOptions">

</div>
<script>

</script>
