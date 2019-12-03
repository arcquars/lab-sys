@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Administrar Analisis', 'navName' => 'Analisis', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Analisis</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
{{--            <div class="row">--}}
{{--                <div class="col-md-6">--}}
{{--                    <h4>Clientes</h4>--}}
{{--                </div>--}}
{{--                <div class="col-md-6 text-right"><a href="#" class="btn btn-primary" onclick="openModelPerson();">Registrar--}}
{{--                        Cliente</a></div>--}}
{{--            </div>--}}
        </div>
        <div class="card-body">
            <table id="tAnalisis" class="table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>fecha</th>
                    <th>Doctor</th>
                    <th>Procedencia</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#tAnalisis').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('simple_datatables_analisis_data') }}",
                columns: [
                    {name: 'id'},
                    {name: 'person.nombres', orderable: true},
                    {name: 'fecha'},
                    {name: 'doctor'},
                    {name: 'procedencia'},
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