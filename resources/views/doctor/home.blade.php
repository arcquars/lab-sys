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
                    <a href="#" class="btn btn-lab-pdm-primary btn-sm" onclick="openModelDoctor();">Registrar Doctor</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive-md">
                <table id="tDoctores" class="table table-bordered table-clinica">
                    <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Especialidad</th>
                        <th>Matrícula</th>
                        <th>Imagen Firma</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
@endsection
<!-- Modal registro Doctor-->
<div id="mdoctor" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="fcreardoctor" enctype="multipart/form-data">
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Especialidad</label>
                                <input type="text" name="especialidad"
                                       onkeyup="uppercaseInput(this);"
                                       class="form-control" placeholder="Especialidad">
                                <div class="fcp_error_especialidad" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="matricula">Matrícula</label>
                                <input type="text" name="matricula"
                                       class="form-control"
                                       onkeyup="uppercaseInput(this);"
                                       placeholder="Matricula">
                                <div class="fcp_error_matricula" style="display: none;"></div>
                            </div>
                        </div>
                    </div>

                    {{--                        <div class="form-check">--}}
                    {{--                            <input class="form-check-input" id="flexCheckChecked" type="checkbox" name="supervisado" value="1">--}}
                    {{--                            <label class="form-check-label" for="flexCheckChecked">Interconsultado</label>--}}
                    {{--                        </div>--}}

                    <div class="row">
                        <div class="col-md-12">
                            <div id="divSigning" style="border: solid 1px #ced4da; padding: 5px;">
                                <button type="button" class="btn btn-danger" onclick="deleteImageSigningDr(this); return false;">Borrar Imagen</button>
                                <img class="img-fluid" src="" alt="">
                            </div>
                            <div class="form-group">
                                <label for="signing">Firma</label>
                                <input id="signing" type="file" class="form-control-file" name="signing">
                                <div class="fcp_error_file" style="display: none;"></div>
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
                    {name: 'especialidad'},
                    {name: 'matricula'},
                    { name: 'signing', "render": function ( data, type, row ) {
                            if(data === ''){
                                return '--';
                            } else {
                                return '<a href="{{asset('uploads/signings/')}}/'+data+'" target="_blank">Firma Digital</a>';
                            }
                        }
                    },
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

                // var _token = $(this).find("input[name='_token']").val();
                // var id = $(this).find("input[name='id']").val();
                // var nombres = $(this).find("input[name='nombres']").val();
                // var apellidos = $(this).find("input[name='apellidos']").val();

                var fd = new FormData();
                var files = $('#signing')[0].files[0];
                if(files === undefined){
                    files = '';
                }
                fd.append('id', $(this).find("input[name='id']").val());
                fd.append('file',files);
                fd.append('nombres', $(this).find("input[name='nombres']").val());
                fd.append('apellidos', $(this).find("input[name='apellidos']").val());
                fd.append('especialidad', $(this).find("input[name='especialidad']").val());
                fd.append('matricula', $(this).find("input[name='matricula']").val());
                fd.append('supervisado', $(this).find("input[name='supervisado']").is(':checked')? 1 : 0);

                $.ajax({
                    url: "{{ route('doctores.createDoctor') }}",
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
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
                clearSectionSigning();
            });
        });

        function openModelDoctor() {
            $('#mdoctor').modal('show');
            $('#mdoctor_title').empty().text('Crear Doctor');
        }

        function clearErrorMsg() {
            $('.fcp_error_nombres').empty();
            $('.fcp_error_apellidos').empty();
            $('.fcp_error_file').empty();
            $('.fcp_error_especialidad').empty();
            $('.fcp_error_matricula').empty();

            $("#fcreardoctor").find("input[name='nombres']").removeClass('is-invalid');
            $("#fcreardoctor").find("input[name='apellidos']").removeClass('is-invalid');
            $("#fcreardoctor").find("input[name='signing']").removeClass('is-invalid');
            $("#fcreardoctor").find("input[name='especialidad']").removeClass('is-invalid');
            $("#fcreardoctor").find("input[name='matricula']").removeClass('is-invalid');
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
            $("#fcreardoctor").find("input[name='especialidad']").val(doctor.especialidad);
            $("#fcreardoctor").find("input[name='matricula']").val(doctor.matricula);

            if(doctor.supervisado === 1){
                $("#fcreardoctor").find("input[name='supervisado']").prop('checked', true);
            } else {
                $("#fcreardoctor").find("input[name='supervisado']").prop('checked', false);
            }
            if(doctor.signing !== ''){
                $("#divSigning").show();
                $("#divSigning").find('button').attr('data-id', doctor.id);
                $("#fcreardoctor").find("img").attr('src', '{{asset('uploads/signings')}}/'+doctor.signing);
            } else {
                clearSectionSigning();
            }
        }

        function deleteImageSigningDr(button){
            $.ajax({
                url: "{{ route('doctor.pDeleteSigning') }}",
                type: 'POST',
                data: {doctorId: $(button).attr('data-id')},
                success: function (data) {
                    if (data.success) {
                        clearSectionSigning();
                        $('#tDoctores').DataTable().ajax.reload();
                    } else {
                        alert(data.errors);
                    }
                }
            });
        }

        function clearSectionSigning(){
            $("#divSigning").hide();
            $("#fcreardoctor").find("img").attr('src', '');
            $("#divSigning").find('button').attr('data-id', '-1');
        }
    </script>
@endpush
