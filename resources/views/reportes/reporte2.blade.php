@extends('layouts.dash', ['activePage' => 'admin_reporte2', 'title' => 'Administracion', 'navName' => 'Administracion', 'activeButton' => 'reporteActiveButton'])
@php
$t_CitologiaTotal = 0;
$t_BiopsiaTotal = 0;
$t_InmunoTotal = 0;
$t_Acuenta = 0;
$t_PagoEfectuado = 0;
$t_Ingreso = 0;
@endphp
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
            <form method="post" action="/reportes/reporte2">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-3">
                        <label for="fecha_inicio">Fecha de Inicio</label>
                    </div>
                    <div class="col-md-3">
                        <label for="fecha_fin">Fecha de Fin</label>
                    </div>
                    <div class="col-md-3">
                        <label for="procedencia">Procedencia</label>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <input type="date" name="fechaIni" class="form-control @error('fechaIni') is-invalid @enderror" value="{{$fechaIni}}">
                        @error('fechaIni')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="fechaFin" class="form-control @error('fechaFin') is-invalid @enderror" value="{{old('fechaFin', $fechaFin)}}">
                        @error('fechaFin')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
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
                        <th scope="col">Fecha</th>
                        <th scope="col">{{\App\Analisis::CITOLOGIA}}</th>
                        <th scope="col">{{\App\Analisis::BIOPSIA}}</th>
                        <th scope="col">{{\App\Analisis::INMUNOHISTOQUIMICA}}</th>
                        <th scope="col">Acuenta</th>
                        <th scope="col">Pago Efectuado</th>
                        <th scope="col">Ingreso</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($reporte_2 as $reporte)
                            @phpe
                                $t_CitologiaTotal += $reporte->getCitologiaTotal();
                                $t_BiopsiaTotal += $reporte->getBiopsiaTotal();
                                $t_InmunoTotal += $reporte->getInmunoTotal();
                                $t_Acuenta += $reporte->getAcuenta();
                                $t_PagoEfectuado += $reporte->getPagoEfectuado();
                                $t_Ingreso += $reporte->getIngreso();
                            @endphp
                            <tr>
                                <td>{{$reporte->getFecha()->format('Y-m-d')}}</td>
                                <td>{{$reporte->getCitologiaTotal()}}</td>
                                <td>{{$reporte->getBiopsiaTotal()}}</td>
                                <td>{{$reporte->getInmunoTotal()}}</td>
                                <td>{{$reporte->getAcuenta()}}</td>
                                <td>{{$reporte->getPagoEfectuado()}}</td>
                                <td>{{$reporte->getIngreso()}}</td>
                            </tr>
                        @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td>Totales</td>
                    <td>{{$t_CitologiaTotal}}</td>
                    <td>{{$t_BiopsiaTotal}}</td>
                    <td>{{$t_InmunoTotal}}</td>
                    <td>{{$t_Acuenta}}</td>
                    <td>{{$t_PagoEfectuado}}</td>
                    <td>{{$t_Ingreso}}</td>
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