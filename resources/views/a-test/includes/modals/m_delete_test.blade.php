<!-- Modal Delete Test -->
<div id="mDeleteTest" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <form onsubmit="deleteTest(this); return false;">
        @csrf
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Prueba</h5>
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
function openModalAnalysisTestDelete(aTestId){
    $.ajax({
        url: "{{ route('analisis-test.render-test-form-delete') }}",
        data: {'a_test_id': aTestId},
        success: function (data) {
            $("#mDeleteTest").modal('show');
            $("#mDeleteTest .modal-content .modal-body").empty().append(data);
        }
    });
}

function deleteTest(form){
    $.ajax({
        url: "{{ route('analysis-test.delete.test') }}",
        type: 'POST',
        data: $(form).serialize(),
        success: function (data) {
            $("#mDeleteTest").modal('hide');
            loadTreeTestGroup();

            let notify = $.notify(data.message, {
                type: 'success',
                allow_dismiss: true,
            });

        }
    });
}
    </script>
@endpush
