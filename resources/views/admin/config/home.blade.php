@extends('layouts.dash', ['activePage' => 'admin_config', 'title' => 'Configuracion', 'navName' => 'Configuracion del Sistema', 'activeButton' => 'adminactiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Administracion</li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{route('admin.users.index')}}">Configuración</a></li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.config.save') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="formGroupExampleInput">Método</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input 
                                class="form-check-input" 
                                type="radio" 
                                name="metodo" 
                                id="m-free" 
                                value="1"
                                @if(strcmp($metodo, "1") == 0) checked @endif
                            >
                            <label class="form-check-label" for="m-free" >Libre</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input 
                                class="form-check-input" 
                                type="radio" 
                                name="metodo" 
                                id="m-select" 
                                value="2"
                                @if(strcmp($metodo, "1") != 0) checked @endif
                            >
                            <label class="form-check-label" for="m-select">Selección</label>
                        </div>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary btn-sm">Grabar</button>
                </div>
            </form>
        </div>
        


    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

    </script>
@endpush
