@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Resultado Bethesda', 'navName' => 'Resultado Bethesda', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Bethesda</a></li>
            <li class="breadcrumb-item">Detalle Analisis Bethesda</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h5 class="h5-cito-titulo">INFORME CITOLOGICO - SISTEMA BETHESDA</h5>
        </div>
        <div class="card-body">
            @include('citologia.partial.cliente-head', ['analisis' => $analisis])
            <hr>
            <label class="label-clinica">CALIDAD DE LA MUESTRA:</label>
            <div class="row">
                <div class="col-md-12">
                    <p>{{$bethesda->calidad_muestra}}</p>
                </div>
            </div>
            <label class="label-clinica">CLASIFICACION GENERAL:</label>
            <div class="row">
                <div class="col-md-12">
                    <p>{{$bethesda->clasificacion_general}}</p>
                </div>
            </div>
            @if ($interpretaciones)

            <label class="label-clinica">INTERPRETACION / RESULTADOS:</label>
            <div class="row">
                @foreach ($interpretaciones as $key => $value)
                    <div class="col-md-12">
                        <p><i class="far fa-check-square"></i> {{$key}} - {{$value}}</p>
                    </div>
                @endforeach
            </div>
            @endif
            <hr>
            <label class="label-clinica">FLORA:</label>
            <div class="row">
                @foreach ($celulasObservadas as $key => $value)
                    <div class="col-md-4">
                        <p><i class="far fa-check-square"></i> {{$value}}</p>
                    </div>
                @endforeach
            </div>
            <label class="label-clinica">OBSERVACIONES:</label>
            <div class="row">
                <div class="col-md-12">
                    <p>{{$bethesda->observaciones}}</p>
                </div>
            </div>
            <div style="height: 8px;"></div>
            <div class="row">
                <div class="col-md-12" style="text-align: right;">
                    @can('manage-users-dr')
                        <a href="{{route('bethesda.reporte', ['analisisId' => $analisis->id])}}" target="_blank" class="btn btn-warning">Imprimir</a>
                    @endcan
                    <a href="{{route('bethesda.crear', ['analisisId' => $analisis->id])}}" class="btn btn-primary">Editar</a>
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