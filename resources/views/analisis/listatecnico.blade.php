@extends('layouts.dash', ['activePage' => 'reportetecnico', 'title' => 'Lista de Analisis', 'navName' => 'reportetecnico', 'activeButton' => 'reportetecnicoActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Analisis</li>
            <li class="breadcrumb-item">Tecnico</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body ">
            <div class="table-responsive">
                <table id="tAnalisis" class="table table-bordered table-clinica">
                    <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Codigo</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Doctor Asignado</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#tAnalisis').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('analisis.datatables.tecnico') }}",
                columns: [
                    {name: 'id', visible: false},
                    {name: 'codigo'},
                    {name: 'person.nombres', orderable: false},
                    {name: 'fecha', orderable: false},
                    {name: 'tipo_analisis'},
                    // {name: 'doctor', orderable: false},
                    {name: 'doctorasig.nombres', orderable: false},
                    {name: 'actiontec', orderable: false, searchable: false},
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