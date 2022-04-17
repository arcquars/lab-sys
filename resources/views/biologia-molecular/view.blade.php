@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Resultado Analisis', 'navName' => 'Resultado Analisis', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">{{ __('clinica_msg.'.\App\Analisis::BIOLOGIA_MOLECULAR)}}</a></li>
            <li class="breadcrumb-item">Detalle Analisis {{ __('clinica_msg.'.\App\Analisis::BIOLOGIA_MOLECULAR)}}</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h5 class="h5-cito-titulo">INFORME {{ __('clinica_msg.'.\App\Analisis::BIOLOGIA_MOLECULAR)}}</h5>
        </div>
        <div class="card-body">
            @include('citologia.partial.cliente-head', ['analisis' => $analisis])
            <hr>
            <div class="row row-biopsia">
                <div class="col-md-12 form-group">
                    <label>Interpretacion:</label>
                    <div>
                        {!! $biologia->interpretacion!!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    @if (isset($biologia->imagen1))
                        <img src="{{asset($biologia->imagen1)}}" width="100%">
                    @endif
                </div>
                <div class="col-md-3">
                    @if (isset($biologia->imagen2))
                        <img src="{{asset($biologia->imagen2)}}" width="100%">
                    @endif
                </div>
                <div class="col-md-3">
                    @if (isset($biologia->imagen3))
                        <img src="{{asset($biologia->imagen3)}}" width="100%">
                    @endif
                </div>
                <div class="col-md-3">
                    @if (isset($biologia->imagen4))
                        <img src="{{asset($biologia->imagen4)}}" width="100%">
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 text-center">
                    @if (isset($biologia->titulo_1))
                        <h5>({{$biologia->titulo_1}})</h5>
                    @endif
                </div>
                <div class="col-md-3 text-center">
                    @if (isset($biologia->titulo_2))
                        <h5>({{$biologia->titulo_2}})</h5>
                    @endif
                </div>
                <div class="col-md-3 text-center">
                    @if (isset($biologia->titulo_3))
                        <h5>({{$biologia->titulo_3}})</h5>
                    @endif
                </div>
                <div class="col-md-3 text-center">
                    @if (isset($biologia->titulo_4))
                        <h5>({{$biologia->titulo_4}})</h5>
                    @endif
                </div>
            </div>


            <div class="row row-biopsia">
                <div class="col-md-12 form-group">
                    <label>TECNICA:</label>
                    <div>
                        {!! $biologia->tecnica!!}
                    </div>
                </div>
            </div>
            <div class="row row-biopsia">
                <div class="col-md-12 form-group">
                    <label>Bibliografia:</label>
                    <div>
                        {!! $biologia->bibliografia !!}
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <label>Marcadores:</label>
                    <div>
                        @foreach($biologia->marcadores as $marcador)
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="text-primary" style="font-size: 12px;">{{$marcador->nombre}}</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-muted">{{$marcador->resultado}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div style="height: 8px;"></div>
            <div class="row">
                <div class="col-md-12" style="text-align: right;">
                    @can('manage-users-dr')
                    <a href="{{route('biologiam.reporte', ['analisisId' => $analisis->id])}}" target="_blank" class="btn btn-warning">Imprimir</a>
                    @endcan
                    <a href="{{route('biologiam.crear', ['analisisId' => $analisis->id])}}" class="btn btn-primary">Editar</a>
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
