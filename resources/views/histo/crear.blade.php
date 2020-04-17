@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Inmunohistoquimica', 'navName' => 'Inmunohistoquimica', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item">Crear Inmunohistoquimica</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            @include('citologia.partial.cliente-head', ['analisis' => $analisis])
        </div>
        <div class="card-body">
            <ul class="ul-clinica-errors">
                @foreach ($errors->get('interpretacion') as $error)
                    <li>{{ $error }}</li>
                @endforeach
                @foreach ($errors->get('tecnica') as $error)
                    <li>{{ $error }}</li>
                @endforeach
                @foreach ($errors->get('bibliografia') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <form action="{{url('/histo/save')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="analisis_id" value="{{$analisis->id}}">
                <input type="hidden" name="histo_id" value="{{$histo ? $histo->id : ''}}">


                <div class="row">
                    <div class="col-md-3 form-group">
                        Imagen 1: <input type="file" name="imagen1" accept="image/x-png,image/gif,image/jpeg">
                        @if($histo && !empty($histo->imagen1))
                            <p><a href="{{asset($histo->imagen1)}}" target="_blank">Imagen 1</a></p>
                        @endif
                    </div>
                    <div class="col-md-3 form-group">
                        Imagen 2: <input type="file" name="imagen2" accept="image/x-png,image/gif,image/jpeg">
                        @if($histo && !empty($histo->imagen2))
                            <p><a href="{{asset($histo->imagen2)}}" target="_blank">Imagen 2</a></p>
                        @endif
                    </div>
                    <div class="col-md-3 form-group">
                        Imagen 3: <input type="file" name="imagen3" accept="image/x-png,image/gif,image/jpeg">
                        @if($histo && !empty($histo->imagen3))
                            <p><a href="{{asset($histo->imagen3)}}" target="_blank">Imagen 3</a></p>
                        @endif
                    </div>
                    <div class="col-md-3 form-group">
                        Imagen 4: <input type="file" name="imagen4" accept="image/x-png,image/gif,image/jpeg">
                        @if($histo && !empty($histo->imagen4))
                            <p><a href="{{asset($histo->imagen4)}}" target="_blank">Imagen 4</a></p>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group" >
                        <label>Titulo 1</label>
                        <input type="text" name="titulo_1" class="form-control" value="{{@old('titulo_1', $histo->titulo_1)}}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Titulo 2</label>
                        <input type="text" name="titulo_2" class="form-control" value="{{@old('titulo_2', $histo->titulo_2)}}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Titulo 3</label>
                        <input type="text" name="titulo_3" class="form-control" value="{{@old('titulo_3', $histo->titulo_3)}}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Titulo 4</label>
                        <input type="text" name="titulo_4" class="form-control" value="{{@old('titulo_4', $histo->titulo_4)}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="organo_tejido">Interpretacion</label>
                    <textarea name="interpretacion" id="ta-interpretacion" class="form-control">{{@old('interpretacion', $histo ? $histo->interpretacion : '')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="tecnica">Tecnica</label>
                    <textarea name="tecnica" id="ta-tecnica" class="form-control">{{@old('tecnica', $histo ? $histo->tecnica : '')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="bibliografia">Bibliografia</label>
                    <textarea name="bibliografia" id="ta-bibliografia" class="form-control">{{@old('bibliografia', $histo ? $histo->bibliografia : '')}}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ url()->previous() }}" class="btn btn-dark float-left">Atras</a>
                        <input type="submit" class="btn btn-primary float-right" value="Grabar">
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
                selector: '#ta-interpretacion',
                toolbar: "undo redo | bold italic | link image | underline",
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
                @cannot('manage-users-all') readonly : 1 @endcannot
            });
            tinymce.init({
                selector: '#ta-tecnica',
                toolbar: "undo redo | bold italic | link image | underline",
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
                @cannot('manage-users-all') readonly : 1 @endcannot
            });
            tinymce.init({
                selector: '#ta-bibliografia',
                toolbar: "undo redo | bold italic | link image | underline",
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
                @cannot('manage-users-all') readonly : 1 @endcan
            });
        });

    </script>
@endpush
