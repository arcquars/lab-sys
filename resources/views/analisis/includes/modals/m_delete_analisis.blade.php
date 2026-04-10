<!-- Modal Cerrar Analisis -->
    <div class="modal fade" id="deleteAnalisisModal" tabindex="-1" role="dialog" aria-labelledby="deleteAnalisisModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="f_deleteAnalisis" onsubmit="saveDeleteAnalisis(this); return false;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteAnalisisModalLabel">Eliminar Análisis</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body m-pago-p">
                        <input type="hidden" name="analisis_id">
                        <span class="font-weight-bold text-danger">¿Está seguro de que desea eliminar este análisis?</span>
                        <table class="table">
                            <tr>
                                <td>
                                    <dl>
                                        <dt>Codigo:</dt>
                                        <dd class="fda-dd-code h6 pl-2"></dd>
                                    </dl>
                                </td>
                                <td>
                                    <dl>
                                        <dt>Paciente:</dt>
                                        <dd class="fda-dd-client h6 pl-2">ddddd</dd>
                                    </dl>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@push('js')
    <script>
        // $(document).ready(function () {
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        // });

        function openModalDeleteAnalisis(analisisId) {
            $.ajax({
                url: "{{ route('analisis.aGetAnalisisById') }}",
                type: 'POST',
                data: {analisis_id: analisisId},
                success: function (data) {
                    if(data.success == 1){
                        $('#deleteAnalisisModal').modal('show');
                        $('#f_deleteAnalisis')[0].reset();
                        $('#f_deleteAnalisis input[name="analisis_id"]').val(analisisId);

                        // fda-dd-code
                        $('.fda-dd-code').text(data.analisis.codigo);
                        // fda-dd-client
                        $('.fda-dd-client').text(data.paciente);
                    } else {
                        alert("Ocurrio un error por favor contactese  con el administrador.");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    // printErrorMsg($("#f_fechaentrega"), JSON.parse(XMLHttpRequest.responseText));
                }
            });
        }

        function saveDeleteAnalisis(form){
            var analisisId = $(form).find('input[name="analisis_id"]').val();
            $.ajax({
                url: "{{ route('analisis.aDeleteAnalisis') }}",
                {{-- url: "{{ route('analisis.aDeleteAnalisis') }}", --}}
                type: 'POST',
                data: {analisis_id: analisisId},
                success: function (data) {
                    if(data.success == 1){
                        $('#deleteAnalisisModal').modal('hide');
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