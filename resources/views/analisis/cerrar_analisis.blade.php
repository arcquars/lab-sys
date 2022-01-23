@extends('layouts.public')

@section('content')
    <br>
    @if ( Session::has('flash_message') )
        <div class="alert alert-{{ Session::get('flash_type') }}" role="alert">
            {!! Session::get('flash_message') !!}
        </div>

    @endif

    <dl>
        <dt>Analisis</dt>
        <dd>{{ $analisis->tipo_analisis }}</dd>
        <dt>Paciente:</dt>
        <dd>{{ $analisis->person->nombres }} {{ $analisis->person->apellidos }} {{ $analisis->person->apellido_materno }}</dd>
        <dt>Fecha</dt>
        <dd>{{ $analisis->fecha }}</dd>
    </dl>
    <br>
    <a href="{{ route('analisis.open.esultado.pdf', ['analisisId' => $analisis->id]) }}" class="btn btn-primary">Descargar Analisis!!</a>
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
