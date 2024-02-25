@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Administrar Analisis', 'navName' => 'Analisis', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ URL::previous() }}">Analisis</a></li>
            <li class="breadcrumb-item">Lista Cambios</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body ">
            <div class="row">
                <div class="col-md-6">
                    <dl class="pl-3">
                        <dt>Análisis creado por:</dt>
                        <dd>{{ $user->name }} ({{ $user->email }})</dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="pl-3">
                        <dt>Código de analisis:</dt>
                        <dd>{{ $analisis->codigo }}</dd>
                    </dl>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Fecha Impresion</th>
                    <th>Usuario</th>
                </tr>
                </thead>
                <tbody>
                @foreach($editarControl as $editar)
                    <tr>
                        <td>{{ $editar->created_at }}</td>
                        <td>{{ $editar->user->name }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>

            <a class="btn btn-dark" href="{{ URL::previous() }}">Atras</a>
        </div>
    </div>


@endsection

@push('js')
    <script>
        $(document).ready(function () {


        });

    </script>
@endpush
