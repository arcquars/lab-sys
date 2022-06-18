@extends('layouts.dash', ['activePage' => 'admin_reporte_admin_sinterminar', 'title' => 'Reporte sin terminar', 'navName' => 'Reporte Sin terminar', 'activeButton' => 'reporteActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
        <li class="breadcrumb-item">Reportes</li>
        <li class="breadcrumb-item">Sin terminar</li>

    </ol>
    </nav>
<div class="card">
    <div class="card-header">
    </div>
    <div class="card-body">
        <form id="f_reporte_admin_sinterminar" method="post" action="/reportes/reporte-sin-terminar">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8">
                    <label for="rango">Ultimos dias</label>
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <select name="tipo_analisis" class="form-control">
                        <option value="">TODOS</option>
                        <option {{old('tipo_analisis',$tipo_analisis)== \App\Analisis::BIOPSIA? 'selected':''}} value="{{\App\Analisis::BIOPSIA}}">{{\App\Analisis::BIOPSIA}}</option>
                        <option {{old('tipo_analisis',$tipo_analisis)== \App\Analisis::BIOPSIA_DE_RINON? 'selected':''}} value="{{\App\Analisis::BIOPSIA_DE_RINON}}">{{\App\Analisis::BIOPSIA_DE_RINON}}</option>
                        <option {{old('tipo_analisis',$tipo_analisis)== \App\Analisis::LIQUIDOS? 'selected':''}} value="{{\App\Analisis::LIQUIDOS}}">{{\App\Analisis::LIQUIDOS}}</option>
                        <option {{old('tipo_analisis',$tipo_analisis)== \App\Analisis::BIOLOGIA_MOLECULAR? 'selected':''}} value="{{\App\Analisis::BIOLOGIA_MOLECULAR}}">{{\App\Analisis::BIOLOGIA_MOLECULAR}}</option>
                        <option {{old('tipo_analisis',$tipo_analisis)== \App\Analisis::INMUNOHISTOQUIMICA? 'selected':''}} value="{{\App\Analisis::INMUNOHISTOQUIMICA}}">{{\App\Analisis::INMUNOHISTOQUIMICA}}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="rango" class="form-control" required>
                        <option {{old('rango',$rango)=="7"? 'selected':''}} value="7">7</option>
                        <option {{old('rango',$rango)=="14"? 'selected':''}} value="14">14</option>
                        <option {{old('rango',$rango)=="21"? 'selected':''}} value="21">21</option>
                    </select>
                    @error('rango')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <input type="submit" value="Buscar" class="btn btn-info">
                    <a class="btn btn-warning" onclick="exportExcelReporteAdminDesecho(); return false;">Exportar</a>
                </div>
            </div>
        </form>
        <br>
        <table id="t_sinterminar" class="table table-bordered table-clinica">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Codigo</th>
                <th scope="col">Tipo analisis</th>
                <th scope="col">Paciente</th>
                <th scope="col">Region</th>
                <th scope="col">Firmado</th>
                <th scope="col">Estado</th>
            </tr>
            </thead>
            <tbody>
            @foreach($analisis as $analisi)
            <tr>
                <td>{{ \Carbon\Carbon::parse($analisi->fecha)->format('Y-m-d') }}</td>
                <td>{{$analisi->codigo}}</td>
                <td>{{$analisi->tipo_analisis}}</td>
                <td>{{$analisi->person->nombres}} {{$analisi->person->apellidos}} {{$analisi->person->apellido_materno}}</td>
                <td>{{$analisi->region}}</td>
{{--                <td style="text-align: center;">{!! ($analisi->fecha_entrega)? "<p style='color:green; font-size: 10px;'>".$analisi->fecha_entrega->format('d-m-Y')."</p>" : "<p style='color:red;'>No</p>" !!}</td>--}}
                <td style="text-align: center;">{{($analisi->imprimir_firma == 1)? 'SI' : 'NO'}}</td>
                <td style="color: #0B0D33; font-size: 10px; text-align: center;">
                    <p style="font-size: 16px; margin-bottom: 2px;">{!! ($analisi->fecha_entrega)? "<span class='badge badge-success'>Entregado</span>" : "<p style='color:red;'>Sin Fecha de entrega</p>" !!}</p>
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
            $('#t_sinterminar').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });

        function exportExcelReporteAdminDesecho(){
            var rango = $("#f_reporte_admin_sinterminar select[name='rango']").val();
            var tipo_analisis = $("#f_reporte_admin_sinterminar select[name='tipo_analisis']").val();
            var url = '{{url("/")}}/reportes/reporte-admin-sinterminar/'+rango+'/'+tipo_analisis;
            window.open(url, '_blank');
        }
    </script>
@endpush
