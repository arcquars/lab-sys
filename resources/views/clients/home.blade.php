@extends('layouts.dash', ['activePage' => 'clients', 'title' => 'Administrar Clientes', 'navName' => 'Clientes', 'activeButton' => 'clientActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Clientes</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4>Clientes</h4>
                </div>
                {{--                <div class="col-md-6 text-right"><a href="{{route('clients.create')}}" class="btn btn-success">Registrar Cliente</a></div>--}}
                <div class="col-md-6 text-right"><a href="#" class="btn btn-primary" onclick="openModelPerson();">Registrar
                        Cliente</a></div>
            </div>
        </div>
        <div class="card-body">
            <table id="simple-datatable-example" class="table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>CI</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Edad</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- Modal registro persona-->
    <div id="mpersona" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="fcrearpersona" action="">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="mperson_title" class="modal-title ">Crear Persona</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ci">CI</label>
                                    <input type="text" name="ci" class="form-control" placeholder="Carnet de identidad">
                                    <div class="fcp_error_ci" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nombres</label>
                                    <input type="text" name="nombres" class="form-control" placeholder="Nombres">
                                    <div class="fcp_error_nombres" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="apellidos">Apellido Paterno</label>
                                    <input type="text" name="apellidos" class="form-control"
                                           placeholder="Apellido Paterno">
                                    <div class="fcp_error_apellidos" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="apellido_materno">Apellido Materno</label>
                                    <input type="text" name="apellido_materno" class="form-control"
                                           placeholder="Apellido Materno">
                                    <div class="fcp_error_apellido_materno" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edad">Edad</label>
                                    <input type="number" name="edad" class="form-control">
                                    <div class="fcp_error_edad" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <br>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="sexo1" name="sexo" value="hombre" class="custom-control-input">
                                    <label class="custom-control-label" for="sexo1">Hombre</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="sexo2" name="sexo" value="mujer" class="custom-control-input">
                                    <label class="custom-control-label" for="sexo2">Mujer</label>
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

    <!-- Modal Registrar analisis-->
    <div id="mAnalisis" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="">
                    <div class="modal-header">
                        <h5 class="modal-title">Crear Analisis</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="doctor">Doctor</label>
                                    <input type="text" name="doctor" class="form-control">
                                    <div class="fca_error_doctor" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="procedencia">Procedencia</label>
                                    <select name="procedencia" class="form-control">
                                        <option value="SIN PROCEDENCIA">SIN PROCEDENCIA</option>
                                        @foreach($procedencias as $procedencia)
                                            <option value="{{$procedencia->id}}">{{$procedencia->nombre}}</option>
                                        @endforeach
                                    </select>
                                    <div class="fca_error_procedencia" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_analisis">Tipo Analisis</label>
                                    <select name="tipo_analisis" class="form-control">
                                        @foreach($tipoAnalisis as $analisis)
                                            <option value="{{$analisis}}">{{$analisis}}</option>
                                        @endforeach
                                    </select>
                                    <div class="fca_error_tipo_analisis" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha">Fecha</label>
                                <input type="date" name="fecha" class="form-control datepicker">
                                <div class="fca_error_fecha" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="region">Region</label>
                                    <input type="text" name="region" class="form-control">
                                    <div class="fca_error_region" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="precio">Precio</label>
                                    <input type="text" name="precio" class="form-control">
                                    <div class="fca_error_precio" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="acuenta">Acuenta</label>
                                <input type="text" name="acuenta" class="form-control">
                                <div class="fca_error_acuenta" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="observaciones">Observaciones</label>
                                    <textarea class="form-control" id="observaciones" rows="3" style="resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {

            $('#simple-datatable-example').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('simple_datatables_persons_data') }}",
                columns: [
                    {name: 'ci'},
                    {name: 'nombres'},
                    {name: 'apellidos'},
                    {name: 'edad'},
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

            $("#mpersona").on('shown.bs.modal', function (event) {
                $("#fcrearpersona")[0].reset();
                $("#fcrearpersona").find("input[name='id']").val('');
                clearErrorMsg();
            });

            $("#fcrearpersona").submit(function (event) {
                event.preventDefault();

                clearErrorMsg();

                var _token = $(this).find("input[name='_token']").val();
                var id = $(this).find("input[name='id']").val();
                var ci = $(this).find("input[name='ci']").val();
                var nombres = $(this).find("input[name='nombres']").val();
                var apellidos = $(this).find("input[name='apellidos']").val();
                var apellido_materno = $(this).find("input[name='apellido_materno']").val();
                var edad = $(this).find("input[name='edad']").val();
                var sexo = $(this).find("input[name='sexo']:checked").val();

                $.ajax({
                    url: "{{ route('client.createPerson') }}",
                    type: 'POST',
                    data: {
                        _token: _token,
                        id: id,
                        ci: ci,
                        nombres: nombres,
                        apellidos: apellidos,
                        apellido_materno: apellido_materno,
                        edad: edad,
                        sexo: sexo,

                    },
                    success: function (data) {
                        if (data.success) {
                            $("#mpersona").modal("hide");
                            $('#simple-datatable-example').DataTable().ajax.reload();
                        } else {
                            alert(data.errors);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        printErrorMsg($("#fcrearpersona"), JSON.parse(XMLHttpRequest.responseText));
                    }
                });
            });

        });

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

        function clearErrorMsg() {
            $('.fcp_error_ci').empty();
            $('.fcp_error_nombres').empty();
            $('.fcp_error_apellidos').empty();
            $('.fcp_error_apellido_materno').empty();

            $("#fcrearpersona").find("input[name='ci']").removeClass('is-invalid');
            $("#fcrearpersona").find("input[name='nombres']").removeClass('is-invalid');
            $("#fcrearpersona").find("input[name='apellidos']").removeClass('is-invalid');
            $("#fcrearpersona").find("input[name='apellido_materno']").removeClass('is-invalid');
        }

        function openModelPerson() {
            $('#mpersona').modal('show');
            $('#mperson_title').empty().text('Crear Persona');
        }

        function editPersonAjax(personId) {
            var _token = $("#fcrearpersona").find("input[name='_token']").val();
            $.ajax({
                url: "{{ route('client.getPerson') }}",
                type: 'POST',
                data: {_token: _token, personId: personId},
                success: function (data) {
                    if (data.success) {
                        $("#mpersona").modal("show");
                        $('#mperson_title').empty().text('Editar Persona');
                        setPersonModal(data.person);
                    } else {
                        alert(data.errors);
                    }
                }
            });
        }

        function crearAnalisis(personId) {
            $("#mAnalisis").modal('show');

        }

        function historialAjax(personId) {
            alert("Mostrar Historial: " + personId);
        }

        function setPersonModal(person){
            $("#fcrearpersona").find("input[name='id']").val(person.id);
            $("#fcrearpersona").find("input[name='ci']").val(person.ci);
            $("#fcrearpersona").find("input[name='nombres']").val(person.nombres);
            $("#fcrearpersona").find("input[name='apellidos']").val(person.apellidos);
            $("#fcrearpersona").find("input[name='apellido_materno']").val(person.apellido_materno);
            $("#fcrearpersona").find("input[name='edad']").val(person.edad);
            $("#fcrearpersona").find("input[name='sexo'][value="+person.sexo+"]").attr('checked', 'checked');
        }
    </script>
@endpush