@extends('layouts.public')

@section('content')
    <br>
    @if ( Session::has('flash_message') )
        <div class="alert alert-{{ Session::get('flash_type') }}" role="alert">
            {!! Session::get('flash_message') !!}
        </div>

    @endif

    <div class="row">
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

    <br>
{{--    <a href="{{ route('analisis.open.esultado.pdf', ['analisisId' => base64_encode($analisis->id)]) }}" target="_blank" class="btn btn-primary @if($analisis->imprimir_firma == 0) disabled @endif">Descargar Analisis!!</a>--}}
    @if($analisis->imprimir_firma == 0)
{{--        <p class="text-danger">El analisis todavia no esta firmada por el doctor.</p>--}}
    @endif
@endsection


@push('js')
    <script>
        $(document).ready(function () {
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
        });
    </script>
@endpush
