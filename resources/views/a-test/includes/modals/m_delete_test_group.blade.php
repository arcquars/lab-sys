<!-- Modal Delete Test group -->
<div id="mDeleteTestGroup" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <form onsubmit="deleteTestGroup(this); return false;">
        @csrf
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Grupo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </form>
</div>
@push('js')
    <script>
function openModalAnalysisTestGroupDelete(aTestGroupId){
    $.ajax({
        url: "{{ route('analisis-test.render-test-group-form-delete') }}",
        data: {'a_test_group_id': aTestGroupId},
        success: function (data) {
            let msg = "El grupo <b class='text-primary'>" + data.testGroup.name + "</b> no se puede eliminar pues tiene pruebas. El grupo tiene que estar vacio. ";
            $("#mDeleteTestGroup .modal-content .modal-footer button[type='submit']").attr('disabled', true);
            $("#mDeleteTestGroup .modal-content .modal-footer button[type='submit']").addClass('disabled');
            if(data.valid){
                msg = "Se eliminara el grupo <b class='text-danger'>" + data.testGroup.name + "</b> ";
                msg += "<input type='hidden' name='id' value='" + data.testGroup.id + "' />";
                $("#mDeleteTestGroup .modal-content .modal-footer button[type='submit']").removeAttr('disabled');
                $("#mDeleteTestGroup .modal-content .modal-footer button[type='submit']").removeClass('disabled');
            }
            $("#mDeleteTestGroup").modal('show');
            $("#mDeleteTestGroup .modal-content .modal-body").empty().append(msg);

        }
    });
}

function deleteTestGroup(form){
    $.ajax({
        url: "{{ route('analysis-test.delete.test-group') }}",
        type: 'POST',
        data: $(form).serialize(),
        success: function (data) {
            $("#mDeleteTestGroup").modal('hide');
            loadTestGroup();

            let notify = $.notify(data.message, {
                type: 'success',
                allow_dismiss: true,
            });

        }
    });
}
    </script>
@endpush
