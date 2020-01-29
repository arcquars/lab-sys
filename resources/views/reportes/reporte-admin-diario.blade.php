@extends('layouts.dash', ['activePage' => 'admin_reporte_admin_diario', 'title' => 'Reporte Admin dia', 'navName' => 'Reporte admin dia', 'activeButton' => 'reporteActiveButton'])

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
        <li class="breadcrumb-item">Reportes</li>
        <li class="breadcrumb-item">Admin diario</li>

    </ol>
</nav>
<div class="card">
    <div class="card-header">
    </div>
    <div class="card-body">
        <form method="post" action="/reportes/reporte-admin-diario">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-2">
                    <label for="fecha_fin">Mes</label>
                </div>
                <div class="col-md-2">
                    <label for="fecha_fin">Anio</label>
                </div>
                <div class="col-md-4">
                    <label for="fecha_ingreso">Institucion</label>
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <select name="mes" id="mes" class="form-control">
                        @foreach($meses as $key => $value)
                            @if ($key == $mes)
                                <option value="{{$key}}" selected>{{$value}}</option>
                            @else
                                <option value="{{$key}}">{{$value}}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('mes')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <select name="year" id="year" class="form-control">
                        @while($year_old <= $year)
                            @if($year_old == $year_select)
                                <option value="{{$year_old}}" selected>{{$year_old}}</option>
                            @else
                                <option value="{{$year_old}}">{{$year_old}}</option>
                            @endif

                            @php
                            $year_old++;
                            @endphp
                        @endwhile
                    </select>
                    @error('mes')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
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
        <dl class="row row-citologia">
            <dt class="col-md-6"><b>Fecha Inicio:</b> <span>{{$fecha_ini}}</span></dt>
            <dt class="col-md-6"><b>Fecha Fin:</b> <span>{{$fecha_fin}}</span></dt>
        </dl>
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
                <th scope="col">A cuenta</th>
                <th scope="col">Debe</th>
                <th scope="col">Empresa</th>
            </tr>
            </thead>
            <tbody>
            @foreach($analisis as $analisi)
            <tr>
                <td>{{$analisi->fecha}}</td>
                <td>{{$analisi->codigo}}</td>
                <td>{{$analisi->person->nombres}} {{$analisi->person->apellidos}}</td>
                <td>{{$analisi->person->edad}}</td>
                <td>{{$analisi->doctor}}</td>
                <td>{{$analisi->region}}</td>
                <td>{{$analisi->precio}}</td>
                <td>{{$analisi->acuenta}}</td>
                <td>{{$analisi->precio - $analisi->acuenta}}</td>
                <td>{{ $analisi->institucion->nombre }}</td>
            </tr>
            @endforeach
            </tbody>
{{--            <tfoot>--}}
{{--            <tr>--}}
{{--                <td></td>--}}
{{--                <td></td>--}}
{{--                <td></td>--}}
{{--                <td></td>--}}
{{--                <td></td>--}}
{{--                <td></td>--}}
{{--                <td></td>--}}
{{--                <td></td>--}}
{{--                <td></td>--}}
{{--            </tr>--}}
{{--            </tfoot>--}}
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