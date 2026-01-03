@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Administrar Analisis', 'navName' => 'Kardex de: '.$person->nombres.' '.$person->apellidos, 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item">Lista de Analisis</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            <table id="tAnalisis" class="table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>fecha</th>
                    <th>Tipo</th>
                    <th>Doctor</th>
                    <th>Procedencia</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('analisis.includes.modals.m_fecha_entrega_analisis')
    @include('analisis.includes.modals.m_cerrar_analisis')
    @include('analisis.includes.modals.m_enviar_whatsapp')
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#tAnalisis').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('datatableAnalisisPerson', $person->id) }}",
                columns: [
                    {name: 'id'},
                    {name: 'person.nombres', orderable: true},
                    {name: 'fecha'},
                    {name: 'tipo_analisis'},
                    {name: 'doctor'},
                    {name: 'institucion.nombre'},
                    {name: 'action', orderable: false, searchable: false}
                ],
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
                },
            });
        });

    </script>
@endpush