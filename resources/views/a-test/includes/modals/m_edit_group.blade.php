<!-- Modal Edit Group Test -->
<div id="mEditGroupTest" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <form onsubmit="updateGroup(this); return false;">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar grupo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-primary">Grabar</button>
                </div>
            </div>
        </div>
    </form>
</div>
@push('js')
    <script>
function openModalEditGroupTest(testGroupId){
    clearUpdateGroupFormValidation();
    $.ajax({
        url: "{{ route('analysis-test-group.render.form') }}",
        data: {'a_test_group_id': testGroupId},
        success: function (data) {
            $("#mEditGroupTest").modal('show');
            $("#mEditGroupTest .modal-content .modal-body").empty().append(data);
        }
    });
}

function updateGroup(form){
    clearUpdateGroupFormValidation();
    $.ajax({
        url: "{{ route('analysis-test-group.update_group') }}",
        type: 'POST',
        data: $(form).serialize(),
        success: function (data) {
            $("#mEditGroupTest").modal('hide');
            loadTreeTestGroup();

            let notify = $.notify(data.message, {
                type: 'success',
                allow_dismiss: true,
            });

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            for (const [key, value] of Object.entries(XMLHttpRequest.responseJSON.errors)) {
                console.log(`${key}: ${value}`);
                let inputName = "#mgroup" + key;
                $(inputName).addClass('is-invalid');
                $(inputName).next().empty().append(value);
            }
        }
    });
}

function clearUpdateGroupFormValidation(){
    $("#mgroupname").removeClass('is-invalid');
    $("#mgroupname").next().empty();
    $("#mgroupgroup").removeClass('is-invalid');
    $("#mgroupgroup").next().empty();
}
    </script>
@endpush
