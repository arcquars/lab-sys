@extends('layouts.dash', ['activePage' => 'admin_reporte_admin_diario_convenio', 'title' => 'Reporte Convenio', 'navName' => 'Reporte Convenio', 'activeButton' => 'reporteActiveButton'])

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
        <form id="f_reporte_admin_d" method="post" action="/reportes/reporte-admin-diario-convenio">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-3">
                    <label for="fecha_inicio">Fecha inicio</label>
                </div>
                <div class="col-md-3">
                    <label for="fecha_fin">Fecha fin</label>
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
                <th scope="col">Institucion</th>
                <th scope="col">Matricula</th>
                <th scope="col">PreAfiliacion</th>
            </tr>
            </thead>
            <tbody>
            @foreach($convenios as $convenio)
            <tr>
                <td>{{$convenio->analisis->fecha}}</td>
                <td>{{$convenio->analisis->codigo}}</td>
                <td>{{$convenio->analisis->person->nombres}} {{$convenio->analisis->person->apellidos}} {{$convenio->analisis->person->apellido_materno}}</td>
                <td>{{$convenio->analisis->person->edad}}</td>
                <td>{{$convenio->analisis->doctor}}</td>
                <td>{{$convenio->analisis->region}}</td>
                <td>{{$convenio->analisis->precio}}</td>
                <td>{{$convenio->analisis->institucion->nombre}}</td>
                <td>{{$convenio->bancaMatricula}}</td>
                <td>{{$convenio->bancaPreAfiliacion}}</td>
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
        var url = '{{url("/")}}/reportes/reporte-admin-diario-convenio/'+fechaIni+'/'+fechaFin;

        window.open(url, '_blank');
    }
</script>
@endpush