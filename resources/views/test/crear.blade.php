@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'TEST', 'navName' => 'Test', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Análisis</a></li>
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
                                @if($testResult->aTest->analysisTestType)
                                    {!! $testResult->aTest->analysisTestType->getHtmlInput($testResult->id) !!}
                                    <div class="form-group">
                                        <label for="f_metodo_{{$testResult->a_test_id}}">Metodo</label>
                                        @if(strcmp($metodo, '1') == 0)
                                            <input 
                                                type="text" class="form-control form-control-sm" 
                                                value="{{ $testResult->metodo }}"
                                                name="metodos[{{$testResult->a_test_id}}]" id="f_metodo_{{$testResult->a_test_id}}">
                                        @else
                                        <select name="metodos[{{$testResult->a_test_id}}]" id="f_metodo_{{$testResult->a_test_id}}" class="form-control form-control-sm">
                                            <option value="">Seleccione ...</option>
                                            @foreach(config('clinica.metodos') as $metodo1)
                                                <option value="{{$metodo1}}" @if(isset($testResult->metodo) && strcmp($testResult->metodo, $metodo1) == 0 ) selected @endif>{{$metodo1}}</option>
                                            @endforeach
                                        </select>
                                        @endif
                                    </div>
                                @else
                                    {{ $testResult->aTest->id }}
                                @endif

                            </div>
                            <div class="col-md-4">
                                @if($testResult->aTest->analysisTestType)
                                {!! $testResult->aTest->analysisTestType->getHtmlDescription() !!}
                                @endif
                            </div>
                        </div>
                        <hr class="m-0" style="background: #91A0B9">
                    @endforeach
                    <br>
                @endforeach

                <div class="form-group">
                    <label for="a-observaciones">Observaciones</label>
                    <textarea name="observaciones" id="a-observaciones" rows="3" class="form-control">{{$analysis->observaciones}}</textarea>
                </div>

                {{-- SECCIÓN DE IMAGEN ADJUNTA EXISTENTE --}}
                @if($analysis->adjunto)
                    <div id="divAdjuntoActual" class="form-group border p-3 mb-4 bg-light rounded shadow-sm">
                        <label class="d-block font-weight-bold text-primary"><i class="fas fa-image"></i> Imagen Adjunta Actual:</label>
                        <div class="text-center position-relative">
                            <a href="{{ asset('uploads/test/' . $analysis->adjunto) }}" target="_blank">
                                <img src="{{ asset('uploads/test/' . $analysis->adjunto) }}" 
                                     class="img-thumbnail" 
                                     style="max-height: 250px; background-color: #fff;" 
                                     alt="Vista previa adjunto">
                            </a>
                            <div class="mt-3">
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDeleteAdjunto({{ $analysis->id }})">
                                    <i class="far fa-trash-alt"></i> Eliminar esta imagen de forma definitiva
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- SECCIÓN PARA SUBIR NUEVO ARCHIVO --}}
                <div class="form-group mt-4">
                    <label class="font-weight-bold">Adjuntar Nueva Imagen / Documento</label>
                    <p class="small text-muted">Si ya existe una imagen, seleccionar una nueva reemplazará a la anterior al hacer clic en "Grabar".</p>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="addon-upload">Subir</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="adjunto" class="custom-file-input" id="inputAdjunto" aria-describedby="addon-upload" accept="image/*,application/pdf">
                            <label class="custom-file-label" for="inputAdjunto" data-browse="Buscar">Seleccionar archivo...</label>
                        </div>
                    </div>
                    <div id="file-error-msg" class="text-danger small" style="display:none;"></div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ url()->previous() }}" class="btn btn-dark float-left">Atras</a>
                        <div class="float-right">
                            <input type="submit" name="grabar" class="btn btn-lab-pdm-primary" value="Grabar">
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
            $('[data-toggle="tooltip"]').tooltip();
            $(document).on('change', '.custom-file-input', function() {
                var file = this.files[0];
                var fileName = $(this).val().split('\\').pop();
                var errorDiv = $('#file-error-msg');
                
                errorDiv.hide().text("");

                if (fileName === "") {
                    $(this).next('.custom-file-label').html("Seleccionar archivo...");
                    return;
                }

                if (file) {
                    // Validación de tamaño: 5MB = 5 * 1024 * 1024 bytes
                    var maxSize = 5 * 1024 * 1024;
                    if (file.size > maxSize) {
                        errorDiv.text("El archivo es demasiado grande. El máximo permitido es 5MB.").show();
                        $(this).val(""); // Limpiar el input
                        $(this).next('.custom-file-label').html("Seleccionar archivo...");
                        return;
                    }

                    // Validación de tipo de archivo (solo imagen)
                    if (!file.type.match('image.*')) {
                        errorDiv.text("Por favor, seleccione únicamente archivos de imagen.").show();
                        $(this).val(""); 
                        $(this).next('.custom-file-label').html("Seleccionar archivo...");
                        return;
                    }
                }

                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });

        function confirmDeleteAdjunto(analysisId) {
            if(confirm('¿Está seguro de que desea eliminar permanentemente la imagen adjunta actual? Esta acción no se puede deshacer.')) {
                
                $.ajax({
                    url: "{{ url('/test/delete-adjunto') }}",
                    type: 'POST',
                    data: {
                        id: analysisId
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#divAdjuntoActual').slideUp('slow', function() {
                                $(this).remove();
                            });
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Ocurrió un error al intentar eliminar el archivo.');
                    }
                });
            }
        }
    </script>
@endpush
