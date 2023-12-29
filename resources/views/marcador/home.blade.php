@extends('layouts.dash', ['activePage' => 'marcadores', 'title' => 'Administrar marcadores', 'navName' => 'Marcadores', 'activeButton' => 'marcadorActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Marcadores</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4>Marcadores</h4>
                </div>
                <div class="col-md-6 text-right">
                    <a href="#" class="btn btn-primary" onclick='openModalMarker();'>Registrar Marcador</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="tMarkets" class="table table-bordered table-clinica">
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    @include('marcador.modals.m_create_marker')
    @include('marcador.modals.m_delete_marker')
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#tMarkets').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('marcador.datatables_marcadores') }}",
                columns: [
                    {name: 'id', visible: false},
                    {name: 'name', orderable: true},
                    {name: 'description'},
                    {name: 'action', orderable: false, searchable: false}
                ],
                "order": [[ 1, "asc" ]],
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

        function editMarkerAjax(markerId) {
            $.ajax({
                url: "{{ route('marcador.getmarket') }}",
                type: 'POST',
                data: {markerId},
                success: function (data) {
                    if (data.success) {
                        $("#mMarcador").modal("show");
                        $('#mMarcador_title').empty().text('Editar marcador');
                        setMarkerModal(data.marker);
                    } else {
                        alert(data.errors);
                    }
                }
            });
        }

        function setMarkerModal(marker){
            $("#mMarcador").find("input[name='id']").val(marker.id);
            $("#mMarcador").find("input[name='name']").val(marker.name);
            $("#mMarcador").find("textarea[name='description']").val(marker.description);
        }
    </script>
@endpush
