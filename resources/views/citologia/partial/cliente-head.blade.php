<dl class="row row-citologia">
    <dt class="col-md-3">Nombres y Apellidos:</dt>
    <dd class="col-md-3">{{$analisis->person->apellidos.' '.$analisis->person->apellido_materno.', '.$analisis->person->nombres}}</dd>
    <dt class="col-md-3">Enviado por (Doctor):</dt>
    <dd class="col-md-3">{{$analisis->doctor}}</dd>
</dl>
<dl class="row row-citologia">
    <dt class="col-md-3">Procedencia:</dt>
    <dd class="col-md-3">{{$analisis->institucion->nombre}}</dd>
    <dt class="col-md-3">Edad:</dt>
    <dd class="col-md-3">{{$analisis->person->edad}} años</dd>
</dl>
<dl class="row row-citologia">
    <dt class="col-md-3">Sexo:</dt>
    <dd class="col-md-3">{{(strcmp($analisis->person->sexo, 'hombre') == 0)? 'MASCULINO' : 'FEMENINO'}}</dd>
    <dt class="col-md-3">Codigo:</dt>
    <dd class="col-md-3">{{$analisis->codigo}}</dd>
</dl>
<dl class="row row-citologia">
    <dt class="col-md-3">Fecha de Registro:</dt>
    <dd class="col-md-3">{{(isset($analisis->fecha)? $analisis->fecha->format('Y-m-d'): '--')}}</dd>
    <dt class="col-md-3">Fecha Conclusión:</dt>
{{--    <dd class="col-md-3">{{(isset($analisis->fecha_cierre)? $analisis->fecha_cierre->format('Y-m-d'): '--')}}</dd>--}}
    <dd class="col-md-3">{{ $analisis->lastControlEdition()? $analisis->lastControlEdition()->created_at->format('Y-m-d') : '--' }}</dd>
</dl>
<dl class="row row-citologia">
    <dt class="col-md-3">Analisis Entregado A:</dt>
    <dd class="col-md-3">{{(isset($analisis->persona_entrega)? $analisis->persona_entrega: '--')}}</dd>
    <dt class="col-md-3">Fecha Entrega:</dt>
    <dd class="col-md-3">{{(isset($analisis->fecha_entrega)? $analisis->fecha_entrega->format('Y-m-d'): '--')}}</dd>
</dl>
<dl class="row row-citologia">
    <dt class="col-md-3">Región:</dt>
    <dd class="col-md-3">{{$analisis->region}}</dd>
    <dt class="col-md-3">Teléfono de referencia:</dt>
    <dd class="col-md-3">{{(isset($analisis->telefono_referencia)? $analisis->telefono_referencia: '--')}}</dd>
</dl>
<dl class="row row-citologia">
    <dt class="col-md-3">Doctor asígnado:</dt>
    <dd class="col-md-9">{{$analisis->doctorasig->nombres.' '.$analisis->doctorasig->apellidos}}</dd>
{{--    <dt class="col-md-3">Telefono de referencia:</dt>--}}
{{--    <dd class="col-md-3">{{(isset($analisis->telefono_referencia)? $analisis->telefono_referencia: '--')}}</dd>--}}
</dl>
@if(isset($analisis->convenio))
    <dl class="row row-citologia">
        <dt class="col-md-3">Matrícula convenio:</dt>
        <dd class="col-md-3">{{$analisis->convenio->bancaMatricula}}</dd>
        <dt class="col-md-3">Preafiliación convenio:</dt>
        <dd class="col-md-3">{{$analisis->convenio->bancaPreAfiliacion}}</dd>
    </dl>
@endif

<dl class="row row-citologia">
    @can('manage-users')
    <dt class="col-md-2">
        <button type="button"
                class="btn btn-outline-info btn-block" data-toggle="modal"
                data-target="#mEditarCosto">Editar Precio</button>
    </dt>
    <dd class="col-md-2">
        <a href="{{ route('analisis.edit', $analisis) }}"
                class="btn btn-outline-success btn-block">Editar Analisis</a>
    </dd>
    <dd class="col-md-2">
        <a href="{{ route('analisis.lista.impresion', $analisis) }}"
           class="btn btn-outline-success btn-block">Historial Impresion</a>
    </dd>
    <dd class="col-md-2">
        <a href="{{ route('analisis.lista.edicion', $analisis) }}"
           class="btn btn-outline-success btn-block">Historial de Cambios</a>
    </dd>
    @endcan
    @can('manage-users-dr1')
    <dd class="col-md-2">
        @if($analisis->hasHistory())
            <a href="{{url('analisis/listByPerson/'.$analisis->person->id)}}" class="btn btn-link text-success" style="font-size: 12px"><b>Tiene estudios anteriores</b></a>
        @endif
    </dd>
    @endcan
</dl>
<div id="mEditarCosto" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title">Editar Precio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="precio">Precio de analisis (Bs)</label>
                        <input type="text" name="precio" id="" class="form-control">
                        <div class="fcp_error_precio" style="display: none;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('js')
<script>
    $(document).ready(function () {
        var form = $('#mEditarCosto form');
        $(form).submit(function( event ) {
            var precio = $('#mEditarCosto form input[name="precio"]').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('analisis.aSetPrecioByAnalisis') }}",
                type: 'POST',
                data: {analisis_id: '{{$analisis->id}}', precio: precio},
                success: function (data) {
                    $('#mEditarCosto').modal('hide');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    var response = JSON.parse(XMLHttpRequest.responseText);
                    console.log(response.errors);
                    $.each(response.errors, function(key, value){
                        console.log(JSON.stringify(value));
                        $('#mEditarCosto form').find("input[name='" + key + "']").addClass('is-invalid');
                        var msgs = "<ul class='list-unstyled'>";
                        $.each(value, function (key1, value1) {
                            msgs += "<li><span class='text-danger'>" + value1 + "</span></li>";
                        });
                        msgs += "</ul>";
                        $('.fcp_error_' + key).empty().append(msgs);
                        $('.fcp_error_' + key).show();
                    });
                }
            });

            event.preventDefault();
        });
    });

    $('#mEditarCosto').on('show.bs.modal', function (event) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('analisis.aGetPrecioByAnalisis') }}",
            type: 'POST',
            data: {analisis_id: '{{$analisis->id}}'},
            success: function (data) {
                $('#mEditarCosto form input[name="precio"]').val(data.precio);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    });
</script>
@endpush