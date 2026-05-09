<!-- Modal Eliminar Person -->
<div class="modal fade" id="deletePersonModal" tabindex="-1" role="dialog" aria-labelledby="deletePersonModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="f_deletePerson" onsubmit="saveDeletePerson(this); return false;">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePersonModalLabel">Eliminar Persona</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body m-pago-p">
                    <input type="hidden" name="person_id">
                    <span class="font-weight-bold text-danger">¿Está seguro de que desea eliminar este paciente?</span>
                    <table class="table">
                        <tr>
                            <td>
                                <dl>
                                    <dt>CI:</dt>
                                    <dd class="fda-dd-ci h6 pl-2"></dd>
                                </dl>
                            </td>
                            <td>
                                <dl>
                                    <dt>Nombres:</dt>
                                    <dd class="fda-dd-names h6 pl-2">ddddd</dd>
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
        function openModalDeletePerson(personId) {
            $.ajax({
                url: "{{ route('client.getPerson') }}",
                type: 'POST',
                data: { personId: personId },
                success: function (data) {
                    if (data.success == 1) {
                        $('#deletePersonModal').modal('show');
                        $('#f_deletePerson')[0].reset();
                        // person_id
                        $("#f_deletePerson input[name='person_id']").val(personId);
                        // fda-dd-ci
                        $('.fda-dd-ci').text(data.person.ci);
                        // fda-dd-names
                        $('.fda-dd-names').text(data.person.nombres);
                    } else {
                        alert("Ocurrio un error por favor contactese  con el administrador.");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    // printErrorMsg($("#f_fechaentrega"), JSON.parse(XMLHttpRequest.responseText));
                }
            });
        }

    function saveDeletePerson(form) {
        var analisisId = $(form).find('input[name="analisis_id"]').val();
        $.ajax({
            url: "{{ route('client.deletePerson') }}",
            type: 'POST',
            data: $(form).serialize(),
            success: function (data) {
                if (data.success == 1) {
                    $('#deletePersonModal').modal('hide');
                    window.location.href = "{{ route('clients.index') }}";
                } else {
                    alert("Ocurrio un error por favor contactese  con el administrador.");
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(JSON.parse(XMLHttpRequest.responseText));
            }
        });
    }
    </script>
@endpush