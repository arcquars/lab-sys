@foreach($childs as $child)
    <option value="{{$child->id}}" @if($group_id == $child->id)? selected @endif>
        @for($i=0; $i<$level; $i++)
            -
        @endfor
        {{$child->name}}
    </option>
    @if(count($child->children))
        @include('a-test.partials.render-group-child-html',['level' => $level+1, 'childs' => $child->children, 'group_id' => $group_id])
    @endif
@endforeach
