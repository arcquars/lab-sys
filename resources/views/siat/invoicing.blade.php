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

            <form onsubmit="sendInvoice(this); return false;">
                @csrf
                <div class="row">
                    <div class="col-auto">
                        <label>Cliente</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="razon_social"
                                   value="{{$analisis->razon_social}}">
                            <button class="btn btn-primary rounded-0 btn-sm" type="button"><i class="fas fa-search"></i></button>
                            <button class="btn btn-success rounded-0 btn-sm" type="button"><i class="fas fa-plus-square"></i></button>
                        </div>
                    </div>
                    <div class="col-auto">
                        <label>NIT/CI</label>
                        <input type="text" class="form-control form-control-sm" placeholder="NIT/CI"
                               name="nit" value="{{$analisis->nit}}">
                    </div>
                    <div class="col-auto">
                        <label>Com</label>
                        <input type="text" name="complemento" class="form-control form-control-sm">
                    </div>
                    <div class="col-auto">
                        <label class="visually-hidden" for="tipoDocumentoSelect">Tipo de Documento de Identidad </label>
                        <select class="form-control form-control-sm" id="tipoDocumentoSelect" name="tipo_documento" >
                            <option value="">-- tipo de documento --</option>
                            <option value="1">CI - CÉDULA DE IDENTIDAD</option>
                            <option value="2">CEX - CÉDULA DE IDENTIDAD DE EXTRANJERO</option>
                            <option value="5" selected>NIT - NÚMERO DE IDENTIFICACIÓN TRIBUTARIA</option>
                            <option value="3">PAS - PASAPORTE</option>
                            <option value="4">OD - OTRO DOCUMENTO DE IDENTIDAD</option>
                        </select>
                    </div>
                </div>


            <fieldset class="border p-1 border-info rounded pb-3">
                <legend class="w-auto text-info">Productos</legend>
                <div>
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item">
                            <p class="mb-0">
                                <a href="#" onclick="productAdd('DELIVERY');"><i class="far fa-plus-square"></i></a> Delivery
                            </p>
                        </li>
                        <li class="list-group-item">
                            <p class="mb-0">
                                <a href="#" onclick="productAdd('REACTIVO');"><i class="far fa-plus-square"></i></a> Reactivo
                            </p>
                        </li>
                    </ul>
                </div>
            </fieldset>
            <br>
            <h4>Detalle</h4>
            <table id="t_products" class="table table-sm">
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
                    <td>
                        hem-0045
                        <input type="hidden" name="items[0][code]">
                    </td>
                    <td>Servicios de laboratorio</td>
                    <td>
                        <input name="items[0][amount]" type="number" class="form-control form-control-sm" value="1" onchange="calculateTotals();">
                    </td>
                    <td>
                        <input name="items[0][price]" type="number" value="{{$analisis->precio}}" class="form-control form-control-sm" onchange="calculateTotals();">
                    </td>
                    <td>
                        <input name="items[0][discount]" type="number" class="form-control form-control-sm" onchange="calculateTotals();">
                    </td>
                    <td>
                        <div class="form-control form-control-sm text-right" disabled>
                            {{$analisis->precio}}
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <hr>
            <div>
                <div class="form-group mb-0 row justify-content-end">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Subtotal:</label>
                    <div id="i_subtotal" class="col-sm-2 text-right">
                        88
                    </div>
                </div>
                <div class="form-group row mb-0 justify-content-end">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Descuento:</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control form-control-sm" id="i_discount" step="0.1" onchange="calculateTotals();">
                    </div>
                </div>
                <div class="form-group row mb-0 justify-content-end">
                    <label class="col-sm-2 col-form-label">Total Base Credito Fiscal:</label>
                    <div id="i_total_base" class="col-sm-2 text-right">
                    </div>
                </div>
                <div class="form-group row mb-0 justify-content-end">
                    <label class="col-sm-2 col-form-label">Crédito fiscal:</label>
                    <div id="i_total" class="col-sm-2 text-right">
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
            </form>
        </div>
    </div>

    <script type="text/template" id="underscore_template">
        <tr>
            <td>
                <a href="#" class="text-danger" onclick="removeProductTable(this);"><i class="far fa-minus-square"></i></a> <%= code %>
                <input type="hidden" name="items[<%=index%>][code]" value="<%= code %>">
            </td>
            <td><%= name %></td>
            <td>
                <input name="items[<%=index%>][amount]" type="number" class="form-control form-control-sm" value="<%= amount %>" onchange="calculateTotals();">
            </td>
            <td>
                <input name="items[<%=index%>][price]" type="number" class="form-control form-control-sm" value="<%= price %>" onchange="calculateTotals();">
            </td>
            <td>
                <input name="items[<%=index%>][discount]" type="number" class="form-control form-control-sm" value="<%= discount %>" onchange="calculateTotals();">
            </td>
            <td>
                <div class="form-control form-control-sm text-right" disabled>
                    <%= total %>
                </div>
            </td>
        </tr>
    </script>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            calculateTotals();
        });

    function productAdd(product) {
        const templateString = $("#underscore_template").html();
        const index = $("#t_products tbody tr").length;
        let data = {"code": "pod-25","name": "REACTIVO", "amount": 1, "price": 34.5, "discount": 0, "total": 34.5, "index": index};
        if(product === 'DELIVERY')
            data = {"code": "pod-26","name": product, "amount": 1, "price": 34.5, "discount": 0, "total": 34.5, "index": index};

        const templateFunction = _.template(templateString);
        $("#t_products tbody").append(templateFunction(data));
        calculateTotals();
        return false;
    }

    function removeProductTable(link){
        $(link).parent().parent().remove();
        calculateTotals();
        return false;
    }

    function calculateTotals() {
        let trs = $("#t_products tbody tr");
        let subtotal = 0;
        $.each(trs, function($i, tr){
            const tds = $(tr).children();
            const p_amount = ($(tds[2]).find('input').val().trim() === '')? 0 : parseFloat($(tds[2]).find('input').val());
            const p_price = ($(tds[3]).find('input').val().trim() === '')? 0 : parseFloat($(tds[3]).find('input').val());
            const p_discount = ($(tds[4]).find('input').val().trim() === '')? 0 : parseFloat($(tds[4]).find('input').val());
            const p_total = (p_amount*p_price) - p_discount;
            $(tds[5]).children().empty().text(p_total);
            subtotal += p_total;
        });
        let idiscount = $("#i_discount").val()? parseFloat($("#i_discount").val()): 0;
        let total = (subtotal-idiscount)*13/100;
        total = total.toFixed(2);
        $("#i_subtotal").empty().text(subtotal);
        $("#i_total_base").empty().text(subtotal-idiscount);
        $("#i_total").empty().text(total);
        // alert(idiscount);
    }

    function sendInvoice(form){
        console.log($(form).serialize());
        $.ajax({
            url: "{{ route('siat.a_send_invoice') }}",
            type: 'POST',
            data: $(form).serialize(),
            success: function (data) {
                alert("ccc ooo");
            },
        });
    }
    </script>
@endpush

