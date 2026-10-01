{{-- Modal registro persona (compartido por clients/home y preorder/home).
     En contexto pre-orden (@include con ['preOrderMode' => true]) se omite la
     sección "Crear Analisis" porque el análisis se crea en la pantalla destino. --}}
<div id="mpersona" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <form id="fcrearpersona" action="">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="mperson_title" class="modal-title ">Crear Persona</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ci">CI</label>
                                <input type="text" name="ci" class="form-control" placeholder="Carnet de identidad" onchange="searchClient(this);">
                                <div class="fcp_error_ci" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombres <span class="text-danger">*</span></label>
                                <input type="text" name="nombres"
                                       onkeyup="uppercaseInput(this);"
                                       onchange="searchClient(this);"
                                       class="form-control" placeholder="Nombres">
                                <div class="fcp_error_nombres" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellidos">Apellido Paterno <span class="text-danger">*</span></label>
                                <input type="text" name="apellidos"
                                       class="form-control"
                                       onkeyup="uppercaseInput(this);"
                                       onchange="searchClient(this);"
                                       placeholder="Apellido Paterno">
                                <div class="fcp_error_apellidos" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellido_materno">Apellido Materno</label>
                                <input type="text" name="apellido_materno"
                                       class="form-control"
                                       onkeyup="uppercaseInput(this);"
                                       onchange="searchClient(this);"
                                       placeholder="Apellido Materno">
                                <div class="fcp_error_apellido_materno" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="f_nacimiento">Fecha nacimiento</label>
                                <input type="date" name="f_nacimiento" class="form-control">
                                <div class="fcp_error_f_nacimiento" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="sexo1">Sexo <span class="text-danger">*</span></label>
                            <br>

                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="sexo1" name="sexo" value="hombre" class="custom-control-input">
                                <label class="custom-control-label" for="sexo1">Hombre</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="sexo2" name="sexo" value="mujer" class="custom-control-input">
                                <label class="custom-control-label" for="sexo2">Mujer</label>
                            </div>
                            <div class="fcp_error_sexo" style="display: none;"></div>
                        </div>
                    </div>
                    @if(empty($preOrderMode))
                    <div class="custom-control custom-checkbox fade">
                        <input type="checkbox" class="custom-control-input" name="crear_analisis" onchange="showhideCrearAnalisis(this);" id="customControlValidation1" value="1">
                        <label class="custom-control-label" for="customControlValidation1">Crear Analisis</label>
                    </div>
                    <div id="d_crear_analisis" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="tipo_analisis" id="s_tipoanalisis" onchange="getCodigo();" class="form-control">
                                        <option value="">Elija un Analisis</option>
                                        @foreach($tipoAnalisis as $analisis)
                                            <option value="{{$analisis}}">{{ __('clinica_msg.'.$analisis) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="fcp_error_tipo_analisis" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_analisis">Codigo</label>
                                    <input type="text" name="codigo" id="i_codigo" class="form-control i-codigo" readonly>
                                    <div class="fcp_error_codigo" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="region">Region de analisis <span class="text-danger">*</span></label>
                                    <input type="text" id="region" name="region" class="form-control">
                                    <div class="fcp_error_region" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio">Precio <span class="text-danger">*</span></label>
                                    <input type="text" name="precio" class="form-control">
                                    <div class="fcp_error_precio" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="acuenta">Acuenta</label>
                                <input type="text" name="acuenta" class="form-control">
                                <div class="fcp_error_acuenta" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-lab-pdm-primary btn-sm">Grabar</button>
                </div>
            </div>
        </form>
    </div>
</div>
