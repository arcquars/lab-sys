@extends('layouts.dash', ['activePage' => 'admin_reporte_facturado', 'title' => 'Reporte Facturacion', 'navName' => 'Reporte Transacciones', 'activeButton' => 'reporteActiveButton'])

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
        <form id="f_reporte_admin_d" method="post" action="/reportes/reporte-facturacion">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-2">
                    <label for="fecha_inicio">Fecha inicio</label>
                </div>
                <div class="col-md-2">
                    <label for="fecha_fin">Fecha fin</label>
                </div>
                <div class="col-md-3">
                    <label for="fecha_ingreso">Institucion</label>
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
                    <div class="form-check" style="padding-left: 4px;">
                        <label class="form-check-label">
                            <input class="form-check-input" name="facturados" type="checkbox" value="1" @if(isset($facturados) && $facturados == 1) checked @endif>
                            <span class="form-check-sign"></span>
                            Facturados
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="submit" value="Buscar" class="btn btn-info">
                    <a class="btn btn-warning" onclick="exportExcelReporteAdmin(); return false;">Exportar</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="acuenta">Por fecha</label>
                    <br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="f_pago"
                               id="f_pago_1" value="fecha" checked>
                        <label class="form-check-label" style="padding-left: 2px !important;" for="f_pago_1">A cuenta</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="f_pago"
                               {{ (isset($fecha_pago) && strcmp($fecha_pago, 'fecha_pago_efectuado') == 0)? 'checked' : '' }}
                               id="f_pago_2" value="fecha_pago_efectuado">
                        <label class="form-check-label" style="padding-left: 2px !important;" for="f_pago_2">Saldo</label>
                    </div>
                </div>
            </div>
        </form>
        <br>
        <table class="table table-bordered table-clinica">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Fecha a cuenta</th>
                <th scope="col">Fecha saldo</th>
                <th scope="col">Codigo</th>
                <th scope="col">Paciente</th>
                <th scope="col">Precio</th>
                <th scope="col">A cuenta</th>
                <th scope="col">Tipo pago a cuenta</th>
                <th scope="col">N. cuenta a cuenta</th>
                <th scope="col">Banco a cuenta</th>
                <th scope="col">Pago saldo</th>
                <th scope="col">Tipo pago saldo</th>
                <th scope="col">N. cuenta saldo</th>
                <th scope="col">Banco saldo</th>
{{--                <th scope="col">Facturado</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($analisis as $analisi)
            <tr>
                <td>{{\Carbon\Carbon::parse($analisi->fecha)->format('Y-m-d')}}</td>
                <td>{{ ($analisi->fecha_pago_efectuado)? \Carbon\Carbon::parse($analisi->fecha_pago_efectuado)->format('Y-m-d') : '--'}}</td>
                <td>{{$analisi->codigo}}</td>
                <td>{{$analisi->person->nombres}} {{$analisi->person->apellidos}} {{$analisi->person->apellido_materno}}</td>
                <td>{{$analisi->precio}}</td>
                <td>{{$analisi->acuenta}}</td>
                <td>{{$analisi->tipo_pago_acuenta}}</td>
                <td>{{ (strcmp($analisi->tipo_pago_acuenta,  'EFECTIVO') != 0)? $analisi->acuenta_numero_tarjeta : ''}}</td>
                <td>{{ (strcmp($analisi->tipo_pago_acuenta,  'EFECTIVO') != 0)? $analisi->acuenta_banco : ''}}</td>
                <td>{{$analisi->pago_efectuado}}</td>
                <td>{{ $analisi->tipo_pago_efectuado }}</td>
                <td>{{ (strcmp($analisi->tipo_pago_efectuado,  'EFECTIVO') != 0)? $analisi->saldo_numero_tarjeta : '' }}</td>
                <td>{{ (strcmp($analisi->tipo_pago_efectuado,  'EFECTIVO') != 0)? $analisi->saldo_banco : ''}}</td>
{{--                <td>{{($analisi->facturado == 1)? 'Si' : 'No'}}</td>--}}

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
        var f_pago = $("#f_reporte_admin_d input[name='f_pago']:checked").val();
        var parametros = "?";
        parametros += "f_pago=" + f_pago;
        var url = '{{url("/")}}/reportes/reporte-facturacion-diario/'+fechaIni+'/'+fechaFin+'/'+procedencia+parametros;

        window.open(url, '_blank');
    }
</script>
@endpush
