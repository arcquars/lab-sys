<!-- Modal -->
<div class="modal fade" id="mdl_marcador" tabindex="-1" role="dialog" aria-labelledby="mdlmarcadorLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlmarcadorLabel">Añadir marcador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <select class="js-example-basic-single js-states form-control" name="marcador" id="js-marker-ajax-id" required  >
                                @if(!isset($doctor))
                                    <option value="">Seleccion...</option>
                                @else
                                    <option value="{{ $doctor  }}">{{ $doctor  }}</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="resultado" class="form-control" required>
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
        var form = $('#mdl_marcador form');
        $(form).submit(function( event ) {
            $("#list_marcadores").append(addMarcadorHtml(
                // $(form).find('select[name="marcador"]').val(),
                $('#js-marker-ajax-id').select2('data')[0].text,
                $(form).find('input[name="resultado"]').val(),
            ));
            $("#mdl_marcador").modal("hide");
            event.preventDefault();
        });

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
        $("#mdl_marcador").find('form')[0].reset();
    }

    function removeMarcador(link){
        $(link).parent().parent().parent().remove();
    }
</script>
@endpush
