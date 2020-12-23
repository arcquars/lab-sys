@extends('layouts.dash', ['activePage' => 'texto_predefinido', 'title' => 'Editar Texto predefinido', 'navName' => 'Texto Predefinido', 'activeButton' => 'texto_predefinido'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('texto-predefinido.index')}}">Texto predefinido</a></li>
            <li class="breadcrumb-item">Editar Texto Predefinido</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
{{--            {{$texto->texto}}--}}
        </div>
        <div class="card-body">
            <form action="{{url('/texto-predefinido/'.$texto->id)}}" method="post">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="texto">Texto:</label>
                    <textarea name="texto" id="texto_pre" rows="3" >{!! $texto->texto !!}</textarea>
                </div>
                @error('texto')
                <span class="text-danger">{{ $message }}</span>
                @enderror

                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ url()->previous() }}" class="btn btn-dark float-left">Atras</a>
                        <div class="float-right">
                            <input type="submit" name="grabar" class="btn btn-primary" value="Grabar">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            tinymce.init({
                selector: '#texto_pre',
                plugins: "lists autoresize",
                toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
            });

            // tinyMCE.get('texto_pre').setContent('zzzzzzzzzz');
            {{--tinymce.activeEditor.setContent('{{$texto->texto}}');--}}
        });


    </script>
@endpush
