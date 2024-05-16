@extends('layouts.dash', ['activePage' => 'dashboard', 'title' => 'Tablero', 'navName' => 'Tablero', 'activeButton' => 'laravel'])

@section('content')
    <br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style="text-align: center;">
                    <h4>{{ config('clinica.nombre') }}</h4>
                </div>

                <div class="card-body" style="text-align: center;">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>Bienvenido al Sistema de control de análisis</p>
                        @can('manage-admin')
                    @include('reportes.partials._graficos', ['dateI' =>$dateI, 'dateF' => $dateF])
                            @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
