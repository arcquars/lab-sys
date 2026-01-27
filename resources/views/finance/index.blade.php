@extends('layouts.dash', ['activePage' => 'admin_finances', 'title' => 'Administrar Movimientos', 'navName' => 'Movimientos de caja', 'activeButton' => 'adminactiveButton'])

@section('content')
<div class="container-fluid">
    <!-- Tarjetas de Resumen -->
    <div class="row my-2">
        <div class="col-md-4">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between bd-highlight mb-3">
                        <div class="p-2 bd-highlight">
                            <h5 class="">Ingresos</h5>
                            <h3>Bs. {{ number_format($totalIncome, 2) }}</h3>
                        </div>
                        <div class="p-2 bd-highlight">
                            <i class="fas fa-sign-in-alt fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between bd-highlight mb-3">
                        <div class="p-2 bd-highlight">
                            <h5 class="">Egresos</h5>
                            <h3>Bs. {{ number_format($totalExpense, 2) }}</h3>
                        </div>
                        <div class="p-2 bd-highlight">
                            <i class="fas fa-sign-out-alt fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white {{ $balance >= 0 ? 'bg-primary' : 'bg-warning' }} shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between bd-highlight mb-3">
                        <div class="p-2 bd-highlight">
                            <h5 class="">Balance</h5>
                            <h3>Bs. {{ number_format($balance, 2) }}</h3>
                        </div>
                        <div class="p-2 bd-highlight">
                            <i class="fas fa-poll fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros y Botón Crear -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Control de Caja</h6>
            <a href="{{ route('finance.create') }}" class="btn btn-primary btn-sm">
                <i class="nc-icon nc-simple-add"></i> Nuevo Movimiento
            </a>
        </div>
        <div class="card-body">
            <!-- Formulario de Filtros -->
            <form id="f-finance-search" action="{{ route('finance.index') }}" method="GET" class="form-inline mb-4">
                <div class="form-group mr-2">
                    <label for="start_date" class="mr-2">Desde:</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="form-group mr-2">
                    <label for="end_date" class="mr-2">Hasta:</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                <button type="submit" class="btn btn-secondary">Filtrar</button>
                <a class="ml-1 btn btn-warning" onclick="exportExcelFinance(); return false;">Exportar</a>
            </form>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Fecha</th>
                            <th>Concepto</th>
                            <th>Descripción</th>
                            <th>Método</th>
                            <th>Usuario</th>
                            <th>Ingreso</th>
                            <th>Egreso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movements as $mov)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($mov->movement_date)->format('d/m/Y') }}</td>
                            <td style="text-align: center;">
                                <span class="badge badge-{{ $mov->type == 'INGRESO' ? 'success' : 'danger' }}">
                                    {{ optional($mov->concept)->name ?? 'General' }}
                                </span>
                            </td>
                            <td>
                                {{ $mov->description }}
                                @if($mov->source)
                                    <br><small class="text-muted">Ref: {{ class_basename($mov->source_type) }} #{{ $mov->source_id }}</small>
                                @endif
                            </td>
                            <td>{{ $mov->payment_method }}</td>
                            <td>{{ optional($mov->user)->name ?? 'Sistema' }}</td>
                            <td class="text-right text-success font-weight-bold">
                                {{ $mov->type == 'INGRESO' ? number_format($mov->amount, 2) : '-' }}
                            </td>
                            <td class="text-right text-danger font-weight-bold">
                                {{ $mov->type == 'EGRESO' ? number_format($mov->amount, 2) : '-' }}
                            </td>
                            <td style="text-align: right;">
                                <!-- Solo permitir borrar si es manual (tiene concepto manual) o según política -->
                                <form action="{{ route('finance.destroy', $mov->id) }}" method="POST" onsubmit="return confirm('¿Seguro que desea eliminar este registro?');" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm px-2 py-1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        function exportExcelFinance(){
            var fechaIni = $("#f-finance-search input[name='start_date']").val();
            var fechaFin = $("#f-finance-search input[name='end_date']").val();
            var userId = "{{ Auth::id() }}";
            var url = '{{url("/")}}/admin/finance/export-report/'+fechaIni+'/'+fechaFin+'/'+userId;
            window.open(url, '_blank');
        }
    </script>
@endpush