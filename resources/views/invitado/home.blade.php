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
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="s_nombres">Nombres</label>
                        <input type="text" name="s_nombres" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="apellido_pa">Apellido Paterno</label>
                        <input type="text" name="apellidos_pa" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3">
                </div>
                <div class="col-md-3">
                </div>
            </div>
            <div class="table-full-width table-responsive">
                <div class="table-responsive">
                    <table id="tAnalisisInvitados" class="table table-clinica">
                        <thead class="thead-dark">
                        <tr>
                            <th>Codigo</th>
                            <th>Tipo</th>
                            <th>Paciente Nombres</th>
                            <th>Paciente Apellido</th>
                            <th>Procedencia</th>
                            <th>Fecha</th>
                            <th>Fecha Conclucion</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <hr>

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

            var table = $('#tAnalisisInvitados').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                // deferRender: true,
                ajax: {
                    url: "{{ route('invitado.simple.datatables.analisis.data') }}",
                    type: 'post',
                    beforeSend: function(){
                        // Here, manually add the loading message.
                        $('#tAnalisis > tbody').html(
                            '<tr class="odd">' +
                            '<td valign="top" colspan="6" class="dataTables_empty">Loading&hellip;</td>' +
                            '</tr>'
                        );
                    }
                },
                columns: [
                    {name: 'codigo'},
                    {name: 'tipo_analisis'},
                    {name: 'nombres', searchable: true},
                    {name: 'apellidos', searchable: true},
                    {name: 'nombre'},
                    {name: 'fecha'},
                    {name: 'fecha_conclucion', orderable: false, searchable: false},
                    {name: 'action', orderable: false, searchable: false},

                ],
                "pagingType": "full_numbers",
                "order": [[ 5, "desc" ]],
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
                "initComplete": function (settings) {
                    $('.dataTables_filter').css('visibility', 'hidden');
                }
            });


            $('input[name="s_nombres"]').on( 'keyup', function () {
                table.column(2).search(
                    $(this).val()
                ).draw();
            } );

            $('input[name="apellidos_pa"]').on( 'keyup', function () {
                table.column(3).search(
                    $(this).val()
                ).draw();
            } );
        });
    </script>
@endpush
