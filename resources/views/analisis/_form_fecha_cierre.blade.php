<div class="row">
    <div class="col-md-12">
        @if($update)
            <div class="alert alert-primary" role="alert">
                <b>Advertencia!</b> Usted cerrara el análisis.
            </div>
        @else
            <div class="alert alert-danger" role="alert">
                <b>El analisis</b> ya se cerró en fecha: {{ $analisis->fecha_cierre->format('d-m-Y') }}
            </div>
        @endif
    </div>
    <div class="col-md-6">
        <dl>
            <dt>Paciente:</dt>
            <dd>{{ $analisis->person->nombres }} {{ $analisis->person->apellidos }} {{ $analisis->person->apellido_materno }}</dd>
            <dt>Precio</dt>
            <dd>{{$analisis->precio}}</dd>
            <dt>Pago efectuado</dt>
            <dd>{{$analisis->pago_efectuado}}</dd>
            <dt>Fecha registro analisis</dt>
            <dd>{{ $analisis->fecha->format('Y-m-d') }}</dd>
        </dl>
    </div>
    <div class="col-md-6">
        <dl>
            <dt>Analisis</dt>
            <dd>{{ $analisis->tipo_analisis }}</dd>
            <dt>Acuenta</dt>
            <dd>{{ $analisis->acuenta }}</dd>
            <dt>Estado</dt>
            @if($analisis->precio == ($analisis->acuenta + $analisis->pago_efectuado))
                <dd style="color: green;">Cancelado</dd>
            @else
                <dd style="color: red; font-size: 18px">Debe {{ $analisis->precio - ($analisis->acuenta + $analisis->pago_efectuado) }}</dd>
            @endif
        </dl>
    </div>
</div>
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
@if($update)
<button type="button" class="btn btn-success" onclick="saveFechaCierre('{{ $analisis->id }}')">Grabar</button>
@endif
