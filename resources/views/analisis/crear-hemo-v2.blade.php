@php
/** @var [] $tipoPagoAcuenta */
@endphp
@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Administrar Clientes', 'navName' => 'Crear Analisis', 'activeButton' => 'clientActiveButton'])

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
    /* ================================================================
       LAYOUT PRINCIPAL — corrección padding layout padre en móvil
       ================================================================ */
    @media (max-width: 767px) {
        .main-panel > .content { padding: 10px 6px !important; }
    }

    /* ================================================================
       CARRITO LATERAL — visible solo en desktop ≥ 993px
       ================================================================ */
    #labCart {
        position: fixed;
        top: 80px;
        right: 18px;
        width: 300px;
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

    /* Ocultar carrito fijo en móvil/tablet */
    @media (max-width: 992px) {
        #labCart { display: none !important; }
    }

    /* Header carrito */
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
    .lab-cart-item-group { font-size: 11px; color: #64748b; margin-top: 1px; }
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
    #labCartEmpty {
        text-align: center;
        padding: 20px 10px;
        color: #94a3b8;
        font-size: 13px;
        display: none;
    }
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
    .lab-cart-total-label { font-size: 15px; font-weight: 700; color: #1e293b; }
    #labCartTotalAmount  { font-size: 22px; font-weight: 800; color: #1d4ed8; }
    #labCartTotalCurrency { font-size: 14px; font-weight: 600; color: #1d4ed8; margin-left: 3px; }
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
    #labCartSaveBtn:hover  { opacity: .92; transform: translateY(-1px); }
    #labCartSaveBtn:active { transform: translateY(0); }
    #labCartSaveBtn:disabled { opacity: .5; cursor: not-allowed; transform: none; }
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

    /* ================================================================
       BARRA INFERIOR MÓVIL — reemplaza el carrito lateral en móvil
       ================================================================ */
    #labCartMobile {
        display: none; /* oculto en desktop */
    }

    @media (max-width: 992px) {
        #labCartMobile {
            display: block;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 4000;
            background: #fff;
            border-top: 2px solid #dbeafe;
            box-shadow: 0 -4px 20px rgba(37,99,235,.12);
        }

        /* Barra compacta siempre visible */
        .mobile-cart-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
            cursor: pointer;
            gap: 10px;
        }

        .mobile-cart-bar-left {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
            min-width: 0;
        }

        .mobile-cart-bar-icon {
            color: #fff;
            font-size: 16px;
            flex-shrink: 0;
        }

        .mobile-cart-bar-info {
            min-width: 0;
        }

        .mobile-cart-bar-label {
            font-size: 11px;
            color: rgba(255,255,255,.75);
            line-height: 1;
        }

        .mobile-cart-bar-count {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
        }

        .mobile-cart-bar-total {
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            white-space: nowrap;
        }

        .mobile-cart-bar-chevron {
            color: rgba(255,255,255,.75);
            font-size: 14px;
            transition: transform .25s;
            flex-shrink: 0;
        }

        .mobile-cart-bar-chevron.open {
            transform: rotate(180deg);
        }

        /* Panel expandido del carrito móvil */
        #labCartMobilePanel {
            display: none;
            max-height: 65vh;
            overflow-y: auto;
            background: #fff;
        }

        /* Items del carrito móvil */
        .mobile-cart-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-bottom: 1px solid #f1f5f9;
        }
        .mobile-cart-item-info { flex: 1; min-width: 0; }
        .mobile-cart-item-name {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .mobile-cart-item-group { font-size: 11px; color: #64748b; }
        .mobile-cart-item-price {
            font-size: 13px;
            font-weight: 700;
            color: #0369a1;
            white-space: nowrap;
        }
        .mobile-cart-item-price.sin-precio { color: #94a3b8; }
        .mobile-cart-remove-btn {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 14px;
            padding: 4px 6px;
            cursor: pointer;
            flex-shrink: 0;
        }
        .mobile-cart-remove-btn:hover { color: #ef4444; }

        /* Empty state móvil */
        #labCartMobileEmpty {
            text-align: center;
            padding: 20px;
            color: #94a3b8;
            font-size: 13px;
        }

        /* Footer del carrito móvil */
        .mobile-cart-footer {
            padding: 12px 16px;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .mobile-cart-footer-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .mobile-cart-save-btn {
            display: block;
            width: 100%;
            padding: 13px;
            margin-top: 10px;
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }
        .mobile-cart-save-btn:disabled { opacity: .5; }

        .mobile-cart-clear-btn {
            display: block;
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            background: none;
            color: #94a3b8;
            border: none;
            font-size: 12px;
            cursor: pointer;
        }
        .mobile-cart-clear-btn:hover { color: #ef4444; }

        /* Espaciado inferior al formulario para que no quede tapado por la barra */
        #formAnalisis {
            padding-bottom: 80px !important;
        }
    }

    /* ================================================================
       FORMULARIO — quitar padding-right fijo en móvil
       ================================================================ */
    @media (max-width: 992px) {
        #formAnalisis {
            padding-right: 0 !important;
        }
    }

    /* ================================================================
       CABECERA DE PACIENTE — stack en móvil
       ================================================================ */
    @media (max-width: 767px) {
        .patient-header-row .col-md-4 {
            margin-bottom: 4px;
        }
        .patient-header-row dt { font-size: 0.78rem; color: #6c757d; margin-bottom: 0; }
        .patient-header-row dd { font-size: 0.9rem; font-weight: 600; margin-bottom: 0; }
    }

    /* ================================================================
       CAMPOS DEL FORMULARIO — ajustes móvil
       ================================================================ */
    @media (max-width: 767px) {
        /* Reducir card padding */
        .card-body { padding: 12px 10px !important; }
        .card-header { padding: 10px 12px !important; }

        /* Campos: columna completa por defecto (Bootstrap ya lo hace con col-md-*)
           pero asegurar que los labels no se corten */
        .form-group label {
            font-size: 0.82rem;
            margin-bottom: 3px;
        }

        .form-control {
            font-size: 0.9rem;
        }

        /* Datos de facturación: fondo coloreado se adapta */
        .col-md-3[style*="background-color"],
        .col-md-6[style*="background-color"] {
            border-radius: 6px;
            padding: 8px 10px;
            margin-bottom: 8px;
        }

        /* Radios de tipo pago: wrap en varias líneas si es necesario */
        .form-check-inline {
            margin-right: 8px;
            margin-bottom: 4px;
        }

        /* Sección "datos para facturación" label centrado */
        .facturacion-label {
            text-align: left !important;
        }
    }

    /* ================================================================
       BREADCRUMB
       ================================================================ */
    .breadcrumb {
        padding: 6px 0;
        background: transparent;
        margin-bottom: 8px;
        font-size: 0.82rem;
        flex-wrap: wrap;
    }
    </style>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item">Crear Analisis</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            {{-- Datos del paciente --}}
            <div class="row patient-header-row">
                <div class="col-md-4 col-6">
                    <dl class="mb-0">
                        <dt>Nombres y Apellidos:</dt>
                        <dd>{{ $persona->full_name }}</dd>
                    </dl>
                </div>
                <div class="col-md-4 col-6">
                    <dl class="mb-0">
                        <dt>Fecha nacimiento:</dt>
                        <dd>{{($persona->f_nacimiento) ? $persona->f_nacimiento : '--'}}</dd>
                    </dl>
                </div>
                <div class="col-md-4 col-12">
                    <dl class="mb-0">
                        <dt>Sexo:</dt>
                        <dd>{{$persona->sexo}}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="card-body">

            {{-- =====================================================
                 CARRITO LATERAL FIJO — solo desktop ≥ 993px
                 ===================================================== --}}
            <div id="labCart">
                <div id="labCartHeader">
                    <span class="cart-title">
                        <i class="fas fa-clipboard-list"></i>
                        Resumen del Pedido
                    </span>
                    <span id="labCartCountBadge">0 análisis</span>
                </div>
                <div id="labCartItems">
                    <div id="labCartEmpty">
                        <i class="fas fa-flask" style="font-size:22px;margin-bottom:6px;display:block;"></i>
                        Sin análisis seleccionados
                    </div>
                </div>
                <div id="labCartPago">
                    <div class="pago-label">Tipo de Pago</div>
                    <div class="lab-pago-btns">
                        @foreach($tipoPagoAcuenta as $i => $tipo_pago)
                        @php
                            $activeCss = '';
                            if(old('tipo_pago_acuenta')){
                                if(strcmp(old('tipo_pago_acuenta'), $tipo_pago) == 0) $activeCss = 'active';
                            } else {
                                if($i == 0) $activeCss = 'active';
                            }
                        @endphp
                        <button type="button"
                                class="lab-pago-btn {{ $activeCss }}"
                                data-pago="{{ $tipo_pago }}"
                                onclick="labCartSetPago('{{ $tipo_pago }}', this);">
                            {{ $tipo_pago }}
                        </button>
                        @endforeach
                    </div>
                </div>
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

            {{-- =====================================================
                 BARRA INFERIOR MÓVIL — solo ≤ 992px
                 ===================================================== --}}
            <div id="labCartMobile">
                {{-- Barra siempre visible --}}
                <div class="mobile-cart-bar" onclick="toggleMobileCart();">
                    <div class="mobile-cart-bar-left">
                        <i class="fas fa-clipboard-list mobile-cart-bar-icon"></i>
                        <div class="mobile-cart-bar-info">
                            <div class="mobile-cart-bar-label">Resumen del pedido</div>
                            <div class="mobile-cart-bar-count" id="mobileCartCount">0 análisis</div>
                        </div>
                    </div>
                    <div class="mobile-cart-bar-total" id="mobileCartTotal">-- Bs.</div>
                    <i class="fas fa-chevron-up mobile-cart-bar-chevron" id="mobileCartChevron"></i>
                </div>

                {{-- Panel expandible --}}
                <div id="labCartMobilePanel">
                    <div id="labCartMobileEmpty">
                        <i class="fas fa-flask" style="font-size:20px;display:block;margin-bottom:6px;"></i>
                        Sin análisis seleccionados
                    </div>
                    <div id="labCartMobileItems"></div>
                    <div class="mobile-cart-footer">
                        <div class="mobile-cart-footer-row">
                            <span id="mobileCartConPrecioLabel">Análisis con precio (0)</span>
                            <span id="mobileCartConPrecioVal">—</span>
                        </div>
                        <div class="mobile-cart-footer-row">
                            <span id="mobileCartSinPrecioLabel">Sin precio asignado (0)</span>
                            <span>—</span>
                        </div>
                        <button type="button" class="mobile-cart-save-btn" id="mobileCartSaveBtn"
                                onclick="$('#formAnalisis').submit();" disabled>
                            <i class="fas fa-save"></i> Guardar Análisis
                        </button>
                        <button type="button" class="mobile-cart-clear-btn"
                                onclick="labCartClearAll();">
                            <i class="fas fa-trash-alt"></i> Limpiar todo
                        </button>
                    </div>
                </div>
            </div>

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

            {{-- =====================================================
                 FORMULARIO
                 padding-right: 330px solo en desktop (se cancela en móvil vía CSS)
                 ===================================================== --}}
            <form method="post" action="/analisis" id="formAnalisis" style="padding-right: 320px;">
                <span id="msgPriceTotal" style="display:none;"></span>
                {{ csrf_field() }}
                <input type="hidden" name="person_id"    value="{{$persona->id}}">
                <input type="hidden" name="tipo_analisis" value="{{\App\Analisis::PRUEBA}}">
                <input type="hidden" name="codigo"       value="--">
                <input type="hidden" name="region"       value="--">

                {{-- Fila 1: Edad / Doctor / Región / Teléfono / Fecha --}}
                <div class="row">
                    <div class="col-6 col-md-1">
                        <div class="form-group">
                            <label for="edad">Edad <small>(años)</small>
                                <span class="edadinfo-popover text-info p-1"
                                      title="Convertir a meses"
                                      style="cursor:help"
                                      onclick="openMonthModal();">
                                    <i class="fas fa-info-circle"></i>
                                </span>
                            </label>
                            <input type="number" name="edad"
                                   class="form-control @error('edad') is-invalid @enderror"
                                   step="0.01"
                                   value="{{old('edad') ? old('edad') : $edad}}">
                            @error('edad')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label>Doctor que envia</label>
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
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Region de analisis / Muestra</label>
                            <input type="text" name="region"
                                   class="form-control @error('region') is-invalid @enderror"
                                   onkeyup="uppercaseInput(this);"
                                   value="{{@old('region')}}">
                            @error('region')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6 col-md-2">
                        <div class="form-group">
                            <label>Telefono Referencia</label>
                            <input type="text" name="telefono_referencia"
                                   class="form-control @error('telefono_referencia') is-invalid @enderror"
                                   onfocus="hideSuggesstionBox();"
                                   value="{{old('telefono_referencia')}}">
                            @error('telefono_referencia')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6 col-md-2">
                        <div class="form-group">
                            <label>Fecha de Ingreso</label>
                            <input type="date" name="fecha"
                                   class="form-control @error('fecha') is-invalid @enderror"
                                   value="{{old('fecha', date('Y-m-d'))}}"
                                   onfocus="hideSuggesstionBox();">
                            @error('fecha')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Fila 2: Label datos facturación --}}
                <div class="row">
                    <div class="col-12 col-md-6"></div>
                    <div class="col-12 col-md-6">
                        <h6 class="facturacion-label">Datos Para Facturacion</h6>
                    </div>
                </div>

                {{-- Fila 3: Procedencia / Doctor / Razón Social / NIT --}}
                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Procedencia</label>
                            <select id="s_procedencia" name="procedencia"
                                    onchange="fntBanca(this);"
                                    class="form-control @error('procedencia') is-invalid @enderror">
                                @if(old('procedencia'))
                                    @foreach($procedencias as $procedencia)
                                        <option value="{{$procedencia->id}}"
                                            @if(old('procedencia') == $procedencia->id) selected @endif>
                                            {{$procedencia->nombre}}
                                        </option>
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
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Asignar Doctor</label>
                            <select name="doctor_asignado"
                                    class="form-control @error('fecha_entrega') is-invalid @enderror">
                                <option value="">Elija un doctor</option>
                                @if(old('doctor_asignado'))
                                    @foreach($doctores as $doctor)
                                        <option value="{{$doctor->id}}"
                                            @if(old('doctor_asignado') == $doctor->id) selected @endif>
                                            {{$doctor->nombres}} {{$doctor->apellidos}}
                                        </option>
                                    @endforeach
                                @else
                                    @foreach($doctores as $doctor)
                                        <option value="{{$doctor->id}}"
                                            @if($doctor->id == 5) selected @endif>
                                            {{$doctor->nombres}} {{$doctor->apellidos}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3" style="background-color: #E8F1FF; border-radius: 6px;">
                        <div class="form-group">
                            <label>Razon Social</label>
                            <input type="text" name="razon_social"
                                   class="form-control @error('razon_social') is-invalid @enderror"
                                   value="{{@old('razon_social')}}">
                            @error('razon_social')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-3" style="background-color: #E8F1FF; border-radius: 6px;">
                        <div class="form-group">
                            <label>NIT</label>
                            <input type="text" name="nit"
                                   class="form-control @error('nit') is-invalid @enderror"
                                   value="{{@old('nit')}}">
                            @error('nit')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Fila 4: Código interno / Precio / Acuenta / Tipo pago --}}
                <div class="row">
                    <div class="col-6 col-md-2">
                        <div class="form-group">
                            <label>Código interno</label>
                            <input class="form-control @error('internal_code') is-invalid @enderror"
                                   value="{{@old('internal_code')}}" name="internal_code">
                            @error('internal_code')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6 col-md-2">
                        <div class="form-group">
                            <input type="hidden" name="precio" value="{{@old('precio')}}">
                            <label>Precio</label>
                            <div class="form-control @error('precio') is-invalid @enderror text-right bg-light">
                                {{@old('precio')}}
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-2">
                        <div class="form-group">
                            <label>Acuenta</label>
                            <input type="number" name="acuenta"
                                   class="form-control @error('acuenta') is-invalid @enderror"
                                   value="{{@old('acuenta')}}"
                                   min="0" max="10000">
                            @error('acuenta')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>Tipo de pago Acuenta</label><br>
                            @foreach($tipoPagoAcuenta as $i => $tipo_pago)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"
                                           name="tipo_pago_acuenta"
                                           onchange="changeTipoPago(this);"
                                           id="tipo_pago_acuenta_{{$i}}"
                                           value="{{$tipo_pago}}"
                                           @if(old('tipo_pago_acuenta') && strcmp(old('tipo_pago_acuenta'), $tipo_pago) == 0) checked
                                           @elseif(!old('tipo_pago_acuenta') && $i==0) checked @endif>
                                    <label class="form-check-label"
                                           style="padding-left: 2px !important;"
                                           for="tipo_pago_acuenta_{{$i}}">{{$tipo_pago}}</label>
                                </div>
                            @endforeach
                            @error('tipo_pago_acuenta')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <div class="row acuenta-tarjeta @if(!old('tipo_pago_acuenta')) fade @elseif(old('tipo_pago_acuenta') && strcmp(old('tipo_pago_acuenta'), 'EFECTIVO') == 0) fade @endif">
                                <div class="col-12 col-md-6">
                                    <label>Numero de cuenta</label>
                                    <input type="text" name="acuenta_numero_tarjeta"
                                           id="acuenta_numero_tarjeta"
                                           class="form-control @error('acuenta_numero_tarjeta') is-invalid @enderror"
                                           value="{{@old('acuenta_numero_tarjeta')}}">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Banco</label>
                                    <input type="text" name="acuenta_banco"
                                           id="acuenta_banco"
                                           class="form-control @error('acuenta_banco') is-invalid @enderror"
                                           value="{{@old('acuenta_banco')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                @error('aTests')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <div id="list_group"></div>

                <a href="{{ url()->previous() }}" class="btn btn-secondary">Atras</a>
                <button type="submit" id="btnSubmit" class="btn btn-primary d-none">Crear</button>
            </form>
        </div>
    </div>

    {{-- Modal meses --}}
    <div class="modal fade" id="setMonthModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transformacion Meses:</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="mx-2 p-0" style="list-style:none;font-size:12px;">
                                <li><a href="#" onclick="setMonth('0.08');">0.08: 1 mes</a></li>
                                <li><a href="#" onclick="setMonth('0.16');">0.16: 2 meses</a></li>
                                <li><a href="#" onclick="setMonth('0.25');">0.25: 3 meses</a></li>
                                <li><a href="#" onclick="setMonth('0.33');">0.33: 4 meses</a></li>
                                <li><a href="#" onclick="setMonth('0.41');">0.41: 5 meses</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="mx-2 p-0" style="list-style:none;font-size:12px;">
                                <li><a href="#" onclick="setMonth('0.50');">0.50: 6 meses</a></li>
                                <li><a href="#" onclick="setMonth('0.58');">0.58: 7 meses</a></li>
                                <li><a href="#" onclick="setMonth('0.67');">0.67: 8 meses</a></li>
                                <li><a href="#" onclick="setMonth('0.75');">0.75: 9 meses</a></li>
                                <li><a href="#" onclick="setMonth('0.83');">0.83: 10 meses</a></li>
                                <li><a href="#" onclick="setMonth('0.91');">0.91: 11 meses</a></li>
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
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
            getCodigo();

            $("#formAnalisis").submit(function () {
                $("#btnSubmit").attr("disabled", true);
            });

            loadTreeTestGroup();

            var timeout = null;
            $("#search-envia").keyup(function () {
                if ($(this).val().length > 2) {
                    var inputSearch = this;
                    if (timeout) clearTimeout(timeout);
                    timeout = setTimeout(function () {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('analisis.doctor.envia') }}",
                            data: 'keyword=' + $(inputSearch).val(),
                            dataType: 'html',
                            success: function (data) {
                                $("#suggesstion-box").show().html(data);
                            }
                        });
                    }, 1000);
                } else {
                    hideSuggesstionBox();
                }
            });
        });

        function changeTipoPago(radio) {
            $("#formAnalisis input[name='acuenta_numero_tarjeta']").val('');
            $("#formAnalisis input[name='acuenta_banco']").val('');
            if ($(radio).val() === "TRANSFERENCIA") {
                $(".acuenta-tarjeta").removeClass("fade");
            } else {
                $(".acuenta-tarjeta").addClass("fade");
            }
        }

        function loadTreeTestGroup() {
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
                    setTimeout(function () {
                        if (typeof labCartRefresh === "function") labCartRefresh();
                    }, 350);
                }
            });
        }

        function selectEnvia(val) {
            $("#search-envia").val(val);
            $("#suggesstion-box").hide();
        }

        function hideSuggesstionBox() {
            $("#suggesstion-box").hide();
        }

        function renderLoading() {
            return '<div style="text-align:center;width:100%;padding:20px;"><div class="fa-3x"><i class="fas fa-cog fa-spin"></i></div></div>';
        }

        function syncCheckboxes(input) {
            const aTestId = $(input).val();
            if ($(input).is(':checked')) {
                var aTestSelect = $('.js-data-atest-ajax');

                $.ajax({
                    type: "POST",
                    url: '{{ url('/analisis-test/a-search-set-id') }}/' + aTestId
                }).then(function (data) {

                    // Verificar si select2 está inicializado antes de usarlo
                    var isSelect2Ready = (typeof aTestSelect.data('select2') !== 'undefined');

                    if (isSelect2Ready) {
                        // select2 listo: verificar duplicados antes de agregar
                        var length = 0;
                        aTestSelect.select2('data').forEach(function (item) {
                            if (item.id == data.id) length++;
                        });
                        if (!length) {
                            var option = new Option(data.text, data.id, true, true);
                            aTestSelect.append(option).trigger('change');
                            aTestSelect.trigger({
                                type: 'select2:select',
                                params: { data: aTestSelect.select2('data') }
                            });
                        }
                    } else {
                        // select2 no está listo aún (árbol cargando) — agregar opción directamente
                        // El carrito se actualiza igual vía updateTotalPriceTest()
                        var alreadyExists = aTestSelect.find("option[value='" + data.id + "']").length > 0;
                        if (!alreadyExists) {
                            var option = new Option(data.text, data.id, true, true);
                            aTestSelect.append(option);
                        }
                    }

                    updateTotalPriceTest();
                });
            } else {
                var aTestSelect = $('.js-data-atest-ajax');
                var isSelect2Ready = (typeof aTestSelect.data('select2') !== 'undefined');

                if (isSelect2Ready) {
                    // Deseleccionar en select2 si está inicializado
                    aTestSelect.find("option[value='" + $(input).val() + "']").remove();
                    aTestSelect.trigger('change');
                }

                updateTotalPriceTest();
            }
        }

        function updateTotalPriceTest() {
            let total = 0;
            $.each($("#list_group .test-price"), function (i, testPrice) {
                if ($(testPrice).is(':checked')) total += parseFloat($(testPrice).data('price'));
            });
            let inputPrecio = $("#formAnalisis input[name='precio']");
            if (total !== 0) {
                $("#msgPriceTotal").empty().append(total);
                $(inputPrecio).val(total);
                $(inputPrecio).next().next().empty().append(total);
            } else {
                $("#msgPriceTotal").empty().append('--');
                $(inputPrecio).val('');
                $(inputPrecio).next().next().empty().append('--');
            }
            labCartRefresh();
        }

        function reloadGroupChilds(input) {
            var parent  = $(input).parent().parent().parent().parent().parent();
            var cardBody = $(parent).find(".card-body");
            if ($(input).is(':checked')) {
                var checks = $(cardBody).find("input[type=checkbox]");
                $.each(checks, function (ind, check) {
                    if ($(check).is(':checked')) $(check).click();
                    $(check).attr('disabled', 'disabled');
                    $(check).parent().parent().addClass('disabled');
                });
            } else {
                var checks = $(cardBody).find("input[type=checkbox]");
                $.each(checks, function (ind, check) {
                    $(check).removeAttr('disabled');
                    $(check).parent().parent().removeClass('disabled');
                    if ($(check).is(':checked')) $(check).click();
                });
            }
            updateTotalPriceTest();
        }

        function loadSelect2Atest() {
            $('.js-data-atest-ajax').select2({
                ajax: {
                    url: '{{ route('analisis.test.asearch') }}',
                    type: "post",
                    dataType: 'json',
                    data: function (params) { return { search: params.term }; },
                    processResults: function (response) { return { results: response }; }
                }
            });
            $('.js-data-atest-ajax').on('select2:select', function (e) {
                setChecktedAtest(e.params.data.id, true);
            });
            $('.js-data-atest-ajax').on('select2:unselect', function (e) {
                $(this).find("option[value='" + e.params.data.id + "']").remove();
                setChecktedAtest(e.params.data.id, false);
            });
        }

        function setChecktedAtest(atestId, checked) {
            var checkbox = $("#accordionTestGroup input.test-price[value='" + atestId + "']");
            if (checkbox.length > 0) {
                if (checked === false) {
                    $(checkbox).prop('checked', false);
                    updateTotalPriceTest();
                    return;
                }
                if (!$(checkbox).is(':checked')) {
                    $(checkbox).prop('checked', true);
                    updateTotalPriceTest();
                }
            }
        }

        function reloadaTest(ids) {
            if (ids.length > 0) {
                $.ajax({
                    type: "POST",
                    url: '{{ route('analisis.test.asearch.setids') }}',
                    data: { ids: ids }
                }).then(function (data) {
                    var aTestSelect = $('.js-data-atest-ajax');
                    data.forEach(function (item) {
                        aTestSelect.append(new Option(item.text, item.id, true, true)).trigger('change');
                    });
                    aTestSelect.trigger({ type: 'select2:select', params: { data: aTestSelect.select2('data') } });
                });
            }
        }

        function openMonthModal() { $('#setMonthModal').modal('show'); }
        function setMonth(month) {
            $("#formAnalisis input[name='edad']").val(month);
            $('#setMonthModal').modal('hide');
        }

        /* ================================================================
           Toggle carrito móvil
           ================================================================ */
        function toggleMobileCart() {
            var $panel   = $('#labCartMobilePanel');
            var $chevron = $('#mobileCartChevron');
            if ($panel.is(':visible')) {
                $panel.slideUp(200);
                $chevron.removeClass('open');
            } else {
                $panel.slideDown(200);
                $chevron.addClass('open');
            }
        }
    </script>

    <script>
    /* ================================================================
       LAB-PDM — Carrito lateral v2 + sincronización carrito móvil
       ================================================================ */
    (function () {

        window.labCartRefresh = function () {
            var entries   = [];
            var total     = 0;
            var conPrecio = 0;
            var sinPrecio = 0;

            /* Tests individuales */
            $('#list_group .test-price[name="aTests[]"]:checked').each(function () {
                var $cb    = $(this);
                var price  = parseFloat($cb.data('price')) || 0;
                var $card  = $cb.closest('.lab-test-card');
                var name   = $card.find('.lab-test-name-text').text().trim()
                             || $cb.closest('label').find('.lab-test-name-text').text().trim()
                             || 'Análisis #' + $cb.val();
                var groupName = '';
                var $groupBlock = $cb.closest('.lab-group-block');
                if ($groupBlock.length) {
                    groupName = $groupBlock.find('.lab-group-name').first().text().trim();
                } else {
                    var $subBlock = $cb.closest('.lab-subgroup-block');
                    if ($subBlock.length) groupName = $subBlock.find('.lab-subgroup-name').first().text().trim();
                }
                entries.push({ id: $cb.val(), name: name, price: price, groupName: groupName });
                if (price > 0) { total += price; conPrecio++; } else { sinPrecio++; }
            });

            /* Grupos completos */
            $('#list_group .test-price[name="aGroup[]"]:checked').each(function () {
                var $cb    = $(this);
                var price  = parseFloat($cb.data('price')) || 0;
                var $header = $cb.closest('.lab-group-header, .lab-subgroup-header');
                var name   = $header.find('.lab-group-name, .lab-subgroup-name').first().text().trim()
                             || 'Grupo #' + $cb.val();
                entries.push({ id: 'g_' + $cb.val(), name: name, price: price, groupName: 'Paquete' });
                if (price > 0) { total += price; conPrecio++; } else { sinPrecio++; }
            });

            var totalItems = entries.length;
            var totalFmt   = total > 0 ? total : '--';

            /* ---- Carrito desktop ---- */
            $('#labCartItems .lab-cart-item').remove();
            if (totalItems === 0) {
                $('#labCartEmpty').show();
            } else {
                $('#labCartEmpty').hide();
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
                            '<button type="button" class="lab-cart-remove"><i class="fas fa-times"></i></button>' +
                        '</div>'
                    );
                    $row.find('.lab-cart-remove').on('click', function () { labCartRemoveItem(e.id); });
                    $('#labCartItems').append($row);
                });
            }
            $('#labCartTotalAmount').text(totalFmt);
            $('#labCartConPrecioLabel').text('Análisis con precio (' + conPrecio + ')');
            $('#labCartConPrecioVal').text(conPrecio > 0 ? total + ' Bs.' : '—');
            $('#labCartSinPrecioLabel').text('Sin precio asignado (' + sinPrecio + ')');
            $('#labCartCountBadge').text(totalItems + ' análisis');
            $('#labCartSaveBtn').prop('disabled', totalItems === 0);

            /* ---- Carrito móvil ---- */
            $('#labCartMobileItems .mobile-cart-item').remove();
            $('#mobileCartCount').text(totalItems + ' análisis');
            $('#mobileCartTotal').text((total > 0 ? total : '--') + ' Bs.');
            $('#mobileCartSaveBtn').prop('disabled', totalItems === 0);
            $('#mobileCartConPrecioLabel').text('Análisis con precio (' + conPrecio + ')');
            $('#mobileCartConPrecioVal').text(conPrecio > 0 ? total + ' Bs.' : '—');
            $('#mobileCartSinPrecioLabel').text('Sin precio asignado (' + sinPrecio + ')');

            if (totalItems === 0) {
                $('#labCartMobileEmpty').show();
            } else {
                $('#labCartMobileEmpty').hide();
                entries.forEach(function (e) {
                    var priceHtml = e.price > 0
                        ? '<span class="mobile-cart-item-price">' + e.price + ' Bs.</span>'
                        : '<span class="mobile-cart-item-price sin-precio">—</span>';
                    var $row = $(
                        '<div class="mobile-cart-item" data-id="' + e.id + '">' +
                            '<div class="mobile-cart-item-info">' +
                                '<div class="mobile-cart-item-name" title="' + e.name + '">' + e.name + '</div>' +
                                '<div class="mobile-cart-item-group">' + e.groupName + '</div>' +
                            '</div>' +
                            priceHtml +
                            '<button type="button" class="mobile-cart-remove-btn"><i class="fas fa-times"></i></button>' +
                        '</div>'
                    );
                    $row.find('.mobile-cart-remove-btn').on('click', function () { labCartRemoveItem(e.id); });
                    $('#labCartMobileItems').append($row);
                });
            }
        };

        window.labCartRemoveItem = function (id) {
            var selector = String(id).indexOf('g_') === 0
                ? '#list_group input.test-price[name="aGroup[]"][value="' + id.replace('g_', '') + '"]'
                : '#list_group input.test-price[name="aTests[]"][value="' + id + '"]';
            var $cb = $(selector);
            if ($cb.length && $cb.is(':checked')) {
                $cb.prop('checked', false);
                if (String(id).indexOf('g_') !== 0) {
                    syncCheckboxes($cb[0]);
                } else {
                    reloadGroupChilds($cb[0]);
                }
                $cb.closest('.lab-test-card').removeClass('checked');
                updateTotalPriceTest();
            }
        };

        window.labCartClearAll = function () {
            $('#list_group input.test-price[name="aGroup[]"]:checked').each(function () {
                $(this).prop('checked', false);
                reloadGroupChilds(this);
            });
            $('#list_group input.test-price[name="aTests[]"]:checked').each(function () {
                $(this).prop('checked', false);
                syncCheckboxes(this);
                $(this).closest('.lab-test-card').removeClass('checked');
            });
            updateTotalPriceTest();
            labCartRefresh();
        };

        window.labCartSetPago = function (tipo, btn) {
            $('.lab-pago-btn').removeClass('active');
            $(btn).addClass('active');
            $('#formAnalisis input[name="tipo_pago_acuenta"]').each(function () {
                if ($(this).val() === tipo) $(this).prop('checked', true).trigger('change');
            });
        };

        $(document).on('change', '#formAnalisis input[name="tipo_pago_acuenta"]', function () {
            var val = $(this).val();
            $('.lab-pago-btn').each(function () {
                $(this).toggleClass('active', $(this).data('pago') === val);
            });
        });

        $('#formAnalisis').on('submit', function () {
            $('#labCartSaveBtn, #mobileCartSaveBtn').prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
            $('#btnSubmit').prop('disabled', true);
        });

        $(function () { labCartRefresh(); });

    })();
    </script>
@endpush