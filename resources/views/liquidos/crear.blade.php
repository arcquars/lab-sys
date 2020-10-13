@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Liquidos', 'navName' => 'Liquidos', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Análisis</a></li>
            <li class="breadcrumb-item">Crear Liquidos</li>

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
            <form action="{{url('/liquidos/save')}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="analisis_id" value="{{$analisis->id}}">
                <input type="hidden" name="liquido_id" value="{{$liquido ? $liquido->id : ''}}">

                <div class="form-group">
                    <label for="organo_tejido">ÓRGANO Y TEJIDO</label>
                    <input type="text" name="organo_tejido" id="ta-organo_tejido" class="form-control" value="{{@old('organo_tejido', $analisis->region)}}" required>
                </div>
                <div class="form-group">
                    <label for="macroscopia">Macroscopia</label>
                    <textarea name="macroscopia" id="ta-macroscopia" class="form-control">{{@old('macroscopia', $liquido ? $liquido->macroscopia : '')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="microscopia">Microscopia</label>
                    <textarea name="microscopia" id="ta-microscopia" class="form-control">{{@old('microscopia', $liquido ? $liquido->microscopia : '')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="diagnostico">Diagnostico</label>
                    <textarea name="diagnostico" id="ta-diagnostico" class="form-control">{{@old('diagnostico', $liquido ? $liquido->diagnostico : '')}}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ url()->previous() }}" class="btn btn-dark float-left">Atras</a>
                        <div class="float-right">
                            @can('manage-users')
                            <input type="submit" name="grabar-imprimir" class="btn btn-success" value="Grabar/Imprimir">
                            @endcan
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
                selector: '#ta-macroscopia',
                plugins: "lists autoresize",
                toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify fontselect fontsizeselect | bullist numlist outdent indent | link image',
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
                @cannot('manage-users-all') readonly : 1 @endcannot
            });
            tinymce.init({
                selector: '#ta-microscopia',
                plugins: "lists autoresize",
                toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify fontselect fontsizeselect | bullist numlist outdent indent | link image',
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
                @cannot('manage-users-dr') readonly : 1 @endcannot
            });
            tinymce.init({
                selector: '#ta-diagnostico',
                plugins: "lists autoresize",
                toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify fontselect fontsizeselect | bullist numlist outdent indent | link image',
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
                @cannot('manage-users-dr') readonly : 1 @endcannot
            });

            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        });

        function prueba() {
            console.log($('#ta-organo-tejido').val());
        }
    </script>
@endpush
