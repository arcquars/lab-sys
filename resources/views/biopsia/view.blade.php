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
            <h5 class="h5-cito-titulo">INFORME HISTOPATOLOGICO</h5>
        </div>
        <div class="card-body">
            @include('citologia.partial.cliente-head', ['analisis' => $analisis])
            <hr>
            <div class="row">
                <div class="col-md-3">
                    @if (isset($biopsia->imagen1))
                        <img src="{{asset($biopsia->imagen1)}}" width="100%">
                    @endif
                </div>
                <div class="col-md-3">
                    @if (isset($biopsia->imagen2))
                        <img src="{{asset($biopsia->imagen2)}}" width="100%">
                    @endif
                </div>
                <div class="col-md-3">
                    @if (isset($biopsia->imagen3))
                        <img src="{{asset($biopsia->imagen3)}}" width="100%">
                    @endif
                </div>
                <div class="col-md-3">
                    @if (isset($biopsia->imagen4))
                        <img src="{{asset($biopsia->imagen4)}}" width="100%">
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 text-center">
                    @if (isset($biopsia->titulo_1))
                        <h5>({{$biopsia->titulo_1}})</h5>
                    @endif
                </div>
                <div class="col-md-3 text-center">
                    @if (isset($biopsia->titulo_2))
                        <h5>({{$biopsia->titulo_2}})</h5>
                    @endif
                </div>
                <div class="col-md-3 text-center">
                    @if (isset($biopsia->titulo_3))
                        <h5>({{$biopsia->titulo_3}})</h5>
                    @endif
                </div>
                <div class="col-md-3 text-center">
                    @if (isset($biopsia->titulo_4))
                        <h5>({{$biopsia->titulo_4}})</h5>
                    @endif
                </div>
            </div>
            @if ($biopsia->is_histopatologico)
                <hr>
                <h5>Imagenes Histopatologicos</h5>
                <div class="row">
                    <div class="col-md-2">
                        @if (isset($biopsia->histopatologico_imagenes1))
                            <img src="{{asset($biopsia->histopatologico_imagenes1)}}" width="100%">
                        @endif
                        @if (isset($biopsia->histopatologico_nombre1))
                            <h5>({{$biopsia->histopatologico_nombre1}})</h5>
                        @endif
                    </div>
                    <div class="col-md-2">
                        @if (isset($biopsia->histopatologico_imagenes2))
                            <img src="{{asset($biopsia->histopatologico_imagenes2)}}" width="100%">
                        @endif
                        @if (isset($biopsia->histopatologico_nombre2))
                            <h5>({{$biopsia->histopatologico_nombre2}})</h5>
                        @endif
                    </div>
                    <div class="col-md-2">
                        @if (isset($biopsia->histopatologico_imagenes3))
                            <img src="{{asset($biopsia->histopatologico_imagenes3)}}" width="100%">
                        @endif
                        @if (isset($biopsia->histopatologico_nombre3))
                            <h5>({{$biopsia->histopatologico_nombre3}})</h5>
                        @endif
                    </div>
                    <div class="col-md-2">
                        @if (isset($biopsia->histopatologico_imagenes4))
                            <img src="{{asset($biopsia->histopatologico_imagenes4)}}" width="100%">
                        @endif
                        @if (isset($biopsia->histopatologico_nombre4))
                            <h5>({{$biopsia->histopatologico_nombre4}})</h5>
                        @endif
                    </div>
                    <div class="col-md-2">
                        @if (isset($biopsia->histopatologico_imagenes5))
                            <img src="{{asset($biopsia->histopatologico_imagenes5)}}" width="100%">
                        @endif
                        @if (isset($biopsia->histopatologico_nombre5))
                            <h5>({{$biopsia->histopatologico_nombre5}})</h5>
                        @endif
                    </div>
                    <div class="col-md-2">
                        @if (isset($biopsia->histopatologico_imagenes6))
                            <img src="{{asset($biopsia->histopatologico_imagenes6)}}" width="100%">
                        @endif
                        @if (isset($biopsia->histopatologico_nombre6))
                            <h5>({{$biopsia->histopatologico_nombre6}})</h5>
                        @endif
                    </div>
                    <div class="col-md-2">
                        @if (isset($biopsia->histopatologico_imagenes7))
                            <img src="{{asset($biopsia->histopatologico_imagenes7)}}" width="100%">
                        @endif
                        @if (isset($biopsia->histopatologico_nombre7))
                            <h5>({{$biopsia->histopatologico_nombre7}})</h5>
                        @endif
                    </div>
                </div>



            @endif
            <div class="row row-biopsia">
                <div class="col-md-12 form-group">
                    <label>MACROSCOPIA:</label>
                    <div>
                        {!! $biopsia->macroscopia !!}
                    </div>
                </div>
            </div>
            <div class="row row-biopsia">
                <div class="col-md-12 form-group">
                    <label>MICROSCOPIA:</label>
                    <div>
                        {!! $biopsia->microscopia !!}
                    </div>
                </div>
            </div>
            <div class="row row-biopsia">
                <div class="col-md-12 form-group">
                    <label>DIAGNISTICO:</label>
                    <div>
                        {!! $biopsia->diagnostico !!}
                    </div>
                </div>
            </div>
            <div style="height: 8px;"></div>
            <div class="row">
                <div class="col-md-12" style="text-align: right;">
                    @can('manage-users-dr')
                    <a href="{{route('biopsia.reporte', ['analisisId' => $analisis->id])}}" target="_blank" class="btn btn-warning">Imprimir</a>
                    @endcan
                    <a href="{{route('biopsia.crear', ['analisisId' => $analisis->id, 'is_histopatologico' => $biopsia->is_histopatologico])}}" class="btn btn-primary">Editar</a>
                    <a href="{{url()->previous()}}" class="btn btn-dark">Atras</a>
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