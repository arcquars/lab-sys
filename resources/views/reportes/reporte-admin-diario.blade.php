@extends('layouts.dash', ['activePage' => 'admin_reporte_admin_diario', 'title' => 'Reporte Administracion', 'navName' => 'Reporte administracion', 'activeButton' => 'reporteActiveButton'])

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 38px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 34px;
        }
    </style>
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
                <div class="col-md-2">
                    <label for="fecha_inicio">Fecha inicio</label>
                </div>
                <div class="col-md-2">
                    <label for="fecha_fin">Fecha fin</label>
                </div>
                <div class="col-md-2">
                    <label for="fecha_ingreso">Doctor que pidio</label>
                </div>
                <div class="col-md-3">
                    <label for="fecha_ingreso">Institucion</label>
                </div>
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
                <div class="col-md-2">
                    <select class="form-control" name="doctor_refiere" id="js-doctor-ajax-id">
                        @if(!isset($doctor))
                            <option value="">Seleccion...</option>
                        @else
                            <option value="{{ $doctor  }}">{{ $doctor  }}</option>
                        @endif
                    </select>
                    @error('doctor_refiere')
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
                    <a class="btn btn-default" href="{{route('reporte.reporte_admin_diario')}}">Limpiar</a>
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
                <th scope="col">Institucion</th>
                <th scope="col">Region</th>
                <th scope="col">Precio</th>
                <th scope="col">Entregado</th>
                <th scope="col">Estado</th>
            </tr>
            </thead>
            <tbody>
            @foreach($analisis as $analisi)
            <tr>
                <td>{{ \Carbon\Carbon::parse($analisi->fecha)->format('Y-m-d') }}</td>
                <td>{{$analisi->codigo}}</td>
                <td>{{$analisi->person->nombres}} {{$analisi->person->apellidos}} {{$analisi->person->apellido_materno}}</td>
                <td>{{$analisi->edad}}</td>
                <td>{{$analisi->doctor}}</td>
                <td>{{$analisi->institucion->nombre}}</td>
                <td>{{$analisi->region}}</td>
                <td>{{$analisi->precio}}</td>
{{--                <td style="text-align: center;">{!! ($analisi->fecha_entrega)? "<p style='color:green; font-size: 10px;'>".$analisi->fecha_entrega->format('d-m-Y')."</p>" : "<p style='color:red;'>No</p>" !!}</td>--}}
                <td style="text-align: center;">{!! ($analisi->fecha_entrega)? "<p style='color:green; font-size: 10px;'>Entregado</p>" : "<p style='color:red;'>No</p>" !!}</td>
                <td style="color: #0B0D33; font-size: 10px;"><p style="font-size: 16px; margin-bottom: 2px;">{!! ($analisi->precio == ($analisi->acuenta + $analisi->pago_efectuado))? '<span class="badge badge-success">Cancelado</span>' : '<span class="badge badge-danger">Debe: '.($analisi->precio -($analisi->acuenta + $analisi->pago_efectuado)).'</span>' !!}</p></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#js-doctor-ajax-id').select2({
                ajax: {
                    url: '{{ route('analisis.doctor.asearchdoctor') }}',
                    dataType: 'json',
                    type: "post",
                    data: function (params) {
                        return {
                            _token: CSRF_TOKEN,
                            search: params.term
                        }
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                }
            });
        });

        function exportExcelReporteAdmin(){
            var fechaIni = $("#f_reporte_admin_d input[name='fecha_ini']").val();
            var fechaFin = $("#f_reporte_admin_d input[name='fecha_fin']").val();
            var procedencia = $("#f_reporte_admin_d select[name='procedencia']").val();
            var doctor = $("#f_reporte_admin_d select[name='doctor_refiere']").val();
            var url = '{{url("/")}}/reportes/reporte-admin-diario/'+fechaIni+'/'+fechaFin+'/'+procedencia+'/'+doctor;

            window.open(url, '_blank');
        }
    </script>
@endpush
