@extends('layouts.dash', ['activePage' => 'doctores', 'title' => 'Administrar Doctores', 'navName' => 'Doctores', 'activeButton' => 'doctorActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Doctores</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4>Doctores</h4>
                </div>
                <div class="col-md-6 text-right">
                    <a href="#" class="btn btn-primary" onclick="openModelDoctor();">Registrar Doctor</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="tDoctores" class="table table-bordered table-clinica">
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>


    <!-- Modal registro Doctor-->
    <div id="mdoctor" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="fcreardoctor" action="">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="mdoctor_title" class="modal-title ">Crear Doctor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nombres</label>
                                    <input type="text" name="nombres"
                                           onkeyup="uppercaseInput(this);"
                                           class="form-control" placeholder="Nombres">
                                    <div class="fcp_error_nombres" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="apellidos">Apellidos</label>
                                    <input type="text" name="apellidos"
                                           class="form-control"
                                           onkeyup="uppercaseInput(this);"
                                           placeholder="Apellido Paterno">
                                    <div class="fcp_error_apellidos" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Grabar</button>
                    </div>
                </div>
            </form>
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

            $('#tDoctores').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('doctor.datatables_doctores') }}",
                columns: [
                    {name: 'id', visible: false},
                    {name: 'nombres', orderable: true},
                    {name: 'apellidos'},
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

            $("#fcreardoctor").submit(function (event) {
                event.preventDefault();
                clearErrorMsg();

                var _token = $(this).find("input[name='_token']").val();
                var id = $(this).find("input[name='id']").val();
                var nombres = $(this).find("input[name='nombres']").val();
                var apellidos = $(this).find("input[name='apellidos']").val();

                $.ajax({
                    url: "{{ route('doctores.createDoctor') }}",
                    type: 'POST',
                    data: {
                        _token: _token,
                        id: id,
                        nombres: nombres,
                        apellidos: apellidos
                    },
                    success: function (data) {
                        if (data.success) {
                            $("#mdoctor").modal("hide");
                            $('#tDoctores').DataTable().ajax.reload();
                        } else {
                            alert(data.errors);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        printErrorMsg($("#fcreardoctor"), JSON.parse(XMLHttpRequest.responseText));
                    }
                });
            });

            $("#mdoctor").on('shown.bs.modal', function (event) {
                $("#fcreardoctor")[0].reset();
                $("#fcreardoctor").find("input[name='id']").val('');
                clearErrorMsg();
            });
        });

        function openModelDoctor() {
            $('#mdoctor').modal('show');
            $('#mdoctor_title').empty().text('Crear Doctor');
        }

        function clearErrorMsg() {
            $('.fcp_error_nombres').empty();
            $('.fcp_error_apellidos').empty();

            $("#fcreardoctor").find("input[name='nombres']").removeClass('is-invalid');
            $("#fcreardoctor").find("input[name='apellidos']").removeClass('is-invalid');
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

        function editDoctorAjax(doctorId) {
            var _token = $("#fcreardoctor").find("input[name='_token']").val();
            $.ajax({
                url: "{{ route('doctor.getDoctor') }}",
                type: 'POST',
                data: {_token: _token, doctorId: doctorId},
                success: function (data) {
                    if (data.success) {
                        $("#mdoctor").modal("show");
                        $('#mdoctor_title').empty().text('Editar Doctor');
                        setDoctorModal(data.doctor);
                    } else {
                        alert(data.errors);
                    }
                }
            });
        }

        function setDoctorModal(doctor){
            $("#fcreardoctor").find("input[name='id']").val(doctor.id);
            $("#fcreardoctor").find("input[name='nombres']").val(doctor.nombres);
            $("#fcreardoctor").find("input[name='apellidos']").val(doctor.apellidos);
        }
    </script>
@endpush