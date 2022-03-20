@extends('layouts.dash', ['activePage' => 'invitado_index', 'title' => 'Invitado', 'navName' => 'Analisis', 'activeButton' => 'invitadoActiveButton'])

@section('content')
    <div style="height: 2px"></div>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4>Lista de analisis</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-full-width table-responsive">
                <table id="tAnalisisInvitados" class="table table-hover">
                    <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Tipo</th>
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($analisis as $a)
                        <tr data-id="{{$a->id}}">
                            <td>{{$a->codigo}}</td>
                            <td>{{$a->tipo_analisis}}</td>
                            <td>{{$a->nombres}} {{$a->apellidos}} {{$a->apellido_materno}}</td>
                            <td>{{$a->fecha}}</td>
                            <td>
                                <a href="{{route('analisis.open.esultado.pdf', array('analisisId' => base64_encode($a->id)))}}"
                                   class="btn btn-primary btn-sm" title="Archivo pdf" target="_blank"
                                   ><i class="fas fa-file-pdf"></i></a>
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
        $(document).ready(function () {
        });
    </script>
@endpush
