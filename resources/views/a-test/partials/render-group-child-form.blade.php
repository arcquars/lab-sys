@foreach($childs as $child)
    <option value="{{$child->id}}" @if($parent_id && $parent_id == $child->id) selected @endif>
        @for($i=0; $i<$level; $i++)
            -
        @endfor
        {{$child->name}}
    </option>
    @if(count($child->children))
        @include('a-test.partials.render-group-child-form',['level' => $level+1, 'childs' => $child->children, 'parent_id' => $parent_id])
    @endif
@endforeach
