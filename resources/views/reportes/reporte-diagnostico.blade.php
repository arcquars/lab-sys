@extends('layouts.dash', ['activePage' => 'admin_reporte_diagnostico', 'title' => 'Reporte Diagnostico', 'navName' => 'Reporte Diagnostico', 'activeButton' => 'reporteActiveButton'])

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
        <form id="f_reporte_admin_d" method="post" action="/reportes/reporte-diagnostico">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-2">
                    <label for="fecha_inicio">Fecha inicio</label>
                </div>
                <div class="col-md-2">
                    <label for="fecha_fin">Fecha fin</label>
                </div>
                <div class="col-md-3">
                    <label for="fecha_ingreso">Diagnóstico</label>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-3"></div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <input type="date" name="fecha_ini" class="form-control" value="{{old('fecha_ini', $fecha_ini)}}" required>
                    @error('fecha_ini')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <input type="date" name="fecha_fin" class="form-control" value="{{old('fecha_fin', $fecha_fin)}}" required>
                    @error('fecha_fin')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <input type="text" name="diagnostico" class="form-control" value="{{$diagnostico}}">
                </div>
                <div class="col-md-5">
                    <input type="submit" value="Buscar" class="btn btn-info">
                </div>
            </div>
        </form>
        <br>
        <h4>Total Resultados: {{ count($biopsias) }}</h4>
        <table class="table table-bordered table-clinica">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Nombres</th>
                <th scope="col">Edad</th>
                <th scope="col">Sexo</th>
                <th scope="col">Diagnóstico</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($biopsias as $biopsia)
            <tr>
                <td>{{ \Carbon\Carbon::parse($biopsia->analisis->fecha)->format('yy-m-d') }}</td>
                <td>{{ $biopsia->analisis->person->nombres . ' ' . $biopsia->analisis->person->apellidos }}</td>
                <td>{{ $biopsia->analisis->person->edad }}</td>
                <td>{{ $biopsia->analisis->person->sexo }}</td>
                <td>{!! (strlen($biopsia->diagnostico) < 150)? strip_tags($biopsia->diagnostico) : substr(strip_tags($biopsia->diagnostico), 0, 150).'...' !!}</td>
                <td style="text-align: center;">
                    <a href="{{ route('biopsia.viewResultado', ['analisisId' => $biopsia->analisis->id]) }}" class="btn btn-link btn-clinica" title="Ver Resultados">
                        <i class="far fa-eye"></i>
                    </a>
                </td>
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