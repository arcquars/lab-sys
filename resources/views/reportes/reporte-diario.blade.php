@extends('layouts.dash', ['activePage' => 'admin_reporte_diario', 'title' => 'Reporte por dia', 'navName' => 'Reporte por dia', 'activeButton' => 'reporteActiveButton'])

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
            <li class="breadcrumb-item">Cobros X Dia</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form id="f_reporte_diario" method="post" action="/reportes/reporte-diario">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-2">
                        <label for="fecha_inicio">Fecha inicio</label>
                    </div>
                    <div class="col-md-2">
                        <label for="fecha_fin">Fecha fin</label>
                    </div>
                    <div class="col-md-2">
                        <label for="fecha_fin">Tipo analisis</label>
                    </div>
                    <div class="col-md-2">
                        <label for="doctor_refiere">Doctor</label>
                    </div>
                    <div class="col-md-2">
                        <label for="tipo_analisis">Procedencia</label>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <input type="date" name="fecha_ini" class="form-control" value="{{old('fecha_ini', $fecha_ini)}}" >
                        @error('fecha_ini')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="fecha_fin" class="form-control" value="{{$fecha_fin}}" >
                        @error('fecha_fin')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <select name="tipo_analisis" class="form-control">
                            <option value="0">Todos</option>
                            @foreach($tipoAnalisis as $key => $tipo)
                                @if(strcmp(old('tipo_analisis', $tipoId), $key) == 0)
                                    <option value="{{$key}}" selected>{{$tipo}}</option>
                                @else
                                    <option value="{{$key}}">{{$tipo}}</option>
                                @endif
                            @endforeach
                        </select>
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
                    <div class="col-md-2">
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
                        <input type="submit" value="Buscar" class="btn btn-info">
                        <a href="#" onclick="exportExcel(); return false;"  class="btn btn-warning">Exportar excel</a>
                        <a href="#" onclick="exportPdf(); return false;"  class="btn btn-warning">Exportar pdf</a>
                    </div>
                </div>
            </form>
            <br>
            <h4>Analisis Pagos a Cuenta</h4>
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
                                <td>{{ \Carbon\Carbon::parse($analisi->fecha)->format('Y-m-d') }}</td>
                                <td>{{$analisi->codigo}}</td>
                                <td>{{$analisi->person->nombres}} {{$analisi->person->apellidos}} {{$analisi->person->apellido_materno}}</td>
                                <td>{{$analisi->doctor}}</td>
                                <td>{{$analisi->region}}</td>
                                <td>{{( strcmp($analisi->tipo_analisis, \App\Analisis::HISTOPATOLOGICO) != 0)? $analisi->tipo_analisis: \App\Analisis::BIOPSIA_DE_RINON}}</td>
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
            <br>
            <h4>Analisis Pagos Efectuados</h4>
            <table class="table table-bordered table-clinica">
                <thead class="thead-dark">
                <tr>
                    <th>N.</th>
                    <th scope="col">Fecha Pago</th>
                    <th scope="col">Codigo</th>
                    <th scope="col">Paciente</th>
                    <th scope="col">Doctor que Pidio</th>
                    <th scope="col">Region</th>
                    <th scope="col">Tipo Estudio</th>
                    <th scope="col">Precio</th>
                    <th scope="col">A cuenta</th>
                    <th scope="col">Pago Efec</th>
                    <th scope="col">Empresa</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($analisisPagos as $analisi)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$analisi->fecha_pago_efectuado}}</td>
                        <td>{{$analisi->codigo}}</td>
                        <td>{{$analisi->person->nombres}} {{$analisi->person->apellidos}} {{$analisi->person->apellido_materno}}</td>
                        <td>{{$analisi->doctor}}</td>
                        <td>{{$analisi->region}}</td>
                        <td>{{( strcmp($analisi->tipo_analisis, \App\Analisis::HISTOPATOLOGICO) != 0)? $analisi->tipo_analisis: \App\Analisis::BIOPSIA_DE_RINON}}</td>
                        <td>{{$analisi->precio}}</td>
                        <td>{{$analisi->acuenta}}</td>
                        <td>{{$analisi->pago_efectuado}}</td>
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
                    <td>{{$totalPrecioPago}}</td>
                    <td>{{$totalAcuentaPago}}</td>
                    <td>{{$totalDebePago}}</td>
                    <td></td>
                </tr>
                </tfoot>
            </table>
            <br>
            <h4>Gastos</h4>
            <table class="table table-bordered table-clinica">
                <thead class="thead-dark">
                <tr>
                    <th>N.</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Detalle</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Monto</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($gastos as $gasto)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$gasto->fecha}}</td>
                        <td>{{$gasto->detalle}}</td>
                        <td>{{$gasto->user->name}}</td>
                        <td>{{$gasto->gasto}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>TOTALES</td>
                    <td>{{$totalGastos}}</td>
                </tr>
                </tfoot>
            </table>
            <br>
            <h4>Totales</h4>
            <table class="table table-bordered table-clinica">
                <thead class="thead-dark">
                <tr>
                    <th>Resumen</th>
                    <th>$</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Pagos a Cuenta</td>
                        <td>{{$totalAcuenta}}</td>
                    </tr>
                    <tr>
                        <td>Total Pagos Efectuados</td>
                        <td>{{$totalDebePago}}</td>
                    </tr>
                    <tr>
                        <td>Total Egresos</td>
                        <td>{{$totalGastos}}</td>
                    </tr>
                    <tr>
                        <td>TOTAL</td>
                        <td>{{$totalAcuenta + $totalDebePago - $totalGastos}}</td>
                    </tr>
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

        function exportExcel(){
            var fechaIni = $("#f_reporte_diario input[name='fecha_ini']").val();
            var fechaFin = $("#f_reporte_diario input[name='fecha_fin']").val();
            var procedencia = $("#f_reporte_diario select[name='procedencia']").val();
            var tipoId = $("#f_reporte_diario select[name='tipo_analisis']").val();
            var doctor = $("#f_reporte_diario select[name='doctor_refiere']").val();
            var url = '{{url("/")}}/reportes/reporte-diario-excel/'+fechaIni+'/'+fechaFin+'/'+procedencia+'/'+tipoId+'/'+doctor;

            window.open(url, '_blank');
        }

        function exportPdf(){
            var fechaIni = $("#f_reporte_diario input[name='fecha_ini']").val();
            var fechaFin = $("#f_reporte_diario input[name='fecha_fin']").val();
            var procedencia = $("#f_reporte_diario select[name='procedencia']").val();
            var tipoId = $("#f_reporte_diario select[name='tipo_analisis']").val();
            var doctor = $("#f_reporte_diario select[name='doctor_refiere']").val();
            var url = '{{url("/")}}/reportes/reporte-diario-pdf/'+fechaIni+'/'+fechaFin+'/'+procedencia+'/'+tipoId+'/'+doctor;

            window.open(url, '_blank');
        }
    </script>
@endpush
