<dl class="row row-citologia">
    <dt class="col-md-3">Paciente:</dt>
    <dd class="col-md-3">
        {{$analisis->person->apellidos.' '.$analisis->person->apellido_materno.', '.$analisis->person->nombres}}
        @if($analisis->person->isSisNombreApellido())
            <a href="#" onclick="openModalChangePasiente('{{$analisis->id}}')" class="btn btn-link text-success"><i class="fas fa-user-secret fa-2x"></i></a>
        @endif
    </dd>
    <dt class="col-md-3">Enviado por (Doctor):</dt>
    <dd class="col-md-3">{{$analisis->doctor}}
</dl>
<dl class="row row-citologia">
    <dt class="col-md-3">Procedencia:</dt>
    <dd class="col-md-3">{{$analisis->institucion->nombre}}</dd>
    <dt class="col-md-3">Edad:</dt>
    <dd class="col-md-3">{{$analisis->edad}} años</dd>
</dl>
<dl class="row row-citologia">
    <dt class="col-md-3">Sexo:</dt>
    <dd class="col-md-3">{{(strcmp($analisis->person->sexo, 'hombre') == 0)? 'MASCULINO' : 'FEMENINO'}}</dd>
    <dt class="col-md-3">Código:</dt>
    <dd class="col-md-3">{{$analisis->codigo}}</dd>
</dl>markers
<dl class="row row-citologia">
    <dt class="col-md-3">Fecha de Registro:</dt>
    <dd class="col-md-3">{{(isset($analisis->fecha)? $analisis->fecha->format('Y-m-d'): '--')}}</dd>
    <dt class="col-md-3">Fecha Conclusión:</dt>
{{--    <dd class="col-md-3">{{(isset($analisis->fecha_cierre)? $analisis->fecha_cierre->format('Y-m-d'): '--')}}</dd>--}}
    <dd class="col-md-3">{{ $analisis->lastControlEdition()? $analisis->lastControlEdition()->created_at->format('Y-m-d') : '--' }}</dd>
</dl>
<dl class="row row-citologia">
    <dt class="col-md-3">Analisis Entregado A:</dt>
    <dd class="col-md-3">{{(isset($analisis->persona_entrega)? $analisis->persona_entrega: '--')}}</dd>
    <dt class="col-md-3">Fecha Entrega:</dt>
    <dd class="col-md-3">{{(isset($analisis->fecha_entrega)? $analisis->fecha_entrega->format('Y-m-d'): '--')}}</dd>
</dl>
<dl class="row row-citologia">
    <dt class="col-md-3">Región:</dt>
    <dd class="col-md-3">{{ strip_tags($analisis->region) }}</dd>
    <dt class="col-md-3">Teléfono de referencia:</dt>
    <dd class="col-md-3">{{(isset($analisis->telefono_referencia)? $analisis->telefono_referencia: '--')}}</dd>
</dl>
<dl class="row row-citologia">
    <dt class="col-md-3">Doctor asígnado:</dt>
    <dd class="col-md-9">{{$analisis->doctorasig->nombres.' '.$analisis->doctorasig->apellidos}}</dd>
{{--    <dt class="col-md-3">Telefono de referencia:</dt>--}}
{{--    <dd class="col-md-3">{{(isset($analisis->telefono_referencia)? $analisis->telefono_referencia: '--')}}</dd>--}}
</dl>
@if(isset($analisis->convenio))
    <dl class="row row-citologia">
        <dt class="col-md-3">Matrícula convenio:</dt>
        <dd class="col-md-3">{{$analisis->convenio->bancaMatricula}}</dd>
        <dt class="col-md-3">Preafiliación convenio:</dt>
        <dd class="col-md-3">{{$analisis->convenio->bancaPreAfiliacion}}</dd>
    </dl>
@endif

<div class="row">
    <div class="col-md-12">
        @can('manage-users')
            @if(strcmp($analisis->tipo_analisis, \App\Analisis::BETHESDA) == 0 || strcmp($analisis->tipo_analisis, \App\Analisis::CITOLOGIA) == 0 || strcmp($analisis->tipo_analisis, \App\Analisis::LIQUIDOS) == 0)
            <button type="button"
                    class="btn btn-outline-info" data-toggle="modal"
                    data-target="#tipoAnalisisModal">Tipo de análisis</button>
            @endif
            <button type="button"
                class="btn btn-outline-info" data-toggle="modal"
                data-target="#mEditarCosto">Editar Precio</button>
        <a href="{{ route('analisis.lista.impresion', $analisis) }}"
           class="btn btn-outline-success">Historial Impresion</a>
            <a href="{{ route('analisis.lista.edicion', $analisis) }}"
               class="btn btn-outline-success">Historial de Edición</a>
        @endcan
        @can('manage-users-dr')
                <a href="{{ route('analisis.edit', $analisis) }}"
                   class="btn btn-outline-success">Editar Analisis</a>
                @if($analisis->isChangeCitologia())
                    <a href="#" onclick="openConfirVolverCito(); return false;" class="btn btn-outline-success">Volver a Citología</a>
                @endif
                @if($analisis->hasHistory())
                    <a href="{{url('analisis/listByPerson/'.$analisis->person->id)}}" class="btn btn-link text-success" style="font-size: 12px"><b>Tiene estudios anteriores</b></a>
                @endif
                    <div class="form-check" style="display: inline;">
                        <label class="form-check-label">
                            <input name="escamosas" class="form-check-input" type="checkbox" value="1" @if($analisis->imprimir_firma) checked @endif onchange="setImprimirFirma(this, '{{$analisis->id}}');">
                            <span class="form-check-sign form-check-sign-black" ></span>
                            Imprimir Firma del doctor
                        </label>
                    </div>
        @endcan
            @if(strcmp($analisis->tipo_analisis, \App\Analisis::CITOLOGIA) == 0 || strcmp($analisis->tipo_analisis, \App\Analisis::BETHESDA) == 0)
                <div class="form-check" style="display: inline;">
                    <label class="form-check-label">
                        <input id="iCitoSubtitulo" name="citoSubtitulo" class="form-check-input" type="checkbox" value="1"  onchange="setCitoSubtitulo(this);">
                        <span class="form-check-sign form-check-sign-black" ></span>
                        Subtítulo
                    </label>
                </div>
            @endif
    </div>
</div>
<div id="mEditarCosto" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title">Editar Precio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="precio">Precio de analisis (Bs)</label>
                        <input type="text" name="precio" id="" class="form-control">
                        <div class="fcp_error fcp_error_precio" style="display: none;"></div>
                    </div>
                    <div class="form-group">
                        <label for="acuenta">A cuenta (Bs)</label>
                        <input type="text" name="acuenta" id="" class="form-control">
                        <div class="fcp_error fcp_error_acuenta" style="display: none;"></div>
                    </div>
                    <div class="form-group">
                        <label for="acuenta">Tipo de pago a cuenta</label>
                        <br>
                        @foreach(\App\Analisis::TIPO_PAGO_ACUENTA as $i => $tipo_pago)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo_pago_acuenta"
                                       id="tipo_pago_acuenta_{{$i}}" value="{{$tipo_pago}}" {{(strcmp($tipo_pago, $analisis->tipo_pago_acuenta) == 0)? 'checked' : ''}}>
                                <label class="form-check-label" style="padding-left: 2px !important;" for="tipo_pago_acuenta_{{$i}}">{{$tipo_pago}}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="pago_efectuado">Pago de Saldo</label>
                        <input type="text" name="pago_efectuado" id="" class="form-control">
                        <div class="fcp_error fcp_error_pago_efectuado" style="display: none;"></div>
                    </div>
                    <div class="form-group">
                        <label for="asaldo">Tipo de pago saldo</label>
                        <br>
                        @foreach(\App\Analisis::TIPO_PAGO_EFECTUADO as $i => $tipo_pago_e)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo_pago_efectuado"
                                       id="tipo_pago_saldo_{{$i}}" value="{{$tipo_pago_e}}" {{(strcmp($tipo_pago_e, $analisis->tipo_pago_efectuado) == 0)? 'checked' : ''}}>
                                <label class="form-check-label" style="padding-left: 2px !important;" for="tipo_pago_saldo_{{$i}}">{{$tipo_pago_e}}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="fecha_pago_efectuado">Fecha Pago de Saldo</label>
                        <input type="date" name="fecha_pago_efectuado" id="fecha_pago_efectuado" class="form-control">
                        <div class="fcp_error fcp_error_fecha_pago_efectuado" style="display: none;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal confirmar volver a citologia -->
<div id="mConfirmarVolverCito" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form onsubmit="saveChangeToCitologia(); return false;">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar volver a Citología</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="callout callout-warning">
                        <p>Esta seguro que quiere volver a Citologia?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Cambiar paciente y doctor que refiere -->
<div id="mCambiarPaciente" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar paciente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-success">Este análisis esta sin un paciente asignado. Por favor asigne o cree uno.</p>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Nombres <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" style="text-transform: uppercase;" name="nombres" autocomplete="off">
                        </div>
                        <div class="col-md-3 form-group">
                            <label>A. paterno <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="ap_paterno" style="text-transform: uppercase;" autocomplete="off">
                        </div>
                        <div class="col-md-3 form-group">
                            <label>A. materno</label>
                            <input type="text" class="form-control form-control-sm" name="ap_materno" style="text-transform: uppercase;" autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <label>.</label>
                            <button type="button" onclick="searchClientRango(); return false;" class="btn btn-sm btn-primary btn-block">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="dPersonaNoExist">
                        <hr>
                        <h5>No existe la persona:</h5>
                        <input type="hidden" name="personaNombre">
                        <input type="hidden" name="personaApPaterno">
                        <input type="hidden" name="personaApMaterno">
                        <div class="row">
                            <div class="col-md-6">
                                <p><b class="dpbNombres">ss</b></p>
                            </div>
                            <div class="col-md-3">
                                <label>
                                    <input type="radio" value="H" name="sexo" checked> Hombre
                                </label>
                                <label>
                                    <input type="radio" value="M" name="sexo"> Mujer
                                </label>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-success btn-sm" onclick="bCrearAsignar(); return false;">Crear y Asignar</button>
                            </div>
                        </div>
                    </div>
                    <div class="dPersonTable">
                        <hr>
                        <h5>Personas encontradas:</h5>
                        <table class="table table-bordered table-sm">
                            <thead>
                            <tr>
                                <th>CI</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Accion</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Cambiar paciente y doctor que refiere -->
<div id="mCambiarDoctor" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form onsubmit="saveDoctorEnvio(this); return false;">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar Doctor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="analisisId" value="{{ $analisis->id }}">
                    <div class="form-group">
                        <label for="">Doctor que envio</label>
                        <input type="text" name="doctor" class="form-control form-control-sm" style="text-transform: uppercase;" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Grabar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Elegir tipo de analisis -->
<div class="modal" id="tipoAnalisisModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="tipoAnalisisForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="tipoAModalLabel">Establecer Tipo de analisis</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="{{$analisis->id}}" name="analisis_id">
                    <div class="row">
                        <div class="col-md-12">
                            <select class="form-control" name="tipo" required>
                                <option value="">Seleccione ...</option>
                                <option value="{{\App\Analisis::CITOLOGIA}}">{{\App\Analisis::CITOLOGIA}}</option>
                                <option value="{{\App\Analisis::BETHESDA}}">{{\App\Analisis::BETHESDA}}</option>
                                <option value="{{\App\Analisis::LIQUIDOS}}">{{\App\Analisis::LIQUIDOS}}</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-dark">Atras</a>
                    <button type="submit" class="btn btn-primary align-right">Establecer</button>
                </div>
            </form>
        </div>
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

        @if($analisis->person->isSisNombreApellido())
        openModalChangePasiente('{{$analisis->id}}');
        @endif
            @if(strcmp($analisis->tipo_analisis, \App\Analisis::CITOLOGIA) == 0 || strcmp($analisis->tipo_analisis, \App\Analisis::BETHESDA) == 0)
            // pdm implementar aqui cito subtitulo
        getCitoSubtitulo();
            @endif
        var form = $('#mEditarCosto form');
        $(form).submit(function( event ) {
            let precio = $('#mEditarCosto form input[name="precio"]').val();
            let acuenta = $('#mEditarCosto form input[name="acuenta"]').val();
            let pago_efectuado = $('#mEditarCosto form input[name="pago_efectuado"]').val();
            let fecha_pago_efectuado = $('#mEditarCosto form input[name="fecha_pago_efectuado"]').val();
            let tipo_pago_acuenta = $('#mEditarCosto form input[name="tipo_pago_acuenta"]:checked').val();
            let tipo_pago_efectuado = $('#mEditarCosto form input[name="tipo_pago_efectuado"]:checked').val();

            $.ajax({
                url: "{{ route('analisis.aSetPrecioByAnalisis') }}",
                type: 'POST',
                data: {analisis_id: '{{$analisis->id}}', precio, acuenta, pago_efectuado, fecha_pago_efectuado, tipo_pago_acuenta, tipo_pago_efectuado},
                success: function (data) {
                    $('#mEditarCosto').modal('hide');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    var response = JSON.parse(XMLHttpRequest.responseText);
                    clearMsgErrors("#mEditarCosto form");
                    console.log(response.errors);
                    $.each(response.errors, function(key, value){
                        console.log(JSON.stringify(value));
                        $('#mEditarCosto form').find("input[name='" + key + "']").addClass('is-invalid');
                        var msgs = "<ul class='list-unstyled'>";
                        $.each(value, function (key1, value1) {
                            msgs += "<li><span class='text-danger'>" + value1 + "</span></li>";
                        });
                        msgs += "</ul>";
                        $('.fcp_error_' + key).empty().append(msgs);
                        $('.fcp_error_' + key).show();
                    });
                }
            });

            event.preventDefault();
        });
    });

    $('#mEditarCosto').on('show.bs.modal', function (event) {
        clearMsgErrors("#mEditarCosto form");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('analisis.aGetPrecioByAnalisis') }}",
            type: 'POST',
            data: {analisis_id: '{{$analisis->id}}'},
            success: function (data) {
                $('#mEditarCosto form input[name="precio"]').val(data.precio);
                $('#mEditarCosto form input[name="acuenta"]').val(data.acuenta);
                if(data.pago_efectuado === 0){
                    $('#mEditarCosto form input[name="pago_efectuado"]').val('');
                } else {
                    $('#mEditarCosto form input[name="pago_efectuado"]').val(data.pago_efectuado);
                }
                $('#mEditarCosto form input[name="fecha_pago_efectuado"]').val(data.fecha_pago_efectuado);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    });

    function setImprimirFirma(check, analisisId){
        // alert("ww: " + analisisId + " || checked:: " + $(check).is(':checked'));
        let imprimir = 0;
        if($(check).is(':checked')){
            imprimir = 1;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('analisis.aSetImprimirFirma') }}",
            type: 'POST',
            data: {analisis_id: '{{$analisis->id}}', imprimir_firma: imprimir},
            success: function (data) {
                console.log(data)
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }

    function openConfirVolverCito(){
        $("#mConfirmarVolverCito").modal('show');
    }

    function saveChangeToCitologia(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('analisis.aChangeToCitologia') }}",
            type: 'POST',
            data: {analisis_id: '{{$analisis->id}}'},
            success: function (data) {
                console.log(JSON.stringify(data));
                window.location.href = '{{url('/analisis/analisisextendido/'.$analisis->id)}}';
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }

    function clearMsgErrors(form){
        $(form).find('.fcp_error ').empty();
        $(form).find("input").removeClass('is-invalid');
    }

    function openModalChangePasiente(analisisId){
        $('#mCambiarPaciente form')[0].reset();
        $('.dPersonTable').hide();
        $('.dPersonaNoExist').hide(); // dPersonaNoExist
        $('#mCambiarPaciente').modal('show');
    }

    // mCambiarDoctor
    function openModalChangeDoctor(){
        $('#mCambiarDoctor').modal('show');
    }

    function searchClientRango(){
        var nombres = $('#mCambiarPaciente').find("input[name='nombres']").val();
        var apellidos = $('#mCambiarPaciente').find("input[name='ap_paterno']").val();
        var apellido_materno = $('#mCambiarPaciente').find("input[name='ap_materno']").val();

        $.ajax({
            url: "{{ route('client.searchAjaxPerson') }}",
            type: 'POST',
            data: {
                nombres: nombres,
                apellidos: apellidos,
                apellido_materno: apellido_materno,
            },
            success: function (data) {
                if (data.success) {
                    if(data.persons.length > 0){
                        // dPersonTable
                        $('#mCambiarPaciente .dPersonTable').show();
                        $('#mCambiarPaciente .dPersonaNoExist').hide();
                        var table = $("#mCambiarPaciente table");
                        $(table).find('tbody').empty();
                        var trs = '';
                        $.each(data.persons, function (index, person) {
                            trs += '<tr>';
                            trs += '<td>' + person.ci + '</td>';
                            trs += '<td>' + person.nombres + '</td>';
                            trs += '<td>' + person.apellidos + ' ' + person.apellido_materno + '</td>';
                            trs += '<td><button class="btn btn-success btn-sm" onclick="asignarPerson(\'' + person.id + '\', \'{{ $analisis->id }}\'); return false;">Asignar</button></td>';
                            trs += '</tr>';
                        });
                        $(table).find('tbody').append(trs);
                    } else {
                        $('#mCambiarPaciente .dPersonTable').hide();
                        $('#mCambiarPaciente .dPersonaNoExist').show();
                        $('#mCambiarPaciente .dPersonaNoExist .dpbNombres').empty().text(
                            $('#mCambiarPaciente input[name="nombres"]').val().toUpperCase() + ' ' +
                            $('#mCambiarPaciente input[name="ap_paterno"]').val().toUpperCase() + ' ' +
                            $('#mCambiarPaciente input[name="ap_materno"]').val().toUpperCase()
                        );
                        // personaNombre
                        $('.dPersonaNoExist input[name="personaNombre"]').val($('#mCambiarPaciente input[name="nombres"]').val().toUpperCase());
                        $('.dPersonaNoExist input[name="personaApPaterno"]').val($('#mCambiarPaciente input[name="ap_paterno"]').val().toUpperCase());
                        $('.dPersonaNoExist input[name="personaApMaterno"]').val($('#mCambiarPaciente input[name="ap_materno"]').val().toUpperCase());
                    }
                } else {
                    alert(data.errors);
                }
            }
        });

        return false;
    }

    function asignarPerson(personId, analisisId){
        $.ajax({
            url: "{{ route('client.ajaxSetPersonAnalisis') }}",
            type: 'POST',
            data: {
                personId,
                analisisId,
            },
            success: function (data) {
                if (data.success) {
                    // location.reload();
                    window.location.replace("{{ route('analisis.edit', $analisis) }}");
                } else {
                    alert(data.errors);
                }
            }
        });
        return false;
    }

    function bCrearAsignar() {
        var personaNombre = $('.dPersonaNoExist input[name="personaNombre"]').val();
        var personaApPaterno = $('.dPersonaNoExist input[name="personaApPaterno"]').val();
        var personaApMaterno = $('.dPersonaNoExist input[name="personaApMaterno"]').val();
        var personaSexo = $('.dPersonaNoExist input[name="sexo"]:checked').val();

        if(personaNombre !== '' && personaApPaterno !== ''){
            $.ajax({
                url: "{{ route('client.ajaxCreatePersonSetAnalisis') }}",
                type: 'POST',
                data: {
                    personaNombre,
                    personaApPaterno,
                    personaApMaterno,
                    personaSexo,
                    'analisisId': '{{ $analisis->id }}'
                },
                success: function (data) {
                    if (data.success) {
                        // location.reload();
                        window.location.replace("{{ route('analisis.edit', $analisis) }}");
                    } else {
                        alert(data.errors);
                    }
                }
            });
        } else {
            console.log('Nombre y apellido paterno son obligatorios');
            alert('Nombre y apellido paterno son obligatorios');
        }
        return false;
    }

    function saveDoctorEnvio(form) {
        $.ajax({
            url: "{{ route('client.ajaxSetDoctorAnalisis') }}",
            type: 'POST',
            data: $(form).serialize(),
            success: function (data) {
                if (data.success) {
                    location.reload();
                    // alert('se gragoo');
                } else {
                    alert(data.errors);
                }
            }
        });
    }

    function getCitoSubtitulo(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('citologia.agetsubtitulo') }}",
            type: 'POST',
            data: {analisis_id: '{{$analisis->id}}'},
            success: function (data) {
                if(data.subtitulo){
                    $("#iCitoSubtitulo").prop("checked", true)
                } else {
                    $("#iCitoSubtitulo").prop("checked", false)
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }

    function setCitoSubtitulo(check){
        subtitulo = $(check).is(':checked');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('citologia.asetsubtitulo') }}",
            type: 'POST',
            data: {
                analisis_id: '{{$analisis->id}}',
                subtitulo
            },
            success: function (data) {
                console.log(data);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    }
</script>
@endpush
