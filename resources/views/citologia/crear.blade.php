@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Resultado Analisis', 'navName' => 'Resultado Analisis', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item">Crear Analisis</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            @include('citologia.partial.cliente-head', ['analisis' => $analisis])
        </div>
        <div class="card-body">
            <form method="post" action="/citologia/resultados">
                {{ csrf_field() }}
                <input type="hidden" name="analisis_id" value="{{$analisisId}}">
                <div class="modal-body">
                    <p class="text-muted" style="margin-bottom: 2px;">Clasificacion del Papanicolau Clase</p>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <input type="text" name="papanicolaou_clase1"
                                   class="form-control @error('papanicolaou_clase1') is-invalid @enderror"
                                   onkeyup="uppercaseInput(this);"
                            >
                            @error('papanicolaou_clase1')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="papanicolaou_clase2"
                                   class="form-control @error('papanicolaou_clase2') is-invalid @enderror"
                                   onkeyup="uppercaseInput(this);"
                            >
                            @error('papanicolaou_clase2')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="ana-ext-title text-muted">OMS</h3>
                            <div class="form-group row">
                                <label for="displasia-leve" class="col-md-6 col-form-label text-right">DISPLASIA LEVE</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm"
                                           name="oms[displasia-leve]"
                                           onkeyup="uppercaseInput(this);"
                                    >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="displasia-moderada" class="col-md-6 col-form-label text-right">DISPLASIA MODERADA</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm"
                                           name="oms[displasia-moderada]"
                                           onkeyup="uppercaseInput(this);"
                                    >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="displasia-severa" class="col-md-6 col-form-label text-right">DISPLASIA SEVERA</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm"
                                           name="oms[displasia-severa]"
                                           onkeyup="uppercaseInput(this);"
                                    >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="displasia-in" class="col-md-6 col-form-label text-right">DISPLASIA IN SITU</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm"
                                           name="oms[displasia-in]"
                                           onkeyup="uppercaseInput(this);"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h3 class="ana-ext-title text-muted">HICHART</h3>
                            <div class="form-group row">
                                <label for="nic-i" class="col-md-6 col-form-label text-right">NIC I</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm"
                                           name="hichart[nic-i]"
                                           onkeyup="uppercaseInput(this);"
                                    >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nic-ii" class="col-md-6 col-form-label text-right">NIC II</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm"
                                           name="hichart[nic-ii]"
                                           onkeyup="uppercaseInput(this);"
                                    >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nic-iii" class="col-md-6 col-form-label text-right">NIC III</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm"
                                           name="hichart[nic-iii]"
                                           onkeyup="uppercaseInput(this);"
                                    >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nic-iv" class="col-md-6 col-form-label text-right">NIC IV</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm"
                                           name="hichart[nic-iv]"
                                           onkeyup="uppercaseInput(this);"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h3 class="ana-ext-title text-muted">BETHESDA (N.C.I.)</h3>
                            <div class="form-group row">
                                <label for="lis-bajo" class="col-md-6 col-form-label text-right">LIS DE BAJO GRADO</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm"
                                           name="bethesda[lis-bajo]"
                                           onkeyup="uppercaseInput(this);"
                                    >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lis-alto" class="col-md-6 col-form-label text-right">LIS DE ALTO GRADO</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm"
                                           name="bethesda[lis-alto]"
                                           onkeyup="uppercaseInput(this);"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <p class="text-muted">EXTENDIDO COMPATIBLE CON LOS DIAGNOSTICOS
                        <a href="#" class="btn btn-link btn-link-clinica" data-toggle="modal" data-target="#ecdModal">
                            <i class="far fa-plus-square fa-lg"></i>
                        </a>
                    </p>
                    <div id="ecdList" class="row">
                    </div>
                    <hr>
                    <p class="text-muted">REACCION INFLAMATORIA
                        <a href="#" class="btn btn-link btn-link-clinica" data-toggle="modal" data-target="#reacInflaModal">
                            <i class="far fa-plus-square fa-lg"></i>
                        </a>
                    </p>
                    <div id="reacInflamatoriaList" class="row"></div>
                    <hr>
                    <p class="text-muted">ESTUDIO MICROBIOLOGICO
                        <a href="#" class="btn btn-link btn-link-clinica" data-toggle="modal" data-target="#estMicroModal">
                            <i class="far fa-plus-square fa-lg"></i>
                        </a>
                    </p>
                    <div id="estMicroList" class="row"></div>
                    <hr>
                    <p class="text-muted">ESTUDIO CITO - HORMONAL</p>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="estCito[PARABASALES]">PARABASALES</label>
                            <input type="text" class="form-control"
                                   name="estCito[PARABASALES]"
                                   onkeyup="uppercaseInput(this);"
                            >
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="estCito[INTERMEDIAS]">INTERMEDIAS</label>
                            <input type="text" class="form-control"
                                   name="estCito[INTERMEDIAS]"
                                   onkeyup="uppercaseInput(this);"
                            >
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="estCito[SUPERFICIALES]">SUPERFICIALES</label>
                            <input type="text" class="form-control"
                                   name="estCito[SUPERFICIALES]"
                                   onkeyup="uppercaseInput(this);"
                            >
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="tipo[ESTROGENICO]">TIPO ESTROGENICO</label>
                            <input type="text" class="form-control"
                                   name="tipo[ESTROGENICO]"
                                   onkeyup="uppercaseInput(this);"
                            >
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="tipo[INTERMEDIO]">TIPO INTERMEDIO</label>
                            <input type="text" class="form-control"
                                   name="tipo[INTERMEDIO]"
                                   onkeyup="uppercaseInput(this);"
                            >
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="tipo[PARABASAL]">TIPO PARABASAL</label>
                            <input type="text" class="form-control"
                                   name="tipo[PARABASAL]"
                                   onkeyup="uppercaseInput(this);"
                            >
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="tipo[ATROFICO]">TIPO ATROFICO</label>
                            <input type="text" class="form-control"
                                   name="tipo[ATROFICO]"
                                   onkeyup="uppercaseInput(this);"
                            >
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="desviacion[DESVIACION A LA IZQUIERDA]">DESVIACION A LA IZQUIERDA</label>
                            <input type="text" class="form-control"
                                   name="desviacion[DESVIACION A LA IZQUIERDA]"
                                   onkeyup="uppercaseInput(this);"
                            >
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="desviacion[DESVIACION AL CENTRO]">DESVIACION AL CENTRO</label>
                            <input type="text" class="form-control"
                                   name="desviacion[DESVIACION AL CENTRO]"
                                   onkeyup="uppercaseInput(this);"
                            >
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="desviacion[DESVIACION A LA DERECHA]">DESVIACION A LA DERECHA</label>
                            <input type="text" class="form-control"
                                   name="desviacion[DESVIACION A LA DERECHA]"
                                   onkeyup="uppercaseInput(this);"
                            >
                        </div>
                    </div>
                    <hr>
                    <p class="text-muted">OBSERVACIONES</p>
                    <div class="row">
                        <div class="col-md-6">
                            <textarea name="observaciones1" class="form-control" style="resize: none;" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <textarea name="observaciones2" class="form-control" style="resize: none;" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cerrar</a>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Extendido compatible-->
    <div class="modal fade" id="ecdModal" tabindex="-1" role="dialog" aria-labelledby="ecdModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ecdModalLabel">Aniadir Extendido Compatible</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" id="s_extendido_compatible">
                            @foreach(Config::get('clinica.extendido_compatible') as $extComp)
                                <option>{{$extComp}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="addExtendidoCompatible();">Aniadir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reaccion inflamatoria -->
    <div class="modal fade" id="reacInflaModal" tabindex="-1" role="dialog" aria-labelledby="reacModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="reacInflaForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="reacModalLabel">Aniadir reaccion inflamatoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control" name="tipo" required>
                                <option value="">Seleccione ...</option>
                                @foreach(Config::get('clinica.reac_inflamatoria') as $reacInfla)
                                    <option>{{$reacInfla}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="descripcion" class="form-control"
                                   onkeyup="uppercaseInput(this);"
                                   required>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Aniadir</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Estudio Microbiologico-->
    <div class="modal fade" id="estMicroModal" tabindex="-1" role="dialog" aria-labelledby="estMicroModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="estMicroForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="estMicroModalLabel">Aniadir Estudio Microbiologico</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control" name="tipo" required>
                                    <option value="">Seleccione ...</option>
                                    @foreach(Config::get('clinica.estudio_microbiologico') as $estMicro)
                                        <option>{{$estMicro}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="descripcion" class="form-control"
                                       onkeyup="uppercaseInput(this);"
                                       required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Aniadir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $("#reacInflaForm").submit(function (event) {
                event.preventDefault();
                var riKey = $("#reacInflaForm").find("select[name=tipo]").val();
                var riValue = $("#reacInflaForm").find("input[name=descripcion]").val();

                //alert(riKey+" || "+riValue);
                var numItemReacInfla = $("#reacInflamatoriaList").find("input[type=text]").length;
                if(numItemReacInfla < 10){
                    tplItemReacInfla(riKey, riValue);
                    $("#reacInflaForm")[0].reset();
                    $("#reacInflaModal").modal("hide");
                } else {
                    alert("No puede aumentar mas items.");
                }


            });
            $("#estMicroForm").submit(function (event) {
                event.preventDefault();
                var riName = $("#estMicroForm").find("select[name=tipo]").find('option:selected').text();
                var riKey = $("#estMicroForm").find("select[name=tipo]").val();
                var riValue = $("#estMicroForm").find("input[name=descripcion]").val();

                // alert(riName+" || "+riKey+" || "+riValue);
                var numItemEstMicro = $("#estMicroList").find("input[type=text]").length;
                if(numItemEstMicro < 10){
                    tplItemEstMicro(riName,riKey, riValue);
                    $("#estMicroForm")[0].reset();
                    $("#estMicroModal").modal("hide");
                } else {
                    alert("No puede aumentar mas items.");
                }


            });

        });

        function addExtendidoCompatible(){
            var numItemExtComp = $("#ecdList").find("input[type=checkbox]").length;
            if(numItemExtComp < 10){
                tplItemExtendido($("#s_extendido_compatible").val());
            } else {
                alert("No puede aniadir mas items.");
            }

            $("#ecdModal").modal('hide');
        }

        function tplItemExtendido(nombre){
            var html = "";
            html += "<div class='col-md-3'>";
            html += "<p style='color: #000; font-size: .8rem; margin-bottom: 2px;'>";
            html += "<a href='#' class='btn btn-link' style='padding: 2px;' onclick='removeItemExtendido(this); return false;'>";
            html += "<i class='far fa-trash-alt'></i></a> "+nombre;
            html += "</p>";
            html += "<input type='checkbox' style='visibility: hidden;' name='ExtComp[]' checked value='"+nombre+"'>";
            html += "</div>";

            $("#ecdList").append(html);
        }

        function removeItemExtendido(link){
            $(link).parent().parent().remove();
        }

        function tplItemReacInfla(key, value){
            var html = "";
            html += "<div class='col-md-4 row'>";
            html += "<div class='col-md-6'>";
            html += "<p style='color: #000; font-size: .8rem; margin-bottom: 2px; text-align: right;'>";
            html += "<a href='#' class='btn btn-link' style='padding: 2px;' onclick='removeItemReacInfla(this); return false;'>";
            html += "<i class='far fa-trash-alt'></i></a> "+key;
            html += "</p>";
            html += "</div>";
            html += "<div class='col-md-6'>";
            html += "<input type='text' class='form-control' name='reacInfla["+key+"]' value='"+value+"' readonly>";
            html += "</div>";
            html += "</div>";

            $("#reacInflamatoriaList").append(html);
        }

        function tplItemEstMicro(name, key, value){
            var html = "";
            html += "<div class='col-md-4 row'>";
            html += "<div class='col-md-6'>";
            html += "<p style='color: #000; font-size: .8rem; margin-bottom: 2px; text-align: right;'>";
            html += "<a href='#' class='btn btn-link' style='padding: 2px;' onclick='removeItemEstudioMicro(this); return false;'>";
            html += "<i class='far fa-trash-alt'></i></a> "+name;
            html += "</p>";
            html += "</div>";
            html += "<div class='col-md-6'>";
            html += "<input type='text' class='form-control' name='estudioMicro["+key+"]' value='"+value+"' readonly>";
            html += "</div>";
            html += "</div>";

            $("#estMicroList").append(html);
        }


        function removeItemReacInfla(link){
            $(link).parent().parent().parent().remove();
        }

        function removeItemEstudioMicro(link){
            $(link).parent().parent().parent().remove();
        }
    </script>
@endpush