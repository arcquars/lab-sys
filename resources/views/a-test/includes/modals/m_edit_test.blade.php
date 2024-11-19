<!-- Modal Edit Test -->
<div id="mEditTest" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <form onsubmit="updateTest(this); return false;">
        @csrf
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Prueba</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-lab-pdm-primary">Grabar</button>
                </div>
            </div>
        </div>
    </form>
</div>
@push('js')
    <script>
function openModalAnalysisTest(aTestId){
    $.ajax({
        url: "{{ route('analisis-test.render-test-form') }}",
        data: {'a_test_id': aTestId},
        success: function (data) {
            $("#mEditTest").modal('show');
            $("#mEditTest .modal-content .modal-body").empty().append(data);
            // alert(data);
        }
    });
}

function updateTest(form){
    $.ajax({
        url: "{{ route('analysis-test.update.test') }}",
        type: 'POST',
        data: $(form).serialize(),
        success: function (data) {
            $("#mEditTest").modal('hide');
            loadTreeTestGroup();

            let notify = $.notify(data.message, {
                type: 'success',
                allow_dismiss: true,
            });

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            for (const [key, value] of Object.entries(XMLHttpRequest.responseJSON.errors)) {
                let inputName = "#mtest" + key.replaceAll(".", "_");
                console.log("PDM:: ids: " + inputName);
                $(inputName).addClass('is-invalid');
                $(inputName).next().empty().append(value);
            }
        }
    });
}
    </script>
@endpush
