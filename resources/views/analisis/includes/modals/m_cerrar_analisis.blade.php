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

@push('js')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        function openModalCerrarAnalisis(link) {
            var date = new Date();
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