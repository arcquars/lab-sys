@extends('layouts.dash', ['activePage' => 'admin_reporte', 'title' => 'Reporte por dia a cuenta', 'navName' => 'Reporte por dia a cuenta', 'activeButton' => 'reporteActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Reportes</li>
            <li class="breadcrumb-item">Reporte 1</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form method="post" action="/reportes/reporte1">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-5">
                        <label for="fecha_ingreso">Fecha de ingreso</label>
                    </div>
                    <div class="col-md-5">
                        <label for="fecha_ingreso">Tipo de Analisis</label>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <input type="date" name="fecha" class="form-control" value="{{$fecha}}" required>
                    </div>
                    <div class="col-md-5">
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
                    <div class="col-md-2">
                        <input type="submit" value="Buscar" class="btn btn-info btn-block">
                    </div>
                </div>
            </form>
            <br>
            <h4>A cuenta</h4>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Fecha de entrega</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">Doctor que Pidio</th>
                        <th scope="col">Institucion</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Acuenta</th>
                        <th scope="col">Pago Efectuado</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($analisis as $analisi)
                            <tr>
                                <th scope="row">{{$analisi->id}}</th>
                                <td>{{$analisi->fecha}}</td>
                                <td>{{$analisi->fecha_entrega}}</td>
                                <td>{{$analisi->person->nombres}} {{$analisi->apellidos}}</td>
                                <td>{{$analisi->doctor}}</td>
                                <td>{{$analisi->institucion->nombre}}</td>
                                <td>{{$analisi->precio}}</td>
                                <td>{{$analisi->acuenta}}</td>
                                <td>{{$analisi->pago_efectuado}}</td>
                                <td>{{ ($analisi->acuenta + $analisi->pago_efectuado) == $analisi->precio? 'Cancelado' :  'Debe '.($analisi->precio-$analisi->acuenta) }}</td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
            <h6 class="text-right">Total ingreso a cuenta: {{$totalAcuenta}}</h6>

            <h4>Pago Efectuado</h4>
            <table class="table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Fecha de entrega</th>
                    <th scope="col">Paciente</th>
                    <th scope="col">Doctor que Pidio</th>
                    <th scope="col">Institucion</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Acuenta</th>
                    <th scope="col">Pago Efectuado</th>
                    <th scope="col">Estado</th>
                </tr>
                </thead>
                <tbody>
                @foreach($analisisEfec as $analisi)
                    <tr>
                        <th scope="row">{{$analisi->id}}</th>
                        <td>{{$analisi->fecha}}</td>
                        <td>{{$analisi->fecha_entrega}}</td>
                        <td>{{$analisi->person->nombres}} {{$analisi->apellidos}}</td>
                        <td>{{$analisi->doctor}}</td>
                        <td>{{$analisi->institucion->nombre}}</td>
                        <td>{{$analisi->precio}}</td>
                        <td>{{$analisi->acuenta}}</td>
                        <td>{{$analisi->pago_efectuado}}</td>
                        <td>{{ ($analisi->acuenta + $analisi->pago_efectuado) == $analisi->precio? 'Cancelado' :  'Debe '.($analisi->precio-$analisi->acuenta) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <h6 class="text-right">Total ingreso a cuenta: {{$totalEfec}}</h6>
            <div style="height: 10px;"></div>
            <h5 class="text-right">Gran TOTAL: {{$totalAcuenta+$totalEfec}}</h5>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function () {

        });

    </script>
@endpush