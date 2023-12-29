<!-- Modal borrar Marcador -->
<div id="mDeleteMarker" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form onsubmit="deleteMarker(this); return false;">
            <input type="hidden" name="id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="mMarcador_title" class="modal-title ">Borrar Marcador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Esta seguro que quiere eliminar el marcador: <b id="m-market-name"></b></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Borrar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('js')
    <script>
        function deleteMarkerAjax(markerId) {
            $.ajax({
                url: "{{ route('marcador.getmarket') }}",
                type: 'POST',
                data: {markerId},
                success: function (data) {
                    if (data.success) {
                        $('#mDeleteMarker').modal('show');
                        $('#mDeleteMarker input[name="id"]').val(markerId);
                        $('#m-market-name').empty().append(data.marker.name);

                    } else {
                        alert(data.errors);
                    }
                }
            });
        }

        function deleteMarker(form) {
            $.ajax({
                url: "{{ route('marcador.adelete') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $(form).serialize(),
                success: function (data) {
                    $("#mDeleteMarker").modal('hide');
                    $('#tMarkets').DataTable().ajax.reload();
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    // eMarkets = XMLHttpRequest.responseJSON.errors
                    // showValidateMessages(form, eMarkets);
                }
            });
        }

        {{--function storeMarker(form) {--}}
        {{--    $.ajax({--}}
        {{--        url: "{{ route('marcador.astore') }}",--}}
        {{--        type: 'POST',--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        },--}}
        {{--        data: $(form).serialize(),--}}
        {{--        success: function (data) {--}}
        {{--            $("#mMarcador").modal('hide');--}}
        {{--            $('#tMarkets').DataTable().ajax.reload();--}}
        {{--        },--}}
        {{--        error: function (XMLHttpRequest, textStatus, errorThrown) {--}}
        {{--            // console.log(XMLHttpRequest.responseJSON.errors);--}}
        {{--            eMarkets = XMLHttpRequest.responseJSON.errors--}}
        {{--            showValidateMessages(form, eMarkets);--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}

        {{--function clearFormMarket(){--}}
        {{--    form = $("#mMarcador form");--}}
        {{--    $("#mMarcador input[name='id']").val('');--}}
        {{--    $(form)[0].reset();--}}
        {{--    clearValidForm(form);--}}
        {{--}--}}

        {{--function clearValidForm(form){--}}
        {{--    $(form).find('input,select,textarea').each(function(i){--}}
        {{--        $(this).removeClass('is-invalid');--}}
        {{--    });--}}
        {{--}--}}

        {{--function showValidateMessages(form, eMarkets){--}}
        {{--    $(form).find('input,select,textarea').each(function(i){--}}
        {{--        elementMarket = this;--}}
        {{--        $(elementMarket).removeClass('is-invalid');--}}
        {{--        $.each(eMarkets, function (key, arr){--}}
        {{--            if($(elementMarket).attr('name') === key){--}}
        {{--                $(elementMarket).addClass('is-invalid');--}}
        {{--                $(elementMarket).next().empty().append(arr.join([separator = ',']));--}}
        {{--            }--}}
        {{--        });--}}

        {{--    });--}}

        {{--}--}}
    </script>
@endpush
