@extends('layouts.dash', ['activePage' => 'analisis', 'title' => \App\Analisis::BIOPSIA_DE_RINON, 'navName' => \App\Analisis::BIOPSIA_DE_RINON, 'activeButton' => 'analisisActiveButton'])

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container .select2-selection--single {
            height: 38px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 34px;
        }
        a.disabled {
            color: #2a2a2a;
            pointer-events: none;
        }
    </style>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item">Crear {{\App\Analisis::BIOPSIA_DE_RINON}}</li>

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
                    @foreach ($errors->get('region') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
            </ul>
            <form action="{{url('/histo/save')}}" method="post" enctype="multipart/form-data" target="_blank">
                {{ csrf_field() }}
                <input type="hidden" name="analisis_id" value="{{$analisis->id}}">
                <input type="hidden" name="histo_id" value="{{$histo ? $histo->id : ''}}">

                <div class="form-group">
                    <label for="organo_tejido">Región <span style="color: red">*</span></label>
{{--                    <input type="text" class="form-control" name="region" id="ta-region" value="{{@old('region', $analisis ? $analisis->region : '')}}">--}}
                    <textarea name="region" id="ta-region" class="form-control">{{@old('region', $analisis ? $analisis->region : '')}}</textarea>
                </div>

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
                <div class="row">
                    <div class="col-md-6">

                        <a href="#" onclick="openMdlMarcador(); return false;" class="@if(!isset($histo)) disabled @endif">
                            <i class="fas fa-plus-circle fa-2x"></i>
                        </a>
                        <label>Añadir Marcado</label>
                    </div>
                    <div class="col-md-6 form-inline d-flex flex-row-reverse">
                        <div class="form-group ">
                            <label for="ta-sizetexto">Tamaño Texto&nbsp;</label>
                            <select name="size_texto_marcadores" id="ta-sizetexto" class="form-control form-control-sm">
                                <option value="10" {{@old('size_texto_marcadores', ($histo && $histo->size_texto_marcadores == 10) ? 'selected' : '')}}>10</option>
                                <option value="12" {{@old('size_texto_marcadores', ($histo && $histo->size_texto_marcadores == 12) ? 'selected' : '')}}>12</option>
                                <option value="14" {{@old('size_texto_marcadores', ($histo && $histo->size_texto_marcadores == 14) ? 'selected' : '')}}>14</option>
                                <option value="16" {{@old('size_texto_marcadores', ($histo && $histo->size_texto_marcadores == 16) ? 'selected' : '')}}>16</option>
                                <option value="18" {{@old('size_texto_marcadores', ($histo && $histo->size_texto_marcadores == 18) ? 'selected' : '')}}>18</option>
                                <option value="20" {{@old('size_texto_marcadores', ($histo && $histo->size_texto_marcadores == 20) ? 'selected' : '')}}>20</option>
                            </select>
                        </div>
                    </div>
                </div>
                <ul id="list_marcadores" style="padding-left: 0;">
                    @if(isset($histo->marcadores))
                    @foreach($histo->marcadores as $marcador)
                        <li class="ui-state-default" style="list-style-type: none;" data-id="{{$marcador->id}}">
                            <div class="table-bordered" style="padding: 4px;">
                                <h6 class="text-primary">
                                    <a class="text-danger" href="#" onclick="removeMarcador(this, '{{$marcador->id}}');"><i class="far fa-trash-alt"></i></a>
                                    {{$marcador->nombre}}
                                </h6>
                                <div class="row">
                                    <div class="col-md-2">
                                        @if(!empty($marcador->path_image))
                                            <img src="{{ asset(\App\Marcador::PATH_IMAGE) . DIRECTORY_SEPARATOR . $marcador->path_image }}" class="img-fluid" alt="Responsive image">
                                        @endif
                                    </div>
                                    <div class="col-md-5 histo-marcador-paragram">
                                        <h7 class="text-success">Resultado</h7>
                                        {!! $marcador->resultado !!}
                                    </div>
                                    <div class="col-md-5">
                                        <h7 class="text-success">Intensidad</h7>
                                        {!! $marcador->intensidad !!}
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                    @endif
                </ul>
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

    @include('histo.partial.marcador_modal', ['markers' => $markers, 'analisis_id' => $analisis->id])

@endsection

@push('js')
    <script src=" https://cdn.jsdelivr.net/npm/underscore@1.13.6/underscore-umd-min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        var markertTemplate = _.template(
            `<% _.forEach(marcadores, function(marcador) { %>` +
            `<li class="ui-state-default" style="list-style-type: none;">` +
            `<div class="table-bordered" style="padding: 4px;">` +
            `<h6 class='text-primary'>` +
            `<a class='text-danger' href='#' onclick="removeMarcador(this, '<%= marcador.id %>');"><i class='far fa-trash-alt'></i></a>` +
            ` <%= marcador.nombre %>` +
            `</h6>` +
            `<div class="row">` +
            `<div class="col-md-2">` +
            `<% if(marcador.path_image !== '') { %>` +
            `<img src="<%= marcador.path_url %>" class="img-fluid" alt="Responsive image">` +
            `<% } %>` +
            `</div>` +
            `<div class="col-md-5 histo-marcador-paragram">` +
            `<h7 class="text-success">Resultado</h7>` +
            `<%= marcador.resultado %>` +
            `</div>` +
            `<div class="col-md-5">` +
            `<h7 class="text-success">Intensidad</h7>` +
            `<%= marcador.intensidad %>` +
            `</div>` +
            `</div>` +
            `</div>` +
            `</li>` +
            `<% }); %>`
        );

        @if ($histo)
        var numMarcadores = parseInt('{{count($histo->marcadores)}}');
        @else
        var numMarcadores = 0;
        @endif
        $(document).ready(function () {
            tinymce.init({
                selector: '#ta-region',
                plugins: "lists autoresize",
                toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify fontselect fontsizeselect | bullist numlist outdent indent | link image',
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
                @cannot('manage-users-all') readonly : 1 @endcannot
            });
            tinymce.init({
                selector: '#ta-interpretacion',
                plugins: "lists autoresize",
                toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify fontselect fontsizeselect | bullist numlist outdent indent backcolor | link image',
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
                @cannot('manage-users-all') readonly : 1 @endcannot
            });
            tinymce.init({
                selector: '#ta-tecnica',
                plugins: "lists autoresize",
                toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify fontselect fontsizeselect | bullist numlist outdent indent backcolor | link image',
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
                @cannot('manage-users-all') readonly : 1 @endcannot
            });
            tinymce.init({
                selector: '#ta-bibliografia',
                plugins: "lists autoresize",
                toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify fontselect fontsizeselect | bullist numlist outdent indent backcolor | link image',
                menubar: false,
                language: 'es',
                browser_spellcheck: true,
                @cannot('manage-users-all') readonly : 1 @endcan
            });
            @if ($histo)
            @foreach($histo->marcadores as $marcador)
            {{--$("#list_marcadores").append(addMarcadorHtml(--}}
            {{--    '{{ $marcador->nombre }}',--}}
            {{--    '{{ $marcador-> resultado }}',--}}
            {{--));--}}

            @endforeach
            @endif

            $( "#list_marcadores" ).sortable({
                update: function (event, ui){
                    let sortIds = [];
                    $.each($("#list_marcadores li"), function(index, item){
                        sortIds[index] = {'id': $(item).attr('data-id')}
                    });
                    sortMarcadores(sortIds);
                }
            });
            $( "#list_marcadores" ).disableSelection();
        });

        function reloadMarcadores(){
            $.ajax({
                url: "{{ route('marcador.ajax.get.markers') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {histo_id: '{{ (isset($histo->id))? $histo->id : -1 }}'},
                success: function (data) {
                    if(data.result){
                        $("#list_marcadores").empty().append(markertTemplate({marcadores: data.marcadores}));
                    } else {
                        alert("Ocurrio un problema al eliminar el marcador, por favor contactece con el administrador.");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest.responseJSON.errors);
                }
            });
        }

        function removeMarcador(link, marcadorId){
            $.ajax({
                url: "{{ route('marcador.ajax.delete') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {marcadorId},
                success: function (data) {
                    if(data.result){
                        reloadMarcadores();
                    } else {
                        alert("Ocurrio un problema al eliminar el marcador, por favor contactece con el administrador.");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest.responseJSON.errors);
                }
            });
        }

        function sortMarcadores(ids){
            $.ajax({
                url: "{{ route('marcador.ajax.sort.markers') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {ids: ids},
                success: function (data) {
                    if(data.result){
                        // alert("se ordeno correctamente...");
                    } else {
                        alert("Ocurrio un problema al eliminar el marcador, por favor contactece con el administrador.");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest.responseJSON.errors);
                }
            });
        }
    </script>
@endpush
