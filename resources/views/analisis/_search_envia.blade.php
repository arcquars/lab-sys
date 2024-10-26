<div class="list-group" style="z-index: 10; position: absolute; width: 100%;">
@foreach($anaDoctores as $analisis)
        <a href="#" class="list-group-item list-group-item-action" onClick="selectEnvia('{{$analisis->doctor}}');">
            {{$analisis->doctor}}
        </a>
    @endforeach
</div>
