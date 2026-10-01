@extends('layouts.dash', ['activePage' => 'preorders', 'title' => 'Administrar Pre-órdenes', 'navName' => 'Pre-órdenes', 'activeButton' => 'preorderActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Pre-órdenes</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <div class="row">
                {{-- <div class="col-md-12 text-right">
                    <a href="#" class="btn btn-lab-pdm-primary btn-sm" onclick="openModelPreOrder();">Registrar
                        Pre-orden
                    </a>
                </div> --}}
            </div>
        </div>
        <div class="card-body">
            <table id="datatable-preorders" class="table-lab table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>Orden</th>
                    <th>Sucursal</th>
                    <th>Paciente</th>
                    <th>CI</th>
                    <th>Género</th>
                    <th>STAT</th>
                    <th>Estado</th>
                    <th>Creado</th>
                    <th>Acción</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>


@endsection

@section('pageModals')
<!-- Modal registro Pre-orden -->
<div id="mpreorder" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="fcreatepreorder" action="">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="mpreorder_title" class="modal-title ">Crear Pre-orden</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Branch ID</label>
                                <input type="text" name="branch_id" class="form-control" maxlength="80"
                                       placeholder="central-oquendo">
                                <div class="fcp_error_branch_id" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox mt-4">
                                    <input class="custom-control-input" type="checkbox" value="1" id="is_stat" name="is_stat">
                                    <label class="custom-control-label" for="is_stat">
                                        STAT (urgente)
                                    </label>
                                </div>
                                <div class="fcp_error_is_stat" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h6>Paciente</h6>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Nombre completo</label>
                                <input type="text" name="patient[full_name]" class="form-control" maxlength="255"
                                       placeholder="Ana Pérez">
                                <div class="fcp_error_patient.full_name" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Edad</label>
                                <input type="text" name="patient[age]" class="form-control" maxlength="50"
                                       placeholder="42 Años">
                                <div class="fcp_error_patient.age" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Género</label>
                                <select name="patient[gender]" class="form-control">
                                    <option value="">--</option>
                                    <option value="F">F</option>
                                    <option value="M">M</option>
                                    <option value="O">O</option>
                                </select>
                                <div class="fcp_error_patient.gender" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>CI</label>
                                <input type="text" name="patient[ci]" class="form-control" maxlength="30"
                                       placeholder="5948302 CBBA">
                                <div class="fcp_error_patient.ci" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>F. Nacimiento</label>
                                <input type="date" name="patient[birth_date]" class="form-control">
                                <div class="fcp_error_patient.birth_date" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Diagnóstico</label>
                                <input type="text" name="patient[diagnosis]" class="form-control" maxlength="500">
                                <div class="fcp_error_patient.diagnosis" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Médico</label>
                                <input type="text" name="patient[physician]" class="form-control" maxlength="200">
                                <div class="fcp_error_patient.physician" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h6>Tests (JSON array)</h6>
                    <div class="form-group">
                        <label>Tests</label>
                        <textarea name="tests_json" class="form-control" rows="6" maxlength="5000"
                                  placeholder='[{"id":"hem-01","test_name":"Hemograma completo automatizado","category_name":"Hematología"}]'></textarea>
                        <small class="form-text text-muted">Array JSON. Cada item: id, test_name, category_name.</small>
                        <div class="fcp_error_tests" style="display: none;"></div>
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

<!-- Modal Eliminar Pre-orden -->
<div id="mDeletePreOrder" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form onsubmit="deletePreOrderAjax(); return false;">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title ">Eliminar Pre-orden</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <p class="text-danger">Esta seguro de eliminar la Pre-orden?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {

            $('#datatable-preorders').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('preorder.datatablesPreOrderData') }}",
                columns: [
                    {name: 'order_number'},
                    {name: 'branch_id'},
                    {name: 'patient_full_name'},
                    {name: 'patient_ci'},
                    {name: 'patient_gender'},
                    {name: 'is_stat'},
                    {name: 'state'},
                    {name: 'created_at'},
                    {name: 'action', orderable: false, searchable: false}
                ],
                order: [[7, 'desc']],
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


            $("#fcreatepreorder").submit(function (event) {
                event.preventDefault();

                clearErrorMsg();

                var _token = $(this).find("input[name='_token']").val();
                var id = $(this).find("input[name='id']").val();
                var branch_id = $(this).find("input[name='branch_id']").val();
                var is_stat = $(this).find("input[name='is_stat']").is(':checked') ? 1 : 0;
                var p_full_name = $(this).find("input[name='patient[full_name]']").val();
                var p_age = $(this).find("input[name='patient[age]']").val();
                var p_gender = $(this).find("select[name='patient[gender]']").val();
                var p_ci = $(this).find("input[name='patient[ci]']").val();
                var p_birth_date = $(this).find("input[name='patient[birth_date]']").val();
                var p_diagnosis = $(this).find("input[name='patient[diagnosis]']").val();
                var p_physician = $(this).find("input[name='patient[physician]']").val();

                var tests_raw = $(this).find("textarea[name='tests_json']").val();
                var tests;
                try {
                    tests = JSON.parse(tests_raw || '[]');
                } catch (e) {
                    alert('JSON inválido en sección tests: ' + e.message);
                    return;
                }

                $.ajax({
                    url: "{{ route('preorder.createPreOrder') }}",
                    type: 'POST',
                    data: {
                        _token: _token,
                        id: id,
                        branch_id: branch_id,
                        is_stat: is_stat,
                        patient: {
                            full_name: p_full_name,
                            age: p_age,
                            gender: p_gender,
                            ci: p_ci,
                            birth_date: p_birth_date,
                            diagnosis: p_diagnosis,
                            physician: p_physician
                        },
                        tests: tests
                    },
                    success: function (data) {
                        if (data.success) {
                            $("#mpreorder").modal("hide");
                            $('#datatable-preorders').DataTable().ajax.reload();
                        } else {
                            alert(data.errors || 'Error desconocido');
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        printErrorMsg($("#fcreatepreorder"), JSON.parse(XMLHttpRequest.responseText));
                    }
                });
            });
        });

        function openModelPreOrder() {
            clearErrorMsg();
            $('#mpreorder').modal('show');
            $("#fcreatepreorder").find("input[name='id']").val('');
            $("#fcreatepreorder").find("input[name='branch_id']").val('');
            $("#fcreatepreorder").find("input[name='is_stat']").prop('checked', false);
            $("#fcreatepreorder").find("input[name='patient[full_name]']").val('');
            $("#fcreatepreorder").find("input[name='patient[age]']").val('');
            $("#fcreatepreorder").find("select[name='patient[gender]']").val('');
            $("#fcreatepreorder").find("input[name='patient[ci]']").val('');
            $("#fcreatepreorder").find("input[name='patient[birth_date]']").val('');
            $("#fcreatepreorder").find("input[name='patient[diagnosis]']").val('');
            $("#fcreatepreorder").find("input[name='patient[physician]']").val('');
            $("#fcreatepreorder").find("textarea[name='tests_json']").val('');
            $('#mpreorder_title').empty().text('Crear Pre-orden');
        }

        function editPreOrderAjax(preorderId){
            var _token = $("#fcreatepreorder").find("input[name='_token']").val();
            clearErrorMsg();
            $.ajax({
                url: "{{ route('preorder.getPreOrder') }}",
                type: 'POST',
                data: {_token: _token, id: preorderId},
                success: function (data) {
                    if (data.success) {
                        $("#mpreorder").modal("show");
                        $('#mpreorder_title').empty().text('Editar Pre-orden');

                        var p = data.preorder;
                        $("#fcreatepreorder").find("input[name='id']").val(p.id);
                        $("#fcreatepreorder").find("input[name='branch_id']").val(p.branch_id);
                        $("#fcreatepreorder").find("input[name='is_stat']").prop('checked', !!p.is_stat);
                        $("#fcreatepreorder").find("input[name='patient[full_name]']").val(p.patient.full_name);
                        $("#fcreatepreorder").find("input[name='patient[age]']").val(p.patient.age);
                        $("#fcreatepreorder").find("select[name='patient[gender]']").val(p.patient.gender);
                        $("#fcreatepreorder").find("input[name='patient[ci]']").val(p.patient.ci);
                        $("#fcreatepreorder").find("input[name='patient[birth_date]']").val(p.patient.birth_date);
                        $("#fcreatepreorder").find("input[name='patient[diagnosis]']").val(p.patient.diagnosis);
                        $("#fcreatepreorder").find("input[name='patient[physician]']").val(p.patient.physician);
                        $("#fcreatepreorder").find("textarea[name='tests_json']").val(JSON.stringify(p.tests, null, 2));
                    } else {
                        alert(data.errors || 'Error desconocido');
                    }
                }
            });
        }

        function openDeletePreOrderAjax(preorderId){
            $("#mDeletePreOrder").modal("show");
            $("#mDeletePreOrder input[name='id']").val(preorderId);
        }

        function deletePreOrderAjax(){
            var _token = $("#fcreatepreorder").find("input[name='_token']").val();
            var preorderId = $("#mDeletePreOrder input[name='id']").val();
            clearErrorMsg();
            $.ajax({
                url: "{{ url('/preorder/ajaxDelete') }}/" + preorderId,
                type: 'POST',
                data: { _token },
                success: function (data) {
                    if (data.success) {
                        $("#mDeletePreOrder").modal("hide");
                        $('#datatable-preorders').DataTable().ajax.reload();
                    } else {
                        alert(data.message || data.errors || 'Error al eliminar');
                    }
                }
            });
        }

        function clearErrorMsg() {
            var fields = [
                'branch_id', 'is_stat',
                'patient.full_name', 'patient.age', 'patient.gender',
                'patient.ci', 'patient.birth_date',
                'patient.diagnosis', 'patient.physician',
                'tests'
            ];
            $.each(fields, function (i, key) {
                $('.fcp_error_' + key).empty().hide();
            });
            $("#fcreatepreorder").find("input,select,textarea").removeClass('is-invalid');
        }

        function printErrorMsg(form, msg) {
            $.each(msg.errors, function (key, value) {
                var selector = ".fcp_error_" + key;
                $(selector).each(function () {
                    var msgs = "<ul class='list-unstyled'>";
                    $.each(value, function (k1, v1) {
                        msgs += "<li><span class='text-danger'>" + v1 + "</span></li>";
                    });
                    msgs += "</ul>";
                    $(this).empty().append(msgs).show();
                });

                var byName = $(form).find("[name='" + key + "']");
                if (byName.length === 0) {
                    byName = $(form).find("[name='patient[" + key.split('.')[1] + "]']");
                }
                byName.addClass('is-invalid');
            });
        }
    </script>
@endpush
