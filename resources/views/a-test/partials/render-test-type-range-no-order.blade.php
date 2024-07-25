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
        <input type="text" id="mtestrange_measure" name="range[measure]" class="form-control form-control-sm" aria-describedby="validationMeasure">
        <div id="validationMeasure" class="invalid-feedback">
        </div>
    </div>
</div>
<div id="rangeNoOrderListOptions">

</div>
<script>
</script>
