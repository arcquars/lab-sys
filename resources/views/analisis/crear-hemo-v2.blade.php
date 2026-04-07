@php
/** @var [] $tipoPagoAcuenta */


@endphp
@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Administrar Clientes', 'navName' => 'Crear Analisis', 'activeButton' => 'clientActiveButton'])

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
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
            {{-- =====================================================
                 CARRITO LATERAL FIJO
                 ===================================================== --}}
            <style>
            /* ---- Cart sidebar ---- */
            #labCart {
                position: fixed;
                top: 80px;
                right: 18px;
                width: 310px;
                z-index: 3000;
                background: #fff;
                border-radius: 14px;
                box-shadow: 0 8px 32px rgba(37,99,235,.13), 0 2px 8px rgba(0,0,0,.08);
                border: 1.5px solid #dbeafe;
                display: flex;
                flex-direction: column;
                max-height: calc(100vh - 100px);
                transition: box-shadow .2s;
                font-family: inherit;
            }
            /* Header */
            #labCartHeader {
                background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
                color: #fff;
                border-radius: 12px 12px 0 0;
                padding: 12px 16px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-shrink: 0;
            }
            #labCartHeader .cart-title {
                font-size: 14px;
                font-weight: 700;
                display: flex;
                align-items: center;
                gap: 7px;
            }
            #labCartCountBadge {
                background: rgba(255,255,255,.25);
                border-radius: 20px;
                padding: 2px 9px;
                font-size: 12px;
                font-weight: 700;
            }
            /* Items list */
            #labCartItems {
                overflow-y: auto;
                flex: 1;
                padding: 8px 0;
                min-height: 40px;
            }
            .lab-cart-item {
                display: flex;
                align-items: flex-start;
                gap: 8px;
                padding: 8px 14px;
                border-bottom: 1px solid #f1f5f9;
                transition: background .15s;
            }
            .lab-cart-item:last-child { border-bottom: none; }
            .lab-cart-item:hover { background: #f8fafc; }
            .lab-cart-item-info { flex: 1; min-width: 0; }
            .lab-cart-item-name {
                font-size: 13px;
                font-weight: 600;
                color: #1e293b;
                line-height: 1.3;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .lab-cart-item-group {
                font-size: 11px;
                color: #64748b;
                margin-top: 1px;
            }
            .lab-cart-item-price {
                font-size: 13px;
                font-weight: 700;
                color: #0369a1;
                white-space: nowrap;
                flex-shrink: 0;
                padding-top: 1px;
            }
            .lab-cart-item-price.sin-precio { color: #94a3b8; }
            .lab-cart-remove {
                background: none;
                border: none;
                color: #94a3b8;
                cursor: pointer;
                padding: 0 2px;
                font-size: 13px;
                line-height: 1;
                flex-shrink: 0;
                padding-top: 2px;
                transition: color .15s;
            }
            .lab-cart-remove:hover { color: #ef4444; }
            /* Empty state */
            #labCartEmpty {
                text-align: center;
                padding: 20px 10px;
                color: #94a3b8;
                font-size: 13px;
                display: none;
            }
            /* Tipo pago */
            #labCartPago {
                padding: 8px 14px 6px;
                border-top: 1px solid #e2e8f0;
                flex-shrink: 0;
            }
            #labCartPago .pago-label {
                font-size: 10px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .6px;
                color: #64748b;
                margin-bottom: 6px;
            }
            .lab-pago-btns { display: flex; gap: 6px; }
            .lab-pago-btn {
                flex: 1;
                padding: 5px 4px;
                border: 1.5px solid #e2e8f0;
                border-radius: 8px;
                background: #fff;
                font-size: 12px;
                font-weight: 600;
                color: #64748b;
                cursor: pointer;
                transition: all .15s;
                text-align: center;
            }
            .lab-pago-btn.active {
                background: #2563eb;
                border-color: #2563eb;
                color: #fff;
            }
            /* Footer totales */
            #labCartFooter {
                padding: 10px 14px;
                border-top: 1px solid #e2e8f0;
                flex-shrink: 0;
                background: #f8fafc;
                border-radius: 0 0 12px 12px;
            }
            .lab-cart-subtotal {
                display: flex;
                justify-content: space-between;
                font-size: 12px;
                color: #64748b;
                margin-bottom: 4px;
            }
            .lab-cart-total-row {
                display: flex;
                justify-content: space-between;
                align-items: baseline;
                margin-top: 6px;
                padding-top: 6px;
                border-top: 1.5px solid #e2e8f0;
            }
            .lab-cart-total-label {
                font-size: 15px;
                font-weight: 700;
                color: #1e293b;
            }
            #labCartTotalAmount {
                font-size: 22px;
                font-weight: 800;
                color: #1d4ed8;
            }
            #labCartTotalCurrency {
                font-size: 14px;
                font-weight: 600;
                color: #1d4ed8;
                margin-left: 3px;
            }
            /* Botón guardar */
            #labCartSaveBtn {
                display: block;
                width: 100%;
                margin-top: 10px;
                padding: 11px;
                background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
                color: #fff;
                border: none;
                border-radius: 10px;
                font-size: 14px;
                font-weight: 700;
                cursor: pointer;
                transition: opacity .15s, transform .1s;
                text-align: center;
            }
            #labCartSaveBtn:hover { opacity: .92; transform: translateY(-1px); }
            #labCartSaveBtn:active { transform: translateY(0); }
            #labCartSaveBtn:disabled { opacity: .5; cursor: not-allowed; transform: none; }
            /* Limpiar */
            #labCartClearBtn {
                display: block;
                width: 100%;
                margin-top: 6px;
                padding: 7px;
                background: none;
                color: #94a3b8;
                border: none;
                border-radius: 8px;
                font-size: 12px;
                cursor: pointer;
                transition: color .15s, background .15s;
                text-align: center;
            }
            #labCartClearBtn:hover { color: #ef4444; background: #fef2f2; }
            /* Responsivo: en pantallas pequeñas el carrito se oculta */
            @media (max-width: 992px) {
                #labCart { display: none !important; }
            }
            </style>

            <div id="labCart">
                {{-- Header --}}
                <div id="labCartHeader">
                    <span class="cart-title">
                        <i class="fas fa-clipboard-list"></i>
                        Resumen del Pedido
                    </span>
                    <span id="labCartCountBadge">0 análisis</span>
                </div>

                {{-- Lista de ítems --}}
                <div id="labCartItems">
                    <div id="labCartEmpty">
                        <i class="fas fa-flask" style="font-size:22px;margin-bottom:6px;display:block;"></i>
                        Sin análisis seleccionados
                    </div>
                </div>

                {{-- Tipo de pago (refleja el radio del formulario) --}}
                <div id="labCartPago">
                    <div class="pago-label">Tipo de Pago</div>
                    <div class="lab-pago-btns">
                        @foreach($tipoPagoAcuenta as $i => $tipo_pago)
                        @php
                            // old('tipo_pago_acuenta')? (strcmp(old('tipo_pago_acuenta'), $tipo_pago) == 0? 'active' : '') :  $i == 0 ? 'active' : ''
                            $activeCss = '';
                            if(old('tipo_pago_acuenta')){
                                if(strcmp(old('tipo_pago_acuenta'), $tipo_pago) == 0){
                                    $activeCss = 'active';
                                }
                            } else {
                                if($i == 0){
                                    $activeCss = 'active';
                                }
                            }
                        @endphp
                        <button type="button"
                            {{-- class="lab-pago-btn {{ $i == 0 ? 'active' : '' }}" --}}
                            class="lab-pago-btn {{ $activeCss }}"
                            data-pago="{{ $tipo_pago }}"
                            onclick="labCartSetPago('{{ $tipo_pago }}', this);">
                            {{ $tipo_pago }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Footer --}}
                <div id="labCartFooter">
                    <div class="lab-cart-subtotal">
                        <span id="labCartConPrecioLabel">Análisis con precio (0)</span>
                        <span id="labCartConPrecioVal">—</span>
                    </div>
                    <div class="lab-cart-subtotal">
                        <span id="labCartSinPrecioLabel">Sin precio asignado (0)</span>
                        <span>—</span>
                    </div>
                    <div class="lab-cart-total-row">
                        <span class="lab-cart-total-label">Total</span>
                        <span>
                            <span id="labCartTotalAmount">--</span>
                            <span id="labCartTotalCurrency">Bs.</span>
                        </span>
                    </div>

                    <button type="button" id="labCartSaveBtn" onclick="$('#formAnalisis').submit();">
                        <i class="fas fa-save"></i> Guardar Análisis
                    </button>
                    <button type="button" id="labCartClearBtn" onclick="labCartClearAll();">
                        <i class="fas fa-trash-alt"></i> Limpiar todo
                    </button>
                </div>
            </div>
            {{-- FIN CARRITO --}}

{{--            <div class="fixed-bottom">Pp...</div>--}}
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-bold text-danger m-0 p-0">Por favor, corrige los siguientes errores:</p>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" action="/analisis" id="formAnalisis" style="padding-right: 330px;">
                {{-- msgPriceTotal oculto — se mantiene para compatibilidad con updateTotalPriceTest() --}}
                <span id="msgPriceTotal" style="display:none;"></span>
                {{ csrf_field() }}
                <input type="hidden" name="person_id" value="{{$persona->id}}">
                <input type="hidden" name="tipo_analisis" value="{{\App\Analisis::PRUEBA}}">
                <input type="hidden" name="codigo" value="--">
                <input type="hidden" name="region" value="--">

                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="edad">Edad <small>(años)</small> 
                                <span class="edadinfo-popover text-info p-1" 
                                    title="Convertir a meses"
                                    style="cursor: help" onclick="openMonthModal();"
                                >
                                    <i class="fas fa-info-circle"></i>
                                </span>
                            </label>
                            <input type="number" name="edad"
                                   class="form-control @error('edad') is-invalid @enderror"
                                   step="0.01"
                                   value="{{old('edad')? old('edad') : $edad}}">
                            @error('edad')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
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
                            <div class="form-group">
                                <label for="region">Region de analisis / Muestra</label>
                                <input type="text" name="region"
                                       class="form-control @error('region') is-invalid @enderror"
                                       onkeyup="uppercaseInput(this);"
                                       value="{{@old('region')}}">
                                @error('region')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    <div class="col-md-2">
                        <label for="telefono_referencia">Telefono Referencia</label>
                        <input type="text" name="telefono_referencia" class="form-control @error('telefono_referencia') is-invalid @enderror"
                               onfocus="hideSuggesstionBox();"
                               value="{{old('telefono_referencia')}}">
                        @error('telefono_referencia')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="fecha">Fecha de Ingreso</label>
                        <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                               value="{{old('fecha', date('Y-m-d'))}}"
                               onfocus="hideSuggesstionBox();"
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
                {{-- El botón Guardar está en el carrito lateral; este se mantiene oculto como fallback --}}
                <button type="submit" id="btnSubmit" class="btn btn-primary d-none">Crear</button>
            </form>
        </div>
    </div>

    <div class="modal fade" id="setMonthModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Transformacion Meses:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="mx-2 p-0"  style="list-style: none; font-size: 12px;">
                            <li><a href="#" onclick="setMonth('0.08');" >0.08: 1 mes</a></li>
                            <li><a href="#" onclick="setMonth('0.16');" >0.16: 2 meses</a></li>
                            <li><a href="#" onclick="setMonth('0.25');" >0.25: 3 meses</a></li>
                            <li><a href="#" onclick="setMonth('0.33');" >0.33: 4 meses</a></li>
                            <li><a href="#" onclick="setMonth('0.41');" >0.41: 5 meses</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="mx-2 p-0"  style="list-style: none; font-size: 12px;;">
                            <li><a href="#" onclick="setMonth('0.50');" >0.50: 6 meses</a></li>
                            <li><a href="#" onclick="setMonth('0.58');" >0.58: 7 meses</a></li>
                            <li><a href="#" onclick="setMonth('0.67');" >0.67: 8 meses</a></li>
                            <li><a href="#" onclick="setMonth('0.75');" >0.75: 9 meses</a></li>
                            <li><a href="#" onclick="setMonth('0.83');" >0.83: 10 meses</a></li>
                            <li><a href="#" onclick="setMonth('0.91');" >0.91: 11 meses</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                url: "{{ route('analysis-test-group.render.tree.selected.v2') }}",
                data: {
                    'analisisTestGroupIds': {!! json_encode(old('aGroup', [])) !!}, 
                    'analisisTestIds': {!! json_encode(old('aTests', [])) !!}
                },
                success: function (data) {
                    $("#list_group").empty().append(data);
                    loadSelect2Atest();
                    reloadaTest({!! json_encode(old('aTests', [])) !!});
                    updateTotalPriceTest();
                    setTimeout(function(){ if(typeof labCartRefresh === "function") labCartRefresh(); }, 350);
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

        function syncCheckboxes(input){
            const aTestId = $(input).val();
            if($(input).is(':checked')){
                var aTestSelect = $('.js-data-atest-ajax')
                $.ajax({
                    type: "POST",
                    url: '{{ url('/analisis-test/a-search-set-id') }}/' + aTestId
                }).then(function (data) {
                    length = 0;
                    var selectItems = aTestSelect.select2('data');
                    selectItems.forEach(function(item) {
                        console.log("ID del Ítem:", item.id, "Texto del Ítem:", item.text);
                        if(item.id == data.id){
                            length++;

                        }
                    });
                    if (length) {
                        console.log("PDM - Entro 2.1 ....", length);
                        console.log("PDM - Entro 2.2 ....", data);
                    } else { 
                        var option = new Option(data.text, data.id, true, true);
                        aTestSelect.append(option).trigger('change');
                        console.log("Pdm aaa: ", aTestSelect.select2('data'));
                        aTestSelect.trigger({
                            type: 'select2:select',
                            params: {
                                data: aTestSelect.select2('data')
                            }
                        });
                    }
                    
                });
                // alert(aTestId + " " + aTestDescription);
                updateTotalPriceTest();
            } else {
                var aTestSelect = $('.js-data-atest-ajax')
                var length = 0;
                // var selectItems = aTestSelect.select2('data');
                // selectItems.forEach(function(item) {
                //     console.log("ID del Ítem:", item.id, "Texto del Ítem:", item.text);
                //     if(item.id == aTestId){
                //         length++;
                //     }
                // });
                if (length) {
                    console.log("PDM - Entro 1.1 ....", length);
                    console.log("PDM - Entro 1.2 ....", aTestId);
                    aTestSelect.find("option[value='" + aTestId + "']").remove();
                    aTestSelect.trigger({
                        type: 'select2:unselect',
                        params: {
                            data: aTestSelect.select2('data')
                        }
                    });
                }
                updateTotalPriceTest();
            }
            
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
            // Sincronizar el carrito visual
            labCartRefresh();
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


        function loadSelect2Atest(){
            $('.js-data-atest-ajax').select2({
                ajax: {
                    url: '{{ route('analisis.test.asearch') }}',
                    type: "post",
                    dataType: 'json',
                    data: function (params) {
                        return {
                            search: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                }
            });

            $('.js-data-atest-ajax').on('select2:select', function (e) {
                // 1. Obtener los datos del ítem recién seleccionado (útil para la UX)
                var newItemData = e.params.data;
                
                setChecktedAtest(newItemData.id, true);
            });
            $('.js-data-atest-ajax').on('select2:unselect', function (e) {
                // 1. Obtener los datos del ítem recién seleccionado (útil para la UX)
                var newItemData = e.params.data;
                $(this).find("option[value='" + newItemData.id + "']").remove();
                setChecktedAtest(newItemData.id, false);
            });
        }

        function setChecktedAtest(atestId, checked){
            // Buscar el checkbox correspondiente al análisis seleccionado
            var checkbox = $("#accordionTestGroup input.test-price[value='" + atestId + "']");
            if(checkbox.length > 0){
                if(checked === false){
                    $(checkbox).prop('checked', false);
                    updateTotalPriceTest();
                    return;
                }
                if(!$(checkbox).is(':checked')){
                    $(checkbox).prop('checked', true);
                    updateTotalPriceTest();
                }
            }
        }

        function reloadaTest(ids){
            console.log("PDM - Entro reloadaTest ....", ids);
            if(ids.length > 0){
                $.ajax({
                    type: "POST",
                    url: '{{ route('analisis.test.asearch.setids') }}',
                    data: {ids: ids}
                }).then(function (data) {
                    var aTestSelect = $('.js-data-atest-ajax');
                    console.log("PDM 2- Entro reloadaTest ....", data);
                    data.forEach(function(item){
                        var option = new Option(item.text, item.id, true, true);
                        aTestSelect.append(option).trigger('change');
                    }); 
                    aTestSelect.trigger({
                        type: 'select2:select',
                        params: {
                            data: aTestSelect.select2('data')
                        }
                    });        
                });
            }
            
        }

        function openMonthModal(){
            $('#setMonthModal').modal('show');
        }
        
        function setMonth(month){
            $("#formAnalisis input[name='edad']").val(month);
            $('#setMonthModal').modal('hide');
        }
    </script>

    <script>
    /* ================================================================
       LAB-PDM — Carrito lateral de análisis v2
       Depende de: Bootstrap 4.6, jQuery, Font Awesome
       ================================================================ */
    (function () {

        /* -------------------------------------------------------
           labCartRefresh()
           Lee todos los checkboxes marcados en #list_group
           y reconstruye el carrito visual completo.
           ------------------------------------------------------- */
        window.labCartRefresh = function () {
            var $items   = $('#labCartItems');
            var $empty   = $('#labCartEmpty');
            var entries  = [];   // {id, name, price, groupName}
            var total    = 0;
            var conPrecio = 0;
            var sinPrecio = 0;

            /* Recorrer TODOS los test-price checkboxes marcados  */
            $('#list_group .test-price[name="aTests[]"]:checked').each(function () {
                var $cb    = $(this);
                var price  = parseFloat($cb.data('price')) || 0;
                var $card  = $cb.closest('.lab-test-card');
                var name   = $card.find('.lab-test-name-text').text().trim()
                             || $cb.closest('label').find('.lab-test-name-text').text().trim()
                             || 'Análisis #' + $cb.val();

                /* Grupo padre: buscar el .lab-group-name más cercano */
                var groupName = '';
                var $groupBlock = $cb.closest('.lab-group-block');
                if ($groupBlock.length) {
                    groupName = $groupBlock.find('.lab-group-name').first().text().trim();
                } else {
                    /* Puede estar en un sub-grupo */
                    var $subBlock = $cb.closest('.lab-subgroup-block');
                    if ($subBlock.length) {
                        groupName = $subBlock.find('.lab-subgroup-name').first().text().trim();
                    }
                }

                entries.push({
                    id:        $cb.val(),
                    name:      name,
                    price:     price,
                    groupName: groupName
                });

                if (price > 0) {
                    total += price;
                    conPrecio++;
                } else {
                    sinPrecio++;
                }
            });

            /* También incluir grupos completos seleccionados (aGroup[]) */
            $('#list_group .test-price[name="aGroup[]"]:checked').each(function () {
                var $cb    = $(this);
                var price  = parseFloat($cb.data('price')) || 0;
                /* El nombre del grupo ya está en el header */
                var $header = $cb.closest('.lab-group-header, .lab-subgroup-header');
                var name = $header.find('.lab-group-name, .lab-subgroup-name').first().text().trim()
                           || 'Grupo #' + $cb.val();
                var groupName = 'Paquete';

                entries.push({
                    id:        'g_' + $cb.val(),
                    name:      name,
                    price:     price,
                    groupName: groupName
                });

                if (price > 0) {
                    total += price;
                    conPrecio++;
                } else {
                    sinPrecio++;
                }
            });

            /* ---- Render items ---- */
            $items.find('.lab-cart-item').remove();

            if (entries.length === 0) {
                $empty.show();
            } else {
                $empty.hide();
                entries.forEach(function (e) {
                    var priceHtml = e.price > 0
                        ? '<span class="lab-cart-item-price">' + e.price + ' Bs.</span>'
                        : '<span class="lab-cart-item-price sin-precio">—</span>';

                    var $row = $(
                        '<div class="lab-cart-item" data-id="' + e.id + '">' +
                            '<div class="lab-cart-item-info">' +
                                '<div class="lab-cart-item-name" title="' + e.name + '">' + e.name + '</div>' +
                                '<div class="lab-cart-item-group">' + e.groupName + '</div>' +
                            '</div>' +
                            priceHtml +
                            '<button type="button" class="lab-cart-remove" title="Quitar">' +
                                '<i class="fas fa-times"></i>' +
                            '</button>' +
                        '</div>'
                    );

                    /* Botón quitar */
                    $row.find('.lab-cart-remove').on('click', function () {
                        labCartRemoveItem(e.id);
                    });

                    $items.append($row);
                });
            }

            /* ---- Footer totales ---- */
            var totalFmt = total > 0 ? total : '--';
            $('#labCartTotalAmount').text(totalFmt);
            $('#labCartConPrecioLabel').text('Análisis con precio (' + conPrecio + ')');
            $('#labCartConPrecioVal').text(conPrecio > 0 ? total + ' Bs.' : '—');
            $('#labCartSinPrecioLabel').text('Sin precio asignado (' + sinPrecio + ')');

            /* ---- Badge conteo ---- */
            var totalItems = entries.length;
            $('#labCartCountBadge').text(totalItems + (totalItems === 1 ? ' análisis' : ' análisis'));

            /* ---- Botón guardar ---- */
            $('#labCartSaveBtn').prop('disabled', totalItems === 0);
        };

        /* -------------------------------------------------------
           labCartRemoveItem(id)
           Desmarca el checkbox correspondiente y refresca.
           ------------------------------------------------------- */
        window.labCartRemoveItem = function (id) {
            var selector;
            if (String(id).indexOf('g_') === 0) {
                /* Es un grupo */
                var groupId = id.replace('g_', '');
                selector = '#list_group input.test-price[name="aGroup[]"][value="' + groupId + '"]';
            } else {
                selector = '#list_group input.test-price[name="aTests[]"][value="' + id + '"]';
            }

            var $cb = $(selector);
            if ($cb.length && $cb.is(':checked')) {
                /* Desmarcar y disparar el mismo flujo que al hacer clic manual */
                $cb.prop('checked', false);

                /* Si es un test individual, llamar syncCheckboxes para limpiar Select2 */
                if (String(id).indexOf('g_') !== 0) {
                    syncCheckboxes($cb[0]);
                } else {
                    reloadGroupChilds($cb[0]);
                }

                /* Actualizar clase visual de la tarjeta */
                $cb.closest('.lab-test-card').removeClass('checked');
                updateTotalPriceTest();
            }
        };

        /* -------------------------------------------------------
           labCartClearAll()
           Desmarca todo y limpia el carrito.
           ------------------------------------------------------- */
        window.labCartClearAll = function () {
            /* Desmarcar grupos */
            $('#list_group input.test-price[name="aGroup[]"]:checked').each(function () {
                $(this).prop('checked', false);
                reloadGroupChilds(this);
            });
            /* Desmarcar tests */
            $('#list_group input.test-price[name="aTests[]"]:checked').each(function () {
                $(this).prop('checked', false);
                syncCheckboxes(this);
                $(this).closest('.lab-test-card').removeClass('checked');
            });
            updateTotalPriceTest();
            labCartRefresh();
        };

        /* -------------------------------------------------------
           labCartSetPago(tipo, btn)
           Sincroniza el radio de tipo_pago_acuenta del formulario.
           ------------------------------------------------------- */
        window.labCartSetPago = function (tipo, btn) {
            /* Activar botón visual */
            $('.lab-pago-btn').removeClass('active');
            $(btn).addClass('active');
            /* Marcar el radio correspondiente en el formulario */
            $('#formAnalisis input[name="tipo_pago_acuenta"]').each(function () {
                if ($(this).val() === tipo) {
                    $(this).prop('checked', true).trigger('change');
                }
            });
        };

        /* -------------------------------------------------------
           Sincronizar botones de pago del carrito cuando cambia
           el radio del formulario (por si el usuario lo usa directo)
           ------------------------------------------------------- */
        $(document).on('change', '#formAnalisis input[name="tipo_pago_acuenta"]', function () {
            var val = $(this).val();
            $('.lab-pago-btn').each(function () {
                if ($(this).data('pago') === val) {
                    $(this).addClass('active');
                } else {
                    $(this).removeClass('active');
                }
            });
        });

        /* -------------------------------------------------------
           Deshabilitar el botón guardar al hacer submit
           ------------------------------------------------------- */
        $('#formAnalisis').on('submit', function () {
            $('#labCartSaveBtn').prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
            $('#btnSubmit').prop('disabled', true);
        });

        /* -----    --------------------------------------------------
           Init — estado inicial del carrito
           ------------------------------------------------------- */
        $(function () {
            labCartRefresh();
        });

    })();
    </script>
@endpush
