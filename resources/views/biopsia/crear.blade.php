@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Biopsia', 'navName' => 'Biopsia', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item">Crear Biopsia</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            @include('citologia.partial.cliente-head', ['analisis' => $analisis])
        </div>
        <div class="card-body">
            <ul class="ul-clinica-errors">
                @foreach ($errors->get('organo_tejido') as $error)
                    <li>{{ $error }}</li>
                @endforeach
                    @foreach ($errors->get('macroscopia') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @foreach ($errors->get('microscopia') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @foreach ($errors->get('diagnostico') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
            </ul>
            <form action="{{url('/biopsia/save')}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="analisis_id" value="{{$analisis->id}}">
                <input type="hidden" name="biopsia_id" value="{{$biopsia ? $biopsia->id : ''}}">
                <div class="form-group">
                    <label for="organo_tejido">Organo o Tejido</label>
                    <textarea name="organo_tejido" id="ta-organo_tejido" class="form-control">{{@old('organo_tejido', $biopsia ? $biopsia->organo_tejido : '')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="macroscopia">Macroscopia</label>
                    <textarea name="macroscopia" id="ta-macroscopia" class="form-control">{{@old('macroscopia', $biopsia ? $biopsia->macroscopia : '')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="microscopia">Microscopia</label>
                    <textarea name="microscopia" id="ta-microscopia" class="form-control">{{@old('microscopia', $biopsia ? $biopsia->microscopia : '')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="diagnostico">Diagnostico</label>
                    <textarea name="diagnostico" id="ta-diagnostico" class="form-control">{{@old('diagnostico', $biopsia ? $biopsia->diagnostico : '')}}</textarea>
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
            var editor1 = ClassicEditor
                .create( document.querySelector( '#ta-organo_tejido' ), {
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
                })
                .catch( error => {
                    console.error( error );
                } );



            ClassicEditor
                .create( document.querySelector( '#ta-macroscopia' ), {
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
                .create( document.querySelector( '#ta-microscopia' ), {
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
                .create( document.querySelector( '#ta-diagnostico' ), {
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

        function prueba() {
            console.log($('#ta-organo-tejido').val());
        }
    </script>
@endpush
