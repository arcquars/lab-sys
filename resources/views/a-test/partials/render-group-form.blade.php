<input type="hidden" name="id" value="@if($analysisTestGroup ) {{ $analysisTestGroup->id }} @endif">
@include('a-test.partials.render-group-select-form',['$groups' => $groups])
<div class="form-group">
    <label for="mgroupname">Nombre</label>
    <input type="text" id="mgroupname" name="name" class="form-control form-control-sm" aria-describedby="validationGroupName"
        value="@if($analysisTestGroup != null) {{ $analysisTestGroup->name }} @endif">
    <div id="validationGroupName" class="invalid-feedback">
    </div>
</div>
