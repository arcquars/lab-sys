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
            <form action="{{url('/biopsia/save')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="analisis_id" value="{{$analisis->id}}">
                <input type="hidden" name="biopsia_id" value="{{$biopsia ? $biopsia->id : ''}}">
                <input type="hidden" name="is_histopatologico" value="{{$is_histopatologico}}">

                <div class="row">
                    <div class="col-md-3">
                        Imagen 1: <input type="file" name="imagen1" accept="image/x-png,image/gif,image/jpeg">
                        @if($biopsia && !empty($biopsia->imagen1))
                            <p><a href="{{asset($biopsia->imagen1)}}" target="_blank">Imagen 1</a></p>
                        @endif
                    </div>
                    <div class="col-md-3">
                        Imagen 2: <input type="file" name="imagen2" accept="image/x-png,image/gif,image/jpeg">
                        @if($biopsia && !empty($biopsia->imagen2))
                            <p><a href="{{asset($biopsia->imagen2)}}" target="_blank">Imagen 2</a></p>
                        @endif
                    </div>
                    <div class="col-md-3">
                        Imagen 3: <input type="file" name="imagen3" accept="image/x-png,image/gif,image/jpeg">
                        @if($biopsia && !empty($biopsia->imagen3))
                            <p><a href="{{asset($biopsia->imagen3)}}" target="_blank">Imagen 3</a></p>
                        @endif
                    </div>
                    <div class="col-md-3">
                        Imagen 4: <input type="file" name="imagen4" accept="image/x-png,image/gif,image/jpeg">
                        @if($biopsia && !empty($biopsia->imagen4))
                            <p><a href="{{asset($biopsia->imagen4)}}" target="_blank">Imagen 4</a></p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 form-group" >
                        <label>Titulo 1</label>
                        <input type="text" name="titulo_1" class="form-control" value="{{@old('titulo_1', $biopsia->titulo_1)}}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Titulo 2</label>
                        <input type="text" name="titulo_2" class="form-control" value="{{@old('titulo_2', $biopsia->titulo_2)}}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Titulo 3</label>
                        <input type="text" name="titulo_3" class="form-control" value="{{@old('titulo_3', $biopsia->titulo_3)}}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Titulo 4</label>
                        <input type="text" name="titulo_4" class="form-control" value="{{@old('titulo_4', $biopsia->titulo_4)}}">
                    </div>
                </div>

                @if ($is_histopatologico)
                    <hr>
                <h5>Imagenes Histopatologicos</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="histopatologico_imagenes1">Imagen 1</label>
                                <input type="file" class="form-control form-sin-border" name="histopatologico_imagenes1" />
                                @if($biopsia && !empty($biopsia->histopatologico_imagenes1))
                                    <p><a href="{{asset($biopsia->histopatologico_imagenes1)}}" target="_blank">Imagen 1</a></p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Titulo 1</label>
                                <input type="text" name="histopatologico_nombre1" class="form-control" value="{{@old('histopatologico_nombre1', $biopsia->histopatologico_nombre1)}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="histopatologico_imagenes2">Imagen 2</label>
                                <input type="file" class="form-control form-sin-border" name="histopatologico_imagenes2" />
                                @if($biopsia && !empty($biopsia->histopatologico_imagenes2))
                                    <p><a href="{{asset($biopsia->histopatologico_imagenes2)}}" target="_blank">Imagen 2</a></p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Titulo 2</label>
                                <input type="text" name="histopatologico_nombre2" class="form-control" value="{{@old('histopatologico_nombre2', $biopsia->histopatologico_nombre2)}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="histopatologico_imagenes3">Imagen 3</label>
                                <input type="file" class="form-control form-sin-border" name="histopatologico_imagenes3" />
                                @if($biopsia && !empty($biopsia->histopatologico_imagenes3))
                                    <p><a href="{{asset($biopsia->histopatologico_imagenes3)}}" target="_blank">Imagen 3</a></p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Titulo 3</label>
                                <input type="text" name="histopatologico_nombre3" class="form-control" value="{{@old('histopatologico_nombre3', $biopsia->histopatologico_nombre3)}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="histopatologico_imagenes4">Imagen 4</label>
                                <input type="file" class="form-control form-sin-border" name="histopatologico_imagenes4" />
                                @if($biopsia && !empty($biopsia->histopatologico_imagenes4))
                                    <p><a href="{{asset($biopsia->histopatologico_imagenes4)}}" target="_blank">Imagen 4</a></p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Titulo 4</label>
                                <input type="text" name="histopatologico_nombre4" class="form-control" value="{{@old('histopatologico_nombre4', $biopsia->histopatologico_nombre4)}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="histopatologico_imagenes5">Imagen 5</label>
                                <input type="file" class="form-control form-sin-border" name="histopatologico_imagenes5" />
                                @if($biopsia && !empty($biopsia->histopatologico_imagenes5))
                                    <p><a href="{{asset($biopsia->histopatologico_imagenes5)}}" target="_blank">Imagen 5</a></p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Titulo 5</label>
                                <input type="text" name="histopatologico_nombre5" class="form-control" value="{{@old('histopatologico_nombre5', $biopsia->histopatologico_nombre5)}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="histopatologico_imagenes6">Imagen 6</label>
                                <input type="file" class="form-control form-sin-border" name="histopatologico_imagenes6" />
                                @if($biopsia && !empty($biopsia->histopatologico_imagenes6))
                                    <p><a href="{{asset($biopsia->histopatologico_imagenes6)}}" target="_blank">Imagen 6</a></p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Titulo 6</label>
                                <input type="text" name="histopatologico_nombre6" class="form-control" value="{{@old('histopatologico_nombre6', $biopsia->histopatologico_nombre6)}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="histopatologico_imagenes7">Imagen 7</label>
                                <input type="file" class="form-control form-sin-border" name="histopatologico_imagenes7" />
                                @if($biopsia && !empty($biopsia->histopatologico_imagenes7))
                                    <p><a href="{{asset($biopsia->histopatologico_imagenes7)}}" target="_blank">Imagen 7</a></p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Titulo 7</label>
                                <input type="text" name="histopatologico_nombre7" class="form-control" value="{{@old('histopatologico_nombre7', $biopsia->histopatologico_nombre7)}}">
                            </div>
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label for="organo_tejido">ÓRGANO Y TEJIDO</label>
                    <input type="text" name="organo_tejido" id="ta-organo_tejido" class="form-control" value="{{@old('organo_tejido', $analisis->region)}}" required>
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
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            tinymce.init({
                selector: '#ta-macroscopia',
                toolbar: "undo redo | bold italic | link image | underline",
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
                @cannot('manage-users-all') readonly : 1 @endcannot
            });
            tinymce.init({
                selector: '#ta-microscopia',
                toolbar: "undo redo | bold italic | link image | underline",
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
                @cannot('manage-users-dr') readonly : 1 @endcannot
            });
            tinymce.init({
                selector: '#ta-diagnostico',
                toolbar: "undo redo | bold italic | link image | underline",
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
