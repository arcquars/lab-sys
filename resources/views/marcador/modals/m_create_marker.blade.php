<!-- Modal registro Marcador -->
<div id="mMarcador" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form onsubmit="storeMarker(this); return false;">
            <input type="hidden" name="id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="mMarcador_title" class="modal-title ">Crear Marcador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="markerName">Nombre</label>
                        <input type="text" name="name" id="markerName"
                               onkeyup="uppercaseInput(this);"
                               class="form-control" placeholder="Nombres">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="markerDescription">Descripción</label>
                        <textarea id="markerDescription" name="description" class="form-control" ></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Grabar</button>
                </div>
            </div>
        </form>
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


        function openModalMarker() {
            $('#mMarcador').modal('show');
            $('#mMarcador_title').empty().text('Crear Marcador');
            clearFormMarket();
        }

        function storeMarker(form) {
            $.ajax({
                url: "{{ route('marcador.astore') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $(form).serialize(),
                success: function (data) {
                    $("#mMarcador").modal('hide');
                    $('#tMarkets').DataTable().ajax.reload();
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    // console.log(XMLHttpRequest.responseJSON.errors);
                    eMarkets = XMLHttpRequest.responseJSON.errors
                    showValidateMessages(form, eMarkets);
                }
            });
        }

        function clearFormMarket(){
            form = $("#mMarcador form");
            $("#mMarcador input[name='id']").val('');
            $(form)[0].reset();
            clearValidForm(form);
        }

        function clearValidForm(form){
            $(form).find('input,select,textarea').each(function(i){
                $(this).removeClass('is-invalid');
            });
        }

        function showValidateMessages(form, eMarkets){
            $(form).find('input,select,textarea').each(function(i){
                elementMarket = this;
                $(elementMarket).removeClass('is-invalid');
                $.each(eMarkets, function (key, arr){
                    if($(elementMarket).attr('name') === key){
                        $(elementMarket).addClass('is-invalid');
                        $(elementMarket).next().empty().append(arr.join([separator = ',']));
                    }
                });

            });

        }
    </script>
@endpush
