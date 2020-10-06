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
                    <label for="tecnica">Técnica</label>
                    <textarea name="tecnica" id="ta-tecnica" class="form-control">{{@old('tecnica', $histo ? $histo->tecnica : config('clinica.tecnica'))}}</textarea>
                </div>
                <div class="form-group">
                    <label for="bibliografia">Bibliografia</label>
                    <textarea name="bibliografia" id="ta-bibliografia" class="form-control">{{@old('bibliografia', $histo ? $histo->bibliografia : '')}}</textarea>
                </div>
                <label>Añadir Marcado <a href="#" onclick="openMdlMarcador(); return false;"><i class="fas fa-plus-circle"></i></a></label>
                <div id="list_marcadores" class="row">

                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ url()->previous() }}" class="btn btn-dark float-left">Atras</a>
                        <div class="float-right">
                            <input type="submit" name="grabar-imprimir" class="btn btn-success" value="Grabar/Imprimir">
                            <input type="submit" name="grabar" class="btn btn-primary" value="Grabar">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('histo.partial.marcador_modal')

@endsection

@push('js')
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        @if ($histo)
        var numMarcadores = parseInt('{{count($histo->marcadores)}}');
        @else
        var numMarcadores = 0;
        @endif
        $(document).ready(function () {
            tinymce.init({
                selector: '#ta-interpretacion',
                plugins: "lists autoresize",
                toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify fontselect fontsizeselect | bullist numlist outdent indent | link image',
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
                @cannot('manage-users-all') readonly : 1 @endcannot
            });
            tinymce.init({
                selector: '#ta-tecnica',
                plugins: "lists autoresize",
                toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify fontselect fontsizeselect | bullist numlist outdent indent | link image',
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
                @cannot('manage-users-all') readonly : 1 @endcannot
            });
            tinymce.init({
                selector: '#ta-bibliografia',
                plugins: "lists autoresize",
                toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify fontselect fontsizeselect | bullist numlist outdent indent | link image',
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
                @cannot('manage-users-all') readonly : 1 @endcan
            });
            @if ($histo)
            @foreach($histo->marcadores as $marcador)
            $("#list_marcadores").append(addMarcadorHtml(
                '{{ $marcador->nombre }}',
                '{{ $marcador-> resultado }}',
            ));

            @endforeach
            @endif

        });
    </script>
@endpush
