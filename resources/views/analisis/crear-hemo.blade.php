@php
/** @var [] $tipoPagoAcuenta */
@endphp
@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Administrar Clientes', 'navName' => 'Crear Analisis', 'activeButton' => 'clientActiveButton'])

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
            <div class="row">
                <div class="col-md-4">
                    <dl>
                        <dt>Nombres y Apellidos: </dt>
                        <dd>{{ $persona->full_name }}</dd>
                    </dl>
                </div>
                <div class="col-md-4">
                    <dl>
                        <dt>Fecha nacimiento:</dt>
                        <dd>{{($persona->f_nacimiento)? $persona->f_nacimiento : '--'}}</dd>
                    </dl>
                </div>
                <div class="col-md-4">
                    <dl>
                        <dt>Sexo:</dt>
                        <dd>{{$persona->sexo}}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="position-fixed overflow-auto" style="top: 80%; right: 1%; z-index: 2500; background: white;">
                <div class="m-1 p-3 rounded border border-info">
                    <h4 class="text-info">Precio total: <b id="msgPriceTotal">0</b> Bs.</h4>
                </div>
            </div>
{{--            <div class="fixed-bottom">Pp...</div>--}}

            <form method="post" action="/analisis" id="formAnalisis">
                {{ csrf_field() }}
                <input type="hidden" name="person_id" value="{{$persona->id}}">
                <input type="hidden" name="tipo_analisis" value="{{\App\Analisis::PRUEBA}}">
                <input type="hidden" name="codigo" value="--">
                <input type="hidden" name="region" value="--">

                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="edad">Edad</label>
                            <input type="number" name="edad"
                                   class="form-control @error('edad') is-invalid @enderror"
                                   value="{{old('edad')? old('edad') : $edad}}">
                            @error('edad')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="doctor">Doctor que envia</label>
                            <input type="text" name="doctor"
                                   id="search-envia" autocomplete="off"
                                   class="form-control @error('doctor') is-invalid @enderror"
                                   onkeyup="uppercaseInput(this);"
                                   value="{{old('doctor')}}">
                            <div id="suggesstion-box"></div>
                            @error('doctor')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="telefono_referencia">Telefono Referencia</label>
                        <input type="text" name="telefono_referencia" class="form-control @error('telefono_referencia') is-invalid @enderror"
                               onfocus="hideSuggesstionBox();"
                               value="{{old('telefono_referencia')}}">
                        @error('telefono_referencia')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="fecha">Fecha de Ingreso</label>
                        <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                               value="{{old('fecha', date('Y-m-d'))}}"
                               onfocus="hideSuggesstionBox();"
                               min="{{date('Y-m-d', strtotime("-10 days"))}}"
                               max="{{date('Y-m-d', strtotime("5 days"))}}"
                        >
                        {{--                                       value="2019-12-30">--}}
                        @error('fecha')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <h6>Datos Para Facturacion</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="procedencia">Procedencia</label>
                        <select id="s_procedencia" name="procedencia" onchange="fntBanca(this);" class="form-control @error('procedencia') is-invalid @enderror">
                            @if(old('procedencia'))
                                @foreach($procedencias as $procedencia)
                                    @if(old('procedencia') == $procedencia->id)
                                        <option value="{{$procedencia->id}}" selected>{{$procedencia->nombre}}</option>
                                    @else
                                        <option value="{{$procedencia->id}}">{{$procedencia->nombre}}</option>
                                    @endif
                                @endforeach
                            @else
                                @foreach($procedencias as $procedencia)
                                    <option value="{{$procedencia->id}}">{{$procedencia->nombre}}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('procedencia')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="doctor_asignado">Asignar Doctor</label>
                        <select name="doctor_asignado" class="form-control @error('fecha_entrega') is-invalid @enderror">
                            <option value="">Elija un doctor</option>
                            @if(old('doctor_asignado'))
                                @foreach($doctores as $doctor)
                                    @if(old('doctor_asignado') == $doctor->id)
                                        <option value="{{$doctor->id}}" selected>{{$doctor->nombres}} {{$doctor->apellidos}}</option>
                                    @else
                                        <option value="{{$doctor->id}}">{{$doctor->nombres}} {{$doctor->apellidos}}</option>
                                    @endif
                                @endforeach
                            @else
                                @foreach($doctores as $doctor)
                                    <option value="{{$doctor->id}}" @if($doctor->id == 5) selected @endif>{{$doctor->nombres}} {{$doctor->apellidos}}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('doctor_asignado')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3" style="background-color: #E8F1FF;">
                        <div class="form-group">
                            <label for="razon_social">Razon Social</label>
                            <input type="text" name="razon_social" class="form-control @error('razon_social') is-invalid @enderror"
                                   value="{{@old('razon_social')}}"
                            >
                            @error('razon_social')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3" style="background-color: #E8F1FF;">
                        <label for="nit">NIT</label>
                        <input type="text" name="nit" class="form-control @error('nit') is-invalid @enderror"
                               value="{{@old('nit')}}"
                        >
                        @error('nit')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="internal_code">Código interno</label>
                            <input class="form-control @error('internal_code') is-invalid @enderror"
                            value="{{@old('internal_code')}}" name="internal_code" />
                            @error('internal_code')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="hidden" name="precio" value="{{@old('precio')}}">
                            <label for="precio">Precio</label>
                            <div class="form-control @error('precio') is-invalid @enderror text-right bg-light"
                            >{{@old('precio')}}</div>
                            @error('precio')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="acuenta">Acuenta</label>
                        <input type="number" name="acuenta" class="form-control @error('acuenta') is-invalid @enderror"
                               value="{{@old('acuenta')}}"
                               min="0" max="10000"
                        >
                        @error('acuenta')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="acuenta">Tipo de pago Acuenta</label>
                        <br>
                        @foreach($tipoPagoAcuenta as $i => $tipo_pago)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo_pago_acuenta"
                                       onchange="changeTipoPago(this);"
                                       id="tipo_pago_acuenta_{{$i}}" value="{{$tipo_pago}}"
                                       @if(old('tipo_pago_acuenta') && strcmp(old('tipo_pago_acuenta'), $tipo_pago) == 0) checked @elseif(!old('tipo_pago_acuenta') && $i==0) checked  @endif
                                >
                                <label class="form-check-label" style="padding-left: 2px !important;" for="tipo_pago_acuenta_{{$i}}">{{$tipo_pago}}</label>
                            </div>
                        @endforeach

                        @error('tipo_pago_acuenta')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="row acuenta-tarjeta @if(!old('tipo_pago_acuenta')) fade @elseif(old('tipo_pago_acuenta') && strcmp(old('tipo_pago_acuenta'), 'EFECTIVO') == 0) fade @endif">
                            <div class="col-md-6">
                                <label for="acuenta_numero_tarjeta">Numero de cuenta</label>
                                <input type="text" name="acuenta_numero_tarjeta" id="acuenta_numero_tarjeta"
                                       class="form-control @error('acuenta_numero_tarjeta') is-invalid @enderror"
                                       value="{{@old('acuenta_numero_tarjeta')}}"
                                >
                            </div>
                            <div class="col-md-6">
                                <label for="acuenta_banco">Banco</label>
                                <input type="text" name="acuenta_banco" id="acuenta_banco"
                                       class="form-control @error('acuenta_banco') is-invalid @enderror"
                                       value="{{@old('acuenta_banco')}}"
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                @error('aTests')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <div id="list_group">
                </div>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Atras</a>
                <button type="submit" id="btnSubmit" class="btn btn-primary">Crear</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            getCodigo();

            $("#formAnalisis").submit(function (e) {
                $("#btnSubmit").attr("disabled", true);
                //alert("xxx");
            });

            loadTreeTestGroup();

            var timeout = null;
            $("#search-envia").keyup(function() {
                if($(this).val().length > 2){
                    var inputSearch = this;
                    if (timeout) {
                        clearTimeout(timeout);
                    }
                    timeout = setTimeout(function() {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('analisis.doctor.envia') }}",
                            data: 'keyword=' + $(inputSearch).val(),
                            beforeSend: function() {
                                // $("#search-envia").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
                            },
                            dataType: 'html',
                            success: function(data) {
                                $("#suggesstion-box").show();
                                $("#suggesstion-box").html(data);
                                $("#search-envia").css("background", "#FFF");
                            }
                        });
                    }, 1000);
                } else {
                    hideSuggesstionBox();
                }
            });

        });
    function changeTipoPago(radio){
        $("#formAnalisis input[name='acuenta_numero_tarjeta']").val('');
        $("#formAnalisis input[name='acuenta_banco']").val('');
        if($(radio).val() === "TRANSFERENCIA"){
            $(".acuenta-tarjeta").removeClass("fade");
        } else {
            $(".acuenta-tarjeta").addClass("fade");
        }
    }

        function loadTreeTestGroup(){
            $("#list_group").empty().append(renderLoading());
            $.ajax({
                url: "{{ route('analysis-test-group.render.tree.selected') }}",
                success: function (data) {
                    $("#list_group").empty().append(data);
                }
            });
        }

        function selectEnvia(val) {
            $("#search-envia").val(val);
            $("#suggesstion-box").hide();
        }

        function hideSuggesstionBox(){
            $("#suggesstion-box").hide();
        }

        function loadTestGroup(){
            let aTestIds = null;
            @if(old('aTests'))
                aTestIds = {!! json_encode(old('aTests')) !!};
            @endif
            $("#list_group").empty().append(renderLoading());
            $.ajax({
                url: "{{ route('analysis-test-group.render.list.selected') }}",
                data: {aTestIds},
                success: function (data) {
                    $("#list_group").empty().append(data);
                }
            });
        }

        function renderLoading(){
            return '<div style="text-align: center; width: 100%;"><div class="fa-3x"><i class="fas fa-cog fa-spin"></i></div></div>';
        }

        function updateTotalPriceTest(){
            let testPrices = $("#list_group .test-price");
            let total = 0;
            $.each(testPrices, function(i, testPrice){
                if($(testPrice).is(':checked')){
                    total += parseFloat($(testPrice).data('price'));
                }
            });
            let inputPrecio = $("#formAnalisis input[name='precio']");
            if(total !== 0){
                $("#msgPriceTotal").empty().append(total);
                $(inputPrecio).val(total);
                $(inputPrecio).next().next().empty().append(total);
            } else {
                $("#msgPriceTotal").empty().append('--');
                $(inputPrecio).val('');
                $(inputPrecio).next().next().empty().append('--');
            }
        }

        function reloadGroupChilds(input){
            parent = $(input).parent().parent().parent().parent().parent();
            cardBody = $(parent).find(".card-body");
            if($(input).is(':checked')){
                checks = $(cardBody).find("input[type=checkbox]");
                $.each(checks, function(ind, check){
                    if($(check).is(':checked')){
                        $(check).click();
                    }
                    $(check).attr('disabled', 'disabled');
                    $(check).parent().parent().addClass('disabled');
                });
            } else {
                checks = $(cardBody).find("input[type=checkbox]");
                $.each(checks, function(ind, check){
                    $(check).removeAttr('disabled');
                    $(check).parent().parent().removeClass('disabled');
                    if($(check).is(':checked')){
                        $(check).click();
                    }
                });

            }
            // alert($(cardBody).html());
            updateTotalPriceTest();
        }

    </script>
@endpush
