<dl class="row row-citologia">
    <dt class="col-md-3">Paciente:</dt>
    <dd class="col-md-3">{{$analisis->person->apellidos.' '.$analisis->person->apellido_materno.', '.$analisis->person->nombres}}</dd>
    <dt class="col-md-3">Enviado por (Doctor):</dt>
    <dd class="col-md-3">{{$analisis->doctor}}</dd>
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
    <dt class="col-md-3">Codigo:</dt>
    <dd class="col-md-3">{{$analisis->codigo}}</dd>
</dl>
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
    <dd class="col-md-3">{{$analisis->region}}</dd>
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
                        <label for="pago_efectuado">Pago de Saldo</label>
                        <input type="text" name="pago_efectuado" id="" class="form-control">
                        <div class="fcp_error fcp_error_pago_efectuado" style="display: none;"></div>
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
@push('js')
<script>
    $(document).ready(function () {
        var form = $('#mEditarCosto form');
        $(form).submit(function( event ) {
            let precio = $('#mEditarCosto form input[name="precio"]').val();
            let acuenta = $('#mEditarCosto form input[name="acuenta"]').val();
            let pago_efectuado = $('#mEditarCosto form input[name="pago_efectuado"]').val();
            let fecha_pago_efectuado = $('#mEditarCosto form input[name="fecha_pago_efectuado"]').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('analisis.aSetPrecioByAnalisis') }}",
                type: 'POST',
                data: {analisis_id: '{{$analisis->id}}', precio, acuenta, pago_efectuado, fecha_pago_efectuado},
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
</script>
@endpush
