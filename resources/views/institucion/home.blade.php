@extends('layouts.dash', ['activePage' => 'instituciones', 'title' => 'Administrar Instituciones', 'navName' => 'Instituciones', 'activeButton' => 'institucionActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Instituciones</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 text-right"><a href="#" class="btn btn-lab-pdm-primary btn-sm" onclick="openModelInstitucion();">Registrar
                        Institucion</a></div>
            </div>
        </div>
        <div class="card-body">
            <table id="datatable-instituciones" class="table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Accion</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal registro Institucion -->
    <div id="minstitucion" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="fcrearinstitucion" action="">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="minstitucion_title" class="modal-title ">Crear Institucion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nombre de la Institucion</label>
                                    <input type="text" name="nombre" class="form-control"
                                           placeholder="Nombre de la institucion"
                                           onkeyup="uppercaseInput(this);"
                                    >
                                    <div class="fcp_error_nombre" style="display: none;"></div>
                                </div>
                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input type="text" name="telefono" class="form-control">
                                    <div class="fcp_error_telefono" style="display: none;"></div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="1" id="is_convenio" name="is_convenio">
                                        <label class="form-check-label" for="is_convenio">
                                            Convenio
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-lab-pdm-primary btn-sm">Grabar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {

            $('#datatable-instituciones').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('institucion.datatablesInstitucionData') }}",
                columns: [
                    {name: 'id'},
                    {name: 'nombre'},
                    {name: 'telefono'},
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


            $("#fcrearinstitucion").submit(function (event) {
                event.preventDefault();

                clearErrorMsg();

                var _token = $(this).find("input[name='_token']").val();
                var id = $(this).find("input[name='id']").val();
                var nombre = $(this).find("input[name='nombre']").val();
                var telefono = $(this).find("input[name='telefono']").val();
                var is_convenio = $(this).find("input[name='is_convenio']").is(':checked');

                $.ajax({
                    url: "{{ route('institucion.createInstitucion') }}",
                    type: 'POST',
                    data: {
                        _token: _token,
                        id: id,
                        nombre: nombre,
                        telefono,
                        is_convenio
                    },
                    success: function (data) {
                        if (data.success) {
                            $("#minstitucion").modal("hide");
                            $('#datatable-instituciones').DataTable().ajax.reload();
                        } else {
                            console.log(JSON.stringify(data));
                            alert(data.errors);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        printErrorMsg($("#fcrearinstitucion"), JSON.parse(XMLHttpRequest.responseText));
                    }
                });
            });
        });

        function openModelInstitucion() {
            clearErrorMsg();
            $('#minstitucion').modal('show');
            $("#fcrearinstitucion").find("input[name='id']").val('');
            $("#fcrearinstitucion").find("input[name='nombre']").val('');
            $('#minstitucion_title').empty().text('Crear Institucion');
        }

        function editInstitucionAjax(institucionId){
            var _token = $("#fcrearinstitucion").find("input[name='_token']").val();
            clearErrorMsg();
            $.ajax({
                url: "{{ route('institucion.getInstitucion') }}",
                type: 'POST',
                data: {_token: _token, institucionId: institucionId},
                success: function (data) {
                    if (data.success) {
                        $("#minstitucion").modal("show");
                        $('#minstitucion_title').empty().text('Editar Institucion');
                        $("#fcrearinstitucion").find("input[name='nombre']").val(data.institucion.nombre);
                        $("#fcrearinstitucion").find("input[name='telefono']").val(data.institucion.telefono);
                        if(data.institucion.is_convenio == 1){
                            $("#fcrearinstitucion").find("input[name='is_convenio']").prop('checked', true);
                        } else {
                            $("#fcrearinstitucion").find("input[name='is_convenio']").prop('checked', false);
                        }
                        $("#fcrearinstitucion").find("input[name='id']").val(data.institucion.id);
                    } else {
                        alert(data.errors);
                    }
                }
            });
        }

        function clearErrorMsg() {
            $('.fcp_error_nombre').empty();
            $('.fcp_error_telefono').empty();

            $("#fcrearinstitucion").find("input[name='nombre']").removeClass('is-invalid');
            $("#fcrearinstitucion").find("input[name='telefono']").removeClass('is-invalid');
        }

        function printErrorMsg(form, msg) {
            $.each(msg.errors, function (key, value) {
                $(form).find("input[name='" + key + "']").addClass('is-invalid');
                var msgs = "<ul class='list-unstyled'>";
                $.each(value, function (key1, value1) {
                    msgs += "<li><span class='text-danger'>" + value1 + "</span></li>";
                });
                msgs += "</ul>";
                $('.fcp_error_' + key).empty().append(msgs);
                $('.fcp_error_' + key).show();
            });
        }
    </script>
@endpush
