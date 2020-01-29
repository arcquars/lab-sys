@extends('layouts.dash', ['activePage' => 'admin_reporte_diario', 'title' => 'Reporte por dia', 'navName' => 'Reporte por dia', 'activeButton' => 'reporteActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Reportes</li>
            <li class="breadcrumb-item">Cobros X Dia</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form method="post" action="/reportes/reporte-diario">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-3">
                        <label for="fecha_inicio">Fecha inicio</label>
                    </div>
                    <div class="col-md-3">
                        <label for="fecha_fin">Fecha fin</label>
                    </div>
                    <div class="col-md-3">
                        <label for="fecha_ingreso">Tipo de Analisis</label>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <input type="date" name="fecha_ini" class="form-control" value="{{old('fecha_ini', $fecha_ini)}}" >
                        @error('fecha_ini')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="fecha_fin" class="form-control" value="{{$fecha_fin}}" >
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
                        <input type="submit" value="Buscar" class="btn btn-info btn-block">
                    </div>
                </div>
            </form>
            <br>
            <table class="table table-bordered table-clinica">
                <thead class="thead-dark">
                    <tr>
                        <th>N.</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">Doctor que Pidio</th>
                        <th scope="col">Region</th>
                        <th scope="col">Tipo Estudio</th>
                        <th scope="col">Precio</th>
                        <th scope="col">A cuenta</th>
                        <th scope="col">Debe</th>
                        <th scope="col">Empresa</th>
                    </tr>
                </thead>
                <tbody>
                @php
                $i = 1;
                @endphp
                        @foreach($analisis as $analisi)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$analisi->fecha}}</td>
                                <td>{{$analisi->codigo}}</td>
                                <td>{{$analisi->person->nombres}} {{$analisi->person->apellidos}}</td>
                                <td>{{$analisi->doctor}}</td>
                                <td>{{$analisi->region}}</td>
                                <td>{{$analisi->tipo_analisis}}</td>
                                <td>{{$analisi->precio}}</td>
                                <td>{{$analisi->acuenta}}</td>
                                <td>{{$analisi->precio - $analisi->acuenta}}</td>
                                <td>{{ $analisi->institucion->nombre }}</td>
                            </tr>
                        @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>TOTALES</td>
                    <td>{{$totalPrecio}}</td>
                    <td>{{$totalAcuenta}}</td>
                    <td>{{$totalDebe}}</td>
                    <td></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function () {

        });

    </script>
@endpush