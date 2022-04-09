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
                <div class="col-md-6 text-right">
{{--                    <a href="#" class="btn btn-primary" onclick="openModelPerson();">Registrar Cliente</a>--}}
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
                    <div class="form-group">
                        <label for="apellido_ma">Apellido Materno</label>
                        <input type="text" name="apellidos_ma" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="apellido_ma">.</label>
                        <div>
                            <a href="#" class="btn btn-primary btn-sm" onclick="openModelPerson();"><i class="far fa-plus-square"></i></a>
                            <a href="#" class="btn btn-primary btn-sm" onclick="clearSearch(this);"><i class="fas fa-eraser"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="simple-datatable-example" class="table table-clinica">
                    <thead class="thead-dark">
                    <tr>
                        <th>CI</th>
                        <th>Nombres</th>
                        <th>Ape. Paterno</th>
                        <th>Ape. Materno</th>
                        <th>Fecha nacimiento</th>
                        <th>Fecha creacion</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal registro persona-->
    <div id="mpersona" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
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
                                    <input type="text" name="ci" class="form-control" placeholder="Carnet de identidad" onchange="searchClient(this);">
                                    <div class="fcp_error_ci" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nombres <span class="text-danger">*</span></label>
                                    <input type="text" name="nombres"
                                           onkeyup="uppercaseInput(this);"
                                           onchange="searchClient(this);"
                                           class="form-control" placeholder="Nombres">
                                    <div class="fcp_error_nombres" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="apellidos">Apellido Paterno <span class="text-danger">*</span></label>
                                    <input type="text" name="apellidos"
                                           class="form-control"
                                           onkeyup="uppercaseInput(this);"
                                           onchange="searchClient(this);"
                                           placeholder="Apellido Paterno">
                                    <div class="fcp_error_apellidos" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="apellido_materno">Apellido Materno</label>
                                    <input type="text" name="apellido_materno"
                                           class="form-control"
                                           onkeyup="uppercaseInput(this);"
                                           onchange="searchClient(this);"
                                           placeholder="Apellido Materno">
                                    <div class="fcp_error_apellido_materno" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
{{--                                <div class="form-group">--}}
{{--                                    <label for="edad">Edad</label>--}}
{{--                                    <input type="number" name="edad" class="form-control" onchange="searchClient(this);">--}}
{{--                                    <div class="fcp_error_edad" style="display: none;"></div>--}}
{{--                                </div>--}}
                                <div class="form-group">
                                    <label for="f_nacimiento">Fecha nacimiento</label>
                                    <input type="date" name="f_nacimiento" class="form-control">
                                    <div class="fcp_error_f_nacimiento" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="sexo1">Sexo <span class="text-danger">*</span></label>
                                <br>

                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="sexo1" name="sexo" value="hombre" class="custom-control-input">
                                    <label class="custom-control-label" for="sexo1">Hombre</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="sexo2" name="sexo" value="mujer" class="custom-control-input">
                                    <label class="custom-control-label" for="sexo2">Mujer</label>
                                </div>
                                <div class="fcp_error_sexo" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="crear_analisis" onchange="showhideCrearAnalisis(this);" id="customControlValidation1" value="1" checked>
                            <label class="custom-control-label" for="customControlValidation1">Crear Analisis</label>
                        </div>
                        <div id="d_crear_analisis" style="display: inline;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_analisis">Tipo Analisis <span class="text-danger">*</span></label>
                                        <select name="tipo_analisis" id="s_tipoanalisis" onchange="getCodigo();" class="form-control">
                                            <option value="">Elija un Analisis</option>
                                            @foreach($tipoAnalisis as $analisis)
                                                <option value="{{$analisis}}">{{ __('clinica_msg.'.$analisis) }}</option>
                                            @endforeach
                                        </select>
                                        <div class="fcp_error_tipo_analisis" style="display: none;"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_analisis">Codigo</label>
                                        <input type="text" name="codigo" id="i_codigo" class="form-control i-codigo" readonly>
                                        <div class="fcp_error_codigo" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="region">Region de analisis <span class="text-danger">*</span></label>
                                        <input type="text" id="region" name="region" class="form-control">
                                        <div class="fcp_error_region" style="display: none;"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="precio">Precio <span class="text-danger">*</span></label>
                                        <input type="text" name="precio" class="form-control">
                                        <div class="fcp_error_precio" style="display: none;"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="acuenta">Acuenta</label>
                                    <input type="text" name="acuenta" class="form-control">
                                    <div class="fcp_error_acuenta" style="display: none;"></div>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table1 = $('#simple-datatable-example').DataTable({
                fixedHeader: true,
                searchDelay: 4000,
                searching: true,
                serverSide: true,
                // processing: true,
                responsive: true,
                // deferRender: true,
                // bFilter: false,
                ajax: "{{ route('simple_datatables_persons_data') }}",
                columns: [
                    {name: 'ci'},
                    {name: 'nombres', orderable: false, searchable: true},
                    {name: 'apellidos'},
                    {name: 'apellido_materno'},
                    {name: 'f_nacimiento'},
                    {name: 'created_at', orderable: false, searchable: false},
                    {name: 'action', orderable: false, searchable: false}
                ],
                "pagingType": "full_numbers",
                "order": [[ 4, "desc" ]],
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

            $('input[name="s_nombres"]').on( 'keyup', function () {
                table1.column(1).search(
                    $(this).val()
                ).draw();
            } );
            $('input[name="apellidos_pa"]').on( 'keyup', function () {
                table1.column(2).search(
                    $(this).val()
                ).draw();
            } );
            $('input[name="apellidos_ma"]').on( 'keyup', function () {
                table1.column(3).search(
                    $(this).val()
                ).draw();
            } );
            $("#simple-datatable-example_filter").css('display', 'none');

            $("#mpersona").on('shown.bs.modal', function (event) {
                $("#fcrearpersona")[0].reset();
                $("#fcrearpersona").find("input[name='id']").val('');
                $( "#d_crear_analisis" ).show();
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
                var f_nacimiento = $(this).find("input[name='f_nacimiento']").val();
                var sexo = $(this).find("input[name='sexo']:checked").val();
                // Datos para crear Analisis
                var crear_analisis = $(this).find("input[name='crear_analisis']").is(':checked');
                var tipo_analisis = $(this).find("select[name='tipo_analisis']").val();
                var codigo = $(this).find("input[name='codigo']").val();
                var precio = $(this).find("input[name='precio']").val();
                var acuenta = $(this).find("input[name='acuenta']").val();
                var region = $(this).find("input[name='region']").val();

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
                        f_nacimiento: f_nacimiento,
                        sexo: sexo,
                        crear_analisis: crear_analisis,
                        tipo_analisis: tipo_analisis,
                        codigo: codigo,
                        region: region,
                        precio: precio,
                        acuenta: acuenta
                    },
                    success: function (data) {
                        if (data.success) {
                            if(crear_analisis){
                                $("#mpersona").modal("hide");
                                // alert(data.url_print_recibo);
                                window.open(data.url_print_recibo, '_blank');
                                window.location.href = data.url;
                            }else{
                                if(id !== ''){
                                    $("#mpersona").modal("hide");
                                    $('#simple-datatable-example').DataTable().ajax.reload();
                                } else {
                                    window.location.href = data.url;
                                }
                            }
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

            $('.fcp_error_tipo_analisis').empty();
            $('.fcp_error_codigo').empty();
            $('.fcp_error_precio').empty();
            $('.fcp_error_acuenta').empty();

            $("#fcrearpersona").find("input[name='ci']").removeClass('is-invalid');
            $("#fcrearpersona").find("input[name='nombres']").removeClass('is-invalid');
            $("#fcrearpersona").find("input[name='apellidos']").removeClass('is-invalid');
            $("#fcrearpersona").find("input[name='apellido_materno']").removeClass('is-invalid');

            $("#fcrearpersona").find("select[name='tipo_analisis']").removeClass('is-invalid');
            $("#fcrearpersona").find("input[name='codigo']").removeClass('is-invalid');
            $("#fcrearpersona").find("input[name='precio']").removeClass('is-invalid');
            $("#fcrearpersona").find("input[name='acuenta']").removeClass('is-invalid');
        }

        function openModelPerson() {
            $('#mpersona').modal('show');
            $('#mperson_title').empty().text('Crear Persona');
            $('#mpersona input[name="nombres"]').val($('input[name="s_nombres"]').val().toUpperCase());
            $('#mpersona input[name="apellidos"]').val($('input[name="apellidos_pa"]').val().toUpperCase());
            $('#mpersona input[name="apellido_materno"]').val($('input[name="apellidos_ma"]').val().toUpperCase());
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
            $("#fcrearpersona").find("input[name='f_nacimiento']").val(person.f_nacimiento);
            $("#fcrearpersona").find("input[name='sexo'][value="+person.sexo+"]").attr('checked', 'checked');
        }

        function searchClient(input){
            var ci = $('#fcrearpersona').find("input[name='ci']").val();
            var nombres = $('#fcrearpersona').find("input[name='nombres']").val();
            var apellidos = $('#fcrearpersona').find("input[name='apellidos']").val();
            var apellido_materno = $('#fcrearpersona').find("input[name='apellido_materno']").val();
            var edad = $('#fcrearpersona').find("input[name='edad']").val();
            var sexo = $('#fcrearpersona').find("input[name='sexo']:checked").val();

            $.ajax({
                url: "{{ route('client.searchAjaxPerson') }}",
                type: 'POST',
                data: {
                    // _token: _token,
                    ci: ci,
                    nombres: nombres,
                    apellidos: apellidos,
                    apellido_materno: apellido_materno,
                    edad: edad,
                },
                success: function (data) {
                    if (data.success) {
                        getTdPerson(data.persons);

                    } else {
                        alert(data.errors);
                    }
                }
            });
        }

        function getTdPerson(persons){
            var html = "";
            $.each(persons, function(index, person){
                html += "<tr>";
                html += "<td>"+person.ci+"</td>";
                html += "<td>"+person.nombres+"</td>";
                html += "<td>"+person.apellidos+"</td>";
                html += "<td>"+person.apellido_materno+"</td>";
                html += "<td>"+person.edad+"</td>";
                if(person.sexo != null)
                    html += "<td>"+person.sexo.toUpperCase()+"</td>";
                else
                    html += "<td>--</td>";

                html += "<td>";

                html += "<a href='{{url('/analisis/crear_analisis')}}/"+person.id+"' class='btn btn-link float-right' title='Crear Analisis'>";
                html += "<i class='fas fa-notes-medical fa-lg'></i>";
                html += "</a>";
                html += "";

                html += "</td>";
                html += "</tr>";
            });
            $('#tableResultPerson tbody').empty().append(html);
        }

        function clearSearch(link){
            inputs = $(link).parent().parent().parent().parent().find('input[type="text"]');
            $.each(inputs, function (index, input) {
               $(input).val('');
            });
            return false;
        }

        function showhideCrearAnalisis(check){
            if($(check).is(':checked')){
                $( "#d_crear_analisis" ).show();
            } else {
                $( "#d_crear_analisis" ).hide();
            }

        }
    </script>
@endpush
