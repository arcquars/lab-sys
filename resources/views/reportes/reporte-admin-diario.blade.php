@extends('layouts.dash', ['activePage' => 'admin_reporte_admin_diario', 'title' => 'Reporte Administracion', 'navName' => 'Reporte administracion', 'activeButton' => 'reporteActiveButton'])

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
        <li class="breadcrumb-item">Reportes</li>
        <li class="breadcrumb-item">Administracion</li>

    </ol>
</nav>
<div class="card">
    <div class="card-header">
    </div>
    <div class="card-body">
        <form id="f_reporte_admin_d" method="post" action="/reportes/reporte-admin-diario">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-3">
                    <label for="fecha_inicio">Fecha inicio</label>
                </div>
                <div class="col-md-3">
                    <label for="fecha_fin">Fecha fin</label>
                </div>
                <div class="col-md-3">
                    <label for="fecha_ingreso">Institucion</label>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <input type="date" name="fecha_ini" class="form-control" value="{{old('fecha_ini', $fecha_ini)}}" required>
                    @error('fecha_ini')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <input type="date" name="fecha_fin" class="form-control" value="{{old('fecha_fin', $fecha_fin)}}" required>
                    @error('fecha_fin')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <select name="procedencia" class="form-control">
                        <option value="0">Todos</option>
                        @foreach($procedencias as $procedencia)
                        @if ($procedenciaId == $procedencia->id)
                        <option value="{{$procedencia->id}}" selected>{{$procedencia->nombre}}</option>
                        @else
                        <option value="{{$procedencia->id}}">{{$procedencia->nombre}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="submit" value="Buscar" class="btn btn-info">
                    <a class="btn btn-warning" onclick="exportExcelReporteAdmin(); return false;">Exportar</a>
                </div>
            </div>
        </form>
        <br>
        <table class="table table-bordered table-clinica">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Codigo</th>
                <th scope="col">Paciente</th>
                <th scope="col">Edad</th>
                <th scope="col">Doctor que Pidio</th>
                <th scope="col">Region</th>
                <th scope="col">Precio</th>
            </tr>
            </thead>
            <tbody>
            @foreach($analisis as $analisi)
            <tr>
                <td>{{ \Carbon\Carbon::parse($analisi->fecha)->format('yy-m-d') }}</td>
                <td>{{$analisi->codigo}}</td>
                <td>{{$analisi->person->nombres}} {{$analisi->person->apellidos}} {{$analisi->person->apellido_materno}}</td>
                <td>{{$analisi->person->edad}}</td>
                <td>{{$analisi->doctor}}</td>
                <td>{{$analisi->region}}</td>
                <td>{{$analisi->precio}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('js')
<script>
    $(document).ready(function () {

    });

    function exportExcelReporteAdmin(){
        var fechaIni = $("#f_reporte_admin_d input[name='fecha_ini']").val();
        var fechaFin = $("#f_reporte_admin_d input[name='fecha_fin']").val();
        var procedencia = $("#f_reporte_admin_d select[name='procedencia']").val();
        var url = '{{url("/")}}/reportes/reporte-admin-diario/'+fechaIni+'/'+fechaFin+'/'+procedencia;

        window.open(url, '_blank');
    }
</script>
@endpush