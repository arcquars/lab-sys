@extends('layouts.dash', ['activePage' => 'texto_predefinido', 'title' => 'Administrar Texto', 'navName' => 'Texto Predefinido', 'activeButton' => 'texto_predefinido'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Texto predefinido</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header" style="text-align: right;">
            <a href="{{url('/texto-predefinido/create')}}" class="btn btn-primary btn-sm">Crear texto predefinido</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable-textopredefinido" class="table table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Texto</th>
                        <th>Accion</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Crear / Editar Texto predefinido -->
    <div class="modal fade" id="textopreDeleteModal" tabindex="-1" aria-labelledby="textopreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form onsubmit="s_deteleTexto(this); return false;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="textopreModalLabel">Elimimar Texto predefinido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <input type="hidden" name="id" value="">
                    <div class="alert alert-warning alert-dismissible">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h5>
                        Esta seguro que desea eliminar el texto elegido?
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-danger">Confirmar</button>
                </div>
            </div>
            </form>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#datatable-textopredefinido').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('textopredefinido.datatablesTextopredefinidoData') }}",
                columns: [
                    {name: 'id'},
                    {name: 'texto'},
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


        function deleteTexto(id){
            $("#textopreDeleteModal").modal("show");
            $("#textopreDeleteModal input[name='id']").val(id);
        }

        function s_deteleTexto(form){
            $.ajax({
                url: "{{ route('textopredefinido.adeletetexto') }}",
                type: 'POST',
                data: $(form).serialize(),
                success: function (data) {
                    if (data.success) {
                        $("#textopreDeleteModal").modal("hide");
                        $('#datatable-textopredefinido').DataTable().ajax.reload();
                    } else {
                        console.log(JSON.stringify(data));
                        alert(data.errors);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {

                }
            });
        }
    </script>
@endpush