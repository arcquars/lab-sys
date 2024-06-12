<!-- Modal Firmas Supervisores -->
<div id="mFirmaSupervisores" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Firmas Interconsultados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
{{--                <div class="custom-control custom-switch">--}}
{{--                    <input type="checkbox" class="custom-control-input" id="customSwitch1">--}}
{{--                    <label class="custom-control-label text-primary" for="customSwitch1">Autorizar firma dr. <b>JUAN</b></label>--}}
{{--                </div>--}}
{{--                <div class="custom-control custom-switch">--}}
{{--                    <input type="checkbox" class="custom-control-input" disabled checked id="customSwitch2">--}}
{{--                    <label class="custom-control-label" for="customSwitch2">CARLOS MENDEZ</label>--}}
{{--                </div>--}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        function openModalFirmaSupervisores(analisisId){
            // $("#mFirmaSupervisores").modal('show');
            $.ajax({
                url: "{{ route('analisis.supervisores.data') }}",
                type: 'POST',
                data: {analisis_id: analisisId},
                success: function (result) {
                    html = '';
                    $.each(result.data.analisis_supervisores, function(index, asupervisor){
                        html += '<div class="custom-control custom-switch">';
                        if(parseInt("{{Auth::user()->hasRole('admin')}}") == 1 || parseInt("{{Auth::user()->person}}") == asupervisor.doctor_id){
                            html += '<input type="checkbox" class="custom-control-input" id="customSwitch'+asupervisor.id+'" ';
                            if(asupervisor.estado === '{{\App\AnalisisSupervisor::ESTADO_VERIFICADO}}'){
                                html +=' checked ';
                            }
                            html += ' onchange="setFirmaAnalisisSupervisor(this, \''+asupervisor.id+'\')">';

                            html += '<label class="custom-control-label text-primary" for="customSwitch'+asupervisor.id;
                            html += '">Autorizar firma dr. <b>'+ asupervisor.doctor_supervisor.nombres + ' ' + asupervisor.doctor_supervisor.apellidos +'</b></label>';
                        } else {
                            html += '<input type="checkbox" class="custom-control-input" id="customSwitch1" disabled ';
                            if(asupervisor.estado === '{{\App\AnalisisSupervisor::ESTADO_VERIFICADO}}'){
                                html += ' checked ';
                            }
                            html += '>';
                            html += '<label class="custom-control-label text-dark" for="customSwitch1">Doctor <b>'+asupervisor.doctor_id+'</b></label>';
                        }
                        html += '</div>'
                    });


                    $("#mFirmaSupervisores .modal-body").empty().append(html);
                    $("#mFirmaSupervisores").modal('show');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert('Ocurrio un error por favor comuniquese con el aministrador del sistema');
                }
            });
        }

        function setFirmaAnalisisSupervisor(check, aSupervisorId){
            // alert($(check).is(':checked'));
            $.ajax({
                url: "{{ route('analisis.supervisores.setEstado') }}",
                type: 'POST',
                data: {analisis_supervisor_id: aSupervisorId, estado: $(check).is(':checked')? 1 : 0},
                success: function (result) {
                    // alert(JSON.stringify(result));
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert('Ocurrio un error por favor comuniquese con el aministrador del sistema');
                }
            });
        }
    </script>
@endpush
