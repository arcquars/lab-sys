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
                    <input type="date" name="fecha_ini" class="form-control" value="{{old('fecha_ini', $fecha_ini)}}" >
                    @error('fecha_ini')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <input type="date" name="fecha_fin" class="form-control" value="{{old('fecha_fin', $fecha_fin)}}" >
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
        <h5>Total Resultados: {{ count($biopsias) + count($histoquimicas) + count($liquidos) + count($bethesdas) + count($citologias) }}</h5>
        <table class="table table-bordered table-clinica">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Analisis</th>
                <th scope="col">Codigo</th>
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
                <td>{{ \Carbon\Carbon::parse($biopsia->analisis->fecha)->format('Y-m-d') }}</td>
                <td>{{ $biopsia->analisis->tipo_analisis }}</td>
                <td>{{ $biopsia->analisis->codigo }}</td>
                <td>{{ $biopsia->analisis->person->nombres . ' ' . $biopsia->analisis->person->apellidos }}</td>
                <td>{{ $biopsia->analisis->edad }}</td>
                <td>{{ $biopsia->analisis->person->sexo }}</td>
                <td>{!! (strlen($biopsia->diagnostico) < 150)? strip_tags($biopsia->diagnostico) : substr(strip_tags($biopsia->diagnostico), 0, 150).'...' !!}</td>
                <td style="text-align: center;">
                    <a href="{{ route('biopsia.viewResultado', ['analisisId' => $biopsia->analisis->id]) }}" class="btn btn-link btn-clinica" title="Ver Resultados">
                        <i class="far fa-eye"></i>
                    </a>
                </td>
            </tr>
            @endforeach

            @foreach($histoquimicas as $histoquimica)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($histoquimica->analisis->fecha)->format('Y-m-d') }}</td>
                    <td>{{ $histoquimica->analisis->tipo_analisis }}</td>
                    <td>{{ $histoquimica->analisis->codigo }}</td>
                    <td>{{ $histoquimica->analisis->person->nombres . ' ' . $histoquimica->analisis->person->apellidos }}</td>
                    <td>{{ $histoquimica->analisis->edad }}</td>
                    <td>{{ $histoquimica->analisis->person->sexo }}</td>
                    <td>{!! (strlen($histoquimica->interpretacion) < 150)? strip_tags($histoquimica->interpretacion) : substr(strip_tags($histoquimica->interpretacion), 0, 150).'...' !!}</td>
                    <td style="text-align: center;">
                        <a href="{{ route('histo.viewResultado', ['analisisId' => $histoquimica->analisis->id]) }}" class="btn btn-link btn-clinica" title="Ver Resultados">
                            <i class="far fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach

            @foreach($liquidos as $liquido)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($liquido->analisis->fecha)->format('Y-m-d') }}</td>
                    <td>{{ $liquido->analisis->tipo_analisis }}</td>
                    <td>{{ $liquido->analisis->codigo }}</td>
                    <td>{{ $liquido->analisis->person->nombres . ' ' . $liquido->analisis->person->apellidos }}</td>
                    <td>{{ $liquido->analisis->edad }}</td>
                    <td>{{ $liquido->analisis->person->sexo }}</td>
                    <td>{!! (strlen($liquido->diagnostico) < 150)? strip_tags($liquido->diagnostico) : substr(strip_tags($liquido->diagnostico), 0, 150).'...' !!}</td>
                    <td style="text-align: center;">
                        <a href="{{ route('liquidos.viewResultado', ['analisisId' => $liquido->analisis->id]) }}" class="btn btn-link btn-clinica" title="Ver Resultados">
                            <i class="far fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach

            @foreach($bethesdas as $bethesda)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($bethesda->analisis->fecha)->format('Y-m-d') }}</td>
                    <td>{{ $bethesda->analisis->tipo_analisis }}</td>
                    <td>{{ $bethesda->analisis->codigo }}</td>
                    <td>{{ $bethesda->analisis->person->nombres . ' ' . $bethesda->analisis->person->apellidos }}</td>
                    <td>{{ $bethesda->analisis->edad }}</td>
                    <td>{{ $bethesda->analisis->person->sexo }}</td>
                    <td>{!! (strlen($bethesda->showInterpretaciones()) < 150)? strip_tags($bethesda->showInterpretaciones()) : substr(strip_tags($bethesda->showInterpretaciones()), 0, 150).'...' !!}</td>
                    <td style="text-align: center;">
                        <a href="{{ route('bethesda.viewResultado', ['analisisId' => $bethesda->analisis->id]) }}" class="btn btn-link btn-clinica" title="Ver Resultados">
                            <i class="far fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach

            @foreach($citologias as $citologia)
                @php
                $resultCito = $citologia->showSeccionByType('EXTENDIDO COMPATIBLE CON LOS DIAGNOSTICOS');
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($citologia->analisis->fecha)->format('Y-m-d') }}</td>
                    <td>{{ $citologia->analisis->tipo_analisis }}</td>
                    <td>{{ $citologia->analisis->codigo }}</td>
                    <td>{{ $citologia->analisis->person->nombres . ' ' . $citologia->analisis->person->apellidos }}</td>
                    <td>{{ $citologia->analisis->edad }}</td>
                    <td>{{ $citologia->analisis->person->sexo }}</td>
                    <td>{!! (strlen($resultCito) < 150)? strip_tags($resultCito) : substr(strip_tags($resultCito), 0, 150).'...' !!}</td>
                    <td style="text-align: center;">
                        <a href="{{ route('citologia.viewResultado', ['analisisId' => $citologia->analisis->id]) }}" class="btn btn-link btn-clinica" title="Ver Resultados">
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
