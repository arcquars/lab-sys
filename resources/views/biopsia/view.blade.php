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
            <div class="row row-biopsia">
                <div class="col-md-12 form-group">
                    <label>Organo o Tejido:</label>
                    <div>
                        {!! $biopsia->organo_tejido !!}
                    </div>
                </div>
            </div>
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
                    <a href="{{route('biopsia.crear', ['analisisId' => $analisis->id])}}" class="btn btn-primary">Editar</a>
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