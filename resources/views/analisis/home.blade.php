@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Administrar Analisis', 'navName' => 'Analisis', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Analisis</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body ">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nombres">Nombres</label>
                        <input type="text" name="nombres" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nombres">Apellido</label>
                        <input type="text" name="apellidos" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">

                </div>
            </div>
            <div class="table-responsive">
                <table id="tAnalisis" class="table table-bordered table-clinica">
                    <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Codigo</th>
                        <th>Cliente</th>
                        <th>Ap</th>
                        <th>Ap Ma</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>R. de análisis</th>
                        <th>Doctor Asignado</th>
                        <th>Procedencia</th>
                        <th>Precio</th>
                        <th>A cuenta</th>
                        <th>Pago</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                        <th>Persona Entrega</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Pago -->
    <div class="modal fade" id="pagoModal" tabindex="-1" role="dialog" aria-labelledby="pagoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="f_realizarpago">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pagoModalLabel">Realizar Pago</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body m-pago-p">
                        <input type="hidden" name="analisis_id" id="i_analisis_id">
                        <div class="row">
                            <div class="col-md-6">
                                <p><b>Cliente: </b> <span id="pago_cliente">Maria Jose</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><b>Doctor: </b> <span id="pago_doctor">Carlos Terrazas</span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><b>Precio: </b> <span id="pago_precio"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><b>A cuenta: </b> <span id="pago_acuenta"></span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: right;">
                                <p style="color: #FF9500; font-size: 1rem;"><b>PAGO: </b> <span id="pago_pago"></span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nit">Nit</label>
                                    <input id="realizar_pago_nit" type="text" name="nit" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="razon_social">Razon Social</label>
                                    <input id="realizar_pago_razon_social" type="text" name="razon_social" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Realizar Pago</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Fecha de Entrega -->
    <div class="modal fade" id="fechaEntregaModal" tabindex="-1" role="dialog" aria-labelledby="fechaentregaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="f_fechaentrega">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fechaentregaModalLabel">Fecha de Entrega de analisis</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body m-pago-p">
                        <input type="hidden" name="analisis_id">
                        <div class="form-group">
                            <label for="persona_entrega">Persona a quien entrega</label>
                            <input type="text" name="persona_entrega"
                                   class="form-control"
                                   placeholder="Nombres"
                                   onkeyup="uppercaseInput(this);"
                            >
                            <div class="fcp_error_persona_entrega" style="display: none;"></div>
                        </div>
                        <div class="form-group">
                            <label for="fecha_entrega">Fecha de entrega</label>
                            <input type="date" name="fecha_entrega" class="form-control"
                                   value="{{date('Y-m-d')}}"
                                   min="{{date('Y-m-d', strtotime("-100 days"))}}"
                                   max="{{date('Y-m-d', strtotime("5 days"))}}"
                            >
                            <div class="fcp_error_fecha_entrega" style="display: none;"></div>
                        </div>
                        <span class="font-weight-bold text-success">Esta fecha es la que se imprime en el resultado del análisis</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" onclick="saveFechaEntrega();" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Cerrar Analisis -->
    <div class="modal fade" id="cerrarAnalisisModal" tabindex="-1" role="dialog" aria-labelledby="cerrarAnalisisModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="f_cerraranalisis">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cerrarAnalisisModalLabel">Conclusión de Análisis</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body m-pago-p">
                        <input type="hidden" name="analisis_id">
                        <div class="form-group">
                            <label for="fecha_cierre">Fecha de Conclusión del Analisis</label>
                            <input type="date" name="fecha_cierre" class="form-control"
                                   value="{{date('Y-m-d')}}"
                                   min="{{date('Y-m-d', strtotime("-100 days"))}}"
                                   max="{{date('Y-m-d', strtotime("2 days"))}}"
                            >
                            <div class="fcp_error_fecha_cierre" style="display: none;"></div>
                        </div>
                        <span class="font-weight-bold text-success">Esta fecha es de conclusión del análisis</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" onclick="saveCerrarAnalisis();" class="btn btn-primary">Registrar</button>
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

            var table = $('#tAnalisis').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                deferRender: true,
                ajax: "{{ route('simple_datatables_analisis_data') }}",
                columns: [
                    {name: 'id', visible: false},
                    {name: 'codigo'},
                    // {name: 'nombres', orderable: true},
                    {name: 'person.nombres', orderable: false},
                    {name: 'person.apellidos', orderable: false, visible: false},
                    {name: 'person.apellido_materno', orderable: false, visible: false},
                    {name: 'fecha', orderable: false},
                    {name: 'tipo_analisis'},
                    {name: 'region', orderable: false},
                    {name: 'doctorasig.nombres', orderable: false},
                        @can('manage-users')
                    {name: 'institucion.nombre'},
                    {name: 'precio', searchable: false},
                    {name: 'acuenta', searchable: false},
                    {name: 'pago_efectuado', searchable: false},

                    @else
                    {name: 'institucion.nombre', visible: false},
                    {name: 'precio', searchable: false, visible: false},
                    {name: 'acuenta', searchable: false, visible: false},
                    {name: 'pago_efectuado', searchable: false, visible: false},
                        @endcan
                    {name: 'precio1', orderable: false, searchable: false},
                    {name: 'action', orderable: false, searchable: false},
                    {name: 'persona_entrega', visible: false},
                    {name: 'fecha_cierre', visible: false}
                ],
                // aoColumnDefs: [
                //     {
                //         "targets": [10],
                //         "visible": false,
                //         "searchable": false
                //     }
                // ],
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
            });

            $('#f_realizarpago').submit(function( event ) {
                savePago();
                event.preventDefault();
            });

            $('input[name="nombres"]').on( 'keyup', function () {
                table.column(2).search(
                    $(this).val()
                ).draw();
            } );
            $('input[name="apellidos"]').on( 'keyup', function () {
                table.column(3).search(
                    $(this).val()
                ).draw();
            } );

        });

        function clearErrorMsg() {
            $('.fcp_error_persona_entrega').empty();
            $('.fcp_error_fecha_entrega').empty();

            $("#f_fechaentrega").find("input[name='persona_entrega']").removeClass('is-invalid');
            $("#f_fechaentrega").find("input[name='fecha_entrega']").removeClass('is-invalid');
        }

        function openModalPago(link){
            analisisId = $(link).data('id');
            $.ajax({
                url: "{{ route('analisis.aGetAnalisisPago') }}",
                type: 'POST',
                data: {'analisis_id': analisisId},
                success: function (data) {
                    $('#pago_cliente').empty().append(data.success.cliente);
                    $('#pago_doctor').empty().append(data.success.doctor);
                    $('#pago_precio').empty().append(data.success.precio);
                    $('#pago_acuenta').empty().append(data.success.acuenta);
                    $('#pago_pago').empty().append(data.success.precio-data.success.acuenta);
                    $('#i_analisis_id').val(analisisId);
                    $('#realizar_pago_nit').val(data.success.nit);
                    $('#realizar_pago_razon_social').val(data.success.razon_social);

                    $('#pagoModal').modal('show');
                },
            });
        }

        function savePago(){
            var analisisId = $('#i_analisis_id').val();
            var nit = $('#realizar_pago_nit').val();
            var razon_social = $('#realizar_pago_razon_social').val();
            $.ajax({
                url: "{{ route('analisis.aSavePago') }}",
                type: 'POST',
                data: {'analisis_id': analisisId, 'nit': nit, 'razon_social': razon_social},
                success: function (data) {
                    $('#pagoModal').modal('hide');
                    $('#tAnalisis').DataTable().ajax.reload();
                }

            });
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

        function openModalFechaEntrega(link) {
            $.ajax({
                url: "{{ route('analisis.aGetAnalisisById') }}",
                type: 'POST',
                data: {analisis_id: $(link).data('id')},
                success: function (data) {
                    if(data.success == 1){
                        $('#fechaEntregaModal').modal('show');
                        clearErrorMsg();
                        $('#f_fechaentrega')[0].reset();
                        $('#f_fechaentrega input[name="analisis_id"]').val($(link).data('id'));



                        if(data.analisis.fecha_entrega !== null){
                            $('#f_fechaentrega input[name="fecha_entrega"]').val(data.analisis.fecha_entrega.split(' ')[0]);
                        } else {
                            var now = new Date();

                            var day = ("0" + now.getDate()).slice(-2);
                            var month = ("0" + (now.getMonth() + 1)).slice(-2);

                            var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
                            $('#f_fechaentrega input[name="fecha_entrega"]').val(today);
                        }
                        if(data.analisis.persona_entrega !== null){
                            $('#f_fechaentrega input[name="persona_entrega"]').val(data.analisis.persona_entrega);
                        } else {
                            $('#f_fechaentrega input[name="persona_entrega"]').val('');
                        }

                    } else {
                        alert("Ocurrio un error por favor contactese  con el administrador.");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    // printErrorMsg($("#f_fechaentrega"), JSON.parse(XMLHttpRequest.responseText));
                }
            });
        }

        function openModalCerrarAnalisis(link) {
            $.ajax({
                url: "{{ route('analisis.aGetAnalisisById') }}",
                type: 'POST',
                data: {analisis_id: $(link).data('id')},
                success: function (data) {
                    // alert(data.analisis.fecha_cierre);

                    if(data.success == 1){
                        $('#cerrarAnalisisModal').modal('show');
                        $('#f_cerraranalisis')[0].reset();
                        $('#f_cerraranalisis input[name="analisis_id"]').val($(link).data('id'));
                        // $('#f_cerraranalisis input[name="fecha_cierre"]').val(data.analisis.fecha_cierre);
                        if(data.analisis.fecha_cierre !== null){
                            $('#f_cerraranalisis input[name="fecha_cierre"]').val(data.analisis.fecha_cierre.split(' ')[0]);
                        } else {
                            $('#f_cerraranalisis input[name="fecha_cierre"]').val('');
                        }

                    } else {
                        alert("Ocurrio un error por favor contactese  con el administrador.");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    // printErrorMsg($("#f_fechaentrega"), JSON.parse(XMLHttpRequest.responseText));
                }
            });
        }

        function saveFechaEntrega(){
            var analisisId = $('#f_fechaentrega input[name="analisis_id"]').val();
            var persona_entrega = $('#f_fechaentrega input[name="persona_entrega"]').val();
            var fecha_entrega = $('#f_fechaentrega input[name="fecha_entrega"]').val();
            $.ajax({
                url: "{{ route('analisis.aSaveFechaEntrega') }}",
                type: 'POST',
                data: {analisis_id: analisisId,
                    persona_entrega: persona_entrega,
                    fecha_entrega: fecha_entrega},
                success: function (data) {
                    if(data.success == 1){
                        $('#fechaEntregaModal').modal('hide');
                        $('#tAnalisis').DataTable().ajax.reload();
                    } else {
                        alert("Ocurrio un error por favor contactese  con el administrador.");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    printErrorMsg($("#f_fechaentrega"), JSON.parse(XMLHttpRequest.responseText));
                }
            });
        }

        function saveCerrarAnalisis(){
            var analisisId = $('#f_cerraranalisis input[name="analisis_id"]').val();
            var fecha_cierre = $('#f_cerraranalisis input[name="fecha_cierre"]').val();
            $.ajax({
                url: "{{ route('analisis.aSaveFechaCierre') }}",
                type: 'POST',
                data: {analisis_id: analisisId,
                    fecha_cierre: fecha_cierre},
                success: function (data) {
                    if(data.success == 1){
                        $('#cerrarAnalisisModal').modal('hide');
                        $('#tAnalisis').DataTable().ajax.reload();
                    } else {
                        alert("Ocurrio un error por favor contactese  con el administrador.");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    printErrorMsg($("#f_cerraranalisis"), JSON.parse(XMLHttpRequest.responseText));
                }
            });
        }
    </script>
@endpush