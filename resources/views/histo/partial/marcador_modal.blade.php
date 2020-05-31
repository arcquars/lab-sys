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
                            <select name="marcador" class="form-control">
                                @foreach(config('clinica.marcadores') as $value)
                                    <option value="{{$value}}">{{$value}}</option>
                                @endforeach
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
                $(form).find('select[name="marcador"]').val(),
                $(form).find('input[name="resultado"]').val(),
            ));
            $("#mdl_marcador").modal("hide");
            event.preventDefault();
        });
    });
    function addMarcadorHtml(marcador, resultado){
        let html = '<div class="col-md-3">';
        numMarcadores++;
        html += '<div class="table-bordered" style="padding: 4px;">';
        html += '<h6 class="text-primary"><a class="text-danger" href="#" onclick="removeMarcador(this);"><i class="far fa-trash-alt"></i></a> '+marcador+'</h6>';
        html += '<p class="text-muted">'+resultado+'</p>';
        html += '<input type="hidden" name="marcadores['+numMarcadores+'][nombre]" value="'+marcador+'">';
        html += '<input type="hidden" name="marcadores['+numMarcadores+'][resultado]" value="'+resultado+'">';
        html += '</div>';
        html += '</div>';

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