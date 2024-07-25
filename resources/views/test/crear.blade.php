@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Biopsia', 'navName' => 'Biopsia', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item">Crear Prueba</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            @include('citologia.partial.cliente-head', ['analisis' => $analysis])
        </div>
        <div class="card-body">
            <form action="{{url('/test/save')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="analisis_id" value="{{$analysis->id}}">

                @foreach($orderGroupTest as $key => $testResults)
                    <h4>{{$key}}</h4>
                    @foreach($testResults as $testResult)
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">
                                    {{ $testResult->aTest->name }}
                                </label>
                            </div>
                            <div class="col-md-4">
                                {!! $testResult->aTest->analysisTestType->getHtmlInput() !!}
                            </div>
                            <div class="col-md-4">
                                {!! $testResult->aTest->analysisTestType->getHtmlDescription() !!}
                            </div>
                        </div>
                    @endforeach
                    <br>
                @endforeach

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
