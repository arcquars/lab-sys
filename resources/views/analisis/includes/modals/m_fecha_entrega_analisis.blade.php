<!-- Modal Fecha de Entrega -->
<div class="modal fade" id="fechaEntregaModal" tabindex="-1" role="dialog" aria-labelledby="fechaentregaModalLabel"
    aria-hidden="true">
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
                        <input type="text" name="persona_entrega" class="form-control" placeholder="Nombres"
                            onkeyup="uppercaseInput(this);">
                        <div class="fcp_error_persona_entrega" style="display: none;"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_entrega">Fecha de entrega</label>
                                <input type="date" name="fecha_entrega" class="form-control" value="{{date('Y-m-d')}}"
                                    min="{{date('Y-m-d', strtotime("-100 days"))}}"
                                    max="{{date('Y-m-d', strtotime("5 days"))}}">
                                <div class="fcp_error_fecha_entrega" style="display: none;"></div>
                            </div>
                        </div>
                        {{-- <div class="col-md-6">--}}
                            {{-- <label for="hora_entrega">Hora</label>--}}
                            {{-- <input type="time" name="hora_entrega" class="form-control">--}}
                            {{-- <div class="fcp_error_hora_entrega" style="display: none;"></div>--}}
                            {{-- </div>--}}
                    </div>
                    <span class="font-weight-bold text-success">Esta fecha es la que se imprime en el resultado del
                        análisis</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" onclick="saveFechaEntrega();" class="btn btn-primary">Registrar</button>
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
        });

        function openModalFechaEntrega(link) {
            $.ajax({
                url: "{{ route('analisis.aGetAnalisisById') }}",
                type: 'POST',
                data: { analisis_id: $(link).data('id') },
                success: function (data) {
                    if (data.success == 1) {
                        $('#fechaEntregaModal').modal('show');
                        clearErrorMsg();
                        $('#f_fechaentrega')[0].reset();
                        $('#f_fechaentrega input[name="analisis_id"]').val($(link).data('id'));



                        if (data.analisis.fecha_entrega !== null) {
                            $('#f_fechaentrega input[name="fecha_entrega"]').val(data.analisis.fecha_entrega.split(' ')[0]);
                        } else {
                            var now = new Date();

                            var day = ("0" + now.getDate()).slice(-2);
                            var month = ("0" + (now.getMonth() + 1)).slice(-2);

                            var today = now.getFullYear() + "-" + (month) + "-" + (day);
                            $('#f_fechaentrega input[name="fecha_entrega"]').val(today);
                        }
                        if (data.analisis.persona_entrega !== null) {
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

        function saveFechaEntrega() {
            var analisisId = $('#f_fechaentrega input[name="analisis_id"]').val();
            var persona_entrega = $('#f_fechaentrega input[name="persona_entrega"]').val();
            var fecha_entrega = $('#f_fechaentrega input[name="fecha_entrega"]').val();
            // var hora_entrega = $('#f_fechaentrega input[name="hora_entrega"]').val();
            $.ajax({
                url: "{{ route('analisis.aSaveFechaEntrega') }}",
                type: 'POST',
                data: {
                    analisis_id: analisisId,
                    persona_entrega: persona_entrega,
                    fecha_entrega: fecha_entrega,
                    // hora_entrega: hora_entrega
                },
                success: function (data) {
                    if (data.success == 1) {
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
    </script>
@endpush