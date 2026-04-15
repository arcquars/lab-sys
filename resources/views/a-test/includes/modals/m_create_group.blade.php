<!-- Modal Create Group Test -->
<div id="mCreateGroupTest" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <form onsubmit="saveGroup(this); return false;">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear grupo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-lab-pdm-primary">Crear</button>
                </div>
            </div>
        </div>
    </form>
</div>
@push('js')
    <script>
function openModalCreateGroupTest(){
    $.ajax({
        url: "{{ route('analysis-test-group.render.form') }}",
        success: function (data) {
            $("#mCreateGroupTest .modal-body").empty().append(data);
            $("#mCreateGroupTest").modal('show');
            // $("#mCreateGroupTest form")[0].reset();
            // clearSaveGroupFormValidation();
        }
    });
}

function saveGroup(form){
    clearSaveGroupFormValidation();
    $.ajax({
        url: "{{ route('analysis-test-group.store') }}",
        type: 'POST',
        data: $(form).serialize(),
        success: function (data) {
            $("#mCreateGroupTest").modal('hide');
            loadTreeTestGroup();

            let notify = $.notify(data.message, {
                type: 'success',
                allow_dismiss: true,
            });

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            // XMLHttpRequest.responseJSON.errors
            for (const [key, value] of Object.entries(XMLHttpRequest.responseJSON.errors)) {
                console.log(`${key}: ${value}`);
                let inputName = "#mgroup" + key;
                $(inputName).addClass('is-invalid');
                $(inputName).next().empty().append(value);
            }
            // console.log(JSON.stringify(XMLHttpRequest.responseJSON));
        }
    });
}

function clearSaveGroupFormValidation(){
    $("#mgroupname").removeClass('is-invalid');
    $("#mgroupname").next().empty();
    $("#mgroupprice").removeClass('is-invalid');
    $("#mgroupprice").next().empty();
    $("#mgroupsubtitle").removeClass('is-invalid');
    $("#mgroupsubtitle").next().empty();
}
    </script>
@endpush
