@extends('layouts.dash', ['activePage' => 'clients', 'title' => 'Eliminar Clientes duplicados', 'navName' => 'Clientes', 'activeButton' => 'clientActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Clientes</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-body">
            <form action="{{url('/clients/delete-duplicados')}}" method="post">
            {{ csrf_field() }}
                <div class="form-group">
                    <label for="ides">Ids clientes</label>
                    <input type="text" name="ids" class="form-control form-control-sm">
                    <p class="text-success">Ids separados por coma sin espacio(34,54,554)</p>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Ejecutar</button>
            </form>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function () {

        });
    </script>
@endpush