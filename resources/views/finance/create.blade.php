@extends('layouts.dash', ['activePage' => 'admin_finances_concep', 'title' => 'Conceptos', 'navName' => 'Movimientos de caja registro', 'activeButton' => 'adminactiveButton'])

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Registrar Movimiento de Caja
                <a href="{{ route('finance.index') }}" class="float-right btn btn-secondary btn-sm">Volver</a>
            </h6>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('finance.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="movement_date">Fecha</label>
                            <input type="date" name="movement_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">Monto (Bs.)</label>
                            <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="concept_id">Concepto</label>
                            <select name="concept_id" id="concept_id" class="form-control" required>
                                <option value="">Seleccione...</option>
                                <optgroup label="INGRESOS">
                                    @foreach($concepts->where('type', 'INGRESO') as $concept)
                                        <option value="{{ $concept->id }}">{{ $concept->name }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="EGRESOS">
                                    @foreach($concepts->where('type', 'EGRESO') as $concept)
                                        <option value="{{ $concept->id }}">{{ $concept->name }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment_method">Método de Pago</label>
                            <select name="payment_method" class="form-control" required>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Transferencia">Transferencia Bancaria</option>
                                <option value="Tarjeta">Tarjeta de Débito/Crédito</option>
                                <option value="QR">Pago QR</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Descripción / Detalle</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Ej: Pago de factura de luz mes de Agosto"></textarea>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary btn-block">Guardar Movimiento</button>
            </form>
        </div>
    </div>
</div>
@endsection