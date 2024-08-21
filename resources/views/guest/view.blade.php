@extends('layouts.app')

@section('content')
    <div class="card ml-2 mr-2">
        <div class="card-header">
            <dl>
                <dt>Paciente</dt>
                <dd>{{$person->fullname}}</dd>
                <dt>Fecha nacimiento</dt>
                <dd>{{$person->f_nacimiento}}</dd>
            </dl>
        </div>
        <div class="card-body">
            <h6>Lista de analisis</h6>
            <div class="table-responsive">
                <table id="tAnalisis" class="table table-sm">
                    <thead class="table-dark">
                    <tr class="">
                        <th class="text-center">#</th>
                        <th style="text-align: center">Código</th>
                        <th>Fecha</th>
                        <th>Dr Asignado</th>
                        <th>Procedencia</th>
                        <th>Estado</th>
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
            $('#tAnalisis').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('datatableAnalisisPerson', $person->id) }}",
                columns: [
                    {name: 'id'},
                    {name: 'codigo'},
                    {name: 'fecha'},
                    {name: 'doctorasig.nombres', orderable: false},
                    {name: 'institucion.nombre'},
                    {name: 'precio1', orderable: false, searchable: false},
                    {name: 'actionguest', orderable: false, searchable: false},
                    {name: 'imprimir_firma', visible: false, searchable: false},
                    {name: 'precio', searchable: false, visible: false},
                    {name: 'acuenta', searchable: false, visible: false},
                    {name: 'pago_efectuado', searchable: false, visible: false},
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
