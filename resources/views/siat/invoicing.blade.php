@extends('layouts.dash', ['activePage' => 'analisis', 'title' => 'Siat', 'navName' => 'Siat', 'activeButton' => 'analisisActiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('analisis.index')}}">Analisis</a></li>
            <li class="breadcrumb-item">Facturador</li>

        </ol>
    </nav>
    <div class="card">
        <div class="card-body">
            <div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    En linea
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" data-id="7">(7) CORTE DE SUMINISTRO DE ENERGIA ELECTRICA</a>
                    <a class="dropdown-item" href="#" data-id="5">(5) VIRUS INFORMÁTICO O FALLA DE SOFTWARE</a>
                    <a class="dropdown-item" href="#" data-id="6">(6) CAMBIO DE INFRAESTRUCTURA DEL SISTEMA INFORMÁTICO DE FACTURACIÓN O FALLA DE HARDWARE</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-id="1">(1) CORTE DEL SERVICIO DE INTERNET</a>
                    <a class="dropdown-item" href="#" data-id="2">(2) INACCESIBILIDAD AL SERVICIO WEB DE LA ADMINISTRACIÓN TRIBUTARIA</a>
                    <a class="dropdown-item" href="#" data-id="3">(3) INGRESO A ZONAS SIN INTERNET POR DESPLIEGUE DE PUNTO DE VENTA EN VEHICULOS AUTOMOTORES</a>
                    <a class="dropdown-item" href="#" data-id="4">(4) VENTA EN LUGARES SIN <INTERNET></INTERNET></a>
                </div>
            </div>

            <button class="btn btn-danger">Fuera de linea</button>

            <form class="row gy-2 gx-3 align-items-center">
                <div class="col-auto">
                    <label>Cliente</label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="autoSizingInput" aria-describedby="btnGroupAddon2">
{{--                        <div class="form-control" disabled>Juan Pedro</div>--}}
                        <button class="btn btn-primary rounded-0 btn-sm" type="button"><i class="fas fa-search"></i></button>
                        <button class="btn btn-success rounded-0 btn-sm" type="button"><i class="fas fa-plus-square"></i></button>
                    </div>
                </div>
                <div class="col-auto">
                    <label>NIT/CI</label>
                    <input type="text" class="form-control form-control-sm" id="autoSizingInputGroup" placeholder="NIT/CI">
                </div>
                <div class="col-auto">
                    <label>Com</label>
                    <input type="text" class="form-control form-control-sm" id="autoSizingInputGroupCom">
                </div>
                <div class="col-auto">
                    <label class="visually-hidden" for="autoSizingSelect">Tipo de Documento de Identidad </label>
                    <select class="form-control form-control-sm" id="autoSizingSelect">
                        <option value="">-- tipo de documento --</option>
                        <option value="1">CI - CÉDULA DE IDENTIDAD</option>
                        <option value="2">CEX - CÉDULA DE IDENTIDAD DE EXTRANJERO</option>
                        <option value="5">NIT - NÚMERO DE IDENTIFICACIÓN TRIBUTARIA</option>
                        <option value="3">PAS - PASAPORTE</option>
                        <option value="4">OD - OTRO DOCUMENTO DE IDENTIDAD</option>
                    </select>
                </div>
            </form>
            <fieldset class="border p-1">
                <legend class="w-auto">Productos</legend>
                <div>
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item"><p class="mb-0">Producto 1 </p></li>
                        <li class="list-group-item"><p class="mb-0">Producto 2 </p></li>
                        <li class="list-group-item"><p class="mb-0">Producto 3 <a href="#"><i class="fas fa-plus-circle"></i></a></p></li>
                    </ul>
                </div>
            </fieldset>
            <br>
            <h4>Detalle</h4>
            <table class="table">
                <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Item</th>
                    <th>Cant.</th>
                    <th>Precio</th>
                    <th>Descuento</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Dcoc-0045</td>
                    <td>Producto 2d</td>
                    <td>
                        <input type="number" class="form-control">
                    </td>
                    <td>
                        <input type="number" class="form-control">
                    </td>
                    <td>
                        <input type="number" class="form-control">
                    </td>
                    <td>
                        <div class="form-control" disabled>
                            78.55
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Dcoc-0045</td>
                    <td>Producto 2d</td>
                    <td>
                        <input type="number" class="form-control">
                    </td>
                    <td>
                        <input type="number" class="form-control">
                    </td>
                    <td>
                        <input type="number" class="form-control">
                    </td>
                    <td>
                        <div class="form-control" disabled>
                            78.55
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <hr>
            <div>
                <div class="form-group mb-0 row justify-content-end">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Subtotal:</label>
                    <div class="col-sm-2 text-right">
                        88
                    </div>
                </div>
                <div class="form-group row mb-0 justify-content-end">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Descuento:</label>
                    <div class="col-sm-2">
                        <input type="email" class="form-control" id="inputEmail3">
                    </div>
                </div>
                <div class="form-group row mb-0 justify-content-end">
                    <label class="col-sm-2 col-form-label">Total Base Credito Fiscal:</label>
                    <div class="col-sm-2 text-right">
                        8800
                    </div>
                </div>
                <div class="form-group row mb-0 justify-content-end">
                    <label class="col-sm-2 col-form-label">Crédito fiscal:</label>
                    <div class="col-sm-2 text-right">
                        55
                    </div>
                </div>
                <div class="form-group row mb-0 justify-content-end">
                    <label class="col-sm-2 col-form-label">Metodo de pago:</label>
                    <div class="col-sm-2 text-right">
                        EFECTIVO
                    </div>
                </div>
            </div>
            <button class="btn btn-primary">Generar Factura</button>
        </div>
    </div>
@endsection

@push('js')
    <script>

    </script>
@endpush

