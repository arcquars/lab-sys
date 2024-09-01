<div class="form-group">
    <label for="mgroupgroup">Grupo</label>
    <select name="group" id="mgroupgroup" class="form-control form-control-sm">
        <option value="">PADRE</option>
        @foreach($groups as $group)
            <option value="{{ $group->id }}" @if($analysisTestGroup && $analysisTestGroup->parent_id == $group->id) selected @endif>{{ $group->name }}</option>
            @if(count($group->children))
                @include('a-test.partials.render-group-child-form',['level' => 1, 'childs' => $group->children, 'parent_id' => ($analysisTestGroup)? $analysisTestGroup->parent_id : null])
            @endif
        @endforeach
    </select>
    <div id="validationGroupName" class="invalid-feedback">
    </div>
</div>
