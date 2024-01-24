@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Resultado Analisis', 'navName' => 'Resultado Analisis', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Biopsia</a></li>
            <li class="breadcrumb-item">Detalle Analisis Biopsia</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h5 class="h5-cito-titulo">INFORME {{\App\Analisis::BIOPSIA_DE_RINON}}</h5>
        </div>
        <div class="card-body">
            @include('citologia.partial.cliente-head', ['analisis' => $analisis])
            <hr>
            <div class="row row-biopsia">
                <div class="col-md-12 form-group">
                    <label>Interpretacion:</label>
                    <div>
                        {!! $histo->interpretacion!!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    @if (isset($histo->imagen1))
                        <img src="{{asset($histo->imagen1)}}" width="100%">
                    @endif
                </div>
                <div class="col-md-3">
                    @if (isset($histo->imagen2))
                        <img src="{{asset($histo->imagen2)}}" width="100%">
                    @endif
                </div>
                <div class="col-md-3">
                    @if (isset($histo->imagen3))
                        <img src="{{asset($histo->imagen3)}}" width="100%">
                    @endif
                </div>
                <div class="col-md-3">
                    @if (isset($histo->imagen4))
                        <img src="{{asset($histo->imagen4)}}" width="100%">
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 text-center">
                    @if (isset($histo->titulo_1))
                        <h5>({{$histo->titulo_1}})</h5>
                    @endif
                </div>
                <div class="col-md-3 text-center">
                    @if (isset($histo->titulo_2))
                        <h5>({{$histo->titulo_2}})</h5>
                    @endif
                </div>
                <div class="col-md-3 text-center">
                    @if (isset($histo->titulo_3))
                        <h5>({{$histo->titulo_3}})</h5>
                    @endif
                </div>
                <div class="col-md-3 text-center">
                    @if (isset($histo->titulo_4))
                        <h5>({{$histo->titulo_4}})</h5>
                    @endif
                </div>
            </div>


            <div class="row row-biopsia">
                <div class="col-md-12 form-group">
                    <label>TECNICA:</label>
                    <div>
                        {!! $histo->tecnica!!}
                    </div>
                </div>
            </div>
            <div class="row row-biopsia">
                <div class="col-md-12 form-group">
                    <label>Bibliografia:</label>
                    <div>
                        {!! $histo->bibliografia !!}
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <ul class="col-md-12">
                    <label>Marcadores:</label>
                    <ul id="list_marcadores" style="padding-left: 0;">
                        @foreach($histo->marcadores as $marcador)
                            <li class="ui-state-default" style="list-style-type: none;">
                                <div class="table-bordered" style="padding: 4px;">
                                    <h6 class="text-primary">
                                        {{$marcador->nombre}}
                                    </h6>
                                    <div style="height: 5px;"></div>
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
                    </ul>
                </div>
            </div>
            <div style="height: 8px;"></div>
            <div class="row">
                <div class="col-md-12" style="text-align: right;">
                    @can('manage-users-dr')
                    <a href="{{route('histo.reporte', ['analisisId' => $analisis->id])}}" target="_blank" class="btn btn-warning">Imprimir</a>
                    @endcan
                    <a href="{{route('histo.crear', ['analisisId' => $analisis->id])}}" class="btn btn-primary">Editar</a>
                    <a href="{{route('analisis.index')}}" class="btn btn-dark">Atras</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {

        });

    </script>
@endpush
