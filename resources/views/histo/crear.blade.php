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
                <div class="form-group">
                    Selecciones Imagen 1: <input type="file" name="imagen1" accept="image/x-png,image/gif,image/jpeg">
                </div>
                <div class="form-group">
                    Selecciones Imagen 2: <input type="file" name="imagen2" accept="image/x-png,image/gif,image/jpeg">
                </div>
                <div class="form-group">
                    Selecciones Imagen 3: <input type="file" name="imagen3" accept="image/x-png,image/gif,image/jpeg">
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
    <script src="{{ asset('ckeditor5/ckeditor.js') }}"></script>
    <script src="{{ asset('ckeditor5/translations/es.js') }}"></script>
    <script>
        $(document).ready(function () {
            ClassicEditor
                .create( document.querySelector( '#ta-interpretacion' ), {
                    alignment: {
                        options: [ 'left', 'right' ]
                    },
                    toolbar: [
                        'heading', '|', 'bulletedList', 'numberedList', 'alignment', 'bold', 'italic', 'blockQuote', 'underline','undo', 'redo'
                    ],
                    language: {
                        // The UI will be English.
                        ui: 'es',

                        // But the content will be edited in Arabic.
                        content: 'es'
                    }
                })
                .then( editor => {
                    console.log( editor );
                } )
                .catch( error => {
                    console.error( error );
                } );
            ClassicEditor
                .create( document.querySelector( '#ta-tecnica' ), {
                    alignment: {
                        options: [ 'left', 'right' ]
                    },
                    toolbar: [
                        'heading', '|', 'bulletedList', 'numberedList', 'alignment', 'bold', 'italic', 'undo', 'redo'
                    ],
                    language: {
                        // The UI will be English.
                        ui: 'es',

                        // But the content will be edited in Arabic.
                        content: 'es'
                    }
                })
                .then( editor => {
                    @cannot('manage-users-tecnico') editor.isReadOnly = true; @endcannot
                } )
                .catch( error => {
                    console.error( error );
                } );
            ClassicEditor
                .create( document.querySelector( '#ta-bibliografia' ), {
                    alignment: {
                        options: [ 'left', 'right' ]
                    },
                    toolbar: [
                        'heading', '|', 'bulletedList', 'numberedList', 'alignment', 'bold', 'italic', 'undo', 'redo'
                    ],
                    language: {
                        // The UI will be English.
                        ui: 'es',

                        // But the content will be edited in Arabic.
                        content: 'es'
                    }
                })
                .then( editor => {
                    @can('manage-users-tecnico') editor.isReadOnly = true; @endcan
                } )
                .catch( error => {
                    console.error( error );
                } );
        });

    </script>
@endpush
