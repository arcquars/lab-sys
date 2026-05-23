<input type="hidden" name="id" value="@if($analysisTestGroup ) {{ $analysisTestGroup->id }} @endif">
@include('a-test.partials.render-group-select-form',['$groups' => $groups])
<div class="row no-gutters">
    <div class="col-md-8 pr-1">
        <label for="mgroupname">Nombre <span class="text-danger">*</span></label>
        <input type="text" id="mgroupname" name="name" class="form-control form-control-sm" aria-describedby="validationGroupName"
            value="@if($analysisTestGroup != null) {{ $analysisTestGroup->name }} @endif">
        <div id="validationGroupName" class="invalid-feedback">
        </div>
    </div>
    <div class="col-md-2 pl-1">
        <label for="mgroupprice">Precio</label>
        <input type="number" id="mgroupprice" name="price" step="0.1" class="form-control form-control-sm" aria-describedby="validationGroupPrice"
            value="@if($analysisTestGroup != null){{ $analysisTestGroup->price }}@endif">
        <div id="validationGroupPrice" class="invalid-feedback">
        </div>
    </div>
    <div class="col-md-2 pl-1">
        <label for="mgroupsortable">Orden</label>
        <input type="number" id="mgroupsortable" name="sortable" class="form-control form-control-sm" aria-describedby="validationGroupSortable"
            value="@if($analysisTestGroup != null){{ $analysisTestGroup->sortable }}@endif">
        <div id="validationGroupSortable" class="invalid-feedback">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="mgroupsubtitle">Subtitulo</label>
    <input type="text" id="mgroupsubtitle" name="subtitle" class="form-control form-control-sm" aria-describedby="validationGroupSubtitle"
        value="@if($analysisTestGroup != null) {{ $analysisTestGroup->subtitle }} @endif">
    <div id="validationGroupSubtitle" class="invalid-feedback">
    </div>
</div>
