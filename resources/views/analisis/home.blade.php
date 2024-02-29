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
            @can('manage-users')
            <button class="btn btn-success" data-toggle="modal" data-target="#crearAnalisisRangoModal">Crear rango de analisis</button>
            @endcan
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nombres">Nombres</label>
                        <input type="text" name="nombres" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nombres">Apellido</label>
                        <input type="text" name="apellidos" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="doctor">Doctores</label>
                        <select name="doctor" class="form-control form-control-sm">
                            <option value="">Seleccione</option>
                            @foreach($doctores as $dr)
                                <option value="{{$dr->id}}">{{$dr->nombres}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tAnalisis" class="table table-clinica">
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
                        <div class="form-group">
                            <label>Tipo de pago</label>
                            <br>
                            @foreach($tipoPagoEfectuado as $i => $tipo_pago)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_pago_efectuado"
                                           id="tipo_pago_efectuado_{{$i}}" value="{{$tipo_pago}}" {{($i==0)? 'checked' : ''}}>
                                    <label class="form-check-label" style="padding-left: 2px !important;" for="tipo_pago_efectuado_{{$i}}">{{$tipo_pago}}</label>
                                </div>
                            @endforeach
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
                                    <input id="realizar_pago_razon_social" type="text" name="razon_social" class="form-control" onkeyup="uppercaseInput(this);" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fecha_pago_efectuado">Fecha</label>
                                    <input id="realizar_pago_fecha" value="{{date('Y-m-d')}}" min="{{$date7}}" max="{{$dateNow}}"  type="date" name="fecha_pago_efectuado" class="form-control" required>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_entrega">Fecha de entrega</label>
                                    <input type="date" name="fecha_entrega" class="form-control"
                                           value="{{date('Y-m-d')}}"
                                           min="{{date('Y-m-d', strtotime("-100 days"))}}"
                                           max="{{date('Y-m-d', strtotime("5 days"))}}"
                                    >
                                    <div class="fcp_error_fecha_entrega" style="display: none;"></div>
                                </div>
                            </div>
{{--                            <div class="col-md-6">--}}
{{--                                <label for="hora_entrega">Hora</label>--}}
{{--                                <input type="time" name="hora_entrega" class="form-control">--}}
{{--                                <div class="fcp_error_hora_entrega" style="display: none;"></div>--}}
{{--                            </div>--}}
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

    <!-- Modal Enviar mensaja SMS Analisis -->
    <div class="modal fade" id="enviarSmsAnalisisModal" tabindex="-1" role="dialog" aria-labelledby="enviarSmsAnalisisModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="f_enviarsmsanalisis" onsubmit="sendSmsAnalisis(this);  return false;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="enviarSmsAnalisisModalLabel">Enviar SMS al paciente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="analisis_id">
                        <dl>
                            <dt>Paciente:</dt>
                            <dd id="m_paciente_nombres"></dd>
                            <dt>Codigo analisis</dt>
                            <dd id="m_analisis_codigo"></dd>
                        </dl>
                        <div class="row">
                            <div class="col-md-3">
                                <dl>
                                    <dt>Precio</dt>
                                    <dd id="m_analisis_precio"></dd>
                                </dl>

                            </div>
                            <div class="col-md-3">
                                <dl>
                                    <dt>Acuenta</dt>
                                    <dd id="m_analisis_acuenta"></dd>
                                </dl>
                            </div>
                            <div class="col-md-3">
                                <dl>
                                    <dt>P. efectuado</dt>
                                    <dd id="m_analisis_pago_efectuado"></dd>
                                </dl>
                            </div>
                            <div class="col-md-3">
                                <dl>
                                    <dt>Estado</dt>
                                    <dd id="m_analisis_estado"></dd>
                                </dl>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="m_analisis_celular">Celular:</label>
                            <input type="text" name="s_celular" id="m_analisis_celular" value="" class="form-control">
                            <div class="fcp_error_s_celular" style="display: none;"></div>
                        </div>
                        <div class="form-group">
                            <label for="s_texto">Mensaje</label>
                            <textarea name="s_texto" id="s_texto" class="form-control" style="resize: none;" rows="6"></textarea>
                            <div class="fcp_error_s_texto" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button id="f_enviarsmsanalisis_submit" type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Enviar mensaja Whatsapp Analisis -->
    <div class="modal fade" id="enviarWappAnalisisModal" tabindex="-1" role="dialog" aria-labelledby="enviarWappAnalisisModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="f_enviarwappanalisis" onsubmit="sendWappAnalisis(this);  return false;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="enviarWappAnalisisModalLabel">Enviar mensaje whatsapp al paciente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="analisis_id">
                        <p class="text-success"><b>Convenio: </b><span class="m_paciente_convenio"></span></p>
                        <dl>
                            <dt>Paciente:</dt>
                            <dd class="m_paciente_nombres"></dd>
                            <dt>Codigo analisis</dt>
                            <dd class="m_analisis_codigo"></dd>
                        </dl>
                        <div class="row">
                            <div class="col-md-3">
                                <dl>
                                    <dt>Precio</dt>
                                    <dd class="m_analisis_precio"></dd>
                                </dl>

                            </div>
                            <div class="col-md-3">
                                <dl>
                                    <dt>Acuenta</dt>
                                    <dd class="m_analisis_acuenta"></dd>
                                </dl>
                            </div>
                            <div class="col-md-3">
                                <dl>
                                    <dt>P. efectuado</dt>
                                    <dd class="m_analisis_pago_efectuado"></dd>
                                </dl>
                            </div>
                            <div class="col-md-3">
                                <dl>
                                    <dt>Estado</dt>
                                    <dd class="m_analisis_estado"></dd>
                                </dl>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Celular:</label>
                            <input type="text" name="s_celular" value="" class="form-control m_analisis_celular">
                            <div class="fcp_error_s_celular" style="display: none;"></div>
                        </div>
                        <div class="form-group">
                            <label for="s_texto">Mensaje</label>
                            <textarea name="s_texto" class="form-control s_texto" style="resize: none;" rows="6"></textarea>
                            <div class="fcp_error_s_texto" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button id="f_enviarWappanalisis_submit" type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Pago -->
    <div class="modal fade" id="crearAnalisisRangoModal" tabindex="-1" role="dialog" aria-labelledby="crearAnalisisRangoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="f_crearrangoanalisis" onsubmit="sendCreateRangoAnalisis(this); return false;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearAnalisisRangoModalLabel">Crear rango de analisis</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="procedencia">Procedencia</label>
                                <select name="procedencia" id="procedencia" class="form-control" required>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="analisis">Analisis</label>
                                <select name="analisis" id="analisis" class="form-control" onchange="getCodigoAnalisis(this)" required>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="cantidad">Cantidad</label>
                                <select name="cantidad" id="cantidad" class="form-control" required>
{{--                                    <option value="1">1</option>--}}
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="">Codigo inicio</label>
                                <input type="text" disabled class="form-control" value="" name="codigo">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Crear rango</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Cerrar Analisis -->
    <div class="modal fade" id="fechaCierreModal" tabindex="-1" role="dialog" aria-labelledby="fcModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fcModalLabel">Cerrar análisis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
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
                // deferRender: true,
                ajax: {
                    url: "{{ route('simple_datatables_analisis_data') }}",
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
                    {name: 'id', visible: false},
                    {name: 'codigo'},
                    // {name: 'nombres', orderable: true},
                    {name: 'person.nombres', orderable: false},
                    {name: 'person.apellidos', orderable: false, visible: false},
                    {name: 'person.apellido_materno', orderable: false, visible: false},
                    {name: 'fecha', orderable: false, searchable: false},
                    {name: 'tipo_analisis', "render": function ( data, type, row ) {
                            if(data === '{{\App\Analisis::HISTOPATOLOGICO}}'){
                                return '{{\App\Analisis::BIOPSIA_DE_RINON}}';
{{--                                return '{{\App\Analisis::BIOPSIA}}';--}}
                            } else {
                                return data;
                            }
                        }},
                    {name: 'region', orderable: false, "render": function ( data, type, row ) {

                            if(typeof data === "string" &&  data.length === 0){
                                return '';
                            } else {
                                try{
                                    if($(data).text().length > 19){
                                        return $(data).text().slice(0, 20) + "...";
                                    } else {
                                        return $(data).text();
                                    }
                                } catch(err) {
                                    return data;
                                }


                            }
                            return data;
                        }},
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
                    {name: 'persona_entrega', visible: false, searchable: false},
                    {name: 'fecha_cierre', visible: false, searchable: false},
                    {name: 'send_sms', visible: false, searchable: false},
                    {name: 'imprimir_firma', visible: false, searchable: false},
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
            $('select[name="doctor"]').on( 'change', function () {
                table.column(8).search(
                    $(this).val()
                ).draw();
            } );

            $("#crearAnalisisRangoModal").on('show.bs.modal', function (event) {
                $('#f_crearrangoanalisis').trigger("reset");
                $.ajax({
                    url: "{{ route('analisis.generar.rango.analisis') }}",
                    type: 'POST',
                    data: {},
                    success: function (data) {
                        // f_crearrangoanalisis
                        let optionsProcedencia = "<option value=''>Seleccione</option>";
                        $.each(data.procedencia, function (index, value) {
                            optionsProcedencia += "<option value='"+value.id+"'>"+value.nombre+"</option>";
                        });
                        $('#f_crearrangoanalisis select[name="procedencia"]').empty().append(optionsProcedencia);

                        let optionsAnalisis = "<option value=''>Seleccione</option>";
                        $.each(data.tipoAnalisis, function (index, value) {
                            optionsAnalisis += "<option value='"+value+"'>"+value+"</option>";
                        });
                        $('#f_crearrangoanalisis select[name="analisis"]').empty().append(optionsAnalisis);
                    },
                });
            })
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
                    console.info(data.success.precio + " ||" + data.success.acuenta + "|| " + data.success.pago);
                    var precio = parseFloat(data.success.precio);
                    var acuenta = parseFloat(data.success.acuenta);
                    var pago = parseFloat(data.success.pago);
                    $('#pago_pago').empty().append(precio-(acuenta + pago));
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
            var fecha_pago = $('#realizar_pago_fecha').val();
            var tipo_pago_efectuado = $('#f_realizarpago input[name="tipo_pago_efectuado"]:checked').val();
            $.ajax({
                url: "{{ route('analisis.aSavePago') }}",
                type: 'POST',
                data: {'analisis_id': analisisId, nit, razon_social, 'fecha_pago_efectuado': fecha_pago, tipo_pago_efectuado},
                success: function (data) {
                    $('#pagoModal').modal('hide');
                    $('#tAnalisis').DataTable().ajax.reload();
                }

            });
        }

        function printErrorMsg(form, msg) {
            $.each(msg.errors, function (key, value) {
                $('.fcp_error_' + key).empty();
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
                            $('#f_cerraranalisis input[name="fecha_cierre"]').val(date.toISOString().substring(0,10));
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

        function openModalEnviarSmsAnalisis(link) {
            $.ajax({
                url: "{{ route('analisis.aGetAnalisisPacienteById') }}",
                type: 'POST',
                data: {analisis_id: $(link).data('id')},
                success: function (data) {
                    if(data.success == 1){
                        $('#enviarSmsAnalisisModal').modal('show');
                        $('#f_enviarsmsanalisis')[0].reset();
                        $('#f_enviarsmsanalisis input[name="analisis_id"]').val($(link).data('id'));
                        if(data.paciente.apellido_materno === null){
                            $('#m_paciente_nombres').empty().append(data.paciente.nombres + ' ' + data.paciente.apellidos);
                        } else {
                            $('#m_paciente_nombres').empty().append(data.paciente.nombres + ' ' + data.paciente.apellidos + ' '+ data.paciente.apellido_materno);
                        }

                        $('#m_analisis_codigo').empty().append(data.analisis.codigo);
                        $('#m_analisis_precio').empty().append(data.analisis.precio);
                        $('#m_analisis_acuenta').empty().append(data.analisis.acuenta);
                        $('#m_analisis_pago_efectuado').empty().append(data.analisis.pago_efectuado);
                        const precioA = parseFloat(data.analisis.precio).toFixed(2);
                        const acuentaA = parseFloat(data.analisis.acuenta).toFixed(2);
                        const pagoEfectuadoA = parseFloat(data.analisis.pago_efectuado).toFixed(2);
                        console.log(data.analisis.precio + ' | ' + data.analisis.acuenta + ' | ' + data.analisis.pago_efectuado);
                        console.log(precioA + ' | ' + acuentaA + ' | ' + pagoEfectuadoA);
                        console.log(acuentaA + pagoEfectuadoA);
                        if(precioA == (parseFloat(acuentaA) + parseFloat(pagoEfectuadoA))){
                            $('#m_analisis_estado').empty().append('Cancelado');
                        } else{
                            $('#m_analisis_estado').empty().append('Debe ' + (parseFloat(precioA)-(parseFloat(acuentaA) + parseFloat(pagoEfectuadoA))));
                        }

                        $('#m_analisis_celular').val(data.analisis.telefono_referencia);
                        const textConSalto = data.texto_pre;
                        const textConSalto1 = textConSalto.replaceAll('<br>', "\n");
                        $('#s_texto').val(textConSalto1);

                    } else {
                        alert("Ocurrio un error por favor contactese  con el administrador.");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    // printErrorMsg($("#f_fechaentrega"), JSON.parse(XMLHttpRequest.responseText));
                }
            });
        }

        function openModalEnviarWappAnalisis(link) {
            $.ajax({
                url: "{{ route('analisis.aGetAnalisisPacienteById') }}",
                type: 'POST',
                data: {analisis_id: $(link).data('id')},
                success: function (data) {
                    if(data.success == 1){
                        $('#enviarWappAnalisisModal').modal('show');
                        $('#f_enviarwappanalisis')[0].reset();
                        $('#f_enviarwappanalisis input[name="analisis_id"]').val($(link).data('id'));
                        if(data.institucion.is_convenio){
                            $('#f_enviarwappanalisis .m_paciente_convenio').parent().css('display', 'block');
                            $('#f_enviarwappanalisis .m_paciente_convenio').empty().text(data.institucion.nombre);
                            $('#f_enviarwappanalisis .m_analisis_celular').val(data.institucion.telefono);
                        } else {
                            $('#f_enviarwappanalisis .m_paciente_convenio').parent().css('display', 'none');
                            $('#f_enviarwappanalisis .m_paciente_convenio').empty().text('');
                            $('#f_enviarwappanalisis .m_analisis_celular').val(data.analisis.telefono_referencia);
                        }
                        if(data.paciente.apellido_materno === null){
                            $('#f_enviarwappanalisis .m_paciente_nombres').empty().append(data.paciente.nombres + ' ' + data.paciente.apellidos);
                        } else {
                            $('#f_enviarwappanalisis .m_paciente_nombres').empty().append(data.paciente.nombres + ' ' + data.paciente.apellidos + ' '+ data.paciente.apellido_materno);
                        }

                        $('#f_enviarwappanalisis .m_analisis_codigo').empty().append(data.analisis.codigo);
                        $('#f_enviarwappanalisis .m_analisis_precio').empty().append(data.analisis.precio);
                        $('#f_enviarwappanalisis .m_analisis_acuenta').empty().append(data.analisis.acuenta);
                        $('#f_enviarwappanalisis .m_analisis_pago_efectuado').empty().append(data.analisis.pago_efectuado);
                        const precioA = parseFloat(data.analisis.precio).toFixed(2);
                        const acuentaA = parseFloat(data.analisis.acuenta).toFixed(2);
                        const pagoEfectuadoA = parseFloat(data.analisis.pago_efectuado).toFixed(2);
                        console.log(data.analisis.precio + ' | ' + data.analisis.acuenta + ' | ' + data.analisis.pago_efectuado);
                        console.log(precioA + ' | ' + acuentaA + ' | ' + pagoEfectuadoA);
                        console.log(acuentaA + pagoEfectuadoA);
                        if(precioA == (parseFloat(acuentaA) + parseFloat(pagoEfectuadoA))){
                            $('#f_enviarwappanalisis .m_analisis_estado').empty().append('Cancelado');
                        } else{
                            $('#f_enviarwappanalisis .m_analisis_estado').empty().append('Debe ' + (parseFloat(precioA)-(parseFloat(acuentaA) + parseFloat(pagoEfectuadoA))));
                        }

                        const textConSalto = data.texto_pre;
                        const textConSalto1 = textConSalto.replaceAll('<br>', "\n");
                        $('#f_enviarwappanalisis .s_texto').val(textConSalto1);

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
            // var hora_entrega = $('#f_fechaentrega input[name="hora_entrega"]').val();
            $.ajax({
                url: "{{ route('analisis.aSaveFechaEntrega') }}",
                type: 'POST',
                data: {analisis_id: analisisId,
                    persona_entrega: persona_entrega,
                    fecha_entrega: fecha_entrega,
                    // hora_entrega: hora_entrega
                },
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

        function sendSmsAnalisis(form){
            $("#f_enviarsmsanalisis_submit").prop('disabled', true);
            $.ajax({
                url: "{{ route('analisis.asend.sms.paciente') }}",
                type: 'POST',
                data: $(form).serialize(),
                success: function (data) {
                    $("#f_enviarsmsanalisis_submit").prop('disabled', false);
                    if(data.success == 1){
                        if(data.smsresult.number_of_contacts >= 1){
                            $('#enviarSmsAnalisisModal').modal('hide');
                            alert("El mensaje se envio correctamente!");
                        } else {
                            $('#enviarSmsAnalisisModal').modal('hide');
                            alert("Ocurrio el siguiente error al momento de enviar el sms: " + JSON.stringify(data));
                        }
                    } else {
                        alert("Ocurrio un error por favor contactese  con el administrador.");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    printErrorMsg($("#f_enviarsmsanalisis"), JSON.parse(XMLHttpRequest.responseText));
                }
            });
        }

        function sendWappAnalisis(form){
            $("#f_enviarWappanalisis_submit").prop('disabled', true);
            $.ajax({
                url: "{{ route('analisis.asend.wapp.paciente') }}",
                type: 'POST',
                data: $(form).serialize(),
                success: function (data) {
                    $("#f_enviarWappanalisis_submit").prop('disabled', false);
                    if(data.success == 1){
                        $('#enviarWappAnalisisModal').modal('hide');
                        window.open(data.wappresult, '_black');
                        // alert("El mensaje se envio correctamente!");
                    } else {
                        alert("Ocurrio un error por favor contactese  con el administrador.");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    printErrorMsg($("#f_enviarwappanalisis"), JSON.parse(XMLHttpRequest.responseText));
                }
            });
        }

        function getCodigoAnalisis(select) {
            $.ajax({
                url: "{{ route('analisis.agetcode') }}",
                type: 'POST',
                data: {'tipo-analisis': $(select).val()},
                success: function (data) {
                    $('#f_crearrangoanalisis input[name="codigo"]').val(data.success);
                }
            });
        }

        function sendCreateRangoAnalisis(form) {
            $.ajax({
                url: "{{ route('analisis.crear.generar.rango.analisis') }}",
                type: 'POST',
                data: $(form).serialize(),
                success: function (data) {
                    $('#tAnalisis').DataTable().ajax.reload();
                    $("#crearAnalisisRangoModal").modal('hide');
                },
            });
        }

        function openModalFechaCierre(analisisId){
            $.ajax({
                url: "{{ route('analisis.model.fecha.cierre') }}",
                type: 'POST',
                data: {analisis_id: analisisId},
                success: function (data) {
                    $("#fechaCierreModal .modal-body").empty().append(data);
                    $("#fechaCierreModal").modal('show');
                },
            });
        }

        function saveFechaCierre(analisisId){
            $.ajax({
                url: "{{ route('analisis.save.fecha.cierre') }}",
                type: 'POST',
                data: {analisis_id: analisisId},
                success: function (data) {
                    $("#fechaCierreModal").modal('hide');
                    $('#tAnalisis').DataTable().ajax.reload();
                },
            });
        }
    </script>
@endpush
