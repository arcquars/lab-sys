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


@push('js')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

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
    </script>
@endpush