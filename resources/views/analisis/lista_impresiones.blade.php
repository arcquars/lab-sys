@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Administrar Analisis', 'navName' => 'Analisis', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ URL::previous() }}">Analisis</a></li>
            <li class="breadcrumb-item">Lista impresiones</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body ">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Fecha Impresion</th>
                    <th>Usuario</th>
                </tr>
                </thead>
                <tbody>
                @foreach($impresionesControl as $impresion)
                    <tr>
                        <td>{{ $impresion->created_at }}</td>
                        <td>{{ $impresion->user->name }}</td>
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