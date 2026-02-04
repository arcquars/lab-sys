@extends('layouts.dash', ['activePage' => 'admin_methods', 'title' => 'Gestión de Métodos', 'navName' => 'Métodos de Análisis', 'activeButton' => 'adminactiveButton'])

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">Métodos de Laboratorio</h4>
                    <p class="card-category">Lista de métodos utilizados en los resultados de análisis</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('methods.store') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Nombre del nuevo método (Ej: ELISA, Automatizado...)" required>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Añadir Método</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="text-primary">
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Creado por</th>
                                <th class="text-right">Acciones</th>
                            </thead>
                            <tbody>
                                @foreach($methods as $method)
                                <tr>
                                    <td>{{ $method->id }}</td>
                                    <td>
                                        <form action="{{ route('methods.update', $method->id) }}" method="POST" id="form-edit-{{ $method->id }}">
                                            @csrf @method('PUT')
                                            <input type="text" name="name" class="form-control" value="{{ $method->name }}">
                                        </form>
                                    </td>
                                    <td>{{ $method->user->name ?? 'N/A' }}</td>
                                    <td class="td-actions text-right">
                                        <button type="submit" form="form-edit-{{ $method->id }}" class="btn btn-success btn-link" title="Guardar Cambios">
                                            <i class="fa fa-save"></i>
                                        </button>
                                        <form action="{{ route('methods.destroy', $method->id) }}" method="POST" style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-link" onclick="return confirm('¿Eliminar este método?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection