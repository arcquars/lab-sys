<!-- Modal -->
<div class="modal fade" id="mdl_marcador" tabindex="-1" role="dialog" aria-labelledby="mdlmarcadorLabel"
     aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <form enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlmarcadorLabel">Añadir marcador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="{{$analisis_id}}" name="analisis_id">
                    <div class="form-group">
                        <label for="js-marker-ajax-id">Marcador</label>
                        <select class="js-example-basic-single js-states form-control" name="marcador" id="js-marker-ajax-id" >
                            @if(!isset($doctor))
                                <option value="">Seleccion...</option>
                            @else
                                <option value="{{ $doctor  }}">{{ $doctor  }}</option>
                            @endif
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="iResultado">Resultado</label>
                        <textarea id="iResultado" name="resultado" class="form-control" rows="3"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="iIntensidad">Intensidad</label>
                        <textarea id="iIntensidad" name="intensidad" class="form-control" rows="3"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Subir</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="marker_image" id="inputGroupFile07" aria-describedby="inputGroupFileAddon07">
                            <label class="custom-file-label" for="inputGroupFile07">Seleccionar archivo</label>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Añadir</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('js')
<script>
    $(document).ready(function () {
        $(document).on('change', '#inputGroupFile07', function (event) {
            $(this).next('.custom-file-label').html(event.target.files[0].name);
        });

        var form = $('#mdl_marcador form');
        $(form).submit(function( event ) {
            // $("#list_marcadores").append(addMarcadorHtml(
            //     $('#js-marker-ajax-id').select2('data')[0].text,
            //     $(form).find('input[name="resultado"]').val(),
            // ));
            // $("#mdl_marcador").modal("hide");
            var form0 = $(this)[0];
            var formData = new FormData(form0);
            $.ajax({
                url: "{{ url('/histo/marcador/create-ajax') }}",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function (data) {
                    console.log(JSON.stringify(data));
                    $("#mdl_marcador").modal("hide");
                    reloadMarcadores();
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    eMarkets = XMLHttpRequest.responseJSON.errors
                    showValidateMessagesMarker(form, eMarkets);
                }
            });

            event.preventDefault();
        });

        {{--tinymce.init({--}}
        {{--    selector: '#iResultado',--}}
        {{--    plugins: "lists autoresize",--}}
        {{--    toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify fontselect fontsizeselect | bullist numlist outdent indent | link image',--}}
        {{--    menubar: false,--}}
        {{--    language: 'es',--}}
        {{--    browser_spellcheck: true,--}}
        {{--    @cannot('manage-users-all') readonly : 1 @endcannot--}}
        {{--});--}}
        {{--tinymce.init({--}}
        {{--    selector: '#iIntensidad',--}}
        {{--    plugins: "lists autoresize",--}}
        {{--    toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify fontselect fontsizeselect | bullist numlist outdent indent | link image',--}}
        {{--    menubar: false,--}}
        {{--    language: 'es',--}}
        {{--    browser_spellcheck: true,--}}
        {{--    @cannot('manage-users-all') readonly : 1 @endcannot--}}
        {{--});--}}

        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#js-marker-ajax-id').select2({
            ajax: {
                url: '{{ route('marker.asearch') }}',
                dataType: 'json',
                type: "post",
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term
                    }
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
            },
            width: '100%'
        });
    });
    function addMarcadorHtml(marcador, resultado){
        let html = '<li class="ui-state-default" style="list-style-type: none;">';
        numMarcadores++;
        html += '<div class="table-bordered" style="padding: 4px;">';
        html += '<h6 class="text-primary"><a class="text-danger" href="#" onclick="removeMarcador(this);"><i class="far fa-trash-alt"></i></a> '+marcador+'</h6>';
        html += '<p class="text-muted">'+resultado+'</p>';
        html += '<input type="hidden" name="marcadores['+numMarcadores+'][nombre]" value="'+marcador+'">';
        html += '<input type="hidden" name="marcadores['+numMarcadores+'][resultado]" value="'+resultado+'">';
        html += '</div>';
        html += '</li>';

        return html;
    }

    function openMdlMarcador() {
        $("#mdl_marcador").modal("show");
        clearFormMarket0();
    }

    function showValidateMessagesMarker(form, eMarkets){
        $(form).find('input,select,textarea').each(function(i){
            elementMarket = this;
            $(elementMarket).removeClass('is-invalid');
            $.each(eMarkets, function (key, arr){
                if($(elementMarket).attr('name') === key){
                    $(elementMarket).addClass('is-invalid');
                    // $(elementMarket).next().empty().append(arr.join([separator = ',']));
                    $(elementMarket).parent().find('.invalid-feedback').empty().append(arr.join([separator = ',']));
                }
            });

        });

    }

    function clearFormMarket0(){
        form = $("#mdl_marcador form");
        $("#mdl_marcador input[name='id']").val('');
        $(form)[0].reset();
        clearValidForm0(form);
    }

    function clearValidForm0(form){
        $(form).find('input,select,textarea').each(function(i){
            $(this).removeClass('is-invalid');
        });
    }
</script>
@endpush
