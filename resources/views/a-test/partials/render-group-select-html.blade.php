<div class="form-group">
    <label for="mgroupgroup">Grupo</label>
    <select name="group" id="mgroupgroup" class="form-control form-control-sm">
        <option value="">-- Seleccione grupo --</option>
        @if(isset($group_id))
            @foreach($groups as $group)
                <option value="{{ $group->id }}" @if($group_id == $group->id)? selected @endif >{{ $group->name }}</option>
                @if(count($group->children))
                    @include('a-test.partials.render-group-child-html',['level' => 1, 'childs' => $group->children, 'group_id' => (isset($group_id))? $group_id: null])
                @endif
            @endforeach
        @else
            @foreach($groups as $i => $group)
                <option value="{{ $group->id }}" @if($i == 0)? selected @endif >{{ $group->name }}</option>
                @if(count($group->children))
                    @include('a-test.partials.render-group-child-html',['level' => 1, 'childs' => $group->children, 'group_id' => null])
                @endif
            @endforeach
        @endif
        
    </select>
    <div id="validationGroupName" class="invalid-feedback">
    </div>
</div>
